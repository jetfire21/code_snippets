<?php
header('Content-Type: text/html; charset=utf-8');

// нужно еще анализ POST запросов сделать и возможность исключить ip админа из анализа

//считываем файл
/* 16 000 строк кода обработалось за 26 sec*/

$filename = 'web-dev-pro.ru.access.log';
 // рассмотрим файл как массив
$file_arr = file($filename); 

// подсчитываем количество строк в массиве 
$lines = count($file_arr); 
echo 'Количество записей в log файле -'.$lines;

//log файл расположить в той же директории что и исполняемый скрипт
$text=file_get_contents($filename);
//задаем шаблон регулярного выражения
$pattern='#(([0-9]{1,3}\.){3}[0-9]{1,3}).{1,}GET ([0-9a-z/\_\.\-]{1,})#i';
//вытаскиваем данные в массив matches
preg_match_all($pattern,$text,$matches);
$ip=array_count_values($matches[1]);
$adr=array_count_values($matches[3]);
//сортируем по убыванию
arsort($ip);
arsort($adr);
//выделяем десятку
$ip_10=array_slice($ip,0,10);
$adr_10=array_slice($adr,0,10);

echo "<h2>10 самых активных пользователей по ip адресу c GET запросом</h2>";
echo "IP Количество<br>";
foreach($ip_10 as $key=>$value)
{
	echo $key.' - '.$value."<br>";
}
echo "<hr>";
echo "<h2>10 самых посещаемых страниц</h2>";
echo "Страница Количество<br>";
foreach($adr_10 as $key=>$value)
{
	echo $key.' - '.$value."<br>";
}

echo "<h1>все ip-адреса с которых заходили на страницы сайта (с учетом повторных заходов)</h1>";

// echo $text;
$alex_pattern = "#(.+)\"GET / HTTP/1.0\" 200(.+)([\n\r]*)#i";
preg_match_all($alex_pattern, $text, $matches);
echo "<pre>"; print_r($matches[0]); echo "</pre>";

foreach ($matches[0] as $k => $v) {
	$pattern_ip = "#([0-9]{1,3}\.){3}[0-9]{1,3}#i";
	preg_match($pattern_ip, $v, $matches);
	$ip_index[] = $matches[0];
	// echo "<pre>"; print_r($matches); echo "</pre>";
}
// echo "<pre>"; print_r($ip_index); echo "</pre>";
$count_access_page = array_count_values($ip_index);
arsort($count_access_page);
echo "<pre>"; print_r( $count_access_page ); echo "</pre>";

foreach ($count_access_page as $k => $v) {
	if($v > 1) $cnt_acc_page[$k] = $v;
}

echo "<pre>"; print_r( $cnt_acc_page); echo "</pre>";


