<?php
require_once __DIR__ . '/config.php';

$title = "Inicio";

ob_start(); 
?>

<h1>Proyectos Disponibles</h1>
<div id="respuesta3"></div>

<?php
require_once __DIR__ . '/db/conection.php';

$sql = "SELECT 
    p.*, 
    COUNT(CASE WHEN up.estado = 1 THEN up.usuario_id END) AS cantidad_usuarios
FROM 
    proyectos p
LEFT JOIN 
    usuario_proyecto up ON p.id = up.proyecto_id
WHERE 
    p.estado = 1
GROUP BY 
    p.id;

";
$result = $conn->query($sql);
?>

<?php if ($result && $result->num_rows > 0): ?>
    <div class="project-list">
        <?php while ($proyecto = $result->fetch_assoc()): ?>
            <div class="project-card">
                <h2><?= htmlspecialchars($proyecto['nombre']) ?></h2>
                <p><strong>Descripción:</strong> <?= htmlspecialchars($proyecto['descripcion']) ?></p>
                <p><strong>Fecha de creación:</strong> <?= htmlspecialchars($proyecto['fecha_creacion']) ?></p>
                <p><strong>Usuarios:</strong> <?= htmlspecialchars($proyecto['cantidad_usuarios']) ?></p>

                <!-- Botón para editar -->
                <form action="<?= BASE_URL ?>/pages/editarProyectoForm.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id_proyecto" value="<?= $proyecto['id'] ?>">
                    <button type="submit" class="btn btn-editar">✏️ Editar</button>
                </form>

                <!-- Botón para eliminar -->
                <form class="eliminarProyecto" style="display:inline;">
                    <input type="hidden" name="id_proyecto" value="<?= $proyecto['id'] ?>">
                    <button type="submit" class="btn btn-eliminar">🗑️ Eliminar</button>
                </form>

                <form action="<?= BASE_URL ?>/pages/añadirUsuarioForm.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id_proyecto" value="<?= $proyecto['id'] ?>">
                    <button type="submit" class="btn btn-editar">Añadir usuario</button>
                </form>

                <form action="<?= BASE_URL ?>/pages/listarUsuarios.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id_proyecto" value="<?= $proyecto['id'] ?>">
                    <button type="submit" class="btn btn-editar">Listar usuarios</button>
                </form>
                

            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>No hay proyectos disponibles.</p>
<?php endif; ?>


<?php
$content = ob_get_clean(); 
require_once __DIR__ . '/layout.php';
