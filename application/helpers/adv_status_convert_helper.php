<?php
if (!function_exists('adv_status_convert')) {
    function adv_status_convert($paymterm, $trackDate, $confirm_date, $uniqueId = '')
    {
        $today = new DateTime();
        $baseDate = new DateTime($trackDate);

        if ($paymterm == 1) {
            $endOfMonth = $baseDate->format('Y-m-t');
            $timeOfBase = $baseDate->format('H:i:s');
            $endDate = DateTime::createFromFormat('Y-m-d H:i:s', $endOfMonth . ' ' . $timeOfBase);
        } else {
            $dayOfWeek = (int)$baseDate->format('w');
            $daysToSunday = ($dayOfWeek == 0) ? 0 : 7 - $dayOfWeek;
            $endDate = clone $baseDate;
            $endDate->modify("+{$daysToSunday} days");
        }

        $targetDate = clone $endDate;
        $targetDate->modify("+{$confirm_date} days");
        $targetDate->setTime(0, 0, 0);

        $expireDate = clone $targetDate;
        $expireDate->modify("+1 day");
        if ($paymterm == 1) {
            $expireDate->modify("+5 days");
            $expireThreshold = -5;
        } else {
            $expireDate->modify("+3 days");
            $expireThreshold = -3;
        }

        $diffDays = (int)$today->diff($targetDate)->format('%r%a');
        $expireDiffDays = (int)$today->diff($expireDate)->format('%r%a');

        $targetTimestamp = $targetDate->getTimestamp();
        $expireTimestamp = $expireDate->getTimestamp();

        $deadlineFormat = $targetDate->format('M j, Y \a\t H:i');
        $expireFormat = $expireDate->format('M j, Y \a\t H:i');

        if (empty($uniqueId)) {
            $uniqueId = md5($paymterm . $trackDate . $confirm_date . microtime());
        }

        if ($diffDays > 0) {
            return '<h6><span class="badge bg-info countdown-badge" data-target="' . $targetTimestamp . '" data-tooltip="Target: ' . $deadlineFormat . '" data-bs-toggle="tooltip" id="countdown-' . $uniqueId . '"></span></h6>';
        } elseif ($diffDays >= $expireThreshold) {
            if ($diffDays == 0) {
                return '<h6><span class="badge bg-warning countdown-badge" data-target="' . $expireTimestamp . '" data-tooltip="Expires: ' . $expireFormat . '" data-bs-toggle="tooltip" id="countdown-' . $uniqueId . '">Due Now</span></h6>';
            } else {
                return '<h6><span class="badge bg-warning countdown-badge" data-target="' . $expireTimestamp . '" data-tooltip="Expires: ' . $expireFormat . '" data-bs-toggle="tooltip" id="countdown-' . $uniqueId . '"></span></h6>';
            }
        } else {
            $expiredDays = abs($expireDiffDays);
            return '<h6><span class="badge bg-danger" data-bs-toggle="tooltip" title="Expired ' . $expiredDays . ' days ago on: ' . $expireFormat . '">Expired</span></h6>';
        }
    }
}
