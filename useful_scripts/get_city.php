<?php
header('Content-Type: text/html; charset=utf-8');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// echo $remote_ip = $_SERVER['REMOTE_ADDR'];
// echo $remote_ip = '95.213.218.194';
// echo $remote_ip = '188.162.199.190';
echo $remote_ip = '85.140.4.73';
echo '<hr>';

function get_city_by_ip($ip)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://ipgeobase.ru:7020/geo?ip=' . 
		$ip);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$data = curl_exec($ch);
	$ip_answer = simplexml_load_string($data);

// на HOSTIMAN.RU ошибку Notice: Trying to get property of non-object in /home/gboservi/public_html/get_city.php on line 22
	$city = ($ip_answer->ip[0]->city);
	curl_close($ch);

	return $city;
}
// echo get_city_by_ip('176.213.92.32');
echo get_city_by_ip($remote_ip);
echo "<hr>";


/************* #2 *********************************/


/*
{
  "geoplugin_request":"176.213.92.32",
  "geoplugin_status":200,
  "geoplugin_delay":"1ms",
  "geoplugin_credit":"Some of the returned data includes GeoLite data created by MaxMind, available from <a href='http:\/\/www.maxmind.com'>http:\/\/www.maxmind.com<\/a>.",
  "geoplugin_city":"Cheboksary",
  "geoplugin_region":"Chuvashia",
  "geoplugin_regionCode":"CU",
  "geoplugin_regionName":"Chuvashia",
  "geoplugin_areaCode":"",
  "geoplugin_dmaCode":"",
  "geoplugin_countryCode":"RU",
  "geoplugin_countryName":"Russia",
  "geoplugin_inEU":0,
  "geoplugin_euVATrate":false,
  "geoplugin_continentCode":"EU",
  "geoplugin_continentName":"Europe",
  "geoplugin_latitude":"56.175",
  "geoplugin_longitude":"47.2864",
  "geoplugin_locationAccuracyRadius":"5",
  "geoplugin_timezone":"Europe\/Moscow",
  "geoplugin_currencyCode":"RUB",
  "geoplugin_currencySymbol":"руб",
  "geoplugin_currencySymbol_UTF8":"руб",
  "geoplugin_currencyConverter":62.2703
}
*/

function get_city_by_ip2($remote_ip = false){

	// http://www.geoplugin.net/json.gp?ip=176.213.92.32
	$client  = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = @$_SERVER['REMOTE_ADDR'];
	$result  = array('country'=>'', 'city'=>'');
	
	if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
	elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
	else $ip = $remote;
	// echo $ip;
	if($remote_ip) 	$ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$remote_ip));    
	else $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
	if($ip_data && $ip_data->geoplugin_city != null)
	{
		$result = $ip_data->geoplugin_city;
	}
	
	return $result;
}

// "Cheboksary",Kazan,Medvedevo (Respublika Mariy-El)
echo get_city_by_ip2($remote_ip);
echo "<hr>";


/************* #3 *********************************/


/*
                    [postal_code] => 428000
                    [country] => Россия
                    [region_fias_id] => 878fc621-3708-46c7-a97f-5a13a4176b3e
                    [region_kladr_id] => 2100000000000
                    [region_with_type] => Чувашская республика - Чувашия
                    [region_type] => Чувашия
                    [region_type_full] => Чувашия
                    [region] => Чувашская республика
                    [city_fias_id] => dd8caeab-c685-4f2a-bf5f-550aca1bbc48
                    [city_kladr_id] => 2100000100000
                    [city_with_type] => г Чебоксары
                    [city] => Чебоксары
                    [fias_id] => dd8caeab-c685-4f2a-bf5f-550aca1bbc48
                    [fias_code] => 21000001000000000000000
                    [fias_level] => 4
                    [fias_actuality_state] => 0
                    [kladr_id] => 2100000100000
                    [capital_marker] => 2
                    [okato] => 97401000000
                    [oktmo] => 97701000
                    [tax_office] => 2130
                    [tax_office_legal] => 2130
                    [timezone] => 
                    [geo_lat] => 56.1438298
                    [geo_lon] => 47.2489782
*/

class Dadata
{
    static function detect_by_ip($ip)
    {
        $result = false;
        if ($ch = curl_init("http://suggestions.dadata.ru/suggestions/api/4_1/rs/detectAddressByIp?ip=".$ip))
        {
			/*
			        	Пример запроса:

			curl -X GET \
			  -H "Accept: application/json" \
			  -H "Authorization: Token 40e6038dca0e1597fbcea822c456dafc7ed90f8e" \
			  https://suggestions.dadata.ru/suggestions/api/4_1/rs/detectAddressByIp?ip=46.226.227.20
			  */

             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                 'Content-Type: application/json',
                 'Accept: application/json',
                 // 'Authorization: Token ВАШ_API_КЛЮЧ'
                 'Authorization: Token 40e6038dca0e1597fbcea822c456dafc7ed90f8e'
              ));
             $result = curl_exec($ch);
             $result = json_decode($result, true);
             curl_close($ch);
        }
        return $result;
    }
}
// $result = Dadata::detect_by_ip("77.243.99.134");
$result = Dadata::detect_by_ip($remote_ip);
echo $result['location']['data']['city'];
// print_r($result);


/************* not work - need testing *********************************/

function get_city_by_ip3(){

	// Сначала получаем данные о сервере
		$dom = $_SERVER['HTTP_HOST'];
		$ipus = getenv('REMOTE_ADDR');
	// Если сервер - не localhost, то мы продолжим код
	/*
	Примечание: если хотите, можете эту проверку вырубить. Просто лично у меня она не прокатывала с денвера
	*/
	if ($dom != "localhost"){
		// Формируем адрес подключения
			$fl = "http://ip-whois.net/ip_geo.php?ip=".$ipus;
		// Получаем эти данные через file_get_contents()
		/*
		Примечание: при использовании fopen() - не прокатывало...
		*/
		$data = file_get_contents($fl);
		/*
		Получив данные, мы получили ОГРОМНУЮ страницу. Следовательно, нам нужно её обрезать так, чтобы осталась только надпись города (Город: [полученный город]). Если вы откроете страницу http://ip-whois.net/ip_geo.php?ip=какой-нибудь_IP, то Вы увидите, что страница обработала данные и получила город. Вскрыв исходный код страницы, вы увидите, что там присутствует 2 надписи "Город: [город]": первая - в JS-скрипте, вторая - ниже. Для обрезания мы используем функцию strstr(), и, чтобы обрезать ПРАВИЛЬНО, сначала обрежем до места </IFRAME>, чтобы перейти ЗА надпись в JS-скрипте...
		*/
		$data = strstr($data, "</IFRAME>");
		// А теперь непосредственно обрезаем от надписи "Город: "
		$data = strstr($data, "Город: ");
		/*
		Теперь посмотрите: третье обрезание присвоил другой переменной. Это нужно для того, чтобы после того, как обрезать второй раз, мы заменили ТАКУЮ ЖЕ оставшуюся часть в $data по образцу из $data2
		*/
		$data2 = strstr($data, "");
		// Производим удаление, о котором я говорил выше
		$data3 = str_replace($data2, "", $data);
		// Выводим полученный город на экран
		return $data3;
		// А это про localhost, о котором говорилось выше
	} else {
		return $data3 = "Неподходящий хост";
	}
}

// get_city_by_ip3();