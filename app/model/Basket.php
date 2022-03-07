<?php
    class Basket {
        private $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function getBasketById($id) {
            $this->database->query('SELECT products.name AS product, products.price AS price, baskets.quantity 
                                    FROM `baskets` 
                                    JOIN products ON products.ID = baskets.product_ID 
                                    WHERE baskets.ID = :id');
            $this->database->bind(':id', $id);
            return $this->database->resultSet();
        }

        public function add($productId, $quantity) {
            $this->database->query('INSERT INTO baskets(product_id, quantity) 
                                    VALUES(:productId, :quantity)');
            $this->database->bind(':productId', $productId);
            $this->database->bind(':quantity', $quantity);
            $this->database->execute();
            return $this->database->lastInsertId();
        }

        public function addToBasket($basketId, $productId, $quantity) {
            $this->database->query('SELECT * FROM baskets WHERE ID = :basketId AND product_id = :productId');
            $this->database->bind(':basketId', $basketId);
            $this->database->bind(':productId', $productId);
            $result = $this->database->single();
            if(empty($result)) {
                $this->database->query('INSERT INTO baskets(ID, product_id, quantity) 
                                    VALUES(:basketId, :productId, :quantity)');
                $this->database->bind(':quantity', $quantity);
            } else {
                $updatedQuantity = $result->quantity + $quantity;
                $this->database->query('UPDATE baskets
                                        SET quantity = :updatedQuantity
                                        WHERE ID = :basketId AND product_id = :productId');
                $this->database->bind(':updatedQuantity', $updatedQuantity);
            }
            $this->database->bind(':basketId', $basketId);
            $this->database->bind(':productId', $productId);
            $this->database->execute();
            return $this->database->lastInsertId();
        }
    }
