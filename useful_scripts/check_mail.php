<?php
header('Content-Type: text/html; charset=utf-8');

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);


/* на бесплатных хостингах чаще всего отключают mail() чтобы защититься от спама */

echo 'test work php function mail()<br>';

$to = 'freerun-2012@yandex.ru'; 
$to2 = 'alexey@webyourway.com.au'; 
$sitename = $_SERVER['HTTP_HOST'];
$subject = "Subject";
$message = "test work mail: SUCCESS ! \r\n";
$headers = "From: {$sitename} <admin@".$sitename.">\r\nContent-type:text/plain; charset=utf-8\r\n";
// var_dump(mail($to2,$subject,$message,$headers) );
if( mail($to2,$subject,$message,$headers) ) echo 'Success! mail send!';
else echo 'error! mail not send!';