<?php

/* extract text form image use https://ocr.space/ocrapi, большой процент распознования,намного лучше платного ABBYY Cloud OCR SDK */

/*
парсит 40 изображений в минуту
!!! когда парсится много изображений,к примеру 80 штук,некоторые изобра могут не распознаться,надо пробовать 2 раз попарсить
-------------
 странно,через file_get_contents() 1 запрос срабатывает,а дальше после 1 стал возвращать 403 ошибку,а если напрямую через адрес строку вставлять,то работает (да как раз по домену блокирует,с которого идет запрос к сервису!)
 https://api.ocr.space/parse/imageurl?apikey=helloworld&url=http://vh109980.eurodir.ru/for_extract/AussieGlo-Greeting-Cards-0418-101.jpg
j9523120.beget.tech/public_html/get_text2.php

You may only perform this action upto maximum 10 number of times within 86400 seconds = 24 часа
надо зарегиться чтобы получить id
*/

// на хостинге может возникнуть ошибка (500 Internal Server Error) на eurobyte time = 216-230 (обраб 20-26 изображ и 500 ошибка)
// не забыть на хостинге права на папку с изображ выставить в 755 чтобы скрипт с ними мог работать
ini_set('max_execution_time', '700');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$st_time = microtime(true);

/*
$imgs = scandir("get_text_from_imgs");
unset($imgs[0]);
unset($imgs[1]);
var_dump($imgs);

foreach ($imgs as $k => $img) {
  $img_titles[] = $img;
}
  echo "<pre>"; print_r($img_titles); echo "</pre>";

exit;
*/

/*
//as21_abby_get_text_from_img('AussieGlo-Greeting-Cards-0418-101.jpg'); // не распознается
$img1 = 'AussieGlo-Greeting-Cards-0418-101.jpg';
$img2 = 'AussieGlo-Greeting-Cards-0418-123.jpg';

  echo $url = "https://api.ocr.space/parse/imageurl?apikey=helloworld&url=http://vh109980.eurodir.ru/for_extract/".$img1;
  $res = file_get_contents($url);
  var_dump($res);

    echo $url = "https://api.ocr.space/parse/imageurl?apikey=helloworld&url=http://vh109980.eurodir.ru/for_extract/".$img2;
  $res = file_get_contents($url);
  var_dump($res);

  exit;
*/

  $imgs = scandir("get_text_from_imgs");
  unset($imgs[0]);
  unset($imgs[1]);

  echo "<pre>"; print_r($imgs); echo "</pre>";
// exit;
  $local_directory = dirname(__FILE__)."/get_text_from_imgs"."/";



  foreach ($imgs as $k => $img) {

  // if ($k >= 5 ) break;

    echo $k."- ".$img; echo "<br>";
  // as21_abby_get_text_from_img($img);

    // если в именах файлов существ пробел,то возникает ошибка 
    echo $new_img = str_replace(' ', '_', $img);
    $rename = rename($local_directory.$img, $local_directory.$new_img);
    var_dump($rename);

  // https://api.ocr.space/parse/imageurl?apikey=helloworld&url=http://i.imgur.com/fwxooMv.png 
  // $url = "https://api.ocr.space/parse/imageurl?apikey=helloworld&url=http://vh109980.eurodir.ru/for_extract/AussieGlo-Greeting-Cards-0418-111.jpg";
  // echo $url = "https://api.ocr.space/parse/imageurl?apikey=24b9e3caf188957&url=http://vh109980.eurodir.ru/for_extract/".$img;
  // for yroki-kompa.ru
     $url = "https://api.ocr.space/parse/imageurl?apikey=3f70ccb3f988957&url=http://yroki-kompa.ru/get_text_from_imgs/".$new_img;
    // echo $url = urlencode($url);
     // echo $url = str_replace(' ', '_', $url);
    $res = file_get_contents ($url);

    // var_dump($res);
    $res = json_decode($res);
  // var_dump($res);
  // echo "<pre>"; print_r($res); echo "</pre>";
    echo "<hr>";
    echo $title = $res->ParsedResults[0]->ParsedText;

    // example: "Wisdom",*Verve","Loyalty',"Splendom
    preg_match('#"(.*?)"#is', $title, $m );
    var_dump($m);
    if(empty($m)) preg_match('#*(.*?)"#is', $title, $m );
    if(empty($m)) preg_match('#"(.*?)\'#is', $title, $m );
    if(empty($m)) preg_match('#"(.*?)\s#is', $title, $m );
    var_dump($m);
    $str = strtolower( trim($m[1]) );
    var_dump($str);
    // var_dump($res->ParsedResults);
    if($str)  {
      as21_wjm_write_file_jobs_count('imgs-title.txt',$img."::".$str.".jpg\r");
      as21_wjm_write_file_jobs_count('imgs-new-title.txt',$new_img."::".$str.".jpg\r");
      // rename($local_directory.$img, $local_directory.$str."_283b.jpg");
    }



    echo '<hr>';
    // as21_wjm_write_file_jobs_count('imgs-title.txt',$img);

  }


  function as21_wjm_write_file_jobs_count($filename,$text){

    if( file_exists($filename) ) chmod($filename, 0777);
  $fp = fopen($filename, "a"); // 'a' - write end file
  $write = fwrite($fp, $text); 
  // var_dump($write);
  fclose($fp); 
}

$end_time = microtime(true);
echo "<hr>time = ".($end_time - $st_time);

// $img = 'title img';
// echo $new_img = str_replace(' ', '_', $img);
?>


