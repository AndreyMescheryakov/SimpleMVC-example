<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
use ItForFree\SimpleMVC\Config;

$Url = Config::get('core.router.class');
$action = $action ?? 'add'; // 'add' или 'edit'
?>

<h1><?= $title ?></h1>

<form method="post" action="<?= 
    ($action == 'edit' && !empty($category) && !empty($category->id)) 
    ? $Url::link('admin/admincategories/edit&id=' . $category->id) 
    : $Url::link('admin/admincategories/add') 
?>">
    
    <?php if ($action == 'edit' && !empty($category) && !empty($category->id)): ?>
        <input type="hidden" name="id" value="<?= $category->id ?>">
    <?php endif; ?>
    
    <div class="form-group">
        <label for="name">Название категории:</label>
        <input type="text" name="name" id="name" class="form-control" 
               value="<?= ($action == 'edit' && !empty($category)) ? htmlspecialchars($category->name ?? '') : '' ?>" 
               required>
    </div>
    
    <div class="form-group">
        <label for="description">Описание:</label>
        <textarea name="description" id="description" class="form-control" rows="3">
            <?= ($action == 'edit' && !empty($category)) ? htmlspecialchars($category->description ?? '') : '' ?>
        </textarea>
    </div>
    
    <button type="submit" name="saveCategory" value="1" class="btn btn-success">
        <?= ($action == 'edit') ? 'Сохранить' : 'Добавить' ?>
    </button>
    <button type="submit" name="cancel" value="1" class="btn btn-secondary">Отмена</button>
</form>