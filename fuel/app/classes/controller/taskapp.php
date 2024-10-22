<?php


class Controller_Taskapp extends Controller
{

    // beforeメソッドで、各アクション前に認証チェックを追加
    public function before()
    {
        parent::before();

        // 認証不要のアクションを設定
        $unrestricted_actions = ['user_register','login','login_check','manage_tasks']; //manageTasksは仮置き（js練習中）

        // 現在のアクションを取得
        $current_action = \Request::active()->action;

        // 認証不要アクションでなければ認証チェックを実施
        if (!in_array($current_action, $unrestricted_actions)) {
            // 認証が成功しない場合はログインページにリダイレクト
            if (!\Auth::check()) {
                \Response::redirect('login');
            }
        }
        
    }

    public function action_login()
    {
        // ログインビューを表示
        return Response::forge(View::forge('login'));
    }

    public function action_login_check()
    {
        $loginuser = Input::post();
        $username = $loginuser['username'];
        $password = $loginuser['password'];

        // 認証処理
        if (Auth::login($username, $password)) {
            // 認証成功時はレッツクリエイトタスク画面やタスクページにリダイレクト
            Response::redirect('taskapp/create_task');
        } else {
            // 認証失敗時はエラーメッセージを表示
            Session::set_flash('error', 'ユーザー名またはパスワードが間違っています。');
            echo "NO";
        }
        
    }


    public function action_user_register()
    {
        return View::forge('user_register'); 
    }


    public function action_LetsCreateTask() #
	{
        // 登録画面からPOSTされたデータを取得
        $postUser = Input::post();

        // 新規ユーザーの登録処理
        if (Model_User::register_user($postUser['username'], $postUser['password'], $postUser['email'])) {
            // 登録に成功したときのみセッションにユーザー名を保存
            Session::set('username', $postUser['username']);
            Response::redirect('/taskapp/login');

            // ログイン処理
            if (Model_User::login_user($postUser['username'], $postUser['password'])) {
                // 登録成功画面へ遷移
                return Response::forge(View::forge('letsCreateTask'));
            }
        } 
        
    }

    public function action_create_task()
    {
        return View::forge('create_task');
    }

    public function action_created_task()
    {
        // タスク追加画面からPOSTされたデータを取得
        $posted_task = Input::post();
        Model_Task::creat_task($posted_task['taskname'],$posted_task['category'],$posted_task['importance']);
        return View::forge('created_task',['postTask' => $posted_task]);
    }

    public function action_task_list()
    {
        // モデルからタスクリストを取得
        $tasks = Model_Task::taskList();
        // ビューにタスクのデータを渡す
        return View::forge('task_list', ['tasks' => $tasks]); # View::frogeは第二引数を配列で受け取る仕様のため、'tasks'というキーを付与し配列としている
    }

    public function action_editTask($taskname)
    {
    // URLからタスク名を取得し、データベースから該当タスクを取得
    $task = DB::select()->from('tasks')->where('taskname', $taskname)->execute()->current();

    // タスクが見つからない場合
    if (!$task) {
        Session::set_flash('error', 'タスクが見つかりませんでした');
        Response::redirect('taskapp/tasklist');
    }

    // ビューにタスクデータを渡して編集ページを表示
    return View::forge('editTask', ['task' => $task]);
    }

    public function action_updateTask($original_taskname)
    {
        // POSTデータを取得
        $new_taskname = Input::post('taskname');
        $category = Input::post('category');
        $importance = Input::post('importance');

        // データベースのタスクを更新
        DB::update('tasks')
            ->set([
                'taskname' => $new_taskname,
                'category' => $category,
                'importance' => $importance,
            ])
            ->where('taskname', $original_taskname)
            ->execute();

        // 更新後にタスクリストへリダイレクト
        Session::set_flash('success', 'タスクが更新されました');
        Response::redirect('taskapp/tasklist');
    }

    public function action_deleteTask($taskname)
    {
        // データベースからタスクを削除
        DB::delete('tasks')->where('taskname', $taskname)->execute();

        // 削除後にタスクリストへリダイレクト
        Session::set_flash('success', 'タスクが削除されました');
        Response::redirect('taskapp/tasklist');
    }

        public function action_auth()
    {
        #以下実験→Auth::create_userを使ってdb登録までするためのコントローラ作成）
        #Auth::create_user('tanakaaa','passo','yamachan@gmail.com',1);
        Auth::login('');
    }

    # -------以下knockout.js用のアクションたち

    public function action_manage_tasks()
    {
        // タスクリストを取得 FuelPHPの「ORM（Object Relational Mapper）」を利用したデータベース操作
        $tasks = Model_Task::taskList();
        // タスクデータの確認
        // print_r($tasks);
        // exit;  // デバッグ用に一時的に処理を停止
        
        // タスクデータをビューに渡す
        return View::forge('manageTasks', ['tasks' => $tasks]);
    }

    public function action_create()
    {
        try {
            // POSTデータを取得
            $post = json_decode(file_get_contents('php://input'), true);
    
            // 必要なデータが存在するか確認
            if (!empty($post['taskname']) && !empty($post['category']) && !empty($post['importance'])) {
                // タスクを追加するためにModel_Taskを呼び出し
                Model_Task::addTask($post['taskname'], $post['category'], $post['importance']);
    
                // 成功メッセージを返す
                return Response::forge(json_encode(['status' => 'success', 'message' => 'タスクが追加されました']), 200)
                                ->set_header('Content-Type', 'application/json');
            } else {
                // エラーメッセージを返す
                return Response::forge(json_encode(['status' => 'error', 'message' => 'タスクデータが不足しています']), 400)
                                ->set_header('Content-Type', 'application/json');
            }
        } catch (Exception $e) {
            // エラーメッセージをログに記録して、デバッグ出力する
            Log::error('タスク追加時にエラーが発生: ' . $e->getMessage());
            return Response::forge(json_encode(['status' => 'error', 'message' => 'サーバーでエラーが発生しました']), 500)
                            ->set_header('Content-Type', 'application/json');
        }
    }

    public function action_delete() # あれ引数入れるとどうなるんだっけ？→次のようにルーティングされてしまう！/taskapp/delete/{パラメータ}
    {
        // POSTリクエストでタスク名とカテゴリを取得
        $post = json_decode(file_get_contents('php://input'), true);
        Model_Task::deleteTask($post['taskname'], $post['category']);
    }

    public function action_update()
    {
        // POSTデータを取得
        $post = json_decode(file_get_contents('php://input'), true);
        Model_Task::updateTask($post['taskname'], $post['category'],$post['importance']);
    }



}