<?php
require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/conection.php';

$title = "Proyectos del Usuario";

// Verifica que llegue el ID del usuario
$usuario_id = $_POST['usuario_id'] ?? null;

if (!$usuario_id) {
    echo "<p>❌ Usuario no especificado.</p>";
    exit;
}

// Obtener datos del usuario
$stmtUsuario = $conn->prepare("SELECT nombre FROM usuarios WHERE id = ?");
$stmtUsuario->bind_param("i", $usuario_id);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();
$usuario = $resultUsuario->fetch_assoc();

// Obtener proyectos asignados al usuario
$sql = "SELECT p.nombre 
        FROM proyectos p
        INNER JOIN usuario_proyecto up ON p.id = up.proyecto_id
        WHERE up.usuario_id = ? AND up.estado = 1 AND p.estado = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultProyectos = $stmt->get_result();

ob_start();
?>

<h1>Proyectos de <?= htmlspecialchars($usuario['nombre']) ?></h1>
<div class="text-center">
    <button class="btn-volver" onclick="window.location.href='<?= BASE_URL ?>/pages/usuarios.php'">⏪ Volver</button>
</div>

<?php if ($resultProyectos->num_rows > 0): ?>
    <ul class="user-list">
        <?php while ($proyecto = $resultProyectos->fetch_assoc()): ?>
            <li>📁 <?= htmlspecialchars($proyecto['nombre']) ?></li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>Este usuario no tiene proyectos asignados.</p>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
