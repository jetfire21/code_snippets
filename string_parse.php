<?php
// - #1

/* ********Обработка строк (обрезка / поиск) в php ****** */

// Находит последнее вхождение подстроки Пример: https://twitter.com/ottawafoodbank 
echo $str = substr(strrchr($str,"/"), 1); // вернет ottawafoodbank

// - #2

/* ********** ищет в файлы все скрипты js,считает количество
результаты смотреть в режиме исходного кода 
view-source:http://test.dev/find_page_js/find_page_js.php
************* */

// preg_match_all("|<[^>]+>(.*)</[^>]+>|U",
//     "<b>пример: </b><div align=\"left\">это тест</div>",
//     $out, PREG_SET_ORDER);
// echo $out[0][0] . ", " . $out[0][1] . "\n";
// echo $out[1][0] . ", " . $out[1][1] . "\n";

// <script type='text/javascript' src='/wp-content/themes/buddyapp/assets/js/functions.min.js?ver=1.4'></scrip
// $str = "<script type='text/javascript' src='/wp-content/themes/buddyapp/assets/js/functions.min.js?ver=1.4'></script>ggggg
// <script type='text/javascript' src='/wp-content/plugins/buddypress-media/lib/touchswipe/jquery.touchSwipe.min.js?ver=4.3.1'></script>gdfgfdg
// fgfgfgfg
// <script type='text/javascript' src='/wp-includes/js/imagesloaded.min.js?ver=3.2.0'></script>fgfdgfg
// <img src='1.jpg'>fgfdgfg
// <script type='text/javascript' src='/wp-includes/js/masonry.min.js?ver=3.3.2'></script>
// <script type='text/javascript' src='/wp-includes/js/jquery/jquery.masonry.min.js?ver=3.1.2b'></script>
// <script type='text/javascript' src='/wp-content/themes/buddyapp-child/js/a21_common.js?ver=4.7.3'></script>
// <script type='text/javascript' src='/wp-includes/js/wp-embed.min.js?ver=4.7.3'></script>
// gsdgji0hg0gr0ug89fdgjkfgj
// <script type='text/javascript' src='/wp-content/themes/buddyapp-child/job_manager/wp-job-manager-tags/assets/js/tag-filter.js?ver=1.0'></script>";

// $homepage = file_get_contents('http://www.example.com/');
$str = file_get_contents('test2.php');

// echo "\r\n<br>исходная строка ======\r\n\r\n<br>".$str;
$str = addslashes($str);

// echo "\r\n\r\n<br>экранированная строка ======\r\n\r\n<br>".$str;

$after_pregmatch = preg_match_all("#<script[^>]+#i", $str, $match);

echo "\r\n\r\n<br>Результаты обработки ======\r\n\r\n<br>";

echo "\r\n\r\n<br> var_dump pregmatch = ";
var_dump($after_pregmatch);

echo "\r\n\r\n<br>match ======\r\n\r\n<br>";
// print_r($match);

echo "\r\n\r\n<br>match[0] ======\r\n\r\n<br>";
print_r($match[0]);

if(!empty($match[0])){

	echo "\r\n\r\n Все внешние js \r\n\r\n";

	$i = 1;
	foreach ($match[0] as $k => $v) {
		// <script type=\'text/javascript\' src=\'/wp-content/themes/buddyapp/assets/js/functions.min.js?ver=1.4\'
		$count = preg_match("#src=(.)+#i", $v,$match2);
		if($count > 0):
			$js_name = str_replace("\'", "", $match2[0]);
			$js_name = str_replace('\"', "", $js_name);
			$js_name = str_replace("src=", "", $js_name);
			echo $i." - ".$js_name."\r\n";
			$i++;
		else:
			$inline_js[] = $k;
		endif;
	}

	if(empty($inline_js)) exit;
	echo "\r\n\r\nинлайновый js, то есть нет src-не подключается в виде внешнего файла\r\n";
	foreach ($inline_js as $k => $v) {
		echo $v.", ";
	}
}

/* ********** ищет в файлы все скрипты js,считает количество
результаты смотреть в режиме исходного кода 
view-source:http://test.dev/find_page_js/find_page_js.php
************* */

/* ****  извлекает числа из строки **** */
$str = 'here any 234 $ text';
$str = preg_replace("/[^0-9]/", '', $str);
/* ****  извлекает числа из строки **** */

/* **** as21 разбивает строку на подстроку (будет работаь быстрее чем регулярка) **** */
	// $mail = 'as_fds35@ya.ru';
	$mail = $post_validate['user_email'];
	$user_mail = explode('@', $mail);
	$username = $user_mail[0]; // as_fds35
/* **** as21 разбивает строку на подстроку **** */

/* **** получить текст между тэгами **** */
$html_crop =  preg_match_all('#<h3 class="r"><(.+?)</h3>#is', $html, $match);
