<table class="default tp_tasktable">
    <thead>
        <tr>
            <th><?= _("Aufgabe") ?></th>
            <th><?= _("Verantwortlich") ?></th>
            <th><?= _("Erledigt") ?></th>
            <th><?= _("Fällig bis") ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <? if (count($tasks)) : ?>
            <? foreach ($tasks as $task) : ?>
                <? if (!$task->statusgruppe_id && !$task->parent_id) : ?>
                    <?= $this->render_partial("tasks/_task_row.php", array('task' => $task)) ?>
                    <? foreach ($tasks as $child) : ?>
                        <? if ($child->parent_id === $task->getId()) : ?>
                            <?= $this->render_partial("tasks/_task_row.php", array('task' => $child, 'child' => 1)) ?>
                        <? endif ?>
                    <? endforeach ?>
                <? endif ?>
            <? endforeach ?>
        <? else : ?>
            <tr>
                <td colspan="100" style="text-align: center;">
                    <?= _("Erstellen Sie die ersten Aufgaben") ?>
                </td>
            </tr>
        <? endif ?>
    </tbody>
    <? foreach ($statusgruppen as $statusgruppe) : ?>
        <?
        $relevant = false;
        foreach ($tasks as $task) {
            if ($task['statusgruppe_id'] === $statusgruppe->getId()) {
                $relevant = true;
                break;
            }
        }
        ?>
        <? if ($relevant) : ?>
        <tbody>
            <tr class="nohover caption">
                <td colspan="100">
                    <h2>
                        <?= Icon::create("group2", "inactive")->asImg(25, array('class' => "text-bottom")) ?>
                        <?= htmlReady(_("Gruppe").": ".$statusgruppe['name']) ?>
                    </h2>
                </td>
            </tr>
            <? foreach ($tasks as $task) : ?>
                <? if ($task->statusgruppe_id === $statusgruppe->getId()) : ?>
                    <?= $this->render_partial("tasks/_task_row.php", array('task' => $task)) ?>
                    <? foreach ($tasks as $child) : ?>
                        <? if ($child->parent_id === $task->getId()) : ?>
                            <?= $this->render_partial("tasks/_task_row.php", array('task' => $child, 'child' => 1)) ?>
                        <? endif ?>
                    <? endforeach ?>
                <? endif ?>
            <? endforeach ?>
        </tbody>
        <? endif ?>
    <? endforeach ?>
</table>

<?php

$actions = new ActionsWidget();
$actions->addLink(
    _("Aufgabe erstellen"),
    PluginEngine::getURL($plugin, array('range_type' => "course", 'range_id' => Context::get()->id), "tasks/edit"),
    Icon::create($plugin->getPluginURL()."/assets/task_blue.svg"),
    array('data-dialog' => "reload-on-close")
);

Sidebar::Get()->addWidget($actions);