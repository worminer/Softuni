<?php
namespace Controllers;

use Models\ArticleModel;
use Models\CategoriesModel;
use MVC\DefaultController;

class Article extends DefaultController
{
    /* display createArticle article view */
    public function create()
    {
        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login","You have to be logged in to createArticle article!");
        }
        $categoriesModel = new CategoriesModel();
        try{
            $categories = $categoriesModel->getCategories();
            $this->view->render("article/createArticle",[
                "sub_title" => "Create New Article",
                "categories" => $categories,
            ]);
        }catch (\Exception $exception){
            $this->view->redirect("/article/myArticles",$exception->getMessage());
        }

    }

    /* create new article */
    public function createPost()
    {
        $input = $this->input;

        if ($input->post('createArticle') === null){
            $this->view->redirect("/article/create");
        }

        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You have to be logged in to createArticle article!");
        }
        $author_id = $this->auth->getCurrentUserId();

        $title = $input->post('title',"trim");
        $content = $input->post('content');

        if (empty($input->post('selected_categories')) || count($input->post('selected_categories')) == 0) {
            $this->view->redirect("/article/create","Article have to be in at least one categories!");
        }
        $categories = $input->post('selected_categories');


        $this->validate->setRule('minlength', $title , 5 , "Article title is to short!");
        $this->validate->setRule('minlength', $content , 10 , "Article content is to short!");

        if ($this->validate->validate() === false) {
            $errors = $this->validate->getErrors();
            $this->view->redirect("/article/create",$errors);
        }

        $articleModel = new ArticleModel();

        try{
            if ($articleModel->createArticle($author_id, $title, $content,$categories)) {
                $this->view->redirect("/article/myArticles", "Article Created Successfully.", "success");
            }
        }catch (\Exception $exception) {
            $errorMessage = $exception->getMessage();
            $this->view->redirect("/article/create", $errorMessage, "error");
        }
    }

    /* display editArticle view */
    public function edit(){
        $input = $this->input;
        if (empty($input->get(0,'int'))) {
            $this->view->redirect("/article/myArticles", "There is no such article!", "error");
        }

        $article_id = $input->get(0,"int");

        $articleModel = new ArticleModel();
        $categoriesModel = new CategoriesModel();

        try{
            $categories = $categoriesModel->getCategories();
            $articleCategories = $articleModel->getArticleCategoriesByArticleId($article_id);

            $categoriesNA = array_filter($categories,function ($match) use ($articleCategories) {
                foreach ($articleCategories as $articleCategory) {
                    if ($match['id'] == $articleCategory["category_id"]) {
                        return;
                    }
                }
                return $match;
            });

            $articleData = $articleModel->getArticleByArticleId($article_id);
            $this->view->render("article/editArticle",[
                    "article_id" => $article_id,
                    "title" => $articleData["title"],
                    "content" => $articleData["content"],
                    "categoriesNA" => $categoriesNA,
                    "categoriesAD" => $articleCategories,
                ]
            );
        }catch (\Exception $exception){
            $errorMessage = $exception->getMessage();
            $this->view->redirect("/article/myArticles", $errorMessage, "error");
        }


    }

    /* handles an article logic */
    public function editPost()
    {
        $input = $this->input;

        if ($input->post('editArticle') === null){
            $this->view->redirect("/article/myArticles");
        }

        if (empty($input->get(0,"int"))){
            $this->view->redirect("/article/myArticles", "There is no article id");
        }

        $articleID = $input->get(0,'int');

        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You cant edit an Article if you are not logged in!");
        }

        $title = $input->post('title',"trim");
        $content = $input->post('content');

        $categories = $input->post('selected_categories');

        $this->validate->setRule('numeric', $articleID , null , "Article id is not an valid id");
        $this->validate->setRule('minlength', $title , 5 , "Article title is to short!");
        $this->validate->setRule('minlength', $content , 10 , "Article content is to short!");

        if ($this->validate->validate() === false) {
            $errors = $this->validate->getErrors();
            $this->view->redirect("/article/edit/{$articleID}",$errors);
        }

        $user_id = $this->auth->getCurrentUserId();
        $articleModel = new ArticleModel();
        $articleAuthorId = null; // so it wont cry for it not been defined
        try{
            $articleAuthorId = $articleModel->getAuthorIdFromArticle($articleID);
        }catch (\Exception $exception){
            $errorMessage = $exception->getMessage();
            $this->view->redirect("/article/myArticles", $errorMessage , "error");
        }

        if ($articleAuthorId == $user_id) {
            try{

                if ($articleModel->editArticle($title, $content, $articleID,$categories)){
                    $this->view->redirect("/article/myArticles/{$articleID}", "Article Edited Successfully", "success");
                }

            }catch (\Exception $exception) {
                $errorMessage = $exception->getMessage();
                $this->view->redirect("/article/myArticles/{$articleID}", $errorMessage, "error");
            }
        }else{
            $this->view->redirect("/article/AllArticles", "Sorry you are not the author of this Article!");
        }

    }

    /* displays article delete view*/
    public function delete()
    {
        $input = $this->input;
        if (empty($input->get(0,"int"))){
            $this->view->redirect("/article/myArticles", "There is no article id!");
        }
        $articleID = $input->get(0,'int');

        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You cant delete an Article if you are not logged in!");
        }

        $articleModel = new ArticleModel();

        try{

            $articleData = $articleModel->getArticleByArticleId($articleID);
            $articleCategories =  $articleModel->getArticleCategoriesByArticleId($articleData["article_id"]);
            $articleData["categories_string"] = '';
            $counter = count($articleCategories);
            foreach ($articleCategories as $articleCategory) {
                $articleData["categories_string"] .=  $articleCategory["name"];
                if ($counter > 1) {
                    $articleData["categories_string"] .= ", ";
                }
                $counter--;
            }

            if ($articleData["categories_string"] == '') {
                $articleData["categories_string"] = 'There are categories for this article!';
            }


            $this->view->render("article/deleteArticle",[
                    "article_id" => $articleID,
                    "title" => $articleData["title"],
                    "content" => $articleData["content"],
                    "categories_string" => $articleData["categories_string"],
                ]
            );
        }catch (\Exception $exception){
            $errorMessage = $exception->getMessage();
            $this->view->redirect("/article/myArticles", $errorMessage, "error");
        }
    }

    /* handles article delete logic */
    public function deletePost()
    {
        $input = $this->input;

        if (empty($input->get(0,"int"))){
            $this->view->redirect("/article/myArticles", "There is no article id");
        }

        $articleID = $input->get(0,'int');

        if ($input->post('deleteArticle') === null) {
            $this->view->redirect("/article/myArticles");
        }

        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You cant delete an Article if you are not logged in!");
        }
        // new new
        $user_id = $this->auth->getCurrentUserId();
        $articleModel = new ArticleModel();
        $articleAuthorId = null; // so it wont cry for it not been defined
        try{
            $articleAuthorId = $articleModel->getAuthorIdFromArticle($articleID);
        }catch (\Exception $exception){
            $errorMessage = $exception->getMessage();
            $this->view->redirect("/article/myArticles", $errorMessage , "error");
        }

        if ($articleAuthorId == $user_id) {
            try{

                if ($articleModel->deleteArticle($articleID)) {
                    $this->view->redirect("/article/myArticles", "Article deleted Successfully.", "success");
                }

            }catch (\Exception $exception) {
                $errorMessage = $exception->getMessage();
                $this->view->redirect("/article/myArticles/{$articleID}", $errorMessage, "error");
            }
        }else{
            $this->view->redirect("/article/AllArticles", "Sorry you are not the author of this Article!");
        }
        // new new
    }

    /* displays articles written by the current user */
    public function myArticles(){
        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You cant view an article if you are not logged in!");
        }

        $author_id = $this->auth->getCurrentUserId();
        $articleModel = new ArticleModel();
        try{
            $articles = $articleModel->getArticlesByAuthorId($author_id);
            $articlesUpdated = [];
            foreach ($articles as $article) {
                $articleCategories =  $articleModel->getArticleCategoriesByArticleId($article["article_id"]);
                $article["categories_string"] = '';
                $counter = count($articleCategories);
                foreach ($articleCategories as $articleCategory) {
                    $article["categories_string"] .=  $articleCategory["name"];
                    if ($counter > 1) {
                        $article["categories_string"] .= ", ";
                    }
                    $counter--;
                }

                if ($article["categories_string"] == '') {
                    $article["categories_string"] = 'There are categories for this article!';
                }
                $articlesUpdated[] = $article;
            }
            $this->view->render("article/myArticles",[
                "articles" => $articlesUpdated,
            ]);
        }catch (\Exception $exception){
            $errorMessage = $exception->getMessage();
            $this->view->redirect("/home/index", $errorMessage, "error");
        }
    }

    /* displays all articles by all users */
    public function AllArticles(){
        $articleModel=new ArticleModel();

        try{
            $allArticles=$articleModel->getAllArticles();
            $articlesUpdated = [];
            foreach ($allArticles as $article) {
                $articleCategories =  $articleModel->getArticleCategoriesByArticleId($article["article_id"]);
                $article["categories_string"] = '';
                $counter = count($articleCategories);
                foreach ($articleCategories as $articleCategory) {
                    $article["categories_string"] .=  $articleCategory["name"];
                    if ($counter > 1) {
                        $article["categories_string"] .= ", ";
                    }
                    $counter--;
                }

                if ($article["categories_string"] == '') {
                    $article["categories_string"] = 'There are categories for this article!';
                }
                $articlesUpdated[] = $article;
            }

            $this->view->render("article/allArticles",[
                "allArticles"=>$articlesUpdated]
            );
        }catch (\Exception $exception){
            $errorMessage = $exception->getMessage();
            $this->view->redirect("/article/create", $errorMessage, "error");
        }

    }

    /* display article by id */
    public function articleId()
    {
        $input = $this->input;
        if (empty($input->get(0))){
            $this->view->redirect("/article/AllArticles", "There is no article id");
        }

        $articleID = $input->get(0,'int');
        if (empty($articleID)){
            $this->view->redirect("/article/AllArticles", "This is not an valid article id!");
        }

        $articleModel = new ArticleModel();
        try{
            $articleData = $articleModel->getArticleByArticleId($articleID);


            $articleCategories =  $articleModel->getArticleCategoriesByArticleId($articleData["article_id"]);
            $articleData["categories_string"] = '';
            $counter = count($articleCategories);
            foreach ($articleCategories as $articleCategory) {
                $articleData["categories_string"] .=  $articleCategory["name"];
                if ($counter > 1) {
                    $articleData["categories_string"] .= ", ";
                }
                $counter--;
            }

            if ($articleData["categories_string"] == '') {
                $articleData["categories_string"] = 'There are categories for this article!';
            }

            $this->view->render("/article/showArticle", ["result" => $articleData]);

        }catch (\Exception $exception){
            $errorMessage = $exception->getMessage();
            $this->view->redirect("/article/myArticles", $errorMessage, "error");
        }

    }
}
