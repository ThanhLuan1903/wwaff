<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Threshold Notification</title>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <div class="header-logo">
                <img src="https://wedebeek.com/temp/default/home_page/image_home/imgae.gif" alt="Wedebeek Logo">
            </div>
            <h1 class="header-title">Payment Threshold Notification</h1>
            <div class="header-icon">🎉</div>
        </div>

        <div class="content">
            <div class="greeting">
                <p>Dear <strong><?php echo htmlspecialchars(isset($username)?$username:''); ?></strong>,</p>
            </div>

            <p class="main-text">
                We would like to inform you that, according to the latest financial report, your
                account balance has successfully reached the minimum payment threshold of <strong>$200.00</strong>.
            </p>

            <div class="report-table-container">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Offer Name</th>
                            <th style="text-align: center;">Conversions</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($approved_offers)): ?>
                            <?php foreach ($approved_offers as $offer): ?>
                                <tr>
                                    <td class="offer-id">#<?php echo htmlspecialchars($offer['offerid']); ?></td>
                                    <td><?php echo htmlspecialchars($offer['offer_name']); ?></td>
                                    <td style="text-align: center;"><?php echo number_format((int)$offer['conversion_count']); ?></td>
                                    <td class="amount-cell">$<?php echo number_format((float)$offer['total_amount'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px; color: #94a3b8;">
                                    No approved conversions found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Total</td>
                            <td style="text-align: center;"><?php echo number_format((int)(isset($total_conversions)?$total_conversions:0)); ?></td>
                            <td class="total-amount">$<?php echo number_format((float)(isset($available)?$available:0), 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <p class="main-text">
                With the current balance, your account is now eligible for withdrawal in accordance
                with our payment policy. Please log in to your account and submit a withdrawal request by following the
                provided instructions.
            </p>

            <p class="main-text">
                If you have any questions regarding your financial report or the withdrawal process,
                please feel free to contact us for further assistance.
            </p>

            <div class="signature">
                <p>Thank you for your continued partnership.</p>
                <p><strong>Best regards,</strong><br>
                    Wedebeek Technology Limited</p>
            </div>
        </div>

        <div class="footer">
            <p class="footer-note">Note: This is an automated notification email. Please do not reply directly to this message.</p>
            <p class="footer-contact">For assistance, contact us at:
                <a href="mailto:support@wedebeek.com">support@wedebeek.com</a>
            </p>

            <div class="footer-divider"></div>

            <p class="footer-copyright">
                © <?php echo date('Y'); ?> Wedebeek Technology Limited. All rights reserved.
            </p>
            <p class="footer-address">41 Khue My Dong 7, Khue My, Ngu Hanh Son, Da Nang, Viet Nam, 50511</p>
        </div>
    </div>
</body>
</html>
