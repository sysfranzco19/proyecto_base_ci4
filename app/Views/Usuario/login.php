<?= $this->extend('layouts/main') ?> <!-- Extiende tu layout base (ajusta el nombre) -->

<?= $this->section('title') ?>Iniciar Sesión<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-auto">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Iniciar Sesión</h4>
                </div>
                <div class="card-body">
                    <!-- Mensajes de error/success -->
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger"><?= session('error') ?></div>
                    <?php endif; ?>

                    <?php if (session('success')): ?>
                        <div class="alert alert-success"><?= session('success') ?></div>
                    <?php endif; ?>

                    <!-- Formulario -->
                    <form action="<?= base_url()."/" ?>" method="post" id="login" >
                        <?= csrf_field() ?> <!-- Protección CSRF -->

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input 
                                type="email" 
                                class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                                id="email" 
                                name="email" 
                                value="<?= old('email') ?>" 
                                required
                            >
                            <?php if (session('errors.email')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.email') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                                    id="password" 
                                    name="password" 
                                    required
                                >
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php if (session('errors.password')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Recordar sesión -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Recordar sesión</label>
                        </div>

                        <!-- Botón de envío -->
                        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                    </form>

                    <!-- Enlaces adicionales -->
                    <div class="mt-3 text-center">
                        <a href="<?= base_url('auth/forgot-password') ?>" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para mostrar/ocultar contraseña -->
<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
</script>
<?= $this->endSection() ?>