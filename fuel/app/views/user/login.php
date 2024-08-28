<h2>ログイン</h2>

<?php echo Form::open('users/login'); ?>

    <?php if (Session::get_flash('error')): ?>
        <div class="alert alert-error">
            <?php echo Session::get_flash('error'); ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?php echo Form::label('ユーザー名', 'username'); ?>
        <?php echo Form::input('username', Input::post('username'), array('class' => 'form-control')); ?>
    </div>

    <div class="form-group">
        <?php echo Form::label('パスワード', 'password'); ?>
        <?php echo Form::password('password', null, array('class' => 'form-control')); ?>
    </div>

    <div class="form-group">
        <?php echo Form::submit('submit', 'ログイン', array('class' => 'btn btn-primary')); ?>
    </div>

<?php echo Form::close(); ?>

<p><?php echo Html::anchor('users/register', '新規登録'); ?></p>