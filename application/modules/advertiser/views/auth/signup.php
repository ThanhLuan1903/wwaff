<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
    <title>Authorization</title>

    <meta property="og:image" content="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png" />
    <link rel="icon" href="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png" />

    <link href="<?php echo base_url(); ?>temp/default/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/temp/default/css/login.css" rel="stylesheet" />
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
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css" />

    <style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        background: #f3f5f7;
        color: #203040;
        min-height: 100vh;
    }

    .sc-eqIVtm.jFlzmB,
    #root {
        width: 100%;
    }

    .auth-page {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: stretch;
    }

    .auth-shell {
        width: 60%;
        padding-top: 10px;
        min-height: calc(100vh - 64px);
    }

    .auth-card {
        width: 100%;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        padding: 26px 26px 20px;
    }

    .auth-header {
        text-align: center;
        margin-bottom: 14px;
    }

    .auth-logo {
        width: 82px;
        height: 82px;
        object-fit: contain;
        display: block;
        margin: 0 auto 10px;
    }

    .auth-title {
        font-size: 22px;
        font-weight: 800;
        color: #154272;
        margin: 0 0 6px;
    }

    .auth-subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .section-label {
        font-size: 14px;
        color: #374151;
        margin: 14px 0 8px;
        font-weight: 650;
    }

    .role-row {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        padding: 10px 12px;
    }

    .role-option {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        font-weight: 600;
        color: #1f2937;
        font-size: 14px;
    }

    /* Grid */
    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .group-btn {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0px 120px;
        margin-top: 24px;
    }

    @media (max-width: 760px) {
        .auth-card {
            padding: 20px;
        }

        .grid-2 {
            grid-template-columns: 1fr;
        }

        .group-btn {
            padding: 0px;
        }
    }

    .field {
        margin-top: 10px;
    }

    .field label {
        position: static;
        transform: none;
        display: block;
        margin: 0 0 6px;
        padding: 0;
        background: transparent;
        pointer-events: auto;
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
    .field textarea:focus {
        border-color: #154272;
        box-shadow: 0 0 0 4px rgba(21, 66, 114, .12);
    }

    input::placeholder {
        opacity: .55;
        font-size: 12px;
    }

    /* Phone input match */
    #phone {
        height: 48px !important;
        border-radius: 10px !important;
        border: 1px solid rgba(0, 0, 0, .14) !important;
        padding: 10px 14px !important;
        font-size: 15px !important;
        color: #22324a !important;
    }

    .iti {
        width: 100%;
    }

    /* bootstrap-select match */
    .dropdown.bootstrap-select {
        width: 100% !important;
    }

    .bootstrap-select>.dropdown-toggle {
        height: 48px !important;
        border-radius: 10px !important;
        border: 1px solid rgba(0, 0, 0, .14) !important;
        background: #fff !important;
        color: #22324a !important;
        padding: 12px 14px !important;
    }

    .bootstrap-select>.dropdown-toggle:focus {
        border-color: #154272 !important;
        box-shadow: 0 0 0 4px rgba(21, 66, 114, .12) !important;
        outline: none !important;
    }

    .pw-eye {
        position: absolute;
        right: 12px;
        top: 42px;
        cursor: pointer;
        color: #154272;
        display: flex;
        align-items: center;
    }

    .pw-eye .icon-eye {
        display: none;
    }

    .pw-eye.is-hidden .icon-hide {
        display: block;
    }

    .pw-eye.is-shown .icon-show {
        display: block;
    }

    .hint {
        margin-top: 10px;
        font-size: 13px;
        color: #6b7280;
        line-height: 1.4;
    }

    /* Checkbox list */
    .check-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px 10px;
        margin-top: 6px;
    }

    /* Hide image from tablet down */
    @media (max-width: 991.98px) {

        .auth-shell {
            min-height: calc(100vh - 56px);
            padding: 10px;
            width: 80%;
        }

        .auth-card {
            padding: 20px;
        }
    }

    @media (max-width: 760px) {
        .check-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .auth-shell {
            min-height: calc(100vh - 56px);
            padding: 6px;
            width: 90%;
        }

        .auth-card {
            padding: 20px;
        }
    }

    @media (max-width: 380px) {
        .check-grid {
            grid-template-columns: 1fr;
        }

        .auth-card {
            padding: 20px;
        }

    }

    .check-item {
        display: flex;
        gap: 6px;
        align-items: flex-start;
    }

    .check-row .check-item input[type="checkbox"] {
        margin: 4px 0 0;
        flex: 0 0 auto;
    }


    .check-item label {
        font-size: 14px;
        color: #374151;
        line-height: 1.35;
    }

    .check-item a {
        color: #154272;
        font-weight: 600;
        text-decoration: none;
    }

    .check-item a:hover {
        text-decoration: underline;
    }

    .btn_signup {
        border: none;
        border-radius: 999px;
        background: #FFDF00;
        color: #000;
        font-size: 16px;
        border: 1px solid #4a4a4a;
        padding: 10px 18px;
        font-weight: 650;
        cursor: pointer;
        transition: all .15s ease;
        box-shadow: 0 8px 16px rgba(21, 66, 114, .18);
        display: inline-flex;
        align-items: center;
        gap: 12px;
        min-height: 48px;
    }

    .btn_signup:hover {
        background: #f2d600;
        transform: translateY(-1px);
    }

    .btn_signup:disabled {
        opacity: .65;
        cursor: not-allowed;
        transform: none;
    }

    .btn-icon {
        width: 34px;
        height: 34px;
        border-radius: 999px;
        background: rgba(13, 8, 8, 0.14);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(13, 8, 8, 0.14);
    }

    .link {
        color: #154272;
        font-weight: 700;
        text-decoration: none;
    }

    .link:hover {
        text-decoration: underline;
    }

    /* Toast position keep */
    .toast {
        top: 10px;
        right: 10px;
    }

    .toast .bg-success,
    .toast .bg-danger {
        color: #fff;
    }

    /* Footer */
    .auth-footer {
        padding: 14px 18px;
        text-align: center;
        color: #6b7280;
        font-size: 13px;
    }

    .auth-footer a {
        color: #154272;
        font-weight: 700;
        text-decoration: none;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }

    .check-item input[type="checkbox"] {
        margin: 2px 0 0;
        flex: 0 0 auto;
    }


    .field-phone .iti {
        width: 100%;
    }

    .field-phone .iti input#phone {
        padding-left: 80px !important;
        height: 48px !important;
        border-radius: 10px !important;
    }
    </style>
</head>

<body wfd-invisible="true">
    <div class="loader" wfd-invisible="true"><i class="dot"></i> <i class="dot"></i> <i class="dot"></i></div>
    <div class="auth-page">
        <div class="auth-shell">
            <div class="auth-card">
                <div class="auth-header">
                    <img src="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png" class="auth-logo"
                        alt="Logo" />
                    <div class="auth-title">Worldwide Affiliate</div>
                    <p class="auth-subtitle">Create your account</p>
                </div>

                <form needs-validation enctype="multipart/form-data">
                    <input type="text" name="ref_pub_token" hidden
                        value="<?= isset($_GET['ref']) ? $_GET['ref'] : null ?>">

                    <!-- Account type -->
                    <div class="section-label">Please choose your account type: <span class="sc-csuQGl bDzGcN">*</span>
                    </div>
                    <div class="role-row">
                        <label class="role-option" for="flexRadioDefault1">
                            <input class="form-check-input" type="radio" name="type_account" value="Personal"
                                id="flexRadioDefault1">
                            Personal
                        </label>

                        <label class="role-option" for="flexRadioDefault2">
                            <input class="form-check-input" type="radio" name="type_account" value="Company"
                                id="flexRadioDefault2" checked>
                            Company
                        </label>
                    </div>

                    <!-- Affiliate program -->
                    <div class="section-label" style="margin-top:14px;">Do you already have an affiliate program? <span
                            class="sc-csuQGl bDzGcN">*</span></div>
                    <div class="role-row">
                        <label class="role-option" for="radio">
                            <input class="form-check-input" type="radio" name="user_setting[has_affiliate_program]"
                                value="1" id="radio">
                            Yes, I already have
                        </label>
                        <label class="role-option" for="radio2">
                            <input class="form-check-input" type="radio" name="user_setting[has_affiliate_program]"
                                value="0" id="radio2" checked>
                            No, I don't
                        </label>
                    </div>

                    <!-- TOP FIELDS -->
                    <div class="grid-2">
                        <div class="field" id="username">
                            <label>Username<span id="username_required"> *</span></label>
                            <input type="text" class="jxLAT click_btn_login" name="username" value="">
                        </div>

                        <div class="field">
                            <label>Email<span id="email_required"> *</span></label>
                            <input type="email" class="jxLAT click_btn_login" name="email"
                                value="<?php echo set_value('email'); ?>">
                        </div>
                    </div>

                    <!-- PASSWORDS -->
                    <div class="grid-2">
                        <div class="field" style="position:relative">
                            <label>Password<span id="password_required"> *</span></label>
                            <input type="password" id="password" class="jxLAT click_btn_login" name="password"
                                value="<?php echo set_value('password'); ?>">
                            <!-- Keep showpass() -->
                            <span class="pw-eye is-hidden" onclick="togglePw(this)">
                                <!-- eye open -->
                                <svg class="icon-eye icon-show" xmlns="http://www.w3.org/2000/svg" width="18"
                                    height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                                <!-- eye off -->
                                <svg class="icon-eye icon-hide" xmlns="http://www.w3.org/2000/svg" width="18"
                                    height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20
                                        c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4
                                    c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </span>
                        </div>

                        <div class="field" style="position:relative">
                            <label>Repeat password<span id="cfpassword_required"> *</span></label>
                            <input type="password" class="jxLAT click_btn_login" name="confirm_pass"
                                value="<?php echo set_value('confirm_pass'); ?>">
                            <span class="pw-eye is-hidden" onclick="togglePw(this)">
                                <!-- eye open -->
                                <svg class="icon-eye icon-show" xmlns="http://www.w3.org/2000/svg" width="18"
                                    height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                                <!-- eye off -->
                                <svg class="icon-eye icon-hide" xmlns="http://www.w3.org/2000/svg" width="18"
                                    height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20
                                        c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4
                                    c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="hint">
                        Password must contain: 8 or up to 30 characters with at least one uppercase, at least one of the
                        allowed
                        special characters listed: _-!@*.$%?&amp;#/|\&gt;^{}[]():;
                    </div>

                    <!-- NAME / ADDRESS / PHONE -->
                    <div class="grid-2">
                        <div class="field">
                            <label>First Name<span id="fname_required"> *</span></label>
                            <input maxlength="255" type="text" class="jxLAT click_btn_login" name="first_name" value="">
                        </div>

                        <div class="field">
                            <label>Last Name<span id="lname_required"> *</span></label>
                            <input maxlength="255" type="text" class="jxLAT click_btn_login" name="last_name" value="">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="field">
                            <label>Address *</label>
                            <input maxlength="255" type="text" class="click_btn_login" name="address" value="">
                        </div>

                        <div class="field field-phone">
                            <label class="label-static">Phone Number *</label>
                            <input id="phone" name="phone" type="tel" class="click_btn_login" />
                        </div>

                    </div>

                    <!-- SOCIAL / WEBSITE -->
                    <div class="grid-2">
                        <div class="field">
                            <label>Skype ID/Linkedin<span id="social_network_required"> *</span></label>
                            <input maxlength="255" type="text" class="jxLAT click_btn_login" name="social_network">
                        </div>

                        <div class="field">
                            <label>Website<span id="website_required"> *</span></label>
                            <input maxlength="255" type="text" class="jxLAT" name="website" value="">
                        </div>
                    </div>

                    <!-- AVATAR / GEO -->
                    <div class="grid-2">
                        <div class="field">
                            <label>Please choose product category: *</label>
                            <select name="product_categories[]" class="selectpicker" data-placeholder="Product Category"
                                data-selected-text-format="count > 2" data-count-selected-text="{0} items selected"
                                multiple>
                                <option value="">None</option>
                                <?php foreach ($p_categories as $pcate): ?>
                                <option value="<?= $pcate->id ?>"><?= $pcate->offercat ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="field">
                            <label>Product Geo *</label>
                            <select class="selectpicker" data-placeholder="Product Geo" data-live-search="true" multiple
                                data-selected-text-format="count > 2" data-count-selected-text="{0} items selected"
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


                    <div class="grid-2">
                        <div class="field">
                            <label>Avatar *(Please use image with 3x4 size)</label>
                            <input type="file" class="jxLAT" name="avatar_url" accept="image/png,image/jpeg,image/jpg"
                                style="padding: 10px 14px; height:48px;">
                            <?php if (!empty($this->mailling['avartar'])): ?>
                            <div style="margin-top:10px">
                                <img src="<?= base_url($this->mailling['avartar']); ?>" alt="avatar preview"
                                    style="height:70px;border-radius:10px;border:1px solid #e5e7eb" />
                            </div>
                            <?php endif; ?>
                            <small style="display:block;margin-top:6px;color:#6b7280">
                                Allowed: JPG/PNG. Max 2MB.
                            </small>
                        </div>
                    </div>
                    <!-- TRAFFIC TYPE -->
                    <div class="section-label">Please choose your traffic type:</div>
                    <div class="check-grid">
                        <?php foreach ($traffic_types as $type): ?>
                        <div class="check-item">
                            <input type="checkbox" name="traffic_source_id[]" value="<?= $type->id ?>"
                                id="<?= $type->id ?>">
                            <label for="<?= $type->id ?>"><?= $type->content ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- ABOUT BUSINESS -->
                    <div class="section-label">About your business:<span class="sc-csuQGl bDzGcN">*</span></div>
                    <div class="field" style="margin-top:0;">
                        <textarea name="how_to_get_traffic"
                            placeholder="Please introduce your business, fill more than 200 characters"
                            class="css-sd33"></textarea>
                    </div>

                    <!-- TERMS -->
                    <div class="check-grid" style="grid-template-columns: 1fr; gap: 10px;">
                        <div class="check-item">
                            <input type="checkbox" name="user_setting[agree_with_term_1]" id="agree_with_term_1"
                                value="1">
                            <label for="agree_with_term_1">
                                I agree with
                                <a class="link" target="_blank" href="<?php // echo base_url('v2/terms'); ?>#">Terms And
                                    Conditions</a>
                            </label>
                        </div>

                        <div class="check-item">
                            <input type="checkbox" value="1" name="user_setting[agree_with_term_2]"
                                id="agree_with_term_2">
                            <label for="agree_with_term_2">
                                I hereby consent and allow the use of my and/or my companys information, including
                                sharing with a third
                                party, to assess, detect, prevent or otherwise enable detection and prevention of
                                malicious, invalid or
                                unlawful activity and/or general fraud prevention.
                            </label>
                        </div>
                    </div>

                    <div class="group-btn">
                        <button type="submit" class="btn_signup">
                            <span class="btn-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                </svg>
                            </span>
                            Create Account
                        </button>

                        <a class="link" href="<?php echo base_url('v2/sign/in'); ?>">Sign In</a>
                    </div>

                </form>
            </div>





            <div class="auth-footer">
                <span>Powered by <a target="_blank" rel="noreferrer" href="http://affise.com">Affise.com</a> 2020</span>
                <span style="margin-left:10px;">
                    <a class="link" href="https://www.linkedin.com/in/biphan-wedebeek/" rel="noreferrer"
                        target="_blank">Our
                        LinkedIn</a>
                    <span style="opacity:.5;margin:0 8px;">•</span>
                    <a class="link" href="https://www.facebook.com/teamwedebeek" rel="noreferrer" target="_blank">Our
                        Facebook</a>
                </span>
            </div>
        </div>


    </div>

    <div class="toast position-fixed" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>

    <script>
    function togglePw(el) {
        var field = el.closest('.field');
        if (!field) return;

        var input = field.querySelector('input[type="password"], input[type="text"]');
        if (!input) return;

        if (input.type === "password") {
            input.type = "text";
            el.classList.remove('is-hidden');
            el.classList.add('is-shown');
        } else {
            input.type = "password";
            el.classList.remove('is-shown');
            el.classList.add('is-hidden');
        }
    }

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
        // init selectpicker (ui only)
        if ($.fn.selectpicker) {
            $('.selectpicker').selectpicker();
        }

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
                processData: false,
                contentType: false,
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