<?php
// app/controllers/CartController.php

class CartController extends Controller {
    public function index() {
        $productModel = $this->model('Product');
        $cartItems = [];
        $total = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id => $quantity) {
                $product = $productModel->getProductById($id);
                if ($product) {
                    $itemPrice = !empty($product->prix_promo) ? $product->prix_promo : $product->prix;
                    $subtotal = $itemPrice * $quantity;
                    $total += $subtotal;
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'price' => $itemPrice,
                        'subtotal' => $subtotal
                    ];
                }
            }
        }

        $data = [
            'title' => 'Mon Panier - Race Élu',
            'cart_items' => $cartItems,
            'total' => $total
        ];

        $this->view('pages/cart', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            if ($product_id > 0) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id] += $quantity;
                } else {
                    $_SESSION['cart'][$product_id] = $quantity;
                }

                // Calculer le total et le nombre d'articles
                $cartCount = array_sum($_SESSION['cart']);
                $total = $this->calculateTotal();

                if (ob_get_length()) ob_clean();
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success', 
                    'cartCount' => $cartCount,
                    'cartTotal' => $total
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Produit invalide']);
            }
            exit;
        }
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
            
            if ($product_id > 0 && isset($_SESSION['cart'][$product_id])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$product_id] = $quantity;
                } else {
                    unset($_SESSION['cart'][$product_id]);
                }
            }
            header('Location: ' . BASE_URL . '/cart');
        }
    }

    public function remove($product_id) {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        header('Location: ' . BASE_URL . '/cart');
    }
    
    private function calculateTotal() {
        $productModel = $this->model('Product');
        $total = 0;
        if(isset($_SESSION['cart'])) {
            foreach($_SESSION['cart'] as $id => $qty) {
                $p = $productModel->getProductById($id);
                if($p) {
                    $itemPrice = !empty($p->prix_promo) ? $p->prix_promo : $p->prix;
                    $total += $itemPrice * $qty;
                }
            }
        }
        return $total;
    }
}
