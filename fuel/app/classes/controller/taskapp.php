<?php

// あれ、userregesiterDBへの接続はどこでしているんだろう
class Controller_Taskapp extends Controller
{
    public function action_userregister()
    {
        return View::forge('new_registerview'); 

    } 

    public function action_checkandgototask() 
	{
       
        $post = Input::post();
        \Log::error(print_r($post, true));
        Model_User::create($post);
        return View::forge('register_success');
    }

    // action_checkandgototask() と同じ機能を持つ関数、記述形式が異なる
    // public function action_checkandgototask2()
    // {
        // DB::insert('friends')->set(array(
        //     'username' => Input::post('name1'),
        //     'password' => Input::post('name2'),
        //     'email' => Input::post('email'),
        // ))->execute();
        // echo Input::post('name1');
        // $post = Input::post();
        // Model_User::create($post);
        // return View::forge('form_success');
    // }


    public function action_addtask()
    {
        return View::forge('addtasks');
    }

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

    public function action_rogin()
    {
        // tanaka:Thatuki918      yamada arunba918 ←すでにある
        if(Auth::login('tanaka','newpassword',)){
            echo 'ログインに成功しました';
        }else{
            echo 'ログインに失敗しました';
        }
    }

    public function action_auth2()
    {
        // ログアウト
        // Auth::logout();

        // パスワード変更
        // Auth::change_password('Thatuki918','newpassword','tanaka');

        // パスワード変更を２回同じものでやるとした通らなくなるくもしくは上のパスワード変更だけでも通らないので気を付けよう
            // Auth::update_user(
            //     array(
            //         'email' => 'arunbababa@gmail.com'
            //     )
            // );

        // Auth::delete_user('yamada');
    }

    public function action_auth3()
    {
        // ログインチェック
        if(Auth::check()){
            echo 'ログインしています。';
        }else{
            echo 'ログインしていません。';
        }

        
        // メールアドレス変更
        // 退会（ユーザの削除）
    }
}