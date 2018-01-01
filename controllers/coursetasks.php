<?php

require_once 'app/controllers/plugin_controller.php';

class CoursetasksController extends PluginController {

    public function overview_action()
    {
        Navigation::activateItem("/course/tasks");
        PageLayout::setTitle(_("Aufgaben"));

        $this->tasks = TPTask::findBySQL("range_type = 'course' AND range_id = ? ORDER BY IF(deadline IS NOT NULL, '1', '0') DESC, deadline - UNIX_TIMESTAMP() ASC, name ASC", array(Context::get()->id));
        $this->statusgruppen = Statusgruppen::findBySeminar_id(Context::get()->id);
    }
}