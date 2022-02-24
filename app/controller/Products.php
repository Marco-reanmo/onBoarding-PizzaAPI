<?php
    class Products extends Controller{
        
        private $productModel;

        public function __construct() {
            if(!isLoggedIn()) {
                redirect('users/login');
            }
            $this->productModel = $this->loadModel('Product');
        }
        
        public function index() {
            $products = $this->productModel->getProducts();
            $data = [
                'title' => 'Pizza API',
                'products' => $products
            ];
            $this->loadView('products/index', $data);;
        }

        /*
        public function about() {
            $this->loadView('products/about');
        }
        */
    }
    