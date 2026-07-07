<?php
// app/models/Category.php

class Category {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getCategories() {
        $this->db->query('SELECT * FROM categories ORDER BY nom ASC');
        return $this->db->resultSet();
    }
    
    public function getCategoryBySlug($slug) {
        $this->db->query('SELECT * FROM categories WHERE slug = :slug');
        $this->db->bind(':slug', $slug);
        return $this->db->single();
    }
}
