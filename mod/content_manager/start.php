<?php
/**
 * GV Content Manager.
 *
 */

elgg_register_event_handler('init', 'system', 'gvcontentmanager_init');

/**
 * Initialize the plugin
 */
function gvcontentmanager_init() {
	// Extend CSS
	elgg_extend_view('css/admin', 'content_manager/css');
	elgg_extend_view('js/elgg', 'content_manager/js');

	elgg_register_admin_menu_item('administer', 'content_manager', 'administer_utilities');

	// Register actions
	$action_path = elgg_get_plugins_path() . "content_manager/actions/";
	elgg_register_action('content_manager', "$action_path/content_manager.php");
}

//
function content_manager_show_entities($entities, $vars = array(), $offset = 0, $limit = 10, $full_view = true,
$list_type_toggle = true, $pagination = true) {
}
