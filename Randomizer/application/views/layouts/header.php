<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Randomizer</title>
    <meta name="viewport" content="width=device-width, initial"/>
    <link rel="stylesheet" href="http://localhost/Randomizer/public/styles/index.css" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<!-- HEADER WITH NAV  -->
<div
        class="d-flex flex-column flex-md-row p-3 px-md-4 mb-3
        align-items-center
        bg-white
        border-bottom
        shadow-sm
        justify-content-between
">
    <h5 class="my-0 mr-md-auto font-weight-normal">
        Generate Random <strong>Data</strong>
    </h5>
    <?php
         if (isset($_SESSION['isAuth']) && $_SESSION['isAuth'] == true) {
            ?>
             <nav class="my-2 my-md-0 mr-md-3">
                 <a class="nav-ref home p-2" href="http://localhost/Randomizer/public/home">Home🏠</a>
                 <a class="nav-ref p-2" href="http://localhost/Randomizer/public/data">Data📑</a>
                 <a class="p-2 nav-ref" href="http://localhost/Randomizer/public/meals">Meals🍖</a>
                 <a class="p-2 nav-ref log-out" href="http://localhost/Randomizer/public/logout">LogOut😢</a>
             </nav>
    <?php
          }
    ?>

</div>