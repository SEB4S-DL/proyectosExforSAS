<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Mi sitio' ?></title>
    
    <link rel="icon" href="<?= BASE_URL ?>/assets/icons/proyecto.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/footer.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/crearUsuarioForm.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/crearProyectoForm.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/index.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/editarProyectoForm.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/listarUsuarios.css">
</head>
<body>
    <?php require_once ROOT_PATH . '/includes/header.php'; ?>

    <div class="container">
        <?= $content ?>
    </div>

    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
</body>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo BASE_URL; ?>/js/header.js"></script>
<script src="<?php echo BASE_URL; ?>/js/crearUsuarioFetch.js"></script>
<script src="<?php echo BASE_URL; ?>/js/crearProyectoFetch.js"></script>
<script src="<?php echo BASE_URL; ?>/js/editarProyectoFetch.js"></script>
<script src="<?php echo BASE_URL; ?>/js/añadirUsuarioFetch.js"></script>
<script src="<?php echo BASE_URL; ?>/js/eliminarProyectoFetch.js"></script>
<script src="<?php echo BASE_URL; ?>/js/eliminarUsuarioFetch.js"></script>
</html>
