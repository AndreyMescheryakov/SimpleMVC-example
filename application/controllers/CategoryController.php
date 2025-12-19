<?php
namespace application\controllers;

use application\models\Note;
use application\models\Category;
use ItForFree\SimpleMVC\Config;

class CategoryController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'main.php';
    
    /**
     * Просмотр статей по категории
     */
    public function viewAction()
    {
        $categoryId = $_GET['id'] ?? null;
        
        if (!$categoryId) {
            $this->redirect(Config::get('core.router.class')::link(''));
        }
        
        // Получаем категорию
        $categoryModel = new Category();
        $category = $categoryModel->getById($categoryId);
        
        if (!$category) {
            $this->view->addVar('message', 'Категория не найдена');
            $this->view->render('error.php');
            return;
        }
        
        // Получаем статьи этой категории
        $noteModel = new Note();
        $sql = "SELECT *
                FROM articles
                WHERE categoryId = :categoryId
                ORDER BY publicationDate DESC";
        $st = $noteModel->pdo->prepare($sql);
        $st->bindValue(":categoryId", (int)$categoryId, \PDO::PARAM_INT);
        $st->execute();
        $articles = $st->fetchAll(\PDO::FETCH_OBJ);

        
        $this->view->addVar('category', $category);
        $this->view->addVar('articles', $articles);
        $this->view->addVar('title', 'Категория: ' . $category->name);
        $this->view->render('category/view.php');
    }
    
    /**
     * Список всех категорий
     */
    public function listAction()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getList(100)['results'];
        
        $this->view->addVar('categories', $categories);
        $this->view->addVar('title', 'Все категории');
        $this->view->render('category/list.php');
    }
}