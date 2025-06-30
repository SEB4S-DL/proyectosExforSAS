<?php
require_once __DIR__ . '/../db/conection.php';
header('Content-Type: application/json');

$id = $_POST['id_proyecto'] ?? null;

if (!$id) {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ ID no recibido'
    ]);
    exit;
}

$stmt = $conn->prepare("UPDATE proyectos SET estado = 0 WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode([
        'status' => 'success',
        'message' => '✅ Proyecto eliminado correctamente'
    ]);
    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Error al preparar la consulta'
    ]);
}
$conn->close();
