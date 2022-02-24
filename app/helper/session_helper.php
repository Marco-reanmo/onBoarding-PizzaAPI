<?php
    session_start();

    function flash($name = '', $message = '', $class = 'alert') {
        if(!empty($name)) {
            if(!empty($message) && empty($_SESSION[$name])) {
                if(!empty($_SESSION[$name])) {

                }
                if(!empty($_SESSION[$name . '_class'])) {

                }
                $_SESSION[$name] = $message;
                $_SESSION[$name . '_class'] = $class;
            } elseif(empty($message) && !empty($_SESSION[$name])) {
                $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
                echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            }
        }   
    }

    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }