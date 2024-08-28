document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const userId = document.getElementById('userId').value;
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('errorMessage');

    // ここでユーザーIDとパスワードの検証を行う
    // デモ用に固定のユーザーIDとパスワードを使用
    const validUserId = 'user123';
    const validPassword = 'password123';

    if (userId !== validUserId || password !== validPassword) {
        errorMessage.textContent = 'User ID or password is incorrect';
        errorMessage.style.display = 'block';
    } else {
        errorMessage.style.display = 'none';
        // 正しい場合、フォームを送信するか、別の処理を行う
        // ここではデモ用にアラートを表示
        alert('Login successful');
        // フォームを送信する場合は以下の行をコメント解除
        // this.submit();
    }
});
