<?php

class Controller_User extends Controller
{
    public function action_index()
	{
		return Response::forge(View::forge('user/index'));
	}

    public function action_register()
    {
        // ユーザー登録ロジック
        if (Input::method() == 'POST') {
            $username = Input::post('username');
            $email = Input::post('email');
            $password = Input::post('password');
    
            // パスワードのハッシュ化
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
    
            // ユーザー作成
            $user = Model_User::forge(array(
                'username' => $username,
                'email' => $email,
                'password_hash' => $password_hash,
                'created_at' => time(),
                'updated_at' => time(),
            ));
    
            if ($user and $user->save()) {
                // ユーザー登録成功後の処理
                Response::redirect('user/login');
            } else {
                // エラーメッセージ
                Session::set_flash('error', 'ユーザー登録に失敗しました。');
            }
        }
    
        // 登録フォームの表示
        return Response::forge(View::forge('user/register'));
    }

    public function action_login()
    {
        // ログインロジック
    }

    public function action_logout()
    {
        // ログアウトロジック
    }
}
