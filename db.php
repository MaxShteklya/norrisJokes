<?php
    $db = new mysqli("localhost", "mysql", "mysql", "jokes");
    if ($db->connect_errno) {
        echo "Не удалось подключиться к БД";
    }