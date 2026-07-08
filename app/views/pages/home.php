<?php require_once 'app/views/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section text-white position-relative overflow-hidden">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start">
                <h1 class="display-4 fw-bolder mb-4" style="line-height: 1.2;">VOTRE PARTENAIRE<br>DE CONFIANCE EN<br><span class="text-yellow">ALIMENTATION GÉNÉRALE<br>EN GROS</span></h1>
                <p class="lead mb-4 fs-5 text-white-50">Des produits de qualité, au meilleur prix, livrés partout.</p>
                <a href="<?= BASE_URL ?>/shop" class="btn btn-yellow btn-lg fw-bold px-5 py-3 rounded-pill shadow-sm transition-hover">Découvrir nos produits</a>
            </div>
            <div class="col-lg-5 text-center text-lg-end">
                <img src="<?= BASE_URL ?>/public/assets/images/hero-products.png" alt="Produits en gros" class="hero-image" onerror="this.onerror=null; this.src='https://via.placeholder.com/520x520.png?text=Image';">
            </div>
        </div>
    </div>
    <!-- Décoration de fond (courbe) -->
    <div class="hero-shape position-absolute bottom-0 start-0 w-100" style="height: 100px; background: white; border-radius: 50% 50% 0 0 / 100% 100% 0 0; transform: translateY(50%);"></div>
</section>

<!-- Quick Actions for Mamans (Simplified UI) -->
<section class="quick-actions py-4 bg-white position-relative" style="z-index: 10;">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md-4">
                <a href="<?= BASE_URL ?>/shop" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100 transition-hover" style="background: #fff3e0;">
                        <div class="bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-shopping-cart fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">FAIRE MES ACHATS</h6>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4">
                <a href="<?= BASE_URL ?>/order/track" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100 transition-hover" style="background: #e3f2fd;">
                        <div class="bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-truck fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">SUIVRE MA COMMANDE</h6>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', get_setting('site_contact_phone')) ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100 transition-hover" style="background: #e8f5e9;">
                        <div class="bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fab fa-whatsapp fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">BESOIN D'AIDE (WHATSAPP)</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-5 bg-white position-relative" style="z-index: 3; margin-top: 40px;">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6">
                <div class="feature-card p-3">
                    <i class="fas fa-truck-fast fs-1 text-dark-green mb-3"></i>
                    <h5 class="fw-bold mb-1">Livraison rapide</h5>
                    <p class="text-muted small mb-0">Partout dans le pays</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="feature-card p-3">
                    <i class="fas fa-tags fs-1 text-dark-green mb-3"></i>
                    <h5 class="fw-bold mb-1">Meilleurs prix</h5>
                    <p class="text-muted small mb-0">Prix gros très compétitifs</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="feature-card p-3">
                    <i class="fas fa-award fs-1 text-dark-green mb-3"></i>
                    <h5 class="fw-bold mb-1">Produits de qualité</h5>
                    <p class="text-muted small mb-0">Qualité garantie</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="feature-card p-3">
                    <i class="fas fa-shield-alt fs-1 text-dark-green mb-3"></i>
                    <h5 class="fw-bold mb-1">Paiement sécurisé</h5>
                    <p class="text-muted small mb-0">Paiement à la livraison ou en ligne</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Categories -->
<section class="categories-section py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">Catégories populaires</h3>
            <a href="<?= BASE_URL ?>/shop" class="text-dark-green text-decoration-none fw-medium">Voir toutes les catégories <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-8 g-3 text-center">
            <?php foreach($data['categories'] as $cat): ?>
            <div class="col">
                <a href="<?= BASE_URL ?>/shop/category/<?= $cat->slug ?>" class="text-decoration-none text-dark">
                    <div class="category-card bg-white rounded shadow-sm p-3 mb-2 transition-hover">
                        <span class="d-block small fw-medium"><?= htmlspecialchars($cat->nom) ?></span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Popular Products -->
<section class="products-section py-5 bg-white">
    <div class="container">
        <h3 class="fw-bold mb-4 text-center">Nos produits les plus populaires</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php foreach($data['products'] as $product): ?>
            <div class="col">
                <div class="card product-card h-100 shadow-sm transition-hover">
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
                                <?php if(!empty($product->prix_promo)): ?>
                                    <span class="fs-5 fw-bold text-danger"><?= number_format($product->prix_promo, 0, ',', ' ') ?> FCFA</span>
                                    <span class="text-muted small text-decoration-line-through ms-1"><?= number_format($product->prix, 0, ',', ' ') ?></span>
                                <?php else: ?>
                                    <span class="fs-5 fw-bold text-dark"><?= number_format($product->prix, 0, ',', ' ') ?> FCFA</span>
                                <?php endif; ?>
                                <div class="text-success small fw-bold" style="font-size: 0.7rem;"><i class="fas fa-tag"></i> Prix de gros</div>
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
        <div class="text-center mt-5">
            <a href="<?= BASE_URL ?>/shop" class="btn btn-outline-dark px-4 py-2 fw-medium rounded-pill">Voir tous nos produits</a>
        </div>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
