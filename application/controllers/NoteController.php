<?php
namespace application\controllers;

use application\models\Note;
use ItForFree\SimpleMVC\Config;

class NoteController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'main.php';
    
    public function viewAction()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $this->redirect(Config::get('core.router.class')::link(''));
        }
        
        $noteModel = new Note();
        $article = $noteModel->getById($id);
        
        if (!$article) {
            // Статья не найдена
            $this->view->addVar('message', 'Статья не найдена');
            $this->view->render('error.php');
            return;
        }
        
        $this->view->addVar('viewNotes', $article);
        $this->view->render('note/view-item.php');
    }
}