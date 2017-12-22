<?php
проблема связанная с именованием файлов
когда делаешь бекапы,там исопользуется механизм архивации,который не дружит с кирилическими названиями файлов,поэтому для названия файлов изображений лучше использовать транслит или английские буквы

########### wp replace url in DB #############
1
http://dugoodr.com
http://dugoodr2.dev

2
/home/dugoodr6/public_html/
/home/jetfire/www/dugoodr2.dev/
------
/home/dugoodr6/public_html/bb-config.php
/home/dugoodr6/public_html/wp-content/

3
2F%2Fdugoodr.com
2F%2Fdugoodr2.dev
-----
link="url:http%3A%2F%2Fdugoodr.com%2Fi-am%2Fawesome|||"][vc_custom_heading text="SHOWCASE ALTRUISM"

4
http://www.dugoodr.com
http://www.dugoodr2.dev

возможно еще:
@dugoodr.com
@dugoodr2.dev
postmeta ROW 3015, COLUMN `META_VALUE`  dugoodr.com
http:\/\/dugoodr.com\/wp-content\

#####################

НАСТРОЙКА САЙТА ДЛЯ РАБОТЫ ПО HTTPS

Если для работы с сайтом должен использоваться протокол HTTPS, после установки сертификата производится настройка защищенного соединения для всех элементов и страниц сайта.

В первую очередь осуществляется переадресация сайта на защищенный протокол HTTPS. Переадресация с протокола HTTP на протокол HTTPS реализуется добавлением в файл .htaccess следующих директив:

RewriteEngine on
RewriteCond %{HTTP:HTTPS} !=on [NC]
RewriteRule ^(.*)$ https://yourdomain.com/$1 [R=301,L]
SetEnvIf X-Forwarded-Proto https HTTPS=on
где "yourdomain.com" - имя домена, для которого используется сертификат.

Также производится проверка всех ссылок на сайте на предмет явного использования протокола HTTP. При наличии элементов, открывающихся по небезопасному протоколу, соединение будет считаться недоверенным, и информация об этом отобразится в адресной строке.

Проверить страницы сайта можно с помощью следующего сервиса https://www.whynopadlock.com/

При наличии элементов, доступных только по протоколу HTTP, ссылки на них меняются на относительные (к примеру, вместо http://yourdomain.com/content/pic.jpg в коде страницы ссылка должна иметь вид /content/pic.jpg), либо явно указывается использование протокола HTTPS (в таком случае ссылка будет иметь вид https://yourdomain.com/content/pic.jpg").

Также меняются ссылки для элементов, загружаемых с внешних ресурсов. Например, если на сайте используется скрипт, доступный по адресу http://externaldomain.us/scripts/ad.js, эта ссылка должна быть изменена на //externaldomain.us/scripts/ad.js или https://externaldomain.us/scripts/ad.js. Обратите внимание, что сайт, на котором расположен элемент, также должен иметь валидный SSL-сертификат.

Wordpress

В административной панели Wordpress производится смена протокола в адресе сайта. Для этого в разделе "Настройки" > "Общие", в полях "Адрес WordPress" и "Адрес сайта" протокол "http" меняется на "https". В конфигурационном файле (wp-config.php) добавляется следующая строка define('FORCE_SSL_ADMIN', true);

КАК УКАЗАТЬ ПОИСКОВЫМ СИСТЕМАМ, ЧТО САЙТ ЯВЛЯЕТСЯ ЗАЩИЩЕННЫМ

Компания Google рассматривает использование HTTPS на сайте в качестве фактора ранжирования. Для корректного индексирования сайта по протоколу HTTPS компания Google рекомендует соблюдать следующие правила:

Перенаправляйте пользователей и поисковые системы на страницу HTTPS или ресурс с переадресацией 301 на стороне сервера для адресов HTTP.
Используйте относительные URL для ресурсов, которые находятся на одном защищенном домене.
Например, для перехода на страницу на вашем сайте example.com, использовать a href="/about/ourCompany.php" предпочтительнее, чем a href="https://example.com/about/ourCompany.php" . Это гарантирует, что ваши ссылки и ресурсы всегда будут использовать HTTPS. За счет этого также уменьшается вероятность ошибок в локальном развитии сайта, так как изображения, страницы и другие ресурсы загружаются из локальной среды разработки, а не из производственной среды.

Используйте схожие по протоколам URL-адреса для всех остальных доменов (например //petstore.example.com/dogs/biscuits.php ), или обновите ссылки своего сайта для перехода непосредственно на ресурс HTTPS.

!!! на страницах все протоколы http:// заменить на https:// иначе в строке браузера не будет отображаться "НАДЕЖНЫЙ"

##################

/* ******* запись всех ошибок в файл .log ****************** */

// Turn debugging on
define('WP_DEBUG', true);
 
// Tell WordPress to log everything to /wp-content/debug.log
define('WP_DEBUG_LOG', true);
 
// Turn off the display of error messages on your site
define('WP_DEBUG_DISPLAY', false);
 
// For good measure, you can also add the follow code, which will hide errors from being displayed on-screen
@ini_set('display_errors', 0);

// path log - /home/jetfire/www/graphite-pro.dev/wp-content/debug.log.

/* ******* запись всех ошибок в файл .log ****************** */

/* **** as21 debug function **** */
add_action("wp_footer","as21_cb_function");

function as21_cb_function(){

  // it wll work if site.ru/?dev=1
  if( (bool)$_GET['dev'] == true ) {

  }
}

/******** отправка писем через gmail smtp c плагиноам wp-mail-smtp
тестировал с wp 4.7.3,сработало только если во from email вставить то же что и в username *******/

Mailer: SMTP
SMTP Host: smtp.gmail.com
SMTP Port: 465
Encryption: SSL
Authentication: Yes
! From Email: graphitepro21@gmail.com
! Username: graphitepro21@gmail.com

From Email — адрес, с которого будут отправляться письма и на который получатель отправит ответ, нажав на кнопку «Ответить» в своей почте.
From Name — имя отправителя, можно указать название сайта или свое имя и фамилию.
Mailer — отправка писем через системный транспорт (функция mail()) или через SMTP-сервер. Выбираем «Send all WordPress emails via SMTP».
SMTP Host — адрес SMTP-сервера. Можно узнать у службы поддержки или в справочном разделе. Для Яндекс Почты используйте smtp.yandex.ru, для Gmail — smtp.gmail.com.
SMTP Port — порт SMTP-сервера, зависит от типа шифрования (Encryption). Для Яндекс Почты и Gmail используйте порт 465.
Encryption — тип шифрования. Для Яндекс почты и Gmail необходимо установить «Use SSL encryption».
Authentication — требуется ли выполнять авторизацию на почтовом сервере. Устанавливаем «Yes: Use SMTP authentication».
Username — логин от почты. Как правило, полный адрес почтового ящика, должен совпадать со значением, указанным в поле From Email.
Password — пароль от почтового ящика.

/* ****  проверка работы sendmail или через SMTP **** */

// Загружаем WordPress
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
$headers = "From: {$sitename} <" .$from. ">\r\nContent-type:text/plain; charset=utf-8\r\n";
if( wp_mail($to, 'Тема', 'Проверка работы wp_mail', $headers) ) echo "mail send success!"; else echo "mail send error!";

/* ****  проверка работы sendmail или через SMTP **** */

/* когда функция не оцепляется unhook function */

function alex_remove_junk() { remove_action( 'bp_before_group_body','kleo_bp_group_title', 1 ); }
add_action( 'after_setup_theme', 'alex_remove_junk', 999 );

/* когда функция не оцепляется unhook function */


/* ************************************************ */
/* Just a quick note for anyone importing demo content, I imported the demo content including all attachments, but got a white page, I found the solution to this problem in the faq:
Why do I see a white screen when importing demo content?
If you get a white screen or some other error when trying to import our demo content, this probably happens because of the maximum execution time limit. You need to increase the maximum execution time (upload time) setting of your web server. The default maximum execution time on web servers is 30 seconds. Please increase it to 120 seconds. Possible ways of achieving this are:
average for wp themes */
By Wp-config.php changes - set_time_limit(120);
In htaccess - php_value max_execution_time 120;
In php.ini file - max_execution_time = 120
/* *****
Recommended PHP Configuration Limits for wp AVADA theme
If the import stalls and fails to respond after a few minutes, or it fails with a simple error message like “Import failed,” You are suffering from PHP configuration limits that are set too low to complete the process. You should contact your web host and ask them to increase those limits to a minimum as follows:
*/
max_execution_time 180
memory_limit 128M
post_max_size 32M
upload_max_filesize 32M

	
define( 'WP_MEMORY_LIMIT', '64M' );

// время выполнения скрипта
// 1.
@ini_set( 'max_execution_time', '400' );
ini_set('max_execution_time', 400);

// 2.Adapting the /.htaccess file of your WordPress installation
php_value max_execution_time 60

/* ************************************************ */

/* ******* измерение времени выполнения скрипта ********* */
$st_time = microtime(true);
$end_time = microtime(true);
echo ($end_time - $st_time);

// форматировани текста (все переносы строк заменяет на <p> или <br>
 wpautop( $foo, $br );
	
/* права на каталоги

Относительный путь	Предлагаемое значение	установ Значение	Результат
/	755	755	OK	
wp-includes	755	755	OK	
wp-admin	755	755	OK	
wp-admin/js	755	755	OK	
wp-content	755	755	OK	
wp-content/themes	755	755	OK	
wp-content/plugins	755	755	OK	
wp-content/uploads	755	755	OK	
wp-config.php	444	666	ПРЕДУПРЕЖДЕНИЕ	
.htaccess	444	644	ПРЕДУПРЕЖДЕНИЕ

права на каталоги */

http://underscore.loc/wp-login.php?action=register
Ну и наконец, отключи регистрацию новых пoльзователей, если в этом нет необходимости. Настройки-Общие-Членство..снять галочку!!!

/* 
!!!чтобы wpscan kali linux не детектил username/pass нужно создать нового пользователя с правами админа,после чего войти
через него и удалить учетную запись админа созданую по умолчанию
Проверить через http://yroki-kompa.ru/?author=1

 ******Prevent Enumeration of Usernames****** */
RewriteCond %{QUERY_STRING} ^/?author=([0-9]*)
RewriteRule ^ /? [L,R=301]
	
/* ************** создать в папке /wp-admin/ .htaccess *********** */
<Files install.php>
Order Deny,Allow
Deny from all
</Files>
/* ************** создать в папке /wp-admin/ .htaccess *********** */
	
/* *********** запрет доступа к http://site.ru/xmlrpc.php ************ */

<Files xmlrpc.php>
Order Deny,Allow
Deny from all
</Files>
    
 /* *********** запрет доступа к http://site.ru/xmlrpc.php ************ */

 /* *********** запрет доступа к http://site.ru/wp-login.php ************ */
/* Файл wp-login копируем, переименовываем в любое странное имя, например poletnormalny.php и внутри файла автозаменой меняем все надписи wp-login.php на poletnormalny.php.
Все, теперь к админке можно обратиться только по вашему файлу. не удалять wp-login.php!
Не полное решение:
Но это ещё не всё! Теперь нужно немного пошаманить над файлом general-template.php в папке wp-includes. Если оставить его без изменений,
то кнопки выхода, регистрации, восстановления пароля работать не будут! Поэтому немного изменим этот файл
*/
<Files wp-login.php>
Order Deny,Allow
Deny from all
</Files>
	
<Files readme.html>
Order Deny,Allow
Deny from all
</Files>

/* ***********код запрещает выполнение php или прямое обращение к PHP файлам, находящимся в этих папках************ */
	
<FilesMatch "\.([Pp][Hh][Pp]|[Cc][Gg][Ii]|[Pp][Ll]|[Ph][Hh][Tt][Mm][Ll])\.?.*">
Order allow,deny
Deny from all
</FilesMatch>
 /* ***********код запрещает выполнение php или прямое обращение к PHP файлам, находящимся в этих папках************ */



/* **********отладка sql-запросов ********** */	
// для работы $wpdb->queries нужно включить define('SAVEQUERIES', true );
 if (current_user_can('administrator')){
   global $wpdb;
   echo "<pre>";
   print_r($wpdb->queries);
   echo "</pre>";
 }
 //Lists all the queries executed on your page   echo "</pre>";
function deb_last_query(){

	global $wpdb;
	echo '<hr>';
	echo "<b>last query:</b> ".$wpdb->last_query."<br>";
	echo "<b>last result:</b> "; echo "<pre>"; print_r($wpdb->last_result); echo "</pre>";
	echo "<b>last error:</b> "; echo "<pre>"; print_r($wpdb->last_error); echo "</pre>";
	echo '<hr>';
}


/* **********отладка sql-запросов ********** */	

/* ***** переопределение функций родительской темы или плагина *********** */

// функции задаются с проверкой function_exists,то можете ее переопределить
// функции повешены на акшены или фильтры вы можете их отключить/отвязать 
// подробнее https://wpcafe.org/tutorials/pereopredelenie-funktsiy-roditelskoy-temyi-v-docherney-na-wordpress/
if ( ! function_exists ( 'my_function' ) ) {
    function my_function() {
        // Contents of your function here.
    }
}
/* ***** переопределение функций родительской темы или плагина *********** */

/* ***** использование фильтра обьявленный в каком-то плагине *********** */
$result['showing'] = apply_filters( 'job_manager_get_listings_custom_filter_text', $message, $search_values );

// чтобы вернуть значение 2 переменной,обзяательно указать кол-во параметров в фильтре
add_filter( 'job_manager_get_listings_custom_filter_text',"a21_q",100,2 );
function a21_q($message, $search_values){
   var_dump($message);
   return $message;
}
/* ***** использование фильтра обьявленный в каком-то плагине *********** */

/* ********** hide username in login form ******************** */

// add_filter('login_errors',create_function('$a', "return null;"));

add_filter( 'login_errors', function( $error ) {
	global $errors;
	$err_codes = $errors->get_error_codes();

	// Invalid username.
	// Default: '<strong>ERROR</strong>: Invalid username. <a href="%s">Lost your password</a>?'
	if ( in_array( 'invalid_username', $err_codes ) ) {
		$error = '<strong>ERROR</strong>: Invalid username/password.';
	}

	// Incorrect password.
	// Default: '<strong>ERROR</strong>: The password you entered for the username <strong>%1$s</strong> is incorrect. <a href="%2$s">Lost your password</a>?'
	if ( in_array( 'incorrect_password', $err_codes ) ) {
		$error = '<strong>ERROR</strong>: Invalid username/password.';
	}
	return $error;
} );
/* ********** hide username in login form ******************** */

/* Как запретить редактирование файлов через админку
В общем, если я вас убедил и вы захотите отключить возможность редактирования файлов плагинов и тем, вставьте эту строчку в wp-config.php:
Теперь редактор будет полностью недоступен, даже если попробовать обратиться к нему по прямой ссылке.
wp-config.php:	
*/
define('DISALLOW_FILE_EDIT', true);

/* Как запретить редактирование файлов через админку */


/* ************* Для улучшения безопасности ******** */

// отключить вывод мета тэга "generator" и другого лишнего кода
remove_action('wp_head', 'wp_generator');
remove_action( 'wp_head', 'feed_links_extra', 3 ); 
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); 
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action('wp_head', 'wp_shortlink_wp_head');
//отключение xml-rpc
add_filter('xmlrpc_enabled', '__return_false');

/* *** отключение REST API WP начиная с версии 4.4 *********** */

// Отключаем сам REST API
add_filter('rest_enabled', '__return_false');

// Отключаем фильтры REST API
remove_action( 'xmlrpc_rsd_apis',            'rest_output_rsd' );
remove_action( 'wp_head',                    'rest_output_link_wp_head', 10, 0 );
remove_action( 'template_redirect',          'rest_output_link_header', 11, 0 );
remove_action( 'auth_cookie_malformed',      'rest_cookie_collect_status' );
remove_action( 'auth_cookie_expired',        'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_username',   'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_hash',       'rest_cookie_collect_status' );
remove_action( 'auth_cookie_valid',          'rest_cookie_collect_status' );
remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );

// Отключаем события REST API
remove_action( 'init',          'rest_api_init' );
remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
remove_action( 'parse_request', 'rest_api_loaded' );

// Отключаем Embeds связанные с REST API
remove_action( 'rest_api_init',          'wp_oembed_register_route'              );
remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );

remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
// если собираетесь выводить вставки из других сайтов на своем, то закомментируйте след. строку.
remove_action( 'wp_head',                'wp_oembed_add_host_js'                 );

/* ************* Для улучшения безопасности ******** */

/* ************** варианты подключения js и css *********** */

 // подключение js скриптов для всех страниц
add_action( 'wp_enqueue_scripts', 'css_js_for_theme' );
function css_js_for_theme(){
  // wp_deregister_script( 'jquery' );
  //  wp_enqueue_script('jquery', get_template_directory_uri()."/libs/jquery/jquery_1.8.3.min.js",'','',true);

   if( is_page('fotogalereya')){ 
   	wp_enqueue_style( 'lightbox-css', get_template_directory_uri()."/libs/lightbox/css/lightbox.min.css");
       wp_enqueue_script('lightbox-js', get_template_directory_uri()."/libs/lightbox/js/lightbox.min.js",array('jquery'),'',true);
    }
	
	// отключение js скрипта у плагина и подключение вместо него другого
	// http://my-wp.dev/wp-content/plugins/wp-job-manager/assets/js/ajax-filters.js
	wp_deregister_script( 'wp-job-manager-ajax-filters' );
	wp_enqueue_script( 'wp-job-manager-ajax-filters', plugins_url() . '/wp-job-manager/assets/js/ajax-filters.js', '','', true );
}

 add_action('wp_enqueue_scripts', 'alex_user_js');

 function alex_user_js(){
	wp_enqueue_script( 'frontend-js', plugins_url( 'frontend.js', __FILE__ ), array('jquery'),'', true );
	wp_localize_script( 'jquery', 'ajax_obj', array('url' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce('vote-nonce')));
 }

 // в обработчике шорткода-подключение js скриптов во фронтенде,только на страницах где есть например шорткод 

wp_enqueue_script( 'frontend-js', plugins_url( 'frontend.js', __FILE__ ), array('jquery'),'', true );
wp_localize_script( 'jquery', 'ajax_obj', array('url' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce('vote-nonce')));

/* ************** варианты подключения js и css *********** */

/* ************** скрывает плагин со страницы плагинов(не скрывает элементы в меню и Appearence-editor *********** */
add_filter( 'all_plugins', 'hide_plugins');
function hide_plugins($plugins)
{
  // Hide hello dolly plugin
  /*
  if(is_plugin_active('hello.php')) {
    unset( $plugins['hello.php'] );
  }
  */
  // Hide disqus plugin
  if(is_plugin_active('wp-job-manager-field-editor/wp-job-manager-field-editor.php')) {
    unset( $plugins['wp-job-manager-field-editor/wp-job-manager-field-editor.php'] );
  }
  return $plugins;
}
/* ************** скрывает плагин со страницы плагинов(не скрывает элементы в меню и Appearence-editor *********** */

/* ************** правильная настройка времени на сайте wp *********** */

current_time('mysql'); // по умолчанию возвр время utc+4 (для москвы надо ставить utc+3 в консоль/настройки/общие/часовой пояс)

/* ************** добавить фильтр к шорткоду *********** */
$shortcode = do_shortcode('[mingleforum]');
echo apply_filters('my_new_filter',$shortcode);

add_filter('my_new_filter','my_new_filter_callback');

function my_new_filter_callback($shortcode){
    //to stuff here
    return $shortcode;
}
/* ************** добавить фильтр к шорткоду *********** */

/* *********** передача параметров в шаблон wordpress ************ */

function get_template_part_with_data($slug, array $data = array()){
    $slug .= '.php';
    extract($data);
 
    require locate_template($slug);
}



/* *********** передача параметров в шаблон woocommerce ************ */

function get_template_part_with_data($slug, array $data = array()){
    $slug .= '.php';
    $slug =  WC()->template_path().$slug;
    extract($data);

     require locate_template($slug);
}


<h1>woocommerce.php</h1>

<?php


/* ********* поучение всех категорий пользовательской таксономии ****************** */

$taxonomyName = "product_cat";
$prod_categories = get_terms($taxonomyName, array(
    'orderby'=> 'name',
    'order' => 'ASC',
    'hide_empty' => 0
));  

foreach( $prod_categories as $prod_cat ) :
    if ( $prod_cat->parent != 0 )
        continue;
    $cat_thumb_id = get_woocommerce_term_meta( $prod_cat->term_id, 'thumbnail_id', true );
    // $cat_thumb_url = wp_get_attachment_thumb_url( $cat_thumb_id );
    $cat_thumb_url = wp_get_attachment_image( $cat_thumb_id,'full' );
    $term_link = get_term_link( $prod_cat, 'product_cat' );
 ?>

    <!-- <img  src="<?php echo $cat_thumb_url; ?>" alt="" />  -->
    <?php echo $cat_thumb_url; ?>
    <a class="button" href="<?php echo $term_link; ?>"> <?php echo $prod_cat->name; ?> </a> 

<?php
 endforeach; 
wp_reset_query();


/* ****** показывает все хуки и все функции вызванные в них ********** */
function list_hooked_functions($tag=false){

     global $wp_filter;
     if ($tag) {
      $hook[$tag]=$wp_filter[$tag];
      if (!is_array($hook[$tag])) {
      trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
      return;
      }
     }
     else {
      $hook=$wp_filter;
      ksort($hook);
     }
     echo '<pre>';
     foreach($hook as $tag => $priority){
      echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
      ksort($priority);
      foreach($priority as $priority => $function){
      echo $priority;
      foreach($function as $name => $properties) echo "\t$name<br />";
      }
     }
     echo '</pre>';
     return;
}
list_hooked_functions();

/* ****** показывает все хуки и все функции вызванные в них ********** */

// show all callbaks for some hook/filter by priority
   global $wp_filter;
   alex_debug(0,1,'',$wp_filter['wp_title']);
   alex_debug(0,1,'',$wp_filter['wp_head'])

/* ********* получение всех категорий по пользовательской таксономии ****************** */

$args = array(
    'type'         => 'product',
    'child_of'     => 0,
    'parent'       => '',
    'orderby'      => 'name',
    'order'        => 'ASC',
    'hide_empty'   => 0,
    'hierarchical' => 1,
    'exclude'      => '',
    'include'      => '',
    'number'       => 0,
    'taxonomy'     => 'product_cat',
    'pad_counts'   => false,
);
$categories = get_categories( $args );
print_r($categories);



?>


<?php



/* ********* вывод по пользовательскому запросу ****************** */

$params = array('posts_per_page' => 5, 'post_type' => 'product');
$wc_query = new WP_Query($params);
?>
<?php if ($wc_query->have_posts()) : ?>
<?php while ($wc_query->have_posts()) :
                $wc_query->the_post(); ?>
<?php the_title(); ?>
<?php the_post_thumbnail(); ?>
<?php the_content(); ?>
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>
<?php else:  ?>
<p>
     <?php _e( 'No Products'); ?>
</p>
<?php endif; ?>


<?php
$params = array(  'pagename' => 'o-nas');
$page_o_nas = new WP_Query($params);
?>
<?php if ($page_o_nas->have_posts()) : ?>
<?php while ($page_o_nas->have_posts()) : $page_o_nas->the_post(); ?>
    <?php the_title(); ?>
    <?php the_post_thumbnail(); ?>
    <?php the_content(); ?>
<?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
<?php else:  ?>
    <p> no content</p>
<?php endif; ?>


 <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>

        <?php the_title();?>
        <?php the_post_thumbnail();?>
        <?php the_permalink();?>

<?php endwhile; // end of the loop. ?>
<?php  else:?>
    <h3 class="error">not found</h3>
<?php endif; ?>

<?php
/****** выбриает все посты которые принадлежат к указанной группе (связь с таблицей_postmeta) ************/

$args_meta = array(
      'meta_key' => '_job_group_a21',
      'meta_value' => 14,
      'meta_type' => "NUMERIC",
      'meta_compare' => "=",
      'post_type' => 'job_listing',
      'posts_per_page' => 5
    );
$job = new WP_Query($args_meta);

/****** выбриает все посты которые принадлежат к указанной группе (связь с таблицей_postmeta) ************/


// получение всех url изображений галлереи продукта

  global $product;
 $attachment_ids = $product->get_gallery_attachment_ids();

foreach( $attachment_ids as $attachment_id ) 
{
  echo $image_link = wp_get_attachment_url( $attachment_id );
}



/* *** To display metabox for specific template page use: ******* */
/* *** Отображение plugin meta box на определенном шаблоне страницы ******* */

$post_id = (isset($_GET['post'])) ? $_GET['post'] : $_POST['post_ID'];
$template = get_post_meta( $post_id, '_wp_page_template', true );

if($template == "tpl_contact.php") {
//Your metaboxes
}




/* ************ буферизированный вывод ********** */


ob_start();
wc_cart_totals_order_total_html();
$a = ob_get_contents();
ob_end_clean();
echo $a;

// вывод опции
 echo get_option('option_address'); 

/* **********for adding a new field to the options-general.php page
добовление новой опции в существующую страницу опций (пример options-general.php)********* */

add_action( 'admin_init', 'alex21_register_settings' );
/*  Register settings */
function alex21_register_settings() 
{
    register_setting( 
        'general', 
        'option_facebook',
        'as21_sanitize_cb_url' // <--- Customize this if there are multiple fields
    );
    
    add_settings_field( 
        'facebook_id', 
        'Facebook:', 
        'alex21_add_html_for_option_facebook', 
        'general'
        // 'site-guide' 
    );
}    

function as21_sanitize_cb_url($url){
	return esc_url_raw($url);
	// return strip_tags($a);
	// if( preg_match('#^(http|https):\/\/(www\.)??[a-z0-9-\.]+(\.){1}(com|ru|net)\/??#i', $url) ) return $url;
	// else return false;
}

function alex21_add_html_for_option_facebook() 
{
    // $value = html_entity_decode (get_option( 'option_facebook' ));
    $value = get_option( 'option_facebook' );
    echo '<input type="url" class="regular-text" id="facebook_id" name="option_facebook" value="' . esc_url( $value ) . '"/>
    		<p class="description">Пример: http://facebook.com</p>';
}

add_action( 'admin_init', 'alex21_register_settings' );

/*  Register settings */
function alex21_register_settings() 
{
    register_setting( 
        'general', 
        'option_address',
        'esc_html' // <--- Customize this if there are multiple fields
    );
    register_setting( 
        'general', 
        'option_phone',
        'esc_html' // <--- Customize this if there are multiple fields
    );
    // add_settings_section( 
    //     'site-guide', 
    //     'Name section', 
    //     '__return_false', 
    //     'general' 
    // );

    add_settings_field( 
        'phone_id', 
        'Телефон:', 
        'alex21_add_html_for_option_phone', 
        'general'
        // 'site-guide' 
    );

    add_settings_field( 
        'address_id', 
        'Адрес:', 
        'alex21_add_html_for_option', 
        'general'
        // 'site-guide' 
    );

}    

/* Print settings field content */
function alex21_add_html_for_option_phone() 
{
    $value = html_entity_decode (get_option( 'option_phone' ));
    echo '<input type="text" class="regular-text" id="phone_id" name="option_phone" value="' . esc_attr( $value ) . '"/>';
}

function alex21_add_html_for_option() 
{
    $value = html_entity_decode (get_option( 'option_address' ));
    echo '<textarea class="large-text code" id="address_id" name="option_address">' . esc_attr( $value ) . '</textarea>';
}

// вывод этих опций во фронтенде
echo get_option('option_phone');

/* *************end  for adding a new field to the options-general.php page******* */


/* ************ поиск фразы в url адресной строки ********** */

 $link_cat_gal = $_SERVER['REQUEST_URI'];
 if( preg_match("/brands/i", $link_cat_gal))  $gal_cat = 'brands';



/* **************** custom post type - movies ************************ */

add_action('init', 'custom_type_movie');
function custom_type_movie()
{
  $labels = array(
  'name' => 'Movies', // Основное название типа записи
  'singular_name' => 'Movie', // отдельное название записи типа Book
  'add_new' => 'Add new',
  'add_new_item' => 'Add new movie',
  'edit_item' => 'Edit movie',
  'new_item' => 'New movie',
  'view_item' => 'View movie',
  'search_items' => 'Search movie',
  'not_found' =>  'Not found',
  'not_found_in_trash' => 'No found in trash',
  'parent_item_colon' => '',
  'menu_name' => 'Movies'

  );
  $args = array(
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'show_ui' => true,
  'show_in_menu' => true,
  'query_var' => true,
  'rewrite' => true,
  'capability_type' => 'post',
  'has_archive' => true,
  'hierarchical' => false,
  'menu_position' => null,
  'supports' => array('title','editor','thumbnail')
  );
  register_post_type('movie',$args);
}

/* **************** custom post type - movies ************************ */

/* **************** fix bug keyworks for home page if use static front page - Platinum Seo Pack ************************ */

// echo "==========================".var_dump($this->is_static_front_page())."---------";
if ( (is_home() && get_option('aiosp_home_keywords') ) || $this->is_static_front_page() ) { // || $this->is_static_front_page()) {

/* **************** fix bug keyworks for home page if use static front page - Platinum Seo Pack ************************ */

/* ****** delete jquery-migrate.js for correct work external jquery scripts (example shadowbox-js timeliner.js etc) *** */

add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );

function remove_jquery_migrate( &$scripts){
    // if(!is_admin()){
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ) );
    // }
}
	
/* ****** delete jquery-migrate.js for correct work external jquery scripts (example shadowbox-js timeliner.js etc) *** */

/* *** disable standart wordpress style ***** */

function alex_dequeue_default_css() {
  wp_dequeue_style('bootstrap');
  wp_deregister_style('bootstrap');
}
add_action('wp_enqueue_scripts','alex_dequeue_default_css',100);

/* *** disable standart wordpress style ***** */

/* **** get name page template (получение названия шаблона страницы) ****** */
// (можно также узнать через <body class="..." )
add_action("wp_footer","wp_get_name_page_template");

function wp_get_name_page_template(){

    global $template;
    // echo basename($template);
    // полный путь с названием шаблона страницы
    echo "1- ".$template;

	echo "<br>2- ".$page_template = get_page_template_slug( get_queried_object_id() )." | ";
	// echo $template = get_post_meta( $post->ID, '_wp_page_template', true );
	// echo $template = get_post_meta( get_queried_object_id(), '_wp_page_template', true );
	// echo "id= ".get_queried_object_id();
	echo "<br>3- ".$_SERVER['PHP_SELF'];
	echo "<br>4- ".__FILE__;
	echo "<br>5- ".$_SERVER["SCRIPT_NAME"];
	echo "<br>6- ".$_SERVER['DOCUMENT_ROOT'];
	print_r($_SERVER);
}	

/* **** get name page template (получение названия шаблона страницы) ****** */

# ##### запрет выполнения php в каталоге (добавить в .htaccess во внуть папки ##########
 php_flag engine  off   
# ##### запрет выполнения php в каталоге (добавить в .htaccess во внуть папки ##########

/* ***** простое сркытие администратора от других пользователей в админ панели ************** */

add_action('pre_user_query','yoursite_pre_user_query');
function yoursite_pre_user_query($user_search) {
	global $current_user;
	$username = $current_user->user_login;

	global $wpdb;
	$user_search->query_where = str_replace('WHERE 1=1',
	"WHERE 1=1 AND {$wpdb->users}.user_login != 'alex'",$user_search->query_where);
}

function hide_user_count(){
?>
	<style>
	.wp-admin.users-php span.count {display: none;}
	</style>
	<?php
}

add_action('admin_head','hide_user_count');

/* ***** простое сркытие администратора от других пользователей в админ панели ************** */
	 
/* вывод системных/отладочных данных в форматированном виде */
function alex_debug ( $show_text = false, $is_arr = false, $title = false, $var, $var_dump = false, $sep = "| "){

    // e.g: alex_debug(0, 1, "name_var", $get_tasks_by_event_id, 1);
    $debug_text = "<br>========Debug MODE==========<br>";
    if( (bool)($show_text) ) echo $debug_text;
    if( (bool)($is_arr) ){
        echo "<br>".$title."-";
        echo "<pre>";
        if($var_dump) var_dump($var); else print_r($var);
        echo "</pre>";
    } else echo $title."-".$var;
    if( is_string($var) ) { if($sep == "l") echo "<hr>"; else echo $sep; }
}

/* вывод системных данных в форматированном виде */ 

/* ********** вывод всех дочерних категорий родительской категории ****************** */

  $subcatlist = get_categories(
          array(
          'child_of' => $category_id,
          'orderby' => 'name',
          'order' => 'ASC',
          'hide_empty' => '0'
          ) );
  alex_debug(0,1,'',$subcatlist);
  foreach ($subcatlist as $subcat) {
    echo '<span>'.$subcat->name.'</span>';
  }

/* ********** вывод всех дочерних категорий родительской категории ****************** */


/* ********** переопределние фильтра плагина (по умолчанию выводилась версия,после замены ничего не выводит) ****************** */

// echo apply_filters('show_nextgen_version', '<!-- <meta name="NextGEN" version="'. $ngg->version . '" /> -->' . "\n");
add_filter('show_nextgen_version', 'add_text_to_content');
function add_text_to_content($content){
	// $out = "";
	return $out;
}
/* ********** переопределние фильтра плагина (по умолчанию выводилась версия,после замены ничего не выводит) ****************** */

/* ****** получение всех данных из класса находясь вне класса ********** */

add_action("wp_footer","alex_get_data_from_class");
function alex_get_data_from_class(){
	if ( class_exists('BP_Member_Reviews') ){
		$class = new BP_Member_Reviews();
		echo "REVIEWS = ".$class->version;
	}
}

/* private метод нельзя переопределить в дочерних классах подробно обо всех модификаторах и области видимости
на http://php.net/manual/ru/language.oop5.visibility.php 
он доступен только из того класса,где обьявлен,иначе будет выводиться fatal error
[04-Apr-2017 23:12:28 UTC] PHP Fatal error:  Call to private method sMyles_Updater_v2::add_notice() from context '' in /home/jetfire/www/dugoodr2.dev/wp-content/themes/buddyapp-child/job_manager/wp-job-manager-groups/index.php on line 199
 Добавление методов извне в принципе не есть хорошо
 В итоге если нужно переопределить private метод,то скорее всего придется создать fork плагина,если CLASS большой,если маленький то можно попробовать переопределить его в functions.php
 */
	
/* ****** получение всех данных из класса находясь вне класса ********** */

https://wordpress.stackexchange.com/questions/36013/remove-action-or-remove-filter-with-external-classes
/*** один из вариантов переопределения метода класса какого-то плагина ***/

/* this variable in some plugin where have class BP_Member_Reviews
global $BP_Member_Reviews;
$BP_Member_Reviews = new BP_Member_Reviews();
*/
// if exist,then unregister some method this class - e.g. embed_rating()
if(class_exists('BP_Member_Reviews')){
	global $BP_Member_Reviews;
	alex_debug(1,1,"BP_Member_Reviews",$BP_Member_Reviews);
	remove_action('bp_profile_header_meta', array($BP_Member_Reviews, 'embed_rating'));
	add_action("bp_profile_header_meta","a21_override_bp_mr_embed_rating");
	function a21_override_bp_mr_embed_rating(){
		echo "a21 new_html========";
	}
}
/*** один из вариантов переопределения метода класса какого-то плагина ***/

// add_action('wp_ajax_bp_user_review',   array($this, 'ajax_review'),300);
// add_action('wp_ajax_bp_user_review',   array("BP_Member_Reviews", 'ajax_review'),300);

add_action('wp_ajax_bp_user_review','ajax_review_override',1);
function ajax_review_override(){

if ( class_exists('BP_Member_Reviews') ){

  }
}

/*
Overloading is defining functions that have similar signatures, yet have different parameters. Overriding is only pertinent to derived classes, where the parent class has defined a method and the derived class wishes to override that method.

In PHP, you can only overload methods using the magic method __call.

An example of overriding:

<?php

class Foo {
   function myFoo() {
      return "Foo";
   }
}

class Bar extends Foo {
   function myFoo() {
      return "Bar";
   }
}

$foo = new Foo;
$bar = new Bar;
echo($foo->myFoo()); //"Foo"
echo($bar->myFoo()); //"Bar"
*/
	
  public static function instance() {
  if ( is_null( self::$_instance ) ) {
    self::$_instance = new self();
  }
  return self::$_instance;
}
  
/*
ставил плагин SI CAPTCHA Anti-Spam с показом капчи в виде изображения,и все ранво спам приходил!!!!
***** отличная защита wp сайта от спама ************* */

add_filter( 'comment_form_defaults', 'antispam_comment_form_textarea' );
function antispam_comment_form_textarea( $defaults ) {
	 $defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment">Ваш комментарий</label><textarea id="comment" style="display: none;" name="comment"></textarea><textarea id="real-comment2" name="real-comment2" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true"></textarea></p>';
	$defaults['comment_notes_after'] = '';
  	$defaults['title_reply'] = __( 'Поделитесь своими мыслями' );
	return $defaults;
}
 
// Защита от спама в комментариях
add_filter('init', 'verify_spam');
function verify_spam($commentdata) {
      $spam_test_field = trim($_POST['comment']);
  if(!empty($spam_test_field)) wp_die('Спаму нет!');
      $comment_content = trim($_POST['real-comment2']);
      $_POST['comment'] = $comment_content;
  return $commentdata;
}

/* ********** отличная защита wp сайта от спама ************* */
?>

<!-- ----- custom field frontend добавление поля загрузки изображения с проверкой типа файла и его сохранение
в wp-contents/uploads/ чтобы добавить в базу данных надо использовать кастомный sql запрос  ------ -->

<!-- html разметка-->
<form action="" enctype="multipart/form-data" id="form" method="post" name="form">
<div id="upload">
<input id="file" name="file" type="file">
</div>
<input id="submit" name="submit" type="submit" value="Upload">
</form>
<!-- a21-->

<?php
if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

$uploadedfile = $_FILES['file'];
$upload_overrides = array( 'test_form' => false );

// $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
$mimes = array('png' => 'image/png','gif'=> 'image/gif','jpg'=> 'image/jpeg');
$movefile = wp_handle_upload($uploadedfile, array('test_form' => false, 'mimes' => $mimes));

if ( $movefile && ! isset( $movefile['error'] ) ) {
    echo "File is valid, and was successfully uploaded.\n";
    echo "<hr>".$movefile['url']."<hr>";
    var_dump( $movefile );
} else {
    echo $movefile['error'];
}

$event_image = $wpdb->get_var( "SELECT meta_value FROM {$wpdb->prefix}bp_groups_groupmeta WHERE group_id='{$group_id}' AND meta_key='a21_bgc_event_image'");
?>
<img src="<?php echo $event_image;?>" alt="">

?>
<!------- добавление поля загрузки изображения с проверкой типа файла и его сохранение в wp-contents/uploads/
чтобы добавить в базу данных надо использовать кастомный sql запрос  -------->


<!-- добавление поля загрузки изображения с проверкой типа файла и его сохранение в wp-contents/uploads/
 как attacmnent в таблице postmeta и posts-->

<form id="featured_upload" method="post" action="" enctype="multipart/form-data">
	<input type="file" name="my_image_upload" id="my_image_upload"  multiple="false" />
	<input type="hidden" name="post_id" id="post_id" value="3" />
	<?php // wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
	<input id="submit_my_image_upload" name="submit_my_image_upload" type="submit" value="Upload" />
</form>

<?php

// Check that the nonce is valid, and the user can edit this post.
if ( 
	isset( $_POST['submit_my_image_upload']) 
	// isset( $_POST['my_image_upload_nonce'], $_POST['post_id'] ) 
	// && wp_verify_nonce( $_POST['my_image_upload_nonce'], 'my_image_upload' )
	// && current_user_can( 'edit_post', $_POST['post_id'] )
) {
	// The nonce was valid and the user has the capabilities, it is safe to continue.

	// These files need to be included as dependencies when on the front end.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );
	
	// Let WordPress handle the upload.
	// Remember, 'my_image_upload' is the name of our file input in our form above.
	$attachment_id = media_handle_upload( 'my_image_upload', $_POST['post_id'] );
	
	if ( is_wp_error( $attachment_id ) ) {
		// There was an error uploading the image.
	} else {
		// The image was uploaded successfully!
		echo "The image was uploaded successfully!";
	}

} else {

	// The security check failed, maybe show the user an error.
	echo "The security check failed, maybe show the user an error";
}
echo "<br>get image url: ";
var_dump(wp_get_attachment_image_url(93));
?>

<!-- добавление поля загрузки изображения с проверкой типа файла и его сохранение в wp-contents/uploads/
 как attacmnent в таблице postmeta и posts-->	

<?php
/* очистка строки от всех лишних симоволов */
function str_clear($str) {
      // $str = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $str);
      $str = str_replace(array("\r\n", "\r", "\n", "\t", ' ','  ', '    ', '    '), '', $str);
      return $str;
}
/* очистка строки от всех лишних симоволов */

/******** регистрации сессии $_SESSION **********/

add_action('wp_ajax_a21_add_cart', 'alex_del_timeline');
add_action('wp_ajax_nopriv_a21_add_cart', 'alex_del_timeline');

function alex_del_timeline(){

	// To get the data on ajax hooked function -
	if( !session_id()) session_start();
	$abc = $_SESSION['s_var'];
	echo "wp_ajax_success! Price: ".$_POST['price']." ".$abc;
	exit;
}

function a21_register_session(){
    if( !session_id() )session_start();
}
add_action('init','a21_register_session');

// To set a SESSION data -
$_SESSION['s_var'] = "alex session";

/******** регистрации сессии $_SESSION **********/

/* ********* пример создание куки в wordpress ********* */
add_action( 'init', 'setting_my_first_cookie' );
function setting_my_first_cookie() {	
	global $wpdb;
	$table = $wpdb->prefix."bp_groups";
	$last_gr_id = $wpdb->get_var( "SELECT MAX(`id`) FROM {$table}");
	$new_gr_id = $last_gr_id + 1;
	setcookie("alex_new_gr_id", $new_gr_id,30 * DAYS_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN,is_ssl());
}
/* ********* пример создание куки в wordpress ********* */

/* ********* получение одной строки (одной ячейки) из базы данных ********* */
$group_rating = $wpdb->get_row($wpdb->prepare("SELECT meta_value FROM {$table} WHERE group_id = %d AND meta_key = %s",intval($group->id),"bpgr_rating")); 
echo $group_rating->meta_value;	

/* **** получение целого столбца (например все id, и изменение/добавление slug к нему ***** */

// echo $count_rows = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}bp_groups_calendars`");
// получить полностью один столбец (все id)
global $wpdb;
$ids = $wpdb->get_col("SELECT id FROM {$wpdb->prefix}bp_groups_calendars");
print_r($ids);

foreach($ids as $id){
	echo $event_title = $wpdb->get_var( "SELECT event_title FROM {$wpdb->prefix}bp_groups_calendars WHERE id='{$id}'");
	$event_title = strtolower($event_title);
	$event_slug = str_replace(" ", "_", $event_title);
	$query = 
	$wpdb->update(
		$wpdb->prefix."bp_groups_calendars",
		array( 'event_slug' => $event_slug, ),
		array( 'id' => $id )
	);
}
/* **** получение целого столбца (например все id, и изменение/добавление slug к нему ***** */

/**** чтобы добавить приставку .html для ссылок товаров в WooCommerce, нужно в файле функций functions.php разместить следующий код (взято отсюда): */

function wpse_178112_permastruct_html( $post_type, $args ) {
    if ( $post_type === 'product' )
        add_permastruct( $post_type, "{$args->rewrite['slug']}/%$post_type%.html", $args->rewrite );
}
 
add_action( 'registered_post_type', 'wpse_178112_permastruct_html', 10, 2 );
Если вы хотите сделать такой же формат ссылок для страниц категорий, то добавляете еще и такой код:

function wpse_178112_category_permastruct_html( $taxonomy, $object_type, $args ) {
    if ( $taxonomy === 'product_cat' )
        add_permastruct( $taxonomy, "{$args['rewrite']['slug']}/%$taxonomy%.html", $args['rewrite'] );
}
 
add_action( 'registered_taxonomy', 'wpse_178112_category_permastruct_html', 10, 3 );
/* 
Важно! После этого вам следует вернуться в раздел Permalinks (Постоянные ссылки) админки WordPress и сохранить настройки дабы URL’ы обновились. Теперь ссылки магазина будут по типу:
 http://site.ru/product-category/cars
 http://site.ru/product-category/cars.html
Я пытался по аналогии с категориями сделать такую же фишку и для тегов, но, к сожалению, у меня ничего не вышло. То есть сама ссылка с html генерируется системой, но при попадании на страницу появляется ошибка 404.
чтобы удалить косую черту во всех url нужно в общих настройках permalinks в поле произвольно добавить /%postname%
*/


/* **** as21 скрыть родительский каталог товара из url ( http://my-wp.dev/product-category/xiaomi/redmi/ ) в настройках permalinks product base insert in field
. минус выдает 404 ошибку при переходе на страницу продуктов если они внутри категории 3 уровня 
https://gist.github.com/vovadocent/2c9510bd748c6ef1d05252b9034a67cf
https://rudrastyh.com/wordpress/remove-taxonomy-slug-from-urls.html
Remove Taxonomy Base Slug - 4 года не обновлялся,но тем не менее работает прекрасно
1 lv-http://gorproms.dev/katalogi-chetra
2 lv-http://gorproms.dev/katalogi-chetra/t-9-01ya-yam
3 lv-http://gorproms.dev/katalogi-chetra/t-9-01ya-yam/0902-01-1sp-sp
http://gorproms.dev/product/testovyj-tovar
http://gorproms.dev/katalogi-chetra/t-9-01ya-yam.html - такой url не удалось сделать 2 другим программистам с фриланса
**** */

add_filter('request', function( $vars ) {
	global $wpdb;
	var_dump($vars);
	if( ! empty( $vars['pagename'] ) || ! empty( $vars['category_name'] ) || ! empty( $vars['name'] ) || ! empty( $vars['attachment'] ) ) {
		$slug = ! empty( $vars['pagename'] ) ? $vars['pagename'] : ( ! empty( $vars['name'] ) ? $vars['name'] : ( !empty( $vars['category_name'] ) ? $vars['category_name'] : $vars['attachment'] ) );
		$exists = $wpdb->get_var( $wpdb->prepare( "SELECT t.term_id FROM $wpdb->terms t LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id WHERE tt.taxonomy = 'product_cat' AND t.slug = %s" ,array( $slug )));
		if( $exists ){
			$old_vars = $vars;
			$vars = array('product_cat' => $slug );
			if ( !empty( $old_vars['paged'] ) || !empty( $old_vars['page'] ) )
				$vars['paged'] = ! empty( $old_vars['paged'] ) ? $old_vars['paged'] : $old_vars['page'];
			if ( !empty( $old_vars['orderby'] ) )
	 	        	$vars['orderby'] = $old_vars['orderby'];
      			if ( !empty( $old_vars['order'] ) )
 			        $vars['order'] = $old_vars['order'];	
		}
	}
	return $vars;
});


/* **** 1-получение/удаление опции 2-получение списка всех таблиц у базы данных 3-удаление одной таблицы **** */

add_action("wp_footer","as21_temp_func");
function as21_temp_func(){
	if( current_user_can('administrator') && is_front_page()){

		global $wpdb;

		echo "<h3>for debug:</h3>";
		$option = "bp_group_calendar_installed";
		echo " option:: $option=".get_option($option);
		// if( delete_option( $option ) ) echo "<br>$option - success delete";

		// $tables = $wpdb->get_results("SHOW TABLES FROM dugoodr2");
		$tables = $wpdb->get_results("SHOW TABLES FROM dugoodr6_wp956");
		echo "count tables=".count($tables);echo "<br>";
		alex_debug(0,1,"",$tables);

		// $wpdb->query("DROP TABLE {$wpdb->prefix}bp_groups_calendars;");
	}
}

/* **** as21 запретить переход всем пользователем к консоли /wp-admin кроме администраторов (limiting access to dashboard non-admin users) **** */
add_action( 'init', 'blockusers_init' );
function blockusers_init() {
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_redirect( home_url() );
		exit;
	}
}

/* **** as21 hide adminbar for non-admin users **** */
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}

/* **** as21 создание дополнительных метаполей у категории (в данном коде раздел) c плагином acf (advanced custom fields)
Пример: каталоги четра->T-9.01 - раздел 1 кабина (список категорий) - раздел 2 Двигатель (список категорий) и т.д. **** */
add_action('wp_footer','as21_acf_get_suction_from_cat');
function as21_acf_get_suction_from_cat(){

	$product_categories = get_categories(
 	array(
		// 'child_of'       => $parent_id,
		'child_of'       => 53,
		'menu_order'   => 'ASC',
		'hide_empty'   => 0,
		'hierarchical' => 1,
		'taxonomy'     => 'product_cat',
		// 'pad_counts'   => 1,
	) );

	alex_debug(0,1,'',$product_categories);
	// var_dump( get_field('подраздел', 'product_cat_75') ); work
	$field_settings = get_field_object('as21subsection2','product_cat_'.$product_categories[0]->term_id); // get all data about field
	alex_debug(0,1,'',$field_settings ).'<br>';
	var_dump($field_settings['choices']);

	foreach ($product_categories as $cat) {
		// if( !empty(get_field('подраздел', 'product_cat_'.$cat->term_id) ) ) 
		// { $subsections[get_field('подраздел', 'product_cat_'.$cat->term_id)][] = $cat; }
		// echo get_field('подраздел', 'product_cat_'.$cat->term_id).'<br>';
		if( !empty(get_field('as21subsection2', 'product_cat_'.$cat->term_id) ) ) 
		{ $subsections[ $field_settings['choices'][get_field('as21subsection2', 'product_cat_'.$cat->term_id)] ][] = $cat; }
		// echo get_field('as21subsection2', 'product_cat_'.$cat->term_id).'<br>';
		// alex_debug(0,1,'', get_fields( 'product_cat_'.$cat->term_id)).'<br>';
	}
	ksort($subsections);
	alex_debug(0,1,'',$subsections);

}
/* **** as21 создание дополнительных метаполей у категории (в данном коде раздел) c плагином acf */

/* **** добавление к меню нового пункта/ссылки/элемента html ********* */

add_filter( 'wp_nav_menu_items', 'your_custom_menu_item', 10, 2 );
function your_custom_menu_item ( $items, $args ) {
    if ( $args->theme_location == 'primary') {
    	// $cart_prod_count = ( WC()->cart->get_cart_contents_count() > 0
        $items .= '<li class="as21_menu_cart"><span>'.WC()->cart->get_cart_contents_count().'</span><a href="/cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>';
    }
    return $items;
}
/* **** as21 **** */


/* **** цепляемся за ajax добавление товара в корзину (ползено когда нужно обновить количество товара при клике на добавить товар в кастомной миникорзине) */
add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );
function iconic_cart_count_fragments( $fragments ) {
    
    $fragments['li.as21_menu_cart span'] = '<span>' . WC()->cart->get_cart_contents_count() . '</span>';
    // var_dump($fragments);
    // exit;
    return $fragments;    
}
/* **** as21 **** */

/* **** as21 **** * перенос сайта с сохранениме структуры ссылок на wp

site.ru/product-category/cars/sport/bmw замена на
site.ru/cars/sport/bmw.html
такое не реализуемо..возможно только 1 из них либо тольуо удаление /product-category/ либо только добавление .html

Использование редиректа с кодом 301
Наиболее корректный с точки зрения поисковых машин метод перенаправления страниц — редирект с кодом 301. Таким образом пользователи, использующие старый URL страницы, будут попадать на новую, а для поисковых роботов 301-редирект дает понять, что страница окончательно перемещена и находится в новом месте. 

Перед настройкой редиректа надо провести тщательный анализ, учитывая различные факторы, такие как содержимое и значимость страниц. Затем уже можно принимать решение, для каких страниц он необходим. Редирект при изменении URL точно нужно устанавливать для страниц, которые:
приносят целевой трафик;
важны для конверсии;
имеют обратные ссылки;
играют роль в привлечении пользователей.
На остальные страницы можно установить ошибку 404 и сделать ссылку для пользователей на новые основные страницы сайта. Для поисковиков этот сигнал будет означать о том, что страница окончательно удалена. По мере переиндексации эти страницы исчезнут из поиска, а их место займут новые URL. 

Массовый редирект
Если сайт имеет большое количество страниц с важным содержимым и обратными ссылками, и пересмотреть структуру с объединением невозможно, то в таком случае используется массовый постраничный редирект. Этот процесс достаточно трудоемкий, так как требует прописывания всех старых и новых адресов в файле .htaccess. Среди весомых минусов данного способа большие затраты времени, медленная работа сервера из-за большого массива данных в .htaccess и высокая вероятность ошибки при вводе адресов. 
*/

/* **** as21  заглушка для сайта на техническое обслуживание **** */

# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{REQUEST_URI} !/maintenance.html$ [NC]
RewriteCond %{REQUEST_URI} !\.(jpe?g?|png|gif) [NC]
RewriteRule .* /maintenance.html [R=302,L]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress

/* **** получение/удаление опции 2-получение списка всех таблиц у базы данных 3-удаление одной таблицы **** */

/* **** программное добавление продуктов,товаров в базу данных woocommerce **** */

echo 'a777';
$products['Name'] = 'продукт 1 добавл программно';
$products['Description'] = 'описание продукт 1 добавл программно';
$products['SKU'] = 3423423434;
$post_id = wp_insert_post( array(
    'post_author' => 1,
    'post_title' => $products['Name'],
    'post_content' => $products['Description'],
    'post_status' => 'publish',
    'post_type' => "product",
    // 'post_category' => array(20,26)
) );

// if we are in frontend
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$url = 'http://b2b.berghoffworldwide.ru/catalog_xml_export/productsPhoto/1399843/01.jpg';
$desc = "";

// Download an image from the specified URL and attach it to a post
$attachment = media_sideload_image( $url, $post_id, $desc,'id' ); // arg 'id' only with wp 4.8
// set featured image to post
$add_meta = add_post_meta($post_id, '_thumbnail_id', $attachment);
if($add_meta) echo 'added successfully!';
else "error when added";

// Relates an object (post, link etc) to a term and taxonomy type (tag, category, etc). Creates the term and taxonomy relationship if it doesn't already exist.
wp_set_object_terms( $post_id, 20, 'product_cat' );

wp_set_object_terms( $post_id, 'simple', 'product_type' );
update_post_meta( $post_id, '_visibility', 'visible' );
update_post_meta( $post_id, '_stock_status', 'instock');
update_post_meta( $post_id, 'total_sales', '0' );
update_post_meta( $post_id, '_downloadable', 'no' );
update_post_meta( $post_id, '_virtual', 'yes' );
update_post_meta( $post_id, '_regular_price', '400' ); // цена внтурти отдельного продукта
update_post_meta( $post_id, '_sale_price', '' );
update_post_meta( $post_id, '_purchase_note', '' );
update_post_meta( $post_id, '_featured', 'no' );
update_post_meta( $post_id, '_weight', '' );
update_post_meta( $post_id, '_length', '' );
update_post_meta( $post_id, '_width', '' );
update_post_meta( $post_id, '_height', '' );
update_post_meta( $post_id, '_sku', 111111 ); // артикул
update_post_meta( $post_id, '_product_attributes', array() );
update_post_meta( $post_id, '_sale_price_dates_from', '' );
update_post_meta( $post_id, '_sale_price_dates_to', '' );
update_post_meta( $post_id, '_price', '401' ); // цена в таблице продуктов
update_post_meta( $post_id, '_sold_individually', '' );
update_post_meta( $post_id, '_manage_stock', 'no' );
update_post_meta( $post_id, '_backorders', 'no' );
update_post_meta( $post_id, '_stock', '' );

/* **** as21 **** */

add_action('wp_ajax_bp_user_review1', 'ajax_review2');
add_action('wp_ajax_nopriv_bp_user_review1', 'ajax_review2');
function ajax_review2(){
  echo 'output test text in js console-------';
  // $a['res'] = 'aaa';
  // echo json_encode($a);
  exit;
}


var data = { 'action': 'bp_user_review1'};
$.ajax({
  url: BP_User_Reviews.ajax_url,
  // data:$(this).serialize(), 
  data:data,
  type:'POST', 
  success:function(data){
      console.log("----data from WP AJAX ---");
      console.log("data="+data);
      console.log("data="+data.res);
      console.log(typeof data);
      if( data ) {   } else { console.log("data send with errors!");}
  }
 });

/*

 get_header('shop') is a Wordpress function that will try to load the file header-shop.php from your theme root folder. So, you must look in your theme root folder for it. You must know that if this file dosen't exists Wordpress will load the default header.php file or you can create it.
if((is_tax() && taxonomy_exists('product_cat') && $current_tax == "product_cat") || is_singular('product')) { echo ''; } elseif (((is_home()|| is_page() || is_single()) && intval(get_post_meta($post_id , 'title-show', true)) == 0) && !is_front_page()) { ?> <div id="page-header" class="container"> <div class="page-header-content row-fluid"> <div class="title span12"> <?php $title = get_post_meta($post_id, 'title-content', true); if($title == '') $title = '<h1>'.get_the_title($post_id).'</h1>';
is_cart - Returns true when viewing the cart page.
is_product - Returns true when viewing a single product.
is_checkout
is_account_page
is_shop - Returns true when viewing the product type archive (shop).
Thanks for fast response I've also found the answer as you mentioned. Let me describe for more detail. We can override it by creating our own template with the format taxonomy-product_cat-{slug}.php e.g. if our category is named 'abc product', go to check the url we'll see it display as abc-product. Then our template should be named as taxonomy-product_cat-abc-product.php 
accepted
The cart and checkout are standard pages with short codes and aren't included in the other Woo templates, i.e. is_woocommerce() won't return true for them. So perhaps use
if ( is_page( 'checkout-page-slug' ) || is_page( 'other_shop_page' ) ) {
instead to target them.
Edit:
Replace checkout-page-slug or other_shop_page with the slug of a page you want to target to have the shop header:
if ( ! is_woocommerce() ) {
    if ( is_home() ) {
        // Home site header (Header 1)
    } elseif( is_page( 'checkout-page-slug' ) || is_page( 'other_shop_page' ) ) {
        // Shop header
    } else {
       // All site header (except Home) (Header 2)
    }
} else { // Woocommerce conditional
    // Shop header
}
*/
/*
image meta bpx
    [207] => Array
        (
            [width] => 150
            [height] => 150
            [file] => 2016/10/girl-pictures-16.jpg
            [sizes] => Array
                (
                    [thumbnail] => Array
                        (
                            [file] => girl-pictures-16-150x150.jpg
                            [width] => 150
                            [height] => 150
                            [mime-type] => image/jpeg
                        )
                    [medium_large] => Array
                        (
                            [file] => girl-pictures-16-768x480.jpg
                            [width] => 768
                            [height] => 480
                            [mime-type] => image/jpeg
                        )
                    [cat-movies] => Array
                        (
                            [file] => girl-pictures-16-400x553.jpg
                            [width] => 400
                            [height] => 553
                            [mime-type] => image/jpeg
                        )
                    [cat-gallery] => Array
                        (
                            [file] => girl-pictures-16-1059x662.jpg
                            [width] => 1059
                            [height] => 662
                            [mime-type] => image/jpeg
                        )
                    [prod_cat] => Array
                        (
                            [file] => girl-pictures-16-380x238.jpg
                            [width] => 380
                            [height] => 238
                            [mime-type] => image/jpeg
                        )
                    [shop_slider] => Array
                        (
                            [file] => girl-pictures-16-1522x951.jpg
                            [width] => 1522
                            [height] => 951
                            [mime-type] => image/jpeg
                        )
                    [shop_thumbnail] => Array
                        (
                            [file] => girl-pictures-16-180x180.jpg
                            [width] => 180
                            [height] => 180
                            [mime-type] => image/jpeg
                        )
                    [shop_catalog] => Array
                        (
                            [file] => girl-pictures-16-300x300.jpg
                            [width] => 300
                            [height] => 300
                            [mime-type] => image/jpeg
                        )
                    [shop_single] => Array
                        (
                            [file] => girl-pictures-16-600x600.jpg
                            [width] => 600
                            [height] => 600
                            [mime-type] => image/jpeg
                        )
                )
            [image_meta] => Array
                (
                    [aperture] => 0
                    [credit] => 
                    [camera] => 
                    [caption] => 
                    [created_timestamp] => 0
                    [copyright] => 
                    [focal_length] => 0
                    [iso] => 0
                    [shutter_speed] => 0
                    [title] => 
                    [orientation] => 0
                    [keywords] => Array
                        (
                        )
                )
            [ID] => 207
            [name] => girl-pictures-16.jpg
            [path] => E:\OpenServer\domains\wp-soho/wp-content/uploads/2016/10/girl-pictures-16.jpg
            [url] => http://wp-soho/wp-content/uploads/2016/10/girl-pictures-16-150x150.jpg
            [full_url] => http://wp-soho/wp-content/uploads/2016/10/girl-pictures-16.jpg
            [title] => girl-pictures-16
            [caption] => 
            [description] => 
            [alt] => 
            [srcset] => http://wp-soho/wp-content/uploads/2016/10/girl-pictures-16.jpg 1600w, http://wp-soho/wp-content/uploads/2016/10/girl-pictures-16-768x480.jpg 768w, http://wp-soho/wp-content/uploads/2016/10/girl-pictures-16-1059x662.jpg 1059w, http://wp-soho/wp-content/uploads/2016/10/girl-pictures-16-380x238.jpg 380w, http://wp-soho/wp-content/uploads/2016/10/girl-pictures-16-1522x951.jpg 1522w
        )
preg_match("/http*\/$/i",,$matches);
*/
