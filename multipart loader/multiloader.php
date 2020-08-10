<?php

$error = 0;

loadFile();

function checkFileSize(){
    $maxFileSize = 5 * 1024 * 1024; //5MB

    $total_files = count($_FILES['userfile']['name']);

    for($key = 0; $key < $total_files; $key++) {
        $name = $_FILES['userfile']['name'][$key];
        $size = $_FILES['userfile']['size'][$key];
        if($size != 0 && $size < $maxFileSize){
            echo 'Допустимый размер файла ' . $name . ' </br>';
        } else {
            global $error;
            $error++;
            echo 'Размер файла ' . $name . ' больше допустимого </br>';
        }
    }
}

function checkFileType(){
    $total_files = count($_FILES['userfile']['name']);

    for($key = 0; $key < $total_files; $key++) {
        // if($_FILES['userfile']['type'][$key] != $mimetype){
        $name = $_FILES['userfile']['name'][$key];
        $mimetype = mime_content_type($_FILES['userfile']['tmp_name'][$key]);
        if(in_array($mimetype, array('image/jpeg', 'image/gif', 'image/png'))) {
            echo 'Файл ' . $name . ' прошёл проверку на тип </br>';
        } else {
            global $error;
            $error++;
           echo 'Файл ' . $name . '  не является изображением </br>';
        }
    }
}


function loadFile() {
    global $error;
    $total_files = count($_FILES['userfile']['name']);
    for($key = 0; $key < $total_files; $key++) {
        $name = $_FILES['userfile']['name'][$key];
        $tmp_name = $_FILES['userfile']['tmp_name'][$key];
        if($error === 0) {
            checkFileSize();
            checkFileType();
            move_uploaded_file($tmp_name, "img/$name");
            echo 'Файл упешно загружен </br>';
        } else {
            echo 'Файл загрузить не удалось </br>';
        }
    }
    
}