<?php
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<h2><?= $viewNotes->title ?>
    <span>
        <?php if ($User->isAllowed("admin/notes/edit") && strpos($_SERVER['REQUEST_URI'], 'admin/') !== false): ?>
        <?= $User->returnIfAllowed("admin/notes/edit", 
            "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/notes/edit&id=". $viewNotes->id) 
            . ">[Редактировать]</a>");?>
        
        <?= $User->returnIfAllowed("admin/notes/delete",
                "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/notes/delete&id=". $viewNotes->id)
            .    ">[Удалить]</a>"); ?>
        <?php endif; ?>
    </span>
    
</h2> 

<p>Контент: <?= $viewNotes->content ?></p>
<p>Зарегестрирована: <?= $viewNotes->publicationDate ?></p>
