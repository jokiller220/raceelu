<?php
// app/controllers/ShopController.php

class ShopController extends Controller {
    public function index() {
        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');

        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';

        $data = [
            'title' => 'Boutique - Race Élu',
            'categories' => $categoryModel->getCategories(),
            'products' => $productModel->getProductsFiltered($search, $sort),
            'current_category' => 'Toutes les catégories',
            'search' => $search,
            'sort' => $sort
        ];
        
        $this->view('pages/shop', $data);
    }
    
    public function category($slug) {
        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');
        
        $category = $categoryModel->getCategoryBySlug($slug);
        if (!$category) {
            header('Location: ' . BASE_URL . '/shop');
            exit;
        }

        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';

        $data = [
            'title' => $category->nom . ' - Race Élu',
            'categories' => $categoryModel->getCategories(),
            'products' => $productModel->getProductsFiltered($search, $sort, $category->id),
            'current_category' => $category->nom,
            'search' => $search,
            'sort' => $sort
        ];
        
        $this->view('pages/shop', $data);
    }
}
