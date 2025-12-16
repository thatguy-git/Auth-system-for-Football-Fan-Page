<?php

?>

<div class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">Reset Password</h2>
        <p class="text-gray-600 text-sm mb-6 text-center">
            Enter your email and we'll send you a link to reset your password.
        </p>

        <form action="send_reset_code.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-600 outline-none">
            </div>
            <button type="submit" 
                    class="w-full bg-red-700 text-white font-bold py-3 rounded-lg hover:bg-red-800 transition">
                Send Reset Link
            </button>
        </form>
    </div>
</div>