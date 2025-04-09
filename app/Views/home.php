<?= $this->extend('layouts/main') ?> <!-- Extiende tu layout base (el mismo que usaste en login) -->

<?= $this->section('title') ?>Inicio<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="c-wrapper">
    <!-- Barra superior (navbar) -->
    <header class="c-header c-header-light">
        <div class="c-header-nav px-3">
            <span class="fw-bold">Bienvenido, <?= session('userData.nombre') ?? 'Usuario' ?></span>
            
            <!-- Botón para cambiar tema (light/dark) -->
            <button class="btn btn-link ms-3" id="themeToggle">
                <i class="fas fa-moon"></i>
            </button>
            
            <!-- Botón de logout -->
            <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger ms-2">
                <i class="fas fa-sign-out-alt"></i> Salir
            </a>
        </div>
    </header>

    <!-- Contenido principal -->
    <div class="c-body">
        <main class="c-main">
            <div class="container-fluid">
                <!-- Tarjetas de resumen -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h5 class="card-title">Usuarios</h5>
                                <p class="display-4">25</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-success">
                            <div class="card-body">
                                <h5 class="card-title">Tareas</h5>
                                <p class="display-4">12</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h5 class="card-title">Mensajes</h5>
                                <p class="display-4">5</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfica o tabla de ejemplo -->
                <div class="card">
                    <div class="card-header">
                        <h3>Actividad Reciente</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Aquí puedes agregar una tabla, gráfica o cualquier contenido relevante.</p>
                        <canvas id="myChart" height="100"></canvas> <!-- Ejemplo para gráficos con Chart.js -->
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Script para el toggle de tema (light/dark) -->
<script>
    // Reutiliza el mismo script del login o añade esto:
    document.getElementById('themeToggle').addEventListener('click', () => {
        const html = document.documentElement;
        const theme = html.getAttribute('data-coreui-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-coreui-theme', theme);
        localStorage.setItem('coreui-theme', theme);
    });
</script>
<?= $this->endSection() ?>