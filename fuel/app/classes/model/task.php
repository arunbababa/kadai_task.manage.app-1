<?php

class Model_Task extends \Model
{
    # knockout.jsないほう用のメソッド
    public static function creat_task($taskname, $category, $importance)
    {
        DB::insert('tasks')->set(array(
            'taskname' => $taskname,
            'category' => $category,
            'importance' => $importance,
        ))->execute();
    }

    public static function taskList() # これはどっちでも使ってるわ
    {
        return DB::select()->from('tasks')->execute()->as_array();
    }

    # knockout.js用のメソッド

    # タスク追加用モデル
    public static function addTask($taskname, $category, $importance)
    {
        DB::insert('tasks')->set(array(
            'taskname' => $taskname,
            'category' => $category,
            'importance' => $importance,
        ))->execute();
    }


    # タスク削除用モデル
    public static function deleteTask($taskname, $category)
    {
        // タスクを削除
         // タスク名とカテゴリで削除
         DB::delete('tasks')
         ->where('taskname', $taskname)
         ->where('category', $category)
         ->execute();
    }

    # タスク編集用モデル
    public static function updateTask($taskname, $category, $importance)
    {
        // タスク名とカテゴリでレコードを特定して更新
        DB::update('tasks')
            ->set(array(
                'taskname' => $taskname,
                'category' => $category,
                'importance' => $importance
            ))
            ->where('taskname', $taskname) // 元のタスク名で一致するレコードを検索
            ->where('category', $category) // 元のカテゴリで一致するレコードを検索
            ->execute();

        return $this->response('タスクが更新されました', 200);
    }
}
