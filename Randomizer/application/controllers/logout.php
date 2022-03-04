<?php

class Logout extends Controller
{

    private array $sessionKeys = ["isAuth", "userId", "userName", "errMsg", "randomDataGenerated", "randomMeal", "pageNo"];

    public function index()
    {
        $this->logOut();
        $this->view("login");
    }

    private function logOut(){
        foreach($this->sessionKeys as $key){
            $this->unsetSessionVariable($key);
        }
    }

    private function unsetSessionVariable($key){
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
    }
}