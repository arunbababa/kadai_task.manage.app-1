<!-- tasklist.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスクリスト</title>
    <link rel="stylesheet" href="/assets/css/stylefortasklist.css"> <!-- 必要に応じてCSSをリンク -->
</head>
<body>
    <div class="container">
        <h1>タスクリスト</h1>
        <?php if (empty($tasks)): ?>
            <p>現在、タスクはありません。</p>
        <?php else: ?>
            <ul>
                <?php foreach ($tasks as $task): ?>
                    <li>
                        <strong>タスク名:</strong> <?php echo htmlspecialchars($task['taskname'], ENT_QUOTES, 'UTF-8'); ?><br>
                        <strong>カテゴリー:</strong> <?php echo htmlspecialchars($task['category'], ENT_QUOTES, 'UTF-8'); ?><br>
                        <strong>重要度:</strong> <?php echo htmlspecialchars($task['importance'], ENT_QUOTES, 'UTF-8'); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="/user1/addtask" class="btn">タスクを追加する</a>
    </div>
</body>
</html>
