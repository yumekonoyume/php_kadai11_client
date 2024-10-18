<?php
session_start(); // セッション開始

// 確認画面の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    $_SESSION['form_data'] = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $form_data = $_SESSION['form_data'];
?>
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>確認画面</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div class="container mt-5">
            <h2>入力内容のご確認</h2>
            <ul class="list-group">
                <li class="list-group-item">会社名・屋号・個人: <?= $form_data['company_name'] ?></li>
                <li class="list-group-item">会社・屋号ふりがな: <?= $form_data['company_furigana'] ?></li>
                <li class="list-group-item">担当者氏名: <?= $form_data['representative_name'] ?></li>
                <li class="list-group-item">担当者ふりがな: <?= $form_data['representative_kana'] ?></li>
                <li class="list-group-item">電話番号: <?= $form_data['phone_number'] ?></li>
                <li class="list-group-item">メールアドレス: <?= $form_data['email'] ?></li>
                <li class="list-group-item">郵便番号: <?= $form_data['postal_code'] ?></li>
                <li class="list-group-item">都道府県: <?= $form_data['prefecture'] ?></li>
                <li class="list-group-item">市区町村: <?= $form_data['city'] ?></li>
                <li class="list-group-item">番地: <?= $form_data['address'] ?></li>
                <li class="list-group-item">番地: <?= $form_data['building_name'] ?></li>
                <li class="list-group-item">銀行名: <?= $form_data['bank_name'] ?></li>
                <li class="list-group-item">支店名: <?= $form_data['branch_name'] ?></li>
                <li class="list-group-item">口座種別: <?= $form_data['account_type'] ?></li>
                <li class="list-group-item">口座番号: <?= $form_data['account_number'] ?></li>
                <li class="list-group-item">個人情報取り扱い同意: <?= isset($form_data['privacy_policy_agreed']) ? 1 : 0; ?></li>
            </ul>
            <!-- 確認画面のフォーム -->
            <form method="POST" action="insert.php">
                <!-- すべてのデータをhiddenフィールドで送信 -->
                <?php foreach ($form_data as $key => $value): ?>
                    <input type="hidden" name="<?= $key ?>" value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>">
                <?php endforeach; ?>

                <button type="submit" formaction="index.php" name="modify" class="btn btn-warning">修正する</button>
                <button type="submit" formaction="insert.php" class="btn btn-success">登録する</button>
            </form>

        </div>
    </body>

    </html>
<?php
    exit(); // 処理をここで終了
}

// 修正画面の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modify'])) {
    $form_data = $_SESSION['form_data'];
} else {
    $form_data = []; // 初期データ
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>チームDotsLab登録フォーム</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="container mt-5">
        <h2>メンバー情報入力</h2>
        <form method="POST" action="index.php">
            <div class="form-group">
                <label for="company_name">会社名・屋号・個人</label>
                <input type="text" class="form-control" id="company_name" name="company_name"
                    placeholder="例：株式会社〇〇 / 個人の方は個人と入力してください"
                    value="<?= isset($form_data['company_name']) ? htmlspecialchars($form_data['company_name'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="company_furigana">ふりがな</label>
                <input type="text" class="form-control" id="company_furigana" name="company_furigana"
                    placeholder="例：まるまる / こじん" pattern="^[ぁ-んー\s]+$"
                    value="<?= isset($form_data['company_furigana']) ? htmlspecialchars($form_data['company_furigana'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="representative_name">担当者氏名</label>
                <input type="text" class="form-control" id="representative_name" name="representative_name"
                    placeholder="例：山田 太郎"
                    value="<?= isset($form_data['representative_name']) ? htmlspecialchars($form_data['representative_name'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="representative_kana">担当者ふりがな</label>
                <input type="text" class="form-control" id="representative_kana" name="representative_kana"
                    placeholder="例：やまだ たろう（ひらがな）" pattern="^[ぁ-んー\s]+$"
                    value="<?= isset($form_data['representative_kana']) ? htmlspecialchars($form_data['representative_kana'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="phone_number">電話番号</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number"
                    placeholder="例：09012345678（ハイフンなし、最大11桁）" pattern="\d{10,11}" maxlength="11"
                    value="<?= isset($form_data['phone_number']) ? htmlspecialchars($form_data['phone_number'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email"
                    placeholder="例：example@example.com"
                    value="<?= isset($form_data['email']) ? htmlspecialchars($form_data['email'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="8文字以上の英数字を含むパスワード" pattern="(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,}"
                    value="<?= isset($form_data['password']) ? htmlspecialchars($form_data['password'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code"
                    placeholder="例：123-4567" pattern="\d{3}-\d{4}"
                    value="<?= isset($form_data['postal_code']) ? htmlspecialchars($form_data['postal_code'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="prefecture">都道府県</label>
                <input type="text" class="form-control" id="prefecture" name="prefecture"
                    placeholder="例：東京都"
                    value="<?= isset($form_data['prefecture']) ? htmlspecialchars($form_data['prefecture'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="city">市区町村</label>
                <input type="text" class="form-control" id="city" name="city"
                    placeholder="例：新宿区"
                    value="<?= isset($form_data['city']) ? htmlspecialchars($form_data['city'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="address">番地</label>
                <input type="text" class="form-control" id="address" name="address"
                    placeholder="例：西新宿1-1-1"
                    value="<?= isset($form_data['address']) ? htmlspecialchars($form_data['address'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="building_name">マンション・ビル名</label>
                <input type="text" class="form-control" id="building_name" name="building_name"
                    placeholder="例：〇〇ビル 101号室"
                    value="<?= isset($form_data['building_name']) ? htmlspecialchars($form_data['building_name'], ENT_QUOTES, 'UTF-8') : '' ?>">
            </div>

            <div class="form-group">
                <label for="bank_name">銀行名</label>
                <input type="text" class="form-control" id="bank_name" name="bank_name"
                    placeholder="例：〇〇銀行"
                    value="<?= isset($form_data['bank_name']) ? htmlspecialchars($form_data['bank_name'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="branch_name">支店名</label>
                <input type="text" class="form-control" id="branch_name" name="branch_name"
                    placeholder="例：新宿支店"
                    value="<?= isset($form_data['branch_name']) ? htmlspecialchars($form_data['branch_name'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="account_type">口座種別</label>
                <select class="form-control" id="account_type" name="account_type" required>
                    <option value="普通" <?= (isset($form_data['account_type']) && $form_data['account_type'] === '普通') ? 'selected' : '' ?>>普通</option>
                    <option value="当座" <?= (isset($form_data['account_type']) && $form_data['account_type'] === '当座') ? 'selected' : '' ?>>当座</option>
                    <option value="貯蓄" <?= (isset($form_data['account_type']) && $form_data['account_type'] === '貯蓄') ? 'selected' : '' ?>>貯蓄</option>
                </select>
            </div>

            <div class="form-group">
                <label for="account_number">口座番号</label>
                <input type="text" class="form-control" id="account_number" name="account_number"
                    placeholder="例：1234567（数字のみ）" pattern="\d+"
                    value="<?= isset($form_data['account_number']) ? htmlspecialchars($form_data['account_number'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="privacy_policy" name="privacy_policy_agreed" value="1"
                    <?= isset($form_data['privacy_policy_agreed']) ? 'checked' : '' ?> required>
                <label class="form-check-label" for="privacy_policy">個人情報取り扱いに同意します</label>
            </div>

            <button type="submit" name="confirm" class="btn btn-primary">確認画面へ</button>
        </form>

    </div>
</body>

</html>