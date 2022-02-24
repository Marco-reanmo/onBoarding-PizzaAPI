<?php
    class Ingredient {
        private $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function getIngredients() {
            $this->database->query('SELECT * FROM ingredients');
            return $this->database->resultSet();
        }

        public function getIngredientById($id) {
            $this->database->query('SELECT * FROM ingredients WHERE ingredients.ID = :id');
            $this->database->bind(':id', $id);
            return $this->database->single();
        }

        public function getIngredientsByProductId($prod_id) {
            $this->database->query('SELECT ingredients.ID, ingredients.name
                                    FROM products
                                    JOIN products_ingredients ON products.ID = products_ingredients.product_ID
                                    JOIN ingredients ON products_ingredients.ingredient_ID = ingredients.ID
                                    WHERE products.ID = :prod_id;
            ');
            $this->database->bind(':prod_id', $prod_id);
            return $this->database->resultSet();
        }
    }