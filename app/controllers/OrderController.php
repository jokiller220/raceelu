<?php
// app/controllers/OrderController.php

class OrderController extends Controller {
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = new Database();
    }

    public function track($id = null, $phone = null) {
        $order_id = $id ?? (isset($_GET['id']) ? $_GET['id'] : null);
        $telephone = $phone ?? (isset($_GET['tel']) ? $_GET['tel'] : null);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' || ($order_id && $telephone)) {
            $order_id = $order_id ?? trim($_POST['order_id']);
            $telephone = $telephone ?? trim($_POST['telephone']);

            $this->db->query('SELECT * FROM orders WHERE id = :id AND telephone_client = :tel');
            $this->db->bind(':id', $order_id);
            $this->db->bind(':tel', $telephone);
            $order = $this->db->single();

            if ($order) {
                // Get order items
                $this->db->query('SELECT oi.*, p.nom as produit_nom, p.image as produit_image 
                                FROM order_items oi 
                                JOIN products p ON oi.product_id = p.id 
                                WHERE oi.order_id = :order_id');
                $this->db->bind(':order_id', $order->id);
                $items = $this->db->resultSet();

                $data = [
                    'title' => 'Suivi de commande #' . $order->id . ' - Race Élu',
                    'order' => $order,
                    'items' => $items
                ];
                $this->view('pages/track_result', $data);
                return;
            } else {
                $data = [
                    'title' => 'Suivre ma commande - Race Élu',
                    'error' => 'Aucune commande trouvée avec ces informations. Veuillez vérifier le numéro de commande et le téléphone.'
                ];
                $this->view('pages/track_form', $data);
                return;
            }
        }

        $this->view('pages/track_form', ['title' => 'Suivre ma commande - Race Élu']);
    }
}
