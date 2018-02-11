<?php
/*** проверка активирован ли плагин ******* */
/* Check if should include install file	 */
	public function check_install() {
		$current_version = get_option( 'wp_job_manager_field_editor_version' );
		$plugin_activated = get_option( 'wp_job_manager_field_editor_activated' );
		$force_install = isset( $_GET['jmfe_force_install'] ) ? TRUE : FALSE;
		if ( $force_install || $plugin_activated || ! $current_version || version_compare( WPJM_FIELD_EDITOR_VERSION, $current_version, '>' ) ) {
			// Remove option if was set on plugin activation
			if( $plugin_activated ) delete_option( 'wp_job_manager_field_editor_activated' );
			// Include install class
			include_once( WPJM_FIELD_EDITOR_PLUGIN_DIR . '/classes/install.php' );
		}
	}
// если-true тогда подключаем кастомный код расширяющий функционал плагина,использовать главный класс для этого
if(class_exists("WP_Job_Manager_Field_Editor")) require_once 'job_manager/wp-job-manager-groups/index.php';
/*** проверка активирован ли плагин ******* */



/*** правильное создание обьекта (экземпляра класса) ******* */

class SportsPress {

	public $version = '2.5.10';
	/**
	 * @var SportsPress The single instance of the class
	 * @since 0.7
	 */
	protected static $_instance = null;
	/**
	 * Main SportsPress Instance
	 * Ensures only one instance of SportsPress is loaded or can be loaded.
	 * @since 0.7
	 * @static
	 * @see SP()
	 * @return SportsPress - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) 	self::$_instance = new self();
		return self::$_instance;
		// смысл не понятен,сколько обьектов не создавай все равно все буду работать
	}
	public function test_func_show_text(){
		return "I'm just text for testing";
	}
}
if ( ! function_exists( 'SP' ) ):
	/**
	 * Returns the main instance of SP to prevent the need to use globals.
	 * @since  0.7
	 * @return SportsPress
	 */
	function SP() {
		return SportsPress::instance();
	}
endif;
$obj = SP();
echo $obj->test_func_show_text();
var_dump($obj);

start oop wp plugin
https://code.tutsplus.com/tutorials/object-oriented-programming-in-wordpress-document-the-plugin-i--cms-21168
https://premium.wpmudev.org/blog/object-oriented-plugins/
https://premium.wpmudev.org/blog/object-oriented-code-beginners/
https://premium.wpmudev.org/blog/advanced-wordpress-development-writing-object-oriented-plugins/
https://iandunn.name/content/presentations/wp-oop-mvc/oop.php