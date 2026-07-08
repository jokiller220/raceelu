<?php require_once 'app/views/layouts/header.php'; ?>

<section class="login-section py-5 bg-light" style="min-height: 70vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold">Créer un compte</h3>
                            <p class="text-muted">Rejoignez Race Élu pour commander en ligne</p>
                        </div>

                        <?php if(isset($data['error'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($data['error']) ?></div>
                        <?php endif; ?>

                        <form action="<?= BASE_URL ?>/auth/register" method="POST">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Nom complet</label>
                                <input type="text" name="nom" class="form-control py-2" required placeholder="Ex: Koffi Mensah">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Email</label>
                                <input type="email" name="email" class="form-control py-2" required placeholder="Ex: koffi@gmail.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Téléphone</label>
                                <input type="text" name="telephone" class="form-control py-2" placeholder="Ex: +228 90 00 00 00">
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Mot de passe</label>
                                    <input type="password" name="password" class="form-control py-2" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Confirmer le mot de passe</label>
                                    <input type="password" name="password_confirm" class="form-control py-2" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark-green w-100 py-2 fw-bold">S'inscrire</button>
                        </form>
                        
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted small">Vous avez déjà un compte ? <a href="<?= BASE_URL ?>/auth/login" class="text-dark-green fw-bold text-decoration-none">Se connecter</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
