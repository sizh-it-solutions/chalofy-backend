<?php $__env->startSection('styles'); ?>

<style>
    . __login-badge {
        position: absolute;
        inset-inline-end: 25px;
        top: 25px;
    }

    .badge-soft-success {
        color: #00c9a7;
        background-color: rgba(0, 201, 167, 0.1);
        border: 1px solid rgba(0, 201, 167, 0.6);
    }

    .badge {
        text-transform: capitalize;
    }

    .badge {
        white-space: normal;
    }

    .badge {
        padding: .4em .5em;
        line-height: 14px;
        font-size: .74rem;
    }

    .copy-container {

        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 10px;
        position: relative;
    }

    .copy-container span {
        flex: 1;
    }

    .copy-container button {
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        top: 50%;
        transform: translateY(-50%);
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<section class="login">
    <div class="login_box">
        <div class="left">
            <label class="badge badge-soft-success __login-badge" style="display: none;">
                Software version : 1.2
            </label>
            <div class="contact">
                <div class="login-box">
                <?php if($error = session()->pull('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo e($error); ?>

                    </div>
                <?php endif; ?>
                    <div class="login-logo">
                        <a href="<?php echo e(route('admin.home')); ?>">
                            Admin Signin
                            <br>
                        </a>
                        <p style="font-size: medium;">Welcome back login to your panel.</p>
                    </div>
                    <div class="login-box-body">
                        <?php if(session('message')): ?>
                        <p class="alert alert-info">
                            <?php echo e(session('message')); ?>

                        </p>
                        <?php endif; ?>

                        <div id="loader" style="display: none;">
                            <div class="spinner"></div>
                        </div>
                        <form method="POST" name="loginform" id="loginform" action="<?php echo e(route('login')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?> has-feedback">
                                <input id="email" type="email" name="email" class="email form-control" required
                                    autocomplete="email" autofocus placeholder="<?php echo e(trans('global.login_email')); ?>"
                                    value="<?php echo e(old('email', null)); ?>">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                <span class="credentail"></span>
                                <span class="email"></span>
                                <?php if($errors->has('email')): ?>
                                <p class="help-block">
                                    <?php echo e($errors->first('email')); ?>

                                </p>
                                <?php endif; ?>
                            </div>
                            <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?> has-feedback">
                                <input id="password" type="password" name="password" class="password form-control" required placeholder="<?php echo e(trans('global.login_password')); ?>">
                                <span class="input-group-text toggle-password" onclick="togglePassword()">
                                    <i id="eye-icon" class="fas fa-eye-slash"></i>
                                </span>
                                <?php if($errors->has('password')): ?>
                                <p class="help-block">
                                    <?php echo e($errors->first('password')); ?>

                                </p>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="checkbox icheck">
                                        <label><input type="checkbox" name="remember"> <?php echo e(trans('global.remember_me')); ?></label>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <a href="<?php echo e(route('password.request')); ?>" class="btn btn-link">
                                        <?php echo e(trans('global.forgot_password')); ?>

                                    </a>
                                </div>
                            </div>
                            <div class="form-group<?php echo e($errors->has('g-recaptcha-response') ? ' has-error' : ''); ?> has-feedback">
                                <?php if($general_captcha=='yes'): ?>
                                <div class="g-recaptcha" data-sitekey="<?php echo e($site_key); ?>">
                                </div>
                                <p class="captchamsg"></p>

                                <?php if($errors->has('g-recaptcha-response')): ?>
                                <p class="help-block">
                                    <?php echo e($errors->first('g-recaptcha-response')); ?>

                                </p>
                                <?php endif; ?>

                                <?php endif; ?>
                                <button type="submit" class="btn btn-primary btn-block btn-flat">
                                    <?php echo e(trans('global.login')); ?>

                                </button>
                                <br>
                                    <br>
                                    <div class="row">
                                    <?php echo $__env->make('admin.demo.demo-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right">
        <div class="right-text">
            <?php if($logoUrl && file_exists(public_path($logoUrl))): ?>
            <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($siteName ?? trans('global.site_title')); ?>" />

            <?php else: ?>
            <b><?php echo e(trans('global.site_title')); ?></b>
            <?php endif; ?>
            <!-- <img src="<?php echo e($logoUrl); ?>" /> -->

            <h5><?php echo e($tagLine); ?></h5>
        </div>

    </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.addSteps.footer.footerJs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->startSection('scripts'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    function togglePassword() {
        var passwordField = document.getElementById('password');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    }

    $(document).ready(function() {
        $('.copy_cred').click(function(e) {
            e.preventDefault();
            $('#email').val('admin@sizhitsolutions.com');
            $('#password').val('Admin@1234');


            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.success('Email and password copied!');

        });
    });
</script>
<?php if($general_captcha=='yes'): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>
<script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#loginform').submit(function(event) {
            event.preventDefault();

            $('.email, .password, .captchamsg, .credentail').text('');
            $('.email, .password, .captchamsg').removeClass('error');


            var email = $('#email').val();
            var password = $('#password').val();

            if (!email) {
                $('.email').text('The email field is required');
                $('.email').addClass('error');
                return false;
            }
            if (!password) {
                $('.password').text('Please fill the password.');
                $('.password').addClass('error');
                return false;
            }
            <?php if($general_captcha == 'yes'): ?>
            var recaptchaResponse = grecaptcha.getResponse();
            if (!recaptchaResponse) {
                $('.captchamsg').text('Please fill the reCAPTCHA.');
                $('.captchamsg').addClass('error');
                return false;
            }
            <?php endif; ?>
            $('#loader').show();

            if (email != '' && password != '') {
                $.ajax({
                    type: 'POST',
                    url: '/login',
                    data: $('#loginform').serialize(),
                    success: function(data) {
                        $('#loader').hide();
                        window.location.href = '/admin';
                    },
                    error: function(xhr, status, error) {

                        var response = xhr.responseJSON;

                        if (response && response.errors && response.errors.email) {

                            $('.credentail').text(response.errors.email[0]);
                            $('.credentail').addClass('error');
                            $('#loader').hide();
                        } else {

                            console.error(response);
                            $('#loader').hide();
                        }
                    }
                });
            }
        });
    });
</script>
<style>
    .login-page .right {
        background:linear-gradient(212.38deg,
            rgba(255, 56, 92, 0.7) 0%,
            rgba(252, 29, 69, 0.71) 100%),
        url(<?php echo e($loginBackgroud); ?>);
        background-size: cover;

        color: #fff;
        position: relative;
    }
</style>
<script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var eyeIcon = document.getElementById("eye-icon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\chalofytaxi\resources\views/auth/login.blade.php ENDPATH**/ ?>