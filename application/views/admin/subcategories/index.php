<?php 
use ItForFree\SimpleMVC\Router\WebRouter;
?>

<h1>Управление подкатегориями</h1>

<p><a href="<?= WebRouter::link('admin/adminsubcategories/add') ?>" class="btn btn-primary">Добавить подкатегорию</a></p>

<?php if (!empty($subcategories)): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Категория</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($subcategories as $subcat): ?>
            <tr>
                <td><?= $subcat->id ?></td>
                <td><?= htmlspecialchars($subcat->name) ?></td>
                <td>
                    <?php if (!empty($subcat->categoryName)): ?>
                        <a href="<?= WebRouter::link('admin/admincategories/edit&id=' . $subcat->categoryId) ?>">
                            <?= htmlspecialchars($subcat->categoryName) ?>
                        </a>
                    <?php else: ?>
                        <span class="text-muted">Категория удалена</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= WebRouter::link('admin/adminsubcategories/edit&id=' . $subcat->id) ?>" 
                       class="btn btn-sm btn-warning">Редактировать</a>
                    <a href="<?= WebRouter::link('admin/adminsubcategories/delete&id=' . $subcat->id) ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Удалить подкатегорию?')">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">Подкатегорий пока нет.</div>
<?php endif; ?>