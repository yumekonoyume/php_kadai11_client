<?php
include("funcs.php"); // DB接続関数の読み込み

$pdo = db_conn(); // DB接続

// SQLの準備と実行
$stmt = $pdo->prepare("SELECT * FROM clients");
$status = $stmt->execute();

// データの表示処理
if ($status == false) {
    sql_error($stmt); // SQLエラー時の処理
} else {
    $results = $stmt->fetchAll(); // 全てのデータを取得
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>クライアント一覧</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>DotsLabメンバー一覧</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>会社名・屋号・個人</th>
                    <th>会社ふりがな</th> 
                    <th>担当者氏名</th>
                    <th>担当者ふりがな</th>
                    <th>電話番号</th>
                    <th>メールアドレス</th>
                    <th>登録日時</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['company_name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['company_furigana'], ENT_QUOTES, 'UTF-8') ?></td> <!-- ふりがなを表示 -->
                        <td><?= htmlspecialchars($row['representative_name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['representative_kana'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['phone_number'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
