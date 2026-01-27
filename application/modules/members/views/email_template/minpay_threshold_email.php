<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            font-size: 15px;
            color: #353c46;
            margin: 0;
            padding: 0;
            background-color: #F8FAFC;
        }

        .email-container {
            max-width: 700px;
            margin: 30px auto;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #f5f5f5;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #5bef91 0%, #2d82d6 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
        }

        .header-logo {
            width: 200px;
            max-height: 50px;
        }

        .header-logo img {
            height: 45px;
            vertical-align: middle;
        }

        .header-icon {
            font-size: 40px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .content {
            padding: 20px 40px;
        }

        .greeting p {
            margin: 0;
        }

        .main-text {
            line-height: 1.7;
            margin: 10px 0;
        }

        .report-table-container {
            margin: 25px 0;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
        }

        .report-table thead {
            background: linear-gradient(135deg, #5bef91 0%, #2d82d6 100%);
            color: #ffffff;
        }

        .report-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            border-bottom: 2px solid #22c55e;
        }

        .report-table th:last-child,
        .report-table td:last-child {
            text-align: right;
        }

        .report-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }

        .report-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .report-table td {
            padding: 12px;
            font-size: 14px;
            color: #475569;
        }

        .report-table tfoot {
            background-color: #f8fafc;
            border-top: 2px solid #22c55e;
        }

        .report-table tfoot td {
            padding: 14px 12px;
            font-weight: bold;
            font-size: 15px;
            color: #1e293b;
        }

        .amount-cell {
            color: #22c55e;
            font-weight: 600;
        }

        .total-amount {
            color: #16a34a;
            font-size: 18px;
        }

        .signature {
            margin-top: 25px;
            line-height: 1.7;
        }

        .footer {
            padding: 30px 35px;
            border-top: 1px solid #e2e8f0;
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
        }

        .footer-note {
            font-weight: 600;
            color: #475569;
            margin-bottom: 12px;
        }

        .footer-contact {
            margin: 12px 0;
        }

        .footer-divider {
            height: 1px;
            margin: 20px 0;
        }

        .footer-copyright {
            text-align: center;
            color: #53718f;
            margin-bottom: 8px;
        }

        .footer-address {
            text-align: center;
            color: #53718f;
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .offer-id {
            color: #64748b;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <div class="header-logo">
                <a href="<?= base_url(); ?>">
                    <img src="https://i.postimg.cc/5yXKJx1Q/logo.pngg" alt="Wwaff Logo">
                </a>            
            </div>
            <h1 class="header-title">Payment Threshold Notification</h1>
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
                    Worldwide Affiliate</p>
            </div>
        </div>

        <div class="footer">
            <p class="footer-note">Note: This is an automated notification email. Please do not reply directly to this message.</p>
                <?php if (!empty($manager)): ?>
                    <?php
                        $m_username = is_array($manager) ? ($manager['username'] ?? '') : ($manager->username ?? '');
                        $m_aim      = is_array($manager) ? ($manager['aim'] ?? '')      : ($manager->aim ?? '');
                        $m_skype    = is_array($manager) ? ($manager['skype'] ?? '')    : ($manager->skype ?? '');

                        $parts = [];
                        if ($m_aim !== '')   $parts[] = 'Teams ' . htmlspecialchars($m_aim, ENT_QUOTES, 'UTF-8');
                        if ($m_skype !== '') $parts[] = 'Skype ' . htmlspecialchars($m_skype, ENT_QUOTES, 'UTF-8');
                    ?>

                    <p class="footer-contact">
                        For assistance, contact your personal manager<?= $m_username ? ' (' . htmlspecialchars($m_username, ENT_QUOTES, 'UTF-8') . ')' : '' ?>:
                        <?= $parts ? implode(' or ', $parts) : 'please contact support.'; ?>
                    </p>
                <?php endif; ?>


            <div class="footer-divider"></div>

            <p class="footer-copyright">
                © <?php echo date('Y'); ?> Wedebeek Technology Limited. All rights reserved.
            </p>
            <p class="footer-address">41 Khue My Dong 7, Khue My, Ngu Hanh Son, Da Nang, Viet Nam, 50511</p>
        </div>
    </div>
</body>
</html>
