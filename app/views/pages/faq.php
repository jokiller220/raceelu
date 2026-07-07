<?php require_once 'app/views/layouts/header.php'; ?>

<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-4 text-center">Foire Aux Questions (FAQ)</h2>
                        
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item border-0 border-bottom mb-3">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Comment puis-je passer une commande ?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        Pour passer commande, naviguez dans notre boutique, ajoutez les produits de votre choix au panier, puis validez votre panier. Vous devrez vous créer un compte pour finaliser la commande afin que nous puissions organiser la livraison.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 border-bottom mb-3">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Quels sont les modes de paiement acceptés ?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        Nous acceptons actuellement le paiement à la livraison (en espèces) ainsi que les transferts par Mobile Money.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 border-bottom mb-3">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Combien de temps faut-il pour être livré ?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        Les livraisons dans la zone principale s'effectuent généralement dans un délai de 24 à 48 heures ouvrées après validation de la commande.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border-0 border-bottom">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed fw-bold bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Vendez-vous au détail ou uniquement en gros ?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        Race Élu est spécialisé dans la vente en gros de produits alimentaires. Les unités de vente (cartons, sacs de 25kg, 50kg) sont spécifiées pour chaque produit.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/layouts/footer.php'; ?>
