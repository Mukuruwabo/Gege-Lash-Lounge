<?php
require_once 'config.php';

class SMSService {
    private $provider;
    private $apiKey;
    private $username;
    private $senderId;
    
    public function __construct() {
        $this->provider = SMS_PROVIDER; // 'africastalking' or 'mtn'
        $this->apiKey = SMS_API_KEY;
        $this->username = SMS_USERNAME;
        $this->senderId = SMS_SENDER_ID;
    }
    
    public function sendSMS($phone, $message) {
        // Format phone number (add Rwanda country code)
        $formattedPhone = $this->formatPhoneNumber($phone);
        
        switch ($this->provider) {
            case 'africastalking':
                return $this->sendViaAfricaTalking($formattedPhone, $message);
            case 'mtn':
                return $this->sendViaMTN($formattedPhone, $message);
            default:
                throw new Exception("Unsupported SMS provider");
        }
    }
    
    private function formatPhoneNumber($phone) {
        // Remove any non-digit characters
        $phone = preg_replace('/\D/', '', $phone);
        
        // Convert to international format (Rwanda)
        if (strlen($phone) === 9 && strpos($phone, '0') !== 0) {
            return '+25' . $phone;
        } elseif (strlen($phone) === 10 && strpos($phone, '0') === 0) {
            return '+25' . substr($phone, 1);
        }
        
        return $phone;
    }
    
    private function sendViaAfricaTalking($phone, $message) {
        $url = "https://api.africastalking.com/version1/messaging";
        
        $postData = [
            'username' => $this->username,
            'to' => $phone,
            'message' => $message,
            'from' => $this->senderId
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'apiKey: ' . $this->apiKey,
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json'
        ]);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
    
    private function sendViaMTN($phone, $message) {
        $url = "https://api.mtn.co.rw/sms/v1/messages";
        
        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json'
        ];
        
        $data = [
            'senderAddress' => $this->senderId,
            'receiverAddress' => $phone,
            'message' => $message,
            'clientCorrelator' => uniqid()
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
}
?>