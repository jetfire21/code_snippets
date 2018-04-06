<?php

/* парсинг сайта с простой авторизацией,скрипт эмулиреут браузер,отрпвляет все заголовки:язык,юзер агент и т.д
работает на:
модифицирован: переходит последовательно на 3 страницы и формирует готоый html на выходе
 */

header("content-type: text/html;charset=utf-8");
ini_set('error_reporting', E_ALL);

// require_once "phpQuery-onefile.php";
require_once('phpQuery.php');

$domen = "http://www.gazunas.ru";
$url = "http://www.gazunas.ru/models/";

//замеряем время начала работы скрипта
$st_time =	microtime(true);

function get_result($url){

    $ch = curl_init();
    $headers = [
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
        'Origin:https://freelance.ru',
        'Referer:https://freelance.ru/login/',
        'Connection: keep-alive'
    ];

    $referer = "http://www.gazunas.ru/models/";

    $post_fields = array(
					 "login" => "oenomaus2013",
					"passwd" => "4265082109z",
					 "submit" => "Вход",
					"auth" => "auth",
					"return_url" => "/login/"
					); 

    $cookie = dirname(__FILE__)."/cookie.txt";
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    // curl_setopt ($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie);
    curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie);
    // curl_setopt($ch,CURLOPT_COOKIESESSION,trues);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// просто отключаем проверку сертификата
	curl_setopt($ch, CURLOPT_POST, 0); // использовать данные в post
	// curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

    $res = curl_exec($ch);
    if(curl_error($ch))
		{
		echo "\n\ncURL error:" . curl_error($ch);
		echo "\n\ncURL error:" . curl_errno($ch);
		//$flagerrcurl = true;
		}

    return $res;
}

// echo get_result($url);

// echo "<hr><h2>Here work phpquery...</h2><br><br>";

//создаем новый документ из полченной разметки
// phpQuery::newDocument( get_result($url) );
// $html = pq('.brands .brand-item');
// echo $html = $html->html();
// <a class="bi-name" href="/models/audi/">Audi</a>
// echo "<pre>";
// print_r($html);
// echo "</pre>";


// function parser($domen, $url, $i){

//     echo "<hr><h2>Перебор всех элементов в цикле</h2><br>";
//     phpQuery::newDocument( get_result($url) );
//     // $page = pq('.brand-item .bi-name');
//     $page = pq('.brand-item');

//      // echo $html = $html->html();
//      // echo "<br>";
//      foreach ($page as $item) {

//          if($i < 3){

//             $el = 1;
//              $item = pq($item);
//              // echo $item->html();
//              $link = $item->find(".bi-name")->attr("href"); //   /models/audi/
//              $link_text = $item->find(".bi-name")->text(); 
//              // echo $l = $item->find(".bi-img")->html(); 
//              $img_src = $item->find(".bi-img img")->attr("src"); //  
//              echo "<h3>Страница 1 - ".$domen.$link." <b>Итерация ".$i."</b></h3>";
//              echo "<img src='$domen.$img_src' />";
//              echo $link_text;
//               // echo $item->html();

//              echo "<br><b>Страница 2</b> - ".$domen.$link."<br>";
//              phpQuery::newDocument( get_result($domen.$link) );
//              $page2 = pq('.models .mi-name');

//              foreach ($page2 as $item2) {
//                  $item2 = pq($item2);
//                  $link2 = $item2->attr("href"); //   /photogalery/audi-a6-i-c4-sedan-2-8i-174hp-1994-1997/
//                  $link2_text = $item2->text(); //   
//                  echo "el ".$el." ".$link2." текст ссылки ".$link2_text."<br>";
//                  $el++;

//                     // .pg-desc
//                     echo "<br><b>Страница 3</b> - ".$domen.$link2."<br>";
//                     phpQuery::newDocument( get_result($domen.$link2) );
//                     $page3 = pq('.main-content');
//                     $page3_img_src = $domen.$page3->find("#exposition")->attr("src");
//                     echo "<img src='$page3_img_src' />";
//                     $page3_small_img = $page3->find(".pg-img");
//                     foreach ($page3_small_img as $img) {
//                          $img = pq($img);
//                          $small_src = $domen.$img->find("img")->attr("src");
//                          echo "<img src='$small_src' />";

//                     }
//                     echo $page3->find(".pg-desc")->text();
//                     echo $page3->find(".pg-more")->text();
//                     echo "<br><br>";

//             }
//             echo "<br>";
//             $i++;
//         }
//     }

// }


function parser($domen, $url, $p1_count, $p2_count){

    $p1 = 1;
    echo "<hr><h2>Перебор всех элементов в цикле</h2><br>\r\n";
    phpQuery::newDocument( get_result($url) );
    // $page = pq('.brand-item .bi-name');
    $page = pq('.brand-item');

     // echo $html = $html->html();
     // echo "<br>";
    $gal = 1;
     foreach ($page as $item) {

         if($p1 < $p1_count){

            $el = 1;
             $item = pq($item);
             // echo $item->html();
             $link = $item->find(".bi-name")->attr("href"); //   /models/audi/
             $link_text = $item->find(".bi-name")->text(); 
             // echo $l = $item->find(".bi-img")->html(); 
             $img_src = $item->find(".bi-img img")->attr("src"); //  

             phpQuery::newDocument( get_result($domen.$link) );
             $page2 = pq('.models .mi-name');

             $p2 = 1;
             foreach ($page2 as $item2) {

                 if($p2 < $p2_count){

                 $item2 = pq($item2);
                 $link2 = $item2->attr("href"); //   /photogalery/audi-a6-i-c4-sedan-2-8i-174hp-1994-1997/
                 $link2_text = $item2->text(); //   
                 $el++;

                    // .pg-desc
                    phpQuery::newDocument( get_result($domen.$link2) );
                    $page3 = pq('.main-content');
                    $page3_img_src = $domen.$page3->find("#exposition")->attr("src");
                    $page3_desc = $page3->find(".pg-desc")->text();
                    // $page3_more =  $page3->find(".pg-more")->text();
                    $page3_more =  $page3->find(".pg-more")->html();

                    echo '<div class="work-item '.strtolower($link_text).'" >';
                    echo '<div class="col-md-4">
                                 <img class="img-responsive" src="'.$page3_img_src.'" alt="">
                         </div>';
                     echo '<div class="col-md-8 work-slides">
                                <h2>'.$link2_text.'</h2>
                                '.$page3_desc.'<br>'.$page3_more.'
                                <div class="clearfix"></div>';

                   $page3_small_img = $page3->find(".pg-img");
                    foreach ($page3_small_img as $img) {
                         $img = pq($img);
                         $small_src = $domen.$img->find("img")->attr("src");
                         $sm_img_alt = $img->find("img")->attr("alt");
                         $full_img = $domen.$img->find("img")->attr("lowsrc");
                         $small_title = $img->find("img")->attr("title");
                         // echo "<img src='$small_src' />";
                         // echo '<div class="col-md-4">
                         //          <img class="img-responsive" src="'.$small_src.'" alt="">
                         //      </div>';
                        echo '<a class="example-image-link" href="'.$full_img.'" data-lightbox="example-set_'.$gal.'">
                                <img class="example-image" src="'.$small_src.'" alt="'.$sm_img_alt.'" title="'.$small_title.'"/>
                            </a>';
                    }
                    echo "</div>
                    </div>\r\n"; // end .work-item

                    /* *** for debug ******* */

                   //  echo strtolower($link_text);
                   //  echo '<br><br><img class="img-responsive" src="'.$page3_img_src.'" alt=""><br>';
                   //   echo ' <h2>'.$link2_text.'</h2><br>'.$page3_desc.$page3_more;
                   // $page3_small_img = $page3->find(".pg-img");
                   //  foreach ($page3_small_img as $img) {
                   //       $img = pq($img);
                   //       $small_src = $domen.$img->find("img")->attr("src");
                   //       $sm_img_alt = $img->find("img")->attr("alt");
                   //       $full_img = $domen.$img->find("img")->attr("lowsrc");
                   //       $small_title = $img->find("img")->attr("title");
                   //       // echo "<img src='$small_src' />";
                   //       // echo '<div class="col-md-4">
                   //       //          <img class="img-responsive" src="'.$small_src.'" alt="">
                   //       //      </div>';
                   //      echo '<br><img class="example-image" src="'.$small_src.'" alt="'.$sm_img_alt.'" title="'.$small_title.'"/>';
                   //      echo '<br><img class="example-image" src="'.$full_img.'" alt="'.$sm_img_alt.'" width="500"/>';
                   //  }

                    // echo "<br><br>";
                    // echo "- p2= ".$p2; 
                    $p2++;
                    $gal++;
                } else{ break; }

            }
            // echo "<br>";
            // echo "--p1=".$p1;
            $p1++;
         } else{ break; }
    } // endforeach $page

}

parser($domen, $url, 20, 3);
// всего на сайте 49 марок
// parser($domen, $url, 6, 3);    Время выполнения 22s  (это 5 брендов по 2 машины)
// parser($domen, $url, 15, 3);    Время выполнения 42s (это 14 брендов по 2 машины)
// parser($domen, $url, 15, 3);  Время выполнения 91s  (это 5 брендов по 2 машины в каждом по 5 миниатюр с ориг размером каждая)
// parser($domen, $url, 20, 3);  Время выполнения 113s  (это 5 брендов по 2 машины в каждом по 5 миниатюр с ориг размером каждая)

$end_time	=	microtime(true);
echo "<br><br>Время выполнения скрипта ".($end_time - $st_time)." сек.";


// #2
/* *************************** */


<?php

/* парсинг одной страницы сайта,который вытягивает все изображения и копирует их к себе на компьютер
 */

header("content-type: text/html;charset=utf-8");
ini_set('error_reporting', E_ALL);

// require_once "phpQuery-onefile.php";
require_once('phpQuery.php');

$domen = "http://gbo-ustanovka.ru";
$url = "http://gbo-ustanovka.ru/photogallery";

//замеряем время начала работы скрипта
$st_time =	microtime(true);

function get_result($url){

    $ch = curl_init();
    $headers = [
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
        'Origin:https://freelance.ru',
        'Referer:https://freelance.ru/login/',
        'Connection: keep-alive'
    ];

    $referer = "http://www.gazunas.ru/models/";

    $post_fields = array(
					 "login" => "oenomaus2013",
					"passwd" => "4265082109z",
					 "submit" => "Вход",
					"auth" => "auth",
					"return_url" => "/login/"
					); 

    $cookie = dirname(__FILE__)."/cookie.txt";
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    // curl_setopt ($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie);
    curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie);
    // curl_setopt($ch,CURLOPT_COOKIESESSION,trues);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// просто отключаем проверку сертификата
	curl_setopt($ch, CURLOPT_POST, 0); // использовать данные в post
	// curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

    $res = curl_exec($ch);
    if(curl_error($ch))
		{
		echo "\n\ncURL error:" . curl_error($ch);
		echo "\n\ncURL error:" . curl_errno($ch);
		//$flagerrcurl = true;
		}

    return $res;
}

function parser($domen, $url, $p1_count, $p2_count){

      function translit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
  }

    $p1 = 1;
    echo "<hr><h2>Перебор всех элементов в цикле</h2><br>\r\n";
    phpQuery::newDocument( get_result($url) );
    // $page = pq('.brand-item .bi-name');
    $page = pq('.gallery .categoryInner');

     // echo $html = $html->html();
     // echo "<br>";
    $gal = 1;
     foreach ($page as $item) {

         if($p1 < $p1_count){

            $el = 1;
             $item = pq($item);
             // echo $item->html();
             // echo $l = $item->find(".bi-img")->html(); 
             $img_src = $item->find("img")->attr("src"); //  
             $alt = $item->find("img")->attr("alt"); //  
             $brand = mb_strtolower($alt);
             $full_path = $domen.$img_src;

             if( preg_match('/\.jpg/i', $img_src) ) $ext = ".jpg";
             if( preg_match('/\.png/i', $img_src) ) $ext = ".png";
             if( preg_match('/\.gif/i', $img_src) ) $ext = ".gif";
              $new_img = "brands/brand_".translit($brand).$ext;

             // echo $gal.'- '.$img_src."<br>".$full_path."<br>".$alt."<br>".$brand."<br>".$new_img."<hr>";
            echo '<div class="categoryInner" data-brand="'.$brand.'">
                    <a href="#">
                        <img src="/img/'.$new_img.'" alt="'.$brand.'">
                   </a>
                    <div class="read">
                         <div class="title"><p>'.$alt.'</p></div>
                    </div>
                </div>';
                echo "\r\n";

             // copy($full_path,$new_img);

            // echo "<br>";
            // echo "--p1=".$p1;
            $p1++;
            $gal++;
         } else{ break; }
    } // endforeach $page

}

parser($domen, $url, 50, 2);

$end_time	=	microtime(true);
echo "<br><br>Время выполнения скрипта ".($end_time - $st_time)." сек.";
