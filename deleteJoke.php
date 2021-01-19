<?php
    session_start();
    include "db.php";
    $joke_id = $_GET['id'];

    $query = mysqli_query($db, "SELECT `author` FROM `jokes` WHERE `id`='$joke_id'");
    $result = mysqli_fetch_assoc($query);

    if ($result['author'] != $_SESSION['user_id']) exit(header("Location: ./")); //It isn't his joke

    $deleting = mysqli_query($db, "DELETE FROM `jokes` WHERE `id` = '$joke_id'");
    if ($deleting) exit(header("Location: ./"));