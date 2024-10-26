<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク管理</title>
    <script src="https://cdn.jsdelivr.net/npm/knockout@3.5.1/build/output/knockout-latest.js"></script>
</head>
<body>

    <h1>タスク管理</h1>

    <?php if (Session::get_flash('success')): ?>
        <p id="flash-message" class="success-message"><?php echo Session::get_flash('success'); ?></p>
    <?php endif; ?>

    <!-- タスク追加フォーム -->
    <h2>タスクを追加</h2>
    <form data-bind="submit: add_task"> <!-- Knockout.jsのバインディングを使って、フォームの送信（submit）時にaddTaskメソッドが呼ばれる -->
        <input type="text" placeholder="タスク名" data-bind="value: newTaskName" required /> <!-- テキストボックスの入力内容が、newTaskNameという変数にリアルタイムで反映される、入力したタスク名が、Knockout.jsによって自動的にnewTaskNameに保存される -->
        <input type="text" placeholder="カテゴリ" data-bind="value: newCategory" required /> <!-- requiredは入力必須の意味　-->
        <select data-bind="value: newImportance">
            <option value="" disabled selected>重要度を選択してください</option>
            <?php foreach ($importance_options as $key => $label): ?>
                <option value="<?php echo $key; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">追加</button> <!-- これを押すとaddTaskメソッドが呼ばれて、タスクが追加されます。 -->
    </form>

    <!-- タスクリストの表示 -->
    <h2>タスクリスト</h2>
    <ul data-bind="foreach: tasks">
        <li>
            <!-- 編集モードの切り替え: 通常表示と編集フィールド -->
            <span data-bind="visible: !editing(), text: taskname"></span>
            <input type="text" data-bind="visible: editing, value: taskname" />

            <span data-bind="visible: !editing(), text: category"></span>
            <input type="text" data-bind="visible: editing, value: category" />

            <span data-bind="visible: !editing(), text: importance"></span>
            <select data-bind="visible: editing, value: importance">
                <?php foreach ($importance_options as $key => $label): ?>
                    <option value="<?php echo $key; ?>"><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>

            <!-- 編集と保存ボタン -->
            <button data-bind="click: edit_task, visible: !editing()">編集</button>
            <button data-bind="click: save_task, visible: editing">保存</button>
            <button data-bind="click: $parent.delete_task">削除</button>
        </li>
    </ul>

    <script>
        console.log(<?= json_encode($tasks); ?>);  // デバッグ用にタスクリストを確認

        // DOMが更新されたらflashを消す関数を実行する
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                // 5秒後にフラッシュメッセージを非表示にする
                setTimeout(() => {
                    flashMessage.style.display = 'none';
                }, 5000); // 5000ミリ秒（5秒）
            }
        });
    </script>

    <script>

    function Task(data) {
        this.taskname = ko.observable(data.taskname);
        this.category = ko.observable(data.category);
        this.importance = ko.observable(data.importance);
        this.editing = ko.observable(false);  // 編集モードのフラグ
    }

    function TaskViewModel() {
    var self = this;
    console.log("Knockout.jsバインドが初期化されました");
    
    // 初期タスクリストのデータをTaskオブジェクトに変換
    var mappedTasks = <?= json_encode($tasks); ?>.map(function(task) {
        return new Task(task);
    });
    
    self.tasks = ko.observableArray(mappedTasks); // 初期タスクリスト
    self.newTaskName = ko.observable('');
    self.newCategory = ko.observable('');
    self.newImportance = ko.observable('中');

    // タスクを追加するメソッド
    self.add_task = function() {

        console.log("add_taskメソッドが呼ばれました");

        var newTask = {
            taskname: self.newTaskName(),
            category: self.newCategory(),
            importance: self.newImportance()

            
        };

        console.log("新しいタスクをリストに追加します:", newTask);
        // フロントエンドでリストに追加
        // self.tasks.push(new Task(newTask));

        // サーバーにタスクを保存する処理を呼び出す（createコントローラ)
        fetch('/taskapp/create_task', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(newTask)
        }).then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log(data.message);  // 成功メッセージを表示
                self.tasks.push(new Task(newTask));
            } else {
                console.log(data.message);  // エラーメッセージを表示
            }
        });

        // 入力フィールドをリセット
        self.newTaskName('');
        self.newCategory('');
        self.newImportance('medium');

        console.log("現在のタスクリスト:", self.tasks());
    };

    // タスクを削除するメソッド
    self.delete_task = function(task) {
        // サーバーに削除リクエストを送信
        fetch('/taskapp/delete_task', {
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

    // タスクを編集するメソッド
    self.edit_task = function(task) {

        console.log("edit_taskメソッドが呼ばれました:", task);

        task.editing(true);  // 編集モードに切り替え
    };

    self.save_task = function(task) {
        task.editing(false);  // 編集モードを解除

        // サーバーに更新内容を送信
        var updatedTask = {
            taskname: task.taskname(),
            category: task.category(),
            importance: task.importance()
        };

        fetch('/taskapp/update_task', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedTask)
        }).then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log(data.message);  // 成功メッセージ
            } else {
                console.log(data.message);  // エラーメッセージ
            }
        });
    }

        ko.applyBindings(new TaskViewModel());
    </script>

</body>
</html>
