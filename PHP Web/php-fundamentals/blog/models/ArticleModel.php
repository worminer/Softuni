<?php
namespace Models;

class ArticleModel extends \MVC\Database\PdoMysql
{


    /**
     * @param int $author_id
     * @param string $title
     * @param string $content
     * @param array $categories
     * @return bool
     * @throws \Exception
     */

    public function createArticle(int $author_id, string $title, string $content, array $categories):bool
    {
        if (!isset($author_id) && !isset($title) && !isset($content)) {
            throw new \Exception("ERROR: ArticleModel->createArticle -> all parameters are Mandatory title={$title}, content={$content} <-");
        }

        $result = $this->prepare("INSERT INTO `articles`( `author_id`, `title`, `content`) VALUES (?,?,?)", [$author_id,$title,$content])->execute();

        if  (!$result->getAffectedRows()){
            throw new \Exception("Error:Something went wrong! Article was not saved in DB!");
        }

        $message = "";
        // inserting categories
        //probably it will be better to use transaction tho..
        foreach ($categories as $category){
            // inserting categories
            $result = $this->prepare("INSERT INTO `article_categories` (`article_id`, `category_id`) VALUES ((SELECT article_id FROM articles WHERE author_id=? ORDER BY article_id DESC limit 1), ?)", [$author_id,$category])->execute();
            if (!$result->getAffectedRows()) {
                $message .= "Something went wrong when adding categories {$category} for article title:{$title}<br>";
            }
        }

        if ($message != "") {
            throw new \Exception($message);
        }

        return true;
    }


    public function editArticle($title, $content, $article_id, array $categories):bool {
        $result = $this->prepare("UPDATE `articles` SET `title`=?,`content`=? WHERE `article_id`=?", [$title, $content, $article_id]);
        $result->execute();
        if (!$result->getAffectedRows()) {
            //throw new \Exception("Error: Article edit was not was not saved in DB!");
        }

        // get all categories for this article id
        $result = $this->prepare("SELECT category_id FROM article_categories WHERE article_id=?", [$article_id])->execute();
        $currentCategories = $result->fetchAllAssoc();
        // delete all categories for article id
        //$result = $this->prepare("DELETE FROM article_categories WHERE article_id=?", [$article_id])->execute();
        $categoriesToSave = array_filter($categories,function ($match) use ($currentCategories) {
            foreach ($currentCategories as $articleCategory) {
                if ($match == $articleCategory["category_id"]) {
                    return;
                }
            }
            return $match;
        });
        $categoriesToDelete = array_filter($currentCategories,function ($match) use ($categories) {
            foreach ($categories as $category) {
                if ($match["category_id"] == $category) {
                    return;
                }
            }
            return $match;
        });
        $message = "";
        // inserting categories
        //probably it will be better to use transaction tho..
        foreach ($categoriesToDelete as $category){
            // inserting categories
            //var_dump($categories);
            //var_dump($categoriesToDelete);
            $result = $this->prepare("DELETE FROM article_categories WHERE article_id=? and category_id=?", [$article_id,$category["category_id"]])->execute();
            if (!$result->getAffectedRows()) {
                $message .= "Something went wrong when deleting categories {$category} for article title:{$title}<br>";
            }
        }

        foreach ($categoriesToSave as $category){
            // inserting categories
            $result = $this->prepare("INSERT INTO `article_categories` (`article_id`, `category_id`) VALUES (?, ?)", [$article_id,$category])->execute();
            if (!$result->getAffectedRows()) {
                $message .= "Something went wrong when adding categories {$category} for article title:{$title}<br>";
            }
        }



        if ($message != "") {
            throw new \Exception($message);
        }
        return true;
    }

    public function deleteArticle($article_id){
        $result=$this->prepare("DELETE FROM `article_categories` WHERE `article_id`=?",[$article_id])->execute();
        $result=$this->prepare("DELETE FROM `articles` WHERE `article_id`=?",[$article_id])->execute();
        if  (!$result->getAffectedRows()){
            throw new \Exception("Error: Article was not edit in DB!");
        }
        return true;
    }

    public function getAuthorIdFromArticle($article_id):int {

        $result=$this->prepare("SELECT `author_id` FROM `articles` WHERE `article_id`=?",[$article_id]);
        $result->execute();

        if  (!$result->getAffectedRows()){
            throw new \Exception("Error: Article not exist in DB!");
        }
       return $result->fetchRllAssoc()['author_id'];
    }
    public function getArticlesLimit($limit){

        $result = $this->prepare("SELECT article_id,author_id,title,content,real_name,created_at FROM articles as a INNER JOIN users as u ON a.author_id=u.id ORDER BY created_at DESC LIMIT ? ",[$limit])->execute();

        if  (!$result->getAffectedRows()){
            throw new \Exception("Error: The request is not fulfilled!");
        }
        return  $result->fetchAllAssoc();
    }

    public function getAllArticles():array
    {
        $result = $this->prepare("SELECT article_id,author_id,title,content,real_name,created_at FROM articles as a INNER JOIN users as u ON a.author_id=u.id ORDER BY created_at DESC ")->execute();

        if  (!$result->getAffectedRows()){
            return [];
        }
        return  $result->fetchAllAssoc();
    }
    public  function getArticlesByCategoryId($categoryId){
        $result=$this->prepare("SELECT a.article_id,title,content,created_at,real_name FROM articles AS a 
                                JOIN article_categories AS ac ON a.article_id = ac.article_id 
                                JOIN users as u ON a.author_id=u.id  WHERE ac.category_id = ? ORDER BY created_at DESC ",[$categoryId])->execute();
        return $result->fetchAllAssoc();
    }

    public function getArticlesByAuthorId($author_id):array {
        $result=$this->prepare("SELECT article_id,author_id,title,content,real_name,created_at FROM articles as a INNER JOIN users as u ON a.author_id=u.id WHERE `author_id`=? ORDER BY created_at DESC ",[$author_id])->execute();
        return $result->fetchAllAssoc();
    }

    public function getArticleByArticleId($article_id):array {
        $result=$this->prepare("SELECT article_id,author_id,title,content,real_name,created_at FROM articles as a INNER JOIN users as u ON a.author_id=u.id WHERE `article_id`=?",[$article_id])->execute();
        $result = $result->fetchRllAssoc(); // this is just because it returns false or array and the interpreter gets the return type wrong
        if ($result === false) {
            throw new \Exception("Data for this article cant be found!");
        }
        return $result;
    }

    public function getAuthorNameById($author_id) {
        $result=$this->prepare("SELECT `username` FROM `users` WHERE `id`=?",[$author_id])->execute();
        return $result->fetchAllAssoc();
    }

    public function getArticleCategoriesByArticleId($article_id){
        $result=$this->prepare("SELECT category_id,name FROM article_categories as ac JOIN categories AS c 	ON ac.category_id=c.id WHERE ac.article_id=?",[$article_id])->execute();
        return $result->fetchAllAssoc();
    }

}