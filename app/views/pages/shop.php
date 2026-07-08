<?php require_once 'app/views/layouts/header.php'; ?>

<!-- Breadcrumb -->
<div class="bg-light py-3 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none text-muted">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Boutique</li>
                <?php if($data['current_category'] != 'Toutes les catégories'): ?>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($data['current_category']) ?></li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</div>

<section class="shop-section py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar / Categories -->
            <div class="col-lg-3 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold py-3">
                        Catégories
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item <?= ($data['current_category'] == 'Toutes les catégories') ? 'bg-light fw-bold' : '' ?>">
                            <a href="<?= BASE_URL ?>/shop" class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                Toutes les catégories
                            </a>
                        </li>
                        <?php foreach($data['categories'] as $cat): ?>
                        <li class="list-group-item <?= ($data['current_category'] == $cat->nom) ? 'bg-light fw-bold text-dark-green' : '' ?>">
                            <a href="<?= BASE_URL ?>/shop/category/<?= $cat->slug ?>" class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                <?= htmlspecialchars($cat->nom) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <!-- Search & Filter Bar -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                    <div class="card-body p-3">
                        <form action="<?= BASE_URL ?>/shop" method="GET" class="row g-3 align-items-center">
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Chercher un produit (ex: Riz, Huile, Savon...)" value="<?= h($data['search'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="d-flex align-items-center">
                                    <label class="small text-muted me-2 text-nowrap">Trier par :</label>
                                    <select name="sort" class="form-select" onchange="this.form.submit()">
                                        <option value="newest" <?= ($data['sort'] == 'newest') ? 'selected' : '' ?>>Plus récents</option>
                                        <option value="price_asc" <?= ($data['sort'] == 'price_asc') ? 'selected' : '' ?>>Prix croissant</option>
                                        <option value="price_desc" <?= ($data['sort'] == 'price_desc') ? 'selected' : '' ?>>Prix décroissant</option>
                                        <option value="oldest" <?= ($data['sort'] == 'oldest') ? 'selected' : '' ?>>Plus anciens</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0 outfit-font text-dark-green"><?= htmlspecialchars($data['current_category']) ?></h4>
                    <span class="text-muted small"><?= count($data['products']) ?> produits trouvés</span>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php if(empty($data['products'])): ?>
                        <div class="col-12 text-center py-5">
                            <p class="text-muted fs-5">Aucun produit trouvé dans cette catégorie.</p>
                        </div>
                    <?php else: ?>
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
                                    
                                    <div class="mt-auto">
                                        <div class="mb-3">
                                            <?php if(!empty($product->prix_promo)): ?>
                                                <span class="fs-5 fw-bold text-danger"><?= number_format($product->prix_promo, 0, ',', ' ') ?> FCFA</span>
                                                <span class="text-muted small text-decoration-line-through ms-1"><?= number_format($product->prix, 0, ',', ' ') ?></span>
                                            <?php else: ?>
                                                <span class="fs-5 fw-bold text-dark"><?= number_format($product->prix, 0, ',', ' ') ?> FCFA</span>
                                            <?php endif; ?>
                                            <div class="text-success small fw-bold" style="font-size: 0.7rem;"><i class="fas fa-tag"></i> Prix de gros</div>
                                        </div>
                                        <button class="btn btn-dark-green w-100 btn-sm fw-medium add-to-cart-btn" data-id="<?= $product->id ?>">
                                            <i class="fas fa-shopping-basket me-2"></i> Ajouter au panier
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
