<?php 
use ItForFree\SimpleMVC\Config;
use application\models\Category;
use application\models\Subcategory;
use ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-notes-nav.php'); ?>

<h2>List notes</h2>

<?php if (!empty($notes)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">Оглавление</th>
      <th scope="col">Посвящается</th>
      <th scope="col">Дата</th>
      <th scope="col">Категория</th>
      <th scope="col">Подкатегория</th>
      <th scope="col"></th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($notes as $note): ?>
    <tr>
        <td> <?= "<a href=" . WebRouter::link('admin/notes/index&id=' 
		. $note->id . ">{$note->title}</a>" ) ?> </td>
        <td><?= htmlspecialchars(substr($note->content, 0, 30)) ?>...</td>
        <td> <?= $note->publicationDate ?> </td>
        
        <td>
            <?php if ($note->categoryId): ?>
                <?php 
                $categoryModel = new Category();
                $category = $categoryModel->getById($note->categoryId);
                if ($category): ?>
                    <a href="<?= WebRouter::link('admin/admincategories/edit&id=' . $category->id) ?>">
                        <?= htmlspecialchars($category->name) ?>
                    </a>
                <?php else: ?>
                    <span class="text-muted">Категория удалена</span>
                <?php endif; ?>
            <?php else: ?>
                <span class="text-muted">Без категории</span>
            <?php endif; ?>
        </td>

        <td>
            <?php if ($note->subcategoryId): ?>
                <?php 
                $subcategoryModel = new Subcategory();
                $subcategory = $subcategoryModel->getById($note->subcategoryId);
                if ($subcategory): ?>
                    <span class="text-muted">
                        <?= htmlspecialchars($subcategory->name) ?>
                    </span>
                <?php else: ?>
                    <span class="text-muted">Подкатегория неопределена</span>
                <?php endif; ?>
            <?php else: ?>
                <span class="text-muted">Без подкатегории</span>
            <?php endif; ?>
        </td>

    </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<?php else:?>
    <p> Список заметок пуст</p>
<?php endif; ?>
