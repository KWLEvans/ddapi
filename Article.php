<?php

class Article
{
    public $title;
    public $content;
    public $id;

    function getId()
    {
        return $this->id;
    }

    function getRelatedArticles()
    {
        $related_titles = array();
        $query = $GLOBALS['DB']->prepare("SELECT articles.title, articles.id FROM articles JOIN related_articles ON articles.id=related_articles.child_id WHERE related_articles.parent_id = :parent_id");
        $query->execute([":parent_id" => $this->id]);
        if (is_iterable($query)) {
            for ($i = 0; $i < count($query); $i++) {
                $related_titles[] = array($query[$i]['title'], $query[$i]['id']);
            }
        }
        return json_encode($related_titles);
    }

    function save()
    {
        $save = $GLOBALS['DB']->prepare("INSERT INTO articles (title, content) VALUES (:title, :content);");
        $save->execute([':title' => $this->title, ':content' => $this->content]);
        $this->id = $GLOBALS['DB']->lastInsertId();
        return $this->getId();
    }

    static function getAllTitles()
    {
        $all_titles = array();
        $query = $GLOBALS['DB']->query("SELECT title, id FROM articles");
        if (is_iterable($query)) {
            for ($i = 0; $i < count($query); $i++) {
                $all_titles[] = array($query[$i]['title'], $query[$i]['id']);
            }
        }
        return json_encode($all_titles);
    }
}

?>
