<?php


class Controller_Taskapp extends Controller
{

    // before() メソッドで認証チェックを追加
    public function before()
    {
        parent::before();

        if(Auth::check()){
            echo 'ログインしています。';
        }else{
            echo 'ログインしていません';
        }
        // 認証が不要なアクションを指定
        $unrestricted_actions = ['userregister'];

        #現在のアクションが認証不要でない場合、認証チェックを行う
        // if (!in_array(Request::active()->action, $unrestricted_actions)) {
        //     if (!Auth::check()) {
        //         // ログインしていない場合、ログインページにリダイレクト
        //         Response::redirect('/taskapp/rogin');
        //     }
        // }
    }

    public function action_userregister()
    {
        return View::forge('user_register'); 
    }

    public function action_checkandgototask() 
	{
        #viewのnew_registerからformの情報を受け取る
        $post = Input::post();
        // \Log::error(print_r($post, true));

        // #ユーザーをdb登録するモデルを呼び出し、$postに代入したフォーム情報を渡す
        // Model_User::create($post);

        #セッションの作成と$postのユーザー名を渡す
        Session::set('username', $post['username']);

        Auth::create_user($post['username'],$post['password'],$post['email'],1);

        var_dump(Auth::login($post['username'],$post['password']));

        #db登録ができたら登録完了画面へ遷移ずる
        return View::forge('register_success');
    }

    public function action_checkandgototask2() 
	{
        #作成からログイン機能もろもろすべてをauthクラスで実験する

        #・ユーザー登録
        #Auth::create_user('aru','ppap','yama@gmail.com',1);
        #おけこれでuserregisterのusersテーブルへ登録されていること確認した！ナイス

        #・ログイン
        var_dump(Auth::login('aru','ppap'));

        #セッションの作成と$postのユーザー名を渡す
        // Session::set('username', $post['username']);

        // #db登録ができたら登録完了画面へ遷移ずる
        // return View::forge('register_success');
    }


    public function action_create_task()
    {
        return View::forge('create_task');
    }

    #これ長塚さんに習ったみたいにmvcの分離をしよう(9/18まで)
    public function action_addedtask()
    {
        DB::insert('tasks')->set(array(
            'taskname' => Input::post('taskname'),
            'category' => Input::post('category'),
            'importance' => Input::post('importance'),
        ))->execute();
        return View::forge('addedtasks');
    }

    public function action_tasklist()
    {
        // データベースからタスクを取得
        $tasks = DB::select()->from('tasks')->execute()->as_array();

        // ビューにタスクのデータを渡す
        return View::forge('tasklist', ['tasks' => $tasks]);
    }

    public function action_auth()
    {
        #以下実験→Auth::create_userを使ってdb登録までするためのコントローラ作成）
        #Auth::create_user('tanakaaa','passo','yamachan@gmail.com',1);
        Auth::login('');
    }
}