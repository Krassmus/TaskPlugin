<?php

require_once __DIR__."/lib/TPTask.php";

class TaskPlugin extends StudIPPlugin implements StandardPlugin, HomepagePlugin, PortalPlugin
{
    public function __construct()
    {
        parent::__construct();
    }

    function getInfoTemplate($course_id) {}

    function getIconNavigation($course_id, $last_visit, $user_id) {}

    function getTabNavigation($course_id) {
        $tab = new Navigation(_("Aufgaben"), PluginEngine::getURL($this, array(), "coursetasks/overview"));
        $tab->setImage(Icon::create($this->getPluginURL()."/assets/task_black.svg"));
        $tab->setActiveImage(Icon::create($this->getPluginURL()."/assets/task_white.svg"));
        return array('tasks' => $tab);
    }

    function getHomepageTemplate($user_id) {}

    function getPortalTemplate() {}
}