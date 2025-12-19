<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
use ItForFree\SimpleMVC\Config;

$Url = Config::get('core.router.class');
?>

<h1>Удаление категории</h1>

<div class="alert alert-warning">
    <p>Вы действительно хотите удалить категорию <strong>"<?= htmlspecialchars($category->name) ?>"</strong>?</p>
    <p><strong>Внимание:</strong> Все статьи этой категории останутся без категории.</p>
</div>

<form method="post" action="<?= $Url::link('admin/admincategories/delete&id=' . $category->id) ?>">
    <button type="submit" name="deleteCategory" value="1" class="btn btn-danger">Да, удалить</button>
    <button type="submit" name="cancel" value="1" class="btn btn-secondary">Отмена</button>
</form>