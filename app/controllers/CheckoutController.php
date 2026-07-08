<?php
// app/controllers/CheckoutController.php

class CheckoutController extends Controller {
    public function index() {
        if (empty($_SESSION['cart'])) {
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }

        $productModel = $this->model('Product');
        $cartItems = [];
        $total = 0;

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

        $data = [
            'title' => 'Commander - Race Élu',
            'cart_items' => $cartItems,
            'total' => $total,
            'frais_livraison' => 2000
        ];

        $this->view('pages/checkout', $data);
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['cart'])) {
            // Validation simple
            $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
            $telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
            $adresse = htmlspecialchars(trim($_POST['adresse'] ?? ''));
            $ville = htmlspecialchars(trim($_POST['ville'] ?? ''));
            $mode_paiement = htmlspecialchars(trim($_POST['mode_paiement'] ?? ''));

            if (empty($nom) || empty($telephone) || empty($adresse) || empty($ville)) {
                // Gérer l'erreur (dans un cas réel, rediriger avec message)
                header('Location: ' . BASE_URL . '/checkout?error=1');
                exit;
            }

            $db = new Database();
            $productModel = $this->model('Product');
            
            // Calculer total
            $total = 0;
            $items = [];
            foreach ($_SESSION['cart'] as $id => $quantity) {
                $product = $productModel->getProductById($id);
                if ($product) {
                    $itemPrice = !empty($product->prix_promo) ? $product->prix_promo : $product->prix;
                    $total += $itemPrice * $quantity;
                    $items[] = ['id' => $id, 'nom' => $product->nom, 'prix' => $itemPrice, 'qty' => $quantity];
                }
            }
            $total += 2000; // Frais livraison
            
            // Gestion de l'utilisation des points de fidélité
            $reduction_points = 0;
            $points_utilises = 0;
            if (isset($_POST['use_points']) && $_POST['use_points'] == '1' && isset($_SESSION['user_id'])) {
                $userPoints = get_user_points($_SESSION['user_id']);
                if ($userPoints > 0) {
                    $reduction_points = $userPoints * POINT_VALUE;
                    if ($reduction_points > $total) {
                        $reduction_points = $total;
                        $points_utilises = ceil($total / POINT_VALUE);
                    } else {
                        $points_utilises = $userPoints;
                    }
                    $total -= $reduction_points;
                    $db->query('UPDATE users SET points = points - :pu WHERE id = :id');
                    $db->bind(':pu', $points_utilises);
                    $db->bind(':id', $_SESSION['user_id']);
                    $db->execute();
                }
            }

            // Gestion du code promo (Coupon)
            $reduction_coupon = 0;
            if (!empty($_POST['coupon_code'])) {
                $code = trim($_POST['coupon_code']);
                $db->query('SELECT * FROM coupons WHERE code = :code AND status = "actif" AND (expire_at IS NULL OR expire_at >= CURDATE())');
                $db->bind(':code', $code);
                $coupon = $db->single();

                if ($coupon) {
                    if ($coupon->usage_limit === null || $coupon->usage_count < $coupon->usage_limit) {
                        if ($coupon->type == 'percent') {
                            $reduction_coupon = ($total * $coupon->valeur) / 100;
                        } else {
                            $reduction_coupon = $coupon->valeur;
                        }
                        $total -= $reduction_coupon;
                        $db->query('UPDATE coupons SET usage_count = usage_count + 1 WHERE id = :id');
                        $db->bind(':id', $coupon->id);
                        $db->execute();
                    }
                }
            }

            // Insérer commande
            $points_gagnes = floor($total / POINTS_RATIO);
            $db->query('INSERT INTO orders (user_id, nom_client, telephone_client, adresse_livraison, ville_livraison, total, mode_paiement, status, points_gagnes, points_utilises, reduction_fidelite) VALUES (:user_id, :nom, :tel, :adresse, :ville, :total, :paiement, "en_attente", :points, :pu, :red)');
            $db->bind(':user_id', isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);
            $db->bind(':nom', $nom);
            $db->bind(':tel', $telephone);
            $db->bind(':adresse', $adresse);
            $db->bind(':ville', $ville);
            $db->bind(':total', $total);
            $db->bind(':paiement', $mode_paiement);
            $db->bind(':points', $points_gagnes);
            $db->bind(':pu', $points_utilises);
            $db->bind(':red', $reduction_points + $reduction_coupon);
            $db->execute();
            
            $orderId = $db->lastInsertId();

            // Attribuer les points à l'utilisateur s'il est connecté
            if (isset($_SESSION['user_id'])) {
                $db->query('UPDATE users SET points = points + :points WHERE id = :id');
                $db->bind(':points', $points_gagnes);
                $db->bind(':id', $_SESSION['user_id']);
                $db->execute();
            }

            // Insérer order_items et maj stock
            foreach ($items as $item) {
                $db->query('INSERT INTO order_items (order_id, product_id, quantite, prix_unitaire) VALUES (:oid, :pid, :qty, :prix)');
                $db->bind(':oid', $orderId);
                $db->bind(':pid', $item['id']);
                $db->bind(':qty', $item['qty']);
                $db->bind(':prix', $item['prix']);
                $db->execute();

                // Maj stock
                $db->query('UPDATE products SET stock = stock - :qty WHERE id = :id');
                $db->bind(':qty', $item['qty']);
                $db->bind(':id', $item['id']);
                $db->execute();
            }

            // Vider le panier
            unset($_SESSION['cart']);

            // Construire message WhatsApp
            $whatsapp_text = "Bonjour Race Élu ! Je viens de passer une commande sur le site.\n\n";
            $whatsapp_text .= "*Commande #* : " . $orderId . "\n";
            $whatsapp_text .= "*Nom* : " . $nom . "\n";
            $whatsapp_text .= "*Ville* : " . $ville . "\n";
            $whatsapp_text .= "*Total* : " . number_format($total, 0, ',', ' ') . " FCFA\n\n";
            $whatsapp_text .= "*Articles* :\n";
            foreach ($items as $item) {
                $whatsapp_text .= "- " . $item['qty'] . "x " . $item['nom'] . "\n";
            }
            $whatsapp_url = "https://wa.me/" . preg_replace('/[^0-9]/', '', get_setting('site_contact_phone')) . "?text=" . urlencode($whatsapp_text);

            // Rediriger vers succès
            $this->view('pages/success', [
                'title' => 'Commande réussie', 
                'order_id' => $orderId,
                'telephone' => $telephone,
                'points_gagnes' => $points_gagnes,
                'whatsapp_url' => $whatsapp_url
            ]);
        } else {
            header('Location: ' . BASE_URL . '/shop');
        }
    }

    public function applyCoupon() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['code'])) {
            $code = trim($_POST['code']);
            $db = new Database();
            $db->query('SELECT * FROM coupons WHERE code = :code AND status = "actif" AND (expire_at IS NULL OR expire_at >= CURDATE())');
            $db->bind(':code', $code);
            $coupon = $db->single();

            header('Content-Type: application/json');
            if ($coupon) {
                if ($coupon->usage_limit !== null && $coupon->usage_count >= $coupon->usage_limit) {
                    echo json_encode(['status' => 'error', 'message' => 'Ce code a atteint sa limite d\'utilisation.']);
                } else {
                    $val = ($coupon->type == 'percent') ? $coupon->valeur . '%' : $coupon->valeur . ' FCFA';
                    echo json_encode(['status' => 'success', 'message' => 'Réduction de ' . $val . ' appliquée !']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Code promo invalide ou expiré.']);
            }
            exit;
        }
    }
}
