<?php

class Model_Task extends \Orm\Model
{
    protected static $_properties = array(
        'id',
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'created_at',
        'updated_at',
    );

    protected static $_table_name = 'tasks';

    protected static $_created_at = 'created_at';
    protected static $_updated_at = 'updated_at';
}
