<form action="<?= PluginEngine::getLink($plugin, array('range_type' => Request::get("range_type"), 'range_id' => Request::get("range_id")), "tasks/edit/" . $task->getId()) ?>"
      method="post"
      class="default"
      data-dialog xmlns="http://www.w3.org/1999/html">
    <input type="hidden" name="task[range_id]" value="<?= htmlReady($task['range_id'] ?: Request::get("range_id")) ?>">
    <input type="hidden" name="task[range_type]" value="<?= htmlReady($task['range_type'] ?: Request::get("range_type")) ?>">

    <fieldset>
        <legend><?= _("Aufgabe") ?></legend>

        <label>
            <?= _("Kurzbezeichnung") ?>
            <input type="text" name="task[name]" value="<?= htmlReady($task['name']) ?>" placeholder="<?= _("Einen Bären aufbinden") ?>" required>
        </label>

        <label>
            <?= _("Anforderungsbeschreibung") ?>
            <textarea name="task[description]" class="add_toolbar"><?= htmlReady($task['description']) ?></textarea>
        </label>

        <label>
            <?= _("Fällig bis") ?>
            <input type="text" name="task[deadline]" data-datetime-picker value="<?= $task['deadline'] ? date("j.n.Y G:i", $task['deadline']) : "" ?>">
        </label>

        <? if ($statusgruppen && count($statusgruppen) > 0) : ?>
        <label>
            <?= _("Arbeitsgruppe") ?>
            <select name="task[statusgruppe_id]">
                <option value=""></option>
                <? foreach ((array) $statusgruppen as $statusgruppe) : ?>
                    <option value="<?= htmlReady($statusgruppe->getId()) ?>"<?= $task['statusgruppe_id'] === $statusgruppe->getId() ? " selected" : "" ?>>
                        <?= htmlReady($statusgruppe['name']) ?>
                    </option>
                <? endforeach ?>
            </select>
        </label>
        <? endif ?>

        <? if (count($tasks)) : ?>
        <label>
            <?= _("Unteraufgabe von") ?>
            <select name="task[parent_id]">
                <option value="">-</option>
                <? foreach ($tasks as $parent_task) : ?>
                    <? if (($parent_task->getId() !== $task->getId()) && (!$parent_task->parent_id)) : ?>
                        <option value="<?= htmlReady($parent_task->getId()) ?>"<?= $parent_task->getId() === $task->parent_id ? " selected" : "" ?>>
                            <?= htmlReady($parent_task['name']) ?>
                        </option>
                    <? endif ?>
                <? endforeach ?>
            </select>
        </label>
        <? endif ?>

        <? if ("course" === ($task['range_type'] ?: Request::get("range_type"))) : ?>
            <label>
                <input type="checkbox" name="task[for_all]" value="1" <?= $task['for_all'] ? "checked" : "" ?>>
                <?= _("Sind alle für die Aufgabe vorgesehen?") ?>
            </label>

            <label>
                <input type="checkbox" name="task[work_as_group]" value="1" <?= $task['work_as_group'] || $task->isNew() ? "checked" : "" ?>>
                <?= _("Ist dies eine kooperative Aufgabe?") ?>
            </label>
        <? endif ?>

        <? if ($task->isNew()) : ?>
            <div>
                <h4><?= _("Wer kümmert sich drum?") ?></h4>
                <label>
                    <input type="radio" name="responsible" value="">
                    <?= _("Noch niemand spezielles") ?>
                </label>
                <label>
                    <input type="radio" name="responsible" value="me">
                    <?= _("Ich höchst persönlich") ?>
                </label>
                <label>
                    <?= _("Dieser hier ...") ?>
                    <? if ($users) : ?>
                        <select name="responsible_user">
                            <option value=""></option>
                            <? foreach ($users as $user) : ?>
                                <option value="<?= htmlReady($user->getId()) ?>">
                                    <?= htmlReady($user->getFullName()) ?>
                                </option>
                            <? endforeach ?>
                        </select>
                    <? else : ?>
                        <?= QuickSearch::get("responsible_user", new StandardSearch("user_id"))->render() ?>
                    <? endif ?>
                </label>
            </div>
        <? endif ?>



    </fieldset>
    <div data-dialog-button>
        <?= \Studip\Button::create(_("Speichern")) ?>
    </div>
</form>