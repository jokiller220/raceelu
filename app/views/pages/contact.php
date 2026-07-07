<?php require_once 'app/views/layouts/header.php'; ?>

<section class="py-5 bg-light">
    <div class="container text-center">
        <h1 class="fw-bold mb-4">Contactez-nous</h1>
        <p class="text-muted">Une question ? Un besoin particulier ? Notre équipe est à votre écoute.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100 p-4">
                    <h4 class="fw-bold mb-4 text-dark-green">Nos coordonnées</h4>
                    
                    <div class="d-flex mb-4">
                        <div class="icon-circle bg-light-green text-dark-green me-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-map-marker-alt fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Adresse</h6>
                            <p class="text-muted mb-0"><?= h($data['address']) ?></p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="icon-circle bg-light-green text-dark-green me-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-phone fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Téléphone</h6>
                            <p class="text-muted mb-0"><?= h($data['phone']) ?></p>
                        </div>
                    </div>

                    <div class="d-flex mb-0">
                        <div class="icon-circle bg-light-green text-dark-green me-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-envelope fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Email</h6>
                            <p class="text-muted mb-0"><?= h($data['email']) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4">
                    <h4 class="fw-bold mb-4">Envoyez-nous un message</h4>
                    <form action="#" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Nom complet</label>
                                <input type="text" class="form-control" placeholder="Ex: Jean Dupont" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Email</label>
                                <input type="email" class="form-control" placeholder="Ex: jean@email.com" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium">Sujet</label>
                                <input type="text" class="form-control" placeholder="Comment pouvons-nous vous aider ?" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium">Message</label>
                                <textarea class="form-control" rows="5" placeholder="Votre message ici..." required></textarea>
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-dark-green px-5 py-2 fw-bold">Envoyer le message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
