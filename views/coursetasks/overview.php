<table class="default">
    <thead>
        <tr>
            <th><?= _("Aufgabe") ?></th>
            <th><?= _("Verantwortlich") ?></th>
            <th><?= _("Erledigt") ?></th>
            <th><?= _("Fällig bis") ?></th>
        </tr>
    </thead>
    <tbody>
        <? if (count($tasks)) : ?>
            <? foreach ($tasks as $task) : ?>
                <tr>
                    <td>
                        <?= htmlReady($task['name']) ?>
                    </td>
                    <td>
                        <? if ($task['assigned_to_user']) : ?>
                            <?= htmlReady(get_fullname($task['assigned_to_user'])) ?>
                        <? endif ?>
                    </td>
                    <td>
                        <input readonly type="range" value="<?= htmlReady($task['finished']) ?>" max="100">
                    </td>
                    <td>
                        <? if ($task['deadline']) : ?>
                        <?= date("G:h d.n.Y", $task['deadline']) ?>
                        <? endif ?>
                    </td>
                </tr>
            <? endforeach ?>
        <? else : ?>
            <tr>
                <td colspan="100" style="text-align: center;">
                    <?= _("Erstellen Sie die ersten Aufgaben") ?>
                </td>
            </tr>
        <? endif ?>
    </tbody>
</table>

<?php

$actions = new ActionsWidget();
$actions->addLink(
    _("Aufgabe erstellen"),
    PluginEngine::getURL($plugin, array(), "coursetasks/edit"),
    Icon::create($plugin->getPluginURL()."/assets/task_blue.svg"),
    array('data-dialog' => 1)
);

Sidebar::Get()->addWidget($actions);