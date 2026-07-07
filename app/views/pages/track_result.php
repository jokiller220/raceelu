<?php require_once 'app/views/layouts/header.php'; ?>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h2 class="fw-bold outfit-font mb-1">Commande #<?= $data['order']->id ?></h2>
                        <p class="text-muted mb-0">Passée le <?= date('d/m/Y à H:i', strtotime($data['order']->created_at)) ?></p>
                    </div>
                    <a href="<?= BASE_URL ?>/order/track" class="btn btn-outline-secondary btn-sm border-0"><i class="fas fa-arrow-left me-2"></i> Nouvelle recherche</a>
                </div>

                <!-- Stepper Status -->
                <div class="card border-0 shadow-sm mb-4 rounded-4 p-4 p-md-5">
                    <div class="status-stepper d-flex justify-content-between position-relative">
                        <?php 
                        $status = $data['order']->status;
                        $steps = [
                            'en_attente' => ['label' => 'Reçue', 'icon' => 'fa-file-invoice'],
                            'payee' => ['label' => 'Confirmée', 'icon' => 'fa-check-circle'],
                            'expediee' => ['label' => 'En cours', 'icon' => 'fa-truck'],
                            'livree' => ['label' => 'Livrée', 'icon' => 'fa-home']
                        ];
                        
                        $reached = true;
                        foreach($steps as $key => $step):
                        ?>
                            <div class="step text-center <?= $reached ? 'active' : '' ?>" style="flex: 1; z-index: 1;">
                                <div class="step-icon mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background-color: <?= $reached ? 'var(--color-dark-green)' : '#e9ecef' ?>; color: <?= $reached ? 'white' : '#adb5bd' ?>;">
                                    <i class="fas <?= $step['icon'] ?>"></i>
                                </div>
                                <span class="small fw-bold <?= $reached ? 'text-dark' : 'text-muted' ?>"><?= $step['label'] ?></span>
                            </div>
                        <?php 
                        if($key === $status) $reached = false;
                        endforeach; 
                        ?>
                        <!-- Line behind -->
                        <div class="position-absolute top-25 start-0 w-100 translate-middle-y" style="height: 2px; background-color: #e9ecef; z-index: 0; top: 25px;"></div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Details -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-white py-3">
                                <h5 class="fw-bold mb-0">Détails des articles</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table mb-0 align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Produit</th>
                                            <th class="text-center">Quantité</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($data['items'] as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= BASE_URL ?>/public/assets/images/<?= $item->produit_image ?>" width="40" height="40" class="rounded me-2 shadow-sm" style="object-fit: cover;">
                                                        <span class="fw-medium small"><?= h($item->produit_nom) ?></span>
                                                    </div>
                                                </td>
                                                <td class="text-center">x<?= $item->quantite ?></td>
                                                <td class="text-end fw-bold"><?= number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') ?> FCFA</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="bg-light fw-bold">
                                        <tr>
                                            <td colspan="2" class="text-end">Total de la commande</td>
                                            <td class="text-end text-dark-green"><?= number_format($data['order']->total, 0, ',', ' ') ?> FCFA</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Client Info -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm rounded-4 p-4">
                            <h5 class="fw-bold mb-4">Informations de livraison</h5>
                            <div class="mb-3 d-flex">
                                <i class="fas fa-user text-muted me-3 mt-1"></i>
                                <div>
                                    <p class="small text-muted mb-0">Client</p>
                                    <p class="fw-bold mb-0"><?= h($data['order']->nom_client) ?></p>
                                </div>
                            </div>
                            <div class="mb-3 d-flex">
                                <i class="fas fa-phone text-muted me-3 mt-1"></i>
                                <div>
                                    <p class="small text-muted mb-0">Téléphone</p>
                                    <p class="fw-bold mb-0"><?= h($data['order']->telephone_client) ?></p>
                                </div>
                            </div>
                            <div class="mb-0 d-flex">
                                <i class="fas fa-map-marker-alt text-muted me-3 mt-1"></i>
                                <div>
                                    <p class="small text-muted mb-0">Adresse</p>
                                    <p class="fw-bold mb-0"><?= h($data['order']->adresse_livraison) ?>, <?= h($data['order']->ville_livraison) ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-yellow mt-4 border-0 rounded-4">
                            <div class="d-flex">
                                <i class="fas fa-info-circle fs-4 me-3"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Besoin d'aide ?</h6>
                                    <p class="small mb-0">Contactez notre support au <strong><?= h(get_setting('site_contact_phone')) ?></strong> pour toute question sur votre livraison.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
