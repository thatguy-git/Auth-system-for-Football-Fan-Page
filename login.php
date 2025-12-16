<?php
session_start();
include 'database.php';
include 'google_config.php';

// 1. Initialize variables
$email = "";
$password = "";
$remember = false; // For the "Remember Me" checkbox
$errors = [];

// 2. Process Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect Input
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']); // Check if "Remember Me" was ticked

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
                
                // Login Success!
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                
                // (Optional) Handle "Remember Me" cookie logic here later
                
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
            $login_button = '<a href="'.$client->createAuthUrl().'" class="bg-red-600 p-2 rounded-sm text-white font-medium">Login With Google</a>';
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