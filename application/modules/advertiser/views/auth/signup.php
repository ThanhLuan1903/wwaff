<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Authorization</title>
    <meta property="og:image" content="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png">
    <link rel="icon" href="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png">
    <link href="<?php echo base_url(); ?>temp/default/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/temp/default/css/login.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>/temp/default/js/multiple/jquery-3.2.1.min.js" type="text/javascript">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
        integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"
        integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">

    <style>
    #phone {
        height: 32px;
        width: 100%;
        font-size: 14px;
        color: rgb(51, 51, 60);
        border: 1px solid #CACFD3;
        border-radius: 8px;
    }

    input::placeholder {
        opacity: 0.5;
        font-size: 10px;
    }

    .dropdown.bootstrap-select {
        width: 384px !important;
        border-width: 0px 0px 1px;

        border: 1px solid #CACFD3;
        border-radius: 8px;
    }

    .bootstrap-select>.dropdown-toggle {
        border-radius: 8px;
        background: #fff !important;
        font-size: 14px;
        color: rgb(51, 51, 60);
    }

    .toast {
        top: 10px;
        right: 10px;
    }

    .toast .bg-success,
    .toast .bg-danger {
        color: white;
    }

    form div>input {
        width: 384px;
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
            <header class="sc-bdVaJa hTXyZr">
                <div class="sc-bxivhb cpOYPG"></div>
                <div class="ECBVuC1-2xlutADBhrw- ON7Z_5ZehzihyO3o4vqbE" data-test-id="menu-English">
                    <div class="_37NUkzmoyY2UEU1AerMvXX"> <span class="_2cCWo1Fd19nOeZ9SafKr1H">English</span></div>
                </div>
            </header>

            <main class="sc-fAjcbJ kFfNqn">
                <div class="sc-Rmtcm cIUDWQ">
                    <div class="sc-bRBYWo eVigII">
                        <img src="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png"
                            class="sc-VigVT iApbYG">
                        <span class="sc-jhAzac cnxHgy">Registration</span>
                        <div class="sc-hzDkRC ioyCcs">
                            <div style="width: 385px;">
                                <form class="sc-kpOJdX kFPdwr" needs-validation enctype="multipart/form-data">
                                    <input type="text" name="ref_pub_token" hidden
                                        value="<?= isset($_GET['ref']) ? $_GET['ref'] : null ?>">
                                    <div class="sc-hSdWYo drEhZp">
                                        <p class="sc-jlyJG bqJkQa">
                                            <span>Please choose your account type: *</span>
                                            <span class="sc-csuQGl bDzGcN"></span>
                                        </p>
                                        <div class="row col-12 mx-auto">
                                            <div class="col-6 form-check mx-auto">
                                                <input class="form-check-input" type="radio" name="type_account"
                                                    value="Personal" id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1">Personal</label>
                                            </div>
                                            <div class="col-6 form-check mx-auto">
                                                <input class="form-check-input" type="radio" name="type_account"
                                                    value="Company" id="flexRadioDefault2" checked>
                                                <label class="form-check-label" for="flexRadioDefault2">Company</label>
                                            </div>
                                        </div>
                                        <p class="sc-jlyJG bqJkQa">
                                            <span>Do you already have an affiliate program? *</span>
                                            <span class="sc-csuQGl bDzGcN"></span>
                                        </p>
                                        <div class="row col-12 mx-auto">
                                            <div class="col-6 form-check mx-auto">
                                                <input class="form-check-input" type="radio"
                                                    name="user_setting[has_affiliate_program]" value="1" id="radio">
                                                <label class="form-check-label" for="radio">Yes, I already have</label>
                                            </div>
                                            <div class="col-6 form-check mx-auto">
                                                <input class="form-check-input" type="radio"
                                                    name="user_setting[has_affiliate_program]" value="0" id="radio2"
                                                    checked>
                                                <label class="form-check-label" for="radio2">No, I don't</label>
                                            </div>
                                        </div>
                                        <div class="sc-ckVGcZ xzcRZ">
                                            <div class="sc-kAzzGY jIpyka" height="52px">
                                                <p>Username<span id="username_required"> *</span></p>
                                                <input type="text" class="jxLAT click_btn_login"
                                                    style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                    name="username" value="">
                                            </div>
                                        </div>
                                        <div class="sc-ckVGcZ xzcRZ">
                                            <div class="sc-kAzzGY jIpyka" height="52px">
                                                <p>Email<span id="email_required"> *</span></p>
                                                <input type="email" class="jxLAT click_btn_login"
                                                    style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                    name="email" value="<?php echo set_value('email'); ?>">
                                            </div>
                                        </div>
                                        <div class="sc-ckVGcZ xzcRZ">
                                            <div class="sc-kAzzGY jIpyka" height="52px">
                                                <p>Password<span id="password_required"> *</span></p>
                                                <input type="password" id="password" class="jxLAT click_btn_login"
                                                    style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                    name="password" value="<?php echo set_value('password'); ?>">
                                                <svg onclick="showpass()" xmlns="http://www.w3.org/2000/svg" width="18"
                                                    height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="sc-kGXeez bxubDE">
                                                    <path
                                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24">
                                                    </path>
                                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="sc-cvbbAY hMwApc">Password must contain: 8 or up to 30 characters with
                                            at least one uppercase, at least one of the allowed special characters
                                            listed:
                                            _-!@*.$%?&amp;#/|\&gt;^{}[]():;
                                        </p>
                                        <div class="sc-ckVGcZ xzcRZ">
                                            <div class="sc-kAzzGY jIpyka" height="52px">
                                                <p>Repeat password<span id="cfpassword_required"> *</span></p>
                                                <input type="password" class="jxLAT click_btn_login"
                                                    style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                    name="confirm_pass"
                                                    value="<?php echo set_value('confirm_pass'); ?>">
                                            </div>
                                        </div>
                                        <div class="sc-gipzik fusulQ">
                                            <div class="sc-kAzzGY jIpyka" height="52px">
                                                <p>First Name<span id="fname_required"> *</span></p>
                                                <input maxlength="255" type="text" class="jxLAT click_btn_login"
                                                    style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                    name="first_name" value="">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="sc-gipzik fusulQ">
                                            <div class="sc-kAzzGY jIpyka" height="52px">
                                                <p>Last Name<span id="lname_required"> *</span></p>
                                                <input maxlength="255" type="text" class="jxLAT click_btn_login"
                                                    style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                    name="last_name" value="">
                                            </div>
                                            <div class="sc-kAzzGY jIpyka" height="52px">
                                                <p>Address *</p>
                                                <input maxlength="255" type="text" class="jxLAT click_btn_login"
                                                    style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                    name="address" value="">
                                            </div>
                                            <div class="sc-ckVGcZ xzcRZ">
                                                <div class="sc-kAzzGY jIpyka" height="52px">
                                                    <p>Phone Number *</p>
                                                    <input id="phone"
                                                        style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                        name="phone" type="tel" name="phone" />
                                                </div>
                                            </div>
                                            <div class="sc-gipzik fusulQ">
                                                <div class="sc-kAzzGY jIpyka" height="52px">
                                                    <p>Skype ID/Linkedin<span id="social_network_required"> *</span></p>
                                                    <input maxlength="255 "
                                                        style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                        type="text" class="jxLAT click_btn_login" name="social_network">
                                                </div>
                                            </div>
                                            <div class="sc-gipzik fusulQ">
                                                <div class="sc-kAzzGY jIpyka" height="52px">
                                                    <p>Website<span id="website_required"> *</span></p>
                                                    <input maxlength="255"
                                                        style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                        type="text" class="jxLAT" name="website" value="">
                                                </div>
                                                <div class="sc-gipzik fusulQ">
                                                    <div class="sc-kAzzGY jIpyka" height="52px">
                                                        <p style="font-weight: 400;font-size:15px">Avatar *(Please use
                                                            image with 3x4 size)</p>

                                                        <input type="file" class="jxLAT"
                                                            style="border:1px solid #CACFD3;border-radius:8px;height: 40px;padding:6px 10px;"
                                                            name="avatar_url" accept="image/png,image/jpeg,image/jpg" />

                                                        <?php if (!empty($this->mailling['avartar'])): ?>
                                                        <div style="margin-top:8px">
                                                            <img src="<?= base_url($this->mailling['avartar']); ?>"
                                                                alt="avatar preview"
                                                                style="height:70px;border-radius:8px;border:1px solid #e5e7eb" />
                                                        </div>
                                                        <?php endif; ?>

                                                        <small style="display:block;margin-top:6px;opacity:.75">
                                                            Allowed: JPG/PNG. Max 2MB.
                                                        </small>

                                                    </div>
                                                    <div class="sc-ckVGcZ xzcRZ">
                                                        <div class="sc-kAzzGY jIpyka" height="52px">
                                                            <p>Product Geo *</p>
                                                            <select class="selectpicker" data-placeholder="Product Geo"
                                                                data-live-search="true" multiple
                                                                name="product_geo_ids[]">
                                                                <?php foreach ($countries as $country): ?>

                                                                <?php
                                                                    $cc = strtolower(trim($country->keycode));

                                                                    $countryName = mb_convert_case(
                                                                        mb_strtolower(trim($country->country), 'UTF-8'),
                                                                        MB_CASE_TITLE,
                                                                        'UTF-8'
                                                                    );
                                                                ?>

                                                                <option value="<?= $country->id ?>"
                                                                    data-content="<span class='fi fi-<?= $cc ?> me-2'></span><?= htmlspecialchars($countryName) ?> - <?= htmlspecialchars($country->keycode) ?>">
                                                                    <?= htmlspecialchars($countryName) ?>
                                                                </option>

                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="sc-gipzik fusulQ">
                                                        <p class="sc-jlyJG bqJkQa"><span>Please choose your traffic
                                                                type:</span><span class="sc-csuQGl bDzGcN"></span></p>
                                                        <div>
                                                            <?php foreach ($traffic_types as $type): ?>
                                                            <?php $idRandom = rand(10, 100) ?>
                                                            <div
                                                                class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi">
                                                                <input class="" type="checkbox"
                                                                    name="traffic_source_id[]" value="<?= $type->id ?>"
                                                                    id="<?= $type->id ?>">
                                                                <label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00"
                                                                    for="<?= $type->id ?>">
                                                                    <span
                                                                        class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00"><?= $type->content ?></span>
                                                                </label>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <div class="sc-gipzik fusulQ">
                                                        <p class="sc-jlyJG bqJkQa"><span>Please choose product
                                                                category:</span><span class="sc-csuQGl bDzGcN"></span>
                                                        </p>
                                                        <div>
                                                            <select name="product_categories[]" class="selectpicker"
                                                                data-placeholder="Product Category" multiple>
                                                                <option value="">None</option>
                                                                <?php foreach ($p_categories as $pcate): ?>
                                                                <option value="<?= $pcate->id ?>">
                                                                    <?= $pcate->offercat ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="sc-gipzik fusulQ">
                                                        <p class="sc-jlyJG bqJkQa"><span>About your
                                                                business:</span><span class="sc-csuQGl bDzGcN">*</span>
                                                        </p>
                                                        <textarea name="how_to_get_traffic"
                                                            placeholder="Please introduce your business, fill more than 200 characters"
                                                            type="text" class="css-sd33">
                                                        </textarea>
                                                    </div>
                                                    <div class="sc-eHgmQL kLECzY">
                                                        <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi">
                                                            <input class="" type="checkbox"
                                                                name="user_setting[agree_with_term_1]"
                                                                id="agree_with_term_1" value="1">
                                                            <label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00"
                                                                for="agree_with_term_1">
                                                                <span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">
                                                                    <span>I agree with
                                                                        <a class="sc-jWBwVP bBsnzv" target="_blank"
                                                                            href="<?php // echo base_url('v2/terms');
                                                                                                                            ?>#">Terms
                                                                            And Conditions</a>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <div
                                                            class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi css-l9drzq">
                                                            <input class="" type="checkbox" value="1"
                                                                name="user_setting[agree_with_term_2]"
                                                                id="agree_with_term_2">
                                                            <label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00"
                                                                for="agree_with_term_2">
                                                                <span class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">I here
                                                                    by consent and allow the use of my and/or my
                                                                    companys
                                                                    information, including sharing with a third party,
                                                                    to assess, detect, prevent or otherwise enable
                                                                    detection and prevention of malicious, invalid or
                                                                    unlawful activity and/or general fraud prevention.
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="sc-dxgOiQ jaHTXm">
                                                        <button type="submit"
                                                            class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_ btn_signup">
                                                            <div class="_3kiCWIsiMrRqCXneU8Asq6"
                                                                style="height: 0px; width: 0px; left: 0px; top: 0px;">
                                                            </div>
                                                            <span class="_1pFgCebzxXEI3gItBe_863">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="17"
                                                                    height="17" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                                                </svg>
                                                            </span>
                                                            <span class="_3axrJUuPR6Tfk-J1aQF4dm">Create Account</span>
                                                        </button>
                                                        <a class="sc-jKJlTe gPtJgO"
                                                            href="<?php echo base_url('v2/sign/in'); ?>">Sign In</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="sc-ifAKCX hbyzzN">
                <span>Powered by&nbsp;<a target="_blank" rel="noreferrer" href="http://affise.com"
                        class="sc-EHOje fPkDMs">Affise.com</a>&nbsp;2020</span>
                <div class="sc-bZQynM dAZhcd"><a href="https://www.linkedin.com/in/biphan-wedebeek/" rel="noreferrer"
                        target="_blank">Our LinkedIn </a>
                    <a href="https://www.facebook.com/teamwedebeek" rel="noreferrer" target="_blank">Our Facebook</a>
                </div>
            </footer>
        </div>
    </div>

    <div class="toast position-fixed" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>

    <script>
    const radios = document.querySelectorAll('input[name="flexRadioDefault"]');
    const infor = "Persional"
    radios.forEach(radio => {
        radio.addEventListener('change', event => {
            // const = event.target.value;
        });
    });
    </script>

    <script>
    $(document).ready(function() {

        $(".click_btn_login").each(function() {
            var t = $(this).siblings('.span_ip');
            if ($(this).val()) {
                $(t).removeClass('jBAAej span_ip');
                $(t).addClass('fLnJSC');
            } else {
                $(t).removeClass('fLnJSC');
                $(t).addClass('jBAAej span_ip');
            }
        });
        //thuwr span click
        $('.span_ip').on('click', function() {
            var t = $(this).siblings('.click_btn_login');
            $(this).removeClass('jBAAej span_ip');
            $(this).addClass('fLnJSC');
            $(t).focus();
        })

        $('.click_btn_login').on('click', function() {
            var t = $(this).siblings('.span_ip');
            $(t).removeClass('jBAAej span_ip');
            $(t).addClass('fLnJSC');
        })
        $(".click_btn_login").focusout(function() {

            var t = $(this).siblings('span');
            if ($(this).val()) {
                $(t).removeClass('jBAAej');
                $(t).addClass('fLnJSC');
            } else {
                $(t).removeClass('fLnJSC');
                $(t).addClass('jBAAej');
            }
        });
    })

    function showpass() {
        const type = $("#password")[0].type
        if (type === "password") {
            $("#password")[0].type = "text";
        } else {
            $("#password")[0].type = "password";
        }
    }
    </script>

    <script>
    const company_field_required = [
        'username',
        'email',
        'password',
        'cfpassword',
        'website',
        'fname',
        'lname',
        'social_network'
    ]
    const persional_field_required = [
        'username',
        'email',
        'password',
        'cfpassword',
        'fname',
        'lname',
    ]
    const field_required = Array.from(new Set(company_field_required.concat(persional_field_required)));
    $(document).ready(function() {
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js"
        });
        input.addEventListener("countrychange", function() {
            var countryData = iti.getSelectedCountryData();
            var dialCode = "+" + countryData.dialCode;
            document.getElementById("phone").value = dialCode;
        });
        $('.btn_signup').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var formData = new FormData(form[0]);
            ajurl = "<?php echo base_url('v2/advertiser/sign-up') ?>";
            $('.btn_signup').attr('disabled', true);
            $.ajax({
                type: "POST",
                url: ajurl,
                data: formData,
                processData: false, // IMPORTANT
                contentType: false, // IMPORTANT
                success: ajaxSuccess,
                error: ajaxErr
            });
        })
        $('#flexRadioDefault2').on('click', function(e) {
            $("#company").css('display', 'block');
            resetFieldRequired();
            company_field_required.forEach((key) => {
                $('#' + key + '_required').html(' *')
            });
        })
        $('#flexRadioDefault1').on('click', function(e) {
            $("#company").css('display', 'none');
            resetFieldRequired();
            persional_field_required.forEach((key) => {
                $('#' + key + '_required').html(' *')
            });
        })
    });

    function resetFieldRequired() {
        field_required.forEach((key) => {
            $('#' + key + '_required').html('')
        });
    }

    function ajaxErr() {
        alert('Network Error!');
    }

    function ajaxSuccess(data) {
        var myToastEl = document.getElementById('toast')
        var myToast = new bootstrap.Toast(myToastEl, option)
        $('#toast .toast-header').removeClass('bg-danger')
        $('#toast .toast-body').removeClass('bg-danger')
        $('#toast .toast-header').removeClass('bg-success')
        $('#toast .toast-body').removeClass('bg-success')
        const obj = JSON.parse(data);
        if (obj?.error) {
            $('#toast .toast-header').addClass('bg-danger')
            $('#toast .toast-body').addClass('bg-danger')
            $('.toast-body').html(obj.data);
            myToast.show();
            setTimeout(() => {
                $('.btn_signup').attr('disabled', false);
            }, 3000);
        } else {
            $('#toast .toast-header').addClass('bg-success')
            $('#toast .toast-body').addClass('bg-success')
            $('.toast-body').html("<p>Sign up successfully</p>");
            myToast.show();
            setTimeout(() => {
                $('.btn_signup').attr('disabled', false);
                window.location.href = "<?php echo base_url('v2'); ?>";
            }, 500);
        }

    }
    var option = {
        animation: true,
        delay: 5000,
        autohide: true
    };
    </script>

    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.bundle.min.js"></script>
</body>

</html>