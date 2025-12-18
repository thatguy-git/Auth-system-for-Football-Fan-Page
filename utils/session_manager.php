<?php

class SessionManager {

    
     //Start session
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            $isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';

            session_set_cookie_params([
                'lifetime' => 86400,            
                'path'     => '/',
                'domain'   => '',
                'secure'   => $isHttps,         
                'httponly' => true,             
                'samesite' => 'Strict'          
            ]);

            session_start();

            self::checkRegeneration();
        }
    }

    
     //Regenerate session ID
    private static function checkRegeneration() {
        $interval = 60 * 30;

        if (!isset($_SESSION['last_regeneration'])) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        } elseif (time() - $_SESSION['last_regeneration'] >= $interval) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
    }

    
    //Check if user is logged in
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    
    //Get a session variable
    public static function get($key) {
        return $_SESSION[$key] ?? null;
    }

    //login check
    public static function requireLogin() {
        self::start();
        if (!self::isLoggedIn()) {
            header("Location: login.php");
            exit();
        }
    }

    //logut
    public static function destroy() {
        self::start();
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>