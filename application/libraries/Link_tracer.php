<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Link_tracer {

    protected $RAW_PROXIES = array(
        '31.59.20.176:6754:zlweruzp:eqa10abcbcnz',
        '23.95.150.145:6114:zlweruzp:eqa10abcbcnz',
        '198.23.239.134:6540:zlweruzp:eqa10abcbcnz',
        '107.172.163.27:6543:zlweruzp:eqa10abcbcnz',
        '198.105.121.200:6462:zlweruzp:eqa10abcbcnz',
        '64.137.96.74:6641:zlweruzp:eqa10abcbcnz',
        '216.10.27.159:6837:zlweruzp:eqa10abcbcnz',
        '23.26.71.145:5628:zlweruzp:eqa10abcbcnz',
        '23.229.19.94:8689:zlweruzp:eqa10abcbcnz',
        '2.57.20.2:5994:zlweruzp:eqa10abcbcnz',
    );

    protected $PARSED_PROXIES = null;

    protected function parse_proxies()
    {
        if ($this->PARSED_PROXIES !== null) return $this->PARSED_PROXIES;

        $out = array();
        foreach ($this->RAW_PROXIES as $line) {
            $line = trim($line);
            if ($line === '') continue;

            $parts = explode(':', $line);
            if (count($parts) < 4) continue;

            $host = trim($parts[0]);
            $port = (int)trim($parts[1]);
            $user = trim($parts[2]);
            $pass = trim($parts[3]);

            if ($host === '' || $port <= 0) continue;

            $out[] = array('host' => $host, 'port' => $port, 'user' => $user, 'pass' => $pass);
        }

        $this->PARSED_PROXIES = $out;
        return $out;
    }

    // Map host by country
    protected function get_proxy_by_country($country)
    {
        $country = strtoupper(trim((string)$country));
        if ($country === '' || $country === 'VN') return null;

        $proxies = $this->parse_proxies();
        if (!$proxies) return null;

        $countryPool = array(
            'GB' => array('31.59.20.176', '198.105.121.200'),
            'US' => array(
                '23.95.150.145','198.23.239.134','107.172.163.27','216.10.27.159',
                '23.26.71.145','23.229.19.94','2.57.20.2'
            ),
            'ES' => array('64.137.96.74'),
        );

        if (!isset($countryPool[$country]) || empty($countryPool[$country])) return null;

        $allowedHosts = array_flip($countryPool[$country]);
        $candidates = array();

        foreach ($proxies as $p) {
            if (isset($allowedHosts[$p['host']])) $candidates[] = $p;
        }

        if (!$candidates) return null;
        return $candidates[array_rand($candidates)];
    }

    protected function accept_language_by_country($country)
    {
        $country = strtoupper(trim((string)$country));
        if ($country === 'GB') return 'en-GB,en;q=0.9';
        if ($country === 'ES') return 'es-ES,es;q=0.9,en;q=0.8';
        if ($country === 'US') return 'en-US,en;q=0.9';
        return 'en-US,en;q=0.9';
    }

    protected function user_agent_by_device($device)
    {
        switch ((int)$device) {
            // 1️⃣ Desktop
            case 1:
                return 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

            // 2️⃣ Android
            case 2:
                return 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36';

            // 3️⃣ iPhone
            case 3:
                return 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1';

            // 4️⃣ iPad
            case 4:
                return 'Mozilla/5.0 (iPad; CPU OS 17_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1';

            default:
                return 'Mozilla/5.0';
        }
    }

    // ✅ PROBE: kiểm tra proxy đang ra IP + country nào (để bạn biết geo có đổi thật không)
    protected function probe_proxy($proxy, $timeout = 10)
    {
        // Direct (VN)
        if (!$proxy) return array('ok' => true, 'ip' => null, 'country' => 'VN');

        $ch = curl_init('https://ipinfo.io/json');
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING       => '',
        ));

        curl_setopt($ch, CURLOPT_PROXY, $proxy['host'] . ':' . $proxy['port']);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy['user'] . ':' . $proxy['pass']);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);

        $res = curl_exec($ch);
        if ($res === false) {
            $err = curl_error($ch);
            curl_close($ch);
            return array('ok' => false, 'error' => $err);
        }
        curl_close($ch);

        $data = json_decode($res, true);
        return array(
            'ok'      => true,
            'ip'      => isset($data['ip']) ? $data['ip'] : null,
            'country' => isset($data['country']) ? $data['country'] : null,
            'raw'     => $data,
        );
    }

    protected function to_absolute_url($baseUrl, $location)
    {
        $location = trim($location);
        if (preg_match('~^https?://~i', $location)) return $location;

        $p = parse_url($baseUrl);
        if (!$p || empty($p['scheme']) || empty($p['host'])) return $location;

        $scheme = $p['scheme'];
        $host   = $p['host'];
        $port   = isset($p['port']) ? ':' . $p['port'] : '';

        if (strpos($location, '/') === 0) return $scheme . '://' . $host . $port . $location;

        $path = isset($p['path']) ? $p['path'] : '/';
        $dir  = rtrim(str_replace('\\', '/', dirname($path)), '/');
        return $scheme . '://' . $host . $port . $dir . '/' . $location;
    }

    protected function status_title($code) { $map = array( 0 => 'Connection failed / Timeout / Blocked', 200 => '200 OK – Success', 201 => '201 Created', 202 => '202 Accepted', 204 => '204 No Content', 301 => '301 Moved Permanently', 302 => '302 Found (Temporary Redirect)', 303 => '303 See Other', 307 => '307 Temporary Redirect', 308 => '308 Permanent Redirect', 400 => '400 Bad Request', 401 => '401 Unauthorized', 403 => '403 Forbidden – Access denied', 404 => '404 Not Found', 405 => '405 Method Not Allowed', 408 => '408 Request Timeout', 410 => '410 Gone', 429 => '429 Too Many Requests', 500 => '500 Internal Server Error', 502 => '502 Bad Gateway', 503 => '503 Service Unavailable', 504 => '504 Gateway Timeout', ); return isset($map[$code]) ? $map[$code] : $code . ' Unknown Status'; }

    public function trace($startUrl, $country = 'VN', $device = 1, $maxHops = 15, $timeout = 15)
    {
        $country = strtoupper(trim((string)$country));
        $userAgent = $this->user_agent_by_device($device);

        $proxy = $this->get_proxy_by_country($country);

        // ✅ cookie jar per country (giữ session giữa các hop)
        $cookieFile = sys_get_temp_dir() . '/linktracer_' . strtolower($country) . '.cookie';

        $hops = array();

        // ✅ thêm bước PROBE để bạn thấy geo có đổi thật không
        // $probe = $this->probe_proxy($proxy, min(10, $timeout));
        // $hops[] = array(
        //     'step'         => 0,
        //     'url'          => 'https://ipinfo.io/json',
        //     'status'       => $probe['ok'] ? 200 : 0,
        //     'status_title' => $probe['ok'] ? '200 OK – Proxy Probe' : '0 – Proxy Probe Failed',
        //     'type'         => $proxy ? 'probe+proxy' : 'probe+direct',
        //     'proxy'        => $proxy ? ($proxy['host'] . ':' . $proxy['port']) : null,
        //     'geo'          => $country,
        //     'exit_ip'      => isset($probe['ip']) ? $probe['ip'] : null,
        //     'exit_country' => isset($probe['country']) ? $probe['country'] : null,
        //     'error'        => isset($probe['error']) ? $probe['error'] : null,
        // );

        // // Nếu proxy fail thì dừng luôn để bạn biết lỗi nằm ở đâu
        // if ($proxy && (!$probe['ok'])) return $hops;

        $currentUrl = $startUrl;

        for ($i = 1; $i <= $maxHops; $i++) {

            $ch = curl_init($currentUrl);

            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => true,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_TIMEOUT        => $timeout,
                CURLOPT_CONNECTTIMEOUT => $timeout,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_USERAGENT      => $userAgent,
                CURLOPT_ENCODING       => '',
                CURLOPT_COOKIEJAR      => $cookieFile,
                CURLOPT_COOKIEFILE     => $cookieFile,
            ));

            $headers = array(
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: ' . $this->accept_language_by_country($country),
                'Connection: keep-alive',
            );

            // Mobile devices
            if (in_array((int)$device, array(2,3,4))) {
                $headers[] = 'Sec-CH-UA-Mobile: ?1';
                $headers[] = 'Viewport-Width: 390';
            } else {
                $headers[] = 'Sec-CH-UA-Mobile: ?0';
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


            if ($proxy) {
                curl_setopt($ch, CURLOPT_PROXY, $proxy['host'] . ':' . $proxy['port']);
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy['user'] . ':' . $proxy['pass']);
                curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
            }

            $response = curl_exec($ch);

            if ($response === false) {
                $hops[] = array(
                    'step'         => $i,
                    'url'          => $currentUrl,
                    'status'       => 0,
                    'status_title' => $this->status_title(0),
                    'error'        => curl_error($ch),
                    'type'         => 'curl-error',
                    'proxy'        => $proxy ? ($proxy['host'] . ':' . $proxy['port']) : null,
                    'geo'          => $country,
                );
                curl_close($ch);
                break;
            }

            $status     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers    = substr($response, 0, $headerSize);
            $body       = substr($response, $headerSize);

            curl_close($ch);

            $hops[] = array(
                'step'         => $i,
                'url'          => $currentUrl,
                'status'       => $status,
                'status_title' => $this->status_title($status),
                'type'         => $proxy ? 'http+proxy' : 'http',
                'proxy'        => $proxy ? ($proxy['host'] . ':' . $proxy['port']) : null,
                'geo'          => $country,
                'device' => (int)$device,
            );

            if ($status >= 300 && $status < 400) {
                if (preg_match('/\r?\nLocation:\s*(.*?)\r?\n/i', "\n".$headers."\n", $m)) {
                    $next = trim($m[1]);
                    $currentUrl = $this->to_absolute_url($currentUrl, $next);
                    continue;
                }
                break;
            }


            if ($status == 200 && preg_match('/http-equiv=["\']?refresh["\']?.*url=([^"\'>]+)/i', $body, $m)) {
                $next = html_entity_decode(trim($m[1]));
                $currentUrl = $this->to_absolute_url($currentUrl, $next);

                $hops[] = array(
                    'step'         => $i,
                    'url'          => $currentUrl,
                    'status'       => 200,
                    'status_title' => '200 OK – Meta Refresh',
                    'type'         => 'meta-refresh',
                    'proxy'        => $proxy ? ($proxy['host'] . ':' . $proxy['port']) : null,
                    'geo'          => $country,
                    'device' => (int)$device,
                );
                continue;
            }

            break;
        }

        return $hops;
    }
}