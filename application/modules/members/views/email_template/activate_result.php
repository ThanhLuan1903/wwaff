<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <meta property="og:image" content="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png">
    <link rel="icon" href="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png">
    <title><?= isset($title) ? $title : 'Active Result' ?></title>

    <link href="<?php echo base_url(); ?>temp/default/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>temp/default/css/newlogin.css?time=<?php echo time(); ?>" rel="stylesheet">

    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        background: #f3f5f7;
        color: #203040;
        min-height: 100vh;
    }

    /* ===== Page layout (match login) ===== */
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

    /* Left column */
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
        padding: 22px 22px 18px;
    }

    /* Right image (match login) */
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

    /* Hide image on tablet down */
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

    /* ===== Result UI ===== */
    .result-head {
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 10px;
        text-align: center;
        margin-bottom: 6px;
    }

    .result-logo {
        width: 82px;
        height: 82px;
        object-fit: contain;
        display: block;
        margin: 0 auto 2px;
    }

    .result-title {
        font-size: 22px;
        font-weight: 800;
        color: #154272;
        margin: 0;
    }

    .result-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 12px;
        font-weight: 700;
        margin-top: 6px;
    }

    .badge-success {
        background: rgba(25, 135, 84, .12);
        color: #198754;
    }

    .badge-info {
        background: rgba(13, 202, 240, .12);
        color: #0dcaf0;
    }

    .badge-danger {
        background: rgba(220, 53, 69, .12);
        color: #dc3545;
    }

    .result-msg {
        margin: 12px auto 0;
        max-width: 460px;
        color: #5c677a;
        line-height: 1.55;
        text-align: center;
        font-size: 15px;
    }

    .result-actions {
        margin-top: 16px;
        display: flex;
        justify-content: center;
    }

    .btn-home {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        border-radius: 999px;
        background: #FFDF00;
        color: #000;
        font-size: 16px;
        border: 1px solid #4a4a4a;
        padding: 10px 16px;
        font-weight: 650;
        text-decoration: none;
        box-shadow: 0 8px 16px rgba(21, 66, 114, .18);
        transition: all .15s ease;
        min-width: 220px;
    }

    .btn-home:hover {
        background: #f2d600;
        transform: translateY(-1px);
        text-decoration: none;
        color: #000;
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
        display: block;
    }

    .policy-row {
        margin-top: 14px;
        display: flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
        font-size: 13px;
    }

    .policy-row a {
        color: #154272;
        text-decoration: none;
        font-weight: 600;
    }

    .policy-row a:hover {
        text-decoration: underline;
    }

    /* Social (match login) */
    .social-row {
        margin-top: 14px;
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
    </style>
</head>

<body>
    <div class="auth-page">
        <div class="auth-shell">

            <!-- LEFT -->
            <div class="auth-left">
                <div class="auth-card">

                    <?php
                    $status = isset($status) ? $status : 'info';
                    $badgeClass = 'badge-info';
                    $label = 'Info';
                    if ($status === 'success') { $badgeClass = 'badge-success'; $label = 'Success'; }
                    elseif ($status === 'error' || $status === 'danger' || $status === 'failed') { $badgeClass = 'badge-danger'; $label = 'Failed'; }
                ?>

                    <div class="result-head">
                        <img src="<?php echo base_url(); ?>/upload/files/website_logo_waff.jpeg" class="result-logo"
                            alt="logo">
                        <h1 class="result-title"><?= isset($title) ? $title : 'Result' ?></h1>

                        <div class="result-msg">
                            <?= isset($message) ? $message : '' ?>
                        </div>

                        <div class="result-actions">
                            <a class="btn-home" href="<?= base_url() ?>">
                                <span class="btn-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <line x1="19" y1="12" x2="5" y2="12"></line>
                                        <polyline points="12 19 5 12 12 5"></polyline>
                                    </svg>
                                </span>
                                <span>Back to Home</span>
                            </a>
                        </div>

                        <div class="policy-row">
                            <a target="_blank" href="#">Terms And Conditions</a>
                            <a target="_blank" href="#">Privacy Policy</a>
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

                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="auth-right" style="background-image:url('https://i.imgur.com/7PTAFH9.jpg');"></div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.bundle.min.js"></script>
</body>

</html>