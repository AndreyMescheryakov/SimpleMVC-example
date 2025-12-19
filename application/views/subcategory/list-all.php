<h1>Все подкатегории</h1>

<?php if (!empty($categories)): ?>
    <?php foreach ($categories as $category): ?>
        <?php if (!empty($category->subcategories)): ?>
            <h2><?= htmlspecialchars($category->name) ?></h2>
            <ul>
            <?php foreach ($category->subcategories as $subcat): ?>
                <li>
                    <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('subcategory/view&id=' . $subcat->id) ?>">
                        <?= htmlspecialchars($subcat->name) ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>Подкатегорий пока нет.</p>
<?php endif; ?>

<p><a href="./">На главную</a></p>