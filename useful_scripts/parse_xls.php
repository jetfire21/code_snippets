    <?php
/* PHPExcel - чтение и запись xls файлов,устарела..лучше использовать новую библиотеку phpspreadsheet,вручную тяжело поставить,только через composer,в wp composer еще
для этого нужно внедрить правильно */

    echo __FILE__;
    echo __DIR__;
    require_once 'PHPExcel.php';
    $excel = PHPExcel_IOFactory::load(__DIR__.'/stock.xls'); //абсолютный путь
    var_dump($excel->getSheetCount());

        // as21_debug(0,1,'',$excel->setActiveSheetIndex(0) );
    // Получаем активный лист
    // $sheet = $excel->getActiveSheet();
    // // var_dump($sheet);
    // exit;
    $i = 1;
        // формируем массив из всех листов
    foreach($excel ->getWorksheetIterator() as $worksheet) {
       $lists[] = $worksheet->toArray();
         // as21_debug(0,1,'',$worksheet);
         // as21_debug(0,1,'',$worksheet->toArray());
         // as21_debug(0,1,'',$lists);
   }
        // as21_debug(0,1,'',$excel);
     // $new_arr = array_diff($lists, array(''));
     // $lists=array_filter(array_map('array_filter', $lists));
   $i = 0;
   foreach ($lists[0] as $list) {
        // echo $list[0];
       if(!empty($list[0])) { $lists2[] = $list; $i++; }
   }
   echo '<br>количество строк (c учетом пустых) -'.count($lists[0]);
   echo '<br>количество заполненых строк -'.($i-1);

    unset($lists2[0]);
   as21_debug(0,1,'',$lists2);

   global $wpdb;

    function get_last_add_post_id(){
        global $wpdb;
        $get_id = $wpdb->get_row("SHOW TABLE STATUS LIKE '{$wpdb->posts}'"); 
           // var_dump($get_id);
        return $last_post_id = $get_id->Auto_increment-1;
    }

       $k = 1;
       foreach ($lists2 as $list) {
            // if($k == 3) break;

        $wpdb->insert(
            $wpdb->posts,
            array( 'post_author'=>'1', 'post_title'=>$list[0], 'post_date'=>current_time('mysql'),'post_type' => 'stockist','comment_status'=>'closed','ping_status'=>'closed'),
            array( '%d','%s','%s', '%s', '%s', '%s' )
        );
        $last_post_id = get_last_add_post_id();
        $wpdb->insert(
            $wpdb->postmeta,
            array( 'post_id'=>$last_post_id, 'meta_key'=>'_crb_address', 'meta_value'=>$list[1]),
            array( '%d','%s','%s' )
        ); 
           $wpdb->insert(
            $wpdb->postmeta,
            array( 'post_id'=>$last_post_id, 'meta_key'=>'_crb_postcode', 'meta_value'=>$list[2]),
            array( '%d','%s','%d' )
        );
        echo $list[0]."<br>";
        $k++;
     }