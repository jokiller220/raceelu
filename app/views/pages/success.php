<?php require_once 'app/views/layouts/header.php'; ?>

<section class="success-section py-5 bg-white text-center" style="min-height: 60vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="mb-4 text-success">
                    <i class="fas fa-check-circle" style="font-size: 5rem;"></i>
                </div>
                <h2 class="fw-bold mb-3 outfit-font">Commande confirmée !</h2>
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-light">
                    <p class="text-muted mb-2">Votre numéro de commande est le :</p>
                    <h3 class="fw-bold text-dark-green mb-0">#<?= $data['order_id'] ?></h3>
                    <?php if(isset($data['points_gagnes']) && $data['points_gagnes'] > 0): ?>
                        <div class="mt-2 text-dark fw-bold small">
                            <i class="fas fa-coins text-yellow me-1"></i> Vous avez gagné <?= $data['points_gagnes'] ?> points !
                        </div>
                    <?php endif; ?>
                </div>
                <p class="text-muted lead mb-4">Merci pour votre confiance. Votre commande est déjà en cours de préparation par notre équipe.</p>
                
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mb-5">
                    <?php if(isset($data['whatsapp_url'])): ?>
                        <a href="<?= $data['whatsapp_url'] ?>" target="_blank" class="btn rounded-pill px-4 py-2 fw-bold shadow-sm" style="background-color: #25D366; color: white; border-color: #25D366;">
                            <i class="fab fa-whatsapp me-2" style="font-size: 1.2rem;"></i> Confirmer sur WhatsApp
                        </a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/order/track?id=<?= $data['order_id'] ?>&tel=<?= urlencode($data['telephone']) ?>" class="btn btn-yellow rounded-pill px-4 py-2 fw-bold shadow-sm">
                        <i class="fas fa-search me-2"></i> Suivre ma commande
                    </a>
                    <a href="<?= BASE_URL ?>" class="btn btn-outline-dark-green rounded-pill px-4 py-2 fw-bold">
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
