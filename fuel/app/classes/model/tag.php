<?php

class Model_Tag extends \Orm\Model
{
    protected static $_properties = array(
        'id',
        'name',
        'user_id',
    );

    protected static $_table_name = 'tags';
}
