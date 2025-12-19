<h1>Все категории</h1>

<?php if (!empty($categories)): ?>
    <ul>
    <?php foreach ($categories as $category): ?>
        <li>
            <h3>
                <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('category/view&id=' . $category->id) ?>">
                    <?= htmlspecialchars($category->name) ?>
                </a>
            </h3>
            <?php if (!empty($category->description)): ?>
                <p><?= htmlspecialchars($category->description) ?></p>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Категорий пока нет.</p>
<?php endif; ?>