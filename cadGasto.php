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
$idTipoGasto = trim($jsonParam['idTipoGasto'] ?? '');
$idData      = trim($jsonParam['idData'] ?? '');
$qtGasto     = trim($jsonParam['qtGasto'] ?? '');

// Validate required fields
if (empty($idTipoGasto) || empty($idData) || empty($qtGasto)) {
    echo json_encode(['success' => false, 'message' => 'Campos obrigatórios ausentes.']);
    exit;
}

// Prepare and bind
$stmt = $con->prepare("
    INSERT INTO Gasto (idTipoGasto, idData, qtGasto)
    VALUES (?, ?, ?)
");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Erro ao preparar a consulta: ' . $con->error]);
    exit;
}

$stmt->bind_param("sss", $idTipoGasto, $idData, $qtGasto);

// Execute and return result
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Gasto registrado com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao registrar o gasto: ' . $stmt->error]);
}

$stmt->close();
$con->close();

?>
