<?php require_once 'app/views/layouts/header.php'; ?>

<!-- Breadcrumb -->
<div class="bg-light py-3 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none text-muted">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mon panier</li>
            </ol>
        </nav>
    </div>
</div>

<section class="cart-section py-5 bg-white">
    <div class="container">
        <h2 class="fw-bold mb-4">Mon panier</h2>

        <?php if(empty($data['cart_items'])): ?>
            <div class="text-center py-5 bg-light rounded">
                <i class="fas fa-shopping-cart fs-1 text-muted mb-3"></i>
                <h4 class="text-muted">Votre panier est vide.</h4>
                <p class="mb-4">Découvrez nos produits et commencez vos achats !</p>
                <a href="<?= BASE_URL ?>/shop" class="btn btn-dark-green rounded-pill px-4">Aller à la boutique</a>
            </div>
        <?php else: ?>
            <div class="row gx-5">
                <!-- Cart Items -->
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="py-3">Produit</th>
                                    <th scope="col" class="py-3">Prix</th>
                                    <th scope="col" class="py-3">Quantité</th>
                                    <th scope="col" class="py-3">Sous-total</th>
                                    <th scope="col" class="py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['cart_items'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= BASE_URL ?>/public/assets/images/<?= $item['product']->image ?>" alt="<?= htmlspecialchars($item['product']->nom) ?>" style="width: 60px; height: 60px; object-fit: contain;" class="bg-light p-1 rounded me-3" onerror="this.onerror=null; this.src='https://via.placeholder.com/60x60.png';">
                                            <div>
                                                <a href="<?= BASE_URL ?>/product/show/<?= $item['product']->id ?>" class="text-decoration-none text-dark fw-bold"><?= htmlspecialchars($item['product']->nom) ?></a>
                                                <div class="small text-muted"><?= htmlspecialchars($item['product']->unite) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-medium"><?= number_format($item['price'], 0, ',', ' ') ?> FCFA</td>
                                    <td>
                                        <form action="<?= BASE_URL ?>/cart/update" method="POST" class="d-flex align-items-center">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="product_id" value="<?= $item['product']->id ?>">
                                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['product']->stock ?>" class="form-control form-control-sm text-center me-2" style="width: 70px;" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="fw-bold text-dark"><?= number_format($item['subtotal'], 0, ',', ' ') ?> FCFA</td>
                                    <td class="text-end">
                                        <a href="<?= BASE_URL ?>/cart/remove/<?= $item['product']->id ?>" class="text-danger" onclick="return confirm('Retirer ce produit du panier ?');"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= BASE_URL ?>/shop" class="btn btn-outline-secondary rounded-pill px-4">Continuer mes achats</a>
                        <!-- Bouton vider le panier (optionnel) -->
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Résumé de la commande</h5>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Sous-total</span>
                                <span class="fw-medium"><?= number_format($data['total'], 0, ',', ' ') ?> FCFA</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Livraison</span>
                                <span class="fw-medium">2 000 FCFA</span> <!-- Frais fixe exemple -->
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-5 text-dark-green"><?= number_format($data['total'] + 2000, 0, ',', ' ') ?> FCFA</span>
                            </div>
                            
                            <a href="<?= BASE_URL ?>/checkout" class="btn btn-dark-green w-100 py-3 fw-bold rounded-pill">
                                Passer la commande
                            </a>
                            
                            <div class="mt-4 d-flex justify-content-center align-items-center gap-2 text-muted small">
                                <i class="fas fa-lock"></i> Paiement sécurisé
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
