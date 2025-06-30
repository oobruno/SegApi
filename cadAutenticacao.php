<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type
header('Content-Type: application/json');

// Include the shared DB connection
require_once 'conexao.php';
$con->set_charset("utf8");

// Get JSON input
$jsonParam = json_decode(file_get_contents('php://input'), true);

if (!$jsonParam) {
    echo json_encode(['success' => false, 'message' => 'Dados JSON inválidos ou ausentes.']);
    exit;
}

// Extract and validate data
$idEmail      = trim($jsonParam['idEmail'] ?? '');
$idSenha      = trim($jsonParam['idSenha'] ?? '');
$idNumero     = trim($jsonParam['idNumero'] ?? '');
$nomeUsuario  = trim($jsonParam['nomeUsuario'] ?? '');


// Prepare and bind
$stmt = $con->prepare("
    INSERT INTO Usuario ( idEmail, idSenha, idNumero, nomeUsuario)
    VALUES ( ?, ?, ?, ?)
");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Erro ao preparar a consulta: ' . $con->error]);
    exit;
}

$stmt->bind_param("ssss",$idEmail, $idSenha, $idNumero, $nomeUsuario);

// Execute and return result
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Usuário inserido com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro no registro do usuário: ' . $stmt->error]);
}

$stmt->close();
$con->close();

?>
