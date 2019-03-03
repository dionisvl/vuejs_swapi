<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function pre($arr)
{
    echo '<pre 
style="font-size: 10pt; background-color: #fff; color: #000; 
margin: 10px; padding: 10px; border: 1px solid red; text-align: left; max-width: 800px; max-height: 800px; overflow: scroll;
line-height: 1.1;">';
    echo print_r($arr, 1);
    echo '</pre>';

}

function download_page($path)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $path);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $retValue = curl_exec($ch);
    curl_close($ch);
    return $retValue;
}


function make_request($section){
    $page = 1;
    if (!empty($_REQUEST['characters_page']) AND ($section != 'films')){
        $page = (int)$_REQUEST['characters_page'];
    }

    $result = download_page("https://swapi.co/api/$section/?page=$page&format=json");
    $json = json_decode($result, true);
    return $json;
}

$films = make_request('films');
foreach ($films['results'] as $film){
    $films_arr[] = $film;
}
//pre($films_arr);

$people = make_request('people');
foreach ($people['results'] as $character){
    $characters[] = $character;
}
//pre($characters);



