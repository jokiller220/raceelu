<?php require_once 'app/views/layouts/header.php'; ?>

<!-- Breadcrumb -->
<div class="bg-light py-3 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none text-muted">Accueil</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/shop" class="text-decoration-none text-muted">Boutique</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/shop/category/<?= strtolower(str_replace(' ', '-', $data['product']->categorie_nom ?? 'non-categorise')) ?>" class="text-decoration-none text-muted"><?= htmlspecialchars($data['product']->categorie_nom ?? 'Non catégorisé') ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($data['product']->nom) ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="product-detail-section py-5 bg-white">
    <div class="container">
        <div class="row gx-5">
            <!-- Product Image -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="bg-light p-4 rounded text-center" style="height: 500px; display: flex; align-items: center; justify-content: center;">
                    <img src="<?= BASE_URL ?>/public/assets/images/<?= $data['product']->image ?>" alt="<?= htmlspecialchars($data['product']->nom) ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;" onerror="this.onerror=null; this.src='https://via.placeholder.com/500x500.png?text=Image';">
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <h2 class="fw-bold text-dark mb-2"><?= htmlspecialchars($data['product']->nom) ?></h2>
                <div class="mb-3">
                    <?php if(!empty($data['product']->prix_promo)): ?>
                        <span class="fs-3 fw-bold text-danger"><?= number_format($data['product']->prix_promo, 0, ',', ' ') ?> FCFA</span>
                        <span class="text-muted fs-5 text-decoration-line-through ms-2"><?= number_format($data['product']->prix, 0, ',', ' ') ?> FCFA</span>
                        <span class="badge bg-danger ms-2">PROMO</span>
                    <?php else: ?>
                        <span class="fs-3 fw-bold text-dark"><?= number_format($data['product']->prix, 0, ',', ' ') ?> FCFA</span>
                    <?php endif; ?>
                </div>
                
                <p class="text-muted mb-4"><?= nl2br(htmlspecialchars($data['product']->description)) ?></p>

                <div class="mb-4 d-flex align-items-center">
                    <?php if($data['product']->stock > 0): ?>
                        <span class="text-success fw-medium"><i class="fas fa-check me-2"></i>En stock (<?= $data['product']->stock ?> disponibles)</span>
                    <?php else: ?>
                        <span class="text-danger fw-medium"><i class="fas fa-times me-2"></i>Rupture de stock</span>
                    <?php endif; ?>
                </div>

                <hr class="mb-4">

                <form id="add-to-cart-form" class="mb-4">
                    <input type="hidden" name="product_id" value="<?= $data['product']->id ?>">
                    <div class="row align-items-center gx-3 mb-4">
                        <div class="col-auto">
                            <label class="form-label fw-medium mb-0">Quantité:</label>
                        </div>
                        <div class="col-auto">
                            <div class="input-group" style="width: 120px;">
                                <button class="btn btn-outline-secondary" type="button" id="btn-minus">-</button>
                                <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="<?= $data['product']->stock ?>">
                                <button class="btn btn-outline-secondary" type="button" id="btn-plus">+</button>
                            </div>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-dark-green w-100 py-2 fw-bold add-to-cart-btn" data-id="<?= $data['product']->id ?>" <?= $data['product']->stock <= 0 ? 'disabled' : '' ?>>
                                <i class="fas fa-shopping-basket me-2"></i> Ajouter au panier
                            </button>
                        </div>
                    </div>
                </form>

                <div class="bg-light p-3 rounded">
                    <p class="mb-1"><span class="text-muted">Catégorie:</span> <a href="<?= BASE_URL ?>/shop/category/<?= strtolower(str_replace(' ', '-', $data['product']->categorie_nom ?? 'non-categorise')) ?>" class="text-decoration-none text-dark-green fw-medium"><?= htmlspecialchars($data['product']->categorie_nom ?? 'Non catégorisé') ?></a></p>
                    <p class="mb-0"><span class="text-muted">Partager:</span> 
                        <a href="#" class="text-muted ms-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-muted ms-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted ms-2"><i class="fab fa-whatsapp"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="related-products py-5 bg-light">
    <div class="container">
        <h3 class="fw-bold mb-4 outfit-font">Produits similaires</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php 
            $count = 0;
            foreach($data['related_products'] as $related): 
                if($related->id == $data['product']->id) continue;
                if($count >= 4) break;
                $count++;
            ?>
            <div class="col">
                <div class="card product-card h-100 shadow-sm transition-hover">
                    <a href="<?= BASE_URL ?>/product/show/<?= $related->id ?>">
                        <img src="<?= BASE_URL ?>/public/assets/images/<?= $related->image ?>" class="card-img-top" alt="<?= htmlspecialchars($related->nom) ?>" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x200.png?text=Image';">
                    </a>
                    <div class="card-body d-flex flex-column p-3">
                        <h6 class="card-title fw-bold text-dark mb-1">
                            <a href="<?= BASE_URL ?>/product/show/<?= $related->id ?>" class="text-decoration-none text-dark"><?= htmlspecialchars($related->nom) ?></a>
                        </h6>
                        <div class="mt-auto d-flex justify-content-between align-items-center mt-2">
                            <span class="fw-bold text-dark"><?= number_format($related->prix, 0, ',', ' ') ?> FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row gx-5">
            <div class="col-lg-7">
                <h3 class="fw-bold mb-4 outfit-font">Avis des clients (<?= count($data['reviews']) ?>)</h3>
                
                <?php if(empty($data['reviews'])): ?>
                    <p class="text-muted">Soyez le premier à donner votre avis sur ce produit !</p>
                <?php else: ?>
                    <?php foreach($data['reviews'] as $review): ?>
                        <div class="card border-0 shadow-sm rounded-4 p-4 mb-3 bg-light">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold text-dark"><?= h($review->user_nom) ?></span>
                                <div class="text-yellow">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i class="<?= ($i <= $review->note) ? 'fas' : 'far' ?> fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="mb-0 text-muted small"><?= nl2br(h($review->commentaire)) ?></p>
                            <small class="text-muted mt-2 d-block" style="font-size: 0.7rem;">Publié le <?= date('d/m/Y', strtotime($review->created_at)) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-dark-green text-white">
                    <h4 class="fw-bold mb-4 outfit-font">Laisser un avis</h4>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <form action="<?= BASE_URL ?>/product/addReview" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $data['product']->id ?>">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Note</label>
                                <select name="note" class="form-select border-0 shadow-none" required>
                                    <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
                                    <option value="4">⭐⭐⭐⭐ (Très bien)</option>
                                    <option value="3">⭐⭐⭐ (Moyen)</option>
                                    <option value="2">⭐⭐ (Décevant)</option>
                                    <option value="1">⭐ (Mauvais)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Votre commentaire</label>
                                <textarea name="commentaire" class="form-control border-0 shadow-none" rows="4" placeholder="Qu'avez-vous pensé du produit ?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-yellow w-100 fw-bold rounded-pill py-2 shadow-sm">
                                Publier mon avis
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-lock fs-1 mb-3 text-white-50"></i>
                            <p>Vous devez être connecté pour laisser un avis.</p>
                            <a href="<?= BASE_URL ?>/auth/login" class="btn btn-yellow rounded-pill px-4 fw-bold">Se connecter</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('btn-minus').addEventListener('click', function() {
        let input = document.querySelector('input[name="quantity"]');
        if(parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    });
    document.getElementById('btn-plus').addEventListener('click', function() {
        let input = document.querySelector('input[name="quantity"]');
        let max = parseInt(input.getAttribute('max'));
        if(parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    });
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>
