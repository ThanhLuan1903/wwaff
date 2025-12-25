<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Chuyển đổi thời gian hiện tại sang GMT-5
 * @param string $format Format của thời gian trả về (Y-m-d, Y-m-d H:i:s, etc.)
 * @param string $source_timezone Múi giờ nguồn (mặc định: Asia/Ho_Chi_Minh)
 * @return string Thời gian đã được chuyển đổi theo format
 */

 if (!function_exists('convert_to_gmt5')) {
    function convert_to_gmt5($format = 'Y-m-d', $source_timezone = 'Asia/Ho_Chi_Minh') {
        $now = new DateTime('now', new DateTimeZone($source_timezone));
        $now->setTimezone(new DateTimeZone('GMT-5'));
        return $now->format($format);
    }
}


/**
 * Chuyển đổi một timestamp cụ thể sang GMT-5
 * @param string|int $timestamp Timestamp cần chuyển đổi (dạng string hoặc timestamp unix)
 * @param string $format Format của thời gian trả về
 * @param string $source_timezone Múi giờ nguồn
 * @return string Thời gian đã được chuyển đổi theo format
 */

if (!function_exists('timestamp_to_gmt5')) {
    function timestamp_to_gmt5($timestamp, $format = 'Y-m-d', $source_timezone = 'Asia/Ho_Chi_Minh') {
        if (is_string($timestamp)) {
            $dt = new DateTime($timestamp, new DateTimeZone($source_timezone));
        } else {
            $dt = new DateTime();
            $dt->setTimestamp($timestamp);
            $dt->setTimezone(new DateTimeZone($source_timezone));
        }
        
        $dt->setTimezone(new DateTimeZone('GMT-5'));
        return $dt->format($format);
    }
}