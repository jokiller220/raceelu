<?php require_once 'app/views/admin/layouts/header.php'; ?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3 d-flex justify-content-between align-items-center">
        <span>Gérez votre catalogue de produits.</span>
        <a href="<?= BASE_URL ?>/admin/productAdd" class="btn btn-dark-green fw-medium"><i class="fas fa-plus me-2"></i>Nouveau produit</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle datatable w-100">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Nom du produit</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['products'] as $product): ?>
                    <tr>
                        <td>
                            <img src="<?= BASE_URL ?>/public/assets/images/<?= $product->image ?>" alt="<?= htmlspecialchars($product->nom) ?>" class="rounded bg-light" style="width: 50px; height: 50px; object-fit: contain;" onerror="this.onerror=null; this.src='https://via.placeholder.com/50';">
                        </td>
                        <td class="fw-bold"><?= htmlspecialchars($product->nom) ?></td>
                        <td><?= htmlspecialchars($product->categorie_nom ?? 'Non classé') ?></td>
                        <td>
                            <?php if(!empty($product->prix_promo)): ?>
                                <div class="text-danger fw-bold"><?= number_format($product->prix_promo, 0, ',', ' ') ?> FCFA</div>
                                <div class="text-muted small text-decoration-line-through"><?= number_format($product->prix, 0, ',', ' ') ?> FCFA</div>
                            <?php else: ?>
                                <div class="fw-medium text-dark-green"><?= number_format($product->prix, 0, ',', ' ') ?> FCFA</div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($product->stock > 10): ?>
                                <span class="badge bg-success"><?= $product->stock ?> en stock</span>
                            <?php elseif($product->stock > 0): ?>
                                <span class="badge bg-warning text-dark">Faible : <?= $product->stock ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger">Rupture</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?= $product->status == 'actif' ? 'bg-success' : 'bg-secondary' ?>"><?= ucfirst($product->status) ?></span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/productEdit/<?= $product->id ?>" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
                            <a href="<?= BASE_URL ?>/admin/productDelete/<?= $product->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'app/views/admin/layouts/footer.php'; ?>
