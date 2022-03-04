<?php

abstract class Controller
{

    public abstract function index();

    protected function model($model)
    {
        require_once '../application/models/' .$model . '.php';
        return new $model();
    }

    protected function view($view)
    {
        require_once '../application/views/'. $view . '.php';
    }

}