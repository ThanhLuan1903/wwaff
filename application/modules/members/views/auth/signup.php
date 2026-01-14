<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Authorization</title>

    <meta property="og:image" content="<?php echo base_url(); ?>/upload/files/website_logo_waff.jpeg">
    <link rel="icon" href="<?php echo base_url(); ?>/upload/files/website_logo_waff.jpeg">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
        integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">
    <script src="<?php echo base_url(); ?>/temp/default/js/multiple/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"
        integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
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
        /* max-width: 760px; */
        /* đăng ký nhiều field -> rộng hơn login */
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
        font-weight: 800;
        color: #154272;
        margin-bottom: 6px;
    }

    .auth-subtitle {
        text-align: center;
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 14px;
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

    /* ===== Form blocks ===== */
    .section-label {
        font-size: 14px;
        color: #374151;
        margin: 8px 0 10px;
        font-weight: 600;
    }

    .role-row {
        padding-left: 20px;
        display: flex;
        gap: 48px;
        align-items: center;
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

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    @media (max-width: 640px) {
        .grid-2 {
            grid-template-columns: 1fr;
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

    .hint {
        margin-top: 8px;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.4;
    }

    .textarea {
        min-height: 110px;
        padding: 14px;
        resize: vertical;
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


    .bootstrap-select .dropdown-toggle {
        height: 48px !important;
        border-radius: 10px !important;
        border: 1px solid rgba(0, 0, 0, .14) !important;
        background: #fff !important;
        color: #22324a !important;
        padding: 12px 14px !important;
        overflow: hidden !important;
        white-space: nowrap !important;
    }

    .bootstrap-select .dropdown-toggle .filter-option {
        max-height: 24px !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
        line-height: 24px !important;
    }

    .bootstrap-select .dropdown-toggle .filter-option-inner {
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    .bootstrap-select .dropdown-toggle .filter-option-inner-inner {
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    .bootstrap-select .dropdown-toggle:focus {
        border-color: #154272 !important;
        box-shadow: 0 0 0 4px rgba(21, 66, 114, .12) !important;
    }

    .dropdown.bootstrap-select {
        width: 100% !important;
    }

    /* CTA */
    .btn-wrapper {
        display: flex;
        justify-content: center;
    }

    .btn-signin {
        width: 100%;
        margin: 14px 0 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        border: none;
        border-radius: 999px;
        background: #FFDF00;
        color: #000;
        font-size: 16px;
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

    .bottom-links {
        margin-top: 10px;
        display: flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .link {
        color: #154272;
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
    }

    .link:hover {
        text-decoration: underline;
    }

    .check-row {
        display: grid;
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

    .check-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px 8px;
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

    /* Toast */
    .toast-wrap {
        position: fixed;
        top: 18px;
        left: 18px;
        z-index: 9999;
        width: 360px;
        max-width: calc(100vw - 36px);
    }

    /* Phone input to match */
    #phone {
        height: 48px;
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, .14);
        padding: 16px 14px 12px;
    }

    .iti {
        width: 100%;
    }

    .group-btn {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0px 120px;
    }

    @media (max-width: 640px) {
        .check-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .group-btn {
            padding: 0px;
        }

        .auth-shell {
            min-height: calc(100vh - 56px);
            padding: 6px;
            width: 90%;
        }
    }

    @media (max-width: 320px) {
        .check-grid {
            grid-template-columns: 1fr;
        }

        .group-btn {
            padding: 0px;
        }
    }
    </style>
</head>

<body>
    <div class="auth-page">

        <div class="auth-shell">
            <div class="auth-card">

                <img src="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png" class="auth-logo"
                    alt="Logo">
                <div class="auth-title">Worldwide Affiliate</div>
                <div class="auth-subtitle">Create your account</div>

                <!-- ===== FORM: giữ nguyên name/value logic ===== -->
                <form class="sc-kpOJdX kFPdwr" enctype="multipart/form-data">
                    <input type="hidden" name="ref_pub_token" value="" />

                    <!-- Account type -->
                    <div class="section-label">
                        Please choose your account type: <span class="sc-csuQGl bDzGcN">*</span>
                    </div>

                    <div class="role-row">
                        <label class="role-option" for="flexRadioDefault1">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" value="Persional"
                                id="flexRadioDefault1">
                            Personal
                        </label>

                        <label class="role-option" for="flexRadioDefault2">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" value="Company"
                                id="flexRadioDefault2" checked>
                            Company
                        </label>
                    </div>

                    <!-- TOP: Username / Email -->
                    <div class="grid-2">
                        <div class="field" id="username">
                            <label>Username<span id="username_required"> *</span></label>
                            <input type="text" class="click_btn_login" name="mailling[username]" value="">
                        </div>

                        <div class="field">
                            <label>Email<span id="email_required"> *</span></label>
                            <input type="email" class="click_btn_login" name="email"
                                value="<?php echo set_value('email'); ?>">
                        </div>
                    </div>

                    <!-- Password / Repeat -->
                    <div class="grid-2">
                        <div class="field" style="position:relative">
                            <label>Password<span id="password_required"> *</span></label>
                            <input type="password" id="password" class="click_btn_login" name="password"
                                value="<?php echo set_value('password'); ?>">

                            <!-- Eye icon (giữ showpass) -->
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
                            <label>Repeat password<span id="cfpassword_required"></span></label>
                            <input type="password" class="click_btn_login" name="confirm_pass"
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
                        Password must contain: 6 or up to 30 characters with at least one uppercase, at least one
                        lowercase, at least one numeric digit, at least one of the allowed special characters
                        listed:
                        _-!@*.$%?&amp;#/|\&gt;^{}[]():;
                    </div>

                    <!-- Name -->
                    <div class="grid-2">
                        <div class="field">
                            <label>First Name<span id="fname_required"> *</span></label>
                            <input maxlength="255" type="text" class="click_btn_login" name="mailling[firstname]"
                                value="<?php if (!empty($this->mailling['firstname'])) echo $this->mailling['firstname']; ?>">
                        </div>

                        <div class="field">
                            <label>Last Name<span id="lname_required"> *</span></label>
                            <input maxlength="255" type="text" class="click_btn_login" name="mailling[lastname]"
                                value="<?php if (!empty($this->mailling['lastname'])) echo $this->mailling['lastname']; ?>">
                        </div>
                    </div>

                    <!-- Address / Phone -->
                    <div class="grid-2">
                        <div class="field">
                            <label>Address *</label>
                            <input type="text" class="click_btn_login" name="mailling[ad]" data-placeholder="Address" />
                        </div>

                        <div class="field">
                            <label>Phone Number *</label>
                            <input id="phone" class="click_btn_login" name="phone" type="tel" />
                        </div>
                    </div>

                    <!-- Social / Website -->
                    <div class="grid-2">
                        <div class="field">
                            <label>Skype ID/Linkedin<span id="social_network_required"> *</span></label>
                            <input maxlength="255" type="text" class="click_btn_login" name="mailling[im_service]"
                                value="<?php if (!empty($this->mailling['im_service'])) echo $this->mailling['im_service']; ?>">
                        </div>

                        <div class="field">
                            <label>Website<span id="website_required"> *</span></label>
                            <input maxlength="255" type="text" class="click_btn_login" name="mailling[website]"
                                value="<?php if (!empty($this->mailling['website'])) echo $this->mailling['website']; ?>">
                        </div>
                    </div>

                    <!-- Product categories / geo -->
                    <div class="grid-2" style="margin-top:10px">
                        <div class="field">
                            <label
                                style="position:static;transform:none;background:transparent;padding:0;margin-bottom:6px;display:block;color:#374151;font-weight:600;font-size:14px">
                                Product Categories *
                            </label>
                            <select name="product_category[]" class="selectpicker" multiple
                                data-selected-text-format="count > 2" data-count-selected-text="{0} items selected"
                                data-placeholder="Product Category">
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= $category->offercat ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="field">
                            <label
                                style="position:static;transform:none;background:transparent;padding:0;margin-bottom:6px;display:block;color:#374151;font-weight:600;font-size:14px">
                                Product Geo *
                            </label>
                            <select class="selectpicker" data-live-search="true" multiple name="product_geo[]"
                                data-placeholder="Product Geo" data-selected-text-format="count > 2"
                                data-count-selected-text="{0} items selected">
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

                    <!-- Product type / Volume -->
                    <div class="grid-2" style="margin-top:10px">
                        <div class="field">
                            <label
                                style="position:static;transform:none;background:transparent;padding:0;margin-bottom:6px;display:block;color:#374151;font-weight:600;font-size:14px">
                                Product type *
                            </label>
                            <select name="conversion_flow[]" class="selectpicker" multiple
                                data-selected-text-format="count > 2" data-count-selected-text="{0} items selected"
                                data-placeholder="Product type">
                                <?php foreach ($offer_types as $offer_type): ?>
                                <option value="<?= $offer_type->id ?>"><?= $offer_type->type ?></option>
                                <?php endforeach ?>
                            </select>

                        </div>

                        <div class="field">
                            <label>Volume (Monthly) *</label>
                            <input type="number" name="mailling[volume]" class="click_btn_login" min="1" step="1"
                                required />
                        </div>
                    </div>

                    <!-- Traffic device / Avatar -->
                    <div class="grid-2" style="margin-top:10px">
                        <div class="field">
                            <div class="section-label" style="margin:0 0 6px">
                                Traffic Device *
                            </div>

                            <?php $traffic_devices = $this->Home_model->get_data('device', ['show' => 1]); ?>
                            <select name="traffic_device[]" class="selectpicker" multiple title="Traffic Device"
                                data-placeholder="Traffic Device" data-selected-text-format="count > 2"
                                data-count-selected-text="{0} items selected">
                                <?php foreach ($traffic_devices as $traffic_device): ?>
                                <option value="<?= $traffic_device->id ?>"><?= $traffic_device->device ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="field">
                            <label
                                style="position:static;transform:none;background:transparent;padding:0;margin-bottom:6px;display:block;color:#374151;font-weight:600;font-size:14px">
                                Avatar * (Please use image with 3x4 size)
                            </label>
                            <input type="file" class="click_btn_login" name="avatar_url"
                                accept="image/png,image/jpeg,image/jpg" style="padding: 10px 14px; height:48px;">

                            <?php if (!empty($this->mailling['avartar'])): ?>
                            <div style="margin-top:8px">
                                <img src="<?= base_url($this->mailling['avartar']); ?>" alt="avatar preview"
                                    style="height:70px;border-radius:8px;border:1px solid #e5e7eb" />
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Traffic type -->
                    <div class="section-label" style="margin-top:14px">
                        Please choose your traffic type:*
                    </div>
                    <div class="check-row check-grid">
                        <?php foreach ($trafficTypes as $type): ?>
                        <div class="check-item">
                            <input type="checkbox" name="aff_type[]" value="<?= $type->content ?>"
                                id="<?= $type->id ?>">
                            <label for="<?= $type->id ?>"><?= $type->content ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>


                    <!-- About business -->
                    <div class="section-label" style="margin-top:14px">
                        About your business:<span class="sc-csuQGl bDzGcN">*</span>
                    </div>
                    <div class="field">
                        <textarea name="mailling[hear_about]" class="textarea"
                            placeholder="Please introduce your business, fill more than 200 characters"
                            maxlength="300"></textarea>
                    </div>

                    <!-- Terms -->
                    <div class="check-row" style="margin-top:14px">
                        <div class="check-item">
                            <input class="" type="checkbox" name="mailling[terms]" id="1sftljo7ebto" value="1">
                            <label for="1sftljo7ebto">
                                I agree with
                                <a class="sc-jWBwVP bBsnzv" target="_blank" href="#">Terms And Conditions</a>
                            </label>
                        </div>

                        <div class="check-item">
                            <input class="" type="checkbox" name="57l2dbmlifn" id="57l2dbmlifn">
                            <label for="57l2dbmlifn">
                                I hereby consent and allow the use of my and/or my companys information, including
                                sharing with a third party,
                                to assess, detect, prevent or otherwise enable detection and prevention of
                                malicious, invalid or unlawful activity
                                and/or general fraud prevention.
                            </label>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="group-btn">

                        <div class="btn-wrapper">
                            <!-- giữ class btn_signup để JS bắt -->
                            <button type="submit" class="btn-signin btn_signup">
                                <span class="btn-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                </span>
                                Create Account
                            </button>
                        </div>

                        <div class="bottom-links">
                            <a class="link" href="<?php echo base_url('v2/sign/in'); ?>">Sign In</a>
                        </div>
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


        <!-- Toasts (giữ id/structure để JS show) -->
        <div class="toast-wrap">
            <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">
                <div class="toast-body d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-exclamation-triangle-fill flex-shrink-0" viewBox="0 0 16 16" role="img"
                        aria-label="Warning:">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                    <span class="toastContent">Successfully edited profile</span>
                </div>
            </div>

            <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao2">
                <div class="toast-body bg-danger text-white">
                    <span class="toastContent">Successfully edited profile</span>
                </div>
            </div>
        </div>

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



    $(document).ready(function() {

        // ===== Floating label effect (thay cho span_ip cũ) =====
        // (Không ảnh hưởng logic submit)
        $('.field input, .field textarea').each(function() {
            var $field = $(this).closest('.field');
            if ($(this).val()) $field.addClass('is-active');
        });

        $(document).on('focus', '.field input, .field textarea', function() {
            $(this).closest('.field').addClass('is-active');
        });

        $(document).on('blur', '.field input, .field textarea', function() {
            var $field = $(this).closest('.field');
            if ($(this).val()) $field.addClass('is-active');
            else $field.removeClass('is-active');
        });

        // ===== intl-tel-input: init 1 lần (bản cũ bị init lặp) =====
        var input = document.querySelector("#phone");
        if (input && window.intlTelInput) {
            var iti = window.intlTelInput(input, {
                separateDialCode: true,
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js"
            });

            input.addEventListener("countrychange", function() {
                var countryData = iti.getSelectedCountryData();
                var dialCode = "+" + countryData.dialCode;
                document.getElementById("phone").value = dialCode;
            });
        }

        // ===== bootstrap-select refresh =====
        if ($.fn.selectpicker) {
            $('.selectpicker').selectpicker();
        }

        // ===== Required fields logic (GIỮ NGUYÊN) =====
        const company_field_required = ['username', 'email', 'password', 'cfpassword', 'website', 'fname',
            'lname', 'social_network'
        ];
        const persional_field_required = ['username', 'email', 'password', 'cfpassword', 'fname', 'lname'];
        const field_required = Array.from(new Set(company_field_required.concat(persional_field_required)));

        function resetFieldRequired() {
            field_required.forEach((key) => {
                $('#' + key + '_required').html('');
            });
        }

        $('#flexRadioDefault2').on('click', function(e) {
            resetFieldRequired();
            company_field_required.forEach((key) => {
                $('#' + key + '_required').html(' *');
            });
        });

        $('#flexRadioDefault1').on('click', function(e) {
            resetFieldRequired();
            persional_field_required.forEach((key) => {
                $('#' + key + '_required').html(' *');
            });
        });

        // ===== Ref token from query string (GIỮ NGUYÊN) =====
        const queryString = getQueryString();
        if (queryString && queryString.ref) {
            $('input[name="ref_pub_token"]').val(queryString.ref);
        }

        // ===== Submit ajax (GIỮ NGUYÊN: btn_signup + FormData) =====
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
                processData: false,
                contentType: false,
                success: ajaxSuccess,
                error: ajaxErr
            });
        });
    });

    function ajaxErr() {
        alert('Network Error!');
    }

    function ajaxSuccess(data) {
        const obj = JSON.parse(data);
        if (obj.error == 0) {
            $('.toastContent').html(obj.data);
            var myAlert = document.getElementById('thongBao');
            var bsAlert = new bootstrap.Toast(myAlert, {
                animation: true,
                delay: 10000,
                autohide: true
            });
            bsAlert.show();
            setTimeout(() => {
                window.location.href = "<?php echo base_url('v2'); ?>";
            }, 10000);
        } else {
            $('.toastContent').html(obj.data);
            $('.btn_signup').attr('disabled', false);
            var myAlert2 = document.getElementById('thongBao2');
            var bsAlert2 = new bootstrap.Toast(myAlert2, option);
            bsAlert2.show();
        }
    }

    var option = {
        animation: true,
        delay: 5000,
        autohide: true
    };

    function getQueryString() {
        var queryString = window.location.search;
        if (!queryString) return null;
        queryString = queryString.slice(1);
        var queryParams = {};
        queryString.split('&').forEach(function(param) {
            var keyValue = param.split('=');
            var key = decodeURIComponent(keyValue[0]);
            var value = decodeURIComponent(keyValue[1] || '');
            queryParams[key] = value;
        });
        return queryParams;
    }
    </script>
</body>

</html>