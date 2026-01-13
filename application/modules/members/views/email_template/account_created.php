<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Created</title>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #fff;
        color: #333;
        line-height: 1.6;
        font-size: 16px;
    }

    .background {
        background: rgba(244, 244, 244);
        width: 1000px;
        margin: 0 auto;
        padding: 30px 0;
        border-radius: 12px;
    }

    .email-container {
        max-width: 650px;
        margin: 20px auto;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .1);
    }

    .email-header-image {
        width: 100%;
        height: 200px;
        display: block;
        max-width: 100%;
    }

    .content {
        padding: 30px;
    }

    h2 {
        margin-bottom: 13px;
        color: #154272;
        font-weight: 600;
        font-size: 20px;
    }

    p {
        margin-bottom: 8px;
        font-size: 16px;
        color: #444;
    }

    strong {
        font-weight: 600;
        color: #154272;
    }

    .btn-wwaff {
        display: block;
        width: 50%;
        margin: 35px auto;
        padding: 16px 20px;
        text-align: center;
        border-radius: 999px;
        background: #FFDF00;
        color: #000;
        font-size: 18px;
        border: 1px solid #4a4a4a;
        padding: 12px 16px;
        font-weight: 700;
        font-size: 18px;
        box-shadow: 0 4px 8px rgba(21, 66, 114, 0.3);
    }

    .signature {
        margin: 25px 0;
    }

    .team-name {
        font-weight: 600;
        color: #154272;
        font-size: 17px;
    }

    .logo-section {
        text-align: center;
        padding: 10px 0 15px;
    }

    .company-logo-container {
        margin: 0 auto;
        width: 100px;
        max-width: 90%;
    }

    .company-logo-container img {
        width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    .footer {
        text-align: center;
        padding: 25px 20px 30px;
        background: #fff;
    }

    .footer-info {
        margin: 0 auto;
        max-width: 80%;
    }

    .copyright,
    .contact-info {
        font-size: 14px;
        color: #444;
        margin: 6px 0;
    }

    .contact-info a {
        color: #154272;
        text-decoration: none;
        font-weight: 500;
    }

    @media screen and (max-width:600px) {
        .email-container {
            width: 100%;
            margin: 0;
            border-radius: 0;
        }

        .content {
            padding: 25px;
        }

        .btn-wwaff {
            width: 100%;
        }

        .background {
            width: 100%;
            border-radius: 0;
        }

        .field-label {
            min-width: auto;
        }
    }
    </style>
</head>

<body>
    <div class="background">
        <div class="email-container">

            <a href="<?= base_url(); ?>">
                <img src="https://i.postimg.cc/htmFx1kX/Screenshot-2026-01-12-212505.png" alt="Wwaff Header"
                    class="email-header-image">
            </a>

            <div class="content">
                <?php
                $name     = isset($name) ? $name : 'Partner';
                $email    = isset($email) ? $email : '';
                $password = isset($password) ? $password : '';
                $reset_link = function_exists('base_url') ? base_url('v2/sign/password/reset') : 'v2/sign/password/reset';
              ?>

                <h2>Dear <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>,</h2>

                <p>✅ Your <strong>Worldwide Affiliate</strong> account has been created successfully.</p>
                <p>You can reset your dashboard using the information below:</p>
                <div class="field-row">
                    <span class="field-label">Username:</span>
                    <span class="field-value"><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <a href="<?= $reset_link; ?>" class="btn-wwaff" style="
     color:#000 !important;
     text-decoration:none !important;
     display:block;
   ">
                    Reset password
                </a>
                <p class="pw-help">
                    For security, we recommend changing your password after your first login.
                </p>

                <div class="signature">
                    <p>We look forward to a mutually successful partnership!</p>
                    <p>Best regards,</p>
                    <p class="team-name">Worldwide Affiliate Team</p>
                </div>
            </div>

            <div class="logo-section">
                <div class="company-logo-container">
                    <img src="https://i.postimg.cc/5yXKJx1Q/logo.png" alt="Worldwide Affiliate Logo">
                </div>
            </div>

            <div class="footer">
                <div class="footer-info">
                    <p class="copyright">&copy; 2021 Worldwide Affiliate, Inc. All rights reserved.</p>
                    <p class="contact-info">
                        Have any questions? Email us <a href="mailto:support@wwaff.com">support@wwaff.com</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</body>

</html>