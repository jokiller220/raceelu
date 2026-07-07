<?php require_once 'app/views/admin/layouts/header.php'; ?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3 d-flex justify-content-between align-items-center">
        <span>Gérez les catégories de votre boutique.</span>
        <a href="<?= BASE_URL ?>/admin/categoryAdd" class="btn btn-dark-green fw-medium"><i class="fas fa-plus me-2"></i>Nouvelle catégorie</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle datatable w-100">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom de la catégorie</th>
                        <th>Slug</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['categories'] as $cat): ?>
                    <tr>
                        <td><?= $cat->id ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($cat->nom) ?></td>
                        <td class="text-muted"><?= htmlspecialchars($cat->slug) ?></td>
                        <td>
                            <span class="badge <?= (isset($cat->status) && $cat->status == 'actif') ? 'bg-success' : 'bg-secondary' ?>"><?= isset($cat->status) ? ucfirst($cat->status) : 'Actif' ?></span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/categoryEdit/<?= $cat->id ?>" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
                            <a href="<?= BASE_URL ?>/admin/categoryDelete/<?= $cat->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Attention ! Supprimer cette catégorie supprimera aussi tous ses produits. Continuer ?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'app/views/admin/layouts/footer.php'; ?>
