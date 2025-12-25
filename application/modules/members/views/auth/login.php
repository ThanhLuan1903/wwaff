<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <meta property="og:image" content="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png">
    <link rel="icon" href="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png">
    <title>Authorization</title>
    <link href="<?php echo base_url(); ?>temp/default/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>temp/default/css/newlogin.css?time=<?php echo time(); ?>" rel="stylesheet">
    <script src="<?php echo base_url(); ?>/temp/default/js/multiple/jquery-3.2.1.min.js" type="text/javascript"></script>

    <style>
        .icon-social {
            width: 38px;
            height: 38px;
            padding: 8px;
            border-radius: 8px;
            display: inline-block;
            margin-right: 8px;
            cursor: pointer;
            color: #fff;
        }

        .label-register {
            cursor: pointer;
            max-width: 200px;
            height: 38px;
            border: 1px solid rgba(20, 177, 247, 0.2);
            border-radius: 19px;
            display: inline-block;
            margin: 0 4px;
            padding: 11px 17px;
            color: #14B1F7;
            font-weight: 500 !important;
        }

        .label-register>a {
            color: #14B1F7;
            font-weight: 500 !important;
        }

        .toast-top-left {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 9999;
        }
    </style>
</head>

<body wfd-invisible="true">
    <div class="loader" wfd-invisible="true"><i class="dot"></i> <i class="dot"></i> <i class="dot"></i></div>
    <div id="root">
        <div class="_15fu8tliQjoFX_txAhIwyW _2JZmjKGweSe3VKt76UWHXO css-1ed4bhs">
            <div class="_1q1YDBKhjzRspY4va-DRI4"></div>
        </div>
        <div class="sc-eqIVtm jFlzmB">
            <div class="row col-12">
                <div class="col-4" style="height:100vh">
                    <main class="sc-fAjcbJ kFfNqn">
                        <div class="sc-Rmtcm cIUDWQ">
                            <div class="sc-bRBYWo eVigII">
                                <img src="<?php echo base_url(); ?>/upload/files/website_logo_waff.jpeg" class="sc-VigVT iApbYG">
                                <span class="sc-jhAzac cnxHgy">Authorization</span>
                                <div class="sc-hzDkRC ioyCcs">
                                    <form class="sc-kpOJdX kFPdwr" method="post" action="">
                                        <div data-test-id="login-signin-email-input" class="xzcRZ">
                                            <p class="sc-jlyJG bqJkQa">
                                                <span>Please choose your account type: *</span>
                                                <span class="sc-csuQGl bDzGcN"></span>
                                            </p>
                                            <div class="row col-12 mx-auto">
                                                <div class="col-6 form-check mx-auto">
                                                    <input class="form-check-input" type="radio" name="role" value="2" id="flexRadioDefault1">
                                                    <label class="form-check-label" for="flexRadioDefault1">Advertiser</label>
                                                </div>
                                                <div class="col-6 form-check mx-auto">
                                                    <input class="form-check-input" type="radio" name="role" value="1" id="flexRadioDefault2" checked>
                                                    <label class="form-check-label" for="flexRadioDefault2">Publisher</label>
                                                </div>
                                            </div>
                                            <div class="sc-kAzzGY jIpyka">
                                                <p>Email</p>
                                                <input type="hidden" name="login" value="login">
                                                <input name="email" type="email" class="jxLAT click_btn_login" style="width:100%"
                                                    value="<?php if (set_value('email')) echo set_value('email'); ?>" id="ip_email">
                                            </div>
                                        </div>
                                        <div data-test-id="login-signin-password-input" class="xzcRZ">
                                            <div class="sc-kAzzGY jIpyka">
                                                <p>Password</p>
                                                <input type="password" name="pwd" class="jxLAT click_btn_login" style="width:100%"
                                                    value="<?php if (set_value('pwd')) echo set_value('pwd'); ?>" id="ip_pass">
                                            </div>
                                        </div>
                                        <div class="newdiv">
                                            <a class="sc-jKJlTe gPtJgO" href="<?php echo base_url('v2/sign/password/reset'); ?>">Password Recovering</a>
                                            <div data-test-id="login-signin-remember-toogle" class="sc-eNQAEJ jpWIxZ">
                                                <div class="_24Sdpdb7tKbUjJcti0bPnh _35iQwZ_AuaFmdI_kBnReo_">
                                                    <input class="" type="checkbox" name="7h429qn81qj" id="7h429qn81qj" value="false">
                                                    <label class="_19KU9ICo0Eb0R2seYqKsCW" for="7h429qn81qj">
                                                        <span class="_19KU9ICo0Eb0R2seYqKsCW">Remember Me</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sc-dxgOiQ jaHTXm">
                                            <button data-test-id="login-signin-signin-button" type="submit"
                                                class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_ btn_signin">
                                                <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                                <span class="_1pFgCebzxXEI3gItBe_863">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="">
                                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                                        <polyline points="10 17 15 12 10 7"></polyline>
                                                        <line x1="15" y1="12" x2="3" y2="12"></line>
                                                    </svg>
                                                </span>
                                                <span class="_3axrJUuPR6Tfk-J1aQF4dm">Sign In</span>
                                            </button>
                                            <br>
                                        </div>
                                        <div class="sc-hMqMXs iQKfMG">
                                            <a class="sc-jKJlTe gPtJgO" target="_blank" href="#">Terms And Conditions</a>
                                            <div class="sc-kEYyzF chXnfj"><a class="sc-jKJlTe gPtJgO" target="_blank" href="#">Privacy Policy</a></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </main>

                    <div class="row">
                        <div class="text-center">
                            <a style="color:white" href="#" target="_blank">
                                <div class="icon-social" style="background-color:rgb(59, 89, 152)">
                                    <svg href="#" class="" style="width:100%;height:100%">
                                        <use xlink:href="<?php echo base_url(); ?>/temp/default/images/icon.svg#facebook-icon"> </use>
                                    </svg>
                                </div>
                            </a>
                            <a style="color:white" href="#" target="_blank">
                                <div class="icon-social" style="background-color:rgb(29, 161, 242)">
                                    <svg class="" style="width:100%;height:100%">
                                        <use xlink:href="<?php echo base_url(); ?>/temp/default/images/icon.svg#twitter-icon"></use>
                                    </svg>
                                </div>
                            </a>
                            <a style="color:white" href="#" target="_blank">
                                <div class="icon-social" style="background-color:rgb(0, 119, 181)">
                                    <svg class="" style="width:100%;height:100%">
                                        <use xlink:href="<?php echo base_url(); ?>/temp/default/images/icon.svg#linkedin-icon"></use>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <span class="instruc text-center">If you don't have an account, please register as</span>
                        <div class="text-center">
                            <div class="label-register text-center"><a href="<?php echo base_url('v2/sign/up'); ?>"
                                    style="text-decoration:none">Publisher</a></div>
                            <div class="label-register text-center"><a href="<?php echo base_url('v2/advertiser/sign-up'); ?>"
                                    style="text-decoration:none">Advertiser</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-8" style="background:url(<?= $loginBackground ? $loginBackground->content : null ?>) no-repeat;background-size:cover"></div>
            </div>
        </div>
    </div>

    <div class="position-fixed top-0 end-0 p-5 hide">
        <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">
            <div class="toast-body d-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                    aria-label="Warning:">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
                <span id="toastContent">Successfully edited profile</span>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <span>Powered by&nbsp;<a href="https://wwaff.com" target="_blank">wwaff.com</a>&nbsp;2025</span>
    </footer>


    <script>
        $(document).ready(function() {

            $(".click_btn_login").each(function() {
                var t = $(this).siblings('.span_ip');
                if ($(this).val()) {
                    $(t).removeClass('jBAAej');
                    $(t).addClass('fLnJSC');
                } else {
                    $(t).removeClass('fLnJSC');
                    $(t).addClass('jBAAej');
                }
            });

            $('.click_btn_login').on('click', function() {
                var t = $(this).siblings('.span_ip');
                $(t).removeClass('jBAAej');
                $(t).addClass('fLnJSC');
            })

            $(".click_btn_login").focusout(function() {
                var t = $(this).siblings('.span_ip');
                if ($(this).val()) {
                    $(t).removeClass('jBAAej');
                    $(t).addClass('fLnJSC');
                } else {
                    $(t).removeClass('fLnJSC');
                    $(t).addClass('jBAAej');
                }
            });

            $('.btn_signin').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                ajurl = "<?php echo base_url('v2/sign/in'); ?>";
                $.ajax({
                    type: "POST",
                    url: ajurl,
                    data: form.serialize(),
                    success: ajaxSuccess,
                    error: ajaxErr
                });
            })
        })

        function ajaxErr() {
            alert('Network Error!');
        }

        function ajaxSuccess(data) {
            const obj = JSON.parse(data);
            if (obj.error == 0) {
                setTimeout(() => {
                    window.location.href = "<?php echo base_url('v2'); ?>";
                }, 3000);
            }
            $('#toastContent').html(obj.data);
            var myAlert = document.getElementById('thongBao'); //select id of toast
            myAlert.classList.add('toast-top-left');
            var bsAlert = new bootstrap.Toast(myAlert, option); //inizialize it

            bsAlert.show(); //show it   
        }

        var option = {
            animation: true,
            delay: 5000,
            autohide: true,
            position: 'top-start'
        };
    </script>
    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.bundle.min.js"></script>
</body>

</html>