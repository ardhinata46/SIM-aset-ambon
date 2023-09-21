<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfilController extends Controller
{

    public function index()
    {
        $title = 'Profil Gereja';
        $profil = Profil::first();

        return view('sa.content.profil.index', compact('title', 'profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|max:2048',
        ], [
            'logo.image' => 'Logo harus berupa file gambar.',
            'logo.max' => 'Ukuran logo tidak boleh melebihi 2MB.',
        ]);

        $profil = Profil::first();
        $profil->nama_aplikasi = $request->nama_aplikasi;
        $profil->nama_organisasi = ucwords($request->nama_organisasi);
        $profil->alamat = $request->alamat;
        $profil->updated_by = Auth::guard('superadmin')->user()->id_pengguna;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = public_path('logo');

            if (!File::exists($logoPath)) {
                File::makeDirectory($logoPath, 0777, true, true);
            }

            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move($logoPath, $logoName);
            $profil->logo = 'logo/' . $logoName;
        }


        try {
            $profil->save();
            return redirect(route('superadmin.profil.index'))->with(['success' => 'Data berhasil diubah']);
        } catch (\Exception $e) {
            return redirect(route('superadmin.profil.index'))->with(['warning' => 'Data gagal diubah. Pastikan semua inputan sudah diisi dengan benar!']);
        }
    }
}
