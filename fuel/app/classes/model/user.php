<?php

// ユーザ登録とログインの処理をするクラスです
class Model_User extends \Model
{

    public static function register_user($username, $password, $email)
    {
        // ユーザを作成
        Auth::create_user($username, $password, $email, 1);
        return TRUE;
    }

        //　login認証をする
    public static function login_user($username, $password)
    {
        Auth::login($username, $password);
    }

}