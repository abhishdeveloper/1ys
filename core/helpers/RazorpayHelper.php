<?php

class RazorpayHelper {
    private $keyId;
    private $keySecret;
    private $baseUrl = 'https://api.razorpay.com/v1';

    public function __construct($keyId, $keySecret) {
        $this->keyId = $keyId;
        $this->keySecret = $keySecret;
    }

    /**
     * Creates an order in Razorpay
     * @param float $amount Amount in your base currency (e.g. INR or USD)
     * @param string $currency Currency code (default: INR)
     * @param string|null $receipt Optional receipt id
     * @return array|bool Array with order details on success, false on failure
     */
    public function createOrder($amount, $currency = 'INR', $receipt = null) {
        $url = $this->baseUrl . '/orders';

        // Razorpay expects amount in subunits (e.g. paise for INR, cents for USD)
        $amountInSubunits = (int)round($amount * 100);

        $data = [
            'amount' => $amountInSubunits,
            'currency' => $currency,
            'receipt' => $receipt ?? uniqid('rcpt_')
        ];

        $response = $this->makeRequest('POST', $url, $data);

        if ($response && isset($response['id'])) {
            return $response;
        }

        return false;
    }

    /**
     * Verifies the Razorpay signature
     * @param string $razorpayOrderId
     * @param string $razorpayPaymentId
     * @param string $razorpaySignature
     * @return bool
     */
    public function verifySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature) {
        $expectedSignature = hash_hmac('sha256', $razorpayOrderId . '|' . $razorpayPaymentId, $this->keySecret);
        return hash_equals($expectedSignature, $razorpaySignature);
    }

    /**
     * Helper to make cURL requests to Razorpay
     */
    private function makeRequest($method, $url, $data = null) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->keyId . ':' . $this->keySecret);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json'
                ]);
            }
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("Razorpay cURL Error: " . $error);
            return false;
        }

        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        } else {
            error_log("Razorpay API Error ($httpCode): " . $response);
            return false;
        }
    }
}
