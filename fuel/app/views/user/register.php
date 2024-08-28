<h2>ユーザー登録</h2>

<?php if (Session::get_flash('error')): ?>
    <p><?php echo Session::get_flash('error'); ?></p>
<?php endif; ?>

<form action="register" method="post">
    <div>
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username">
    </div>
    <div>
        <label for="email">メールアドレス:</label>
        <input type="email" id="email" name="email">
    </div>
    <div>
        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password">
    </div>
    <div>
        <input type="submit" value="登録">
    </div>
</form>
