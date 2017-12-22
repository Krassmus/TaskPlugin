<?php

require_once __DIR__."/lib/TPTask.php";

class TaskPlugin extends StudIPPlugin implements StandardPlugin, HomepagePlugin, PortalPlugin
{
    public function __construct()
    {
        parent::__construct();
        $this->addStylesheet("assets/tasks.less");
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

    function getPortalTemplate() {
        $statement = DBManager::get()->prepare("
            SELECT tp_tasks.*
            FROM tp_tasks
                LEFT JOIN tp_task_user ON (tp_tasks.task_id = tp_task_user.task_id)
                LEFT JOIN statusgruppe_user ON (tp_tasks.statusgruppe_id = statusgruppe_user.statusgruppe_id)
                LEFT JOIN seminar_user ON (tp_tasks.range_type = 'course' AND tp_tasks.range_id = seminar_user.Seminar_id)
            WHERE (
                    tp_task_user.user_id = :me
                    OR (statusgruppe_user.user_id = :me AND tp_tasks.for_all = '1')
                    OR (seminar_user.user_id = :me AND tp_tasks.for_all = '1')
                ) 
                AND  tp_tasks.finished < 100
                AND (tp_tasks.deadline IS NULL OR tp_tasks.deadline > UNIX_TIMESTAMP())
            GROUP BY tp_tasks.task_id
            ORDER BY IF(tp_tasks.deadline IS NOT NULL, '1', '0') DESC, tp_tasks.deadline - UNIX_TIMESTAMP() ASC, tp_tasks.name ASC
        ");
        $statement->execute(array('me' => $GLOBALS['user']->id));
        $tasks = array();
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $tasks[] = TPTask::buildExisting($data);
        }

        $tf = new Flexi_TemplateFactory(__DIR__."/views");
        $template = $tf->open("widget/index");
        $template->tasks = $tasks;
        $template->title = _("Aufgaben");
        $template->plugin = $this;
        return $template;
    }


}