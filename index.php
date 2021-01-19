<?php
    session_start();
    include "db.php";
    $pg = $_GET['page'];
    if(empty($pg)) $pg = "";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Jokes.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>

<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <p class="h5 my-0 me-md-auto fw-normal">Jokes.com</p>
    <nav class="my-2 my-md-0 me-md-3">
        <a class="p-2 text-dark" href="./">Все шутки</a>
        <?php if(isset($_SESSION['user_id'])) { ?><a class="p-2 text-dark" href="./?page=add">Добавить</a><?php } ?>
    </nav>
    <?php if(!isset($_SESSION['user_login'])){
        echo '<a class="btn btn-outline-primary" href="./login.php">Авторизация</a>';
    }else{
        echo 'Привет, '.$_SESSION['user_login'];
        echo '<a class="p-2 text-danger" href="./exit.php" class="exit">Выход</a>';
    } ?>

</header>

<main class="container">
    <?php
        switch ($pg){
            case "":
                include "./pages/jokes_list.php";
                break;
            case "add":
                include "./pages/add.php";
                break;
            case "joke":
                include "./pages/joke.php";
                break;
            default:
                echo "<p class='lead text-center mt-5 mb-5'>Данной страницы не существует :(</p>";
                break;
        }
    ?>
</main>
<footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="row container mx-auto">
        <div class="col-12 text-center">
            <small class="d-block mb-3 text-muted">&copy;2021 Max Shteklya</small>
        </div>
    </div>
</footer>
</body>
</html>
