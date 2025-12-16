<?php
session_start();
include 'database.php';

$token = $_GET['token'] ?? '';
$error = "";
$success = "";

if (empty($token)) {
    die("Invalid request. No token provided.");
}
$stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid or expired link. Please request a new password reset.");
}

$reset_request = $result->fetch_assoc();
$email = $reset_request['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (strlen($new_password) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // HASH NEW PASSWORD
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // UPDATE USER'S PASSWORD
        $update = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
        $update->bind_param("ss", $hashed_password, $email);
        
        if ($update->execute()) {
            
            // Delete the used token 
            $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $del->bind_param("s", $email);
            $del->execute();
            
            header("Location: login.php?reset=success");
            exit();
        } else {
            $error = "System error. Could not update password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set New Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Set New Password</h2>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-5">
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-600 outline-none"
                        placeholder="Min 8 characters">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="confirm_password" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-600 outline-none"
                        placeholder="Re-type password">
            </div>

            <button type="submit" 
                    class="w-full bg-red-700 text-white font-bold py-3 rounded-lg hover:bg-red-800 transition shadow-lg">
                Update Password
            </button>

        </form>
    </div>

</body>
</html>