<?php require_once 'app/views/layouts/header.php'; ?>

<div class="bg-light py-3 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none text-muted">Accueil</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/cart" class="text-decoration-none text-muted">Mon panier</a></li>
                <li class="breadcrumb-item active" aria-current="page">Commander</li>
            </ol>
        </nav>
    </div>
</div>

<section class="checkout-section py-5 bg-white">
    <div class="container">
        <h2 class="fw-bold mb-4">Commander</h2>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger">Veuillez remplir tous les champs obligatoires.</div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/checkout/process" method="POST">
            <?= csrf_field() ?>
            <div class="row gx-5">
                <!-- Informations de livraison -->
                <div class="col-lg-7 mb-5 mb-lg-0">
                    <h5 class="fw-bold mb-4">Informations de livraison</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Nom complet *</label>
                        <input type="text" name="nom" class="form-control" required placeholder="Entrez votre nom">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Téléphone *</label>
                        <input type="tel" name="telephone" class="form-control" required placeholder="Entrez votre téléphone">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Adresse de livraison *</label>
                        <input type="text" name="adresse" class="form-control" required placeholder="Entrez votre adresse">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Ville *</label>
                        <select name="ville" class="form-select" required>
                            <option value="">Sélectionnez votre ville</option>
                            <option value="Lomé (Assiganmé)">Lomé (Assiganmé)</option>
                            <option value="Lomé (Autres)">Lomé (Autres quartiers)</option>
                            <option value="Dakar">Dakar</option>
                            <option value="Thiès">Thiès</option>
                            <option value="Saint-Louis">Saint-Louis</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>

                <!-- Résumé et Paiement -->
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 bg-light mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Résumé de la commande</h5>
                            
                            <?php foreach($data['cart_items'] as $item): ?>
                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-muted"><?= htmlspecialchars($item['product']->nom) ?> (x<?= $item['quantity'] ?>)</span>
                                    <span class="fw-medium"><?= number_format($item['subtotal'], 0, ',', ' ') ?> FCFA</span>
                                </div>
                            <?php endforeach; ?>
                            
                            <hr class="my-3">
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Sous-total</span>
                                <span class="fw-medium"><?= number_format($data['total'], 0, ',', ' ') ?> FCFA</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Livraison</span>
                                <span class="fw-medium"><?= number_format($data['frais_livraison'], 0, ',', ' ') ?> FCFA</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-0 border-top pt-3">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-5 text-dark-green"><?= number_format($data['total'] + $data['frais_livraison'], 0, ',', ' ') ?> FCFA</span>
                            </div>
                        </div>
                    </div>
                    
                    <?php if(isset($_SESSION['user_id'])): 
                        $userPoints = get_user_points($_SESSION['user_id']);
                        if($userPoints > 0):
                    ?>
                        <div class="card shadow-sm border-0 bg-light-yellow mb-4 rounded-4 overflow-hidden">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3 outfit-font text-dark"><i class="fas fa-coins me-2 text-warning"></i> Vos points de fidélité</h6>
                                <p class="small text-muted mb-3">Vous avez <strong><?= $userPoints ?> points</strong> disponibles (valeur: <?= number_format($userPoints * POINT_VALUE, 0, ',', ' ') ?> FCFA).</p>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="use_points" id="usePointsCheck" value="1">
                                    <label class="form-check-label fw-bold" for="usePointsCheck">Utiliser mes points pour cette commande</label>
                                </div>
                            </div>
                        </div>
                    <?php endif; endif; ?>
                    
                    <div class="card shadow-sm border-0 bg-light mb-4 rounded-4 overflow-hidden">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3 outfit-font text-dark"><i class="fas fa-ticket-alt me-2 text-dark-green"></i> Code Promo</h6>
                            <div class="input-group">
                                <input type="text" name="coupon_code" id="couponCode" class="form-control" placeholder="Entrez votre code">
                                <button type="button" class="btn btn-outline-dark-green fw-bold" onclick="applyCoupon()">Appliquer</button>
                            </div>
                            <div id="couponMessage" class="small mt-2"></div>
                        </div>
                    </div>
                    
                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Mode de paiement</h5>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="mode_paiement" id="paiement1" value="livraison" checked>
                                <label class="form-check-label fw-medium" for="paiement1">
                                    Paiement à la livraison
                                </label>
                            </div>
                            
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="mode_paiement" id="paiement2" value="mobile">
                                <label class="form-check-label fw-medium" for="paiement2">
                                    Paiement en ligne (Mobile Money, Carte, etc.)
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-dark-green w-100 py-3 fw-bold rounded-pill">
                                Confirmer la commande
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
