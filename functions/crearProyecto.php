<?php
require_once __DIR__ . '/../db/conection.php';

// Forzar que la respuesta sea JSON SIEMPRE
header('Content-Type: application/json');

$nombre = $_POST['nombre'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';

$response = []; // Arreglo para la respuesta final

if (!empty($nombre) && !empty($descripcion)) {
    $stmt = $conn->prepare("INSERT INTO proyectos (nombre, descripcion) VALUES (?, ?)");

    if ($stmt) {
        try {
            $stmt->bind_param("ss", $nombre, $descripcion);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response = [
                    'status' => 'success',
                    'message' => '✅ Proyecto guardado con éxito'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => '⚠️ No se pudo guardar el proyecto'
                ];
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $response = [
                'status' => 'error',
                'message' => '❌ Error al guardar el proyecto',
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
        'message' => '⛔ Todos los campos son obligatorios'
    ];
}

$conn->close();

// Devolver JSON
echo json_encode($response);
?>