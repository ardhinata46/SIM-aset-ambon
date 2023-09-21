@extends ('auth.layout')
@section ('auth')
@include('sweetalert::alert')
<div class="form-container sign-up-container">
    <form action="{{route('auth.forgot')}}" method="POST">
        @csrf
        <h3>Reset Password</h3>
        <br><br>
        <span>Masukan Email yang sudah terdaftar!</span>
        <input type="email" name="email" placeholder="Password" />
        <br>
        <button type="submit">Reset Password</button>
    </form>
</div>
<div class="form-container sign-in-container">
    <form method="POST" action="{{ route('auth.verify') }}">
        @csrf
        <h2 class="mb-4">Login</h2><br><br>
        <span class="mb-6">Masukan Email & Password</span>
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <br>
        <button type="submit">Login</button>
    </form>
</div>
<div class="overlay-container">
    <div class="overlay">
        <div class="overlay-panel overlay-left">
            <h3>Kembali ke Login</h3>
            <p>Klik login untuk kembali ke form Login</p>
            <button class="ghost" id="signIn">Login</button>
        </div>
        <div class="overlay-panel overlay-right">
            <h3>Lupa Sandi?</h3>
            <p>Klik Lupa Sandi untuk melakukan reset password</p>
            <button class="ghost" id="signUp">Lupa Sandi</button>
        </div>
    </div>
</div>
@endsection