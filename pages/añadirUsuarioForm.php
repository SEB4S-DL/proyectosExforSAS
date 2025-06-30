<?php
require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/conection.php';

$title = "Añadir Usuario al Proyecto";

$idProyecto = $_POST['id_proyecto'] ?? null;

if (!$idProyecto) {
    echo "<p>❌ Proyecto no especificado.</p>";
    exit;
}

// Obtener usuarios disponibles (puedes filtrarlos si ya están asignados)
$stmt = $conn->prepare("
    SELECT u.id, u.nombre
    FROM usuarios u
    WHERE u.id NOT IN (
        SELECT usuario_id
        FROM usuario_proyecto
        WHERE proyecto_id = ? AND estado = 1
    )
");
$stmt->bind_param("i", $idProyecto);
$stmt->execute();
$usuarios = $stmt->get_result();


ob_start();
?>

<h1>Añadir Usuario</h1>

<form id="añadirUsuario" class="form-card">
    <input type="hidden" name="proyecto_id" value="<?= htmlspecialchars($idProyecto) ?>">

    <div class="form-group">
        <label for="usuario_id">Usuarios disponibles</label>
        <select name="usuario_id" id="usuario_id" class="input-control" required>
            <option value="" disabled selected>-- Seleccione un usuario --</option>
                <?php while ($usuario = $usuarios->fetch_assoc()): ?>
            <option value="<?= $usuario['id'] ?>"><?= htmlspecialchars($usuario['nombre']) ?></option>
        <?php endwhile; ?>
</select>
    </div>

    <button type="submit" class="btn-primary">Añadir usuario</button>
    <button type="button" class="btn-cancelar" onclick="window.location.href='<?= BASE_URL ?>/index.php'">Cancelar</button>
    <div class="form-response" id="respuesta"></div>
</form>


<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
