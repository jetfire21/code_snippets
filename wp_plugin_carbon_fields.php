<?php

if ( ! function_exists( 'carbon_get_post_meta' ) ) {
	function carbon_get_post_meta( $id, $name, $type = null ) {
		return false;
	}   
}

if ( ! function_exists( 'carbon_get_the_post_meta' ) ) {
	function carbon_get_the_post_meta( $name, $type = null ) {
		return false;
	}   
}

if ( ! function_exists( 'carbon_get_theme_option' ) ) {
	function carbon_get_theme_option( $name, $type = null ) {
		return false;
	}   
}

if ( ! function_exists( 'carbon_get_term_meta' ) ) {
	function carbon_get_term_meta( $id, $name, $type = null ) {
		return false;
	}   
}

if ( ! function_exists( 'carbon_get_user_meta' ) ) {
	function carbon_get_user_meta( $id, $name, $type = null ) {
		return false;
	}   
}

if ( ! function_exists( 'carbon_get_comment_meta' ) ) {
	function carbon_get_comment_meta( $id, $name, $type = null ) {
		return false;
	}   
}


use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Container::make('post_meta', 'Custom Data')
//     ->show_on_post_type('page')
//     ->add_fields(array(
//         Field::make('map', 'crb_location')->set_position(37.423156, -122.084917, 14),
//         Field::make('choose_sidebar', 'crb_custom_sidebar'),
//         Field::make('image', 'crb_photo'),
//     ));

Container::make('post_meta', 'Linked set')
->show_on_post_type('page')
->add_fields(array(
	Field::make( "select", "crb_content_align", "Text alignment" )
	->add_options( array(
		'left' => 'Left',
		'center' => 'Center',
		'right' => 'Right',
	) )    ));


/* *********** получить значение ************ */

echo carbon_get_post_meta( 57, 'crb_use_as_set');
