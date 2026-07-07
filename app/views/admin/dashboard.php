<?php require_once 'app/views/admin/layouts/header.php'; ?>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
            <div class="d-flex align-items-center">
                <div class="bg-light-green p-3 rounded-4 me-3">
                    <i class="fas fa-shopping-bag text-dark-green fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 small fw-bold">COMMANDES</h6>
                    <h4 class="fw-bold mb-0"><?= $data['stats']['commandes'] ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
            <div class="d-flex align-items-center">
                <div class="bg-light-blue p-3 rounded-4 me-3" style="background-color: #e3f2fd;">
                    <i class="fas fa-money-bill-wave text-primary fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 small fw-bold">CHIFFRE D'AFFAIRES</h6>
                    <h4 class="fw-bold mb-0"><?= number_format($data['stats']['ca'], 0, ',', ' ') ?> <small class="fs-6">F</small></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
            <div class="d-flex align-items-center">
                <div class="bg-light-yellow p-3 rounded-4 me-3">
                    <i class="fas fa-users text-warning fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 small fw-bold">CLIENTS</h6>
                    <h4 class="fw-bold mb-0"><?= $data['stats']['clients'] ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 <?= $data['stats']['low_stock'] > 0 ? 'bg-danger text-white' : 'bg-white' ?>">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-4 me-3 <?= $data['stats']['low_stock'] > 0 ? 'bg-white text-danger' : 'bg-light-red' ?>" style="background-color: <?= $data['stats']['low_stock'] > 0 ? '#fff' : '#ffebee' ?>;">
                    <i class="fas fa-exclamation-triangle fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-1 small fw-bold <?= $data['stats']['low_stock'] > 0 ? 'text-white-50' : 'text-muted' ?>">ALERTE STOCK</h6>
                    <h4 class="fw-bold mb-0"><?= $data['stats']['low_stock'] ?> <small class="fs-6">bas</small></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Graphique Évolution du CA -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 outfit-font"><i class="fas fa-chart-line text-primary me-2"></i>Évolution du Chiffre d'Affaires (6 mois)</h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <!-- Graphique Répartition par Catégorie -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 outfit-font"><i class="fas fa-chart-pie text-success me-2"></i>Ventes par Catégorie</h5>
            </div>
            <div class="card-body d-flex align-items-center">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Top Clients -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 outfit-font"><i class="fas fa-crown text-warning me-2"></i>Le top des clients fidèles</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4">Client</th>
                                <th class="border-0">Commandes</th>
                                <th class="border-0 text-end px-4">Total Dépensé</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['stats']['top_customers'] as $customer): ?>
                                <tr>
                                    <td class="px-4">
                                        <div class="fw-bold"><?= h($customer->nom_client) ?></div>
                                        <small class="text-muted"><?= h($customer->telephone_client) ?></small>
                                    </td>
                                    <td><span class="badge bg-light-green text-dark-green"><?= $customer->nb_commandes ?> achats</span></td>
                                    <td class="text-end fw-bold px-4"><?= number_format($customer->CA, 0, ',', ' ') ?> FCFA</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 outfit-font">Commandes Récentes</h5>
                <a href="<?= BASE_URL ?>/admin/orders" class="btn btn-sm btn-light-green text-dark-green fw-bold">Voir tout</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4">Client</th>
                                <th class="border-0">Date</th>
                                <th class="border-0">Total</th>
                                <th class="border-0">Status</th>
                                <th class="border-0 text-end px-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['recent_orders'] as $order): ?>
                                <tr>
                                    <td class="px-4">
                                        <div class="fw-bold"><?= h($order->nom_client) ?></div>
                                        <small class="text-muted"><?= h($order->telephone_client) ?></small>
                                    </td>
                                    <td><?= date('d/m/y', strtotime($order->created_at)) ?></td>
                                    <td class="fw-bold"><?= number_format($order->total, 0, ',', ' ') ?> F</td>
                                    <td>
                                        <?php 
                                        $badges = [
                                            'en_attente' => 'bg-warning text-dark',
                                            'payee' => 'bg-info text-white',
                                            'expediee' => 'bg-primary text-white',
                                            'livree' => 'bg-success text-white',
                                            'annulee' => 'bg-danger text-white'
                                        ];
                                        $label = str_replace('_', ' ', ucfirst($order->status));
                                        ?>
                                        <span class="badge rounded-pill <?= $badges[$order->status] ?> px-3"><?= $label ?></span>
                                    </td>
                                    <td class="text-end px-4">
                                        <a href="<?= BASE_URL ?>/admin/orderShow/<?= $order->id ?>" class="btn btn-sm btn-light border">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <!-- Actions Rapides -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 outfit-font">Actions Rapides</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= BASE_URL ?>/admin/productAdd" class="btn btn-outline-dark-green py-3 rounded-3 text-start px-3">
                        <i class="fas fa-plus-circle me-2"></i> Ajouter un produit
                    </a>
                    <a href="<?= BASE_URL ?>/admin/categoryAdd" class="btn btn-outline-dark-green py-3 rounded-3 text-start px-3">
                        <i class="fas fa-folder-plus me-2"></i> Nouvelle catégorie
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistiques de Vente -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 outfit-font"><i class="fas fa-trophy text-warning me-2"></i>Top 5 des Ventes</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php if(!empty($data['stats']['best_sellers'])): ?>
                        <?php foreach($data['stats']['best_sellers'] as $index => $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-4 py-3 <?= $index % 2 == 0 ? 'bg-light' : '' ?>">
                                <div>
                                    <span class="badge bg-dark-green rounded-circle me-2" style="width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"><?= $index + 1 ?></span>
                                    <span class="fw-medium"><?= h($item->nom) ?></span>
                                </div>
                                <span class="badge bg-light-green text-dark-green rounded-pill"><?= $item->total_vendu ?> vendus</span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-center py-4 text-muted small">Aucune donnée de vente pour le moment.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <?php if($data['stats']['top_year']): ?>
        <div class="card border-0 shadow-sm rounded-4 bg-dark-green text-white mb-4 overflow-hidden">
            <div class="card-body p-4 position-relative">
                <i class="fas fa-crown position-absolute" style="top: -10px; right: -10px; font-size: 5rem; opacity: 0.1; transform: rotate(15deg);"></i>
                <h6 class="text-white-50 small fw-bold mb-2">PRODUIT DE L'ANNÉE <?= date('Y') ?></h6>
                <h4 class="fw-bold mb-1"><?= h($data['stats']['top_year']->nom) ?></h4>
                <p class="mb-0 small opacity-75"><?= $data['stats']['top_year']->total_vendu ?> unités vendues cette année</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique Évolution du CA
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: [<?php foreach($data['stats']['monthly_sales'] as $m) echo '"' . $m->mois . '",'; ?>],
            datasets: [{
                label: 'Chiffre d\'Affaires (FCFA)',
                data: [<?php foreach($data['stats']['monthly_sales'] as $m) echo $m->CA . ','; ?>],
                borderColor: '#0B5D3B',
                backgroundColor: 'rgba(11, 93, 59, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });

    // Graphique Répartition Catégorie
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: [<?php foreach($data['stats']['category_sales'] as $c) echo '"' . $c->nom . '",'; ?>],
            datasets: [{
                data: [<?php foreach($data['stats']['category_sales'] as $c) echo $c->CA . ','; ?>],
                backgroundColor: ['#0B5D3B', '#FFC107', '#2196F3', '#E91E63', '#9C27B0'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            },
            cutout: '70%'
        }
    });
});
</script>

<?php require_once 'app/views/admin/layouts/footer.php'; ?>
