<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <meta property="og:image" content="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png">
    <link rel="icon" href="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png">
    <title>Authorization</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>temp/default/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/temp/default/js/multiple/jquery-3.2.1.min.js" type="text/javascript">
    </script>

    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        background: #f3f5f7;
        color: #203040;
        min-height: 100vh;
    }

    /* ===== Page layout ===== */
    .auth-page {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .auth-shell {
        flex: 1;
        display: flex;
        min-height: calc(100vh - 64px);
    }

    /* Left: form area */
    .auth-left {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 22px 18px 30px;
    }

    .auth-card {
        width: 100%;
        max-width: 520px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        padding: 20px 20px 22px;
    }

    .auth-logo {
        width: 82px;
        height: 82px;
        object-fit: contain;
        display: block;
        margin: 0 auto 10px;
    }

    .auth-title {
        text-align: center;
        font-size: 22px;
        font-weight: 800;
        color: #154272;
        margin-bottom: 10px;
    }

    .auth-subtitle {
        text-align: center;
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 14px;
    }

    /* Right: image area (1/2 screen on large) */
    .auth-right {
        width: 50%;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        min-height: 100vh;
        position: relative;
    }

    .auth-right::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(243, 245, 247, 0.00) 0%, rgba(21, 66, 114, 0.10) 100%);
        pointer-events: none;
    }

    /* Hide image from tablet down */
    @media (max-width: 991.98px) {
        .auth-right {
            display: none;
        }

        .auth-left {
            padding: 18px 14px 26px;
        }

        .auth-shell {
            min-height: calc(100vh - 56px);
        }
    }

    /* ===== Form blocks ===== */
    .section-label {
        font-size: 14px;
        color: #374151;
        margin: 8px 0 10px;
        font-weight: 600;
    }

    .role-row {
        display: flex;
        gap: 18px;
        align-items: center;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .role-option {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #1f2937;
        font-weight: 600;
        font-size: 14px;
    }

    .field {
        margin-top: 10px;
        /* bỏ position:relative vì label không còn absolute */
    }

    .field label {
        position: static;
        /* quan trọng */
        transform: none;
        /* quan trọng */
        display: block;
        margin: 0 0 6px;
        padding: 0;
        background: transparent;
        pointer-events: auto;
        /* label click được */
        font-size: 14px;
        font-weight: 600;
        color: #374151;
    }

    .field input,
    .field select,
    .field textarea {
        width: 100%;
        height: 48px;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, .14);
        outline: none;
        font-size: 15px;
        color: #22324a;
        background: #fff;
        transition: all .15s ease;
    }

    .field textarea {
        height: auto;
        min-height: 110px;
        padding: 12px 14px;
        resize: vertical;
    }

    .field input:focus,
    .field select:focus,
        {
        border-color: #154272;
        box-shadow: 0 0 0 4px rgba(21, 66, 114, .12);
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 12px;
        flex-wrap: wrap;
    }

    .link {
        color: #154272;
        text-decoration: none;
        font-weight: 500;
        font-size: 16px;
    }

    .link:hover {
        text-decoration: underline;
    }

    .remember {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 16px;
        color: #374151;
        font-weight: 500;
        user-select: none;
    }

    .btn-wrapper {
        display: flex;
        justify-content: center;
    }

    .btn-signin {
        width: 50%;
        margin: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        border-radius: 999px;
        background: #FFDF00;
        color: #000;
        font-size: 18px;
        border: 1px solid #4a4a4a;
        padding: 10px 16px;
        font-weight: 650;
        cursor: pointer;
        transition: all .15s ease;
        box-shadow: 0 8px 16px rgba(21, 66, 114, .18);
    }

    .btn-signin:hover {
        background: #f2d600;
        transform: translateY(-1px);
    }

    .btn-icon {
        width: 34px;
        height: 34px;
        border-radius: 999px;
        background: rgba(13, 8, 8, 0.14);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(13, 8, 8, 0.14);
    }

    .policy-row {
        display: flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
        font-size: 13px;
    }

    /* Social */
    .social-row {
        margin-top: 10px;
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    .social-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 8px 16px rgba(0, 0, 0, .10);
    }

    .social-btn svg {
        width: 20px;
        height: 20px;
        display: block;
    }

    .social-fb {
        background: #3b5998;
    }

    .social-tw {
        background: #1da1f2;
    }

    .social-li {
        background: #0077b5;
    }

    /* Register */
    .register-wrap {
        margin-top: 8px;
        text-align: center;
    }

    .register-text {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .register-pills {
        display: flex;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 16px;
        border-radius: 999px;
        border: 1px solid rgba(21, 66, 114, .22);
        color: #154272;
        font-weight: 650;
        font-size: 14px;
        text-decoration: none;
        background: #f3f9ff;
    }

    .pill:hover {
        filter: brightness(0.98);
    }

    /* Toast */
    .toast-wrap {
        position: fixed;
        top: 18px;
        left: 18px;
        z-index: 9999;
        width: 360px;
        max-width: calc(100vw - 36px);
    }
    </style>
</head>

<body>
    <?php
    $bg = $loginBackground ? $loginBackground->content : '';
  ?>

    <div class="auth-page">
        <div class="auth-shell">

            <!-- LEFT -->
            <div class="auth-left">
                <div class="auth-card">

                    <img src="<?php echo base_url(); ?>/upload/files/website_logo_waff.jpeg" class="auth-logo"
                        alt="Logo">
                    <div class="auth-title">Authorization</div>
                    <div class="auth-subtitle">Sign in to continue</div>

                    <form id="loginForm" method="post" action="">
                        <input type="hidden" name="login" value="login">

                        <div class="section-label">Please choose your account type: *</div>
                        <div class="role-row">
                            <label class="role-option">
                                <input class="form-check-input" type="radio" name="role" value="2" id="role_adv">
                                Advertiser
                            </label>

                            <label class="role-option">
                                <input class="form-check-input" type="radio" name="role" value="1" id="role_pub"
                                    checked>
                                Publisher
                            </label>
                        </div>

                        <!-- Email -->
                        <div class="field" id="emailField">
                            <label>Email</label>
                            <input name="email" type="email" id="ip_email" class="click_btn_login"
                                value="<?php if (set_value('email')) echo set_value('email'); ?>" required>
                        </div>

                        <!-- Password -->
                        <div class="field" id="passField">
                            <label>Password</label>
                            <input type="password" name="pwd" id="ip_pass" class="click_btn_login"
                                value="<?php if (set_value('pwd')) echo set_value('pwd'); ?>" required>
                        </div>

                        <div class="form-row">
                            <a class="link" href="<?php echo base_url('v2/sign/password/reset'); ?>">Password
                                Recovering</a>

                            <label class="remember">
                                <input type="checkbox" name="remember" value="1">
                                Remember Me
                            </label>
                        </div>
                        <div class="btn-wrapper">
                            <button type="submit" class="btn-signin btn_signin">
                                <span class="btn-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                        <polyline points="10 17 15 12 10 7"></polyline>
                                        <line x1="15" y1="12" x2="3" y2="12"></line>
                                    </svg>
                                </span>
                                <span>Sign In</span>
                            </button>
                        </div>
                        <div class="policy-row">
                            <a class="link" target="_blank" href="#">Terms And Conditions</a>
                            <a class="link" target="_blank" href="#">Privacy Policy</a>
                        </div>

                        <!-- Social -->
                        <div class="social-row">
                            <a class="social-btn social-fb" href="#" target="_blank" title="Facebook">
                                <svg>
                                    <use
                                        xlink:href="<?php echo base_url(); ?>/temp/default/images/icon.svg#facebook-icon">
                                    </use>
                                </svg>
                            </a>
                            <a class="social-btn social-tw" href="#" target="_blank" title="Twitter">
                                <svg>
                                    <use
                                        xlink:href="<?php echo base_url(); ?>/temp/default/images/icon.svg#twitter-icon">
                                    </use>
                                </svg>
                            </a>
                            <a class="social-btn social-li" href="#" target="_blank" title="LinkedIn">
                                <svg>
                                    <use
                                        xlink:href="<?php echo base_url(); ?>/temp/default/images/icon.svg#linkedin-icon">
                                    </use>
                                </svg>
                            </a>
                        </div>

                        <!-- Register -->
                        <div class="register-wrap">
                            <div class="register-text">If you don't have an account, please register as</div>
                            <div class="register-pills">
                                <a class="pill" href="<?php echo base_url('v2/sign/up'); ?>">Publisher</a>
                                <a class="pill" href="<?php echo base_url('v2/advertiser/sign-up'); ?>">Advertiser</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

            <!-- RIGHT (image) -->
            <div class="auth-right" style="background-image:url('<?= $bg ?>');"></div>

        </div>

        <!-- Toast -->
        <div class="toast-wrap">
            <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">
                <div class="toast-body d-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-check-circle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                        aria-label="Info">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.17-.94L7.5 9.584 5.854 7.939a.75.75 0 0 0-1.06 1.06l2.176 2.031z" />
                    </svg>
                    <span id="toastContent">Message</span>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.bundle.min.js"></script>

    <script>
    // ===== Floating label behavior (same style as recover page) =====
    function syncFieldState($field, $input) {
        if ($input.val()) $field.addClass('is-active');
        else $field.removeClass('is-active');
    }

    $(document).ready(function() {
        var $emailField = $('#emailField');
        var $passField = $('#passField');
        var $emailInput = $('#ip_email');
        var $passInput = $('#ip_pass');

        syncFieldState($emailField, $emailInput);
        syncFieldState($passField, $passInput);

        $emailInput.on('focus', function() {
            $emailField.addClass('is-active');
        });
        $emailInput.on('blur', function() {
            syncFieldState($emailField, $emailInput);
        });

        $passInput.on('focus', function() {
            $passField.addClass('is-active');
        });
        $passInput.on('blur', function() {
            syncFieldState($passField, $passInput);
        });

        // ===== AJAX login (keep behavior) =====
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var ajurl = "<?php echo base_url('v2/sign/in'); ?>";

            $.ajax({
                type: "POST",
                url: ajurl,
                data: form.serialize(),
                success: ajaxSuccess,
                error: ajaxErr
            });
        });
    });

    function ajaxErr() {
        alert('Network Error!');
    }

    var option = {
        animation: true,
        delay: 5000,
        autohide: true
    };

    function ajaxSuccess(data) {
        var obj;
        try {
            obj = JSON.parse(data);
        } catch (e) {
            $('#toastContent').html('Server response invalid!');
            showToast();
            return;
        }

        $('#toastContent').html(obj.data);
        showToast();

        if (obj.error == 0) {
            setTimeout(function() {
                window.location.href = "<?php echo base_url('v2'); ?>";
            }, 3000);
        }
    }

    function showToast() {
        var myAlert = document.getElementById('thongBao');
        var bsAlert = new bootstrap.Toast(myAlert, option);
        bsAlert.show();
    }
    </script>
</body>

</html>