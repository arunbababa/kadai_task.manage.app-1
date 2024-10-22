<!-- addtasks.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク追加</title>
    <link rel="stylesheet" href="/assets/css/styleforaddtask.css">
    <!-- Knockout.jsを読み込む -->
    <script type="text/javascript" src="/assets/js/knockout-3.5.1.js"></script>
</head>
<body>
    <script type="text/javascript" src="knockout-3.0.0.js"></script>
    <div class="container">
        <h1>タスクを追加しましょう！</h1>
        <form action="/taskapp/created_task" method="post">
            <div class="form-group">
                <label for="taskname">タスク名:</label>
                <input type="text" id="taskname" name="taskname" required>
            </div>
            <div class="form-group">
                <label for="category">カテゴリー:</label>
                <input type="text" id="category" name="category" required>
            </div>
            <div class="form-group">
                <label for="importance">重要度:</label>
                <select id="importance" name="importance">
                    <!-- ◆以下valueの中身を日本語にする、もしくはlabel属性にする(?) -->
                    <?php
                    \Config::load('importance', true);
                    $options = \Config::get('importance');
                    var_dump($options); // デバッグ用出力←現状ここでnullが返されています。
                    foreach ($options as $value => $label): ?>
                        <option value="<?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn">タスクを追加する</button>
        </form>
    </div>
</body>
</html>
