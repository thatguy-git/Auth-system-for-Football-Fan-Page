<?php
include'database.php';      // Your DB connection
include'google_config.php'; // Your Google Client setup

// 1. Check if Google sent a code back
if (isset($_GET['code'])) {

    // 2. The Library exchanges the code for a Token automatically
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    // Check for errors
    if(!isset($token['error'])){
        
        // Set the token so the client can act as the user
        $client->setAccessToken($token['access_token']);

        // 3. Get User Profile Data
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        // Extract Data
        $g_id = $google_account_info->id;
        $g_email = $google_account_info->email;
        $g_name = $google_account_info->name;

        // --- DATABASE LOGIC (Same as before) ---
        
        // Check if user exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE google_id = ?");
        $stmt->bind_param("s", $g_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            // LOGIN
            $_SESSION['user_id'] = $user['id'];
        } else {
            // SIGNUP
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, google_id) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $g_name, $g_email, $g_id);
            $stmt->execute();
            $_SESSION['user_id'] = $conn->insert_id;
        }

        // Redirect to Dashboard
        header("Location: dashboard.php");
        exit();
    }
}
?>