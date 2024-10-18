<?php
include("funcs.php"); // DB接続関数の読み込み

session_start(); // セッション開始

// POSTデータの取得とサニタイズ
$form_data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
$email = $form_data['email'];
$password = $form_data['password'];

// フォームデータをセッションに保存
$_SESSION['form_data'] = $form_data;

try {
    $pdo = db_conn();

    // メールアドレスの重複チェック
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM clients WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // エラーメッセージをセッションに保存
        $_SESSION['error'] = 'このメールアドレスはすでに登録されています。修正してください。';
        header('Location: index.php'); // 入力画面にリダイレクト
        exit();
    } else {
        // メールアドレスが重複していない場合、処理を続行

        
        // データ挿入処理
        $stmt = $pdo->prepare(
            "INSERT INTO clients (
                company_name, company_furigana, representative_name, representative_kana, phone_number, 
                email, password_hash, postal_code, prefecture, city, address, 
                building_name, bank_name, branch_name, account_type, account_number, 
                privacy_policy_agreed, created_at
            ) VALUES (
                :company_name, :company_furigana, :representative_name, :representative_kana, :phone_number, 
                :email, :password_hash, :postal_code, :prefecture, :city, :address, 
                :building_name, :bank_name, :branch_name, :account_type, :account_number, 
                :privacy_policy_agreed, sysdate()
            )"
        );

        // バインド変数の設定
        $stmt->bindValue(':company_name', $form_data['company_name'], PDO::PARAM_STR);
        $stmt->bindValue(':company_furigana', $form_data['company_furigana'], PDO::PARAM_STR);
        $stmt->bindValue(':representative_name', $form_data['representative_name'], PDO::PARAM_STR);
        $stmt->bindValue(':representative_kana', $form_data['representative_kana'], PDO::PARAM_STR);
        $stmt->bindValue(':phone_number', $form_data['phone_number'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindValue(':postal_code', $form_data['postal_code'], PDO::PARAM_STR);
        $stmt->bindValue(':prefecture', $form_data['prefecture'], PDO::PARAM_STR);
        $stmt->bindValue(':city', $form_data['city'], PDO::PARAM_STR);
        $stmt->bindValue(':address', $form_data['address'], PDO::PARAM_STR);
        $stmt->bindValue(':building_name', $form_data['building_name'], PDO::PARAM_STR);
        $stmt->bindValue(':bank_name', $form_data['bank_name'], PDO::PARAM_STR);
        $stmt->bindValue(':branch_name', $form_data['branch_name'], PDO::PARAM_STR);
        $stmt->bindValue(':account_type', $form_data['account_type'], PDO::PARAM_STR);
        $stmt->bindValue(':account_number', $form_data['account_number'], PDO::PARAM_STR);
        $stmt->bindValue(':privacy_policy_agreed', $form_data['privacy_policy_agreed'], PDO::PARAM_INT);

        // SQL実行
        $stmt->execute();

        // 登録後、自動ログイン処理
        $login_stmt = $pdo->prepare("SELECT * FROM clients WHERE email = :email");
        $login_stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $login_stmt->execute();
        $user = $login_stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // ログイン成功
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['representative_name'];
            header('Location: welcome.php'); // ウェルカム画面にリダイレクト
            exit();
        } else {
            // ログイン失敗（念のためエラーハンドリング）
            exit('自動ログインに失敗しました。');
        }
    }
} catch (PDOException $e) {
    exit("SQLエラー: " . $e->getMessage());
}
