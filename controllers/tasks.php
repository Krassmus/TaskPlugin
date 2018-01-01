<?php

require_once 'app/controllers/plugin_controller.php';

class TasksController extends PluginController {

    public function edit_action($task_id = null)
    {
        $this->task = new TPTask($task_id);
        if ((Request::get("range_type") === "user") || ($this->task['range_type'] === "user")) {
            if ($this->task->isNew()) {
                PageLayout::setTitle(_("Individuelle Aufgabe erstellen"));
            } else {
                PageLayout::setTitle(_("Individuelle Aufgabe bearbeiten"));
            }
        } else {
            if ($this->task->isNew()) {
                PageLayout::setTitle(_("Aufgabe erstellen"));
            } else {
                PageLayout::setTitle(_("Aufgabe bearbeiten"));
            }
        }
        if (Request::isPost()) {
            $data = Request::getArray("task");
            $data['deadline'] = strtotime($data['deadline']) ?: null;
            if ($this->task->isNew()) {
                $data['created_by_user'] = $GLOBALS['user']->id;
            }
            $data['for_all'] = $data['for_all'] ?: 0;
            $data['work_as_group'] = $data['work_as_group'] ?: 0;
            $this->task->setData($data);
            $this->task->store();
            if (Request::option("responsible") || Request::option("responsible_user")) {
                $statement = DBManager::get()->prepare("
                    INSERT IGNORE INTO tp_task_user
                    SET task_id = :task_id,
                        user_id = :user_id
                ");
                if (Request::option("responsible_user")) {
                    $statement->execute(array(
                        'task_id' => $this->task->getId(),
                        'user_id' => Request::option("responsible_user")
                    ));
                } elseif(Request::option("responsible") === "me") {
                    $statement->execute(array(
                        'task_id' => $this->task->getId(),
                        'user_id' => $GLOBALS['user']->id
                    ));
                }
            }
            PageLayout::postSuccess(_("Aufgabe gespeichert."));
            $this->response->add_header('X-Dialog-Close', '1');
        }
        if (Request::get("range_id") || $this->task['range_id']) {
            $range_id = Request::get("range_id") ?: $this->task['range_id'];
            if ((Request::get("range_type") === "course") || ($this->task['range_type'] === "course")) {
                $this->statusgruppen = Statusgruppen::findBySeminar_id($range_id);
                $this->tasks = TPTask::findBySQL("range_type = ? AND range_id = ?", array("course", $range_id));
            } else {
                $this->statusgruppen = Statusgruppen::findAllByRangeId($range_id);
            }
        }
    }

    public function change_action($task_id)
    {
        $this->task = new TPTask($task_id);
        $output = array();
        if (Request::isPost()) {
            $this->task[Request::get("attribute")] = Request::get("value");
            $this->task->store();
            if ($this->task->parent_id) {
                $parent = TPTask::find($this->task->parent_id);
                $children = TPTask::findByParent_id($this->task->parent_id);
                $average = 0;
                foreach ($children as $child) {
                    $average += $child['finished'];
                }
                $average = floor($average / count($children));
                $parent['finished'] = $average;
                $parent->store();
                $output[$this->task->parent_id] = $average;
            }
        }
        $this->render_json($output);
    }

    public function add_person_action($task_id)
    {
        $this->task = new TPTask($task_id);
        if (Request::isPost() && Request::option("user_id")) {
            $statement = DBManager::get()->prepare("
                INSERT IGNORE INTO tp_task_user
                SET task_id = :task_id,
                    user_id = :user_id
            ");
            $statement->execute(array(
                'task_id' => $this->task->getId(),
                'user_id' => Request::option("user_id")
            ));
            $this->response->add_header('X-Dialog-Close', '1');
        }
        if ($this->task['range_type'] === "course") {
            $this->users = User::findBySQL("INNER JOIN seminar_user USING (user_id) WHERE seminar_user.Seminar_id = ? ORDER BY Vorname, Nachname", array($this->task['range_id']));
        }
    }

    public function details_action($task_id)
    {
        $this->task = new TPTask($task_id);
        PageLayout::addScript($this->plugin->getPluginURL()."/assets/tasks.js");
        if ($this->task['range_type'] === "course") {
            Navigation::activateItem("/course/tasks");
        }
    }

    public function comment_action($task_id)
    {
        $this->task = new TPTask($task_id);
        if (Request::isPost() && Request::get("comment")) {
            $this->comment = new TPComment();
            $this->comment['task_id'] = $task_id;
            $this->comment['comment'] = Request::get("comment");
            $this->comment['user_id'] = $GLOBALS['user']->id;
            $this->comment->store();
            $comment_html = $this->render_template_as_string("tasks/_comment");
            $this->render_json(array('html' => $comment_html));
        }
    }
}