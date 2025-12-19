<?php

namespace application\controllers;

use application\models\Note;

class HomepageController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'main.php';

    public function indexAction()
    {
        $articleModel = new Note();

        $articles = $articleModel->getList(10)['results'];

        foreach ($articles as $article) {
            // Эти свойства должны быть ОБЪЯВЛЕНЫ в модели (см. ниже)
            $article->categoryName    = $articleModel->getCategoryNameForId($article->categoryId);
            $article->subcategoryName = $articleModel->getSubcategoryNameForId($article->subcategoryId);
            $article->authors         = $articleModel->getAuthorsForArticle($article->id);
        }

        $this->view->addVar('articles', $articles);
        $this->view->render('homepage/index.php');
    }
}
