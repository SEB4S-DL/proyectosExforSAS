<?php
require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/conection.php';

$title = "Usuarios";

// Consulta para obtener usuarios activos
$sql = "SELECT id, nombre, email FROM usuarios";
$resultUsuarios = $conn->query($sql);

ob_start();
?>

<h1>Usuarios</h1>
<div class="text-center">
    <button class="btn-volver" onclick="window.location.href='/proyectosExforSAS/index.php'">⏪ Volver</button>
</div>

<?php if ($resultUsuarios && $resultUsuarios->num_rows > 0): ?>
    <ul class="user-list">
        <?php while ($usuario = $resultUsuarios->fetch_assoc()): ?>
            <li>
                <strong><?= htmlspecialchars($usuario['nombre']) ?></strong><br>
                📧 <?= htmlspecialchars($usuario['email']) ?><br>
                <form method="POST" action="<?= BASE_URL ?>/pages/proyectosPorUsuario.php" style="display:inline;">
                    <input type="hidden" name="usuario_id" value="<?= $usuario['id'] ?>">
                    <button type="submit" class="btn btn-editar">📁 Ver proyectos</button>
                </form>
            </li>

        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No hay usuarios</p>
<?php endif; ?>

<br>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>

