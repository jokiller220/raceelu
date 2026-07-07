<?php require_once 'app/views/admin/layouts/header.php'; ?>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold border-bottom pb-3 mb-4">Détail des articles commandés</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Produit</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th class="text-end">Sous-total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($data['items'])): ?>
                            <?php foreach($data['items'] as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= BASE_URL ?>/public/assets/images/<?= $item->image ?? 'default.jpg' ?>" alt="<?= htmlspecialchars($item->product_name ?? 'Produit') ?>" style="width: 50px; height: 50px; object-fit: contain;" class="bg-light p-1 rounded me-3" onerror="this.onerror=null; this.src='https://via.placeholder.com/50';">
                                        <span class="fw-medium"><?= htmlspecialchars($item->product_name ?? 'Produit supprimé') ?></span>
                                    </div>
                                </td>
                                <td><?= number_format($item->prix_unitaire, 0, ',', ' ') ?> FCFA</td>
                                <td><?= $item->quantite ?></td>
                                <td class="fw-bold text-end"><?= number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') ?> FCFA</td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr><td colspan="4" class="text-center text-muted">Aucun article trouvé.</td></tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end text-muted">Sous-total :</td>
                                <td class="text-end fw-medium"><?= number_format($data['order']->total - 2000, 0, ',', ' ') ?> FCFA</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-muted">Livraison :</td>
                                <td class="text-end fw-medium">2 000 FCFA</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-bold fs-5">TOTAL :</td>
                                <td class="text-end fw-bold text-dark-green fs-5"><?= number_format($data['order']->total, 0, ',', ' ') ?> FCFA</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Statut de la commande -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Statut de la commande</h6>
                <form action="<?= BASE_URL ?>/admin/updateOrderStatus/<?= $data['order']->id ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="input-group">
                        <select name="status" class="form-select fw-medium">
                            <option value="en_attente" <?= $data['order']->status == 'en_attente' ? 'selected' : '' ?>>En attente</option>
                            <option value="payee" <?= $data['order']->status == 'payee' ? 'selected' : '' ?>>Payée</option>
                            <option value="expediee" <?= $data['order']->status == 'expediee' ? 'selected' : '' ?>>Expédiée</option>
                            <option value="livree" <?= $data['order']->status == 'livree' ? 'selected' : '' ?>>Livrée</option>
                            <option value="annulee" <?= $data['order']->status == 'annulee' ? 'selected' : '' ?>>Annulée</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
                <hr>
                <a href="<?= BASE_URL ?>/admin/orderInvoice/<?= $data['order']->id ?>" target="_blank" class="btn btn-outline-dark-green w-100 fw-bold">
                    <i class="fas fa-print me-2"></i> Imprimer la facture
                </a>
            </div>
        </div>

        <!-- Informations Client -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="fas fa-user me-2 text-dark-green"></i>Informations du client</h6>
                <div class="mb-2"><span class="text-muted small d-block">Nom complet</span> <span class="fw-medium"><?= htmlspecialchars($data['order']->nom_client) ?></span></div>
                <div class="mb-2"><span class="text-muted small d-block">Téléphone</span> <span class="fw-medium"><?= htmlspecialchars($data['order']->telephone_client) ?></span></div>
                <div class="mb-2"><span class="text-muted small d-block">Adresse de livraison</span> <span class="fw-medium"><?= nl2br(htmlspecialchars($data['order']->adresse_livraison)) ?></span></div>
                <div class="mb-0"><span class="text-muted small d-block">Ville</span> <span class="fw-medium"><?= htmlspecialchars($data['order']->ville_livraison) ?></span></div>
            </div>
        </div>

        <!-- Informations de paiement -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="fas fa-wallet me-2 text-warning"></i>Paiement</h6>
                <div class="mb-2"><span class="text-muted small d-block">Méthode</span> <span class="fw-medium"><i class="fas fa-money-bill-wave me-1 text-success"></i> <?= htmlspecialchars($data['order']->mode_paiement) ?></span></div>
                <div class="mb-0"><span class="text-muted small d-block">Date de commande</span> <span class="fw-medium"><?= date('d/m/Y à H:i', strtotime($data['order']->created_at)) ?></span></div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= BASE_URL ?>/admin/orders" class="btn btn-light border"><i class="fas fa-arrow-left me-2"></i>Retour aux commandes</a>
</div>

<?php require_once 'app/views/admin/layouts/footer.php'; ?>
