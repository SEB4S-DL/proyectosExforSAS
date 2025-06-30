<?php
require_once __DIR__ . '/../config.php';
require_once ROOT_PATH . '/db/conection.php';

$title = "Editar Proyecto";

$proyecto_id = $_POST['id_proyecto'] ?? null;
$nombre = '';
$descripcion = '';

if ($proyecto_id) {
    $stmt = $conn->prepare("SELECT nombre, descripcion FROM proyectos WHERE id = ?");
    $stmt->bind_param("i", $proyecto_id);
    $stmt->execute();
    $stmt->bind_result($nombre, $descripcion);
    $stmt->fetch();
    $stmt->close();
}

ob_start();
?>
<h1>Editar Proyecto</h1>
<form id="editarProyecto" class="form-card" method="POST" action="<?= BASE_URL ?>/functions/editarProyecto.php">
    <input type="hidden" name="id_proyecto" value="<?= htmlspecialchars($proyecto_id) ?>">

    <div class="form-group">
        <label for="nombre">Nombre:</label>
       <input type="text" id="nombre" name="nombre" class="input-control" required 
       value="<?= htmlspecialchars($nombre) ?>" 
       placeholder="Ingrese el nombre del proyecto"
       pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s\-]{3,50}"
       title="Solo letras. Mínimo 3 caracteres">
    </div>

    <div class="form-group">
        <label for="descripcion">Descripción</label>
       <input type="text" id="descripcion" name="descripcion" class="input-control" required 
       value="<?= htmlspecialchars($descripcion) ?>" 
       placeholder="Ingrese la descripción del proyecto"
       pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s\.,\-]{5,100}"
       title="Solo letras. Mínimo 5 caracteres">
    </div>

    <button type="submit" class="btn-primary">Editar proyecto</button>
    <button type="button" class="btn-cancelar" onclick="window.location.href='<?= BASE_URL ?>/index.php'">Cancelar</button>
    <div id="respuesta" class="form-response"></div>
</form>


<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';