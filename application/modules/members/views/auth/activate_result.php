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
    body {
        margin: 0;
    }

    .left-col {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 0;
    }

    .result-wrap {
        padding: 40px 24px 12px;
    }

    .result-card {
        max-width: 520px;
        margin: 0 auto;
        padding: 8px 8px 0;
    }

    .result-head {
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 10px;
        text-align: center;
    }

    .result-logo {
        width: 110px;
        height: auto;
        object-fit: contain;
    }

    .result-title {
        font-size: 22px;
        font-weight: 600;
        margin: 0;
    }

    .result-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 12px;
        font-weight: 600;
        margin-top: 10px;
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
        margin: 14px auto 0;
        max-width: 460px;
        color: #5c677a;
        line-height: 1.5;
        text-align: center;
    }

    .result-actions {
        margin-top: 18px;
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .result-actions .btn {
        min-width: 150px;
        border-radius: 10px;
        padding: 10px 14px;
        font-weight: 600;
    }

    .bottom-links {
        margin-top: 20px;
        text-align: center;
        padding-bottom: 6px;
    }

    .bottom-links a {
        text-decoration: none;
        font-weight: 500;
    }

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

    .social-row {
        padding: 0 0 10px;
    }

    .right-bg {
        height: 100vh;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }

    .right-bg::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, .06);
    }

    .right-bg {
        position: relative;
        overflow: hidden;
    }
    </style>
</head>

<body>
    <div id="root">
        <div class="sc-eqIVtm jFlzmB">
            <div class="">
                <div class="result-wrap">
                    <div class="result-card">
                        <div class="result-head">
                            <img src="<?php echo base_url(); ?>/upload/files/website_logo_waff.jpeg" class="result-logo"
                                alt="logo">
                            <h1 class="result-title"><?= isset($title) ? $title : 'Result' ?></h1>

                            <?php
                                    $status = isset($status) ? $status : 'info';
                                    $badgeClass = 'badge-info';
                                    $label = 'Info';
                                    if ($status === 'success') { $badgeClass = 'badge-success'; $label = 'Success'; }
                                    elseif ($status === 'error' || $status === 'danger' || $status === 'failed') { $badgeClass = 'badge-danger'; $label = 'Failed'; }
                                ?>

                            <div class="result-badge <?= $badgeClass ?>">
                                <!-- icon -->
                                <?php if ($status === 'success'): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                                <?php elseif ($badgeClass === 'badge-danger'): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                <?php else: ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 16v-4"></path>
                                    <path d="M12 8h.01"></path>
                                </svg>
                                <?php endif; ?>
                                <span><?= $label ?></span>
                            </div>

                            <div class="result-msg">
                                <?= isset($message) ? $message : '' ?>
                            </div>

                            <div class="result-actions">
                                <a href="<?= base_url() ?>">Back to Home</a>
                            </div>

                            <div class="bottom-links">
                                <a class="sc-jKJlTe gPtJgO" target="_blank" href="#">Terms And Conditions</a>
                                <span style="opacity:.5;margin:0 10px;">|</span>
                                <a class="sc-jKJlTe gPtJgO" target="_blank" href="#">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="social-row">
                    <div class="text-center">
                        <a style="color:white" href="#" target="_blank" rel="noopener">
                            <div class="icon-social" style="background-color:rgb(59, 89, 152)">
                                <svg style="width:100%;height:100%">
                                    <use
                                        xlink:href="<?php echo base_url(); ?>/temp/default/images/icon.svg#facebook-icon">
                                    </use>
                                </svg>
                            </div>
                        </a>
                        <a style="color:white" href="#" target="_blank" rel="noopener">
                            <div class="icon-social" style="background-color:rgb(29, 161, 242)">
                                <svg style="width:100%;height:100%">
                                    <use
                                        xlink:href="<?php echo base_url(); ?>/temp/default/images/icon.svg#twitter-icon">
                                    </use>
                                </svg>
                            </div>
                        </a>
                        <a style="color:white" href="#" target="_blank" rel="noopener">
                            <div class="icon-social" style="background-color:rgb(0, 119, 181)">
                                <svg style="width:100%;height:100%">
                                    <use
                                        xlink:href="<?php echo base_url(); ?>/temp/default/images/icon.svg#linkedin-icon">
                                    </use>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <span>Powered by&nbsp;<a href="https://wwaff.com" target="_blank" rel="noopener">wwaff.com</a>&nbsp;2025</span>
    </footer>

    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>/temp/default/js/bootstrap.bundle.min.js"></script>
</body>

</html>