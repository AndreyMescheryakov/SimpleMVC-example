<?php 
use application\assets\DemoJavascriptAsset;
use ItForFree\SimpleMVC\Router\WebRouter;

DemoJavascriptAsset::add();
?>

<?php if (!empty($articles)): ?>
    <ul id="headlines">
    <?php foreach ($articles as $article): ?>
        <li>
            <h2>
                <a href="<?= WebRouter::link('note/view&id=' . $article->id) ?>">
                    <?= htmlspecialchars($article->title) ?>
                </a>
            </h2>
            
            <!-- Категория и подкатегория -->
            <div class="categories">
                <?php if (!empty($article->categoryName)): ?>
                    <span class="category">
                        Категория: 
                        <a href="<?= WebRouter::link('category/view&id=' . $article->categoryId) ?>">
                            <?= htmlspecialchars($article->categoryName) ?>
                        </a>
                    </span>
                <?php endif; ?>
                
                <?php if (!empty($article->subcategoryName)): ?>
                    <span class="subcategory">
                        | Подкатегория: 
                        <a href="<?= WebRouter::link('subcategory/view&id=' . $article->subcategoryId) ?>">
                            <?= htmlspecialchars($article->subcategoryName) ?>
                        </a>
                    </span>
                <?php endif; ?>
            </div>
            
            <!-- АВТОРЫ -->
        <?php if (!empty($article->authors)): ?>
            <div style="color: #888; font-size: 0.85em; font-style: italic; margin: 3px 0;">
                Автор(ы): 
                <?php foreach ($article->authors as $author): ?>
                    <span class="author"><?= htmlspecialchars($author->login) ?></span>
                    <?php if ($author !== end($article->authors)): ?>, <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

            <p class="pubDate"><?= date('j F Y', strtotime($article->publicationDate)) ?></p>
            <p class="summary"><?= htmlspecialchars(substr($article->content, 0, 30)) ?>...</p>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Статей пока нет.</p>
<?php endif; ?>