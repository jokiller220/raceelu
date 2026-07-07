<?php require_once 'app/views/layouts/header.php'; ?>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4">
                    <div class="text-center mb-4">
                        <div class="bg-light-green mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px;">
                            <i class="fas fa-truck-loading fs-2 text-dark-green"></i>
                        </div>
                        <h2 class="fw-bold outfit-font">Suivre ma commande</h2>
                        <p class="text-muted">Entrez vos informations pour connaître l'état de votre livraison.</p>
                    </div>

                    <?php if(isset($data['error'])): ?>
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <i class="fas fa-exclamation-circle me-2"></i> <?= h($data['error']) ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>/order/track" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Numéro de commande</label>
                            <input type="text" name="order_id" class="form-control form-control-lg" placeholder="Ex: 123" required>
                            <small class="text-muted">Le numéro que vous avez reçu par email ou SMS.</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Téléphone</label>
                            <input type="text" name="telephone" class="form-control form-control-lg" placeholder="Ex: +221..." required>
                            <small class="text-muted">Le numéro utilisé lors de la commande.</small>
                        </div>
                        <button type="submit" class="btn btn-dark-green w-100 py-3 fw-bold rounded-3 shadow-sm transition-hover">
                            <i class="fas fa-search me-2"></i> Rechercher ma commande
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
