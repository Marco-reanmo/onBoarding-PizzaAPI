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
    }