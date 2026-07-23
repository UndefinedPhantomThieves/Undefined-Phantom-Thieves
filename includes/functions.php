<?php
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

function emailExists($conn, $email) {
    $sql = "SELECT user_id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
}

function usernameExists($conn, $username) {
    $sql = "SELECT user_id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
}

function sendVerificationEmail($to_email, $to_name, $token) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "yourgmail@gmail.com";
        $mail->Password = "your-app-password";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom("no-reply@phantomstore.com", "Phantom Store");
        $mail->addAddress($to_email, $to_name);

        $confirm_link = "http://localhost/Undefined-Phantom-Thieves/verify.php?token=" . urlencode($token);

        $mail->isHTML(true);
        $mail->Subject = "Confirm Your Registration";
        $mail->Body = "
            <div style='font-family: Arial, sans-serif;'>
                <p>Dear <strong>$to_name</strong>,</p>
                <p>Thank you for registering. Please click the button below to confirm your account:</p>
                <div style='margin: 15px 0;'>
                    <a href='$confirm_link' style='padding: 10px 20px; background: #198754; color: white; text-decoration: none; border-radius: 5px;'>Confirm Registration</a>
                </div>
                <p>If the button does not work, copy and paste this link into your browser:</p>
                <a href='$confirm_link'>$confirm_link</a>
                <p>— The Phantom Furniture Team</p>
            </div>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Verification link (email failed): <a href='$confirm_link'>$confirm_link</a>";
        return false;
    }
}

function logActivity($conn, $user_id, $activity) {
    $sql = "SELECT role FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row && in_array($row['role'], ['ADMIN','SELLER'])) {
        $sql = "INSERT INTO audit_logs (user_id, activity, created_at) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "is", $user_id, $activity);
        mysqli_stmt_execute($stmt);
    }
}
?>
