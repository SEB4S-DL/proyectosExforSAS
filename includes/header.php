<?php
require_once __DIR__ . '/../config.php';

// Obtener el nombre del archivo actual (sin ruta completa)
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<header class="main-header">
    <nav class="navbar">
        <div class="logo">🧠 Proyectos Exfor SAS</div>
        <ul class="nav-links">
            <li><a href="<?= BASE_URL ?>/index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Inicio</a></li>
            <li><a href="<?= BASE_URL ?>/pages/crearProyectoForm.php" class="<?= $currentPage === 'crearProyectoForm.php' ? 'active' : '' ?>">Crear proyecto</a></li>
            <li><a href="<?= BASE_URL ?>/pages/crearUsuarioForm.php" class="<?= $currentPage === 'crearUsuarioForm.php' ? 'active' : '' ?>">Crear usuario</a></li>
            <li><a href="<?= BASE_URL ?>/pages/Usuarios.php" class="<?= $currentPage === 'Usuarios.php' ? 'active' : '' ?>">Usuarios</a></li>
        </ul>
        <div class="menu-toggle" id="menu-toggle">☰</div>
    </nav>
</header>
