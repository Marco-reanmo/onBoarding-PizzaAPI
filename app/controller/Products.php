<?php
    class Products extends Controller{
        
        private $productModel;

        public function __construct() {
            if(!isLoggedIn()) {
                redirect('users/login');
            }
            $this->productModel = $this->loadModel('Product');
            $this->ingredientModel = $this->loadModel('Ingredient');
            $this->productImageModel = $this->loadModel('Product_Image');
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
            $productImage = $this->productImageModel->getProductImageByProductID($product->ID);
            $data = [
                'product' => $product,
                'ingredients' => $ingredients,
                'product_image' => $productImage
            ];
            $this->loadView('products/details', $data);
        }
        
    }
    