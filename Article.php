<?php

class Article
{
    public $title;
    public $content;
    public $related_topics;
    public $id;

    function getId()
    {
        return $this->id;
    }

    function save()
    {
        $save = $GLOBALS['DB']->prepare("INSERT INTO articles (title, content) VALUES (:title, :content);");
        $save->execute([':title' => $this->title, ':content' => $this->content]);
        $this->id = $GLOBALS['DB']->lastInsertId();
        return $this->getId();
    }

    static function getAll()
    {
        // HAVE TO TAKE INTO ACCOUNT HOW TO HANDLE RELATED ARTICLES
        $returned_articles = $GLOBALS['DB']->query("SELECT * FROM articles;");
        if ($returned_articles) {
            $articles = $returned_articles->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article', ['title', 'content', 'related_topics', 'id']);
        } else {
            $articles = [];
        }
        return $articles;
    }

    static function getById($id)
    {
        $returned_article = $GLOBALS['DB']->query("SELECT * FROM articles WHERE id = {$id};");
        $article = $returned_article->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Article', ['title', 'content', 'id']);
        return $article[0];
    }
}

?>
