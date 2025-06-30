<?php
require_once __DIR__ . '/../config.php';

$title = "Crear Usuario";

ob_start();
?>
<h1>Crear Usuario</h1>
<form id="crearUsuario" class="form-card">
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" class="input-control" required placeholder="Ingrese el nombre del usuario">
    </div>

    <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" class="input-control" required placeholder="Ingrese el email del usuario">
    </div>

    <button type="submit" class="btn-primary">Crear usuario</button>
    <button type="button" class="btn-cancelar" onclick="window.location.href='/proyectosExforSAS/index.php'">Cancelar</button>
    <div id="respuesta" class="form-response" style="margin-top: 10px;"></div>
</form>




<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
