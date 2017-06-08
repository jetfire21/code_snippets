<?php
	// Преобразует дату '28 Jan 2017' в '2017-01-28', a mysql работает с форматом 0000-00-00 00:00:00
	echo date("Y-m-d",strtotime("28 Jan 2017"));
	// текущая дата и время
	echo " ".date('Y-m-d H:i:s');
	//
	echo date("Y-m-d",strtotime("June 12, 2017"));
	echo date("F d, Y",strtotime("June 12, 2017"));
