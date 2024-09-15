<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録フォーム</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="form-container">
        <h1>登録する</h1>
        <form method="POST" action="/taskapp/checkandgototask">
            <div class="form-group">
                <label for="username">ユーザーネーム：</label>
                <input type="text" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="password">パスワード：</label> 
                <input type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="email">メールアドレス：</label>
                <input type="email" id="email" name="email">
            </div>
            <button type="submit">送信</button>
        </form>
    </div>
</body>
</html>
