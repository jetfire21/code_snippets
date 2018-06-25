<?php 
header('Content-Type: text/html; charset=utf-8');
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

// notformated view (only unix)
// du -h | sort -h
// du --human-readable | sort --human-numeric-sort
// echo $d = escapeshellcmd(dirname(__FILE__)); echo nl2br(`du -h $d`);
?>

<?php
$dirs[0] = "";
$dirs1 = array_filter(glob('*'), 'is_dir');
$dirs2 = array_filter(glob("wp-content/*"), 'is_dir');
$dirs3 = array_filter(glob("wp-content/uploads/*"), 'is_dir');
$dirs = array_merge($dirs,$dirs1,$dirs2,$dirs3);
echo '<pre>'; print_r( $dirs); echo '</pre>'; 
?>



<?php
/*******  этот снипет на хостинге zenon.net не работает! **************

    // функция для просмотра всех подпапок и всех вложенных файлов
function dir_size($dirname) {
	$totalsize=0;
	// if ($dirstream = @opendir($dirname)) {
	if ($dirstream = opendir($dirname)) {
		while (false !== ($filename = readdir($dirstream))) {
			if ($filename!="." && $filename!="..")
			{
				if (is_file($dirname."/".$filename))
					$totalsize+=filesize($dirname."/".$filename);

				if (is_dir($dirname."/".$filename))
					$totalsize+=dir_size($dirname."/".$filename);
			}
		}
	}
	closedir($dirstream);
	return $totalsize;
}

 // функция форматирует вывод размера
function format_size($size){
	$metrics[0] = 'байт';
	$metrics[1] = 'Кбайт';
	$metrics[2] = 'Мбайт';
	$metrics[3] = 'Гбайт';
	$metrics[4] = 'Тбайт';
	$metric = 0;         
	while(floor($size/1024) > 0){
		++$metric;
		$size /= 1024;
	}        
	$ret =  round($size,1)." ".(isset($metrics[$metric])?$metrics[$metric]:'??');
	// return $ret;
	return $size;
}

function get_size_directory($dir){
    // $dirname = '/folder/'; // указываем полный путь до папки или файла 
    $dirname = 'e:/OSPanel/domains/orig-wp.loc/'.$dir; // указываем полный путь до папки или файла 
    $size = dir_size($dirname); //заносим в переменную размер папки или файла
    $formSize = format_size($size); //форматируем вывод
    echo $dir." - ".$formSize."<br>";

}


foreach ($dirs as $dir) {
	// echo $dir;
	get_size_directory($dir);
}

*******  этот снипет на хостинге zenon.net не работает! **************/

?>




<?php
// function getAllSubDirectories( $directory, $directory_seperator )
// {
//         $dirs = array_map( function($item)use($directory_seperator){ return $item . $directory_seperator;}, array_filter( glob( $directory . '*' ), 'is_dir') );

//         foreach( $dirs AS $dir )
//         {
//                 $dirs = array_merge( $dirs, getAllSubDirectories( $dir, $directory_seperator ) );
//         }

//         print_r($dirs);
// }
// getAllSubDirectories( 'e:/OSPanel/domains/orig-wp.loc','/' );
// getAllSubDirectories( 'wp-content','/' );
?>



<?php

// function folderSize ($dir)
// {
//     $size = 0;
//     foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
//         $size += is_file($each) ? filesize($each) : folderSize($each);
//     }
//     return $size;
// }

?>

<?PHP
/*
function read_all_files($root = '.'){
$size=0;
  $files  = array('files'=>array(), 'dirs'=>array());
  $dirs  = array();
  $last_letter  = $root[strlen($root)-1];
  $root  = ($last_letter == '\\' || $last_letter == '/') ? $root : $root.DIRECTORY_SEPARATOR;
  $dirs[]  = $root;
  while (sizeof($dirs)) {
    $dir  = array_pop($dirs);
    if ($handle = opendir($dir)) {
      while (false !== ($file = readdir($handle))) {
        if ($file == '.' || $file == '..') {
          continue;
        }
        $file  = $dir.$file;
        if (is_dir($file)) {
          $directory_path = $file.DIRECTORY_SEPARATOR;
          array_push($dirs, $directory_path);
          $files['dirs'][]  = $directory_path;
        } elseif (is_file($file)) {
         $size+=filesize($file);
        }
      }
      closedir($handle);
    }
  }
  return $size;
}
 
 // to kilobyte
echo read_all_files('wp-content');  // путь к папке
echo "<br>";
echo read_all_files('wp-admin');  // путь к папке
*/
?>


<?php
echo "<hr>";
// function Size($path)
function human_size($bytes)
{
    // $bytes = sprintf('%u', filesize($path));

	if ($bytes > 0)
	{
		$unit = intval(log($bytes, 1024));
		$units = array('B', 'KB', 'MB', 'GB');

		if (array_key_exists($unit, $units) === true)
		{
			return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
		}
	}

	return $bytes;
}

function recursiveDirSize($path) {
	$size = 0;
	$ite = new RecursiveDirectoryIterator($path);

	foreach(new RecursiveIteratorIterator($ite) as $cur) {
		$size += $cur->getSize();
	}

	return $size;
}
$dirsizes = array();
// echo '<pre>'; print_r( $dirs); echo '</pre>'; 
function get_size_dir2($dirs){
	foreach ($dirs as $dir) {
		$s = recursiveDirSize(dirname(__FILE__)."/".$dir);
		if($dir == "") $dir = "public_html";
		// echo $kb = $dir." - ".round($s/1024, 2).' kb<br>';
		$dirsizes[$dir] = $s;
	}
	arsort($dirsizes);
	// echo '<pre>'; print_r( $dirsizes); echo '</pre>'; 
	foreach ($dirsizes as $dir => $size) {
		// echo $kb = $dir." - ".round($size/1024, 2).' kb<br>';
		echo $kb = $dir." - ".human_size($size).'<br>';
	}

}

get_size_dir2($dirs);
// get_size_dir2('/wp-content');
// get_size_dir2('/');

// var_dump($dirsizes);

// var_dump($kb);
?>

<?php 
// echo $size=array_sum(array_map('filesize', glob("{$dir}/*.*")));
// echo $size=array_sum(array_map('filesize', glob("/*.*")));
?>