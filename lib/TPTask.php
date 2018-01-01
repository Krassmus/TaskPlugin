<?php

class TPTask extends SimpleORMap {

    protected static function configure($config = array())
    {
        $config['db_table'] = 'tp_tasks';
        $config['has_and_belongs_to_many']['users'] = array(
            'class_name' => 'User',
            'thru_table' => 'tp_task_user',
            'order_by' => 'ORDER BY Vorname, Nachname'
        );
        $config['has_many']['comments'] = array(
            'class_name' => 'TPComment'
        );
        parent::configure($config);
    }

}