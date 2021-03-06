<?php

/* **** цепляемся за ajax добавление товара в корзину (ползено когда нужно обновить количество товара при клике на добавить товар в кастомной миникорзине) */
add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );
function iconic_cart_count_fragments( $fragments ) {
    
    $fragments['li.as21_menu_cart span'] = '<span>' . WC()->cart->get_cart_contents_count() . '</span>';
    // var_dump($fragments);
    // exit;
    return $fragments;    
}
/* **** as21 **** */



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

/* **** программное добавление продуктов,товаров в базу данных woocommerce **** */


/* *********** передача параметров в шаблон woocommerce ************ */

function get_template_part_with_data($slug, array $data = array()){
    $slug .= '.php';
    $slug =  WC()->template_path().$slug;
    extract($data);

     require locate_template($slug);
}
<h1>woocommerce.php</h1>

/* *********** передача параметров в шаблон woocommerce ************ */


/* *********** Get WooCommerce product categories from WordPress ************ */


  $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 1;      // 1 for yes, 0 for no  
  $title        = '';  
  $empty        = 0;

  $args = array(
         'taxonomy'     => $taxonomy,
         'orderby'      => $orderby,
         'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
         'title_li'     => $title,
         'hide_empty'   => $empty
  );
 $all_categories = get_categories( $args );
 foreach ($all_categories as $cat) {
    if($cat->category_parent == 0) {
        $category_id = $cat->term_id;       
        echo '<br /><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';

        $args2 = array(
                'taxonomy'     => $taxonomy,
                'child_of'     => 0,
                'parent'       => $category_id,
                'orderby'      => $orderby,
                'show_count'   => $show_count,
                'pad_counts'   => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li'     => $title,
                'hide_empty'   => $empty
        );
        $sub_cats = get_categories( $args2 );
        if($sub_cats) {
            foreach($sub_cats as $sub_category) {
                echo  $sub_category->name ;
            }   
        }
    }       
}

/* *********** Get WooCommerce product categories from WordPress ************ */


/* *********** How to get the products by categories in woocommerce? ************ */

So given a category with ID 26, the following code would return it's products (WooCommerce 3+):

    $args = array(
    'post_type'             => 'product',
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => 1,
    'posts_per_page'        => '12',
    'tax_query'             => array(
        array(
            'taxonomy'      => 'product_cat',
            'field' => 'term_id', //This is optional, as it defaults to 'term_id'
            'terms'         => 26,
            'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
        ),
        array(
            'taxonomy'      => 'product_visibility',
            'field'         => 'slug',
            'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
            'operator'      => 'NOT IN'
        )
    )
);
$products = new WP_Query($args);
var_dump($products);

In earlier versions of WooCommerce the visibility was stored as a meta field, so the code would be:

    $args = array(
    'post_type'             => 'product',
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => 1,
    'posts_per_page'        => '12',
    'meta_query'            => array(
        array(
            'key'           => '_visibility',
            'value'         => array('catalog', 'visible'),
            'compare'       => 'IN'
        )
    ),
    'tax_query'             => array(
        array(
            'taxonomy'      => 'product_cat',
            'field' => 'term_id', //This is optional, as it defaults to 'term_id'
            'terms'         => 26,
            'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
        )
    )
);
$products = new WP_Query($args);
var_dump($products);
Here we are only returning visible products, 12 per page.

/* *********** How to get the products by categories in woocommerce? ************ */


$args = array(
    'number' => $number,
    'orderby' => $orderby,
    'order' => $order,
    'hide_empty' => $hide_empty,
    'include' => $ids
);

$product_categories = get_terms('product_cat', $args);
?>
<ul>
    <?php
        foreach ($product_categories as $cat) {
            ?>
                <li>
                    <a href="<?php echo get_term_link($cat->slug, 'product_cat'); ?>"><?php echo $cat->name;?></a>
                    <ul>
                        <?php
                        $productArgs = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => $cat->name, 'orderby' => 'rand' );
                        $products = new WP_Query( $productArgs );
                        while ( $products->have_posts() ) : $products->the_post(); global $product; ?>

                            <li><a href="<?php echo get_permalink( $products->post->ID ) ?>"><?php echo $products->post->title;?></a></li>

                        <?php endwhile; ?>
                    </ul>
                </li>

    <?php 
        }

    wp_reset_query(); ?>
</ul>


----
		$taxonomyName = "product_cat";
		$prod_categories = get_terms($taxonomyName, array(
		    'orderby'=> 'name',
		    'order' => 'ASC',
		    'hide_empty' => 0
		));  
		// print_r($prod_categories);
		$i = 0;
		foreach( $prod_categories as $prod_cat ) :
		    if ( $prod_cat->parent != 0 )
		        continue;;
		     $cat[ $prod_cat->slug ]['term_link'] = get_term_link( $prod_cat, 'product_cat' );
		   
		 endforeach; 
		wp_reset_query();

/* *********** WooCommerce: function that returns all product ID's in a particular category ************ */


function get_products_from_category_by_ID( $category_id ) {

    $products_IDs = new WP_Query( array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'fields' => 'ids', 
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
                'operator' => 'IN',
            )
        )
    ) );

    return $products_IDs;
}

/* *********** WooCommerce: function that returns all product ID's in a particular category ************ */

/* *********** get product in loop ************ */

global $product;
$id = $product->get_id();


/******** меняет кол-во выводимых продуктов на странице shop  ************/
add_filter('loop_shop_columns', 'loop_columns',999);
// if (!function_exists('loop_columns')) {
function loop_columns() {
    return 3; // 3 products per row
// }
}
/******** меняет кол-во выводимых продуктов на странице shop  ************/

/***** меняет кол-во продуктов-категорий на странице front_page если продукты добавлены шорткодом [product_categories] **********/
// закинут в файл site.ru\themes\storefront\woocommerce\loop\loop-start.php
$GLOBALS['woocommerce_loop']['columns'] = 5;
/***** меняет кол-во продуктов-категорий на странице front_page если продукты добавлены шорткодом [product_categories] **********/


/******** сслыка на предыдущий и следующий продукт на странице single-product  ************/

echo next_post_link('%link', '&larr; PREVIOUS', TRUE, ' ', 'product_cat');
 echo previous_post_link('%link', 'NEXT &rarr;', TRUE, ' ', 'product_cat');
 echo previous_post_link('%link', 'Previous card', TRUE, ' ', 'product_cat');
 echo next_post_link('%link', 'Next card', TRUE, ' ', 'product_cat');

 /******** сслыка на предыдущий и следующий продукт на странице single-product  ************/

 /******** изменить количество связанных продуктов  ************/
 // иногда 2 раза подряд выводит на 1 товар меньше (вместо 4-3) надо разобраться почему

add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
 function jk_related_products_args( $args ) {
 
$args['posts_per_page'] = 4; // количество "Похожих товаров"
 $args['columns'] = 4; // количество колонок
 return $args;
}
 /******** изменить количество связанных продуктов  ************/

 /******** получить список всех категорий у продукта (или у поста)  ************/

$product_id = get_the_ID();
$terms = get_the_terms ( $product_id, 'product_cat' );
echo $terms[0]->term_id;
as21_debug(0,1,'',$terms)
;
var_dump(wc_get_product_cat_ids($product_id));

 /******** получить список всех категорий у продукта (или у поста)  ************/


 /******** сортировка продуктов на стринцие категории продукта  ************/

// sort products in page product category
    add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );
    function custom_woocommerce_get_catalog_ordering_args( $args ) {

        $args['orderby'] = 'date ID';
        $args['order'] = 'DESC';
        return $args;
    }
 /******** сортировка продуктов на стринцие категории продукта  ************/

 /******** ограничение доставки только в одну страну,весь список  стран не скрывает,всего лишь по умолчанию выбирает AU
 /wp-admin/admin.php?page=wc-settings Указать страну в selling locations:  ************/

function woo_override_checkout_fields( $fields ) { 

    $fields['shipping']['shipping_country'] = array(
        'type'      => 'select',
        'label'     => __('My New Country List', 'woocommerce'),
        'options'   => array('AU' => 'Australia')
    );

    return $fields; 
} 
add_filter( 'woocommerce_checkout_fields' , 'woo_override_checkout_fields' );

add_filter( 'woocommerce_checkout_fields' , 'as21_custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function as21_custom_override_checkout_fields( $fields ) {
     $fields['order']['order_comments']['placeholder'] = 'Notes about your order (e.g., special delivery notes)';
     return $fields;
}

/******** ограничение доставки только в одну страну ***********/

/******** wc вставка html select выбор страны на любой странице  ***********/

<div class="woocommerce-billing-fields__field-wrapper">
<p class="">Country: &nbsp;<strong>Australia</strong></p>
<?php
$key = 'billing_state';
$args = array('type' => 'state','autocomplete'=>true,'label'=>'Select a state&hellip;');
woocommerce_form_field( $key, $args, $value = null );
?>
<?php
                // global $checkout;
                //  // $fields = $checkout->get_checkout_fields( 'billing' );
                //  $fields = WC()->checkout->get_checkout_fields( 'billing' );

                //  foreach ( $fields as $key => $field ) {
                //      if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
                //          $field['country'] = $checkout->get_value( $field['country_field'] );
                //      }
                //      woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                //  }
?>
</div>


<?php
            /* method 2 
            global $woocommerce;
            $countries_obj   = new WC_Countries();
            $countries   = $countries_obj->__get('countries');
            $default_country = $countries_obj->get_base_country();
            $default_county_states = $countries_obj->get_states( $default_country );

            echo '<div id="my_custom_state_field"><h2>' . __('States') . '</h2>';

            woocommerce_form_field('my_state_field', array(
                'type'       => 'select',
                'class'      => array( 'chzn-drop' ),
                'label'      => __('Select a state'),
                'placeholder'    => __('Enter something'),
                'options'    => $default_county_states
            )
        );
            echo '</div>';
            method 2 */

            

/******** wc вставка html select выбор страны на любой странице  ***********/


/*********** set default state,country in checkout & cart page (установка по умолчанию штат,страна) ************/ 

add_action('woocommerce_add_to_cart' , 'as21_set_default_state_cart_page'); 

function as21_set_default_state_cart_page(){
    //WC()->customer->set_country('US'); //set country code of default country
    //WC()->customer->set_shipping_country('US');
    // WC()->customer->set_country(''); //reset default country
    WC()->customer->set_shipping_state( 'NSW' );
}

// work on checkout page
add_filter( 'default_checkout_billing_state', 'as21_set_default_state_checkout_page' );
  
function as21_set_default_state_checkout_page() {
  return 'NSW'; // state code
}

/*********** set default state in checkout & cart page ************/ 


