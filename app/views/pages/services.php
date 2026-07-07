<?php require_once 'app/views/layouts/header.php'; ?>

<section class="py-5 bg-light">
    <div class="container text-center">
        <h1 class="fw-bold mb-4">Nos Services</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">Nous ne nous contentons pas de vendre des produits, nous accompagnons nos clients avec des services premium.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm p-5">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <i class="fas fa-handshake text-dark-green" style="font-size: 8rem;"></i>
                        </div>
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-3">Ce que nous faisons pour vous</h2>
                            <div class="fs-5 text-muted">
                                <?= nl2br(h($data['content'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
