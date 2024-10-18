<?php
session_start();

// ログインチェック
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // 未ログインの場合、ログイン画面へリダイレクト
    exit();
}

$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kiwi+Maru&display=swap"> <!-- Google Fonts -->
    <link rel="stylesheet" href="css/top.css"> <!-- カスタムCSS -->
</head>
<body>
    <div class="container">
        <img src="img/5.png" alt="DotsLab Logo" class="logo">
        <h1>ようこそ<br?= htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8') ?>さん！</h1>
        <h4>メンバー専用ページです<brおかえりなさい😊</h4>
        <a href="top.php" class="btn btn-custom-logout">ログアウト</a>
    </div>
</body>
</html>
