<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DLメンバーログイン</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kiwi+Maru&display=swap"> <!-- Google Fonts -->
    <link rel="stylesheet" href="css/top.css"> <!-- カスタムCSS -->
</head>
<body>
    <div class="container">
        <img src="img/5.png" alt="DotsLab Logo" class="logo">
        <h2 class="mb-4">DLメンバーログイン</h2>
        <form method="POST" action="login_act.php" class="login-form">
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" class="form-control input-custom" id="email" name="email" 
                    placeholder="例：example@example.com" required>
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" class="form-control input-custom" id="password" name="password" 
                    placeholder="パスワードを入力してください" required>
            </div>
            <button type="submit" class="btn btn-primary btn-custom">ログイン</button>
        </form>
    </div>
</body>
</html>
