<?php
    session_start();
    if (isset($_POST['login']) && isset($_POST['password'])){
        include "./db.php";
        $login = mysqli_real_escape_string($db, htmlspecialchars($_POST['login']));
        $password = md5(trim($_POST['password']));

        $sql = mysqli_query($db, "SELECT id, login FROM users WHERE login= '$login' AND password = '$password' LIMIT 1") or die(mysqli_error());

        if (mysqli_num_rows($sql) == 1) {
            $row = mysqli_fetch_assoc($sql);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_login'] = $row['login'];
        }
        else {
            header("Location: ./login.php");
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
    <title>Вход - Jokes.com</title>
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
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>
<body class="text-center">
    <main class="form-signin">
        <form action="#" method="post">
            <h1 class="h3 mb-3 fw-normal">Вход</h1>
            <label for="inputLogin" class="visually-hidden">Логин</label>
            <input name="login" type="text" id="inputLogin" class="form-control" placeholder="Логин" required autofocus>
            <label for="inputPassword" class="visually-hidden">Пароль</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Пароль" required>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
            <p class="my-3 text-muted">Нету аккаунта? <a href="./register.php">Зарегистрируйся</a></p>
            <p class="mt-5 mb-3 text-muted">&copy;Max Shteklya</p>
        </form>
    </main>
</body>
</html>
