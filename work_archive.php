<?
// распаковка zip архива средставми php

    $zip = new ZipArchive;
    $zip->open('graphite.zip');
    $zip->extractTo('./');
    $zip->close();
    echo "Ok!"; 
///////////////////////////////////////////////////////////////


header('Content-Type: text/html; charset=utf-8');

$st_time = microtime(true);

/* ******* добавляется все файлы и папки рекурсивно в архив ******************** */

// Get real path for our folder
function pack_files($dir){

    $i = 1;
    $rootPath = realpath($dir);

    // Initialize archive object
    $zip = new ZipArchive();
    $name_archive = $dir.'.zip';
    $res = $zip->open($name_archive, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    echo "============="; var_dump($res);

    // Create recursive directory iterator
    /** @var SplFileInfo[] $files */
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    var_dump($files);
    foreach ($files as $name => $file)
    {
        // Skip directories (they would be added automatically)
        if (!$file->isDir())
        {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);

            // Add current file to archive
            $addfile = $zip->addFile($filePath, $relativePath);
            echo $i." - ".$filePath."<br>";
            if( $i< 5) echo "<br>--"; var_dump($addfile); echo "<br>";
        }
        $i++;
    }

    // Zip archive will be created only after closing object
    $zip->close();
    echo "Архив c именем <strong>{$name_archive}</strong> успешно создан!<br>";
}
// pack_files("wp-content");
// pack_files("wp-includes");
// pack_files("wp-admin");
// pack_files("plugins");
// pack_files("themes");

/* ******* добавляется все файлы и папки рекурсивно в архив ******************** */

echo "-------";
$dir = opendir("../wp-content"); // открываем папку с файлами
while( $file = readdir($dir)){ // перебираем все файлы из нашей папки
    echo $file."<br>";
    if(is_dir($file)) pack_files($file);
}

$dir = opendir("../wp-admin"); // открываем папку с файлами
while( $file = readdir($dir)){ // перебираем все файлы из нашей папки
    echo $file."<br>";
    if(is_dir($file)) pack_files($file);
}

$dir = opendir("../wp-includes"); // открываем папку с файлами
while( $file = readdir($dir)){ // перебираем все файлы из нашей папки
    echo $file."<br>";
    if(is_dir($file)) pack_files($file);
}


/* ******* добавляет только все файлы без рекусрии в архив (то есть файлы в вложенных папках не будут добалвены)  ************** */

function pack_files_parent_dir($pathdir){

    $pathdir=$pathdir."/"; // путь к папке, файлы которой будем архивировать
    $nameArhive = $pathdir.'.zip'; //название архива
    $zip = new ZipArchive; // класс для работы с архивами
    if ($zip -> open($nameArhive, ZipArchive::CREATE) === TRUE){ // создаем архив, если все прошло удачно продолжаем

            $dir = opendir($pathdir); // открываем папку с файлами
            while( $file = readdir($dir)){ // перебираем все файлы из нашей папки
                    if (is_file($pathdir.$file)){ // проверяем файл ли мы взяли из папки
                        $zip -> addFile($pathdir.$file, $file); // и архивируем
                        echo("Заархивирован: " . $pathdir.$file) , '<br/>';
                    }
            }
        $zip -> close(); // закрываем архив.
        echo "Aрхив успешно {$pathdir} создан";
    }else{
        die ('Произожла ошибка при создании архива');
    }
}
// pack_files_parent_dir("wp-includes");

/* ******* добавляет только все файлы без рекусрии в архив (то есть файлы в вложенных папках не будут добалвены)  ************** */

$end_time = microtime(true);
