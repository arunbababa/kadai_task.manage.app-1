<?php

// あれ、userregesiterDBへの接続はどこでしているんだろう
class Controller_User1 extends Controller
{
    public function action_form(){
        DB::insert('friends')->set(array(
            'name1' => Input::post('name1'),
            'name2' => Input::post('name2'),
            'age' => Input::post('age'),
            'tel' => Input::post('tel'),
            'email' => Input::post('email'),
        ))->execute();
        // echo Input::post('name1');
        return View::forge('form');
    }

    public function action_users(){
        DB::insert('users')->set(array(
            'username' => Input::post('username'),
            'password' => Input::post('password'),
            'email' => Input::post('email'),
        ))->execute();
        // 確認
        //  echo Input::post('username');
        //  echo Input::post('password');
        //  echo Input::post('email');

        return View::forge('users');
    }

    // public function action_insert()
    // {
    //     DB::insert('userregister')->set(array(
    //         'name1' => '山田',
    //         'name2' => '太郎',
    //         'tel' => '09012345678',
    //         'email' => 'tarou@yahoo.co.jp',
    //     ))->execute();
        
    // }

    public function action_registerview()
    {
        return View::forge('register'); 

    } 

    public function action_checkandgototask() 
    // 思ったビューとauthクラス切り離した方がよくね？
	{
        // ユーザ登録 ↓いる？
        // return View::forge('register');
        // $username = Input::post('username');
        // $password = Input::post('password');
        // $email = Input::post('email');
        Auth::create_user(Input::post('username'),Input::post('username'),Input::post('email'),1);
        return View::forge('form_success');

        // if (empty($username) || empty($password) || empty($email)) {
        //     return 'Username, password, or email is empty.';
        // }else {
        //         Auth::create_user($username, $password, $email, 1);
        //         return View::forge('form');
        //     }
        // // 

            // done! but if i put information of already user go error
            // 

        // このクリエイトユーザーにフォームから受け取ったものを配列として渡す感じのコード書けばよさそう

        // ログイン（viewはまだ作っていないため、一旦echoでログインの可否を判断しています
    }

    public function action_addtask()
    {
        return View::forge('addtask');
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

        Auth::delete_user('yamada');
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