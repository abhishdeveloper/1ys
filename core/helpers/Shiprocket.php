<?php
// core/helpers/Shiprocket.php

class Shiprocket {
    private $email;
    private $password;
    private $token = null;
    private $baseUrl = 'https://apiv2.shiprocket.in/v1/external';

    public function __construct() {
        // Fetch Shiprocket credentials from DB
        try {
            require_once __DIR__ . '/functions.php';
            $db = getDB();
            $stmt = $db->query("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('shiprocket_email', 'shiprocket_password')");
            $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

            $this->email = $settings['shiprocket_email'] ?? '';
            $this->password = $settings['shiprocket_password'] ?? '';
        } catch (Exception $e) {
            error_log("Failed to load Shiprocket credentials: " . $e->getMessage());
        }
    }

    /**
     * Authenticate and get a JWT token
     */
    public function authenticate() {
        if (empty($this->email) || empty($this->password)) {
            return false;
        }

        $ch = curl_init($this->baseUrl . '/auth/login');
        $payload = json_encode([
            'email' => $this->email,
            'password' => $this->password
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            if (isset($data['token'])) {
                $this->token = $data['token'];
                return true;
            }
        }

        error_log("Shiprocket Auth Failed: HTTP " . $httpCode . " Response: " . $response);
        return false;
    }

    /**
     * Get tracking details and URL by AWB (Airway Bill number)
     */
    public function getTrackingUrlByAwb($awbCode) {
        if (!$this->token && !$this->authenticate()) {
            return false;
        }

        if (empty($awbCode)) {
            return false;
        }

        $ch = curl_init($this->baseUrl . '/courier/track/awb/' . $awbCode);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->token
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            if (isset($data['tracking_data']['track_url'])) {
                return $data['tracking_data']['track_url'];
            }
        }

        error_log("Shiprocket Tracking Failed: HTTP " . $httpCode . " Response: " . $response);
        return false;
    }
}
?>