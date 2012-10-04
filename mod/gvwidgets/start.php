<?php
/**
 * GV widgets plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvwidgets_init');

/**
 * Initialize the GV widgets plugin.
 */
function gvwidgets_init() {
    
    //register library
    elgg_register_library("elgg:gvwidgets", elgg_get_plugins_path() . "gvwidgets/lib/widgets.php");

	// allow admins to set default widgets for groups
	elgg_register_plugin_hook_handler('get_list', 'default_widgets', 'gvwidgets_default_widgets_hook');

    // remove old widget types that are not well defined
    $old_widget_names = array('blog', 'filerepo', 'pages','event_calendar',
                              'twitter_search', 'content_stats', 'poll', 'latestPolls',
                              'poll_individual', 'featured_groups', 'index_groups', 'discussion',
                              'group_forum_topics', 'thewire', 'profile_completeness', 'register', 
                              'questions', 'etherpad', 'content_by_tag', 'entity_statistics', 'favorites',
                              'image_slider', 'index_activity', 'index_login', 'index_members', 'index_members_online',
                              'messages', 'tagcloud');
    
    foreach($old_widget_names as $old_widget_name) {
        elgg_unregister_widget_type($old_widget_name);
    }
    
    //register new widget types
    $widget_names = array('latest_files', 
                          'latest_polls',
                          'latest_questions', 
                          'latest_blogs', 
                          'latest_pages', 
                          'latest_discussions', 
                          'latest_events',
                          'latest_wires',
                          'group_new_members',
                          'new_groups', 
                          'my_activities', 
                          'my_blogs',
                          'my_discussions',
                          'my_events',
                          'my_files',
                          'my_pages',
                          'my_polls',
                          'my_questions',
                          'my_wires'
                          );
    
    foreach ($widget_names as $widget_name) {
        elgg_register_widget_type($widget_name, elgg_echo("widget:$widget_name:title"), elgg_echo("widget:$widget_name:description"),"dashboard,profile,groups");
    }
    
    // modify widget title and description by re-register widget types
    elgg_register_widget_type('friends', elgg_echo('widget:friends:title'), elgg_echo('widget:friends:description'));
    elgg_register_widget_type("online_users", elgg_echo("admin:widget:online_users"), elgg_echo("admin:widget:online_users:help"), "dashboard");
    elgg_register_widget_type("new_users", elgg_echo("admin:widget:new_users"), elgg_echo("admin:widget:new_users:help"), "dashboard");
}

/**
 * Register profile widgets with default widgets
 *
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @return array
 */
function gvwidgets_default_widgets_hook($hook, $type, $return) {
	$return[] = array(
		'name' => elgg_echo('group'),
		'widget_context' => 'groups',
		'widget_columns' => 3,

		'event' => 'create',
		'entity_type' => 'group',
		'entity_subtype' => ELGG_ENTITIES_ANY_VALUE,
	);

	return $return;
}
