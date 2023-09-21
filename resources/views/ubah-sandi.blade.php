@extends ('auth.layout')
@section ('auth')
@include('sweetalert::alert')

<div class="form-container sign-in-container">
    <form method="POST" action="{{ route('auth.renew') }}">
        @csrf
        <h2 class="mb-4">Ubah Kata Sandi</h2><br>
        <span class="mb-6">Masukan Password Baru</span>

        <input type="password" name="password" placeholder="password" required autofocus />
        <span class="text-danger">@error('password'){{ $message }}@enderror</span>

        <input type="password" name="new_password" placeholder="Ulangi Password" required />
        <span class="text-danger">@error('new_password'){{ $message }}@enderror</span>

        <br>
        <button type="submit">Simpan</button>
    </form>
</div>
<div class="overlay-container">
    <div class="overlay">
        <div class="overlay-panel overlay-right">
            <h3>Login Kembali?</h3>
            <p>Klik Login untuk menampilkan form Login</p>
            <a href="{{ route('auth.index') }}"> <button class="ghost">Login</button></a>

        </div>
    </div>
</div>
@endsection