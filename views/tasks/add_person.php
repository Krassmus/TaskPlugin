<form action="<?= PluginEngine::getLink($plugin, array(), "tasks/add_person/".$task->getId()) ?>"
      method="post"
      class="default"
      data-dialog>
    <? if (count($users)) : ?>
        <select name="user_id">
            <? foreach ($users as $user) : ?>
                <option value="<?= htmlReady($user->getId()) ?>">
                    <?= htmlReady($user->getFullName()) ?>
                </option>
            <? endforeach ?>
        </select>
    <? else : ?>
        <?= QuickSearch::get("user_id", new StandardSearch("user_id"))->render() ?>
    <? endif ?>

    <div data-dialog-button>
        <?= \Studip\Button::create(_("Hinzufügen")) ?>
    </div>
</form>