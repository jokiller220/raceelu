<?php require_once 'app/views/admin/layouts/header.php'; ?>

<?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> Les paramètres ont été mis à jour avec succès.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?= BASE_URL ?>/admin/updateSettings" method="POST">
            <?= csrf_field() ?>
            
            <?php 
            $categories = [];
            foreach($data['settings'] as $s) {
                $categories[$s->category][] = $s;
            }
            ?>

            <?php foreach($categories as $catName => $settings): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="fw-bold mb-0 text-uppercase text-muted" style="font-size: 0.8rem; letter-spacing: 1px;">
                            <?php 
                            switch($catName) {
                                case 'pages': echo 'Contenu des pages'; break;
                                case 'contact': echo 'Coordonnées de contact'; break;
                                default: echo ucfirst($catName);
                            }
                            ?>
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <?php foreach($settings as $s): ?>
                                <div class="col-md-12">
                                    <label class="form-label fw-medium"><?= htmlspecialchars($s->setting_label) ?></label>
                                    <?php if(strpos($s->setting_key, 'about') !== false || strpos($s->setting_key, 'services') !== false): ?>
                                        <textarea name="settings[<?= $s->setting_key ?>]" class="form-control" rows="5"><?= htmlspecialchars($s->setting_value) ?></textarea>
                                    <?php else: ?>
                                        <input type="text" name="settings[<?= $s->setting_key ?>]" class="form-control" value="<?= htmlspecialchars($s->setting_value) ?>">
                                    <?php endif; ?>
                                    <small class="text-muted">Clé technique : <?= $s->setting_key ?></small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="card border-0 shadow-sm sticky-bottom mt-4">
                <div class="card-body p-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-dark-green px-5 fw-bold py-2">
                        <i class="fas fa-save me-2"></i> Enregistrer tous les changements
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once 'app/views/admin/layouts/footer.php'; ?>
