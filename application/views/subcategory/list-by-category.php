<h1>Подкатегории: <?= htmlspecialchars($category->name) ?></h1>

<?php if (!empty($subcategories)): ?>
    <ul>
    <?php foreach ($subcategories as $subcat): ?>
        <li>
            <h3>
                <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('subcategory/view&id=' . $subcat->id) ?>">
                    <?= htmlspecialchars($subcat->name) ?>
                </a>
            </h3>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>В этой категории нет подкатегорий.</p>
<?php endif; ?>

<p>
    <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('category/view&id=' . $category->id) ?>">
        ← Назад к категории
    </a> | 
    <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('subcategory/listAll') ?>">
        Все подкатегории
    </a> | 
    <a href="./">На главную</a>
</p>