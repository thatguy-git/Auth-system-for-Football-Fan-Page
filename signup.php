<?php
session_start();
include 'database.php';
require_once 'vendor/autoload.php';
include 'google_config.php';
include 'utils/session_manager.php';
SessionManager::start();

if (SessionManager::isLoggedIn()) {
    // header("Location: dashboard.php");
    exit();
}

$password = "";

$fullname = "";
$email = "";
$terms = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $terms = isset($_POST['terms']); 

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    if (empty($fullname) || empty($password)) {
        $errors['general'] = "All fields are required.";
    }

    if (!$terms) {
        $errors['terms'] = "You must agree to the terms.";
    }

    if (empty($errors)) {

        try {
            $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $checkEmail->bind_param("s", $email);
            $checkEmail->execute();
            $checkEmail->store_result();

            if ($checkEmail->num_rows > 0) {
                $errors['email'] = "This email is already registered.";
            } else {
                $checkEmail->close();
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $fullname, $email, $hashed_password);

                if ($stmt->execute()) {
                    header("Location: login.php?signup=success");
                    exit();
                } else {
                    throw new Exception("Execute failed");
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, __DIR__ . '/my_errors.txt');
            $errors['general'] = "System Error: Could not create account.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join the Squad - The Liverpool Offside</title>
    <link href="./css/output.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">

    <div class="bg-white w-full max-w-5xl rounded-sm shadow-2xl overflow-hidden flex flex-row">
        
        <div class="hidden md:flex w-5/12 bg-red-700 flex-col items-center justify-center relative p-12 text-center text-white">
            <div class="absolute inset-0 bg-red-800 opacity-20"></div>
            
            <div class="relative z-10">
                <img src="images/vecteezy_liverpool-club-symbol-white-logo-premier-league-football_26135426-removebg-preview.png" 
                        alt="Logo" class="w-72 mx-auto mb-8 drop-shadow-lg">
                <h2 class="text-4xl font-extrabold tracking-widest uppercase mb-4">Join The Squad</h2>
                <p class="text-red-100 text-lg opacity-90 leading-relaxed">
                    Get exclusive match analysis, comment on articles, and connect with fans worldwide.
                </p>
                <div class="mt-8 w-16 h-1 bg-white opacity-50 mx-auto rounded-none"></div>
            </div>
        </div>

        <div class="w-full md:w-7/12 flex flex-col justify-center px-8 md:px-16 py-10">
            <div class="mb-6">
                <h3 class="text-3xl font-bold text-gray-900">Create Account</h3>
                <p class="text-gray-500 text-sm mt-1">It's free and takes less than a minute.</p>
            </div>
            <form action="" method="POST" class="space-y-5">
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
                    <label class="block text-sm font-bold text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="fullname" 
                            value="<?php echo htmlspecialchars($fullname ?? ''); ?>"
                            class="w-full px-4 py-3 rounded-sm border border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition bg-gray-50"
                            placeholder="Your name" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" 
                            value="<?php echo htmlspecialchars($email); ?>"
                            class="w-full px-4 py-3 rounded-sm border border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition bg-gray-50"
                            placeholder="you@example.com" required>
                            <?php if (isset($errors['email'])): ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo $errors['email']; ?></p>
                            <?php endif; ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" 
                                class="w-full px-4 py-3 rounded-sm border border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition bg-gray-50"
                                placeholder="Min 8 characters" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" name="confirm_password" 
                                class="w-full px-4 py-3 rounded-sm border border-gray-300 focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition bg-gray-50"
                                placeholder="Repeat password" required>
                                <?php if (isset($errors['confirm_password'])): ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo $errors['confirm_password']; ?></p>
                                <?php endif; ?>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox"
                                <?php echo $terms ? 'checked' : ''; ?>
                                class="hover:cursor-pointer w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-red-300 text-red-700">
                                
                    </div>
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        I agree to the <a href="#" class="text-red-700 hover:underline">Terms of Service</a> and <a href="#" class="text-red-700 hover:underline">Privacy Policy</a>.
                    </label>
                </div>
                <?php if (isset($errors['terms'])): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo $errors['terms']; ?></p>
                <?php endif; ?>

                <button type="submit" 
                        class="w-full bg-red-700 hover:bg-red-800 text-white font-bold py-3 rounded-sm shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 duration-200 uppercase tracking-wide">
                    Create Account
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Already have an account? 
                <a href="login.php" class="font-bold text-red-700 hover:underline">Log in here</a>
            </p>
        </div>
        
    </div>

</body>
</html>

