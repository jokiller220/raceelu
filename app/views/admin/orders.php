<?php require_once 'app/views/admin/layouts/header.php'; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle datatable w-100">
                <thead class="table-light">
                    <tr>
                        <th>N° Commande</th>
                        <th>Client</th>
                        <th>Téléphone</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['orders'] as $order): ?>
                    <tr>
                        <td class="fw-bold">#<?= str_pad($order->id, 4, '0', STR_PAD_LEFT) ?></td>
                        <td><?= htmlspecialchars($order->nom_client) ?></td>
                        <td><?= htmlspecialchars($order->telephone_client) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($order->created_at)) ?></td>
                        <td class="fw-bold"><?= number_format($order->total, 0, ',', ' ') ?> FCFA</td>
                        <td>
                            <?php 
                                $badgeClass = 'bg-secondary';
                                if($order->status == 'en_attente') $badgeClass = 'bg-warning text-dark';
                                if($order->status == 'payee') $badgeClass = 'bg-info text-dark';
                                if($order->status == 'expediee') $badgeClass = 'bg-primary';
                                if($order->status == 'livree') $badgeClass = 'bg-success';
                                if($order->status == 'annulee') $badgeClass = 'bg-danger';
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= ucfirst(str_replace('_', ' ', $order->status)) ?></span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/orderShow/<?= $order->id ?>" class="btn btn-sm btn-outline-dark me-1"><i class="fas fa-eye"></i> Consulter</a>
                            <a href="<?= BASE_URL ?>/admin/orderDelete/<?= $order->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette commande ?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'app/views/admin/layouts/footer.php'; ?>
