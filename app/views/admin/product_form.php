<?php require_once 'app/views/admin/layouts/header.php'; ?>
<?php $isEdit = isset($data['product']) && $data['product'] !== null; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="<?= BASE_URL ?>/admin/<?= $isEdit ? 'productEdit/'.$data['product']->id : 'productAdd' ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row g-4 mb-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nom du produit <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control" required value="<?= $isEdit ? htmlspecialchars($data['product']->nom) : '' ?>">
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Prix (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" name="prix" class="form-control" required value="<?= $isEdit ? $data['product']->prix : '' ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Prix Promo (FCFA)</label>
                            <input type="number" name="prix_promo" class="form-control" value="<?= $isEdit ? $data['product']->prix_promo : '' ?>" placeholder="Optionnel">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Stock <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" required value="<?= $isEdit ? $data['product']->stock : '100' ?>">
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Catégorie</label>
                            <select name="category_id" class="form-select">
                                <option value="">-- Sélectionner --</option>
                                <?php foreach($data['categories'] as $cat): ?>
                                    <option value="<?= $cat->id ?>" <?= ($isEdit && $data['product']->category_id == $cat->id) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat->nom) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Unité (ex: 25kg, 20L) <span class="text-danger">*</span></label>
                            <input type="text" name="unite" class="form-control" required value="<?= $isEdit ? htmlspecialchars($data['product']->unite) : '' ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" class="form-control" rows="4"><?= $isEdit ? htmlspecialchars($data['product']->description) : '' ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Statut</label>
                        <select name="status" class="form-select">
                            <option value="actif" <?= ($isEdit && $data['product']->status == 'actif') ? 'selected' : '' ?>>Actif</option>
                            <option value="inactif" <?= ($isEdit && $data['product']->status == 'inactif') ? 'selected' : '' ?>>Inactif</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Image du produit</label>
                        <?php if($isEdit && $data['product']->image): ?>
                            <div class="mb-2">
                                <img src="<?= BASE_URL ?>/public/assets/images/<?= $data['product']->image ?>" class="img-thumbnail" width="150" alt="Image actuelle" onerror="this.onerror=null; this.src='https://via.placeholder.com/150';">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted d-block mt-1">Format recommandé : Carré (ex: 600x600px). L'image sera sauvegardée dans le dossier /public/assets/images/.</small>
                    </div>
                </div>
            </div>
            
            <hr>
            <div class="d-flex justify-content-end gap-2">
                <a href="<?= BASE_URL ?>/admin/products" class="btn btn-light border">Annuler</a>
                <button type="submit" class="btn btn-dark-green fw-medium px-4">
                    <i class="fas fa-save me-2"></i> <?= $isEdit ? 'Enregistrer les modifications' : 'Ajouter le produit' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'app/views/admin/layouts/footer.php'; ?>
