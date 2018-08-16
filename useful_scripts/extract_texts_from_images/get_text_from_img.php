<?php

/* extract text form image use ABBYY Cloud OCR SDK */

  // 1. Send image to Cloud OCR SDK using processImage call
  // 2.	Get response as xml
  // 3.	Read taskId from xml

  // !!! Please provide your application id and password and remove this line !!!
  // To create an application and obtain a password,
  // register at http://cloud.ocrsdk.com/Account/Register
  // More info on getting your application id and password at
  // http://ocrsdk.com/documentation/faq/#faq3
  // Name of application you created


ini_set('max_execution_time', '700');
$st_time = microtime(true);


// $response = '{\cs15\lang1033\langfe1033\b0\i0\ul0\strike0\scaps0\fs22\afs22\charscalex100\expndtw0\cf1\dn0 "Vibrancy}';
//   preg_match('#\'93(.*?)}#is', $response, $m );
//   preg_match('# "(.*?)}#is', $response, $m2 );
//   print_r($m);
//   print_r($m2);
//   $str = strtolower( trim($m[1]) );
//   var_dump( str_replace('"', '', $str) );
//   echo '<hr>';

//   // \'93Harmony"}
//   // {\cs15\lang1033\langfe1033\b0\i0\ul0\strike0\scaps0\fs20\afs20\charscalex100\expndtw0\cf1\dn0 \'93Vision"}
//   // {\cs15\lang1033\langfe1033\b0\i0\ul0\strike0\scaps0\fs22\afs22\charscalex100\expndtw0\cf1\dn0 "Vibrancy} 
// exit;

  // $fileName = 'file.jpg';
$imgs = scandir("imgs");
unset($imgs[0]);
unset($imgs[1]);
  // var_dump($imgs);

//as21_abby_get_text_from_img('AussieGlo-Greeting-Cards-0418-101.jpg'); // не распознается


foreach ($imgs as $k => $img) {
  // if ($k >= 3 ) break;
  echo $k."- ".$img; echo "<br>";
  as21_abby_get_text_from_img($img);
  echo '<hr>';
  // as21_wjm_write_file_jobs_count('imgs-title.txt',$img);
}




function as21_wjm_write_file_jobs_count($filename,$text){

  chmod($filename, 0777);
  $fp = fopen($filename, "a"); // 'a' - write end file
  $write = fwrite($fp, $text); 
  // var_dump($write);
  fclose($fp); 
}
// exit;
// $local_directory = dirname(__FILE__).'/imgs/';
// $str = "test_name95";
// rename($local_directory."AussieGlo Greeting Cards 051895.jpg", $local_directory.$str."_400.jpg");
// exit;

// as21_abby_get_text_from_img('file.jpg');
// as21_abby_get_text_from_img('file2.jpg');
// as21_abby_get_text_from_img('file3.jpg');
// as21_abby_get_text_from_img('file4.jpg');

function as21_abby_get_text_from_img($fileName){

        $applicationId = 'aussieglo';
        // Password should be sent to your e-mail after application was created
        $password = 'UnVIFa+D2uZ1VfxegPFWe/b/';

        $serviceUrl = 'http://cloud.ocrsdk.com';

        // Get path to file that we are going to recognize
        // $local_directory=dirname(__FILE__).'/images/';
        $local_directory=dirname(__FILE__).'/imgs/';
        $filePath = $local_directory.'/'.$fileName;
        if(!file_exists($filePath))
        {
          die('File '.$filePath.' not found.');
        }
        if(!is_readable($filePath) )
        {
         die('Access to file '.$filePath.' denied.');
       }

        // Recognizing with English language to rtf
        // You can use combination of languages like ?language=english,russian or
        // ?language=english,french,dutch
        // For details, see API reference for processImage method
       $url = $serviceUrl.'/processImage?language=english&exportFormat=rtf';

        // Send HTTP POST request and ret xml response
       $curlHandle = curl_init();
       curl_setopt($curlHandle, CURLOPT_URL, $url);
       curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
       curl_setopt($curlHandle, CURLOPT_POST, 1);
       curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
       curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
       $post_array = array();
       if((version_compare(PHP_VERSION, '5.5') >= 0)) {
        $post_array["my_file"] = new CURLFile($filePath);
      } else {
        $post_array["my_file"] = "@".$filePath;
      }
      curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $post_array); 
      $response = curl_exec($curlHandle);
      if($response == FALSE) {
        $errorText = curl_error($curlHandle);
        curl_close($curlHandle);
        die($errorText);
      }
      $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
      curl_close($curlHandle);

        // Parse xml response
      $xml = simplexml_load_string($response);
      if($httpCode != 200) {
        if(property_exists($xml, "message")) {
         die($xml->message);
       }
       die("unexpected response ".$response);
      }

      $arr = $xml->task[0]->attributes();
      $taskStatus = $arr["status"];
      if($taskStatus != "Queued") {
        die("Unexpected task status ".$taskStatus);
      }

        // Task id
      $taskid = $arr["id"];  

        // 4. Get task information in a loop until task processing finishes
        // 5. If response contains "Completed" staus - extract url with result
        // 6. Download recognition result (text) and display it

      $url = $serviceUrl.'/getTaskStatus';
        // Note: a logical error in more complex surrounding code can cause
        // a situation where the code below tries to prepare for getTaskStatus request
        // while not having a valid task id. Such request would fail anyway.
        // It's highly recommended that you have an explicit task id validity check
        // right before preparing a getTaskStatus request.
      if(empty($taskid) || (strpos($taskid, "00000000-0") !== false)) {
        die("Invalid task id used when preparing getTaskStatus request");
      }
      $qry_str = "?taskid=$taskid";

        // Check task status in a loop until it is finished

        // Note: it's recommended that your application waits
        // at least 2 seconds before making the first getTaskStatus request
        // and also between such requests for the same task.
        // Making requests more often will not improve your application performance.
        // Note: if your application queues several files and waits for them
        // it's recommended that you use listFinishedTasks instead (which is described
        // at http://ocrsdk.com/documentation/apireference/listFinishedTasks/).
      while(true)
      {
        sleep(5);
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url.$qry_str);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
        curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
        curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
        $response = curl_exec($curlHandle);
        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);
        
          // parse xml
        $xml = simplexml_load_string($response);
        if($httpCode != 200) {
          if(property_exists($xml, "message")) {
            die($xml->message);
          }
          die("Unexpected response ".$response);
        }
        $arr = $xml->task[0]->attributes();
        $taskStatus = $arr["status"];
        if($taskStatus == "Queued" || $taskStatus == "InProgress") {
            // continue waiting
          continue;
        }
        if($taskStatus == "Completed") {
            // exit this loop and proceed to handling the result
          break;
        }
        if($taskStatus == "ProcessingFailed") {
          die("Task processing failed: ".$arr["error"]);
        }
        die("Unexpected task status ".$taskStatus);
      }

        // Result is ready. Download it

      $url = $arr["resultUrl"];   
      $curlHandle = curl_init();
      curl_setopt($curlHandle, CURLOPT_URL, $url);
      curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        // Warning! This is for easier out-of-the box usage of the sample only.
        // The URL to the result has https:// prefix, so SSL is required to
        // download from it. For whatever reason PHP runtime fails to perform
        // a request unless SSL certificate verification is off.
      curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
      $response = curl_exec($curlHandle);
      curl_close($curlHandle);

        // Let user donwload rtf result
        // header('Content-type: application/rtf');
        // header('Content-Disposition: attachment; filename="file.rtf"');

      
      // $response = '{\cs15\lang1033\langfe1033\b0\i0\ul0\strike0\scaps0\fs22\afs22\charscalex100\expndtw0\cf1\dn0 "Vibrancy}';
      preg_match('#\'93(.*?)}#is', $response, $m );
      preg_match('# "(.*?)}#is', $response, $m2 );
      $str = strtolower( trim($m[1]) );
      $str = str_replace('"', '', $str);
      $str2 = strtolower( trim($m2[1]) );
      $str2 = str_replace('"', '', $str2);
      print_r($m);
    var_dump( $str );
    print_r($m2);
    var_dump( $str2 );

    if( strlen($str) < 3 && strlen($str2) < 3 ) {
    echo "not found title! ".$fileName;
     as21_wjm_write_file_jobs_count('imgs-title.txt',$fileName."::not\r");
    }
    if(strlen($str) > 2){
      as21_wjm_write_file_jobs_count('imgs-title.txt',$fileName."::".$str.".jpg\r");
      rename($local_directory.$fileName, $local_directory.$str."_400.jpg");
    }
    if(strlen($str2) > 2) {
     as21_wjm_write_file_jobs_count('imgs-title.txt',$fileName."::".$str2.".jpg\r");
      rename($local_directory.$fileName, $local_directory.$str2."_400.jpg");
    }
    
     // echo $response;
}

// только распознование изображения через abby идет 6.5 сек - тогда скрипт уже не получится на нашей стороне ускорить
$end_time = microtime(true);
echo "<hr>time = ".($end_time - $st_time);


/*
на бесплатном тарифе доступно только 50 страниц в месяц,если поделиться через соцсети дают еще 100 страниц / 500 fields 
a subscription for 100 pages per month(1) free immediately if you share on Facebook, Twitter or Google Plus;
*/
?>