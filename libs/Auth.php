<?php

class Auth {

    public static function checkLogin() {
        @session_start();
        $logged = $_SESSION['loggedIn'];
        if ($logged == false) {
            session_destroy();
            header('location: ' . URL);
            exit;
        }
        return $logged;
    }

}
