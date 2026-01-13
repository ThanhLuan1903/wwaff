<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Password Recovering</title>

    <meta property="og:image" content="<?php echo base_url(); ?>/upload/files/website_logo_waff.jpeg">
    <link rel="icon" href="<?php echo base_url(); ?>/upload/files/website_logo_waff.jpeg">

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>temp/default/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/temp/default/js/multiple/jquery-3.2.1.min.js" type="text/javascript">
    </script>

    <style>
    /* ====== Base ====== */
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

    /* ====== Page wrapper ====== */
    .auth-page {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* ====== Top header (language) ====== */
    .auth-header {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 18px 22px;
    }

    .lang-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border: 1px solid rgba(0, 0, 0, .08);
        border-radius: 999px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
        font-size: 14px;
        color: #22324a;
        cursor: default;
        user-select: none;
    }

    .lang-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #154272;
        display: inline-block;
    }

    /* ====== Main ====== */
    .auth-main {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 18px 40px;
    }

    .auth-card {
        width: 100%;
        max-width: 520px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        padding: 26px 26px 22px;
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
        font-weight: 700;
        color: #154272;
        margin-bottom: 14px;
    }

    /* ====== Form ====== */
    .auth-form {
        margin-top: 6px;
    }

    .field {
        position: relative;
        margin-top: 10px;
    }

    /* input */
    .field input {
        width: 100%;
        height: 52px;
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, .14);
        padding: 16px 14px 12px;
        outline: none;
        font-size: 15px;
        color: #22324a;
        background: #fff;
        transition: all .15s ease;
    }

    .field input:focus {
        border-color: #154272;
        box-shadow: 0 0 0 4px rgba(21, 66, 114, .12);
    }

    /* floating label */
    .field label {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        padding: 0 6px;
        color: #6b7280;
        background: #fff;
        transition: all .15s ease;
        pointer-events: none;
        font-size: 14px;
    }

    .field.is-active label,
    .field input:focus+label {
        top: 0;
        transform: translateY(-50%);
        font-size: 12px;
        color: #154272;
    }

    /* Actions */
    .auth-actions {
        margin-top: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .btn-getlink {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
        border-radius: 999px;
        background: #FFDF00;
        color: #000000;
        padding: 12px 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all .15s ease;
        box-shadow: 0 8px 16px rgba(21, 66, 114, .18);
        white-space: nowrap;
    }

    .btn-getlink:hover {
        background: #f2d600;
        transform: translateY(-1px);
        box-shadow: 0 12px 20px rgba(255, 223, 0, 0.45);
    }

    .btn-getlink:active {
        transform: translateY(0);
        box-shadow: 0 6px 12px rgba(255, 223, 0, 0.35);
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

    .btn-icon svg {
        display: block
    }

    .link-signin {
        color: #154272;
        text-decoration: none;
        font-weight: 700;
        white-space: nowrap;
    }

    .link-signin:hover {
        text-decoration: underline
    }

    /* Footer */
    .auth-footer {
        padding: 14px 18px;
        text-align: center;
        color: #6b7280;
        font-size: 13px;
        background: transparent;
    }

    .auth-footer a {
        color: #154272;
        text-decoration: none;
        font-weight: 700;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }

    /* ====== Toast wrappers ====== */
    .toast-wrap {
        position: fixed;
        top: 18px;
        right: 18px;
        z-index: 9999;
        width: 340px;
        max-width: calc(100vw - 36px);
    }

    /* ====== Responsive ====== */
    @media (max-width: 600px) {
        .auth-card {
            padding: 22px 18px
        }

        .auth-actions {
            flex-direction: column;
            align-items: stretch
        }

        .btn-getlink {
            justify-content: center
        }
    }
    </style>
</head>

<body>
    <div class="auth-page">

        <!-- Header -->
        <div class="auth-header">
            <div class="lang-pill" title="Language">
                <span class="lang-dot"></span>
                <span>English</span>
            </div>
        </div>

        <!-- Main -->
        <div class="auth-main">
            <div class="auth-card">

                <img src="<?php echo base_url(); ?>/upload/files/website_logo_waff.jpeg" class="auth-logo" alt="Logo">
                <div class="auth-title">Password Recovery</div>

                <form class="auth-form" id="recoverForm" autocomplete="off">
                    <!-- Email -->
                    <div class="field" id="emailField">
                        <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" required>
                        <label>Enter your email address to recovery your password</label>
                    </div>

                    <!-- Actions -->
                    <div class="auth-actions">
                        <button type="submit" class="btn-getlink btn_signin">
                            <span class="btn-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                </svg>
                            </span>
                            <span>Send reset link</span>
                        </button>

                        <a class="link-signin" href="<?php echo base_url('v2/sign/in'); ?>">Sign In</a>
                    </div>
                </form>

            </div>
        </div>

        <!-- Footer -->
        <div class="auth-footer">
            <span>
                Powered by&nbsp;<a target="_blank" rel="noreferrer" href="http://affise.com">Affise.com</a>&nbsp;2020
            </span>
            <span>
                <a href="https://www.linkedin.com/in/biphan-wedebeek/" rel="noreferrer" target="_blank">Our LinkedIn</a>
                &nbsp;|&nbsp;
                <a href="https://www.facebook.com/teamwedebeek" rel="noreferrer" target="_blank">Our Facebook</a>
            </span>
        </div>

    </div>

    <!-- Toast: success -->
    <div class="toast-wrap">
        <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">
            <div class="toast-body d-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                    class="bi bi-check-circle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                    aria-label="Success">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.17-.94L7.5 9.584 5.854 7.939a.75.75 0 0 0-1.06 1.06l2.176 2.031z" />
                </svg>
                <span class="toastContent">Success</span>
            </div>
        </div>
    </div>

    <!-- Toast: error -->
    <div class="toast-wrap" style="top:90px;">
        <div class="toast fade" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao2">
            <div class="toast-body bg-danger text-white">
                <span class="toastContent">Error</span>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.bundle.min.js"></script>

    <script>
    // ===== Floating label behavior (clean) =====
    function syncFieldState($field, $input) {
        if ($input.val()) $field.addClass('is-active');
        else $field.removeClass('is-active');
    }

    $(document).ready(function() {
        var $emailField = $('#emailField');
        var $emailInput = $('#email');

        // init state
        syncFieldState($emailField, $emailInput);

        // focus/blur update
        $emailInput.on('focus', function() {
            $emailField.addClass('is-active');
        });
        $emailInput.on('blur', function() {
            syncFieldState($emailField, $emailInput);
        });

        // ===== AJAX submit =====
        $('#recoverForm').on('submit', function(e) {
            e.preventDefault();

            var ajurl = "<?php echo base_url('v2/sign/password/reset'); ?>";
            var form = $(this);

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
            $('.toastContent').html('Server response invalid!');
            var myAlert = document.getElementById('thongBao2');
            var bsAlert = new bootstrap.Toast(myAlert, option);
            bsAlert.show();
            return;
        }

        if (obj.error == 0) {
            $('.toastContent').html(obj.data);
            var myAlert = document.getElementById('thongBao');
            var bsAlert = new bootstrap.Toast(myAlert, {
                animation: true,
                delay: 10000,
                autohide: true
            });
            bsAlert.show();

            setTimeout(function() {
                window.location.href = "<?php echo base_url('v2'); ?>";
            }, 15000);

        } else {
            $('.toastContent').html(obj.data);
            var myAlert = document.getElementById('thongBao2');
            var bsAlert = new bootstrap.Toast(myAlert, option);
            bsAlert.show();
        }
    }
    </script>
</body>

</html>