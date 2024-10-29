<?php


class Controller_Taskapp extends Controller
{

    // beforeメソッドで、各アクション前に認証チェックを追加
    public function before()
    {
        parent::before();

        // 認証不要のアクションを設定
        $unrestricted_actions = ['userRegister','login','manageTasks']; //manageTasksは仮置き（js練習中）

        // 現在のアクションを取得
        $current_action = \Request::active()->action;

        // 認証不要アクションでなければ認証チェックを実施
        if (!in_array($current_action, $unrestricted_actions)) {
            // 認証が成功しない場合はログインページにリダイレクト
            if (!\Auth::check()) {
                \Response::redirect('taskApp/login');
            }
        }
        
    }

    public function action_login()
    {
        // POSTリクエストの時はユーザ認証を試みる
        if (Input::method() == 'POST')
        {
            $loginData = Input::post();
            $username = $loginData['username'];
            $password = $loginData['password'];

            // ユーザー認証を試みる
            if (Auth::login($username, $password)) 
            {
                // 認証成功時はタスク管理画面にリダイレクト
                Session::set_flash('success','ログインしました！');
                Response::redirect('taskApp/manageTasks');
            } else 
                {
                    // 認証失敗時にエラーメッセージをフラッシュセッションに保存
                    Session::set_flash('error', 'ユーザー名またはパスワードが間違っています。');
                }
        }

        // GETリクエストor認証失敗の時はログインビューを表示
        return Response::forge(View::forge('login'));
    }

    public function action_userRegister()
    {
        // POSTリクエストかどうかを確認
        if (Input::method() == 'POST') 
        {
            // POSTされたデータを取得
            $username = Input::post('username');
            $email = Input::post('email');
            $password = Input::post('password');

            // 新規ユーザーの登録処理
            try 
            {
                if (Model_User::register_user($username, $password, $email)) 
                {
                    // 登録成功時はログイン画面にリダイレクト
                    Session::set_flash('success', 'ユーザー登録が完了しました。');
                    Response::redirect('taskApp/manageTasks');
                }
            } catch (Exception $e) 
            {
                // 登録に失敗した場合はエラーメッセージを表示
                Session::set_flash('error', 'ユーザー登録に失敗しました: ' . $e->getMessage());
            }
        }

        // GETリクエストの場合、または登録に失敗した場合は登録フォームを表示
        return Response::forge(View::forge('userRegister')); 
    }

    public function action_manageTasks()
    {
        // タスクリストを取得
        $tasks = Model_Task::taskList();

        // 重要度の選択肢を取得
        Config::load('importance', true);
        $importanceOptions = Config::get('importance.options');
        
        // タスクの内容ををビューに渡す
        return View::forge('manageTasks', [
            'tasks' => $tasks,
            'importanceOptions' => $importanceOptions
        ]);
    }

    public function action_createTask()
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

    public function action_deleteTask() # あれ引数入れるとどうなるんだっけ？→次のようにルーティングされてしまう！/taskapp/delete/{パラメータ}
    {
        // POSTリクエストでタスク名とカテゴリを取得
        $post = json_decode(file_get_contents('php://input'), true);
        Model_Task::deleteTask($post['taskname'], $post['category']);
    }

    public function action_updateTask()
    {
        // POSTデータを取得
        $post = json_decode(file_get_contents('php://input'), true);
        Model_Task::updateTask($post['taskname'], $post['category'],$post['importance'] ,$post['pre_taskname']);
    }
}