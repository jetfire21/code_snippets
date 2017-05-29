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
