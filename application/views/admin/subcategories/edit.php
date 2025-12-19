<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
use ItForFree\SimpleMVC\Config;

$Url = Config::get('core.router.class');
$action = $action ?? 'add';
?>

<h1><?= $title ?></h1>

<form method="post" action="<?= 
    ($action == 'edit' && !empty($subcategory) && !empty($subcategory->id)) 
    ? $Url::link('admin/adminsubcategories/edit&id=' . $subcategory->id) 
    : $Url::link('admin/adminsubcategories/add') 
?>">
    
    <?php if ($action == 'edit' && !empty($subcategory) && !empty($subcategory->id)): ?>
        <input type="hidden" name="id" value="<?= $subcategory->id ?>">
    <?php endif; ?>
    
    <div class="form-group">
        <label for="name">Название подкатегории:</label>
        <input type="text" name="name" id="name" class="form-control" 
               value="<?= ($action == 'edit' && !empty($subcategory)) ? htmlspecialchars($subcategory->name ?? '') : '' ?>" 
               required>
    </div>
    
    <div class="form-group">
        <label for="categoryId">Родительская категория:</label>
        <select name="categoryId" id="categoryId" class="form-control" required>
            <option value="">-- Выберите категорию --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat->id ?>" 
                    <?= ($action == 'edit' && !empty($subcategory) && $subcategory->categoryId == $cat->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" name="saveSubcategory" value="1" class="btn btn-success">
        <?= ($action == 'edit') ? 'Сохранить' : 'Добавить' ?>
    </button>
    <button type="submit" name="cancel" value="1" class="btn btn-secondary">Отмена</button>
</form>