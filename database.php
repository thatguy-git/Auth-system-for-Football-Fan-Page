<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

    $db_name =$_ENV['DB_NAME'];
    $db_server =$_ENV['DB_HOST'];
    $db_user = $_ENV['DB_USER'];
    $db_pass =$_ENV['DB_PASS'];
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    

    try{
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
        
    } catch (mysqli_sql_exception $e) {
        $log_file = __DIR__ . '/error-logs.txt';
        $timestamp = date("Y-m-d H:i:s");
        $error_message = "[$timestamp] Database Error: " . $e->getMessage() . PHP_EOL;
        error_log($error_message, 3, $log_file);
        echo "<h1>Site is currently down for maintenance.</h1>";
        exit();
    }
?>