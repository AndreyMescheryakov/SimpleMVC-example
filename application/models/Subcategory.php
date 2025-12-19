<?php
namespace application\models;

class Subcategory extends BaseExampleModel 
{
    public string $tableName = "subcategories";
    public string $orderBy = 'name ASC';
    
    public ?int $id = null;
    public $name = null;
    public $categoryId = null;
    
    // Метод для получения названия категории
    public function getCategoryName()
    {
        if ($this->categoryId) {
            $sql = "SELECT name FROM categories WHERE id = :id";
            $st = $this->pdo->prepare($sql);
            $st->bindValue(":id", $this->categoryId, \PDO::PARAM_INT);
            $st->execute();
            $row = $st->fetch();
            return $row ? $row['name'] : null;
        }
        return null;
    }

    // Метод для получения статей этой подкатегории
    public function getArticles()
    {
        $sql = "SELECT * 
                FROM articles 
                WHERE subcategoryId = :id 
                ORDER BY publicationDate DESC";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", (int)$this->id, \PDO::PARAM_INT);
        $st->execute();

        return $st->fetchAll(\PDO::FETCH_OBJ);
    }


    public function getCategoryNameForId($categoryId)
    {
        if (!$categoryId) return null;
        
        $sql = "SELECT name FROM categories WHERE id = :id";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", $categoryId, \PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();
        return $row ? $row['name'] : null;
    }

public function insert()
{
    $sql = "INSERT INTO $this->tableName (name, categoryId) VALUES (:name, :categoryId)"; 
    $st = $this->pdo->prepare($sql);
    $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
    $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);
    $st->execute();
    $this->id = $this->pdo->lastInsertId();
}

public function update()
{
    $sql = "UPDATE $this->tableName SET name = :name, categoryId = :categoryId WHERE id = :id";  
    $st = $this->pdo->prepare($sql);
    $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
    $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);
    $st->bindValue(":id", $this->id, \PDO::PARAM_INT);
    $st->execute();
}
}