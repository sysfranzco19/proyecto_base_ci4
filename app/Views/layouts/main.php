<!DOCTYPE html>
<html lang="es" data-coreui-theme="light">
<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?></title>
    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/coreui/css/coreui.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="c-app">
    <!-- Sidebar -->
    <?= $this->include('layouts/sidebar') ?>

    <div class="c-wrapper">
        <!-- Navbar -->
        <?= $this->include('layouts/navbar') ?>

        <!-- Contenido Principal -->
        <div class="c-body">
            <main class="c-main">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- CoreUI JS -->
    <script src="<?= base_url('assets/coreui/js/coreui.bundle.min.js') ?>"></script>
    <!-- Script para el toggle de tema -->
    <script>
        document.getElementById('themeToggle').addEventListener('click', () => {
            const html = document.documentElement;
            const theme = html.getAttribute('data-coreui-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-coreui-theme', theme);
            localStorage.setItem('coreui-theme', theme);
        });
    </script>
</body>
</html>