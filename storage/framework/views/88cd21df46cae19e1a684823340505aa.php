<?php $__env->startSection('title', 'Login - TripWay'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.login-page {
        min-height: calc(100vh - 64px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        padding: 40px 20px;
        position: relative;
        overflow: hidden;
    }
.login-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920&auto=format&fit=crop') center/cover;
        opacity: 0.05;
    }
    .login-card {
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
    .login-header {
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
    .login-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 6px;
    }
    .login-header p {
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
    .input-wrapper input:focus + i,
    .input-wrapper:focus-within i {
        color: var(--primary);
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
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        font-size: 13px;
    }
    .remember-check {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: var(--text-medium);
    }
    .remember-check input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--primary);
        cursor: pointer;
    }
    .forgot-link {
        color: var(--primary);
        font-weight: 600;
        transition: opacity 0.2s;
    }
    .forgot-link:hover {
        opacity: 0.8;
        text-decoration: underline;
    }
    .btn-login {
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
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(48,82,92,0.4);
    }
    .btn-login:active {
        transform: translateY(0);
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
    .login-footer {
        text-align: center;
        font-size: 14px;
        color: var(--text-light);
    }
    .login-footer a {
        color: var(--primary);
        font-weight: 600;
        transition: opacity 0.2s;
    }
    .login-footer a:hover {
        opacity: 0.8;
        text-decoration: underline;
    }
    .back-home {
        position: absolute;
        top: 24px;
        left: 24px;
        z-index: 3;
        color: white;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        opacity: 0.9;
        transition: opacity 0.2s;
    }
    .back-home:hover {
        opacity: 1;
    }
    @media (max-width: 480px) {
        .login-card {
            padding: 36px 24px;
            border-radius: 16px;
        }
        .login-header h1 {
            font-size: 20px;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="login-page">
        <a href="<?php echo e(url('/')); ?>" class="back-home">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>

        <div class="login-card">
            <div class="login-header">
                <div class="logo-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <h1>Selamat Datang Kembali</h1>
                <p>Masuk ke akun TripWay Anda</p>
            </div>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <input id="email" type="email" class="<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" placeholder="nama@email.com" required autocomplete="email" autofocus>
                        <i class="fas fa-envelope"></i>
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <input id="password" type="password" class="<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" placeholder="••••••••" required autocomplete="current-password">
                        <i class="fas fa-lock"></i>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-options">
                    <label class="remember-check">
                        <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                        <span>Ingat saya</span>
                    </label>
                    <?php if(Route::has('password.request')): ?>
                        <a class="forgot-link" href="<?php echo e(route('password.request')); ?>">
                            Lupa password?
                        </a>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i> Masuk
                </button>
            </form>

            <div class="login-divider">
                <span>atau</span>
            </div>

            <a href="<?php echo e(route('auth.google')); ?>" style="display:flex; align-items:center; justify-content:center; gap:10px; width:100%; padding:12px; border:2px solid #e8e8e8; border-radius:12px; font-size:14px; font-weight:600; color:#444; text-decoration:none; transition:all 0.2s; background:white;" onmouseover="this.style.borderColor='#4285f4'; this.style.background='#f8f9ff'" onmouseout="this.style.borderColor='#e8e8e8'; this.style.background='white'">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" style="width:20px; height:20px;">
                Masuk dengan Google
            </a>

            <div class="login-divider" style="margin-top:28px;"></div>

            <div class="login-footer">
                Belum punya akun? <a href="<?php echo e(route('register')); ?>">Daftar sekarang</a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tripway', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\tripway\tripway\resources\views/auth/login.blade.php ENDPATH**/ ?>