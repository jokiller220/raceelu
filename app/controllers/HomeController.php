<?php
// app/controllers/HomeController.php

class HomeController extends Controller {
    public function index() {
        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');

        $data = [
            'title' => 'Accueil - Race Élu',
            'categories' => $categoryModel->getCategories(),
            'products' => $productModel->getProducts(8) // Limit to 8 products for home
        ];
        
        $this->view('pages/home', $data);
    }
}
