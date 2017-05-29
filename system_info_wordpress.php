<?php
/**
 * Show up some server infor's on wordpress
 * @author GamerZ (http://www.lesterchan.net)
 */
function ngg_get_serverinfo() {

	// global $wpdb, $ngg;
	global $wpdb;
	// Get MYSQL Version
	$sqlversion = $wpdb->get_var("SELECT VERSION() AS version");
	// GET SQL Mode
	$mysqlinfo = $wpdb->get_results("SHOW VARIABLES LIKE 'sql_mode'");
	if (is_array($mysqlinfo)) $sql_mode = $mysqlinfo[0]->Value;
	if (empty($sql_mode)) $sql_mode = 'Not set';
	// Get PHP Safe Mode
	if(ini_get('safe_mode')) $safe_mode = 'On';
	else $safe_mode = 'Off';
	// Get PHP allow_url_fopen
	if(ini_get('allow_url_fopen')) $allow_url_fopen = 'On';
	else $allow_url_fopen = 'Off'; 
	// Get PHP Max Upload Size
	if(ini_get('upload_max_filesize')) $upload_max = ini_get('upload_max_filesize');	
	else $upload_max = 'N/A';
	// Get PHP Output buffer Size
	if(ini_get('pcre.backtrack_limit')) $backtrack_limit = ini_get('pcre.backtrack_limit');	
	else $backtrack_limit = 'N/A';
	// Get PHP Max Post Size
	if(ini_get('post_max_size')) $post_max = ini_get('post_max_size');
	else $post_max = 'N/A';
	// Get PHP Max execution time
	if(ini_get('max_execution_time')) $max_execute = ini_get('max_execution_time');
	else $max_execute = 'N/A';
	// Get PHP Memory Limit 
	if(ini_get('memory_limit')) $memory_limit = ini_get('memory_limit');
	else $memory_limit = 'N/A';
	// Get actual memory_get_usage
	if (function_exists('memory_get_usage')) $memory_usage = round(memory_get_usage() / 1024 / 1024, 2) . ' MByte';
	else $memory_usage = 'N/A';
	// required for EXIF read
	if (is_callable('exif_read_data')) $exif = 'Yes'. " ( V" . substr(phpversion('exif'),0,4) . ")" ;
	else $exif = 'No';
	// required for meta data
	if (is_callable('iptcparse')) $iptc = 'Yes';
	else $iptc = 'No';
	// required for meta data
	if (is_callable('xml_parser_create')) $xml = 'Yes';
	else $xml = 'No';
	
?>
<ul>
	<li><?php echo 'Operating System'; ?> : <span><?php echo PHP_OS; ?>&nbsp;(<?php echo (PHP_INT_SIZE * 8) ?>&nbsp;Bit)</span></li>
	<li><?php echo 'Server'; ?> : <span><?php echo $_SERVER["SERVER_SOFTWARE"]; ?></span></li>
	<li><?php echo 'Memory usage'; ?> : <span><?php echo $memory_usage; ?></span></li>
	<li><?php echo 'MYSQL Version'; ?> : <span><?php echo $sqlversion; ?></span></li>
	<li><?php echo 'SQL Mode'; ?> : <span><?php echo $sql_mode; ?></span></li>
	<li><?php echo 'PHP Version'; ?> : <span><?php echo PHP_VERSION; ?></span></li>
	<li><?php echo 'PHP Safe Mode'; ?> : <span><?php echo $safe_mode; ?></span></li>
	<li><?php echo 'PHP Allow URL fopen'; ?> : <span><?php echo $allow_url_fopen; ?></span></li>
	<li><?php echo 'PHP Memory Limit'; ?> : <span><?php echo $memory_limit; ?></span></li>
	<li><?php echo 'PHP Max Upload Size'; ?> : <span><?php echo $upload_max; ?></span></li>
	<li><?php echo 'PHP Max Post Size'; ?> : <span><?php echo $post_max; ?></span></li>
	<li><?php echo 'PCRE Backtracking Limit'; ?> : <span><?php echo $backtrack_limit; ?></span></li>
	<li><?php echo 'PHP Max Script Execute Time'; ?> : <span><?php echo $max_execute; ?>s</span></li>
	<li><?php echo 'PHP Exif support'; ?> : <span><?php echo $exif; ?></span></li>
	<li><?php echo 'PHP IPTC support'; ?> : <span><?php echo $iptc; ?></span></li>
	<li><?php echo 'PHP XML support'; ?> : <span><?php echo $xml; ?></span></li>
</ul>
<?php }

ngg_get_serverinfo();

?>
