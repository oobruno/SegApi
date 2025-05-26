<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the existing connection script
require_once 'conexao.php';
$con->set_charset("utf8");

// Consulta todos os registros da tabela Gasto
$sql = "SELECT idGasto, idTipoGasto, idData, qtGasto FROM Gasto";

$result = $con->query($sql);

$response = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = array_map(fn($val) => mb_convert_encoding($val, 'UTF-8', 'ISO-8859-1'), $row);
    }
} else {
    $response[] = [
        "idGasto"     => 0,
        "idTipoGasto" => "",
        "idData"      => "",
        "qtGasto"     => ""
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);

$con->close();

?>
