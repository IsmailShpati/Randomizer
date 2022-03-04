<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once(__DIR__ . '/layouts/title.php');

$client = new GuzzleHttp\Client();

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
            <h2 class="card-title font-weight-bold text-center"><u>Don't know what to cook? Try a random meal recipe.</u></h2>
                    <form action="http://localhost/Randomizer/public/meals/generate" method="GET">
                        <input type="submit" value="Generate">
                    </form>
        </div>

<!--        <form action="http://localhost/Randomizer/public/meals/generate" method="GET">-->
<!--            <input type="submit" value="Generate">-->
<!--        </form>-->
    </div>
</div>
</br>
<!--        Add some sort of display block to show the information from the call -->
<?php
if (isset($_SESSION['randomMeal'])) {

    ?>
    <div class="container">
        <div class="row">
            <div class="col-cold-md12">
                <div class="card shadow">
                    <div class="card-body">
                            <?= $_SESSION['randomMeal'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
//            unset($_SESSION['randomDataGenerated']);
}
?>




