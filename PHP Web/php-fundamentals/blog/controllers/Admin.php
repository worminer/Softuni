<?php

namespace Controllers;

use Models\ArticleModel;
use Models\CategoriesModel;
use Models\UserModel;
use MVC\DefaultController;


class Admin extends DefaultController
{


    public function __construct()
    {
        parent::__construct();

        if (!$this->auth->isInRole('admin')) {
            $this->view->redirect("/user/login","You are not logged in as admin!!");
        }

    }

    public function showUsers(){

        $userModel = new UserModel();

        try{
            $usersList = $userModel->getAllUsers();
            foreach ($usersList as $key => $user){

                $userRoles = $userModel->getRolesById($user["id"]);
                $usersList[$key]["userRoles"] = $str = implode (", ", $userRoles);
            }
            $this->view->render("admin/users/showUsers",[
                'users' => $usersList
            ]);
        } catch (\Exception $exception){
            $this->view->redirect("/home/index",$exception->getMessage());
        }

    }
    public function showArticles(){
        $userModel = new UserModel();
        $articleModel = new ArticleModel();
        $allArticles = $articleModel->getAllArticles();
        $userData = $userModel->getUserData(1);

        foreach ($allArticles as $key => $article) {
            $userData = $userModel->getUserData($article["author_id"]);
            $allArticles[$key]["username"] = $userData['username'];
            $allArticles[$key]["real_name"] = $userData['real_name'];

        }
        try{

            $this->view->render("admin/articles/showArticles",[
                'articlesData' => $allArticles
            ]);
        } catch (\Exception $exception){
            $this->view->redirect("/home/index",$exception->getMessage());
        }

    }

    public function articleEdit(){
        $input = $this->input;
        if (empty($input->get(0,'int'))) {
            $this->view->redirect("/admin/showArticles", "There is no such article!", "error");
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
            $this->view->render("admin/articles/editArticle",[
                    "article_id" => $article_id,
                    "title" => $articleData["title"],
                    "content" => $articleData["content"],
                    "categoriesNA" => $categoriesNA,
                    "categoriesAD" => $articleCategories,
                ]
            );
        } catch (\Exception $exception){
            $this->view->redirect("/admin/showArticles",$exception->getMessage());
        }
    }

    /* handles an article logic */
    public function editArticlePost()
    {
        $input = $this->input;

        if ($input->post('editArticle') === null){
            $this->view->redirect("/admin/showArticles");
        }

        if (empty($input->get(0,"int"))){
            $this->view->redirect("/admin/showArticles", "There is no article id");
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
            $this->view->redirect("/admin/showArticles{$articleID}",$errors);
        }

        $articleModel = new ArticleModel();
        $articleAuthorId = null; // so it wont cry for it not been defined

        try{
            $articleAuthorId = $articleModel->getAuthorIdFromArticle($articleID);
            if ($articleModel->editArticle($title, $content, $articleID,$categories)){
                $this->view->redirect("/admin/showArticles", "Article Edited Successfully", "success");
            }

        }catch (\Exception $exception) {
            $errorMessage = $exception->getMessage();
            $this->view->redirect("/admin/showArticles", $errorMessage, "error");
        }


    }
    public function articleDelete(){
        $input = $this->input;
        if (empty($input->get(0,"int"))){
            $this->view->redirect("/admin/showArticles", "There is no article id!");
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


            $this->view->render("admin/articles/deleteArticle",[
                    "article_id" => $articleID,
                    "title" => $articleData["title"],
                    "content" => $articleData["content"],
                    "categories_string" => $articleData["categories_string"],
                ]
            );
        }catch (\Exception $exception){
            $errorMessage = $exception->getMessage();
            $this->view->redirect("/admin/showArticles", $errorMessage, "error");
        }
    }

    /* handles article delete logic */
    public function deleteArticlePost()
    {
        $input = $this->input;

        if (empty($input->get(0,"int"))){
            $this->view->redirect("/admin/showArticles", "There is no article id");
        }

        $articleID = $input->get(0,'int');

        if ($input->post('deleteArticle') === null) {
            $this->view->redirect("/admin/showArticles");
        }

        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You cant delete an Article if you are not logged in!");
        }


        $articleModel = new ArticleModel();
        try{

            if ($articleModel->deleteArticle($articleID)) {
                $this->view->redirect("/admin/showArticles", "Article deleted Successfully.", "success");
            }

        }catch (\Exception $exception) {
            $errorMessage = $exception->getMessage();
            $this->view->redirect("/admin/showArticles", $errorMessage, "error");
        }
    }

    public function editUser(){
        $this->view->render("/admin/users/edit");
    }
    public function deleteUser(){
        $input = $this->input;
        if (empty($input->get(0,'int'))){
            $this->view->redirect("admin/showUsers");
        }
        $userId = $input->get(0,'int');
        $userModel = new UserModel();

        try{
            $userData = $userModel->getUserData($userId);
            $userRoles = $userModel->getRolesById($userData["id"]);
            $userData["userRoles"] = $str = implode (", ", $userRoles);
            $this->view->render("/admin/users/delete",[
                'userData' => $userData
            ]);
        } catch (\Exception $exception){
            $this->view->redirect("/admin/showUsers",$exception->getMessage());
        }

    }
    public function deleteUserPost(){
        $input = $this->input;

        if (empty($input->get(0,'int'))){
            $this->view->redirect("/article/edit", "There is no article id");
        }

        $userId = $input->get(0,'int');

        if ($input->post('deleteUser') === null) {
            $this->view->redirect("/admin/showUsers");
        }

        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You cant delete an Article if you are not logged in!");
        }
        $userModel = new UserModel();
        try{
            if ($userModel ->deleteUserById($userId)) {
                $this->view->redirect("/admin/showUsers","User Deleted successfully.");
            } else {
                $this->view->redirect("/admin/showUsers", "Something went wrong with user Delete!");
            }
        } catch (\Exception $exception){
            $this->view->redirect("/admin/showUsers",$exception->getMessage());
        }

    }
    /* handle post and file for changing user profile picture */
    public function changeProfilePicForUserIdPost(){

        if (!$this->auth->isLogged()) {
            $this->view->redirect("/user/login", "You cant change your profile picture if you are not logged in!");
        }

        if (!isset($this->config->app['profile_image_upload_dir'])) {
            $this->view->redirect("/user/profile","ERROR: profile_image_upload_dir is not set !");
        }
        $target_dir = $this->config->app['profile_image_upload_dir'];

        if (!isset($this->config->app['profile_image_public_path'])) {
            $this->view->redirect("/user/profile","ERROR: profile_image_public_path is not set !");
        }
        $publicPath = $this->config->app['profile_image_public_path'];

        if (!isset($this->config->app['profile_image_min_size'])) {
            $this->view->redirect("/user/profile","ERROR: profile_image_min_size is not set !");
        }

        if (!isset($this->config->app['profile_image_max_size'])) {
            $this->view->redirect("/user/profile","ERROR: profile_image_max_size is not set !");
        }

        $input = $this->input;
        if ($input->file("image") === null) {
            $this->view->redirect("/admin/showUsers");
        }
        $fileInfo = $input->file("image");
        if ($fileInfo["size"] <= $this->config->app['profile_image_min_size']) {
            $this->view->redirect("/admin/showUsers", "Image size is to small! or it is bigger then server upload limit!");
        }

        if ($fileInfo["size"] > $this->config->app['profile_image_max_size']) {
            $this->view->redirect("/admin/showUsers", "Image size is to big!");
        }

        if ($input->post("change_profile_pic") == null) {
            $this->view->redirect("/admin/showUsers");
        }
        if ($input->post("user_id") == null) {
            $this->view->redirect("/admin/showUsers");
        }
        $currentUserId =$input->post("user_id");
            // Check if image file is a actual image or fake image
        $check = getimagesize($fileInfo["tmp_name"]);
        if($check === false) {
            $this->view->redirect("/admin/showUsers","This is not an image!!");
        }

        $imageFileType = pathinfo($fileInfo["name"],PATHINFO_EXTENSION);

        if ($fileInfo["size"] > $this->config->app['profile_image_formats']) {
            $this->view->redirect("/admin/showUsers", "Error: profile_image_formats is not set!");
        }
        // Allow certain file formats
        if (!in_array($imageFileType,$this->config->app['profile_image_formats'])) {
            $this->view->redirect("/admin/showUsers","File format {$imageFileType} is not allowed!");
        }

        $imageName = md5(uniqid('',true));
        $target_file = $target_dir . $imageName . '.' .$imageFileType;
        // Check if file already exists and change the name until its not
        while(file_exists($target_file)){
            $imageName = md5(uniqid('',true));
            $target_file = $target_dir . $imageName . '.' .$imageFileType;
        }

        $publicPath = $publicPath.$imageName.'.'.$imageFileType;

        try {
            move_uploaded_file($fileInfo["tmp_name"], $target_file);

            $userModel = new UserModel();
            if ($userModel->setUserProfilePic($currentUserId,$publicPath)) {
                $this->view->redirect("/admin/showUsers", "Profile picture updated successfully", "success");
            }
        }catch (\Exception $exception){
            $this->view->redirect("/admin/showUsers", $exception->getMessage(), "error");
        }


    }
}