<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;


class PenggunaController extends Controller
{
    public function index()
    {
        $title = 'Data Pengguna';
        $pengguna = Pengguna::orderBy('status', 'desc')
            ->get();

        return view('sa.content.pengguna.list', compact('title', 'pengguna'));
    }

    public function add()
    {
        $title = 'Tambah Pengguna';

        return view('sa.content.pengguna.add', compact('title'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'role' => 'required',
            'nama_pengguna' => 'required',
            'jk' => 'required',
            'email' => 'required|email|unique:penggunas,email',
            'kontak' => ['required', 'regex:/^(\+62|0)[0-9]{9,}$/'],
            'alamat' => 'required',
            'foto' => 'nullable|image|max:2048',
        ], [
            'role.required' => 'Role harus dipilih',
            'nama_pengguna.required' => 'Nama pengguna harus diisi.',
            'jk.required' => 'Jenis kelamin harus dipilih.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar',
            'kontak.required' => 'Nomor telepon harus diisi.',
            'kontak.regex' => 'Format nomor telepon salah.',
            'alamat.required' => 'Alamat harus diisi.',
        ]);

        $pengguna = new Pengguna();
        $pengguna->role = $request->role;
        $pengguna->nama_pengguna = $request->nama_pengguna;
        $pengguna->jk = $request->jk;
        $pengguna->email = $request->email;
        $pengguna->kontak = $request->kontak;
        $pengguna->alamat = $request->alamat;

        // Upload file foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = public_path('foto_pengguna');

            if (!File::exists($fotoPath)) {
                File::makeDirectory($fotoPath, 0777, true, true);
            }

            $fotoName = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move($fotoPath, $fotoName);
            $pengguna->foto = 'foto_pengguna/' . $fotoName;
        } else {
            // Set foto default jika tidak ada foto yang diunggah
            $pengguna->foto = 'foto_pengguna/image.jpg';
        }


        try {
            $pengguna->save();
            return redirect(route('superadmin.pengguna.index'))->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.pengguna.index'))->with('error', 'Pengguna gagal ditambahkan!');
        }
    }


    public function detail($id_pengguna)
    {
        $title = 'Detail Pengguna';
        $pengguna = Pengguna::select(
            'penggunas.id_pengguna',
            'penggunas.nama_pengguna',
            'penggunas.role',
            'penggunas.jk',
            'penggunas.email',
            'penggunas.password',
            'penggunas.alamat',
            'penggunas.kontak',
            'penggunas.status',
            'penggunas.foto',
        )
            ->findOrFail($id_pengguna);

        return view('sa.content.pengguna.detail', compact('pengguna', 'title'));
    }

    public function edit($id_pengguna)
    {
        $title = 'Ubah Pengguna';
        $pengguna = Pengguna::select(
            'penggunas.id_pengguna',
            'penggunas.nama_pengguna',
            'penggunas.role',
            'penggunas.jk',
            'penggunas.email',
            'penggunas.password',
            'penggunas.alamat',
            'penggunas.kontak',
            'penggunas.status',
            'penggunas.foto',
        )
            ->findOrFail($id_pengguna);

        return view('sa.content.pengguna.edit', compact('title', 'pengguna'));
    }

    public function update(Request $request, $id_pengguna)
    {
        $request->validate([
            'role' => 'required',
            'nama_pengguna' => 'required',
            'jk' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('penggunas')->ignore($id_pengguna, 'id_pengguna')
            ],
            'kontak' => ['required', 'regex:/^(\+62|0)[0-9]{9,}$/'],
            'alamat' => 'required',
            'status' => 'required',
            'foto' => 'nullable|image|max:2048',
        ], [
            'role.required' => 'Role harus dipilih.',
            'nama_pengguna.required' => 'Nama pengguna harus diisi.',
            'jk.required' => 'Jenis kelamin harus dipilih.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'kontak.required' => 'Nomor telepon harus diisi.',
            'kontak.regex' => 'Format nomor telepon salah.',
            'alamat.required' => 'Alamat harus diisi.',
            'status.required' => 'Status harus diisi.',
        ]);


        $pengguna = Pengguna::find($id_pengguna);

        $pengguna->role = $request->role;
        $pengguna->nama_pengguna = $request->nama_pengguna;
        $pengguna->jk = $request->jk;
        $pengguna->email = $request->email;
        $pengguna->kontak = $request->kontak;
        $pengguna->alamat = $request->alamat;
        $pengguna->status = $request->status;



        // Cek apakah ada file foto yang diunggah
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = public_path('foto_pengguna');

            if (!File::exists($fotoPath)) {
                File::makeDirectory($fotoPath, 0777, true, true);
            }

            $fotoName = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move($fotoPath, $fotoName);
            $pengguna->foto = 'foto_pengguna/' . $fotoName;
        } // Jika tidak ada file foto yang diunggah, biarkan foto tetap menggunakan foto yang sebelumnya

        try {
            $pengguna->save();
            return redirect(route('superadmin.pengguna.index'))->with('success', 'Pengguna berhasil diubah!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.pengguna.index'))->with('error', 'Pengguna gagal diubah!');
        }
    }

    public function delete($id_pengguna)
    {
        $pengguna = Pengguna::findOrFail($id_pengguna);
        try {
            $pengguna->delete();
            return redirect(route('superadmin.pengguna.index'))->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect(route('superadmin.pengguna.index'))->with('error', 'Pengguna gagal dihapus!');
        }
    }
}
