<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク管理</title>
    <script src="https://cdn.jsdelivr.net/npm/knockout@3.5.1/build/output/knockout-latest.js"></script>
</head>
<body>

    <h1>タスク管理</h1>

    <!-- タスク追加フォーム -->
    <h2>タスクを追加</h2>
    <form data-bind="submit: addTask"> <!-- Knockout.jsのバインディングを使って、フォームの送信（submit）時にaddTaskメソッドが呼ばれる -->
        <input type="text" placeholder="タスク名" data-bind="value: newTaskName" required /> <!-- テキストボックスの入力内容が、newTaskNameという変数にリアルタイムで反映される、入力したタスク名が、Knockout.jsによって自動的にnewTaskNameに保存される -->
        <input type="text" placeholder="カテゴリ" data-bind="value: newCategory" required /> <!-- requiredは入力必須の意味　-->
        <select data-bind="value: newImportance">
            <option value="低">低</option>
            <option value="中">中</option>
            <option value="高">高</option>
        </select>
        <button type="submit">追加</button> <!-- これを押すとaddTaskメソッドが呼ばれて、タスクが追加されます。 -->
    </form>

    <!-- タスクリストの表示 -->
    <h2>タスクリスト</h2>
    <ul data-bind="foreach: tasks"> <!-- Knockout.jsのforeachバインディングを使って、tasks配列に含まれる各タスクをリスト表示 -->
        <li>
            <span data-bind="text: taskname"></span> - 
            <span data-bind="text: category"></span> - 
            <span data-bind="text: importance"></span>
            <button data-bind="click: $parent.editTask">編集</button>
            <button data-bind="click: $parent.removeTask">削除</button>

            
        </li>
    </ul>

    <script>
        console.log(<?= json_encode($tasks); ?>);  // タスクリストを確認
    </script>

    <script>

    function Task(data) {
        this.taskname = ko.observable(data.taskname);
        this.category = ko.observable(data.category);
        this.importance = ko.observable(data.importance);
    }

    function TaskViewModel() {
    var self = this;
    // 初期タスクリストのデータをTaskオブジェクトに変換
    var mappedTasks = <?= json_encode($tasks); ?>.map(function(task) {
        return new Task(task);
    });
    
    self.tasks = ko.observableArray(mappedTasks); // 初期タスクリスト
    
    self.newTaskName = ko.observable('');
    self.newCategory = ko.observable('');
    self.newImportance = ko.observable('中');

    // タスクを追加するメソッド
    self.addTask = function() {
        var newTask = {
            taskname: self.newTaskName(),
            category: self.newCategory(),
            importance: self.newImportance()
        };

        // サーバーにタスクを送信
        fetch('/taskapp/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(newTask)
        }).then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log(data.message);  // 成功メッセージを表示
                self.tasks.push(new Task(newTask)); // フロントでリストに追加
            } else {
                console.log(data.message);  // エラーメッセージを表示
            }
        });

        // 入力フィールドをリセット
        self.newTaskName('');
        self.newCategory('');
        self.newImportance('中');
    };

    // タスクを削除するメソッド
    self.removeTask = function(task) {
        // サーバーに削除リクエストを送信
        fetch('/taskapp/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                taskname: task.taskname(),
                category: task.category()
            })
        })
        .then(response => response.text())  // テキストレスポンスを処理
        .then(data => {
            console.log(data);  // 成功メッセージを表示
            // 成功後にフロントエンドでリストから削除
            self.tasks.remove(task);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    };
}

        ko.applyBindings(new TaskViewModel());
    </script>

</body>
</html>
