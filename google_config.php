<?php
// Load the library (this one line loads everything in the vendor folder)
require_once 'vendor/autoload.php';

// Start Session
if(!session_id()) session_start();

// Initialize the Google Client
$client = new Google\Client();

// Set your keys (Get these from Google Cloud Console)
$client->setClientId('1081172443366-j4imt04e901kfihrsnv643dqgnitaqqa.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/Website/google_callback.php');

// What info do we want?
$client->addScope("email");
$client->addScope("profile");

?>