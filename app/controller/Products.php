<?php
    require_once APPROOT . 'bootstrap.php';

    class Products extends Controller{
        
        private $productModel;

        public function __construct() {
            if(!isLoggedIn()) {
                redirect('users/login');
            }
            $this->productModel = $this->loadModel('Product');
            $this->ingredientModel = $this->loadModel('Ingredient');
            $this->productImageModel = $this->loadModel('Product_Image');
            $this->basketModel = $this->loadModel('Basket');
            $this->sizeModel = $this->loadModel('Size');
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

        public function baskets() {
            if(isLoggedIn()) {
                unset($_SESSION['add_success']);
                if(isPostRequest()) {
                    $post = getSanitizedPostData();
                    $this->basketModel->deleteProductFromBasket($post['basket_id'], $post['product_id']);
                    $basket = $this->basketModel->getBasketById($post['basket_id']);
                    if(empty($basket)) {
                        unset($_SESSION['basket_id']);
                    }
                }
                $session_basket = null;
                if(isset($_SESSION['basket_id'])) {
                    $session_basket = $this->basketModel->getBasketById($_SESSION['basket_id']);
                }
                $data = [
                    'title' => "Warenkorb",
                    'user_id' => $_SESSION['user_id'],
                    'basket' => $session_basket
                ];
                $this->loadView('products/baskets', $data);  
            } else {
                redirect('users/login');
            };
        }

        public function add() {
            if(isLoggedIn()) {
                if(isPostRequest()) {
                    unset($_SESSION['add_success']);
                    $post = getSanitizedPostData();
                    $size = $this->sizeModel->getSizeByRadioButtonString($post['size']);
                    if(isset($_SESSION['basket_id'])) {
                        $this->basketModel->addToBasket($_SESSION['basket_id'], $post['productId'], $post['quantity'], $size->ID);                      
                    } else {
                        $basket_id = $this->basketModel->add($post['productId'], $post['quantity'], $size->ID);
                        $_SESSION['basket_id'] = $basket_id;
                    }
                    $allProducts = $this->productModel->getProducts();
                    $data = [
                        'title' => 'Pizza API',
                        'products' => $allProducts
                    ];
                    $product = $this->productModel->getProductById($post['productId']);
                    $msg = $post['quantity'] . ' x Pizza ' . $product->name . ' (' . $size->name . ') zum Warenkorb hinzugefügt';
                    flash('add_success', $msg);
                    $this->loadView('products/index', $data);
                } else {
                    redirect('products/index');
                }
            } else {
                redirect('users/login');
            };
        }
        
    }
    