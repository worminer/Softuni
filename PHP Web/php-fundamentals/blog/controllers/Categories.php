<?php
namespace Controllers;

use Models\ArticleModel;
use Models\CategoriesModel;
use MVC\DefaultController;

class Categories extends DefaultController
{
    /* Displays the view for manageing all categories */
    public function manage()
    {
        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You can not manage categories if you are not logged in!");
        }

        if (!$this->auth->isInRole("admin")) {
            $this->view->redirect("/user/login", "You can not manage categories if you are not Admin!");
        }

        $categoryModel = new CategoriesModel();
        try{
            $categories = $categoryModel->getCategories();
            $this->view->render("admin/categories/manage",["categories"=> $categories]);
        }catch (\Exception $exception){
            $this->view->redirect("/user/login/",$exception->getMessage());
        }

    }

    public function showCategoryId(){
        if (empty($this->input->get(0,"int"))){
            $this->view->redirect("/categories/manage");
        }

        $categoryId = $this->input->get(0,"int");
        $articlesModel = new ArticleModel();
        $categoriesModel = new CategoriesModel();

        try{
            $categoryArticles = $articlesModel->getArticlesByCategoryId($categoryId);

            foreach ($categoryArticles as $key => $categoryArticle) {

                $articleCategories = $articlesModel->getArticleCategoriesByArticleId($categoryArticle['article_id']);
                $categoryString = '';
                $counter = count($articleCategories);
                foreach ($articleCategories as $articleCategory) {
                    $categoryString .=  $articleCategory["name"];
                    if ($counter > 1) {
                        $categoryString .= ", ";
                    }
                    $counter--;
                }

                if ($categoryString == '') {
                    $categoryString = 'There are categories for this article!';
                }
                $categoryArticles[$key]['categories_string'] = $categoryString;
            }
            //var_dump($categoryArticles);
            $this->view->render("/categories/allArticlesInCategory",[
                    "allArticlesInCategory" => $categoryArticles
                ]
            );

        }catch (\Exception $exception){
            $this->view->redirect("/home/index", $exception->getMessage());
        }

    }
    /* handles adding new categories */
    public function addPost(){

        if ($this->input->post("category_create") === null){
            $this->view->redirect("/categories/manage");
        }

        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You can not add new categories if you are not logged in!");
        }

        if (!$this->auth->isInRole("admin")) {
            $this->view->redirect("/user/login", "You can not manage categories if you are not Admin!");
        }

        $categoryName = $this->input->post("category_name");

        $this->validate->setRule("minlength",$categoryName,3, "Category name length must be more then 3 symbols!");

        if ($this->validate->validate() === false){
            $error = $this->validate->getErrors();
            $this->view->redirect("/categories/manage",$error);
        }

        $categoryModel = new CategoriesModel();
        try{
            if ($categoryModel->hasCategory($categoryName)){
                $this->view->redirect("/categories/manage","This categories already exist!");
            }

            if($categoryModel->addNewCategory($categoryName)){
                $this->view->redirect("/categories/manage","Category created successfully!","success");
            }
        }catch (\Exception $exception){
            $this->view->redirect("/categories/manage",$exception);
        }
    }
    /* display the delete categories by id form */
    public function delete()
    {
        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You can not manage categories if you are not logged in!");
        }
        if (!$this->auth->isInRole("admin")) {
            $this->view->redirect("/user/login", "You can not manage categories if you are not Admin!");
        }

        if (empty($this->input->get(0,"int"))){
            $this->view->redirect("/categories/manage");
        }

        $categoryId = $this->input->get(0,"int");

        $categoryModel = new CategoriesModel();

        if (!$categoryModel->existCategoryId($categoryId)){
            $this->view->redirect("/categories/manage","This categories do not exist!");
        }

        try{
            $categoryName = $categoryModel->getCategoryNameById($categoryId);

            $this->view->render("admin/categories/delete",[
                    "name"=> $categoryName,
                    "id"=> $categoryId
                ]
            );
        }catch (\Exception $exception) {
            $this->view->redirect("/categories/manage", $exception->getMessage());
        }

    }

    /* handles the delete post logic */
    public function deletePost(){

        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You can not add new categories if you are not logged in!");
        }

        if (!$this->auth->isInRole("admin")) {
            $this->view->redirect("/user/login", "You can not manage categories if you are not Admin!");
        }

        if ($this->input->post("delete_category") === null){
            $this->view->redirect("/categories/manage");
        }

        if (empty($this->input->get(0,"int"))){
            $this->view->redirect("/categories/manage");
        }

        $categoryId = $this->input->get(0,"int");

        $categoryModel = new CategoriesModel();
        try{
            if (!$categoryModel->existCategoryId($categoryId)){
                $this->view->redirect("/categories/manage","This categories do not exist!");
            }
            if ($categoryModel->deleteCategory($categoryId)){
                $this->view->redirect("/categories/manage","Category deleted successfully!","success");
            }
        } catch (\Exception $exception) {
            $this->view->redirect("/categories/manage", $exception->getMessage());
        }
    }



    /* Display Edit form for categories */
    public function edit()
    {
        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You can not manage categories if you are not logged in!");
        }
        if (!$this->auth->isInRole("admin")) {
            $this->view->redirect("/user/login", "You can not manage categories if you are not Admin!");
        }

        if (empty($this->input->get(0,"int"))){
            $this->view->redirect("/categories/manage");
        }

        $categoryId = $this->input->get(0,"int");

        $categoryModel = new CategoriesModel();
        try{

            if (!$categoryModel->existCategoryId($categoryId)){
                $this->view->redirect("/categories/manage","This categories do not exist!");
            }
            $categoryName = $categoryModel->getCategoryNameById($categoryId);

            $this->view->render("admin/categories/edit",[
                    "name"=> $categoryName,
                    "id"=> $categoryId
                ]
            );

        } catch (\Exception $exception){
            $this->view->redirect("/categories/manage",$exception->getMessage());
        }

    }

    /* Handle the post from the edit form */
    public function editPost()
    {
        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You can not add new categories if you are not logged in!");
        }

        if (!$this->auth->isInRole("admin")) {
            $this->view->redirect("/user/login", "You can not manage categories if you are not Admin!");
        }

        if ($this->input->post("edit_category") === null){
            $this->view->redirect("/categories/manage");
        }

        if (empty($this->input->get(0,"int"))){
            $this->view->redirect("/categories/manage");
        }

        $categoryId = $this->input->get(0,"int");

        $categoryName = $this->input->post("name");

        $categoryModel = new CategoriesModel();

        try{
            if (!$categoryModel->existCategoryId($categoryId)){
                $this->view->redirect("/categories/manage","This categories do not exist!");
            }

            if ($categoryModel->editCategory($categoryName, $categoryId)){
                $this->view->redirect("/categories/manage","Category edited successfully!","success");
            } else {
                $this->view->redirect("/categories/manage","You did not change anything ?");
            }

        }catch (\Exception $exception) {
            $this->view->redirect("/categories/manage", $exception->getMessage());
        }
    }

}
