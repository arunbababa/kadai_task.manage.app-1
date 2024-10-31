<?php

class Model_Task extends \Model
{
    # タスクリスト取得用モデル
    public static function taskList()
    {
        return DB::select()->from('tasks')->execute()->as_array();
    }

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
        // タスクを、タスク名とカテゴリを指定して削除
        $affected_rows = DB::delete('tasks')
                            ->where('taskname', $taskname)
                            ->where('category', $category)
                            ->execute();
        return $affected_rows > 0;
    }

    # タスク編集用モデル
    public static function updateTask($new_taskname, $new_category, $new_importance,$pre_taskname)
    {
        // 新たなタスク名、カテゴリ、重要度をセット
        $affected_rows = DB::update('tasks')
            ->set([
                'taskname' => $new_taskname,
                'category' => $new_category,
                'importance' => $new_importance,
            ])
            ->where('taskname', $pre_taskname)
            ->execute();
        return $affected_rows > 0;
    }
}