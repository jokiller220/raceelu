<?php
// app/controllers/PageController.php

class PageController extends Controller {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    private function getSetting($key) {
        $this->db->query('SELECT setting_value FROM settings WHERE setting_key = :key');
        $this->db->bind(':key', $key);
        $res = $this->db->single();
        return $res ? $res->setting_value : '';
    }

    public function about() {
        $data = [
            'title' => 'À propos - Race Élu',
            'content' => $this->getSetting('site_about')
        ];
        $this->view('pages/about', $data);
    }

    public function services() {
        $data = [
            'title' => 'Nos Services - Race Élu',
            'content' => $this->getSetting('site_services')
        ];
        $this->view('pages/services', $data);
    }

    public function contact() {
        $data = [
            'title' => 'Contactez-nous - Race Élu',
            'address' => $this->h_getSetting('site_contact_address'),
            'phone' => $this->h_getSetting('site_contact_phone'),
            'email' => $this->h_getSetting('site_contact_email')
        ];
        $this->view('pages/contact', $data);
    }

    public function promotions() {
        $db = new Database();
        $db->query('SELECT p.*, c.nom as categorie_nom, pr.pourcentage_remise FROM products p JOIN promotions pr ON p.id = pr.product_id LEFT JOIN categories c ON p.category_id = c.id WHERE p.status = "actif" AND (pr.date_debut IS NULL OR pr.date_debut <= CURDATE()) AND (pr.date_fin IS NULL OR pr.date_fin >= CURDATE())');
        $promotions = $db->resultSet();
        $data = [
            'title' => 'Promotions - Race Élu',
            'promotions' => $promotions
        ];
        $this->view('pages/promotions', $data);
    }

    public function returns() {
        $data = ['title' => 'Politique de retour - Race Élu'];
        $this->view('pages/returns', $data);
    }

    public function faq() {
        $data = ['title' => 'FAQ - Race Élu'];
        $this->view('pages/faq', $data);
    }

    private function h_getSetting($key) {
        return $this->getSetting($key);
    }
}
