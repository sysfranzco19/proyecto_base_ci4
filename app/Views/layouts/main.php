<!DOCTYPE html>
<html lang="es" data-coreui-theme="light">
<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?></title>
    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/coreui/css/coreui.min.css') ?>">
    <!-- Font Awesome (opcional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="c-app">
    <?= $this->include('layouts/sidebar') ?> <!-- Ejemplo: si usas sidebar -->
    <div class="c-wrapper">
        <?= $this->renderSection('content') ?>
    </div>
    <!-- CoreUI JS -->
    <script src="<?= base_url('assets/coreui/js/coreui.bundle.min.js') ?>"></script>
</body>
</html>

