<?php
    class Basket {
        private $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function getBasketById($id) {
            $this->database->query('SELECT products.name AS product, products.price AS price, baskets.quantity, 
                                        baskets.ID, baskets.product_ID, baskets.size_ID, sizes.name AS size, sizes.factor AS factor
                                    FROM `baskets` 
                                    JOIN products ON products.ID = baskets.product_ID
                                    JOIN sizes ON sizes.ID = baskets.size_ID
                                    WHERE baskets.ID = :id');
            $this->database->bind(':id', $id);
            return $this->database->resultSet();
        }

        public function add($productId, $quantity, $sizeId) {
            $this->database->query('INSERT INTO baskets(product_id, quantity, size_id) 
                                    VALUES(:productId, :quantity, :sizeId)');
            $this->database->bind(':productId', $productId);
            $this->database->bind(':quantity', $quantity);
            $this->database->bind(':sizeId', $sizeId);
            $this->database->execute();
            return $this->database->lastInsertId();
        }

        public function addToBasket($basketId, $productId, $quantity, $sizeId) {
            $this->database->query('SELECT * FROM baskets WHERE ID = :basketId AND product_id = :productId AND size_ID = :sizeId');
            $this->database->bind(':basketId', $basketId);
            $this->database->bind(':productId', $productId);
            $this->database->bind(':sizeId', $sizeId);
            $result = $this->database->single();
            if(empty($result)) {
                $this->database->query('INSERT INTO baskets(ID, product_id, quantity, size_ID) 
                                    VALUES(:basketId, :productId, :quantity, :sizeId)');
                $this->database->bind(':quantity', $quantity);
                $this->database->bind(':sizeId', $sizeId);
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

        public function deleteProductFromBasket($basketId, $productId, $sizeId) {
            $this->database->query('DELETE FROM baskets 
                                    WHERE ID = :basketID AND product_ID = :productID AND size_ID = :sizeID');
            $this->database->bind(':basketID', $basketId);
            $this->database->bind(':productID', $productId);
            $this->database->bind(':sizeID', $sizeId);
            $this->database->execute();
            return $basketId;
        }
    }
