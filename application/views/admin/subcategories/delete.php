<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
use ItForFree\SimpleMVC\Config;

$Url = Config::get('core.router.class');
?>

<h1>Удаление подкатегории</h1>

<div class="alert alert-warning">
    <p>Вы действительно хотите удалить подкатегорию <strong>"<?= htmlspecialchars($subcategory->name) ?>"</strong>?</p>
    <p><strong>Внимание:</strong> Все статьи этой подкатегории останутся без подкатегории.</p>
</div>

<form method="post" action="<?= $Url::link('admin/adminsubcategories/delete&id=' . $subcategory->id) ?>">
    <button type="submit" name="deleteSubcategory" value="1" class="btn btn-danger">Да, удалить</button>
    <button type="submit" name="cancel" value="1" class="btn btn-secondary">Отмена</button>
</form>