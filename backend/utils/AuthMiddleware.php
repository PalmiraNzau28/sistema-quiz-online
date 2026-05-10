<?php
// backend/utils/AuthMiddleware.php

require_once __DIR__ . '/JwtHandler.php';

class AuthMiddleware {
    private $jwt;
    
    public function __construct() {
        $this->jwt = new JwtHandler();
    }
    
    // Verificar se o token é válido
    public function validateToken() {
        $headers = getallheaders();
        
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Token não fornecido"]);
            exit();
        }
        
        $authHeader = $headers['Authorization'];
        $token = str_replace('Bearer ', '', $authHeader);
        
        $payload = $this->jwt->validateToken($token);
        
        if (!$payload) {
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Token inválido ou expirado"]);
            exit();
        }
        
        return $payload;
    }
    
    // Verificar se o utilizador é admin
    public function requireAdmin() {
        $payload = $this->validateToken();
        
        if ($payload->user_type !== 'admin') {
            http_response_code(403);
            echo json_encode(["success" => false, "message" => "Acesso negado. Permissões de administrador necessárias."]);
            exit();
        }
        
        return $payload;
    }
}
?>