<?php
require_once __DIR__ . '/../db/conection.php';
header('Content-Type: application/json');

$proyecto_id = $_POST['proyecto_id'] ?? null;
$usuario_id  = $_POST['usuario_id'] ?? null;

if (!$proyecto_id || !$usuario_id) {
    echo json_encode([
        'status' => 'error',
        'message' => '⛔ Datos incompletos'
    ]);
    exit;
}

// Verificamos si ya existe el registro
$stmtCheck = $conn->prepare("SELECT estado FROM usuario_proyecto WHERE proyecto_id = ? AND usuario_id = ?");
$stmtCheck->bind_param("ii", $proyecto_id, $usuario_id);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

if ($result->num_rows > 0) {
    // Ya existe: actualizamos el estado a 1 (reactivamos)
    $stmtUpdate = $conn->prepare("UPDATE usuario_proyecto SET estado = 1 WHERE proyecto_id = ? AND usuario_id = ?");
    $stmtUpdate->bind_param("ii", $proyecto_id, $usuario_id);
    $stmtUpdate->execute();

    echo json_encode([
        'status' => 'success',
        'message' => '✅ Usuario reactivado en el proyecto'
    ]);
} else {
    // No existe: insertamos
    $stmtInsert = $conn->prepare("INSERT INTO usuario_proyecto (usuario_id, proyecto_id, estado) VALUES (?, ?, 1)");
    $stmtInsert->bind_param("ii", $usuario_id, $proyecto_id);
    $stmtInsert->execute();

    echo json_encode([
        'status' => 'success',
        'message' => '✅ Usuario asignado al proyecto con éxito'
    ]);
}

$conn->close();

?>