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

    public static function task_list() # これはどっちでも使ってるわ
    {
        return DB::select()->from('tasks')->execute()->as_array();
    }

    # knockout.js用のメソッド

    # タスク追加用モデル
    public static function add_task($taskname, $category, $importance)
    {
        DB::insert('tasks')->set(array(
            'taskname' => $taskname,
            'category' => $category,
            'importance' => $importance,
        ))->execute();
    }


    # タスク削除用モデル
    public static function delete_task($taskname, $category)
    {
        // タスクを削除
        // タスク名とカテゴリで削除
        DB::delete('tasks')
        ->where('taskname', $taskname)
        ->where('category', $category)
        ->execute();
    }

    # タスク編集用モデル
    public static function update_task($new_taskname, $new_category, $new_importance,$pre_taskname)
    {

        // データベースのタスクを更新
        DB::update('tasks')
            ->set([
                'taskname' => $new_taskname,
                'category' => $new_category,
                'importance' => $new_importance,
            ])
            ->where('taskname', $pre_taskname)
            ->execute();

        //return $this->response('タスクが更新されました', 200);
    }

    # タスク検索用モデル
    public static function find_task($taskname)
    {
        return DB::select()->from('tasks')->where('taskname', $taskname)->execute()->current();
    }

    
}