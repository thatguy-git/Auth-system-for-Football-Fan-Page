<?php
include'database.php';    
include'google_config.php'; 

if (isset($_GET['code'])) {

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if(!isset($token['error'])){

        $client->setAccessToken($token['access_token']);

        // Getting User Data
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        // Extracting Data
        $g_id = $google_account_info->id;
        $g_email = $google_account_info->email;
        $g_name = $google_account_info->name;

        $stmt = $conn->prepare("SELECT id FROM users WHERE google_id = ?");
        $stmt->bind_param("s", $g_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            // Login
            $_SESSION['user_id'] = $user['id'];
        } else {
            // Signup
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, google_id) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $g_name, $g_email, $g_id);
            $stmt->execute();
            $_SESSION['user_id'] = $conn->insert_id;
        }

        
        header("Location: dashboard.php");
        exit();
    }
}
?>