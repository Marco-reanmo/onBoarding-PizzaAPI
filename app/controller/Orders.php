<?php
    require_once APPROOT . 'bootstrap.php';

    class Orders extends Controller {

        public function __construct() {
            $this->orderModel = $this->loadModel('Order');
            $this->productModel = $this->loadModel('Product');
            $this->basketModel = $this->loadModel('Basket');
        }

        public function index() {
            if(isLoggedIn()) {
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $post = getSanitizedPostData();
                    if (isset($post['basket_id'])) {
                        $this->orderModel->postOrder($_SESSION['user_id'], $post['basket_id']);
                        unset($_SESSION['basket_id']);
                        $basket = $this->basketModel->getBasketById($post['basket_id']);
                        $data['title'] = "Bestellung Abgeschlossen";
                        $data['basket'] = $basket;
                        $this->orderModel = $this->loadView('orders/index', $data);
                    } else {
                        redirect('orders/overview/' . $_SESSION['user_id']);
                    }
                } else {
                    redirect('orders/overview/' . $_SESSION['user_id']);
                }
            } else {
                redirect('users/login');
            };
        }

        public function overview($userId) {
            if(isLoggedIn()) {
                if($_SESSION['user_id'] == $userId) {
                    $allOrders = $this->orderModel->getOrdersByUserId($userId);
                    $orders = array();
                    foreach($allOrders as $orderItem) {
                        if(!isset($orders[$orderItem->ID])) {
                            $orders[$orderItem->ID]['products'] = array();
                        }
                        $orders[$orderItem->ID]['created_at'] = $orderItem->created_at;
                        array_push($orders[$orderItem->ID]['products'], [
                            'name' => $orderItem->name,
                            'price' => (double)$orderItem->price,
                            'quantity' => (double)$orderItem->quantity]
                        );
                    }
                    $data = [
                        'title' => 'Ihre Bestellungen -- Übersicht',
                        'orders' => $orders
                    ];
                    $this->loadView('orders/overview', $data);
                } else {
                    redirect('products/index');
                }
            } else {
                redirect('users/login');
            };
        }
    }