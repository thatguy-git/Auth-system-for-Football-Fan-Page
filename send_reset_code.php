<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST['email'];

    //Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        //Random token 
        $token = bin2hex(random_bytes(32));
        
        $expires_at = date("Y-m-d H:i:s", strtotime('+30 minutes'));

        $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
        $del->bind_param("s", $email);
        $del->execute();

        // Insert new token
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expires_at);
        $stmt->execute();

        //Send Email
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['EMAIL_USER'];
            $mail->Password   = $_ENV['EMAIL_PASS'];   
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            
            $mail->setFrom('no-reply@liverpooloffside.com', 'The Liverpool Offside');
            $mail->addAddress($email);

            // Content
            $url = "http://localhost/Website/reset_password_form.php?token=$token";
            
            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Password';
            $mail->Body    = "
                <h3>Password Reset Request</h3>
                <p>Click the link below to reset your password:</p>
                <p><a href='$url'>$url</a></p>
                <p>This link expires in 30 minutes.</p>
            ";

            $mail->send();
            echo "Message has been sent. Check your email.";
            
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        echo "If this email exists, a reset link has been sent.";
    }
}
?>