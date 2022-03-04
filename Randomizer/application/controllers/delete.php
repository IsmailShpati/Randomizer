<?php

class Delete extends Controller
{


    public function index()
    {
        if(isset($_DELETE['request_id'])){
            $requestId = $_DELETE['request_id'];
            ApiMessages::where(['id' => $requestId])->delete();
            $this->view('home');
        }
    }

}