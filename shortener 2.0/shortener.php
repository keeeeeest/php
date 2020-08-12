<?php

$post = $_POST;
$user_link = $post['link'];


function checkUrl($url){

    if (isset($url) && $url !== '' ) {

        $url = trim($url);

        if(!filter_var($url, FILTER_VALIDATE_URL)) {
            echo 'Это не ссылка!';
            return '';
        }

        getUrl($url);
    } else {
        echo 'Пусто :(';
        return '';
    }
}

function getUrl($url){
    $file = 'url.txt';

    $f = fopen($file, 'a+');

    $urlArr = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    if (empty($urlArr)){
        $shortLink = shortUrl($url);

        fwrite($f, $url.'#'.$shortLink.'\n');
        fclose($f);
        
        echo 'Короткая ссылка: '.$shortLink;
        return 'Короткая ссылка: '.$shortLink;
    }

    foreach ($urlArr as $str) {
      $arr = explode('#', $str);

      if ($url === $arr[0].'#'.$arr[1]) {
        return "Короткая ссылка: ".$arr[2].'#'.$arr[3].'\n';
      }
    }
    
    $shortLink = shortUrl($url, $urlArr);
    fwrite($f, $url.'#'.$shortLink.'\n');
    fclose($f);
    
    echo "Короткая ссылка: ".$shortLink;
    return "Короткая ссылка: ".$shortLink;
}


function shortUrl($url, $urlArr = []){

    $urlHash = '';
    
    for ($i = 0; $i < 7; $i++) {
        $urlHash .= md5($url.microtime())[$i];
    }
    
    foreach ($urlArr as $str){
        $arr = explode('#', $str);
        
        if('http:/short.com/'.$urlHash === $arr[2].$arr[3]){
            shortUrl($url, $urlArr);
        }
    }
    return 'http:/short.com/'.$urlHash;
}

echo checkUrl($user_link);

