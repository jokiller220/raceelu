<?php require_once 'app/views/admin/layouts/header.php'; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle datatable w-100">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom Complet</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['clients'] as $client): ?>
                    <tr>
                        <td><?= $client->id ?></td>
                        <td class="fw-bold">
                            <div class="d-flex align-items-center">
                                <div class="bg-light text-dark-green fw-bold rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                    <?= strtoupper(substr($client->nom, 0, 1)) ?>
                                </div>
                                <?= htmlspecialchars($client->nom) ?>
                            </div>
                        </td>
                        <td><a href="mailto:<?= htmlspecialchars($client->email) ?>" class="text-decoration-none"><?= htmlspecialchars($client->email) ?></a></td>
                        <td><?= htmlspecialchars($client->telephone ?? 'Non renseigné') ?></td>
                        <td><?= date('d/m/Y', strtotime($client->created_at)) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/clientDelete/<?= $client->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce client ?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'app/views/admin/layouts/footer.php'; ?>
