<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Language Mismatch Notice</title>
    <style>
        :root {
            --primary-color: rgb(241, 196, 15);
            --primary-light: rgba(241, 196, 15, 0.08);
            --primary-medium: rgba(241, 196, 15, 0.8);
            --secondary-color: rgba(241, 196, 15, 0.15);
            --text-on-primary: white;
            --border-color: #f6f7b4ff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: rgb(210, 212, 221);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .notification-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
            background-color: white;
            overflow: hidden;
        }

        .notification-header {
            background-color: var(--primary-color);
            color: var(--text-on-primary);
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-image: linear-gradient(to right, var(--primary-color), rgb(251, 206, 25));
        }

        .notification-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 500;
        }

        .notification-content {
            padding: 15px 20px;
            color: #444;
            line-height: 1.5;
            position: relative;
            background-image: linear-gradient(to bottom right, rgba(241, 196, 15, 0.03), rgba(255, 255, 255, 0.9));
        }

        .offer-list {
            margin: 15px 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .offer-item {
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background-color: white;
            transition: all 0.2s;
            position: relative;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .offer-item::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: var(--primary-color);
        }

        .offer-item:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .offer-details {
            margin-bottom: 10px;
        }

        .offer-name {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .offer-id {
            color: #666;
            font-size: 14px;
        }

        .offer-action {
            display: flex;
            justify-content: flex-end;
            border-top: 1px solid #eee;
            padding-top: 10px;
            margin-top: 5px;
        }

        .run-btn {
            background-color: var(--primary-color);
            color: var(--text-on-primary);
            border: none;
            border-radius: 4px;
            padding: 6px 16px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .run-btn:hover {
            background-color: var(--primary-medium);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }

        @media (max-width: 640px) {
            .notification-container {
                margin: 10px;
                width: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Notification container -->
    <div class="notification-container" id="languageMismatchNotification">
        <!-- Notification header -->
        <div class="notification-header">
            <h3>User Mismatch Detected</h3>
        </div>

        <!-- Notification content -->
        <div class="notification-content">
            <p>We detected that you are using the wrong advertiser's target audience.
                <?php if ($soff) echo "Here are some offers that you may be interested in:";
                else echo "Please try again with another user!"; ?></p>

            <div class="offer-list">
                <?php
                if (isset($soff)) {
                    foreach ($soff as $off) {
                        echo '<div class="offer-item">
                                <div class="offer-details">
                                    <div class="offer-name" style="font-size:15px">' . htmlspecialchars($off->title) . '</div>
                                    <div class="offer-id">Offer ID: ' . htmlspecialchars($off->id) . '</div>
                                </div>
                                <div class="offer-action">
                                    <button class="run-btn" onclick="runCampaign(\'' . $off->id . '\')">Run Campaign</button>
                                </div>
                            </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        var base_url = "<?php echo base_url() ?>";

        function runCampaign(offerId) {
            var publisher_id = "<?php echo $pid; ?>";
            var trackingUrl = base_url + "click?pid=" + publisher_id + "&offer_id=" + offerId;

            window.location.href = trackingUrl;
        }
    </script>
</body>

</html>