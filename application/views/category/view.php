<h1>Категория: <?= htmlspecialchars($category->name) ?></h1>

<?php if (!empty($category->description)): ?>
    <p class="categoryDescription"><?= htmlspecialchars($category->description) ?></p>
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
    <p>В этой категории пока нет статей.</p>
<?php endif; ?>

<p><a href="./">Вернуться на главную</a></p>