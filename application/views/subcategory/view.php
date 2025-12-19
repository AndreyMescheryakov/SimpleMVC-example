<h1>Подкатегория: <?= htmlspecialchars($subcategory->name) ?></h1>

<?php 
$categoryName = $subcategory->getCategoryName();
if ($categoryName): ?>
    <p class="category">
        Категория: 
        <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('category/view&id=' . $subcategory->categoryId) ?>">
            <?= htmlspecialchars($categoryName) ?>
        </a>
    </p>
<?php endif; ?>

<?php if (!empty($articles)): ?>
    <ul id="headlines">
    <?php foreach ($articles as $article): ?>
        <li>
            <h2>
                <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('note/view&id=' . $article->id) ?>">
                    <?= htmlspecialchars($article->title) ?>
                </a>
            </h2>
            <p class="pubDate"><?= date('j F Y', strtotime($article->publicationDate)) ?></p>
            <p class="summary"><?= htmlspecialchars(substr($article->content, 0, 200)) ?>...</p>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>В этой подкатегории пока нет статей.</p>
<?php endif; ?>

<p>
    <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('subcategory/listByCategory&categoryId=' . $subcategory->categoryId) ?>">
        ← Назад к подкатегориям
    </a> | 
    <a href="./">На главную</a>
</p>