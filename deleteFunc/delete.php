<?php


function RemoveDir($path) {
    if(file_exists($path) && is_dir($path)) {
        $dirHandle = opendir($path);
        while (false !== ($file = readdir($dirHandle))) {
            if ($file!='.' && $file!='..') {
                $tmpPath=$path.'/'.$file;
                chmod($tmpPath, 0777);
                if (is_dir($tmpPath)) { 
                    RemoveDir($tmpPath);
                    } else {
                        if(file_exists($tmpPath)) {
                        unlink($tmpPath);
                        echo 'Файл удалён! </br>';
                        }
                    }
            }
        }
        closedir($dirHandle);
        if(file_exists($path)) {
            rmdir($path);
            echo "Папка удалена! </br>";
        }
    } else {
        echo "Удаляемой папки не существует или это файл!";
    }
}

$DeletedFolder='/new_dir';
RemoveDir($_SERVER['DOCUMENT_ROOT'].$DeletedFolder);
