 <script>
     // tracking payment
     jQuery(".tinkoffPayRow.btn").on('click',function(){
     	var t_sum = jQuery(this).prev().val();
     	console.log(t_sum);
     	console.log(t_ip);
     	// console.log( jQuery(this).closest('form').find('input').eq(3).val() );
     	// console.log( jQuery(this).next().val() );
     	var h = window.screen.availHeight;
     	var w = window.screen.availWidth;
     	var t_screen = w+"x"+h;
     	var data = { action: 'as21_trackpay',sum:t_sum,screen:t_screen};
     	jQuery.ajax({
     		url: a21_myajax.url,
     		data:data,
     		type:'POST', 
     		success:function(data){
     			// console.log("----data from WP AJAX ---");
     			// console.log("data="+data);
     			// console.log("data="+data.res);
     			// console.log(typeof data);
     			// if( data ) {   } else { console.log("data send with errors!");}
     		}
     	});

     });

 </script>

  <?php
}

add_action('wp_ajax_nopriv_as21_trackpay', 'alex_del_timeline');
add_action('wp_ajax_as21_trackpay', 'alex_del_timeline');

function alex_del_timeline(){

     $debug = false;
     if($debug){
          ini_set('error_reporting', E_ALL);
          ini_set('display_errors', 1);
          ini_set('display_startup_errors', 1);

          echo "wp_ajax_success!";
          print_r($_POST);
     }

     // date_default_timezone_set('Australia/Sydney');
     date_default_timezone_set('Europe/Moscow');
     $date = new DateTime('NOW');
     $date = $date->format('Y-m-d H:i:s');

     $text = $date." | ip:".$_SERVER['REMOTE_ADDR']." | ".$_POST['screen']." | sum: ".$_POST['sum']." rub\r\n";

     if($debug){
          echo 'ip:'.$_SERVER['REMOTE_ADDR'];
          echo 'date:'.$date;
          echo "\r\n";
          echo $text;
     }
     
     function as21_wjm_write_file_jobs_count($filename,$text){
          echo 'work write file';
          chmod($filename, 0777);
          $fp = fopen($filename, "a"); // 'a' - write end file
          $write = fwrite($fp, $text); 
          // var_dump($write); // if > 0 - success
          fclose($fp); 
     }
     as21_wjm_write_file_jobs_count($_SERVER['DOCUMENT_ROOT'].'/filename.txt',$text);

     exit;
}

/******************** new version  *******************/

add_action("wp_footer", "as21_user_resolution_os");

function as21_user_resolution_os(){
?>
 <script>
        // var a21_myajax_url = "http:\/\/aussieglo4.loc\/wp-admin\/admin-ajax.php";
        var a21_myajax_url = "<?php echo site_url();?>/wp-admin/admin-ajax.php";
        // console.log(t_sum);
        // console.log(t_ip);
        // console.log( jQuery(this).closest('form').find('input').eq(3).val() );
        // console.log( jQuery(this).next().val() );
        var h = window.screen.availHeight;
        var w = window.screen.availWidth;
        var t_screen = w+"x"+h;
        var data = { action: 'as21_trackpay',screen:t_screen};
        jQuery.ajax({
            url: a21_myajax_url,
            data:data,
            type:'POST', 
            success:function(data){
                // console.log("----data from WP AJAX ---");
                // console.log("data="+data);
                // console.log("data="+data.res);
                // console.log(typeof data);
                // if( data ) {   } else { console.log("data send with errors!");}
            }
        });


 </script>
  <?php
}

add_action('wp_ajax_nopriv_as21_trackpay', 'alex_del_timeline');
add_action('wp_ajax_as21_trackpay', 'alex_del_timeline');

function alex_del_timeline(){

    $block_ips = array('127.0.0.1','5.165.99.57');
    if ( array_search($_SERVER['REMOTE_ADDR'], $block_ips) !== false ) exit;

     $debug = false;
     if($debug){
          ini_set('error_reporting', E_ALL);
          ini_set('display_errors', 1);
          ini_set('display_startup_errors', 1);

          echo "wp_ajax_success!";
          print_r($_POST);
     }

     // date_default_timezone_set('Australia/Sydney');
     date_default_timezone_set('Europe/Moscow');
     $date = new DateTime('NOW');
     $date = $date->format('Y-m-d H:i:s');

     $text = $date." | ip:".$_SERVER['REMOTE_ADDR']." | ".$_POST['screen']." | ".$_SERVER['HTTP_REFERER']." | ".$_SERVER['HTTP_USER_AGENT']."\r\n";

     if($debug){
          echo 'ip:'.$_SERVER['REMOTE_ADDR'];
          echo 'date:'.$date;
          echo "\r\n";
          echo $text;
     }
     
     function as21_wjm_write_file_jobs_count($filename,$text){
          // echo 'work write file';
          chmod($filename, 0777);
          $fp = fopen($filename, "a"); // 'a' - write end file
          $write = fwrite($fp, $text); 
          // var_dump($write); // if > 0 - success
          fclose($fp); 
     }
     // save in public_html directory
     as21_wjm_write_file_jobs_count($_SERVER['DOCUMENT_ROOT'].'/filename.txt',$text);

     exit;
}