<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($data['title'] ?? SITE_NAME) ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
        const CSRF_TOKEN = '<?= csrf_token() ?>';
    </script>
</head>
<body>

    <!-- Header (Navigation) -->
    <header class="race-header">
        <div class="top-bar py-1 bg-dark-green text-white">
            <div class="container d-flex justify-content-between align-items-center">
                <small>Bienvenue chez Race Élu, votre partenaire en alimentation générale en gros !</small>
                <small><a href="<?= BASE_URL ?>/order/track" class="text-white text-decoration-none"><i class="fas fa-truck text-yellow me-1"></i> Suivre ma commande</a></small>
            </div>
        </div>
        
        <div class="main-header py-3 bg-white border-bottom">
            <div class="container d-flex justify-content-between align-items-center flex-wrap">
                <!-- Logo -->
                <a href="<?= BASE_URL ?>" class="logo text-decoration-none d-flex align-items-center">
                    <img src="<?= BASE_URL ?>/public/assets/images/logo.png" alt="Race Élu Logo" height="55" class="me-2" onerror="this.onerror=null; this.src='https://via.placeholder.com/50x50.png?text=RE';">
                    <div class="logo-text-group">
                        <div class="brand-main">
                            <span class="brand-race">Race</span> <span class="brand-elu">Élu</span>
                        </div>
                        <span class="brand-tagline">GROSSISTE ALIMENTAIRE</span>
                    </div>
                </a>

                <!-- Search -->
                <div class="search-bar flex-grow-1 mx-4 d-none d-md-block" style="max-width: 500px;">
                    <form action="<?= BASE_URL ?>/shop" method="GET" class="input-group">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Toutes les catégories</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/shop">Toutes</a></li>
                        </ul>
                        <input type="text" name="search" class="form-control" placeholder="Rechercher un produit..." value="<?= isset($_GET['search']) ? h($_GET['search']) : '' ?>">
                        <button class="btn btn-primary bg-dark-green border-0" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <!-- Icons (Account / Cart) -->
                <div class="header-icons d-flex align-items-center gap-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <a href="#" class="text-decoration-none text-dark d-flex align-items-center dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="far fa-user fs-4 me-2 text-dark-green"></i>
                                <div class="d-none d-lg-block">
                                    <span class="d-block small text-muted">Bonjour,</span>
                                    <span class="d-block fw-semibold text-dark-green"><?= h($_SESSION['user_nom']) ?></span>
                                    <span class="badge bg-yellow text-dark rounded-pill" style="font-size: 0.65rem;">
                                        <i class="fas fa-coins me-1"></i> <?= get_user_points($_SESSION['user_id']) ?> pts
                                    </span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2">
                                <?php if($_SESSION['role'] === 'admin'): ?>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin"><i class="fas fa-cog me-2"></i> Administration</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/auth/logout"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/auth/login" class="text-decoration-none text-dark d-flex align-items-center">
                            <i class="far fa-user fs-4 me-2"></i>
                            <div class="d-none d-lg-block">
                                <span class="d-block small text-muted">Mon compte</span>
                                <span class="d-block fw-semibold">Se connecter</span>
                            </div>
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?= BASE_URL ?>/cart" class="text-decoration-none text-dark d-flex align-items-center position-relative">
                        <i class="fas fa-shopping-cart fs-4 me-2"></i>
                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-yellow text-dark">
                            <?php 
                                $cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
                                echo $cartCount;
                            ?>
                        </span>
                        <div class="d-none d-lg-block">
                            <span class="d-block small text-muted">Mon panier</span>
                            <span class="d-block fw-semibold">
                                <?php
                                    $cartTotal = 0;
                                    if(isset($_SESSION['cart'])) {
                                        // On pourrait instancier le modèle Product ici, mais c'est lourd. 
                                        // Pour simplifier l'affichage du total dans le header, 
                                        // on pourrait stocker le total en session ou juste ne pas l'afficher ici.
                                        // On va juste afficher "Consulter" pour ne pas requêter la BDD à chaque page pour le header.
                                    }
                                ?>
                                Consulter
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="navbar navbar-expand-xl bg-yellow main-nav py-0">
            <div class="container">
                <button class="navbar-toggler my-2 border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mainNavOffcanvas" aria-controls="mainNavOffcanvas">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-start bg-yellow" tabindex="-1" id="mainNavOffcanvas" aria-labelledby="mainNavOffcanvasLabel">
                    <div class="offcanvas-header bg-dark-green text-white">
                        <h5 class="offcanvas-title fw-bold" id="mainNavOffcanvasLabel">Menu Race Élu</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <!-- Liens mobiles essentiels -->
                            <li class="nav-item d-xl-none border-bottom border-dark-green pb-2 mb-2">
                                <a class="nav-link px-3 fw-bold text-dark" href="<?= BASE_URL ?>/cart">
                                    <i class="fas fa-shopping-basket me-2 text-dark-green"></i> Mon Panier
                                </a>
                                <a class="nav-link px-3 fw-bold text-dark" href="<?= isset($_SESSION['user_id']) ? BASE_URL . '/admin' : BASE_URL . '/auth/login' ?>">
                                    <i class="far fa-user me-2 text-dark-green"></i> <?= isset($_SESSION['user_id']) ? 'Mon Compte' : 'Se connecter' ?>
                                </a>
                            </li>
                            <li class="nav-item dropdown bg-dark-green">
                                <a class="nav-link dropdown-toggle text-white px-4 py-3" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-bars me-2"></i> Toutes les catégories
                                </a>
                                <ul class="dropdown-menu rounded-0 shadow border-0 mt-0">
                                    <?php
                                        $headerDb = new Database();
                                        $headerDb->query('SELECT * FROM categories ORDER BY nom ASC LIMIT 8');
                                        $headerCategories = $headerDb->resultSet();
                                        foreach($headerCategories as $hcat):
                                    ?>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/shop/category/<?= $hcat->slug ?>"><?= h($hcat->nom) ?></a></li>
                                    <?php endforeach; ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item fw-bold text-dark-green" href="<?= BASE_URL ?>/shop">Toutes les catégories</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link px-3 py-3 fw-medium text-dark active" href="<?= BASE_URL ?>">Accueil</a></li>
                            <li class="nav-item"><a class="nav-link px-3 py-3 fw-medium text-dark" href="<?= BASE_URL ?>/shop">Boutique</a></li>
                            <li class="nav-item"><a class="nav-link px-3 py-3 fw-medium text-dark" href="<?= BASE_URL ?>/page/about">À propos</a></li>
                            <li class="nav-item"><a class="nav-link px-3 py-3 fw-medium text-dark" href="<?= BASE_URL ?>/page/services">Services</a></li>
                            <li class="nav-item"><a class="nav-link px-3 py-3 fw-medium text-dark" href="<?= BASE_URL ?>/page/promotions">Promotions</a></li>
                            <li class="nav-item"><a class="nav-link px-3 py-3 fw-medium text-dark" href="<?= BASE_URL ?>/page/contact">Contact</a></li>
                            <li class="nav-item ms-lg-2"><a class="btn btn-dark-green rounded-pill px-4 py-2 mt-2 mt-lg-1 fw-bold shadow-sm" href="<?= BASE_URL ?>/order/track"><i class="fas fa-truck me-2 text-yellow"></i> Suivre mon colis</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <?php if(isset($_SESSION['flash_success'])): ?>
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?= h($_SESSION['flash_success']) ?>
                    <button type="button" class="btn-close" data-bs-alert="alert" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>
