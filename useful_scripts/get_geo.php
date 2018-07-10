<?php
header('Content-Type: text/html; charset=utf-8');
// header('Content-Type: text/html; charset=windows-1251');
// windows-1251
$geo = file_get_contents('http://ipgeobase.ru/?address=176.59.112.41');
// echo $geo;
$start = "<table";
$final = "</table>";
preg_match('~rez_new(.*?)</table>~is', $geo, $m );
// var_dump($m);
var_dump($m[1]);

// preg_match('~Город(.*?)</tr>~is', $m[1], $m2 );
// var_dump($m2);
$tr = explode("<tr>",$m[1]);
var_dump( $tr);
echo $tr[3];

preg_match('~</td><td>(.*?)</tr>~is', $tr[3], $m2 );
var_dump($m2);
$td = explode("<td>",$tr[3]);
var_dump($td);
$td = trim(str_replace('</tr>', '', $td[1]) );
var_dump( $td);
$td =  mb_convert_encoding($td, 'utf-8', 'cp-1251'); // переконвертация кириллица windows-1251 в utf-8
// $td = mb_convert_encoding($td, 'cp-1251','utf-8');
echo $td;


// var_dump($m[1]);
// echo $m[1];
// <table class="rez_new"