<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once(__DIR__ . '/layouts/title.php');

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
            <h2 class="card-title font-weight-bold text-center"><u>Ready to generate some random data?</u></h2>
        </div>

        <form action="http://localhost/Randomizer/public/data/generate" method="GET">
<!--            Add              -->
            <label for="data_type">What kind of random data do you want to get?
                <select name="data_type">
                    <option value="name">Random Name</option>
                    <option value="address">Random Address</option>
                    <option value="vehicle">Random Vehicle</option>
                </select>
            </label>

            <input type="submit" value="Generate">
        </form>
    </div>
</div>
        </br>
<!--        Add some sort of display block to show the information from the call -->
        <?php
        if (isset($_SESSION['randomDataGenerated'])) {

            ?>
                <div class="container">
                    <div class="row">
                        <div class="col-cold-md12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <blockquote class="blockquote">

                                        <?= $_SESSION['randomDataGenerated'] ?>

                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
//            unset($_SESSION['randomDataGenerated']);
        }
        ?>



