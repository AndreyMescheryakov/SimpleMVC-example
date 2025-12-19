<?php
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');
?>

<div id="footer">
    Простая PHP CMS &copy; <?= date('Y') ?>. Все права принадлежат всем. ;)
    
    <?php if ($User->isAllowed("login/login")): ?>
        | <a href="<?= WebRouter::link("login/login") ?>">Site Admin</a>
    <?php elseif ($User->isAllowed("login/logout")): ?>
        | <a href="<?= WebRouter::link("login/logout") ?>">Logout (<?= $User->userName ?>)</a>
    <?php endif; ?>
</div>