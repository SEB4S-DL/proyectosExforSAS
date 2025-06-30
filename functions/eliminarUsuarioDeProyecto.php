<?php
require_once __DIR__ . '/../db/conection.php';
header('Content-Type: application/json');

$usuario_id   = $_POST['usuario_id'] ?? null;
$proyecto_id  = $_POST['proyecto_id'] ?? null;

if (!$usuario_id || !$proyecto_id) {
    echo json_encode([
        'status' => 'error',
        'message' => '⛔ Datos incompletos.'
    ]);
    exit;
}

$stmt = $conn->prepare("UPDATE usuario_proyecto SET estado = 0 WHERE usuario_id = ? AND proyecto_id = ?");
if ($stmt) {
    try {
        $stmt->bind_param("ii", $usuario_id, $proyecto_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => '✅ Usuario eliminado del proyecto.'
            ]);
        } else {
            echo json_encode([
                'status' => 'warning',
                'message' => '⚠️ No se encontró la relación usuario-proyecto o ya estaba inactiva.'
            ]);
        }

    } catch (mysqli_sql_exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Error al eliminar usuario del proyecto.',
            'debug'   => $e->getMessage()
        ]);
    } finally {
        $stmt->close();
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ No se pudo preparar la consulta.',
        'debug' => $conn->error
    ]);
}

$conn->close();
?>
