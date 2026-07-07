<?php
// app/models/Product.php

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getProducts($limit = null) {
        $sql = 'SELECT p.*, c.nom as categorie_nom FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.status = "actif" ORDER BY p.created_at DESC';
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit;
        }
        $this->db->query($sql);
        return $this->db->resultSet();
    }
    
    public function getProductsByCategory($category_id) {
        $this->db->query('SELECT p.*, c.nom as categorie_nom FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = :category_id AND p.status = "actif"');
        $this->db->bind(':category_id', $category_id);
        return $this->db->resultSet();
    }
    
    public function getProductById($id) {
        $this->db->query('SELECT p.*, c.nom as categorie_nom FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getProductsFiltered($search = '', $sort = 'newest', $category_id = null) {
        $sql = 'SELECT p.*, c.nom as categorie_nom FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.status = "actif"';
        
        if (!empty($search)) {
            $sql .= ' AND (p.nom LIKE :search OR p.description LIKE :search)';
        }

        if ($category_id) {
            $sql .= ' AND p.category_id = :category_id';
        }

        switch ($sort) {
            case 'price_asc':
                $sql .= ' ORDER BY p.prix ASC';
                break;
            case 'price_desc':
                $sql .= ' ORDER BY p.prix DESC';
                break;
            case 'oldest':
                $sql .= ' ORDER BY p.created_at ASC';
                break;
            default:
                $sql .= ' ORDER BY p.created_at DESC';
        }

        $this->db->query($sql);
        if (!empty($search)) {
            $this->db->bind(':search', '%' . $search . '%');
        }
        if ($category_id) {
            $this->db->bind(':category_id', $category_id);
        }
        
        return $this->db->resultSet();
    }
}
