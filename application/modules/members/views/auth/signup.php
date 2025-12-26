<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Authorization</title>
    <meta property="og:image" content="<?php echo base_url(); ?>/upload/files/website_logo_waff.jpeg">
    <link rel="icon" href="<?php echo base_url(); ?>/upload/files/website_logo_waff.jpeg">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>temp/default/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>/temp/default/css/login.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>/temp/default/js/multiple/jquery-3.2.1.min.js" type="text/javascript"></script>
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
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">
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
                    <div class="_37NUkzmoyY2UEU1AerMvXX">
                        <span class="_2cCWo1Fd19nOeZ9SafKr1H">English</span>
                    </div>
                </div>
            </header>
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
                    console.log(t);
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

                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
            </script>
            <main class="sc-fAjcbJ kFfNqn">
                <div class="sc-Rmtcm cIUDWQ">
                    <div class="sc-bRBYWo eVigII" style="margin-top:100px">
                        <img src="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png" class="sc-VigVT iApbYG">
                        <span class="sc-jhAzac cnxHgy">Registration</span>
                        <div class="sc-hzDkRC ioyCcs">
                            <div style="width: 385px;">
                                <style>
                                #phone {
                                    height: 32px;
                                    width: 384px;
                                    font-size: 14px;
                                    color: rgb(51, 51, 60);
                                    border: 1px solid #CACFD3;
                                    border-radius: 8px;
                                }
                                </style>


                                <form class="sc-kpOJdX kFPdwr" enctype="multipart/form-data">
                                    <input type="hidden" name="ref_pub_token" value="" />
                                    <div class="sc-hSdWYo drEhZp">
                                        <div class="row col-12 mx-auto">
                                            <p class="sc-jlyJG bqJkQa" style="padding: 0">
                                                <span>Please choose your account type: *</span>
                                                <span class="sc-csuQGl bDzGcN"></span>
                                            </p>
                                            <div class="col-6 form-check mx-auto">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                    value="Persional" id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Personal
                                                </label>
                                            </div>
                                            <div class="col-6 form-check mx-auto">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                    value="Company" id="flexRadioDefault2" checked>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Company
                                                </label>
                                            </div>
                                        </div>

                                        <div class="sc-ckVGcZ xzcRZ">
                                            <div class="sc-kAzzGY jIpyka" height="52px" id="username">
                                                <p>Username<span id="username_required"> *</span></p>
                                                <input type="text" class="jxLAT click_btn_login"
                                                    style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                    name="mailling[username]" value="">
                                            </div>
                                        </div>
                                        <div class="sc-ckVGcZ xzcRZ">
                                            <div class="sc-kAzzGY jIpyka">
                                                <p>Email<span id="email_required"> *</span></p>
                                                <input type="email" class="jxLAT click_btn_login"
                                                    style="border:1px solid #CACFD3;border-radius:8px;height: 40px;" name="email"
                                                    value="<?php echo set_value('email'); ?>">

                                                <!-- <span class="jBAAej span_ip" height="36px">Email<span class="sc-brqgnP feZNLG">*</span></span> -->
                                            </div>
                                        </div>
                                        <div class="sc-ckVGcZ xzcRZ">
                                            <div class="sc-kAzzGY jIpyka">
                                                <p>Password<span id="password_required"> *</span></p>
                                                <input type="password" id="password" class="jxLAT click_btn_login" style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                    name="password" value="<?php echo set_value('password'); ?>">
                                                <!-- <span class="jBAAej span_ip"  height="36px">Password<span class="sc-brqgnP feZNLG">*</span></span> -->
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
                                        <p class="sc-cvbbAY hMwApc">Password must contain: 6 or up to 30 characters with
                                            at least one uppercase, at least one lowercase, at least one numeric digit,
                                            at least one of the allowed special characters listed:
                                            _-!@*.$%?&amp;#/|\&gt;^{}[]():;</p>
                                        <div class="sc-ckVGcZ xzcRZ">
                                            <div class="sc-kAzzGY jIpyka">
                                                <p style="font-weight: 400;font-size:15px">Repeat password</p>
                                                <input type="password" class="jxLAT click_btn_login" style="border:1px solid #CACFD3;border-radius:8px;height: 40px;" name="confirm_pass"
                                                    value="<?php echo set_value('confirm_pass'); ?>">
                                                <!-- <span class="jBAAej span_ip" height="36px">Repeat password<span class="sc-brqgnP feZNLG">*</span></span> -->
                                            </div>
                                        </div>
                                        <div class="sc-gipzik fusulQ">
                                            <div class="sc-kAzzGY jIpyka">
                                                <p>First Name<span id="fname_required"> *</span></p>
                                                <input maxlength="255" type="text" class="jxLAT click_btn_login" style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                    name="mailling[firstname]"
                                                    value="<?php if (!empty($this->mailling['firstname'])) echo $this->mailling['firstname']; ?>">
                                                <!-- <span class="jBAAej span_ip" height="36px">First Name<span class="sc-csuQGl bDzGcN">*</span> -->
                                                </span>
                                            </div>
                                        </div>
                                        <div class="sc-gipzik fusulQ">
                                            <div class="sc-kAzzGY jIpyka">
                                                <p>Last Name<span id="lname_required"> *</span></p>
                                                <input maxlength="255" type="text" class="jxLAT click_btn_login" style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                    name="mailling[lastname]"
                                                    value="<?php if (!empty($this->mailling['lastname'])) echo $this->mailling['lastname']; ?>">
                                                <!-- <span class="jBAAej span_ip" height="36px">Last Name<span class="sc-csuQGl bDzGcN">*</span></span></div> -->
                                            </div>
                                            <div class="sc-kAzzGY jIpyka" height="52px">
                                                <p>Address *</p>
                                                <input type="text" style="border:1px solid #CACFD3;border-radius:8px;height: 40px;" name="mailling[ad]" class="jxLAT click_btn_login" data-placeholder="Address" />
                                            </div>
                                            <div class="sc-ckVGcZ xzcRZ">
                                                <div class="sc-kAzzGY jIpyka">
                                                    <p style="font-weight: 400;font-size:15px">Phone Number</p>
                                                    <input id="phone" style="border:1px solid #CACFD3;border-radius:8px;height: 40px;" name="phone" type="tel" name="phone" />
                                                    <script>
                                                    var input = document.querySelector("#phone");
                                                    var iti = window.intlTelInput(input, {
                                                        separateDialCode: true,
                                                        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js"
                                                    });
                                                    input.addEventListener("countrychange", function() {
                                                        var countryData = iti.getSelectedCountryData();
                                                        var dialCode = "+" + countryData.dialCode;
                                                        document.getElementById("phone").value = dialCode;
                                                        console.log(dialCode);
                                                    });
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="sc-gipzik fusulQ">
                                                <div class="sc-kAzzGY jIpyka">
                                                    <p>Skype ID/Linkedin<span id="social_network_required"> *</span></p>
                                                    <input maxlength="255" type="text" class="jxLAT click_btn_login" style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                        name="mailling[im_service]"
                                                        value="<?php if (!empty($this->mailling['im_service'])) echo $this->mailling['im_service']; ?>">
                                                </div>
                                            </div>
                                            <div class="sc-gipzik fusulQ">
                                                <div class="sc-kAzzGY jIpyka">
                                                    <p>Website<span id="website_required"> *</span></p>
                                                    <input maxlength="255" type="text" class="jxLAT click_btn_login" style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                        name="mailling[website]"
                                                        value="<?php if (!empty($this->mailling['website'])) echo $this->mailling['website']; ?>">
                                                </div>
                                                <style>
                                                input::placeholder {
                                                    opacity: 0.5;
                                                    font-size: 12px;
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
                                                </style>
                                                <!-- Category Options -->
                                                <div class="sc-kAzzGY jIpyka" height="52px">
                                                    <p>Product Categories *</p>
                                                    <select name="product_category[]" class="selectpicker"
                                                        data-placeholder="Product Category" multiple>
                                                        <?php foreach ($categories as $category): ?>
                                                        <option value="<?= $category->id ?>"><?= $category->offercat ?>
                                                        </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="sc-kAzzGY jIpyka" height="52px">
                                                    <p>Product Geo *</p>
                                                    <select class="selectpicker" data-placeholder="Product Geo"
                                                        data-live-search="true" multiple name="product_geo[]">
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
                                                <!-- Conversion Flow -->
                                                <div class="sc-kAzzGY jIpyka" height="52px">
                                                    <p>Product type *</p>
                                                    <select name="conversion_flow[]" class="selectpicker"
                                                        data-placeholder="Product type" multiple>
                                                        <?php foreach ($offer_types as $offer_type): ?>
                                                        <option value="<?= $offer_type->id ?>"><?= $offer_type->type ?>
                                                        </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <!-- Volume -->
                                                <div class="sc-kAzzGY jIpyka" height="52px">
                                                    <p>Volume *</p>
                                                    <input type="number" name="mailling[volume]"
                                                        class="jxLAT click_btn_login"
                                                        style="border:1px solid #CACFD3;border-radius:8px;height: 40px;"
                                                        data-placeholder="Volume" multiple />
                                                </div>
                                                <!-- Traffic Device -->
                                                <div class="sc-kAzzGY jIpyka" height="52px">
                                                    <?php $traffic_devices = $this->Home_model->get_data('device', ['show' => 1]); ?>
                                                    <p>Traffic Device *</p>
                                                    <select name="traffic_device" class="selectpicker"
                                                        data-placeholder="Traffic Device">
                                                        <?php foreach ($traffic_devices as $traffic_device): ?>
                                                        <option value="<?= $traffic_device->id ?>">
                                                            <?= $traffic_device->device ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <!-- Address -->


                                                <div class="sc-kAzzGY jIpyka">
                                                    <p style="font-weight: 400;font-size:15px; margin-top:6px">Avatar
                                                        *(Please use
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
                                                </div>
                                                <div class="sc-gipzik fusulQ">
                                                    <p style="margin-top:6px;" class="sc-jlyJG bqJkQa">Please choose
                                                        your traffic
                                                        type:*</p>
                                                    <?php foreach ($trafficTypes as $type): ?>
                                                    <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi">
                                                        <input class="" type="checkbox" name="aff_type[]"
                                                            value="<?= $type->content ?>" id="<?= $type->id ?>"><label
                                                            class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00"
                                                            for="<?= $type->id ?>"><span
                                                                class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00"><?= $type->content ?></span></label>
                                                    </div>
                                                    <?php endforeach; ?>

                                                </div>
                                            </div>

                                            <div class="sc-gipzik fusulQ">
                                                <p class="sc-jlyJG bqJkQa"><span
                                                        style="font-weight: 400;font-size:15px">About your
                                                        business:</span><span class="sc-csuQGl bDzGcN">*</span>
                                                </p>

                                                <textarea name="mailling[hear_about]"
                                                    placeholder="Please introduce your business, fill more than 200 characters"
                                                    type="text" class="css-sd33" maxlength="300"></textarea>
                                            </div>
                                            <div class="sc-eHgmQL kLECzY">
                                                <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi">
                                                    <input class="" type="checkbox" name="mailling[terms]"
                                                        id="1sftljo7ebto" value="1">
                                                    <label class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00"
                                                        for="1sftljo7ebto"><span
                                                            class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00"><span>I
                                                                agree with<a class="sc-jWBwVP bBsnzv" target="_blank"
                                                                    href="#">Terms
                                                                    And Conditions</a></span></span></label>
                                                </div>
                                                <div class="_2yRUtwQzTcJQHKHRzGIAfL _1zMi2ue1d1ggkuAFpIUpBi css-l9drzq">
                                                    <input class="" type="checkbox" name="57l2dbmlifn"
                                                        id="57l2dbmlifn"><label
                                                        class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00"
                                                        for="57l2dbmlifn"><span
                                                            class="_7H-rw2-gbQmIWhoWOkS93 css-7c2d00">I hereby
                                                            consent and allow the use of my and/or my companys
                                                            information, including sharing with a third party,
                                                            to assess, detect, prevent or otherwise enable
                                                            detection and prevention of malicious, invalid or
                                                            unlawful activity and/or general fraud
                                                            prevention.</span></label>
                                                </div>
                                            </div>
                                            <div class="sc-dxgOiQ jaHTXm">
                                                <button type="submit"
                                                    class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_ btn_signup">
                                                    <div class="_3kiCWIsiMrRqCXneU8Asq6"
                                                        style="height: 0px; width: 0px; left: 0px; top: 0px;">
                                                    </div>
                                                    <span class="_1pFgCebzxXEI3gItBe_863">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="">
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

    <script>
    const radios = document.querySelectorAll('input[name="flexRadioDefault"]');
    const infor = "Persional"
    radios.forEach(radio => {
        radio.addEventListener('change', event => {
            const selectedValue = event.target.value; // Thêm tên biến
            // Hoặc nếu không dùng thì xóa dòng này đi
        });
    });
    </script>
    <!--thoong bao -->
    <div class="position-fixed top-0 end-0 p-5 hide">
        <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">
            <div class="toast-body">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                    aria-label="Warning:">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
                <span class="toastContent">
                    Successfully edited profile
                </span>
            </div>
        </div>
    </div>
    <!--thong bao loi-->
    <div class="position-fixed top-0 end-0 p-5 hide">
        <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao2">
            <div class="toast-body bg-danger text-white">

                <span class="toastContent ">
                    Successfully edited profile
                </span>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
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
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js"
        });
        input.addEventListener("countrychange", function() {
            var countryData = iti.getSelectedCountryData();
            var dialCode = "+" + countryData.dialCode;
            document.getElementById("phone").value = dialCode;
            console.log(dialCode);
        });
        $('.btn_signup').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var formData = new FormData(form[0]);
            ajurl = "<?php echo base_url('v2/sign/up') ?>";
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
            resetFieldRequired();
            company_field_required.forEach((key) => {
                $('#' + key + '_required').html(' *')
            });
        })
        $('#flexRadioDefault1').on('click', function(e) {
            resetFieldRequired();
            persional_field_required.forEach((key) => {
                $('#' + key + '_required').html(' *')
            });
        })


        const queryString = getQueryString();
        $('input[name="ref_pub_token"]').val(queryString.ref)
        // $('.btn_signup').on('click', function(e) {
        //     e.preventDefault();
        //     var form = $(this).closest('form');
        //     ajurl = "<?php echo base_url('v2/sign/up'); ?>";
        //     $.ajax({
        //         type: "POST",
        //         url: ajurl,
        //         data: form.serialize(),
        //         success: ajaxSuccess,
        //         error: ajaxErr
        //     });
        // })

        function resetFieldRequired() {
            field_required.forEach((key) => {
                $('#' + key + '_required').html('')
            });
        }
    });




    function ajaxErr() {
        alert('Network Error!');
    }

    function ajaxSuccess(data) {
        const obj = JSON.parse(data);
        if (obj.error == 0) {
            $('.toastContent').html(obj.data);
            var myAlert = document.getElementById('thongBao'); //select id of toast
            var bsAlert = new bootstrap.Toast(myAlert, {
                animation: true,
                delay: 10000,
                autohide: true
            }); //inizialize it
            bsAlert.show(); //show it  
            setTimeout(() => {
                window.location.href = "<?php echo base_url('v2'); ?>";
            }, 500);
        } else {
            $('.toastContent').html(obj.data);
            $('.btn_signup').attr('disabled', false);
            var myAlert = document.getElementById('thongBao2'); //select id of toast
            var bsAlert = new bootstrap.Toast(myAlert, option); //inizialize it
            bsAlert.show(); //show it  
        }

    }
    var option = {
        animation: true,
        delay: 5000,
        autohide: true
    };

    function getQueryString() {
        // Lấy chuỗi query string từ URL bằng cách chuyển đổi location.search
        var queryString = window.location.search;

        // Kiểm tra nếu chuỗi query không tồn tại hoặc rỗng, trả về null
        if (!queryString) {
            return null;
        }

        // Loại bỏ ký tự "?" ở đầu chuỗi query
        queryString = queryString.slice(1);

        // Tạo một đối tượng lưu trữ các giá trị key-value trong query string
        var queryParams = {};

        // Phân tích chuỗi query và đưa các giá trị vào đối tượng queryParams
        queryString.split('&').forEach(function(param) {
            var keyValue = param.split('=');
            var key = decodeURIComponent(keyValue[0]);
            var value = decodeURIComponent(keyValue[1] || '');
            queryParams[key] = value;
        });

        // Trả về đối tượng queryParams
        return queryParams;
    }
    </script>
    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.bundle.min.js"></script>
</body>

</html>