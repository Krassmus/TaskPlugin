<tr id="task_<?= htmlReady($task->getId()) ?>">
    <td>
        <?= htmlReady($task['name']) ?>
    </td>
    <td>
        <? if ($task['for_all']) : ?>
            <?= _("Alle") ?>
        <? else : ?>
        <ul class="clean">
            <? foreach ($task->users as $user) : ?>
                <li>
                    <?= htmlReady($user->getFullName()) ?>
                </li>
            <? endforeach ?>
        </ul>
        <a href="<?= PluginEngine::getLink($plugin, array(), "tasks/add_person/".$task->getId()) ?>" data-dialog="reload-on-close">
            <?= Icon::create("add", "clickable")->asImg(16) ?>
        </a>
        <? endif ?>
    </td>
    <td>
        <input type="range"
               value="<?= htmlReady($task['finished']) ?>"
               max="100"
               class="<?= $task['finished'] == "100" ? "max" : "" ?>"
               onInput="jQuery(this).next().find('.percentage').text(this.value); jQuery(this).toggleClass('max', this.value == 100);"
               onChange="jQuery.post(STUDIP.ABSOLUTE_URI_STUDIP + 'plugins.php/taskplugin/tasks/change/<?= $task->getId() ?>', {'attribute': 'finished', 'value': this.value})">
        <span class="percentage_indicator"><span class="percentage"><?= (int) $task['finished'] ?></span>%</span>
        <span class="finish_indicator">
            <?= Icon::create("accept", "accept")->asImg(20, array('class' => "text-bottom")) ?>
        </span>
    </td>
    <td>
        <? if ($task['deadline']) : ?>
            <?= $task['deadline'] ? date("j.n.Y G:i", $task['deadline']) : "" ?>
        <? endif ?>
    </td>
    <td class="actions">
        <a href="<?= PluginEngine::getURL($plugin, array(), "tasks/edit/".$task->getId()) ?>" data-dialog="reload-on-close">
            <?= Icon::create("edit", "clickable")->asImg(20, array('class' => "text-bottom")) ?>
        </a>
    </td>
</tr>