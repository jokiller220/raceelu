<?php require_once 'app/views/layouts/header.php'; ?>

<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <h2 class="fw-bold mb-4 text-center">Nos Promotions</h2>
        
        <?php if (empty($data['promotions'])): ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i> Il n'y a actuellement aucune promotion en cours. Revenez bientôt !
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <?php foreach($data['promotions'] as $product): ?>
                <div class="col">
                    <div class="card product-card h-100 shadow-sm transition-hover">
                        <div class="position-absolute top-0 end-0 m-2 z-1">
                            <span class="badge bg-danger fs-6">-<?= htmlspecialchars($product->pourcentage_remise) ?>%</span>
                        </div>
                        <a href="<?= BASE_URL ?>/product/show/<?= $product->id ?>">
                            <img src="<?= BASE_URL ?>/public/assets/images/<?= $product->image ?>" class="card-img-top" alt="<?= htmlspecialchars($product->nom) ?>" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x200.png?text=Image';">
                        </a>
                        <div class="card-body d-flex flex-column p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge badge-stock-in small"><i class="fas fa-check-circle me-1"></i>En stock</span>
                                <span class="small text-muted"><?= htmlspecialchars($product->unite) ?></span>
                            </div>
                            <h6 class="card-title fw-bold text-dark mb-1">
                                <a href="<?= BASE_URL ?>/product/show/<?= $product->id ?>" class="text-decoration-none text-dark"><?= htmlspecialchars($product->nom) ?></a>
                            </h6>
                            <p class="text-muted small mb-3"><?= htmlspecialchars($product->categorie_nom ?? 'Non catégorisé') ?></p>
                            
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <div>
                                    <?php 
                                        $prixRemise = $product->prix - ($product->prix * $product->pourcentage_remise / 100);
                                    ?>
                                    <span class="fs-5 fw-bold text-danger"><?= number_format($prixRemise, 0, ',', ' ') ?> FCFA</span><br>
                                    <span class="text-muted small text-decoration-line-through"><?= number_format($product->prix, 0, ',', ' ') ?> FCFA</span>
                                </div>
                                <button class="btn btn-dark-green btn-sm rounded-circle add-to-cart-btn" data-id="<?= $product->id ?>" title="Ajouter au panier">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
