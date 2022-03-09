<?php

    function getDefaultImageByCategoryId($categoryId) {
        switch ($categoryId) {
            case 1: return URLROOT . 'public/images/default_salad.jpg';
            case 2: return URLROOT . 'public/images/default_pizza.png';
            case 3: return URLROOT . 'public/images/default_drink.jpg';
        }
    }