<?php
// Limpio desde la primera línea sin espacios
$host = 'localhost';//cambiar si es necesario
$user = 'root';//cambiar si es necesario
$password = '123456';//cambiar si es necesario
$database = 'crud_db';

$conn = new mysqli($host, $user, $password, $database);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // ¡clave!

if ($conn->connect_error) {
    // Devolver error como JSON si la conexión falla
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al conectar con la base de datos',
        'debug' => $conn->connect_error
    ]);
    exit;
}

$conn->set_charset('utf8');
?>