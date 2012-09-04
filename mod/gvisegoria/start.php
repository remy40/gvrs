<?php
/**
 * GV isegoria plugin
 *
 */
	require_once(dirname(__FILE__) . "/lib/isegoria.php");
 
 
elgg_register_event_handler('init', 'system', 'gvisegoria_init');

/**
 * Initialize the GV isegoria plugin.
 */
function gvisegoria_init() {

    // override dashboard page handler
	elgg_register_page_handler('dashboard', 'isegoria_page_handler');
    
    // remove dashboard item in the topbar
    elgg_unregister_menu_item('topbar', 'dashboard');

    // add isegoria item in the topbar menu
    elgg_register_menu_item('topbar', array(
    'name' => 'isegoria',
    'href' => 'dashboard',
    'text' => elgg_echo('gvgroups:isegoria'),
    'priority' => '10',
    ));

    // add an admin menu to update old users with default dashboard widgets
	elgg_register_admin_menu_item('administer', 'update_old_users', 'isegoria');

    // add default dashboard widgets for new users
    elgg_register_event_handler("create", "user", "isegoria_new_user");

    // register some new actions
	$action_base = elgg_get_plugins_path() . 'gvisegoria/actions/';
    elgg_register_action("admin/update_old_users", "$action_base/admin/update_old_users.php");
}

function isegoria_new_user($hook, $type, $user) {
    if(!empty($user) && ($user instanceof ElggUser)){
        isegoria_add_default_widget($user->guid);
    }
}

// isegoria page handler
function isegoria_page_handler() {
	// Ensure that only logged-in users can see this page
	gatekeeper();

	// Set context and title
	elgg_set_context('dashboard');
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	$title = elgg_echo('dashboard');

	// wrap intro message in a div
//	$intro_message = elgg_view('dashboard/blurb');

	$params = array(
//		'content' => $intro_message,
		'num_columns' => 3,
		'show_access' => false,
	);
	$widgets = elgg_view_layout('widgets', $params);

	$body = elgg_view_layout('one_column', array('content' => $widgets));

	echo elgg_view_page($title, $body);
	return true;
}

