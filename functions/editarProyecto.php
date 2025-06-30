<?php
require_once __DIR__ . '/../db/conection.php';

header('Content-Type: application/json');

// Sanitizar y validar entradas
$id_proyecto = intval($_POST['id_proyecto'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');

$response = [];

if ($id_proyecto && $nombre && $descripcion) {

    // Validación con expresiones regulares
    if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s\-]{3,50}$/", $nombre)) {
        echo json_encode([
            'status' => 'error',
            'message' => '⚠️ El nombre contiene caracteres inválidos. Solo letras, números, espacios y guiones.'
        ]);
        exit;
    }

    if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s\.,\-]{5,100}$/", $descripcion)) {
        echo json_encode([
            'status' => 'error',
            'message' => '⚠️ La descripción contiene caracteres inválidos. Solo letras, números, puntos, comas y guiones.'
        ]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE proyectos SET nombre = ?, descripcion = ? WHERE id = ?");
    if ($stmt) {
        try {
            $stmt->bind_param("ssi", $nombre, $descripcion, $id_proyecto);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response = [
                    'status' => 'success',
                    'message' => ''
                ];
            } else {
                $response = [
                    'status' => 'warning',
                    'message' => '⚠️ No se realizaron cambios o el proyecto no existe'
                ];
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $response = [
                'status' => 'error',
                'message' => '❌ Error al actualizar el proyecto',
                'debug' => $e->getMessage()
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => '❌ Error al preparar la consulta',
            'debug' => $conn->error
        ];
    }

} else {
    $response = [
        'status' => 'warning',
        'message' => '⛔ Todos los campos son obligatorios (ID, nombre, descripción)'
    ];
}

$conn->close();
echo json_encode($response);
