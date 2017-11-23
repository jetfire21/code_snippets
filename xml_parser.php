<?php
	echo '<pre>';
	$xml = FALSE; // будет возвращать массив со всеми продуктами

	$init_load_url = TRUE;// при загрузке ПО ССЫЛКЕ выставить TRUE, при загрузке ДОКУМЕНТА выставить FALSE

	$doc = new domDocument();

	$xml = file_get_contents('http://b2b.berghoffworldwide.ru/catalog_xml_export'); // загрузка файла по ссылке

    if( $xml = $doc->loadXML($xml) ) // используется, при загрузке файла по ссылке
    {
        $yaml = $doc->getElementsByTagName('yml_catalog');

		$yaml = $yaml->item(0);

        $shop = $yaml->getElementsByTagName('shop');

		$shop = $shop->item(0);

        $categories = $shop->getElementsByTagName('categories');

		$categories = $categories->item(0);

        $icons = $shop->getElementsByTagName('specIcons');

		$icons = $icons->item(0);

        $offers = $shop->getElementsByTagName('offers');

		$offers = $offers->item(0);

        $result = array();

        /*Категории*/

        // Парсинг данных
        foreach ( $categories->getElementsByTagName('category') as $category )
        {
            $title = preg_replace('/\s{2,}/', ' ', trim((string) $category->nodeValue));

            $cid = (string) $category->getAttribute('id');

            $parse_cat[$cid] = array(
                'category_id' => $cid,
                'parent_id'   => (string) ($category->getAttribute('parentId') ? $category->getAttribute('parentId') : 0),
                'text'        => $title
            );

        }
        //print_r($parse_cat); die();
		$result['categories'] = $parse_cat;

		//Формирование массива данных

        /*/ Вывод категорий с подкатегориями

        foreach ($parse_cat as $item ) {

            if ($item['parent_id'] == 0)
            {
                foreach ($parse_cat as $childs)
                {
                    if($item['category_id'] == $childs['parent_id'])
                    {
                        $item['childs'][] = $childs;
                    }
                }

                $new_cats[] = $item;
            }

        }



        $result['categories'] = $new_cats;*/

        /*Иконки*/

        // Парсинг данных

        //Формирование массива данных
        foreach ($icons->getElementsByTagName('icon') as $icon)
        {
			$id = $icon->getAttribute('id');
            $childs = array('id' => $id);

            $names = array('symbol','name','sortOrder','png','svg');

            foreach ($icon->childNodes as $child)
            {
                if(in_array($child->nodeName, $names))
                {
                    $childs[ $child->nodeName ]  =  $child->nodeValue;
                }
            }

            $parse_icons[$id] = $childs;
        }

        $result['icons'] = $parse_icons;


        /*Продукты*/

        // Парсинг данных

        //Формирование массива данных
        foreach ( $offers->getElementsByTagName('offer') as $offer )
        {
			$pid = $offer->getAttribute('id');
            $childs = array(

                'id'        => $pid,
                'available' => $offer->getAttribute('available'),
                'param'     => array(),
                'picture'   => array()
            );

            $names = array(

                'name',
                'price',
                'oldprice',
                'currencyId',
                'vendor',
                'description',
                'manufacturer_warranty',
                'barcode',
                'categoryId',
                'pictureTHUMB'
            );

            $picture = array(); //Формирование массива данных

            foreach ($offer->childNodes as $child)
            {
                if( in_array($child->nodeName, $names) )
                {
                    $childs[ $child->nodeName ]  =  $child->nodeValue;
                }
                else if( $child->nodeName == 'categoriesList' )
                {
                    if( $child->hasChildNodes() )
                    {
                        $parent_categories = array();

                        foreach( $child->childNodes as $node)
                        {
                            if( ($node->nodeName == 'item')  &&  (!empty($node->nodeValue)) )
                            {
                                $parent_categories[] = array(

                                    'item' => $node->nodeValue
                                );
                            }
                        }

                        if( ! empty($parent_categories) )
                        {
                            $childs[ $child->nodeName ] = $parent_categories;
                        }
                    }
                }
                else if( $child->nodeName == 'param' )
                {
					$param_name = $child->getAttribute('name');

                    $childs['param'][$param_name] = array(

                        'name'  => $param_name,
                        'value' => $child->nodeValue,
                        'unit'  => $child->getAttribute('unit')

                    );
                }
                else if( $child->nodeName == 'picture' )
                {
                    $childs['picture'][] = $child->nodeValue;
                }
                else if( $child->nodeName == 'pictureTHUMB' )
                {
                    $childs['picture_thumb'] = $child->nodeValue;
                }
            }

            $parse_offers[$pid] = $childs;
        }

		$result['offers'] = $parse_offers;

        //return $result; //Вывод массива с данными парсера

		echo '<pre>';
		//var_dump($result);
		print_r($result);
		echo '</pre>';

        // $ids = array(3700085,3700086,3700088,3700089,3700090,3700093);
        // // print_r($result['offers']);
        // foreach ($result['offers'] as $k => $v) {
        //     foreach ($ids as $k2=>$v2) {
        //         if( $k == $v2) $res[$k] = $v;
        //     }
        // }
        // print_r($res);

        echo '<hr>кол-во товаров: '.count($result['offers']);
        }
        else
        {
            echo 'not load';
        }


