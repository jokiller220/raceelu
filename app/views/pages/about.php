<?php require_once 'app/views/layouts/header.php'; ?>

<!-- Hero Section About -->
<section class="py-5 bg-dark-green text-white position-relative overflow-hidden" style="background: linear-gradient(rgba(11, 93, 59, 0.9), rgba(11, 93, 59, 0.9)), url('https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-4 fw-bold mb-3 outfit-font">À propos de Race Élu</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-white-50 text-decoration-none">Accueil</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">À propos</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Our History -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1578916171728-46686eac8d58?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-4 shadow-lg" alt="Notre Histoire">
                    <div class="position-absolute bottom-0 end-0 bg-yellow p-4 rounded-4 shadow m-n3 d-none d-md-block" style="max-width: 200px;">
                        <span class="d-block h2 fw-bold mb-0 text-dark">10+</span>
                        <span class="text-dark-50 small fw-bold">Années d'expérience</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h6 class="text-yellow text-uppercase fw-bold mb-2">Notre Histoire</h6>
                <h2 class="display-6 fw-bold mb-4 text-dark-green outfit-font">Votre Partenaire de Confiance pour l'Alimentation en Gros</h2>
                <div class="content lead text-muted mb-4" style="text-align: justify;">
                    <?= !empty($data['content']) ? nl2br(h($data['content'])) : "Race Élu est votre grossiste alimentaire de confiance, offrant une large gamme de produits de qualité supérieure aux meilleurs prix du marché. Nous nous engageons à fournir les meilleurs services à nos clients depuis plus d'une décennie." ?>
                </div>
                <div class="row g-4 mb-5">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-light-green p-2 rounded-circle me-3">
                                <i class="fas fa-check text-dark-green"></i>
                            </div>
                            <span class="fw-bold text-dark">Qualité Certifiée</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-light-green p-2 rounded-circle me-3">
                                <i class="fas fa-check text-dark-green"></i>
                            </div>
                            <span class="fw-bold text-dark">Prix Grossiste</span>
                        </div>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/shop" class="btn btn-dark-green px-5 py-3 rounded-pill fw-bold shadow-sm transition-hover">
                    <i class="fas fa-shopping-basket me-2"></i> Découvrir nos produits
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-yellow text-uppercase fw-bold mb-2">Pourquoi nous ?</h6>
            <h2 class="display-6 fw-bold text-dark-green outfit-font">Nos Valeurs Fondamentales</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 text-center rounded-4 transition-hover">
                    <div class="bg-light-green mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px;">
                        <i class="fas fa-shield-alt fs-2 text-dark-green"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Fiabilité</h4>
                    <p class="text-muted">Nous respectons nos engagements et nos délais de livraison pour assurer la continuité de votre business.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 text-center rounded-4 transition-hover">
                    <div class="bg-light-green mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px;">
                        <i class="fas fa-hand-holding-heart fs-2 text-dark-green"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Proximité</h4>
                    <p class="text-muted">Un service client à l'écoute et disponible pour répondre à tous vos besoins spécifiques en approvisionnement.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 text-center rounded-4 transition-hover">
                    <div class="bg-light-green mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px;">
                        <i class="fas fa-star fs-2 text-dark-green"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Excellence</h4>
                    <p class="text-muted">Nous sélectionnons rigoureusement chaque produit pour vous garantir le meilleur rapport qualité-prix.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
