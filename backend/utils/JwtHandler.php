<?php
// backend/utils/JwtHandler.php

class JwtHandler {
    private $secret_key = "sua_chave_secreta_muito_segura_2026";
    private $algorithm = "HS256";

    public function generateToken($user_id, $email, $user_type) {
        $header = json_encode(['typ' => 'JWT', 'alg' => $this->algorithm]);
        $payload = json_encode([
            'user_id' => $user_id,
            'email' => $email,
            'user_type' => $user_type,
            'exp' => time() + (7 * 24 * 60 * 60) // 7 dias
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret_key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public function validateToken($token) {
        $parts = explode('.', $token);
        if (count($parts) != 3) return false;

        $signature = hash_hmac('sha256', $parts[0] . "." . $parts[1], $this->secret_key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        if ($base64UrlSignature !== $parts[2]) return false;

        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])));
        if ($payload->exp < time()) return false;

        return $payload;
    }
}
?>