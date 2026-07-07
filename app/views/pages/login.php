<?php require_once 'app/views/layouts/header.php'; ?>

<section class="login-section py-5 bg-light" style="min-height: 70vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold">Connexion</h3>
                            <p class="text-muted">Accédez à votre compte Race Élu</p>
                        </div>

                        <?php if(isset($data['error'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($data['error']) ?></div>
                        <?php endif; ?>

                        <form action="<?= BASE_URL ?>/auth/login" method="POST">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Email</label>
                                <input type="email" name="email" class="form-control py-2" required placeholder="Ex: admin@race-elu.com">
                            </div>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label fw-medium">Mot de passe</label>
                                    <a href="#" class="text-decoration-none text-dark-green small">Oublié ?</a>
                                </div>
                                <input type="password" name="password" class="form-control py-2" required placeholder="Ex: admin123">
                            </div>
                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label small" for="remember">Se souvenir de moi</label>
                            </div>
                            <button type="submit" class="btn btn-dark-green w-100 py-2 fw-bold">Se connecter</button>
                        </form>
                        
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted small">Nouveau client ? <a href="<?= BASE_URL ?>/auth/register" class="text-dark-green fw-bold text-decoration-none">Créer un compte</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
