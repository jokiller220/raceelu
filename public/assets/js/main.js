// public/assets/js/main.js

document.addEventListener('DOMContentLoaded', function() {
    
    // Fonctionnalité d'ajout au panier
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-id');
            // Récupérer la quantité s'il y a un input (page produit), sinon 1
            let quantity = 1;
            const qtyInput = document.querySelector('input[name="quantity"]');
            if (qtyInput && this.closest('#add-to-cart-form')) {
                quantity = qtyInput.value;
            }
            
            addToCart(productId, quantity);
        });
    });
});

function addToCart(productId, quantity = 1) {
    // Appel AJAX vers CartController/add
    fetch(`${BASE_URL}/cart/add`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `product_id=${productId}&quantity=${quantity}&csrf_token=${CSRF_TOKEN}`
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            // Mettre à jour le badge du panier
            updateCartBadge(data.cartCount, data.cartTotal);
            // Afficher une notification
            showNotification('Produit ajouté au panier avec succès !', 'success');
        } else {
            showNotification(data.message || 'Erreur lors de l\'ajout', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Erreur de connexion', 'danger');
    });
}

function updateCartBadge(count, total) {
    const badge = document.querySelector('.badge.bg-yellow');
    if(badge) {
        badge.textContent = count;
    }
    const totalSpan = document.querySelector('a[href*="/cart"] .fw-semibold');
    if(totalSpan && total !== undefined) {
        totalSpan.textContent = `(${new Intl.NumberFormat('fr-FR').format(total)} FCFA)`;
    }
}

function showNotification(message, type = 'success') {
    // Créer un élément toast Bootstrap dynamique
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    
    const toastId = 'toast-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body">
              ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {delay: 3000});
    toast.show();
    
    // Nettoyer le DOM après disparition
    toastElement.addEventListener('hidden.bs.toast', function () {
        toastElement.remove();
    });
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
    container.style.zIndex = '1100';
    document.body.appendChild(container);
    return container;
}

function applyCoupon() {
    const code = document.getElementById('couponCode').value;
    const msgDiv = document.getElementById('couponMessage');
    
    if(!code) return;

    fetch(`${BASE_URL}/checkout/applyCoupon`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `code=${code}&csrf_token=${CSRF_TOKEN}`
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            msgDiv.className = 'small mt-2 text-success fw-bold';
            msgDiv.innerHTML = `<i class="fas fa-check me-1"></i> ${data.message}`;
            // Dans un vrai projet, on mettrait à jour le total affiché ici aussi
        } else {
            msgDiv.className = 'small mt-2 text-danger fw-bold';
            msgDiv.innerHTML = `<i class="fas fa-times me-1"></i> ${data.message}`;
        }
    });
}
