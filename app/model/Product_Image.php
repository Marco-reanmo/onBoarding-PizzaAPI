<?php
    class Product_Image {
        private $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function getProductImages() {
            $this->database->query('SELECT * FROM product_images');
            return $this->database->resultSet();
        }

        public function getProductImageById($id) {
            $this->database->query('SELECT * FROM product_images WHERE product_images.ID = :id');
            $this->database->bind(':id', $id);
            return $this->database->single();
        }

        public function getProductImageByProductId($prod_id) {
            $this->database->query('SELECT product_images.ID, product_images.image
                                    FROM products
                                    JOIN product_images ON products.image_ID = product_images.ID
                                    WHERE products.ID = :prod_id;');
            $this->database->bind(':prod_id', $prod_id);
            $row = $this->database->single();
            if($row) {
                return $row;
            } else {
                return null;
            }
        }
    }