<?php require_once 'app/views/admin/layouts/header.php'; ?>
<?php $isEdit = isset($data['category']) && $data['category'] !== null; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="<?= BASE_URL ?>/admin/<?= $isEdit ? 'categoryEdit/'.$data['category']->id : 'categoryAdd' ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row g-4 mb-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nom de la catégorie <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control" required value="<?= $isEdit ? htmlspecialchars($data['category']->nom) : '' ?>">
                        <small class="text-muted">Le lien (slug) sera généré automatiquement à partir de ce nom.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" class="form-control" rows="4"><?= $isEdit ? htmlspecialchars($data['category']->description) : '' ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Statut</label>
                        <select name="status" class="form-select">
                            <option value="actif" <?= ($isEdit && $data['category']->status == 'actif') ? 'selected' : '' ?>>Actif</option>
                            <option value="inactif" <?= ($isEdit && $data['category']->status == 'inactif') ? 'selected' : '' ?>>Inactif</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <hr>
            <div class="d-flex justify-content-end gap-2">
                <a href="<?= BASE_URL ?>/admin/categories" class="btn btn-light border">Annuler</a>
                <button type="submit" class="btn btn-dark-green fw-medium px-4">
                    <i class="fas fa-save me-2"></i> <?= $isEdit ? 'Enregistrer les modifications' : 'Ajouter la catégorie' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'app/views/admin/layouts/footer.php'; ?>
