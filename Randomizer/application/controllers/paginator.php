<?php

class Paginator extends Controller
{

    private static function dbg($msg){
        error_log("PaginatorController_SMAJLI --> " . $msg );
    }

    public function index()
    {

    }

    public function delete(){
        self::dbg("Inside delete");
        self::dbg("Query string: " . $_SERVER['QUERY_STRING']);
        $queryParams = array();
        parse_str($_SERVER['QUERY_STRING'], $queryParams);
        self::dbg("QueryParams: " . implode(";", $queryParams));
        if(isset($queryParams['request_id'])){
            self::dbg("Request id is set.");
            $requestId = $queryParams['request_id'];
            ApiMessages::where(['id' => $requestId])->delete();
        }
    }

    public function nextPage(){
        if(isset($_SESSION['pageNo'])){
            $_SESSION['pageNo']++;
        }
        $this->view('home');
    }

    public function prevPage(){
        if(isset($_SESSION['pageNo']) && $_SESSION['pageNo'] > 1){
            $_SESSION['pageNo']--;
        }
        $this->view('home');
    }

}