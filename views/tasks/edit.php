<form action="<?= PluginEngine::getLink($plugin, array('range_type' => Request::get("range_type"), 'range_id' => Request::get("range_id")), "tasks/edit/".$task->getId()) ?>"
      method="post"
      class="default"
      data-dialog>
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
            <textarea name="task[description]"><?= htmlReady($task['description']) ?></textarea>
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

        <? if ("course" === $task['range_type'] ?: Request::get("range_type")) : ?>
        <label>
            <input type="checkbox" name="task[for_all]" value="1" <?= $task['for_all'] ? "checked" : "" ?>>
            <?= _("Sind alle verantwortlich?") ?>
        </label>
        <? endif ?>

    </fieldset>
    <div data-dialog-button>
        <?= \Studip\Button::create(_("Speichern")) ?>
    </div>
</form>