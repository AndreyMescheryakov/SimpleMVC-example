<?php
namespace application\controllers;

use application\models\Subcategory;
use application\models\Category;
use ItForFree\SimpleMVC\Config;

class SubcategoryController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'main.php';
    
    /**
     * Просмотр статей подкатегории
     */
    public function viewAction()
    {
        $subcategoryId = $_GET['id'] ?? null;
        
        if (!$subcategoryId) {
            $this->redirect(Config::get('core.router.class')::link(''));
        }
        
        $subcategoryModel = new Subcategory();
        $subcategory = $subcategoryModel->getById($subcategoryId);
        
        if (!$subcategory) {
            $this->view->addVar('message', 'Подкатегория не найдена');
            $this->view->render('error.php');
            return;
        }
        
        // Получаем статьи подкатегории
        $articles = $subcategory->getArticles();
        
        $this->view->addVar('subcategory', $subcategory);
        $this->view->addVar('articles', $articles);
        $this->view->addVar('title', 'Подкатегория: ' . $subcategory->name);
        $this->view->render('subcategory/view.php');
    }
    
    /**
     * Список подкатегорий по категории
     */
    public function listByCategoryAction()
    {
        $categoryId = $_GET['categoryId'] ?? null;
        
        if (!$categoryId) {
            $this->redirect(Config::get('core.router.class')::link('category/list'));
        }
        
        $categoryModel = new Category();
        $category = $categoryModel->getById($categoryId);
        
        if (!$category) {
            $this->view->addVar('message', 'Категория не найдена');
            $this->view->render('error.php');
            return;
        }
        
        // Получаем подкатегории этой категории
        $subcategoryModel = new Subcategory();
        $sql = "SELECT * FROM subcategories WHERE categoryId = :categoryId ORDER BY name";
        $st = $subcategoryModel->pdo->prepare($sql);
        $st->bindValue(":categoryId", $categoryId, \PDO::PARAM_INT);
        $st->execute();
        $subcategories = $st->fetchAll(\PDO::FETCH_OBJ);
        
        $this->view->addVar('category', $category);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('title', 'Подкатегории: ' . $category->name);
        $this->view->render('subcategory/list-by-category.php');
    }
    
    /**
     * Список всех подкатегорий с группировкой
     */
    public function listAllAction()
    {
        $subcategoryModel = new Subcategory();
        $categoryModel = new Category();
        
        // Получаем все категории с их подкатегориями
        $categories = $categoryModel->getList(100)['results'];
        
        foreach ($categories as $category) {
            $sql = "SELECT * FROM subcategories WHERE categoryId = :categoryId ORDER BY name";
            $st = $subcategoryModel->pdo->prepare($sql);
            $st->bindValue(":categoryId", $category->id, \PDO::PARAM_INT);
            $st->execute();
            $category->subcategories = $st->fetchAll(\PDO::FETCH_OBJ);
        }
        
        $this->view->addVar('categories', $categories);
        $this->view->addVar('title', 'Все подкатегории');
        $this->view->render('subcategory/list-all.php');
    }
}