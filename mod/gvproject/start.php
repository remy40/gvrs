<?php
/**
 * GV Project
 */

elgg_register_event_handler('init', 'system', 'gvproject_init');

/**
 * Initialize the gv project plugin.
 *
 */
function gvproject_init() {

	$item = new ElggMenuItem('projects', elgg_echo('gvprojects:menu:projects'), 'projects/all');
	elgg_register_menu_item('site', $item);

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('projects', 'gvproject_page_handler');

	// Register a url handler
	elgg_register_entity_url_handler('object', 'project', 'gvproject_url');

	// Register some actions
	$action_base = elgg_get_plugins_path() . 'gvproject/actions/';
	elgg_register_action("projects/edit", "$action_base/edit.php");
	elgg_register_action("projects/delete", "$action_base/delete.php");

	// Register entity type for search
	elgg_register_entity_type('object', 'project');

    elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'gvproject_owner_block_menu');

    elgg_register_widget_type('latest_projects', elgg_echo("widget:latest_projects:title"), elgg_echo("widget:latest_projects:description"),"dashboard,profile,groups");
}

/**
 * Dispatcher for projects.
 * URLs take the form of
 *  All projects:        projects/all
 *  View project:        projects/view/<guid>/<title>
 *  New project:         projects/add/<guid> (container: group)
 *  Edit project:        projects/edit/<guid>
 *  Group projects:      projects/group/<guid>/all
 *
 * @param array $page
 * @return bool
 */
function gvproject_page_handler($page) {

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$base_dir = elgg_get_plugins_path() . 'gvproject/pages/';

	$page_type = $page[0];
	switch ($page_type) {
		case 'view':
			set_input('guid', $page[1]);
			include "$base_dir/view.php";
			break;
		case 'add':
			set_input('guid', $page[1]);
			include "$base_dir/new.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$base_dir/edit.php";
			break;
		case 'group':
			set_input('guid', $page[1]);
			include "$base_dir/owner.php";
			break;
		case 'all':
			include "$base_dir/world.php";
			break;
		default:
			return false;
	}
	return true;
}

/**
 * Override the project url
 * 
 * @param ElggObject $entity Project object
 * @return string
 */
function gvproject_url($entity) {
	$title = elgg_get_friendly_title($entity->title);
	return "projects/view/$entity->guid/$title";
}
/**
 * Add a menu item to the user ownerblock
 */
function gvproject_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'group')) {
        $url = "projects/group/{$params['entity']->guid}/all";
        $item = new ElggMenuItem('projects', elgg_echo('gvprojects:menu:group'), $url);
        $return[] = $item;
	}

	return $return;
}
