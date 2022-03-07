<?php

class  Order {
    public function __construct() {
        $this->database = new Database();
    }

    public function getOrdersByUserId($userId) {
        $this->database->query('SELECT orders.ID, orders.created_at, orders.user_ID, orders.basket_ID, products.name, baskets.quantity, products.price 
                                FROM orders
                                JOIN baskets ON baskets.ID = orders.basket_ID
                                JOIN products ON products.ID = baskets.product_ID
                                WHERE orders.user_id = :userId
                                ORDER BY created_at DESC');
       $this->database->bind(':userId', $userId);
       return $this->database->resultSet(); 
    }

    public function postOrder($userId, $basketId) {
        $this->database->query('INSERT INTO orders (user_ID, basket_ID)
                                VALUES (:userID, :basketID)');
        $this->database->bind(':userID', $userId);
        $this->database->bind('basketID', $basketId);
        return $this->database->lastInsertId();
    }
}