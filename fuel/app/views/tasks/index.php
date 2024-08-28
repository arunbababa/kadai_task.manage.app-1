<h2>タスク一覧</h2>

<?php if ($tasks): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>作成日時</th>
                <th>アクション</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo $task->title; ?></td>
                <td><?php echo Date::forge($task->created_at)->format("%Y-%m-%d %H:%M"); ?></td>
                <td>
                    <?php echo Html::anchor('tasks/view/'.$task->id, '表示'); ?> |
                    <?php echo Html::anchor('tasks/edit/'.$task->id, '編集'); ?> |
                    <?php echo Html::anchor('tasks/delete/'.$task->id, '削除', array('onclick' => "return confirm('本当に削除しますか？')")); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>タスクがありません。</p>
<?php endif; ?>

<p><?php echo Html::anchor('tasks/create', '新規タスク作成', array('class' => 'btn btn-success')); ?></p>