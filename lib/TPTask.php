<?php

class TPTask extends SimpleORMap {

    protected static function configure($config = array())
    {
        $config['db_table'] = 'tp_tasks';
        parent::configure($config);
    }

}