<?php

require_once 'app/controllers/plugin_controller.php';

class TasksController extends PluginController {

    public function edit_action($task_id = null)
    {
        $this->task = new TPTask($task_id);
        if (Request::isPost()) {
            $data = Request::getArray("task");
            $data['deadline'] = strtotime($data['deadline']) ?: null;
            if ($this->task->isNew()) {
                $data['created_by_user'] = $GLOBALS['user']->id;
            }
            $this->task->setData($data);
            $this->task->store();
            PageLayout::postSuccess(_("Aufgabe gespeichert."));
            $this->response->add_header('X-Dialog-Close', '1');
        }
        if (Request::get("range_id") || $this->task['range_id']) {
            if ((Request::get("range_type") === "course") || ($this->task['range_type'] === "course")) {
                $this->statusgruppen = Statusgruppen::findBySeminar_id(Request::get("range_id") ?: $this->task['range_id']);
            } else {
                $this->statusgruppen = Statusgruppen::findAllByRangeId(Request::get("range_id") ?: $this->task['range_id']);
            }
        }
    }

    public function change_action($task_id)
    {
        $this->task = new TPTask($task_id);
        if (Request::isPost()) {
            $this->task[Request::get("attribute")] = Request::get("value");
            $this->task->store();
        }
        $this->render_text("ok");
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
}