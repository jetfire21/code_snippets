<?php

/*****************
 чтение названий файлов как из деректории так и файла .txt
сравнение 2 массивов файлов с названиями и выявление расхождения в них
 **************/

$local_dir = dirname(__FILE__).DIRECTORY_SEPARATOR;

/*****************  read filenames from external files **************/

// $content = file_get_contents($local_dir."list_titles/imgs-title.txt");
$content = file_get_contents($local_dir."/list2/imgs-title.txt");
// var_dump($content);
$img_titles = explode("\r", $content);
// var_dump($content);

// print_r($img_titles);

foreach ($img_titles as $img) {
	$img_title = explode("::",$img);
	$only_name_cards .= $img_title[1]."\r\n";
	// check space sign
	if(preg_match('#\s#i', $img_title[1])) $titles_space .= $img_title[1]."<br>";
	// var_dump($img_title);
	$ex_raw_only_file_names_defis[] = str_replace(" ", "-", $img_title[0] ); 
	$valid_titles[] = $img_title[1];
}
	// echo $only_name_cards;
	// print_r($ex_raw_only_file_names);
	// echo "ex_raw_only_file_names_defis";
	// print_r($ex_raw_only_file_names_defis);
	// echo "Названия с пробелами: ".$titles_space;
	echo "<hr>";


$all_raw_titles = file_get_contents($local_dir."/list2/all_raw_titles.txt");
// var_dump($content);
$all_raw_titles = explode("\r\n", $all_raw_titles);
// var_dump($content);

// print_r($all_raw_titles);
echo "<hr>";
// $cmp2arr = array_diff($all_raw_titles, $ex_raw_only_file_names);
// $cmp2arr2 = array_diff($ex_raw_only_file_names, $all_raw_titles);
echo "Всего отличается строк: ".count($cmp2arr);
echo "<hr>";

// print_r($cmp2arr);
// var_dump($cmp2arr2);

// exit;
/*****************  read filenames from external files **************/


// array all files
$imgs = scandir("valid_283b");
// $imgs = scandir("raw_283");
unset($imgs[0]);
unset($imgs[1]);

// echo "<pre>"; print_r($imgs); echo "</pre>";
echo "total files: ".count($imgs);

	echo "ex_raw_only_file_names_defis";
	// print_r($ex_raw_only_file_names_defis);


// exit;
echo "<br>\r\n";

foreach ($imgs as $k => $img) {
	// del _283b
	$titles_del_283b[] = str_replace("_283b", "", $img);
}
// ищем дублирующиеся значения
print_r(array_count_values($valid_titles));
print_r($valid_titles);
print_r($titles_del_283b);

// echo 'cmp AussieGlo-Greeting-Cards-0518129.jpg & AussieGlo-Greeting-Cards-0518129.jpg';
echo 'cmp zest.jpg & zest.jpg';
// $cmp_raw_titles = array_diff($titles_del_283b, $valid_titles);
$cmp_raw_titles = array_diff($valid_titles,$titles_del_283b);
// $cmp_raw_titles = array_diff($ex_raw_only_file_names_defis,$imgs);
print_r($cmp_raw_titles);
echo "<br>\r\n";

exit;

// foreach ($content as $img) {
// 	$img_title = explode("::",$img);
// 	var_dump($img_title);
// }

foreach ($imgs as $k => $img) {
	echo $img."<br>";
}
/*
foreach ($imgs as $k => $img) {
	// if($k >= 6) exit;
	foreach ($img_titles as $img_f) {
		if( preg_match("#".$img."#i",$img_f ) ){
			echo $img_f;
			$new_title = explode("::",$img_f);
			echo "<br>".$new_title[1]."<hr>";
			$new_title_ext = str_replace(".jpg", "", $new_title[1]);
	        rename($local_dir."front_title/".$img, $local_dir."front_title/".$new_title_ext."_400f.jpg");
			break;
		}
	}
}
*/


/*  rename file

echo "<hr> rename";
echo "<hr>";
$path = $local_dir."valid_283b".DIRECTORY_SEPARATOR;
foreach ($imgs as $k => $img) {
	// if($k >= 6) exit;
	$img_space = str_replace("-", " ", $img);
	// $imgs_space[] = $img_space;
	foreach ($img_titles as $img_f) {
		if( preg_match("#".$img_space."#i",$img_f ) ){
			echo $img_f."<br>";
			$new_title = explode("::",$img_f);
			echo "<br>".$new_title[1]."<hr>";
			$new_title_ext = str_replace(".jpg", "", $new_title[1]);
	        // rename($local_dir."valid_283b/".$img, $local_dir."valid_283b/".$new_title_ext."_283b.jpg");
	        rename($path.$img, $path.$new_title_ext."_283b.jpg");
	        echo $path.$img." | ".$path.$new_title_ext."_283b.jpg<br>";
			break;
		}
	}
}
echo "<hr>\r\n";
// print_r($imgs_space);

*/