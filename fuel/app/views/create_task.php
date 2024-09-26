<!-- addtasks.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク追加</title>
    <link rel="stylesheet" href="/assets/css/styleforaddtask.css"> <!-- 必要に応じてCSSをリンク -->
</head>
<body>
    <div class="container">
        <h1>タスクを追加する</h1>
        <form action="/taskapp/addedtask" method="post"> <!-- addedtasksアクションを呼び出す -->
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
                    <option value="low">低</option> 
                    <option value="medium">中</option>
                    <option value="high">高</option>
                </select>
            </div>
            <button type="submit" class="btn">タスクを追加</button>
        </form>
    </div>
</body>
</html>
