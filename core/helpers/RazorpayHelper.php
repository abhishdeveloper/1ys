<?php

class RazorpayHelper {
    private $keyId;
    private $keySecret;
    private $baseUrl = 'https://api.razorpay.com/v1';
    public $lastError = null;

    public function __construct($keyId, $keySecret) {
        $this->keyId = trim($keyId);
        $this->keySecret = trim($keySecret);
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
        // Minimum amount for INR is ₹1.00 (100 paise)
        if ($amount < 1.00 && strtoupper($currency) === 'INR') {
            $amount = 1.00;
        }

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
        $this->lastError = null;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->keyId . ':' . $this->keySecret);
        // Important for shared hosting environments that might have outdated CA bundles
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

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
            $this->lastError = "cURL Error: " . $error;
            error_log("Razorpay " . $this->lastError);
            return false;
        }

        $decodedResponse = json_decode($response, true);

        if ($httpCode >= 200 && $httpCode < 300) {
            return $decodedResponse;
        } else {
            $apiErrorMsg = isset($decodedResponse['error']['description']) ? $decodedResponse['error']['description'] : "Unknown API Error";
            $this->lastError = "API Error ($httpCode): " . $apiErrorMsg;
            error_log("Razorpay " . $this->lastError . " - Response: " . $response);
            return false;
        }
    }
}
