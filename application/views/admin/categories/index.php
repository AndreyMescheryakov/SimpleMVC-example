<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');
?>

<h1>Управление категориями</h1>

<p><a href="<?= WebRouter::link('admin/admincategories/add') ?>" class="btn btn-primary">Добавить категорию</a></p>

<?php if (!empty($categories)): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category->id ?></td>
                <td><?= htmlspecialchars($category->name) ?></td>
                <td><?= htmlspecialchars($category->description ?? '') ?></td>
                <td>
                    <a href="<?= WebRouter::link('admin/admincategories/edit&id=' . $category->id) ?>" 
                       class="btn btn-sm btn-warning">Редактировать</a>
                    <a href="<?= WebRouter::link('admin/admincategories/delete&id=' . $category->id) ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Удалить категорию?')">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">Категорий пока нет.</div>
<?php endif; ?>