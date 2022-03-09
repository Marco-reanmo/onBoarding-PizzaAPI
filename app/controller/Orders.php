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
                if(isPostRequest()) {
                    if (isset($_SESSION['basket_id'])) {
                        $this->orderModel->postOrder($_SESSION['user_id'], $_SESSION['basket_id']);
                        $basket = $this->basketModel->getBasketById($_SESSION['basket_id']);
                        unset($_SESSION['basket_id']);
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

        public function overview() {
            if(isLoggedIn()) {
                $allOrders = $this->orderModel->getOrdersByUserId($_SESSION['user_id']);
                $orders = array();
                foreach($allOrders as $orderItem) {
                    if(!isset($orders[$orderItem->ID])) {
                        $orders[$orderItem->ID]['products'] = array();
                    }
                    $orders[$orderItem->ID]['created_at'] = $orderItem->created_at;
                    array_push($orders[$orderItem->ID]['products'], [
                        'name' => $orderItem->name,
                        'price' => (double)$orderItem->price,
                        'quantity' => (double)$orderItem->quantity,
                        'size' => $orderItem->size,
                        'factor' => (double) $orderItem->factor
                        ]
                    );
                }
                $data = [
                    'title' => 'Ihre Bestellungen -- Übersicht',
                    'orders' => $orders
                ];
                $this->loadView('orders/overview', $data);
            } else {
                redirect('users/login');
            };
        }
    }