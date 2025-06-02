<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the existing connection script
require_once 'conexao.php';
$con->set_charset("utf8");

// Decode JSON input
$input = json_decode(file_get_contents('php://input'), true);
$nomeUsuario = isset($input['nomeUsuario']) ? trim($input['nomeUsuario']) : '';

// SQL com busca case-insensitive (pode ser removido se não quiser filtro)
$sql = "SELECT idUsuario, idEmail, idSenha, idNumero, nomeUsuario
        FROM Usuario
        WHERE LOWER(nomeUsuario) LIKE LOWER(?)";

$stmt = $con->prepare($sql);
$likeParam = '%' . $nomeUsuario . '%';
$stmt->bind_param('s', $likeParam);

$stmt->execute();
$result = $stmt->get_result();

$response = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = array_map(fn($val) => mb_convert_encoding($val, 'UTF-8', 'ISO-8859-1'), $row);
    }
} else {
    $response[] = [
        "idUsuario"    => 0,
        "idEmail"      => "",
        "idSenha"      => "",
        "idNumero"     => "",
        "nomeUsuario"  => ""
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);

$stmt->close();
$con->close();

?>
