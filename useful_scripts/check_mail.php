<?php
/* 
на хостинге hostiq.ua с cpanel тестировал,письма доходят на все 3 ящика в папку Входяющие,разве что только замочек желтный перечеркнутый
(возможно не надежный отправитель),а на хостинге digitalpacific.com.au cpanel почему-то все в спам попадало (там пришлось пересылку forwarding добавить)
*/
header('Content-Type: text/html; charset=utf-8');

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);


/* на бесплатных хостингах чаще всего отключают mail() чтобы защититься от спама */

echo 'test work php function mail()<br>';

$to = 'freerun-2012@yandex.ru'; 
$to2 = 'alexey@webyourway.com.au'; 
$to3 = 'oenomaus2013@mail.ru'; 
$sitename = $_SERVER['HTTP_HOST'];
$subject = "Subject";
$message = "test work mail: SUCCESS 00-36! \r\n";
$headers = "From: {$sitename} <admin@".$sitename.">\r\nContent-type:text/plain; charset=utf-8\r\n";
// var_dump(mail($to2,$subject,$message,$headers) );

if( mail($to,$subject,$message,$headers) ) echo 'Success! mail send ! '.$to;
else echo 'error! mail not send!';

if( mail($to2,$subject,$message,$headers) ) echo '<br>Success! mail send! '.$to2;
else echo 'error! mail not send!';

if( mail($to3,$subject,$message,$headers) ) echo '<br>Success! mail send! '.$to3;
else echo 'error! mail not send!';