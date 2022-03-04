<?php

use GuzzleHttp\Client as Client;

class Meals extends Controller
{
    private Client $client;
    protected ApiMessages $apiMessage;


    public function __construct()
    {
        $this->client = new Client();
    }

    private function dbg($msg){
        error_log("MealsController_SMAJLI --> " . $msg);
    }

    public function index()
    {
        $this->view("random_meals");
    }

    public function generate(){
        try{
            $apiResponse = $this->client->request("GET", "https://www.themealdb.com/api/json/v1/1/random.php");

            $apiId = uniqid(session_id());

            ApiMessages::create([
                'id' => $apiId,
                'user_id' => $_SESSION['userId'],
                'caller' => "https://www.themealdb.com/api/json/v1/1/random.php",
                'response' => $apiResponse->getBody()]);


            $_SESSION['randomMeal'] = $this->parseResponse($apiResponse->getBody());

        } catch(Exception $e) {
            self::dbg("Inside exception on generate $e");
        }
        $this->index();
    }
    
    private function parseResponse($responseBody): string
    {
        self::dbg("Plain body: " . $responseBody);
        $jsonBody = json_decode($responseBody, true)["meals"][0];
        $html = 
            '<h1 class="text-center">'.$jsonBody['strMeal'].'</h1>
             <h3 class="text-left">Category: '. $jsonBody['strCategory'] .'</h3>
             <h3 class="text-left">Country of Origin: '. $jsonBody['strArea'] .'</h3>
             <img class="text-center" src="'. $jsonBody['strMealThumb'] .'" alt="meal image"/>
             <br>
             <h3>Ingredients</h3>
             <br>
             <ul>';

        // API returns a list of 20 ingredients and 20 measures but not all them contain values
        for($i = 1; $i <= 20; $i++){
            if(isset($jsonBody["strIngredient$i"]) && $jsonBody["strIngredient$i"] != null){
                $html .= '<li>' . $jsonBody["strMeasure$i"] . $jsonBody["strIngredient$i"] . '</li>';
            }
        }

        $html .= '</ul>
              <br>
              <h3>Instructions</h3>
              <p>'.$jsonBody["strInstructions"].'</p>';
        self::dbg("Html: $html");
        return $html;
    }
}