<?php

require_once 'app/controllers/plugin_controller.php';

class CoursetasksController extends PluginController {

    public function overview_action()
    {
        Navigation::activateItem("/course/tasks");
        PageLayout::setTitle(_("Aufgaben"));

        $this->tasks = TPTask::findBySQL("1=1 ORDER BY name");
    }
}