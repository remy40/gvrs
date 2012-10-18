<?php
/**
 * GV User Manager.
 *
 */

elgg_register_event_handler('init', 'system', 'gvusermanager_init');

/**
 * Initialize the plugin
 */
function gvusermanager_init() {

	elgg_extend_view('css/admin', 'user_manager/css');

	elgg_register_admin_menu_item('administer', 'users_list', 'users');

	// Register actions
//	$action_path = elgg_get_plugins_path() . "content_manager/actions/";
//	elgg_register_action('content_manager', "$action_path/content_manager.php");
}
