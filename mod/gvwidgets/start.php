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
    
    //register widget types
    $widget_names = array('latest_files', 'latest_questions', 'latest_blogs', 'active_groups', 'new_groups', 'my_activity', 
                          'my_discussion',  'group_new_members');
    
    foreach ($widget_names as $widget_name) {
        elgg_register_widget_type($widget_name, elgg_echo("widget:$widget_name:title"), elgg_echo("widget:$widget_name:description"));
    }
    
    // modify widget by re-register widget types
	elgg_register_widget_type('blog', elgg_echo('widget:blog:title'), elgg_echo('widget:blog:description'));
	elgg_register_widget_type('filerepo', elgg_echo("widget:file:title"), elgg_echo("widget:file:description"));
    elgg_register_widget_type('friends', elgg_echo('widget:friends:title'), elgg_echo('widget:friends:description'));
    elgg_register_widget_type('pages', elgg_echo('widget:pages:title'), elgg_echo('widget:pages:description'));
    elgg_register_widget_type(
        "online_users",
        elgg_echo("admin:widget:online_users"),
        elgg_echo("admin:widget:online_users:help"), "dashboard");

    elgg_register_widget_type(
        "new_users",
        elgg_echo("admin:widget:new_users"),
        elgg_echo("admin:widget:new_users:help"), "dashboard");
}
