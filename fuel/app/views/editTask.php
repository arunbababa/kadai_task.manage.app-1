<form action="/taskapp/updateTask/<?php echo urlencode($task['taskname']); ?>" method="POST">
    <label for="taskname">タスク名:</label>
    <input type="text" name="taskname" id="taskname" value="<?php echo htmlspecialchars($task['taskname'], ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="category">カテゴリー:</label>
    <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($task['category'], ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="importance">重要度:</label>
    <select id="importance" name="importance">
        <option value="low" <?php echo ($task['importance'] == 'low') ? 'selected' : ''; ?>>低</option>
        <option value="medium" <?php echo ($task['importance'] == 'medium') ? 'selected' : ''; ?>>中</option>
        <option value="high" <?php echo ($task['importance'] == 'high') ? 'selected' : ''; ?>>高</option>
    </select>

    <input type="submit" value="更新">
</form>
