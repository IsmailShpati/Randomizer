<?php

class Home extends Controller
{

    protected User $user;

    public function __construct(){
        $this->user = new User();
    }

    public function index(){
        $this->view('home');
    }
}