<?php
// app/controllers/ProductController.php

class ProductController extends Controller {
    public function show($id) {
        $productModel = $this->model('Product');
        $db = new Database();

        $product = $productModel->getProductById($id);
        if (!$product) {
            header('Location: ' . BASE_URL . '/shop');
            exit;
        }

        // Fetch approved reviews
        $db->query('SELECT * FROM reviews WHERE product_id = :pid AND status = "approuve" ORDER BY created_at DESC');
        $db->bind(':pid', $id);
        $reviews = $db->resultSet();

        $data = [
            'title' => $product->nom . ' - Race Élu',
            'product' => $product,
            'related_products' => $productModel->getProductsByCategory($product->category_id),
            'reviews' => $reviews
        ];
        
        $this->view('pages/product', $data);
    }

    public function addReview() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $db = new Database();
            $db->query('INSERT INTO reviews (product_id, user_id, user_nom, note, commentaire) VALUES (:pid, :uid, :unom, :note, :com)');
            $db->bind(':pid', $_POST['product_id']);
            $db->bind(':uid', $_SESSION['user_id']);
            $db->bind(':unom', $_SESSION['user_nom']);
            $db->bind(':note', $_POST['note']);
            $db->bind(':com', $_POST['commentaire']);
            $db->execute();

            header('Location: ' . BASE_URL . '/product/show/' . $_POST['product_id'] . '?review_sent=1');
            exit;
        }
        header('Location: ' . BASE_URL . '/shop');
    }
}
