<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $password = $_POST['password'];

    // データベース接続情報
    $host = 'localhost';
    $db = 'task_management';  // データベース名を指定
    $user = 'root';  // デフォルトのMAMPユーザー
    $pass = 'root';  // デフォルトのMAMPパスワード

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // ユーザーの認証
        $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :userId AND password = :password');
        $stmt->execute(['userId' => $userId, 'password' => $password]);
        $user = $stmt->fetch();

        if ($user) {
            // ログイン成功
            echo 'Login successful';
        } else {
            // ログイン失敗
            echo 'User ID or password is incorrect';
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
