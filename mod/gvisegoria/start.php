<?php
/**
 * GV isegoria plugin
 *
 */
 
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
    
    // register widget types
    elgg_register_widget_type(
        "online_users",
        elgg_echo("admin:widget:online_users"),
        elgg_echo("admin:widget:online_users:help"));

    elgg_register_widget_type(
        "new_users",
        elgg_echo("admin:widget:new_users"),
        elgg_echo("admin:widget:new_users:help"));
}

/**
 * GV isegoria page handler.
 */
function isegoria_page_handler() {
	// Ensure that only logged-in users can see this page
	gatekeeper();

	// Set context and title
	elgg_set_context('dashboard');
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	$title = elgg_echo('dashboard');

	$params = array(
		'num_columns' => 3,
		'show_access' => false,
	);
	$widgets = elgg_view_layout('widgets', $params);

	$body = elgg_view_layout('one_column', array('content' => $widgets));

	echo elgg_view_page($title, $body);
	return true;
}
