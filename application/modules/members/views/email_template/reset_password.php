<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background-color: white;
        color: #333;
        line-height: 1.6;
        font-size: 16px;
    }

    .background {
        background-color: rgba(244, 244, 244);
        width: 1000px;
        margin-left: auto;
        margin-right: auto;
        padding-top: 30px;
        padding-bottom: 30px;
        border-radius: 12px;
    }

    /* Main container */
    .email-container {
        max-width: 650px;
        margin: 20px auto;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
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
        margin-bottom: 5px;
        font-size: 16px;
        color: #444;
    }

    strong {
        font-weight: 600;
        color: #154272;
    }

    /* Signature */
    .signature {
        margin: 25px 0;
    }

    .team-name {
        font-weight: 600;
        color: #154272;
        font-size: 17px;
    }

    /* Logo section */
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

    /* Footer section */
    .footer {
        text-align: center;
        padding: 25px 20px 30px;
        background-color: #ffffff;
    }

    .footer-info {
        margin: 0 auto;
        max-width: 80%;
    }

    .copyright {
        font-size: 14px;
        color: #444;
        margin: 6px 0;
    }

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

    .footer-links {
        margin-top: 6px;
    }

    .footer-links a {
        color: #154272;
        text-decoration: none;
        font-weight: 500;
    }

    /* Responsive design */
    @media screen and (max-width: 600px) {
        .email-container {
            width: 100%;
            margin: 0;
            border-radius: 0;
        }

        .content {
            padding: 25px;
        }

        .company-logo-container {
            width: 250px;
        }

        .footer-info {
            max-width: 100%;
        }
    }

    .info-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 15px 18px;
        margin: 15px 0;
    }

    .info-row {
        margin-bottom: 6px;
        font-size: 15px;
    }

    .info-row strong {
        color: #154272;
        font-weight: 600;
    }

    .warning {
        margin-top: 15px;
        font-size: 14px;
        color: #b91c1c;
    }
    </style>
</head>

<body>
    <div class="background">
        <div class="email-container">

            <!-- Header -->
            <a href="<?= base_url(); ?>">
                <img src="https://i.postimg.cc/htmFx1kX/Screenshot-2026-01-12-212505.png" alt="Wwaff Header"
                    class="email-header-image">
            </a>

            <!-- Content -->
            <div class="content">
                <h2>Dear <?= htmlspecialchars($firstname . ' ' . $lastname); ?>,</h2>

                <p>
                    As requested, your password for <strong><?= htmlspecialchars($sitename); ?></strong> has been
                    successfully reset.
                </p>

                <p>Please find your new login details below:</p>

                <div class="info-box">
                    <div class="info-row">
                        <strong>Email:</strong> <?= htmlspecialchars($email); ?>
                    </div>
                    <div class="info-row">
                        <strong>New Password:</strong> <?= htmlspecialchars($password); ?>
                    </div>
                </div>

                <p class="warning">
                    ⚠ For security reasons, please log in and change this password immediately.
                </p>

                <div class="signature">
                    <p>We look forward to a mutually successful partnership!</p>
                    <p>Best regards,</p>
                    <p class="team-name">Worldwide Affiliate Team</p>
                </div>
            </div>

            <!-- Logo section with proper container -->
            <div class="logo-section">
                <div class="company-logo-container">
                    <img src="https://i.postimg.cc/5yXKJx1Q/logo.png" alt="Worldwide Affiliate Logo">
                </div>
            </div>

            <div class="footer">
                <div class="footer-info">
                    <p class="copyright">&copy; 2021 Worldwide Affiliate, Inc. All rights reserved.</p>
                    <p class="contact-info">Have any questions? Email us <a
                            href="mailto:support@wwaff.com">support@wwaff.com</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>