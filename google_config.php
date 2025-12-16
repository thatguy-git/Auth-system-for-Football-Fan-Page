<?php
require_once 'vendor/autoload.php';

if(!session_id()) session_start();

$client = new Google\Client();

$client->setClientId($ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($ENV['GOOGLE_REDIRECT_URI']);

$client->addScope("email");
$client->addScope("profile");

?>