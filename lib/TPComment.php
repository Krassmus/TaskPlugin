<?php

class TPComment extends SimpleORMap {

    protected static function configure($config = array())
    {
        $config['db_table'] = 'tp_comments';
        parent::configure($config);
    }
}