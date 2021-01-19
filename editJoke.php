<?php
    if(!$_POST) exit("Forbidden!");
    session_start();
    include "db.php";
    $joke_id = $_POST['id'];
    $text = htmlspecialchars(trim(mysqli_real_escape_string($db, $_POST['text'])));

    $query = mysqli_query($db, "SELECT `author` FROM `jokes` WHERE `id`='$joke_id'");
    $result = mysqli_fetch_assoc($query);

    if($result['author'] != $_SESSION['user_id']) exit(); //It isn't his joke

    $update = mysqli_query($db, "UPDATE `jokes` SET `joke` = '$text' WHERE `id` = '$joke_id'");
    if($update) exit("success");