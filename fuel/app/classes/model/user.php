<?php

class Model_User extends \Model
{

    public static function create($post)
    {
        DB::insert('users')->set(array(
            'username' => $post['username'],
            'password' => $post['password'],
            'email' => $post['email'],
        ))->execute();
        // echo Input::post('name1');
    }
//     protected static $_properties = array(
//         'id',
//         'username',
//         'email',
//         'password_hash',
//         'created_at',
//         'updated_at',
//     );

//     protected static $_table_name = 'users';

//     protected static $_created_at = 'created_at';
//     protected static $_updated_at = 'updated_at';
}