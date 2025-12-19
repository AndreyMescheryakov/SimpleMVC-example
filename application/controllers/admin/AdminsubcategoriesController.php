<?php
namespace application\controllers\admin;

use ItForFree\SimpleMVC\Config;
use application\models\Subcategory;
use application\models\Category;

class AdminSubcategoriesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'admin-main.php';
    
    protected array $rules = [ 
         ['allow' => true, 'roles' => ['admin']],
         ['allow' => false, 'roles' => ['?', '@']],
    ];
    
    /**
     * Список подкатегорий
     */
    public function indexAction()
    {
        $SubcategoryModel = new Subcategory();
        $subcategories = $SubcategoryModel->getList(100)['results'];
        
        // Добавляем названия категорий
        $CategoryModel = new Category();
        foreach ($subcategories as $subcat) {
            $subcat->categoryName = $SubcategoryModel->getCategoryNameForId($subcat->categoryId);
        }
        
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('title', 'Управление подкатегориями');
        $this->view->render('admin/subcategories/index.php');
    }

    /**
     * Добавление подкатегории
     */
public function addAction()
{
    $Url = Config::get('core.router.class');
    
    // Получаем список категорий для выпадающего списка
    $CategoryModel = new Category();
    $categories = $CategoryModel->getList(100)['results'];
    
    if (!empty($_POST)) {
        if (isset($_POST['saveSubcategory'])) {
            $SubcategoryModel = new Subcategory();
            $newSubcategory = $SubcategoryModel->loadFromArray($_POST);
            $newSubcategory->insert(); 
            $this->redirect($Url::link("admin/adminsubcategories/index"));
        } 
        elseif (isset($_POST['cancel'])) {
            $this->redirect($Url::link("admin/adminsubcategories/index"));
        }
    } else {
        $this->view->addVar('categories', $categories);
        $this->view->addVar('title', 'Добавление подкатегории');
        $this->view->addVar('action', 'add');
        $this->view->addVar('Url', $Url);
        $this->view->render('admin/subcategories/edit.php');
    }
}
    
    /**
     * Редактирование подкатегории
     */
    public function editAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        if (!$id) {
            $this->redirect($Url::link("admin/adminsubcategories/index"));
        }
        
        // Получаем список категорий для выпадающего списка
        $CategoryModel = new Category();
        $categories = $CategoryModel->getList(100)['results'];
        
        if (!empty($_POST)) {
            if (isset($_POST['saveSubcategory'])) {
                $SubcategoryModel = new Subcategory();
                $newSubcategory = $SubcategoryModel->loadFromArray($_POST);
                $newSubcategory->update();
                $this->redirect($Url::link("admin/adminsubcategories/index"));
            } 
            elseif (isset($_POST['cancel'])) {
                $this->redirect($Url::link("admin/adminsubcategories/index"));
            }
        } else {
            $SubcategoryModel = new Subcategory();
            $subcategory = $SubcategoryModel->getById($id);
            
            if (!$subcategory) {
                $this->redirect($Url::link("admin/adminsubcategories/index"));
            }
            
            $this->view->addVar('subcategory', $subcategory);
            $this->view->addVar('categories', $categories);
            $this->view->addVar('title', 'Редактирование подкатегории');
            $this->view->addVar('action', 'edit');
            $this->view->addVar('Url', $Url);
            $this->view->render('admin/subcategories/edit.php');   
        }
    }
    
    /**
     * Удаление подкатегории
     */
    public function deleteAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        if (!$id) {
            $this->redirect($Url::link("admin/adminsubcategories/index"));
        }
        
        if (!empty($_POST)) {
            if (isset($_POST['deleteSubcategory'])) {
                $SubcategoryModel = new Subcategory();
                $subcategory = $SubcategoryModel->getById($id);
                if ($subcategory) {
                    $subcategory->delete();
                }
                $this->redirect($Url::link("admin/adminsubcategories/index"));
            }
            elseif (isset($_POST['cancel'])) {
                $this->redirect($Url::link("admin/adminsubcategories/edit&id=$id"));
            }
        } else {
            $SubcategoryModel = new Subcategory();
            $subcategory = $SubcategoryModel->getById($id);
            
            if (!$subcategory) {
                $this->redirect($Url::link("admin/adminsubcategories/index"));
            }
            
            $this->view->addVar('subcategory', $subcategory);
            $this->view->addVar('title', 'Удаление подкатегории');
            $this->view->addVar('Url', $Url);
            $this->view->render('admin/subcategories/delete.php');
        }
    }
}