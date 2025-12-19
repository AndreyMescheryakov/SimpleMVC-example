<?php

namespace application\models;

class Note extends BaseExampleModel
{
    public string $tableName = "articles";

    public string $orderBy = 'publicationDate DESC';

    public ?int $id = null;

    public ?string $title = null;
    public ?string $summary = null;
    public ?string $content = null;

    public $publicationDate = null;

    public ?int $categoryId = null;
    public ?int $subcategoryId = null;

    public int $active = 1;

    public ?string $categoryName = null;
    public ?string $subcategoryName = null;
    public array $authors = [];

    public function insert()
    {
        if (empty($this->categoryId)) {
            $this->categoryId = 1;
        }

        $sql = "INSERT INTO {$this->tableName}
                (publicationDate, categoryId, subcategoryId, title, summary, content, active)
                VALUES
                (:publicationDate, :categoryId, :subcategoryId, :title, :summary, :content, :active)";

        $st = $this->pdo->prepare($sql);

        // DATE: YYYY-MM-DD
        $st->bindValue(":publicationDate", (new \DateTime('NOW'))->format('Y-m-d'), \PDO::PARAM_STR);

        $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);

        if ($this->subcategoryId === null || $this->subcategoryId === 0) {
            $st->bindValue(":subcategoryId", null, \PDO::PARAM_NULL);
        } else {
            $st->bindValue(":subcategoryId", $this->subcategoryId, \PDO::PARAM_INT);
        }

        $st->bindValue(":title", $this->title, \PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary ?? '', \PDO::PARAM_STR);
        $st->bindValue(":content", $this->content ?? '', \PDO::PARAM_STR);
        $st->bindValue(":active", (int)$this->active, \PDO::PARAM_INT);

        $st->execute();
        $this->id = (int)$this->pdo->lastInsertId();
    }

    public function update()
    {
        $sql = "UPDATE {$this->tableName} SET
                    publicationDate = :publicationDate,
                    categoryId = :categoryId,
                    subcategoryId = :subcategoryId,
                    title = :title,
                    summary = :summary,
                    content = :content,
                    active = :active
                WHERE id = :id";

        $st = $this->pdo->prepare($sql);

        $st->bindValue(":publicationDate", (new \DateTime('NOW'))->format('Y-m-d'), \PDO::PARAM_STR);
        $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);

        if ($this->subcategoryId === null || $this->subcategoryId === 0) {
            $st->bindValue(":subcategoryId", null, \PDO::PARAM_NULL);
        } else {
            $st->bindValue(":subcategoryId", $this->subcategoryId, \PDO::PARAM_INT);
        }

        $st->bindValue(":title", $this->title, \PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary ?? '', \PDO::PARAM_STR);
        $st->bindValue(":content", $this->content ?? '', \PDO::PARAM_STR);
        $st->bindValue(":active", (int)$this->active, \PDO::PARAM_INT);
        $st->bindValue(":id", (int)$this->id, \PDO::PARAM_INT);

        $st->execute();
    }

    public function getCategoryNameForId($categoryId): ?string
    {
        if (!$categoryId) return null;

        $sql = "SELECT name FROM categories WHERE id = :id";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", (int)$categoryId, \PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch(\PDO::FETCH_ASSOC);

        return $row ? $row['name'] : null;
    }

    public function getSubcategoryNameForId($subcategoryId): ?string
    {
        if (!$subcategoryId) return null;

        $sql = "SELECT name FROM subcategories WHERE id = :id";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", (int)$subcategoryId, \PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch(\PDO::FETCH_ASSOC);

        return $row ? $row['name'] : null;
    }

    public function getAuthorsForArticle(int $articleId): array
    {
        $sql = "SELECT u.*
                FROM users u
                JOIN article_users au ON u.id = au.user_id
                WHERE au.article_id = :article_id
                ORDER BY u.login";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":article_id", $articleId, \PDO::PARAM_INT);
        $st->execute();

        return $st->fetchAll(\PDO::FETCH_OBJ);
    }

    public function addAuthor(int $userId): bool
    {
        $sql = "INSERT IGNORE INTO article_users (article_id, user_id)
                VALUES (:article_id, :user_id)";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":article_id", (int)$this->id, \PDO::PARAM_INT);
        $st->bindValue(":user_id", $userId, \PDO::PARAM_INT);

        return $st->execute();
    }

    public function removeAuthor(int $userId): bool
    {
        $sql = "DELETE FROM article_users
                WHERE article_id = :article_id AND user_id = :user_id";

        $st = $this->pdo->prepare($sql);
        $st->bindValue(":article_id", (int)$this->id, \PDO::PARAM_INT);
        $st->bindValue(":user_id", $userId, \PDO::PARAM_INT);

        return $st->execute();
    }
}
