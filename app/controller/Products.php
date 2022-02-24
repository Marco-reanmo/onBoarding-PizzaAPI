<?php
    class Products extends Controller{
        
        private $productModel;

        public function __construct() {
            if(!isLoggedIn()) {
                redirect('users/login');
            }
            $this->productModel = $this->loadModel('Product');
            $this->ingredientModel = $this->loadModel('Ingredient');
        }
        
        public function index() {
            $products = $this->productModel->getProducts();
            $data = [
                'title' => 'Pizza API',
                'products' => $products
            ];
            $this->loadView('products/index', $data);;
        }

        public function details($id) {
            $product = $this->productModel->getProductById($id);
            $ingredients = $this->ingredientModel->getIngredientsByProductID($product->ID);
            $data = [
                'product' => $product,
                'ingredients' => $ingredients
            ];
            $this->loadView('products/details', $data);
        }
        
    }
    