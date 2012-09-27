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

    // unregister some widget types
	elgg_unregister_widget_type('poll');	
	elgg_unregister_widget_type('group_invitations');	
	elgg_unregister_widget_type('featured_groups');	
	elgg_unregister_widget_type('index_groups');	

    // register widget types
    elgg_register_widget_type('pages', elgg_echo('pages'), elgg_echo('pages:widget:description'), "groups");
	elgg_register_widget_type('etherpad', elgg_echo('etherpad'), elgg_echo('etherpad:profile:widgetdesc'), "groups");
	elgg_register_widget_type('poll_individual',elgg_echo('polls:individual'),elgg_echo('poll_individual_group:widget:description'), "profile");	
	elgg_register_widget_type('questions', elgg_echo("widget:questions:title"), elgg_echo("widget:questions:description"), "groups");
	elgg_register_widget_type('blog', elgg_echo('widget:blog:title'), elgg_echo('blog:widget:description'), "dashboard,groups");
	elgg_register_widget_type('filerepo', elgg_echo("widget:file:title"), elgg_echo("file:widget:description"), "dashboard,groups");
    elgg_register_widget_type('friends', elgg_echo('widget:friends:title'), elgg_echo('friends:widget:description'));
    elgg_register_widget_type(
        "online_users",
        elgg_echo("admin:widget:online_users"),
        elgg_echo("admin:widget:online_users:help"), "dashboard");

    elgg_register_widget_type(
        "new_users",
        elgg_echo("admin:widget:new_users"),
        elgg_echo("admin:widget:new_users:help"), "dashboard");
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
