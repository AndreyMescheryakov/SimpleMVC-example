<?php
namespace application\controllers\admin;

use ItForFree\SimpleMVC\Config;
use application\models\Category;

/**
 * Администрирование категорий
 */
class AdminCategoriesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'admin-main.php';
    
    protected array $rules = [ 
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => false, 'roles' => ['?', '@']],
    ];
    
    /**
     * Список категорий
     */
    public function indexAction()
    {
        $CategoryModel = new Category();
        $categories = $CategoryModel->getList(100)['results'];
        
        $this->view->addVar('categories', $categories);
        $this->view->addVar('title', 'Управление категориями');
        $this->view->render('admin/categories/index.php');
    }

    /**
     * Добавление категории
     */
public function addAction()
{
    $Url = Config::get('core.router.class');
    
    if (!empty($_POST)) {
        if (isset($_POST['saveCategory'])) {
            $CategoryModel = new Category();
            $newCategory = $CategoryModel->loadFromArray($_POST);
            $newCategory->insert(); 
            $this->redirect($Url::link("admin/admincategories/index"));
        } 
        elseif (isset($_POST['cancel'])) {
            $this->redirect($Url::link("admin/admincategories/index"));
        }
    } else {
        $this->view->addVar('title', 'Добавление категории');
        $this->view->addVar('action', 'add');
        $this->view->addVar('Url', $Url);
        $this->view->render('admin/categories/edit.php');
    }
}
    
    /**
     * Редактирование категории
     */
    public function editAction()
    {  
    $id = $_GET['id'] ?? null;
    $Url = Config::get('core.router.class');

        if (!$id) {
            $this->redirect($Url::link("admin/admincategories/index"));
        }
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveCategory'])) {
                $CategoryModel = new Category();
                $newCategory = $CategoryModel->loadFromArray($_POST);
                $newCategory->update();
                $this->redirect($Url::link("admin/admincategories/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/admincategories/index"));
            }
        } else {
            $CategoryModel = new Category();
            $category = $CategoryModel->getById($id);
            
            if (!$category) {
                $this->redirect($Url::link("admin/admincategories/index"));
            }
            
            $this->view->addVar('category', $category);
            $this->view->addVar('title', 'Редактирование категории');
            $this->view->addVar('action', 'edit');
            $this->view->render('admin/categories/edit.php');   
        }
    }
    
    /**
     * Удаление категории
     */
    public function deleteAction()
{   
    $id = $_GET['id'] ?? null;
    $Url = Config::get('core.router.class');
    
    if (!empty($_POST)) {
        echo "POST данные:\n";
        print_r($_POST);
        
        if (isset($_POST['deleteCategory'])) {
            echo "\n--- Удаление категории ---\n";
            
            $CategoryModel = new Category();
            $category = $CategoryModel->getById($id);
            
            if ($category) {
                echo "Категория найдена: " . ($category->name ?? 'NULL') . "\n";
                echo "Вызываю delete()...\n";
                $category->delete();
                echo "delete() выполнен\n";
            } else {
                echo "Категория не найдена!\n";
            }
            
            echo "</pre>";
            $this->redirect($Url::link("admin/admincategories/index"));
            return;
        }
        elseif (isset($_POST['cancel'])) {
            echo "Отмена удаления\n</pre>";
            $this->redirect($Url::link("admin/admincategories/edit&id=$id"));
            return;
        }
    }
    
    echo "Показ формы подтверждения удаления\n";
    
    $CategoryModel = new Category();
    $category = $CategoryModel->getById($id);
    
    if (!$category) {
        echo "Категория не найдена, редирект\n</pre>";
        $this->redirect($Url::link("admin/admincategories/index"));
        return;
    }
    
    echo "Категория для удаления: " . ($category->name ?? 'NULL') . "\n</pre>";
    
    $this->view->addVar('category', $category);
    $this->view->addVar('title', 'Удаление категории');
    $this->view->addVar('Url', $Url);
    $this->view->render('admin/categories/delete.php');
}
}