<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\UbahKataSandi;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Mail;
use App\Util\Helper;

class AuthController extends Controller
{
    public function index()
    {
        $title = 'Login Pengurus';
        return view('login', compact('title'));
    }

    public function verify(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin', 'status' => 1])) {
            return redirect()->intended('/admin/dashboard');
        } else if (Auth::guard('superadmin')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'superadmin', 'status' => 1])) {
            return redirect()->intended('/superadmin/dashboard');
        } else {
            //user tidak ditemukan
            return redirect('login')->with('error', 'Email dan password salah !');
        }
    }

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('superadmin')->check()) {
            Auth::guard('superadmin')->logout();
        }
        return redirect('login');
    }


    public function reset()
    {
        $title = 'Lupa Sandi';

        return view('lupasandi', compact('title'));
    }



    public function forgot(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->validate($request, [
            'email' => 'email:rfc,dns',
        ]);

        if (Pengguna::where('email', $request->email)->exists()) {
            $pengguna = Pengguna::where('email', $request->email)->first();
            $token = $this->generateToken(24);


            $pengguna->remember_token = $token;

            try {
                $pengguna->save();

                $email = Helper::encrypt($request->email);

                $reset_token = $pengguna->remember_token;

                $link = route('auth.password', [$email, $reset_token]);

                Mail::to($request->email)->send(new UbahKataSandi($pengguna->nama_pengguna, $link));

                return redirect(route('auth.index'))->with('success', 'Request berhasil. Periksa email Anda untuk melakukan perubahan kata sandi');
            } catch (\Exception $e) {
                return redirect(route('auth.index'))->with('error', 'Request gagal');
            }
        } else {
            return redirect(route('auth.index'))->with('error', 'Email Belum Terdaftar');
        }
    }

    public function password($emailHash, $token)
    {

        date_default_timezone_set('Asia/Jakarta');

        $title = 'Ubah Sandi';
        $email = Helper::decrypt($emailHash);
        $pengguna = Pengguna::where('email', $email)->first();


        if ($pengguna->remember_token == $token) {

            return view('ubah-sandi', compact('emailHash', 'title'));
        } else {
            return redirect(route('auth.reset'))->with('error', 'Token tidak valid');
        }
    }

    public function renew(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6',
            'new_password' => 'required|same:password',
            'remember_token' => 'required'
        ], [
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal harus 6 karakter',
            'new_password.required' => 'Konfirmasi password harus diisi',
            'new_password.same' => 'Konfirmasi password berbeda dengan password baru',
        ]);

        $email = Helper::decrypt($request->remember_token);
        $pengguna = Pengguna::where('email', $email)->first();

        if (!$pengguna) {
            return redirect(route('auth.renew'))->with('error', 'Pengguna tidak ditemukan.');
        }

        $pengguna->password = bcrypt($request->password);

        try {
            $pengguna->save();
            return redirect(route('auth.index'))->with('success', 'Kata Sandi Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect(route('auth.reset'))->with('error', 'Kata Sandi Gagal Diubah.');
        }
    }


    private function generateToken($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
