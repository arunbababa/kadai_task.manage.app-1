<!-- form_success.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録成功</title>
    <link rel="stylesheet" href="/assets/css/style_forseccess.css"> <!-- CSSファイルへのリンク -->
</head>
<body>
    <div class="container">
        <h1>登録できました！</h1>
        <p>早速今日のタスクを追加しましょう。</p>
        <form action="/taskapp/addtask" method="post"> <!-- コントローラとアクションを指定 -->
            <button type="submit" class="btn">タスクを追加する</button>
        </form>
    </div>

    <!-- トースター通知部分 -->
    <div id="toast" class="toast">
        登録が完了しました！ ユーザー名: <?= \Session::get('username'); ?>
    </div>

    <script>
        // トースターを表示する関数
        function showToast() {
            var toast = document.getElementById("toast");
            toast.className = "toast show";
            setTimeout(function() {
                toast.className = toast.className.replace("show", "");
            }, 3000); // 3秒後にトースターを非表示に
        }

        // ページロード時にトースターを表示
        window.onload = showToast;
    </script>

</body>
</html>
