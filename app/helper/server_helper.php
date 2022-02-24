<?php
    function isPostRequest() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    function getSanitizedPostData() {
        return filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
    }