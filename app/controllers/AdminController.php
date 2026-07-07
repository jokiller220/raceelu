<?php
// app/controllers/AdminController.php

class AdminController extends Controller {
    public function __construct() {
        parent::__construct();
        // Protection admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    public function index() {
        $db = new Database();
        
        $db->query('SELECT COUNT(*) as total FROM orders');
        $commandes = $db->single()->total;
        
        $db->query('SELECT COALESCE(SUM(total), 0) as total FROM orders');
        $ca = $db->single()->total;
        
        $db->query('SELECT COUNT(*) as total FROM users WHERE role="client"');
        $clients = $db->single()->total;
        
        $db->query('SELECT COUNT(*) as total FROM products');
        $produits = $db->single()->total;

        $db->query('SELECT COUNT(*) as total FROM products WHERE stock < 10');
        $low_stock = $db->single()->total;

        // Top 5 Best Sellers
        $db->query('SELECT p.nom, SUM(oi.quantite) as total_vendu FROM order_items oi JOIN products p ON oi.product_id = p.id GROUP BY oi.product_id, p.nom ORDER BY total_vendu DESC LIMIT 5');
        $best_sellers = $db->resultSet();

        // Top product of the year
        $db->query('SELECT p.nom, SUM(oi.quantite) as total_vendu FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN orders o ON oi.order_id = o.id WHERE YEAR(o.created_at) = YEAR(CURDATE()) GROUP BY oi.product_id, p.nom ORDER BY total_vendu DESC LIMIT 1');
        $top_year = $db->single();
        
        $db->query('SELECT * FROM orders ORDER BY created_at DESC LIMIT 5');
        $recent_orders = $db->resultSet();

        // Ventes par mois (6 derniers mois)
        $db->query('SELECT DATE_FORMAT(created_at, "%Y-%m") as mois, SUM(total) as CA FROM orders WHERE status != "annulee" GROUP BY DATE_FORMAT(created_at, "%Y-%m") ORDER BY mois DESC LIMIT 6');
        $monthly_sales = array_reverse($db->resultSet());

        // CA par catégorie
        $db->query('SELECT c.nom, SUM(oi.prix_unitaire * oi.quantite) as CA FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN categories c ON p.category_id = c.id GROUP BY c.id, c.nom ORDER BY CA DESC');
        $category_sales = $db->resultSet();

        // Top 5 Clients (par CA)
        $db->query('SELECT MAX(nom_client) as nom_client, telephone_client, SUM(total) as CA, COUNT(*) as nb_commandes FROM orders GROUP BY telephone_client ORDER BY CA DESC LIMIT 5');
        $top_customers = $db->resultSet();

        $data = [
            'title' => 'Dashboard - Admin Race Élu',
            'page_title' => 'Tableau de bord',
            'active_menu' => 'dashboard',
            'stats' => [
                'commandes' => $commandes,
                'ca' => $ca,
                'clients' => $clients,
                'produits' => $produits,
                'low_stock' => $low_stock,
                'best_sellers' => $best_sellers,
                'top_year' => $top_year,
                'monthly_sales' => $monthly_sales,
                'category_sales' => $category_sales,
                'top_customers' => $top_customers
            ],
            'recent_orders' => $recent_orders
        ];

        $this->view('admin/dashboard', $data);
    }
    
    // ==========================================
    // COMMANDES
    // ==========================================
    
    public function orders() {
        $db = new Database();
        $db->query('SELECT * FROM orders ORDER BY created_at DESC');
        $orders = $db->resultSet();
        
        $data = [
            'title' => 'Commandes - Admin Race Élu',
            'page_title' => 'Gestion des commandes',
            'active_menu' => 'orders',
            'orders' => $orders
        ];
        
        $this->view('admin/orders', $data);
    }

    public function orderShow($id) {
        $db = new Database();
        $db->query('SELECT * FROM orders WHERE id = :id');
        $db->bind(':id', $id);
        $order = $db->single();

        if (!$order) {
            header('Location: ' . BASE_URL . '/admin/orders');
            exit;
        }

        // Récupérer les articles de la commande
        $db->query('SELECT oi.*, p.nom as product_name, p.image FROM order_items oi LEFT JOIN products p ON oi.product_id = p.id WHERE oi.order_id = :id');
        $db->bind(':id', $id);
        $items = $db->resultSet();

        $data = [
            'title' => 'Détail Commande - Admin Race Élu',
            'page_title' => 'Commande #' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
            'active_menu' => 'orders',
            'order' => $order,
            'items' => $items
        ];
        
        $this->view('admin/order_show', $data);
    }

    public function updateOrderStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])) {
            $db = new Database();
            $db->query('UPDATE orders SET status = :status WHERE id = :id');
            $db->bind(':status', $_POST['status']);
            $db->bind(':id', $id);
            $db->execute();
        }
        header('Location: ' . BASE_URL . '/admin/orderShow/' . $id);
        exit;
    }

    public function orderInvoice($id) {
        $db = new Database();
        $db->query('SELECT * FROM orders WHERE id = :id');
        $db->bind(':id', $id);
        $order = $db->single();

        if (!$order) {
            header('Location: ' . BASE_URL . '/admin/orders');
            exit;
        }

        $db->query('SELECT oi.*, p.nom as product_name FROM order_items oi LEFT JOIN products p ON oi.product_id = p.id WHERE oi.order_id = :id');
        $db->bind(':id', $id);
        $items = $db->resultSet();

        $data = [
            'order' => $order,
            'items' => $items
        ];
        
        $this->view('admin/invoice', $data);
    }

    public function orderDelete($id) {
        $db = new Database();
        $db->query('DELETE FROM order_items WHERE order_id = :id');
        $db->bind(':id', $id);
        $db->execute();
        
        $db->query('DELETE FROM orders WHERE id = :id');
        $db->bind(':id', $id);
        $db->execute();
        header('Location: ' . BASE_URL . '/admin/orders');
        exit;
    }
    
    // ==========================================
    // PRODUITS
    // ==========================================
    
    public function products() {
        $db = new Database();
        $db->query('SELECT p.*, c.nom as categorie_nom FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC');
        $products = $db->resultSet();
        
        $data = [
            'title' => 'Produits - Admin Race Élu',
            'page_title' => 'Gestion des produits',
            'active_menu' => 'products',
            'products' => $products
        ];
        
        $this->view('admin/products', $data);
    }

    public function productAdd() {
        $db = new Database();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = $this->uploadImage($_FILES['image'] ?? null);
            
            $db->query('INSERT INTO products (category_id, nom, description, prix, prix_promo, unite, stock, image, status) VALUES (:category_id, :nom, :description, :prix, :prix_promo, :unite, :stock, :image, :status)');
            $db->bind(':category_id', !empty($_POST['category_id']) ? $_POST['category_id'] : null);
            $db->bind(':nom', $_POST['nom']);
            $db->bind(':description', $_POST['description'] ?? '');
            $db->bind(':prix', $_POST['prix']);
            $db->bind(':prix_promo', !empty($_POST['prix_promo']) ? $_POST['prix_promo'] : null);
            $db->bind(':unite', $_POST['unite']);
            $db->bind(':stock', $_POST['stock']);
            $db->bind(':image', $image ?: 'default.jpg');
            $db->bind(':status', $_POST['status'] ?? 'actif');
            $db->execute();
            
            header('Location: ' . BASE_URL . '/admin/products');
            exit;
        }

        $db->query('SELECT * FROM categories ORDER BY nom ASC');
        $categories = $db->resultSet();

        $data = [
            'title' => 'Nouveau Produit - Admin Race Élu',
            'page_title' => 'Ajouter un produit',
            'active_menu' => 'products',
            'categories' => $categories,
            'product' => null
        ];
        
        $this->view('admin/product_form', $data);
    }

    public function productEdit($id) {
        $db = new Database();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db->query('SELECT image FROM products WHERE id = :id');
            $db->bind(':id', $id);
            $currentProduct = $db->single();
            $currentImage = $currentProduct ? $currentProduct->image : 'default.jpg';

            $image = $this->uploadImage($_FILES['image'] ?? null);
            if (!$image) $image = $currentImage;

            $db->query('UPDATE products SET category_id=:category_id, nom=:nom, description=:description, prix=:prix, prix_promo=:prix_promo, unite=:unite, stock=:stock, image=:image, status=:status WHERE id=:id');
            $db->bind(':category_id', !empty($_POST['category_id']) ? $_POST['category_id'] : null);
            $db->bind(':nom', $_POST['nom']);
            $db->bind(':description', $_POST['description'] ?? '');
            $db->bind(':prix', $_POST['prix']);
            $db->bind(':prix_promo', !empty($_POST['prix_promo']) ? $_POST['prix_promo'] : null);
            $db->bind(':unite', $_POST['unite']);
            $db->bind(':stock', $_POST['stock']);
            $db->bind(':image', $image);
            $db->bind(':status', $_POST['status'] ?? 'actif');
            $db->bind(':id', $id);
            $db->execute();
            
            header('Location: ' . BASE_URL . '/admin/products');
            exit;
        }

        $db->query('SELECT * FROM products WHERE id = :id');
        $db->bind(':id', $id);
        $product = $db->single();

        if (!$product) {
            header('Location: ' . BASE_URL . '/admin/products');
            exit;
        }

        $db->query('SELECT * FROM categories ORDER BY nom ASC');
        $categories = $db->resultSet();

        $data = [
            'title' => 'Modifier Produit - Admin Race Élu',
            'page_title' => 'Modifier : ' . $product->nom,
            'active_menu' => 'products',
            'categories' => $categories,
            'product' => $product
        ];
        
        $this->view('admin/product_form', $data);
    }

    public function productDelete($id) {
        $db = new Database();
        $db->query('DELETE FROM products WHERE id = :id');
        $db->bind(':id', $id);
        $db->execute();
        header('Location: ' . BASE_URL . '/admin/products');
        exit;
    }
    
    // ==========================================
    // CATÉGORIES
    // ==========================================
    
    public function categories() {
        $db = new Database();
        $db->query('SELECT * FROM categories ORDER BY nom ASC');
        $categories = $db->resultSet();
        
        $data = [
            'title' => 'Catégories - Admin Race Élu',
            'page_title' => 'Gestion des catégories',
            'active_menu' => 'categories',
            'categories' => $categories
        ];
        
        $this->view('admin/categories', $data);
    }

    public function categoryAdd() {
        $db = new Database();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['nom'])));

            $db->query('INSERT INTO categories (nom, slug, description, image, status) VALUES (:nom, :slug, :description, :image, :status)');
            $db->bind(':nom', $_POST['nom']);
            $db->bind(':slug', $slug);
            $db->bind(':description', $_POST['description'] ?? '');
            $db->bind(':image', 'default.jpg');
            $db->bind(':status', $_POST['status'] ?? 'actif');
            $db->execute();
            
            header('Location: ' . BASE_URL . '/admin/categories');
            exit;
        }

        $data = [
            'title' => 'Nouvelle Catégorie - Admin Race Élu',
            'page_title' => 'Ajouter une catégorie',
            'active_menu' => 'categories',
            'category' => null
        ];
        
        $this->view('admin/category_form', $data);
    }

    public function categoryEdit($id) {
        $db = new Database();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['nom'])));

            $db->query('UPDATE categories SET nom=:nom, slug=:slug, description=:description, status=:status WHERE id=:id');
            $db->bind(':nom', $_POST['nom']);
            $db->bind(':slug', $slug);
            $db->bind(':description', $_POST['description'] ?? '');
            $db->bind(':status', $_POST['status'] ?? 'actif');
            $db->bind(':id', $id);
            $db->execute();
            
            header('Location: ' . BASE_URL . '/admin/categories');
            exit;
        }

        $db->query('SELECT * FROM categories WHERE id = :id');
        $db->bind(':id', $id);
        $category = $db->single();

        if (!$category) {
            header('Location: ' . BASE_URL . '/admin/categories');
            exit;
        }

        $data = [
            'title' => 'Modifier Catégorie - Admin Race Élu',
            'page_title' => 'Modifier : ' . $category->nom,
            'active_menu' => 'categories',
            'category' => $category
        ];
        
        $this->view('admin/category_form', $data);
    }

    public function categoryDelete($id) {
        $db = new Database();
        $db->query('DELETE FROM categories WHERE id = :id');
        $db->bind(':id', $id);
        $db->execute();
        header('Location: ' . BASE_URL . '/admin/categories');
        exit;
    }
    
    // ==========================================
    // CLIENTS
    // ==========================================
    
    public function clients() {
        $db = new Database();
        $db->query('SELECT * FROM users WHERE role="client" ORDER BY created_at DESC');
        $clients = $db->resultSet();
        
        $data = [
            'title' => 'Clients - Admin Race Élu',
            'page_title' => 'Gestion des clients',
            'active_menu' => 'clients',
            'clients' => $clients
        ];
        
        $this->view('admin/clients', $data);
    }

    public function clientDelete($id) {
        $db = new Database();
        $db->query('DELETE FROM users WHERE id = :id AND role = "client"');
        $db->bind(':id', $id);
        $db->execute();
        header('Location: ' . BASE_URL . '/admin/clients');
        exit;
    }

    // ==========================================
    // PARAMÈTRES
    // ==========================================

    public function settings() {
        $db = new Database();
        $db->query('SELECT * FROM settings ORDER BY category, id');
        $settings = $db->resultSet();

        $data = [
            'title' => 'Paramètres - Admin Race Élu',
            'page_title' => 'Paramètres du site',
            'active_menu' => 'settings',
            'settings' => $settings
        ];

        $this->view('admin/settings', $data);
    }

    public function updateSettings() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db = new Database();
            foreach ($_POST['settings'] as $key => $value) {
                $db->query('UPDATE settings SET setting_value = :value WHERE setting_key = :key');
                $db->bind(':value', $value);
                $db->bind(':key', $key);
                $db->execute();
            }
            header('Location: ' . BASE_URL . '/admin/settings?success=1');
            exit;
        }
    }

    // ==========================================
    // UTILITAIRE UPLOAD
    // ==========================================

    private function uploadImage($file) {
        if (isset($file) && is_array($file) && $file['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $filename = $file['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $newName = uniqid() . '.' . $ext;
                $destination = 'public/assets/images/' . $newName;
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    return $newName;
                }
            }
        }
        return false;
    }
}
