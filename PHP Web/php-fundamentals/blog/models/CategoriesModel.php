<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 3/8/2017
 * Time: 9:34 PM
 */

namespace Models;


use MVC\Database\PdoMysql;

class CategoriesModel extends PdoMysql
{
    public function getCategories():array {
        $result = $this->prepare('SELECT `id`, `name` FROM `categories`')->execute();
        return $result->fetchAllAssoc();
    }
    public function countArticlesInCategoryById($categoryId):int{
        $result = $this->prepare('SELECT id FROM article_categories WHERE category_id=?', [$categoryId])->execute();
        return count($result->fetchAllAssoc());
    }

    public function hasCategory(string $categoryName):bool{

        $result = $this->prepare('SELECT `id` FROM `categories` WHERE name=(?)', [$categoryName])->execute();
        if (!$result->fetchRllAssoc()) {
            return false;
        }
        return true;
    }

    public function deleteCategory(string $id)
    {
        $result = $this->prepare('DELETE FROM `article_categories` WHERE category_id=(?)', [$id])->execute();
        $result = $this->prepare('DELETE FROM `categories` WHERE id=(?)', [$id])->execute();
        return (bool) $result->getAffectedRows();
    }

    public function editCategory($categoryName, $id){
        $result = $this->prepare('UPDATE `categories` SET name = (?) WHERE id=(?)', [$categoryName, $id])->execute();

        return (bool) $result->getAffectedRows();
    }


    public function addNewCategory(string $categoryName):bool {
        $result = $this->prepare('INSERT INTO `categories` (`name`) VALUES (?)', [$categoryName])->execute();
        return (bool) $result->getAffectedRows();
    }

    public function existCategoryId(string $id):bool {
            $result = $this->prepare('SELECT `id` FROM `categories` WHERE id=(?)', [$id])->execute();
        if (!$result->fetchRllAssoc()) {
            return false;
        }
        return true ;
    }

    public function getCategoryNameById(int $id){
        $result = $this->prepare('SELECT `name` FROM `categories` WHERE id=(?)', [$id])->execute();
        return  $result->fetchRllAssoc()["name"];
    }

}