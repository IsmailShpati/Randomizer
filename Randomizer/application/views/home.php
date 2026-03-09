<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once(__DIR__ . '/layouts/title.php');

use GuzzleHttp\Client;


function dbg($msg)
{
    error_log("HomeView_SMAJLI --> " . $msg);
}

function getRandomFactOfDay()
{
    try {
        $client = new Client();
        $res = $client->request("GET", "https://uselessfacts.jsph.pl/random.json?language=en");
        $parsedBody = json_decode($res->getBody(), false);
        dbg("Response from calling the api: " . $parsedBody->text);
        return $parsedBody;
    } catch (\GuzzleHttp\Exception\GuzzleException $e) {
        dbg("Inside exception when calling guzzle");
    }
}

function fetchApiCalls(){
    try{
        $apiRequests = ApiMessages::where(["user_id" => $_SESSION['userId']])->offset($_SESSION['pageNo'] * 10)->limit(10)->get();
        dbg("Api requests done: " . $apiRequests);
        return parseApiCalls($apiRequests);
    } catch (Exception $e) {
        dbg("Inside exception fetchApiCalls: " . $e);
        return [];
    }
}

function parseApiCalls($apiCalls): string
{
    $html = "";
    foreach ($apiCalls as $apiCall){
        $html .= '<tr>
                  <td><button class="btn btn-danger" name="delete-row" id="'.$apiCall->id.'">X</button></td>
                  <td>'.$apiCall->id.'</td>
                  <td>'.$apiCall->user_id.'</td>
                  <td>'.$apiCall->caller.'</td>
                  <td><textarea disabled class="form-control z-depth-1 response-area">'.$apiCall->response.'</textarea></td>
                </tr>';
//        <td> width="30%"'.$apiCall->response. '</td>
    }

    return $html;
}

$randomFact = getRandomFactOfDay();
?>

    <br>
    <br>
    <br>
    <div class="container h-25 text-center">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold text-center">Random fact of the day</h4>
                        <hr>
                        <blockquote class="blockquote">
                            <p class="mb-3"><?= trim($randomFact->text) ?></p>
                            <footer class="blockquote-footer"><cite
                                        title="Source Title"><?= $randomFact->source ?></cite></footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div
    <br>

    <div class="container">
        <div class="row">
            <div class="col-cold-md12">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold text-center">All your API requests in one place</h5>

                        <div class="row">
                        <nav class="my-2 my-md-0 mr-md-3">
                                <a class="page-navigator p-2" href="http://localhost/Randomizer/public/paginator/prevPage">⬅</a>
                                <?php if(!isset($_SESSION['pageNo']))
                                    $_SESSION['pageNo'] = 0;
                                echo $_SESSION["pageNo"];
                                ?>
                                <a class="p-2 page-navigator" href="http://localhost/Randomizer/public/paginator/nextPage">➡</a>
                        </nav>
                        </div>
                        <table class="table table-striped table-dark table-fit">
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>USER ID</th>
                                <th>Caller</th>
                                <th>Api Response</th>
                            </tr>
                        <?=
                            $requests = fetchApiCalls();
                            print "$requests"; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // function deleteRow(){
                let buttons = document.getElementsByName("delete-row");
                let length = buttons.length;
                for(let i = 0; i < length; i++) {
                    buttons[i].onclick = () => {
                        console.log('rowId ', buttons[i].id);
                        let deleteData = "request_id=" + buttons[i].id;
                        jQuery.ajax({
                            url: "http://localhost/Randomizer/public/paginator/delete?request_id=" + buttons[i].id,
                            type: 'DELETE',
                            data: deleteData,
                            success: () => location.reload()
                        });
                    }
                }

            // }
        </script>
    </div>

<?=
include_once(__DIR__ . '/layouts/footer.php');
