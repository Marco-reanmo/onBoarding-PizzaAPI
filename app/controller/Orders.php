<?php
    require_once APPROOT . 'bootstrap.php';

    class Orders extends Controller{

        public function __construct() {
            $this->orderModel = $this->loadModel('Order');
            $this->productModel = $this->loadModel('Product');
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