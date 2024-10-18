<?php
session_start();
include("funcs.php");

$email = $_POST['email'];
$password = $_POST['password'];

$pdo = db_conn();
$stmt = $pdo->prepare("SELECT * FROM clients WHERE email = :email");
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['representative_name'];
    redirect("welcome.php");
} else {
    redirect("login.php?error=1");
}
