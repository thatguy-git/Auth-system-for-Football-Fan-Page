<?php
session_start();
include 'database.php';
include 'google_config.php';
include 'utils/session_manager.php';
SessionManager::start();

if (SessionManager::isLoggedIn()) {
    // header("Location: dashboard.php");
    exit();
}



$email = "";
$password = "";
$remember = false;
$errors = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    // Validate
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    // Attempt Login
    if (empty($errors)) {
        
        $stmt = $conn->prepare("SELECT id, full_name, password_hash FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password_hash'])) {
                
                // Login Success
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                
                header("Location: dashboard.php");
                exit();

            } else {
                $errors['login'] = "Invalid email or password.";
            }
        } else {
            $errors['login'] = "Invalid email or password.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - The Liverpool Offside</title>
    <link href="./css/output.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white w-full max-w-4xl h-[600px] rounded-sm shadow-2xl overflow-hidden flex flex-row">
        
        <div class="hidden md:flex w-1/2 bg-red-700 flex-col items-center justify-center relative p-12 text-center text-white">
            <div class="absolute inset-0 bg-red-800 opacity-20"></div> 
            
            <div class="relative z-10">
                <img src="images/vecteezy_liverpool-club-symbol-white-logo-premier-league-football_26135426-removebg-preview.png" 
                        alt="Logo" class="w-72 mx-auto mb-6 drop-shadow-lg">
                <h2 class="text-3xl font-extrabold tracking-widest uppercase mb-2">Welcome Back</h2>
                <p class="text-red-100 opacity-90">
                    Join the discussion, track the stats, and never walk alone.
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex flex-col justify-center px-12 py-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-2 hidden md:block">Sign In</h3>
            <p class="text-gray-500 text-sm mb-8">Enter your details to access your account.</p>

            
            <form action="" method="POST" class="space-y-6">
                <?php
                    $google_svg = '<svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                    </svg>';
                    $login_button = '<a href="'.$client->createAuthUrl().'" class="w-full flex items-center justify-center gap-4 bg-white border border-gray-300 text-gray-700 font-medium py-3 rounded-sm hover:bg-gray-50 transition shadow-sm">
                                        ' . $google_svg . '
                                        <span>Continue with Google</span>
                                    </a>';
                ?>
                <div class="google-btn">
                    <?php echo $login_button; ?>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" 
                            class="bg-gray-50 w-full px-4 py-3 rounded-sm border border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition"
                            placeholder="you@example.com" required>
                            <?php if (isset($errors['email'])): ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo $errors['email']; ?></p>
                            <?php endif; ?>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <a href="forgot_password.php" class="text-sm text-red-600 hover:underline">Forgot password?</a>
                    </div>
                    <input type="password" name="password" id="password" 
                            class="bg-gray-50 w-full px-4 py-3 rounded-sm border border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition"
                            placeholder="••••••••" required>
                            <?php if (isset($errors['password'])): ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo $errors['password']; ?></p>
                            <?php endif; ?>
                </div>
                <?php if (isset($errors['login'])): ?>
                <div class="bg-red-100 text-red-700 px-4 py-1 rounded relative mb-4 text-sm">
                    <?php echo $errors['login']; ?>
                </div>
                <?php endif; ?>

                <button type="submit" 
                        class="w-full bg-red-700 hover:bg-red-700 text-white font-bold py-3 rounded-sm shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 duration-200">
                    Sign In
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Don't have an account? 
                <a href="signup.php" class="font-bold text-red-700 hover:underline">Sign up for free</a>
            </p>
        </div>
        
    </div>

</body>
</html>