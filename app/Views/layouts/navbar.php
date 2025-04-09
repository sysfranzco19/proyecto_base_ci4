<header class="c-header c-header-light">
    <div class="c-header-nav px-3">
        <!-- Botón para mostrar/ocultar sidebar (en móviles) -->
        <button class="c-header-toggler c-class-toggler d-lg-none" type="button" data-coreui-toggle="sidebar">
            <i class="fas fa-bars"></i>
        </button>

        <!-- User info y logout -->
        <ul class="c-header-nav ms-auto">
            <li class="c-header-nav-item">
                <span class="c-header-nav-link">
                    <i class="fas fa-user me-2"></i>
                    <?= session('userData.nombre') ?? 'Usuario' ?>
                </span>
            </li>
            <li class="c-header-nav-item">
                <a class="c-header-nav-link" href="<?= base_url('auth/logout') ?>">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </li>
        </ul>
    </div>
</header>