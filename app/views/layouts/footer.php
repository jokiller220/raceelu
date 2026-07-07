    </main>

    <!-- Footer -->
    <footer class="bg-dark-green text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3 outfit-font">Race Élu</h5>
                    <p class="text-white-50"><?= h(get_setting('site_footer_desc')) ?></p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="<?= h(get_setting('site_facebook')) ?>" class="text-white fs-5 transition-hover"><i class="fab fa-facebook"></i></a>
                        <a href="<?= h(get_setting('site_instagram')) ?>" class="text-white fs-5 transition-hover"><i class="fab fa-instagram"></i></a>
                        <a href="<?= h(get_setting('site_twitter')) ?>" class="text-white fs-5 transition-hover"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="fw-bold mb-3 outfit-font">Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= BASE_URL ?>" class="text-white-50 text-decoration-none">Accueil</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/shop" class="text-white-50 text-decoration-none">Boutique</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/page/services" class="text-white-50 text-decoration-none">Services</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/page/contact" class="text-white-50 text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-3 outfit-font">Service Client</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= BASE_URL ?>/auth/login" class="text-white-50 text-decoration-none">Mon Compte</a></li>
                        <li class="mb-2"><a href="<?= BASE_URL ?>/order/track" class="text-white-50 text-decoration-none">Suivre ma commande</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Politique de retour</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-3 outfit-font">Contact</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-yellow"></i> <?= h(get_setting('site_contact_address')) ?></li>
                        <li class="mb-2"><i class="fas fa-phone me-2 text-yellow"></i> <?= h(get_setting('site_contact_phone')) ?></li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-yellow"></i> <?= h(get_setting('site_contact_email')) ?></li>
                    </ul>
                </div>
            </div>
            <hr class="border-white-50 mt-4 mb-3">
            <div class="text-center text-white-50 small">
                &copy; <?= date('Y') ?> Race Élu - Tous droits réservés.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= BASE_URL ?>/public/assets/js/main.js"></script>

    <!-- Mobile Bottom Nav -->
    <div class="mobile-bottom-nav d-lg-none">
        <a href="<?= BASE_URL ?>" class="nav-item">
            <i class="fas fa-home"></i>
            Accueil
        </a>
        <a href="<?= BASE_URL ?>/shop" class="nav-item">
            <i class="fas fa-store"></i>
            Boutique
        </a>
        <a href="<?= BASE_URL ?>/cart" class="nav-item position-relative">
            <i class="fas fa-shopping-basket"></i>
            Panier
            <?php if(!empty($_SESSION['cart'])): ?>
                <span class="position-absolute top-0 start-50 translate-middle-x badge rounded-pill bg-danger" style="margin-left: 10px; font-size: 8px;">
                    <?= array_sum($_SESSION['cart']) ?>
                </span>
            <?php endif; ?>
        </a>
        <a href="<?= BASE_URL ?>/order/track" class="nav-item">
            <i class="fas fa-truck"></i>
            Suivi
        </a>
    </div>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', get_setting('site_contact_phone')) ?>" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-badge d-none d-md-block">Besoin d'aide ?</span>
    </a>
</body>
</html>
