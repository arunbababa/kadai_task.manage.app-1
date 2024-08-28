<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users</title>
</head>
<body>
    <h1>Users List</h1>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo $user->username; ?> (<?php echo $user->email; ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
