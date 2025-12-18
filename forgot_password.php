<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - The Liverpool Offside</title>
    <link href="./css/output.css?v=<?php echo time(); ?>" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">

    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden flex flex-row h-[500px]">
        
        <div class="hidden md:flex w-1/2 bg-red-700 flex-col items-center justify-center relative p-12 text-center text-white">
            <div class="absolute inset-0 bg-red-800 opacity-20"></div>
            
            <div class="relative z-10">
                <img src="images/vecteezy_liverpool-club-symbol-white-logo-premier-league-football_26135426-removebg-preview.png" 
                        alt="Logo" class="w-28 mx-auto mb-6 drop-shadow-lg">
                <h2 class="text-3xl font-extrabold tracking-widest uppercase mb-2">Account Recovery</h2>
                <p class="text-red-100 opacity-90 text-sm">
                    Don't worry, we'll get you back on the pitch in no time.
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex flex-col justify-center px-8 py-12 relative">

            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-900">Forgot Password?</h3>
                <p class="text-gray-500 text-sm mt-2">
                    Enter your email address and we will send you a secure link to reset your password.
                </p>
            </div>

            <form action="send_reset_code.php" method="POST" class="space-y-6">
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" required
                            class="w-full px-4 py-3 rounded-sm border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-red-600 focus:border-transparent outline-none transition"
                            placeholder="you@example.com">
                </div>

                <button type="submit" 
                        class="w-full bg-red-700 hover:bg-red-800 text-white font-bold py-3 rounded-sm shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 duration-200 uppercase tracking-wide text-sm">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-2 text-center">
                <a href="login.php" class="text-sm font-medium text-gray-600 hover:text-red-700 transition flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Login
                </a>
            </div>

        </div>
    </div>

</body>
</html>