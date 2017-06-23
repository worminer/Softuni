<?php

namespace Controllers;

use Models\UserModel;
use MVC\DefaultController;

class User extends DefaultController
{

    /* login functionality */

    /* display the login form */
    public function login(){
        // this will display the user login form
        $this->view->render("user/login");
    }

    /* handle the login post request */
    public function loginPost(){
        $input = $this->input; // we get the input array that contains all the get and post params

        // checking for login parameter in post request ..
        // if there is no such param that means that the wrong form was send or someone access the /user /registerPost url!
        // that means, we have to redirect the user to the login form
        if ($input->post("login") == null) {
            $this->view->redirect("/user/login");
        }

        $email = $input->post('email'); // get the email from  post request
        $password = $input->post('password'); // get the password from post request

        // check if the email is a valid email
        $this->validate->setRule('email', $email , null , "This is not an valid Email!");
        // check if password is more then 6 symbols
        $this->validate->setRule('minlength', $password , 6 , "Password must be more then 6 symbols!");

        // validate all filters and if there is an error .. we have to redirect and display the errors
        if ($this->validate->validate() === false) {
            $errors = $this->validate->getErrors();
            $this->view->redirect("/user/login",$errors);
        }

        //if we are at this point of the code .. this means that everything is ok with our form information and we can register out user

        // to register the user we need an instance of UserModel
        $userModel = new \Models\UserModel();

        // we check if there is user with that username in database. If there is one we need to redirect to register form and display the error
        if (!$userModel->userExist($email)) {
            $error = "There is no such user registered!";
            $this->view->redirect("/user/login",$error);
        }

        // if we are here in the code.. that means that there is no reason not to login the user .. so we do it :)

        // and we register the user FINALLY!!!
        // if everything is ok with the registration we redirect the user to the login page

        try{
            if ($userModel->authenticate($email,$password)) {
                $this->view->redirect("/user/profile");
            }
        }catch (\Exception $exception){
            // if there is a problem with the login we log the message and redirect to the registration page
            $message = $exception->getMessage();
            $this->view->redirect("/user/login",$message);
        }
    }

    /* register functionality */

    /* display registration form */
    public function register(){
        // this will display the user login form
        $this->view->render("user/register");
    }

    /* handle the registration post request */
    public function registerPost(){

        $input = $this->input; // we get the input array that contains all the get and post params

        // checking for register parameter in post request..
        // if there is no such param that means that the wrong form was send or someone access the /user /registerPost url!
        // that means, we have to redirect the user to the register form
        if ($input->post("register") == null) {
            $this->view->redirect("/user/register");
        }

        $email = $input->post('email'); // get the email from  post
        $realName = $input->post('real_name'); // get the email from
        $password1 = $input->post('password'); // get the password 1 from post
        $password2 = $input->post('password2'); // get the password 2 from post

        // check if the email is a valid email
        $this->validate->setRule('email', $email , null , "This is not an valid Email!");
        // check if password1 matches password2 are the same
        $this->validate->setRule('matches', $password1 ,$password2, "Passwords are not the same!");
        // check if password is more then 6 symbols
        $this->validate->setRule('minlength', $password1 , 6 , "Password must be more then 6 symbols!");
        $this->validate->setRule('minlength', $realName , 3 ,  "Your name bust be more then 3 symbols!");
        $this->validate->setRule('maxlength', $realName , 50 , "Your name can not be more then 50 symbols!");

        // validate all filters and if there is an error .. we have to redirect and display the errors
        if ($this->validate->validate() === false) {
            $errors = $this->validate->getErrors();
            $this->view->redirect("/user/register",$errors);
        }

        //if we are at this point of the code .. this means that everything is ok with our form information and we can register our user

        // to register the user we need an instance of UserModel
        $userModel = new \Models\UserModel();

        // we check if there is user with that username in database. If there is one we need to redirect to register form and display the error
        if ($userModel->userExist($email)) {
            $error = "User with that name already exist!";
            $this->view->redirect("/user/register",$error);
        }

        // if we are here in the code.. that means that there is no reason not to register the user .. so we do it :)
        // if everything is ok with the registration we redirect the user to the login page

        try{
            if ($userModel->tryRegisterUser($email,$email,$password1,$realName)) {
                $messageSuccess = "Registration completed successful.";
                $this->view->redirect("/user/login",$messageSuccess, "success");
            }
        }catch (\Exception $exception){
            // if there is a problem with the registration we log the message and redirect to the registration page
            $message = $exception->getMessage();
            $this->view->redirect("/user/register",$message);
        }
    }

    /* display user profile */
    public function profile(){
        $user_id = $this->auth->getCurrentUserId();
        $userModel = new \Models\UserModel();
        try{
            $userData = $userModel->getUserData($user_id);
            $userRoles =$userModel->getRoles();

            $this->view->render("/user/profile",[
                "userData" => $userData,
                "userRoles"=> $userRoles,
            ]);

        }catch (\Exception $exception){
            $this->view->redirect("/",$exception->getMessage());
        }


    }

    /* handle post and file for changing user profile picture */
    public function changeProfilePicPost(){

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
            $this->view->redirect("/user/profile");
        }
        $fileInfo = $input->file("image");
        if ($fileInfo["size"] <= $this->config->app['profile_image_min_size']) {
            $this->view->redirect("/user/profile", "Image size is to small! or it is bigger then server upload limit!");
        }

        if ($fileInfo["size"] > $this->config->app['profile_image_max_size']) {
            $this->view->redirect("/user/profile", "Image size is to big!");
        }

        if ($input->post("change_profile_pic") == null) {
            $this->view->redirect("/user/profile");
        }

        // Check if image file is a actual image or fake image
        $check = getimagesize($fileInfo["tmp_name"]);
        if($check === false) {
            $this->view->redirect("/user/profile","This is not an image!!");
        }

        $imageFileType = pathinfo($fileInfo["name"],PATHINFO_EXTENSION);

        if ($fileInfo["size"] > $this->config->app['profile_image_formats']) {
            $this->view->redirect("/user/profile", "Error: profile_image_formats is not set!");
        }
        // Allow certain file formats
        if (!in_array($imageFileType,$this->config->app['profile_image_formats'])) {
            $this->view->redirect("/user/profile","File format {$imageFileType} is not allowed!");
        }

        $imageName = md5(uniqid('',true));
        $target_file = $target_dir . $imageName . '.' .$imageFileType;
        // Check if file already exists and change the name until its not
        while(file_exists($target_file)){
            $imageName = md5(uniqid('',true));
            $target_file = $target_dir . $imageName . '.' .$imageFileType;
        }

        $publicPath = $publicPath.$imageName.'.'.$imageFileType;
        $currentUserId = $this->auth->getCurrentUserId();
        try {
            $target_file = str_replace('/',DIRECTORY_SEPARATOR,$target_file);
            $target_file = str_replace('\\',DIRECTORY_SEPARATOR,$target_file);
            move_uploaded_file($fileInfo["tmp_name"], $target_file);
            $userModel = new UserModel();
            if ($userModel->setUserProfilePic($currentUserId,$publicPath)) {
                $this->view->redirect("/user/profile", "Profile picture updated successfully", "success");
            }
        }catch (\Exception $exception){
            $this->view->redirect("/user/profile", $exception->getMessage(), "error");
        }


    }

    /* loging out logic */
    public function logOut(){
        // to register the user we need an instance of UserModel
        $userModel = new \Models\UserModel();
        $userModel->logOut();
        // this will display the user login form
        $this->view->redirect("/user/login","You logged out successfully.","success");
    }
}