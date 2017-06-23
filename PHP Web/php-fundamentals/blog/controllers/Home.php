<?php

namespace Controllers;


use Models\ArticleModel;
use Models\CategoriesModel;
use Models\UserModel;
use MVC\DefaultController;


class Home extends DefaultController
{
    public function index(){
        $categoryModel = new CategoriesModel();
        $articleModel = new ArticleModel();
        $userModel = new UserModel();
        try{
            $categories = $categoryModel->getCategories();
            foreach ($categories as $key => $category) {

                $categories[$key]["articlesCount"] = $categoryModel->countArticlesInCategoryById($category['id']);
            }
            $articles = $articleModel->getArticlesLimit('5');

            foreach ($articles as $key => $article){
                $userData = $userModel->getUserData($article["author_id"]);
                $articles[$key]["username"] = $userData["username"];
                $articles[$key]["real_name"] = $userData["real_name"];
                $articles[$key]["profile_pic"] = $userData["profile_pic"];
            }

            $fistArticle = array_shift($articles);
            // this is the default index so this will display the homepage
            $this->view->render("home/index",[
                "categoryInfo" => $categories,
                "lastArticles" => $articles,
                "firstArticle" => $fistArticle
            ]);
        }catch (\Exception $exception){
            $this->view->render("home/index",[]);
        }
    }
}