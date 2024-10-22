<?php

class Model_User extends \Model
{

    public static function register_user($username, $password, $email)
    {
        // FuelPHPの認証システムを使用してユーザーを作成 ←このcreate_userメソッドでどのDB、テーブルに挿入するかの設定でどこだ？
        Auth::create_user($username, $password, $email, 1);
        return TRUE;
    }

    public static function login_user($username, $password)
    {
        return Auth::login($username, $password);
    }

}