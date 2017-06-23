<?php

namespace Models;


use MVC\Crypt;

class UserModel extends \MVC\Auth
{
    /**
     * @var Crypt
     * holds an instance of Crypt
     */
    public $crypt;

    /**
     * @param string $username
     * @param string $password
     * @return bool
     * @throws \Exception
     * checks if the password matches for this user
     */
    public function authenticate(string $username, string $password):bool {
        if (!isset($username) || !isset($password)) {
            throw new \Exception("Error: Usermodel->Authenticate-> you did not set Username or Password");
        }
        $result = $this ->prepare("SELECT pass_hash,pass_salt FROM users WHERE username=?",[$username]) // make a prepared statement
        ->execute(); // and after that this needs to be executed so you can receive the result if there is any
        // after that we need to get the results from the PDO return so we do fetchRllAssoc() ..
        // this will return the fist result or false if there are no results
        // if there are no result, we return false
        if ($result === false) {
            // you should never come here because there is a check if the user exist before that.. but better be save then sorry
            throw new \Exception("Error:There is no such user in Database..");
            //$this->setErrorMessage("Error:There is no such user in Database..");
            //return false;
        }

        $result = $result->fetchRllAssoc(); // getting the result

        $passSalt = $result["pass_salt"]; // salt from database
        $passHash = $result["pass_hash"]; // password hash from database


        //var_dump(password_verify($password,$passHash));
        if (!password_verify($password,$passHash)) {
            throw new \Exception("Password does not match!");
            //$this->setErrorMessage("Password does not match!");
            //return false;
        }

        // createArticle unique token to identify user
        $sessionToken = $this->getCrypt()->getNewSalt().$this->getCrypt()->getNewSalt();


        $sessionLifeTime = time() + $this->getSession()->getLifeTime();

        // try save it to DB
        $result = $this->prepare("UPDATE `users` SET `session_token`=?,`session_token_expire`=? WHERE username=?",
            [$sessionToken,$sessionLifeTime,$username])->execute();

        // if db change is not successful we return an error
        if (!(bool)$result->getAffectedRows()) {
            throw new \Exception("Something went wrong with DB! .. session token did not get saved!");
            //$this->setErrorMessage("Something went wrong with DB! .. session token did not get saved!");
            //return false;
        }
        // if everything is ok we save the same token in session
        $this->getSession()->AuthToken = $sessionToken;

        return true;
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @return bool
     * @throws \Exception
     */
    public function tryRegisterUser(string $username, string $email, string $password, string $realName):bool{

        if (!isset($username) || !isset($email) && !isset($passwordHash) && !isset($salt)) {
            throw new \Exception("ERROR: tryRegisterUser -> all parameters are Mandatory user={$username}, email={$email}, password={$password} <-");
        }

        //  createArticle Salt for the user password .. this makes it more unique
        $salt = $this->getCrypt()->getNewSalt();
        // hashing the password by using the salt ..
        $passwordHash = $this->getCrypt()->getHash($password,$salt);

        $result = $this->prepare("INSERT INTO `users` (`username`, `email`, `pass_hash`, `pass_salt`,`real_name`) VALUES (?, ?, ?, ?, ?)",[$username, $email, $passwordHash, $salt,$realName])->execute();

        // if that failed .. throw exception
        if (!$result->getAffectedRows()) {
            throw new \Exception("Something went wrong with registration process!!");
        }

        // inserting roles
        $result = $this->prepare("INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES ((SELECT users.id FROM users WHERE username=?), (SELECT roles.id FROM roles WHERE role_name='user'))", [$username])->execute();

        // if that failed .. throw exception
        if (!$result->getAffectedRows()) {
            throw new \Exception("Something went wrong.. could not set role 'user' for user {$username}");
        }
        // or just return true ..
        return (bool) $result->getAffectedRows();
    }

    public function getUserData($id) {
        $result = $this->prepare("SELECT id,username,real_name,email,creation_date,profile_pic FROM users WHERE id=?", [$id])->execute();
        $return = $result->fetchRllAssoc();
        if ($return === false) {
            throw new \Exception("There is no such id!");
        }
        return $return ;
    }
    public function setUserProfilePic($id,$path) {
        $result = $this->prepare("UPDATE `users` SET profile_pic=? WHERE id=?", [$path,$id])->execute();

        // if that failed .. throw exception
        if (!$result->getAffectedRows()) {
            throw new \Exception("Something went wrong.. could not set profile pic url");
        }
        // or just return true ..
        return (bool) $result->getAffectedRows();
    }

    public function getAllUsers():array {
        $result = $this->prepare("SELECT id,username,real_name,email,creation_date,profile_pic FROM users ORDER BY creation_date DESC ", [])->execute();

        return $result->fetchAllAssoc() ;
    }
    private function getCrypt() {
        if ($this->crypt === null) {
            $this->crypt    = \MVC\Crypt::getInstance();
        }
        return $this->crypt;
    }

    public function getRolesById($id){

        $result = $this->prepare('Select role_name FROM user_roles AS ur Join roles AS r ON ur.role_id=r.id WHERE ur.user_id=?', [$id])->execute();
        $result = $result->fetchAllAssoc();
        if (count($result) == 0) {
            return [];
        }
        $userRoles = [];
        foreach ($result as $resultArr){
            $userRoles[] =$resultArr["role_name"] ;
        }
        return $userRoles;

    }
    public function deleteUserById($userId){
        $result = $this->prepare(' DELETE FROM user_roles WHERE user_id=?', [$userId])->execute();
        $result = $this->prepare(' DELETE FROM users WHERE id=?', [$userId])->execute();
        return (bool) $result->getAffectedRows();
    }
}