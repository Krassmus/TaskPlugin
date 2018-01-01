<li id="comment_<?= $comment->getId() ?>" class="comment">
    <div class="avatar">
        <img width="50px" height="50px" src="<?= htmlReady(Avatar::getAvatar($comment['user_id'])->getURL(Avatar::MEDIUM)) ?>">
    </div>
    <div class="content">
        <div class="timestamp">
            <?= date("j.n.Y G:i", $comment['chdate']) ?>
        </div>
        <strong><?= htmlReady(get_fullname($comment['user_id'])) ?></strong>
        <div class="comment_text">
            <?= formatReady($comment['comment']) ?>
        </div>
    </div>
</li>