<?php
require_once __DIR__ . '/../config.php';

$title = "Crear proyecto";

ob_start();
?>
<h1>Crear Proyecto</h1>
<form id="crearProyecto" class="form-card">
    <div class="form-group">
        <label for="nombre">Nombre del Proyecto</label>
        <input type="text" id="nombre" name="nombre" class="input-control" placeholder="Ingrese el nombre del proyecto" required>
        <br>
        <label for="descripcion">Descripción</label>
        <input type="text" id="descripcion" name="descripcion" class="input-control" placeholder="Ingrese la descripción del proyecto" required>
    </div>

    <button type="submit" class="btn-primary">Crear Proyecto</button>
    <button type="button" class="btn-cancelar" onclick="window.location.href='/proyectosExforSAS/index.php'">Cancelar</button>

    <div class="form-response" id="respuesta"></div>
</form>


<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
