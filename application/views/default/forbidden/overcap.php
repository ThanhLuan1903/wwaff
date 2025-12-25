<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .notification-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }
        .notification-detail {
            background-color: #fef9c3;
            color: #713f12;
            padding: 28px 32px;
            border-radius: 8px;
            border-left: 4px solid #eab308;
            box-shadow: 0 8px 32px rgba(234, 179, 8, 0.2), 0 2px 8px rgba(0, 0, 0, 0.08);
            max-width: 480px;
            width: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            position: relative;
        }
        .notification-detail::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60px;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
        }
        .notification-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }
        .notification-icon {
            width: 24px;
            height: 24px;
            opacity: 0.9;
            color: #a16207;
        }
        .notification-title {
            font-weight: 600;
            font-size: 16px;
            color: #a16207;
            margin: 0;
        }
        .notification-message {
            font-size: 15px;
            color: #b45309;
            margin-bottom: 20px;
            font-weight: 400;
        }
        .time-highlight {
            color: #92400e;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.6);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 14px;
        }
        .contact-info {
            font-size: 13px;
            color: #ca8a04;
            opacity: 0.9;
            border-top: 1px solid rgba(161, 98, 7, 0.2);
            padding-top: 16px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="notification-container">
        <div class="notification-detail">
            <div class="notification-header">
                <svg class="notification-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1L9 7V9C9 10.1 9.9 11 11 11V16L8 19V21H16V19L13 16V11C14.1 11 15 10.1 15 9H21ZM12 8C11.4 8 11 7.6 11 7S11.4 6 12 6S13 6.4 13 7S12.6 8 12 8Z"/>
                    <circle cx="12" cy="4" r="1.5" fill="#eab308"/>
                    <path d="M12 6.5L10.5 8H13.5L12 6.5Z" fill="#eab308"/>
                </svg>
                <h4 class="notification-title">Offer Capped</h4>
            </div>
            <div class="notification-message">
                You have reached the limit <?php echo isset($month) ? "monthly cap. Try again starting from <span class='time-highlight'>12:00 AM (GMT - 5)</span>  on the first day of next month" : "daily cap. Try again tomorrow at <span class='time-highlight'>12:00 AM (GMT - 5)</span>"; ?>.
            </div>
            <div class="contact-info">
                Any questions please contact manager.
            </div>
        </div>
    </div>
</body>
</html>