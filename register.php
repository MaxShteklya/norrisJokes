<?php
session_start();
if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_r'])){
    include "./db.php";
    $login = mysqli_real_escape_string($db, htmlspecialchars($_POST['login']));
    $password = md5(trim($_POST['password']));
    $password_r = md5(trim($_POST['password_r']));

    $sql = mysqli_query($db, "SELECT `login` FROM `users` WHERE `login`= '$login'") or die(mysqli_error());
    if(!empty($login) && !empty($password) && !empty($password_r)){
        if(mysqli_num_rows($sql) == 1){
            $error = "Пользователь с таким именем уже существует";
        }elseif($password != $password_r){
            $error = "Пароли не совпадают";
        }else{
            $insert = mysqli_query($db, "INSERT INTO `users` (`login`, `password`) VALUES ('$login', '$password')");
            if($insert) {
                $_SESSION['user_id'] = mysqli_insert_id($db);
                $_SESSION['user_login'] = $login;
                header("Location: ./");
            }else{
                $error = 'Ошибка!'.mysqli_error($db);
            }

        }
    }
}
if (isset($_SESSION['user_id'])){
    exit(header("Location: ./"));
}
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
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
        .form-signin .checkbox {
            font-weight: 400;
        }
        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }
        .form-signin button[type="submit"] {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>
<body class="text-center">
    <main class="form-signin">
        <?php if(!empty($error)){ ?>
            <div class="container mx-auto">
                <div class="alert alert-danger" role="alert"><?=$error?></div>
            </div>
        <?php } ?>
        <form action="#" method="post">
            <h1 class="h3 mb-3 fw-normal">Регистрация</h1>
            <input name="login" type="text" class="form-control" placeholder="Логин" required autofocus>
            <input name="password" type="password" class="form-control" placeholder="Придумайте пароль" required>
            <input name="password_r" type="password" class="form-control" placeholder="Повторите пароль" required>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Зарегитрироваться</button>
            <p class="my-3 text-muted">Уже есть аккаунт? <a href="./login.php">Войдите в него</a></p>
            <p class="mt-5 mb-3 text-muted">&copy;Max Shteklya</p>
        </form>
    </main>
</body>
</html>
