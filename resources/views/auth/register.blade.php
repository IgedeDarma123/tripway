@extends('layouts.tripway')

@section('title', 'Daftar - TripWay')

@section('styles')
<style>
.register-page {
    min-height: calc(100vh - 64px);
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    padding: 40px 20px;
    position: relative;
    overflow: hidden;
}
.register-page::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920&auto=format&fit=crop') center/cover;
    opacity: 0.05;
}
.register-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    width: 100%;
    max-width: 440px;
    padding: 48px 40px;
    position: relative;
    z-index: 2;
    animation: slideUp 0.6s ease-out;
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.register-header {
    text-align: center;
    margin-bottom: 32px;
}
.logo-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #30525c 0%, #4a707f 100%);
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
    margin-bottom: 16px;
    box-shadow: 0 8px 20px rgba(48,82,92,0.3);
}
.register-header h1 {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 6px;
}
.register-header p {
    font-size: 14px;
    color: var(--text-light);
}
.form-group {
    margin-bottom: 20px;
}
.form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
}
.input-wrapper {
    position: relative;
}
.input-wrapper i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
    font-size: 15px;
    transition: color 0.2s;
}
.input-wrapper input {
    width: 100%;
    padding: 12px 14px 12px 42px;
    border: 2px solid #e8e8e8;
    border-radius: 12px;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    transition: all 0.2s;
    background: #fafafa;
}
.input-wrapper input:focus {
    border-color: var(--primary);
    background: white;
    box-shadow: 0 0 0 4px rgba(48,82,92,0.1);
}
.input-wrapper input.is-invalid {
    border-color: #dc3545;
    background: #fff5f5;
}
.invalid-feedback {
    display: block;
    font-size: 12px;
    color: #dc3545;
    margin-top: 6px;
}
.btn-register {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #30525c 0%, #4a707f 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 8px 20px rgba(48,82,92,0.3);
    font-family: inherit;
}
.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(48,82,92,0.4);
}
.login-divider {
    display: flex;
    align-items: center;
    gap: 16px;
    margin: 28px 0;
    color: #aaa;
    font-size: 13px;
}
.login-divider::before,
.login-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e8e8e8;
}
.register-footer {
    text-align: center;
    font-size: 14px;
    color: var(--text-light);
}
.register-footer a {
    color: var(--primary);
    font-weight: 600;
    transition: opacity 0.2s;
}
.register-footer a:hover {
    opacity: 0.8;
    text-decoration: underline;
}
</style>
@endsection

@section('content')
<div class="register-page">
    <div class="register-card">
        <div class="register-header">
            <div class="logo-icon">
                <i class="fas fa-paper-plane"></i>
            </div>
            <h1>Buat Akun Baru</h1>
            <p>Daftar dan mulai petualangan Anda</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <div class="input-wrapper">
                    <input id="name" type="text" class="@error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda"
                        required autocomplete="name" autofocus>
                    <i class="fas fa-user"></i>
                </div>
                @error('name')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <div class="input-wrapper">
                    <input id="email" type="email" class="@error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                        required autocomplete="email">
                    <i class="fas fa-envelope"></i>
                </div>
                @error('email')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <div class="input-wrapper">
                    <input id="password" type="password" class="@error('password') is-invalid @enderror"
                        name="password" placeholder="Min. 8 karakter"
                        required autocomplete="new-password">
                    <i class="fas fa-lock"></i>
                </div>
                @error('password')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">Konfirmasi Kata Sandi</label>
                <div class="input-wrapper">
                    <input id="password-confirm" type="password"
                        name="password_confirmation" placeholder="Ulangi kata sandi"
                        required autocomplete="new-password">
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Daftar Sekarang
            </button>
        </form>

        <div class="login-divider"><span>atau</span></div>

        <a href="{{ route('auth.google') }}" style="display:flex; align-items:center; justify-content:center; gap:10px; width:100%; padding:12px; border:2px solid #e8e8e8; border-radius:12px; font-size:14px; font-weight:600; color:#444; text-decoration:none; transition:all 0.2s; background:white;" onmouseover="this.style.borderColor='#4285f4'; this.style.background='#f8f9ff'" onmouseout="this.style.borderColor='#e8e8e8'; this.style.background='white'">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" style="width:20px; height:20px;">
            Daftar dengan Google
        </a>

        <div class="login-divider" style="margin-top:28px;"></div>

        <div class="register-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a>
        </div>
    </div>
</div>
@endsection
