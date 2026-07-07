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

    private function h_getSetting($key) {
        return $this->getSetting($key);
    }
}
