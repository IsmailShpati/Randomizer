<?php

use JetBrains\PhpStorm\ArrayShape;

include_once(__DIR__.'\..\utils\Constants.php');

if(!isset($_SESSION)) session_start();

class App
{
    protected string $controllerName = 'home';
    protected Controller $controller;
    protected string $method = 'index';
    protected $params = [];

    public function __construct()
    {

        $url = $this->parseUrl();
//        error_log("Parsed url: ".implode(" ", $url));
        if (file_exists(CONTROLLERS_PATH . $url['url_path'][0] . '.php')) {
            $this->controllerName = $url['url_path'][0];
//            syslog(LOG_INFO, "Fetched controller from router: ".$this->controllerName);
            error_log("SMAJLI -> Fetched controller from router: $this->controllerName");
            unset($url['url_path'][0]);
        }

        require_once CONTROLLERS_PATH . $this->controllerName . '.php';
        syslog(LOG_INFO, "Requiring controller: ".CONTROLLERS_PATH.$this->controllerName.".php");
        error_log("SMAJLI -> Requiring controller: ".CONTROLLERS_PATH.$this->controllerName.".php");
        $this->controller = new $this->controllerName;


        if (isset($url['url_path'][1])) {
            $this->method = $url['url_path'][1];
            error_log("Method: " . $url['url_path'][1]);
            if (method_exists($this->controller, $url['url_path'][1])) {
                $this->method = $url['url_path'][1];
                error_log("SMAJLI -> Fetched method from url: $this->method");
                unset($url['url_path'][1]);
            }
        }

        $this->validateAuth($this->controllerName, $this->method);

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function validateAuth($controller, $method)
    {
        error_log( "SMAJLI -> Inside validateAuth with controller: $controller and method: $method");

        // TODO: fix later, make login redirect to login when no valid method found
        if($this->notIn($controller, ["login", "register"]) || $this->notIn($method, ['login', 'register', 'index']) ) {
            if(!isset($_SESSION['isAuth']) || $_SESSION['isAuth'] == false)
            {
                require_once CONTROLLERS_PATH.'login.php';
                $_SERVER['REQUEST_URI'] = 'login';
                $this->controller = new Login();
                $this->controller->index();
                die();
            }
        }
    }

    private function in(string $searchValue, array $valuesList): bool {
        foreach ($valuesList as $value) {
            if($value == $searchValue) {
                return true;
            }
        }
        return false;
    }

    private function notIn(string $searchValue, array $valuesList): bool {
        foreach ($valuesList as $value) {
            if($value == $searchValue) {
                return false;
            }
        }
        return true;
    }

    #[ArrayShape(['url_path' => "string", 'query_params' => "mixed|string"])]
    public function parseUrl(): array
    {
        $urlProperties = ['url_path' => 'login/index', 'query_params' => ''];
        if (isset($_SERVER['REDIRECT_URL'])) {
            error_log("SMAJLI -> REDIRECT_URL: " . $_SERVER['REDIRECT_URL']);
            $urlProperties['url_path'] = explode('/', trim(str_replace(BASE_URL, '', $_SERVER['REDIRECT_URL']), '/'));
            error_log("SMAJLI -> urlProps: ". implode(" ", $urlProperties['url_path']));
        }
        if(isset($_SERVER['QUERY_STRING'])) {
            $urlProperties['query_params'] = $_SERVER['QUERY_STRING'];
            error_log("SMAJLI -> queryParams: ". $urlProperties['query_params']);

        }
        return $urlProperties;
    }
}
