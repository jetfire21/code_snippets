<?php
/* ****** обновление сразу нескольких строк за 1 запрос *********** */
if( !empty($_POST['data']) ){
	foreach ($_POST['data'] as $v) {
		$post_title .= $wpdb->prepare("WHEN %d THEN %s ",(int)$v['timel_id'],sanitize_text_field($v['timel_title']));
		$post_content .= $wpdb->prepare("WHEN %d THEN %s ",(int)$v['timel_id'],sanitize_text_field($v['timel_content']));
		$post_date .= $wpdb->prepare("WHEN %d THEN %s ",(int)$v['timel_id'],sanitize_text_field($v['timel_date']));
		$post_id .= (int)$v['timel_id'].",";
	}
	$post_id = substr($post_id, 0,-1);
	// echo $post_title;
	$update_query = "UPDATE $wpdb->posts SET
			    post_title = CASE id {$post_title} END,
			    post_content = CASE id {$post_content} END,
			    post_excerpt = CASE id {$post_date} END WHERE id IN({$post_id})";
	// echo $update_query."<hr>";
   $wpdb->query($update_query);
/* 
  UPDATE wp8k_posts SET 
	post_title = CASE id WHEN 10374 THEN 'alex title 1' WHEN 10375 THEN 'alex title 2' END, 
	post_content = CASE id WHEN 10374 THEN 'a desc 1' WHEN 10375 THEN 'a desc 2' END,
	post_excerpt = CASE id WHEN 10374 THEN '21 Mar 2017' WHEN 10375 THEN '20 Mar 2017' END
		WHERE id IN(10374,10375)
*/
}

/* ****** обновление сразу нескольких строк за 1 запрос *********** */

/* ****** добавление сразу нескольких строк за 1 запрос *********** */
if( !empty($_POST['new_data']) ){
	$user = wp_get_current_user();
	$member_id = $user->ID;
	foreach ($_POST['new_data'] as $item) {
		$val .= $wpdb->prepare("(%s,%s,%s,%d,%s),",sanitize_text_field($item['timel_title']),sanitize_text_field($item['timel_content']),sanitize_text_field($item['timel_date']),(int)$member_id,"alex_timeline");
	}
	$val = substr($val, 0,-1);
	$insert_query = "INSERT INTO $wpdb->posts (post_title,post_content,post_excerpt,post_parent,post_type) VALUES {$val}";
	echo $insert_query;
	$wpdb->query($insert_query);
}
/*
INSERT INTO wp8k_posts (post_title,post_content,post_excerpt,post_parent,post_type)
	VALUES ('alex title 3','desc 3','15 Mar 2017',14,'alex_timeline'),
		('a title 4','desc 4','01 Mar 2017',14,'alex_timeline'),
		('a title 5','desc 5','04 Mar 2017',14,'alex_timeline')
*/
/* ****** добавление сразу нескольких строк за 1 запрос *********** */

/* ****** получение значения auto_increment у любой таблицы (работает только через phpmyadmin почему то) *********** */
$last_id = $wpdb->get_var("SELECT 'AUTO_INCREMENT' FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='gbo' AND TABLE_NAME ='{$wpdb->posts}'");
echo "last_id = ".$last_id;
// вариант 2-рабочий
$get_id = $wpdb->get_row("SHOW TABLE STATUS LIKE '{$wpdb->posts}'"); 
$last_post_id = $get_id->Auto_increment;

/* ** получение несколькоих строк из одной таблицы за один запрос ********* */

 $geolocation = $wpdb->get_col($wpdb->prepare("(SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key='geolocation_lat' 
 AND post_id=%d LIMIT 1) UNION (SELECT meta_value FROM {$wpdb->postmeta}
 WHERE meta_key='geolocation_long' AND post_id=%d LIMIT 1)",(int)$v,(int)$v));
$location .= "{lat: ".$geolocation[0].", lng: ".$geolocation[1]."},";
/* ** получение несколькоих строк из одной таблицы за один запрос ********* */

/***** проверка: есть ли у таблицы колонка (check exist column in table db ******/

global $wpdb;
$row = $wpdb->get_results("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = '{$wpdb->prefix}bp_groups_calendars' AND column_name = 'event_slug'"  );
// alex_debug(1,1,"",$row);
// if(!empty($row)) { echo "has value";  ... in no value - add new column in db  }
if(empty($row)){
   $wpdb->query("ALTER TABLE {$wpdb->prefix}bp_groups_calendars ADD event_slug VARCHAR(200) NOT NULL");
   // ALTER TABLE `wp8k_bp_groups_calendars` ADD `event_slug` VARCHAR(200) NOT NULL AFTER `last_edited_stamp`;
// $wpdb->query("ALTER TABLE wp_customer_say ADD say_state INT(1) NOT NULL DEFAULT 1");
}
/***** проверка: есть ли у таблицы колонка ******/

/***** извлечь строку/ряд с sql защитой ******/
$event = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}bp_groups_cal WHERE group_id = %d AND id = %d", $group_id, $event_id ) );

/* **** as21 добавление правильной даты в формате mysql нужное потом для сортировки по этому полю post_date **** */

$date_timeline = $wpdb->get_results( "SELECT ID,post_excerpt FROM ".$wpdb->posts." WHERE post_type='alex_timeline'" );
// alex_debug(0,1,"",$date_timeline);

foreach ($date_timeline as $date) {
	$parse_date = date("Y-m-d",strtotime($date->post_excerpt));
	$query = $wpdb->prepare( "UPDATE " . $wpdb->posts."
			SET post_date=%s WHERE post_type=%s AND ID=%d
			",$parse_date, 'alex_timeline',(int)$date->ID);
	$wpdb->query( $query );
	//deb_last_query();
}

/* **** as21 добавление правильной даты в формате mysql нужное потом для сортировки по этому полю post_date **** */

$wpdb->delete( $wpdb->posts, array( 'ID' => $id ), array( '%d' ) ); 


// в конкретном наборе категорий (2,5,8) найти категории с указанным ключом (более быстрый точный запрос)
 $wpdb->query("SELECT term_id,meta_id,meta_key,meta_value FROM gorp21_termmeta WHERE term_id IN (50,59,63,52) AND meta_key='txcat_section_title' ORDER BY meta_id");
// запрос с подзапросом ( находит всю инфу о категории у который во второй таблице есть нужный ключ) хотя это можно делать в 2 отдельных запроса, получить все id категорий из второй таблицы отфильтровав по ключу и затем уже по cat_id вытащить всю инфу о категории
$get_cat_subsection = $wpdb->get_results("SELECT * FROM gorp21_terms INNER JOIN gorp21_termmeta ON ( gorp21_terms.term_id = gorp21_termmeta.term_id ) WHERE gorp21_termmeta.meta_key = 'txseo_seo_title'"); 



/* **** as21 **** */

$wpdb->insert(
	$wpdb->posts,
	array( 'post_author' => $post['user_id'], 'post_date'=>current_time('mysql'),'post_type' => 'as21_orders','post_parent'=>$prod_id,'menu_order'=>$price,'comment_count'=> $_SESSION['products'][$prod_id]['count'] ),
	array( '%d','%s', '%s','%d', '%d', '%d' )
);