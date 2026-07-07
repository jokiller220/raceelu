<!-- Sidebar -->
<div class="admin-sidebar text-white" style="width: 250px;">
    <div class="p-4 d-flex align-items-center">
        <img src="<?= BASE_URL ?>/public/assets/images/logo.png" alt="Logo" height="40" class="me-2 rounded bg-white p-1">
        <div class="logo-text-group">
            <div class="brand-main" style="gap: 4px;">
                <span class="brand-race text-white" style="font-size: 1.4rem;">Race</span>
                <span class="brand-elu" style="font-size: 1.4rem;">Élu</span>
            </div>
            <span class="brand-tagline text-white-50" style="font-size: 0.55rem; letter-spacing: 1px;">PANNEAU ADMIN</span>
        </div>
    </div>
    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a class="nav-link <?= ($data['active_menu'] ?? '') == 'dashboard' ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin"><i class="fas fa-tachometer-alt me-3 w-20px"></i> Tableau de bord</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['active_menu'] ?? '') == 'orders' ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/orders"><i class="fas fa-shopping-bag me-3 w-20px"></i> Commandes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['active_menu'] ?? '') == 'products' ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/products"><i class="fas fa-box me-3 w-20px"></i> Produits</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['active_menu'] ?? '') == 'categories' ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/categories"><i class="fas fa-tags me-3 w-20px"></i> Catégories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['active_menu'] ?? '') == 'clients' ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/clients"><i class="fas fa-users me-3 w-20px"></i> Clients</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($data['active_menu'] ?? '') == 'settings' ? 'active' : '' ?>" href="<?= BASE_URL ?>/admin/settings"><i class="fas fa-cog me-3 w-20px"></i> Paramètres</a>
        </li>
        <li class="nav-item mt-4 border-top border-secondary pt-3">
            <small class="text-muted px-4 text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Outils externes</small>
        </li>
        <li class="nav-item">
            <?php
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
                $appCommercialeUrl = $protocol . '://' . $host . '/projet_Orizon/applycommerciale/';
            ?>
            <a class="nav-link" href="<?= $appCommercialeUrl ?>" target="_blank"><i class="fas fa-cash-register me-3 w-20px"></i> Gestion Commerciale <i class="fas fa-external-link-alt ms-1 small"></i></a>
        </li>
        <li class="nav-item mt-3 border-top border-secondary">
            <a class="nav-link" href="<?= BASE_URL ?>"><i class="fas fa-sign-out-alt me-3 w-20px"></i> Quitter</a>
        </li>
    </ul>
</div>
