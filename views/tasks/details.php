<h1><?= htmlReady($task['name']) ?></h1>
<div style="text-align: center;" class="tp_details_header">
    <h4><?= _("Fortschritt") ?></h4>
    <input type="range"
           value="<?= htmlReady($task['finished']) ?>"
           max="100"
           class="<?= $task['finished'] == "100" ? "max" : "" ?>"
           onInput="jQuery(this).next().find('.percentage').text(this.value); jQuery(this).toggleClass('max', this.value == 100);"
           onChange="jQuery.post(STUDIP.ABSOLUTE_URI_STUDIP + 'plugins.php/taskplugin/tasks/change/<?= $task->getId() ?>', {'attribute': 'finished', 'value': this.value})"
           style="width: 50%;">
    <div>
        <span class="percentage_indicator"><span class="percentage"><?= (int) $task['finished'] ?></span>%</span>
        <span class="finish_indicator">
            <?= Icon::create("accept", "accept")->asImg(20, array('class' => "text-bottom")) ?>
        </span>
    </div>
</div>

<div>
    <?= formatReady($task['description']) ?>
</div>

<h2><?= _("Diskussion") ?></h2>

<ol class="tp_discussion">
    <? foreach ($task->comments as $comment) : ?>
        <?= $this->render_partial("tasks/_comment.php", compact("comment")) ?>
    <? endforeach ?>
</ol>

<textarea name="comment"
          class="tp_discussion_textarea"
          data-task_id="<?= htmlReady($task->getId()) ?>"
          placeholder="<?= _("Kommentar ...") ?>"></textarea>
<?= \Studip\LinkButton::create(_("Absenden"), "send", array('onClick' => "STUDIP.TP.addComment(); return false;")) ?>

<?
$actions = new ActionsWidget();
$actions->addLink(
    _("Aufgabe bearbeiten"),
    PluginEngine::getURL($plugin, array(), "tasks/edit/".$task->getId()),
    Icon::create("edit", "clickable"),
    array('data-dialog' => "reload-on-close")
);

Sidebar::Get()->addWidget($actions);