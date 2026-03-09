<?php
use GuzzleHttp\Client as Client;


class Data extends Controller
{

    private Client $client;
    protected ApiMessages $apiMessage;


    public function __construct()
    {
        $this->client = new Client();
    }

    private static function dbg($msg) {
        error_log("DataController_SMAJLI --> " . $msg);
    }

    public function index()
    {
        $this->view("random_data");
    }


    public function generate(){
        if(isset($_GET) && isset($_GET['data_type'])) {
            self::dbg("Inside generate");
            $dataType = $_GET['data_type'];
            $response = $this->callRandomApi($dataType);

            self::dbg("Fetched response from random api: " . json_encode($response, JSON_PRETTY_PRINT));
            $buildHtml = $this->parseResponse($dataType, json_encode($response, JSON_PRETTY_PRINT));
            $_SESSION['randomDataGenerated'] = $buildHtml;
            self::dbg("SESSION['randomDataGenerated']: "  . $_SESSION['randomDataGenerated']);
            $this->index();
        }
    }


    private function callRandomApi($dataType){
        self::dbg("Inside callRandomApi with dataType: " . $dataType);
        $response = $this->client->request("GET", "https://random-data-api.com/api/" . $dataType . "/random_" . $dataType);
        $apiId = uniqid(session_id());

        ApiMessages::create([
            'id' => $apiId,
            'user_id' => $_SESSION['userId'],
            'caller' => "https://random-data-api.com/api/" . $dataType . "/random_" . $dataType,
            'response' => $response->getBody()]);

        return json_decode($response->getBody());
    }

    private function parseResponse(string $dataType, $apiResponse): string
    {
        $apiResponse = preg_replace('/("(.+)":)/', '<span style="color: brown">$2:</span>', $apiResponse);
        self::dbg("After key replacement: $apiResponse");
//        $apiResponse = preg_replace('/> (".+")/', '<span style="color: green">>$1</span>', $apiResponse);
//        self::dbg("After string replacement: $apiResponse");
        $apiResponse = preg_replace('/ (".*")/mU', '<span style="color: green"> $1</span>', $apiResponse);
        self::dbg("Trying to printify string values: " . $apiResponse);
        return '<pre style="color: cornflowerblue">'.$apiResponse.'</pre>';
    }


}