<?php


class Controller_Taskapp extends Controller
{

    // beforeメソッドで各アクション前に実行する処理を設定します
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

    // 新しいユーザを登録するメソッド
    public function action_user_register()
    {
        return View::forge('user_register'); 
        #すでに登録されている処理がまだない
    }

    // ログインするメソッド
    public function action_login()
    {
        // POSTリクエストが送られた場合に処理を行う
        if (Input::method() === 'POST') {
            // フォームから送信されたデータを取得
            $loginuser = Input::post();
            $username = $loginuser['username'];
            $password = $loginuser['password'];

            // ユーザー認証処理
            // 入力されたユーザー名とパスワードを使用して認証を試みる
            if (Auth::login($username, $password)) {
                // 認証成功時の処理
                // タスク管理画面にリダイレクトする
                Session::set_flash('success', 'ログインしました！');
                Response::redirect('taskapp/manage_tasks');
                return; // 処理の終了を明示的にする
            } else {
                // 認証失敗時の処理
                // セッションにエラーメッセージを保存
                Session::set_flash('error', 'ユーザー名またはパスワードが間違っています。');
            }
        }

        // GETリクエストの場合、または認証失敗時はログインビューを表示する
        return Response::forge(View::forge('login'));
    }


    public function action_manage_tasks()
    {
        // タスクリストを取得
        $tasks = Model_Task::task_list();
        
        // 設定ファイルから重要度の選択肢を読み込む
        $importance_options = \Config::load('importance', true);
        
        // タスクデータをビューに渡す
        return View::forge('manage_tasks', [
            'tasks' => $tasks,
            'importance_options' => $importance_options
        ]);
    }

    // タスクを追加するメソッド
    public function action_create_task()
    {
        try {
            // POSTデータを取得
            $post = json_decode(file_get_contents('php://input'), true);
    
            // 必要なデータが存在するか確認
            if (!empty($post['taskname']) && !empty($post['category']) && !empty($post['importance'])) {
                // タスクを追加するためにModel_Taskを呼び出し
                Model_Task::add_task($post['taskname'], $post['category'], $post['importance']);
    
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

    // タスクを削除するメソッド
    public function action_delete_task() # あれ引数入れるとどうなるんだっけ？→次のようにルーティングされてしまう！/taskapp/delete/{パラメータ}
    {
        // POSTリクエストでタスク名とカテゴリを取得
        $post = json_decode(file_get_contents('php://input'), true);
        Model_Task::delete_task($post['taskname'], $post['category']);
    }

    // タスクを更新するメソッド
    public function action_update_task()
    {
        // POSTデータを取得
        $post = json_decode(file_get_contents('php://input'), true);
        Model_Task::update_task($post['taskname'], $post['category'],$post['importance']);
    }



}