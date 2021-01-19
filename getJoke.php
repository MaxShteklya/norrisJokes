<?php
    if(!$_POST) exit("Forbidden");
    $action = $_POST['action'];

    switch ($action){
        case 'getCategories':
            $url = 'https://api.chucknorris.io/jokes/categories';
            break;
        case 'getRandomJoke':
            $url = 'https://api.chucknorris.io/jokes/random';
            break;
        case 'getRandJokeByCategory':
            $category = $_POST['category'];
            $url = 'https://api.chucknorris.io/jokes/random?category='.$category;
            break;
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    exit($response);