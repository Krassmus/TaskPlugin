<div style="margin: 10px;">
    <table class="default nohover">
        <thead>
            <tr>
                <th><?= _("Bezeichnung") ?></th>
                <th><?= _("Fällig bis") ?></th>
            </tr>
        </thead>
        <tbody>
            <? if (!count($tasks)) : ?>
                <tr>
                    <td colspan="100" style="text-align: center;">
                        <?= _("Keine ausstehenden Aufgaben") ?>
                    </td>
                </tr>
            <? else : ?>
            <? foreach ($tasks as $task) : ?>
                <tr>
                    <td>
                        <a href="<?= PluginEngine::getLink($plugin, array('cid' => $task['range_id']), "coursetasks/overview") ?>">
                            <?= htmlReady($task['name']) ?>
                        </a>
                    </td>
                    <td><?= $task['deadline'] ? date("j.n.Y G:i", $task['deadline']) : "" ?></td>
                </tr>
            <? endforeach ?>
            <? endif ?>
        </tbody>
    </table>
</div>