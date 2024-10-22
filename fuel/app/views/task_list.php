<!-- tasklist.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスクリスト</title>
    <link rel="stylesheet" href="/assets/css/tasklist.css"> <!-- 必要に応じてCSSをリンク -->
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
                        <a href="/taskapp/edit_task/<?php echo urlencode($task['taskname']); ?>">編集</a>
                        <a href="/taskapp/delete_task/<?php echo urlencode($task['taskname']); ?>" onclick="return confirm('本当に削除しますか？')">削除</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="/taskapp/create_task" class="btn">タスクを追加する</a>
    </div>
</body>
</html>
