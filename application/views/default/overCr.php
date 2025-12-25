<!DOCTYPE html>
<html>

<head>
    <title>Temporarily Suspended</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .suspension-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 450px;
            text-align: center;
        }

        .warning-icon {
            color: #1E4361;
            font-size: 60px;
            margin-bottom: 20px;
        }

        h2 {
            color: #1E4361;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .timer {
            font-size: 32px;
            font-weight: bold;
            color: #1E4361;
            margin: 25px 0;
        }

        .notice {
            background-color: #f0f4f8;
            padding: 15px;
            border-radius: 4px;
            margin-top: 25px;
            border-left: 4px solid #1E4361;
        }

        .header-bar {
            background-color: #1E4361;
            height: 8px;
            width: 100%;
            border-radius: 8px 8px 0 0;
            margin-bottom: 20px;
        }

        .red-percent {
            color: red;
            font-weight: bold;
        }

        /* ✅ THÊM STYLE CHO CR INFO */
        .cr-current {
            display: inline-block;
            background-color: #fff3cd;
            padding: 8px 15px;
            border-radius: 4px;
            margin: 10px 0;
            font-size: 16px;
        }

        .cr-current strong {
            color: #dc3545;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="suspension-box">
        <div class="header-bar"></div>
        <div class="warning-icon">⚠️</div>
        <h2>Temporary Suspension</h2>

        <?php
        $cr_value = isset($cr_value) ? number_format($cr_value, 2) : '0.00';
        $is_too_low = $cr_value < $cr_min;
        ?>

        <p>You are temporarily suspended because CR is outside the allowed range of
            <span class="red-percent"><?php echo $cr_min; ?>% - <?php echo $cr_max; ?>%</span>.
        </p>

        <div class="cr-current">
            Your CR at suspension: <strong><?php echo $cr_value; ?>%</strong>
            <?php if ($is_too_low): ?>
                <span style="color: #dc3545;">(too low)</span>
            <?php else: ?>
                <span style="color: #fd7e14;">(too high)</span>
            <?php endif; ?>
        </div>

        <p>Please try again after:</p>
        <div class="timer" id="countdown">
            <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span>
        </div>

        <div class="notice">
            <p>Please keep your CR between
                <span class="red-percent"><?php echo $cr_min; ?>% - <?php echo $cr_max; ?>%</span>
                to avoid permanent suspension in the future.
            </p>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var timeRemaining = <?php echo $remaining_seconds; ?>;
            var startTime = Date.now();

            function padZero(num) {
                return (num < 10 ? '0' : '') + num;
            }

            function updateTimer() {
                var elapsed = Math.floor((Date.now() - startTime) / 1000);
                var currentRemaining = timeRemaining - elapsed;

                if (currentRemaining <= 0) {
                    $('#hours').text('00');
                    $('#minutes').text('00');
                    $('#seconds').text('00');
                    clearInterval(timerInterval);
                    window.location.reload();
                    return;
                }

                var hours = Math.floor(currentRemaining / 3600);
                var minutes = Math.floor((currentRemaining % 3600) / 60);
                var seconds = currentRemaining % 60;

                $('#hours').text(padZero(hours));
                $('#minutes').text(padZero(minutes));
                $('#seconds').text(padZero(seconds));
            }

            updateTimer();
            var timerInterval = setInterval(updateTimer, 1000);
        });
    </script>
</body>

</html>