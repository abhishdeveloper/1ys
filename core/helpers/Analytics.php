<?php
// core/helpers/Analytics.php

class Analytics {
    public static function logPageView(PDO $db) {
        $pageUrl = $_SERVER['REQUEST_URI'] ?? '/';

        // Strip off query parameters for the base URL to prevent fragmented data (optional)
        $parsedUrl = parse_url($pageUrl);
        $cleanUrl = $parsedUrl['path'] ?? '/';

        // Ignore static assets if they accidentally hit this
        if (preg_match('/\.(css|js|jpg|jpeg|png|gif|svg|ico|woff|woff2|ttf|eot)$/i', $cleanUrl)) {
            return;
        }

        // Do not log admin routes to keep metrics strictly customer-focused
        if (strpos($cleanUrl, '/admin') === 0) {
            return;
        }

        $visitorIp = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

        // Handle IP behind proxies
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $visitorIp = trim($ipList[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $visitorIp = $_SERVER['HTTP_CLIENT_IP'];
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
        // Max limit of user agent field is 255
        $userAgent = substr($userAgent, 0, 255);

        try {
            $stmt = $db->prepare("INSERT INTO page_views (page_url, visitor_ip, user_agent) VALUES (:url, :ip, :ua)");
            $stmt->execute([
                'url' => $cleanUrl,
                'ip' => $visitorIp,
                'ua' => $userAgent
            ]);
        } catch (Exception $e) {
            // Silently fail if tracking errors out, don't break the application
            error_log("Analytics logging failed: " . $e->getMessage());
        }
    }
}
?>