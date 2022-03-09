<?php
    class Product {
        private $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function getProducts() {
            $this->database->query('SELECT * FROM products');
            return $this->database->resultSet();
        }

        public function getProductById($id) {
            $this->database->query('SELECT * FROM products WHERE products.ID = :id');
            $this->database->bind(':id', $id);
            return $this->database->single();
        }

        public function getProductsByCategory($categoryId) {
            $this->database->query('SELECT *
                                    FROM products
                                    WHERE category_ID = :categoryId');
            $this->database->bind(':categoryId', $categoryId);
            return $this->database->resultSet();
        }
    }