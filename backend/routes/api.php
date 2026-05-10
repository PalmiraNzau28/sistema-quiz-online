<?php
// backend/routes/api.php - VERSÃO COMPLETA COM CRUD DE QUIZZES

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Incluir modelos
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Quiz.php';
require_once __DIR__ . '/../models/Question.php';
require_once __DIR__ . '/../models/Answer.php';
require_once __DIR__ . '/../utils/JwtHandler.php';
require_once __DIR__ . '/../utils/AuthMiddleware.php';

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : '';

// Instanciar modelos
$user = new User();
$quiz = new Quiz();
$question = new Question();
$answer = new Answer();

// ==================== AUTENTICAÇÃO ====================

// REGISTO
if ($endpoint == 'register' && $method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->name) || !isset($data->email) || !isset($data->password)) {
        echo json_encode(["success" => false, "message" => "Todos os campos são obrigatórios"]);
        exit();
    }
    
    $result = $user->register($data->name, $data->email, $data->password);
    http_response_code($result['success'] ? 201 : 400);
    echo json_encode($result);
    exit();
}

// LOGIN
if ($endpoint == 'login' && $method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->email) || !isset($data->password)) {
        echo json_encode(["success" => false, "message" => "Email e password são obrigatórios"]);
        exit();
    }
    
    $result = $user->login($data->email, $data->password);
    
    if ($result['success']) {
        $jwt = new JwtHandler();
        $token = $jwt->generateToken(
            $result['user']['id'],
            $result['user']['email'],
            $result['user']['user_type']
        );
        
        echo json_encode([
            "success" => true,
            "message" => "Login bem-sucedido",
            "token" => $token,
            "user" => $result['user']
        ]);
    } else {
        http_response_code(401);
        echo json_encode($result);
    }
    exit();
}

// OBTER DADOS DO PRÓPRIO UTILIZADOR (protegido)
if ($endpoint == 'me' && $method == 'GET') {
    $auth = new AuthMiddleware();
    $payload = $auth->validateToken();
    $userData = $user->findById($payload->user_id);
    
    if ($userData) {
        echo json_encode(["success" => true, "user" => $userData]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Utilizador não encontrado"]);
    }
    exit();
}

// ==================== QUIZZES ====================

// LISTAR TODOS OS QUIZZES (público)
if ($endpoint == 'quizzes' && $method == 'GET') {
    $quizzes = $quiz->getAll();
    echo json_encode(["success" => true, "quizzes" => $quizzes]);
    exit();
}

// BUSCAR QUIZ POR ID (com perguntas e respostas)
if ($endpoint == 'quiz' && $method == 'GET') {
    $quiz_id = isset($_GET['id']) ? $_GET['id'] : null;
    
    if (!$quiz_id) {
        echo json_encode(["success" => false, "message" => "ID do quiz é obrigatório"]);
        exit();
    }
    
    $quizData = $quiz->getById($quiz_id);
    if (!$quizData) {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Quiz não encontrado"]);
        exit();
    }
    
    // Buscar perguntas do quiz
    $questions = $question->getByQuizId($quiz_id);
    
    // Buscar respostas para cada pergunta
    foreach ($questions as &$q) {
        $q['answers'] = $answer->getByQuestionId($q['id']);
    }
    
    $quizData['questions'] = $questions;
    echo json_encode(["success" => true, "quiz" => $quizData]);
    exit();
}

// CRIAR QUIZ (apenas admin)
if ($endpoint == 'quiz' && $method == 'POST') {
    $auth = new AuthMiddleware();
    $payload = $auth->requireAdmin();
    
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->title)) {
        echo json_encode(["success" => false, "message" => "Título é obrigatório"]);
        exit();
    }
    
    $description = isset($data->description) ? $data->description : '';
    $result = $quiz->create($data->title, $description, $payload->user_id);
    
    http_response_code($result['success'] ? 201 : 400);
    echo json_encode($result);
    exit();
}

// ATUALIZAR QUIZ (apenas admin)
if ($endpoint == 'quiz' && $method == 'PUT') {
    $auth = new AuthMiddleware();
    $payload = $auth->requireAdmin();
    
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->id) || !isset($data->title)) {
        echo json_encode(["success" => false, "message" => "ID e título são obrigatórios"]);
        exit();
    }
    
    $description = isset($data->description) ? $data->description : '';
    $result = $quiz->update($data->id, $data->title, $description);
    
    echo json_encode($result);
    exit();
}

// APAGAR QUIZ (apenas admin)
if ($endpoint == 'quiz' && $method == 'DELETE') {
    $auth = new AuthMiddleware();
    $payload = $auth->requireAdmin();
    
    $quiz_id = isset($_GET['id']) ? $_GET['id'] : null;
    
    if (!$quiz_id) {
        echo json_encode(["success" => false, "message" => "ID do quiz é obrigatório"]);
        exit();
    }
    
    $result = $quiz->delete($quiz_id);
    echo json_encode($result);
    exit();
}

// ==================== PERGUNTAS ====================

// ADICIONAR PERGUNTA A UM QUIZ (apenas admin)
if ($endpoint == 'question' && $method == 'POST') {
    $auth = new AuthMiddleware();
    $payload = $auth->requireAdmin();
    
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->quiz_id) || !isset($data->question_text)) {
        echo json_encode(["success" => false, "message" => "quiz_id e question_text são obrigatórios"]);
        exit();
    }
    
    $question_type = isset($data->question_type) ? $data->question_type : 'multiple_choice';
    $result = $question->create($data->quiz_id, $data->question_text, $question_type);
    
    http_response_code($result['success'] ? 201 : 400);
    echo json_encode($result);
    exit();
}

// ATUALIZAR PERGUNTA (apenas admin)
if ($endpoint == 'question' && $method == 'PUT') {
    $auth = new AuthMiddleware();
    $payload = $auth->requireAdmin();
    
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->id) || !isset($data->question_text)) {
        echo json_encode(["success" => false, "message" => "ID e question_text são obrigatórios"]);
        exit();
    }
    
    $question_type = isset($data->question_type) ? $data->question_type : 'multiple_choice';
    $result = $question->update($data->id, $data->question_text, $question_type);
    
    echo json_encode($result);
    exit();
}

// APAGAR PERGUNTA (apenas admin)
if ($endpoint == 'question' && $method == 'DELETE') {
    $auth = new AuthMiddleware();
    $payload = $auth->requireAdmin();
    
    $question_id = isset($_GET['id']) ? $_GET['id'] : null;
    
    if (!$question_id) {
        echo json_encode(["success" => false, "message" => "ID da pergunta é obrigatório"]);
        exit();
    }
    
    $result = $question->delete($question_id);
    echo json_encode($result);
    exit();
}

// ==================== RESPOSTAS ====================

// ADICIONAR RESPOSTA A UMA PERGUNTA (apenas admin)
if ($endpoint == 'answer' && $method == 'POST') {
    $auth = new AuthMiddleware();
    $payload = $auth->requireAdmin();
    
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->question_id) || !isset($data->answer_text)) {
        echo json_encode(["success" => false, "message" => "question_id e answer_text são obrigatórios"]);
        exit();
    }
    
    $is_correct = isset($data->is_correct) ? $data->is_correct : false;
    $result = $answer->create($data->question_id, $data->answer_text, $is_correct);
    
    http_response_code($result['success'] ? 201 : 400);
    echo json_encode($result);
    exit();
}

// ATUALIZAR RESPOSTA (apenas admin)
if ($endpoint == 'answer' && $method == 'PUT') {
    $auth = new AuthMiddleware();
    $payload = $auth->requireAdmin();
    
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->id) || !isset($data->answer_text)) {
        echo json_encode(["success" => false, "message" => "ID e answer_text são obrigatórios"]);
        exit();
    }
    
    $is_correct = isset($data->is_correct) ? $data->is_correct : false;
    $result = $answer->update($data->id, $data->answer_text, $is_correct);
    
    echo json_encode($result);
    exit();
}

// APAGAR RESPOSTA (apenas admin)
if ($endpoint == 'answer' && $method == 'DELETE') {
    $auth = new AuthMiddleware();
    $payload = $auth->requireAdmin();
    
    $answer_id = isset($_GET['id']) ? $_GET['id'] : null;
    
    if (!$answer_id) {
        echo json_encode(["success" => false, "message" => "ID da resposta é obrigatório"]);
        exit();
    }
    
    $result = $answer->delete($answer_id);
    echo json_encode($result);
    exit();
}

// ==================== RECUPERAÇÃO DE SENHA ====================

// Solicitar reset de password (gerar token)
if ($endpoint == 'forgot-password' && $method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->email)) {
        echo json_encode(["success" => false, "message" => "Email é obrigatório"]);
        exit();
    }
    
    $result = $user->generateResetToken($data->email);
    
    if ($result['success']) {
        // Em produção, enviaria email com o link
        // Por agora, retorna o token para teste
        echo json_encode([
            "success" => true,
            "message" => "Token gerado com sucesso. (Em produção, enviaríamos por email)",
            "token" => $result['token']  // Apenas para teste
        ]);
    } else {
        http_response_code(400);
        echo json_encode($result);
    }
    exit();
}

// Resetar password usando token
if ($endpoint == 'reset-password' && $method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->token) || !isset($data->new_password)) {
        echo json_encode(["success" => false, "message" => "Token e nova password são obrigatórios"]);
        exit();
    }
    
    $result = $user->resetPassword($data->token, $data->new_password);
    
    if ($result['success']) {
        echo json_encode($result);
    } else {
        http_response_code(400);
        echo json_encode($result);
    }
    exit();
}