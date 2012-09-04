<?php
/**
 * GV groups plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvgroups_init');

/**
 * Initialize the GV groups plugin.
 */
function gvgroups_init() {

    // override the groups library
    elgg_register_library('elgg:groups', elgg_get_plugins_path() . "gvgroups/lib/groups.php");

    // add admin menu
	elgg_register_admin_menu_item('administer', 'createlocal', 'groups');
	elgg_register_admin_menu_item('administer', 'deletelocal', 'groups');
//	elgg_register_admin_menu_item('administer', 'createfields', 'groups');
	elgg_register_admin_menu_item('administer', 'update_old_groups', 'groups');

    // unregister the sidebar menu
	elgg_unregister_event_handler('pagesetup', 'system', 'groups_setup_sidebar_menus');

    // add some page handler
    elgg_register_plugin_hook_handler("route", "groups", "gvgroups_route_groups_handler");
    
   	// override some actions
	$action_base = elgg_get_plugins_path() . 'gvgroups/actions/';
	elgg_register_action("groups/edit", "$action_base/groups/edit.php");
    
    // register some new actions
    elgg_register_action("admin/createlocal", "$action_base/admin/createlocal.php");
    elgg_register_action("admin/deletelocal", "$action_base/admin/deletelocal.php");
    elgg_register_action("admin/createfields", "$action_base/admin/createfields.php");
    elgg_register_action("admin/update_old_groups", "$action_base/admin/update_old_groups.php");
    
    // add some menu items in the topbar
    elgg_register_menu_item('topbar', array(
    'name' => 'workinggroups',
    'href' => 'groups/working',
    'text' => elgg_echo('gvgroups:workinggroups')
    ));

    elgg_register_menu_item('topbar', array(
    'name' => 'localgroups',
    'href' => 'groups/local',
    'text' => elgg_echo('gvgroups:localgroups')
    ));

    elgg_register_menu_item('topbar', array(
    'name' => 'mygroups',
    'href' => "groups/member/$user->username",
    'text' => elgg_echo('gvgroups:mygroups'),
    'section' => 'alt'
    ));
    
    // register event handlers
    elgg_register_event_handler('create', 'member', 'gvgroups_subscribe_to_group');
}

function gvgroups_subscribe_to_group($event, $type, $relationship) {
    
    if(!empty($relationship) && ($relationship instanceof ElggRelationship)){
        $user_guid = $relationship->guid_one;
        $group_guid = $relationship->guid_two;
        
        $group = get_entity($group_guid);
        
        // checks subscribing limits for local groups
        if ($group->grouptype == 'local') {
            $param_name = $group->localtype . "_limit";
            $limit = elgg_get_plugin_setting($param_name, 'gvgroups');
            
            // 0 means unlimited
            if ($limit > 0) {
                
                // get how many local groups of this type, the user is member of
                $options["type"] = 'group';
                $options["relationship"] = 'member';
                $options["relationship_guid"] = $user_guid;
                $group_options["inverse_relationship"] = false;
                $options["limit"] = 0;
                $options["count"] = TRUE;
                $options["joins"]	= array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid");
                $options["metadata_name_value_pairs"][] = array(
                        "name" => 'grouptype',
                        "value" => 'local');
                $options["metadata_name_value_pairs"][] = array(
                        "name" => 'localtype',
                        "value" => $group->localtype);
                
                $count = elgg_get_entities_from_relationship($options); 

                error_log("count: " . $count . " limit = " . $limit);
                if ($count > $limit) {
                    return false;
                }
            }
        }
    }
}

/**
 * Extends groups page handler
 *
 * URLs take the form of
 *  Local groups:         groups/local
 *  Working groups:       groups/working
 *  Add local group:      groups/local/add
 *  Edit local group:     groups/local/edit/<guid> 
 *  Add working group:    groups/working/add
 *  Edit working group:   groups/working/edit/<guid> 
 *
 */
function gvgroups_route_groups_handler($hook, $type, $return_value, $params) {
    
    elgg_load_library('elgg:groups');
    
    /**
     * $return_value contains:
     * $return_value['handler'] => requested handler
     * $return_value['segments'] => url parts ($page)
     */
    $result = $return_value;

    if(!empty($return_value) && is_array($return_value)){
        $page = $return_value['segments'];

        switch ($page[0]) {
            case 'add':
                groups_handle_edit_page('add', 'default');
                $result = false;
                break;

            case 'edit':
                groups_handle_edit_page('edit', 'default', $page[1]);
                $result = false;
                break;

            case 'local':
                if ($page[1] == 'add') {
                    groups_handle_add_local_page($page[2]);
                }
                elseif($page[1] == 'edit') {
                    groups_handle_edit_page('edit', $page[0], $page[2]);
                }
                else {
                    groups_handle_all_page($page[0]);
                }
                $result = false;
                break;

            case 'working':
                if ($page[1] == 'add') {
                    groups_handle_edit_page('add', $page[0]);
                } 
                elseif($page[1] == 'edit') {
                    groups_handle_edit_page('edit', $page[0], $page[2]);
                }
                else {
                    groups_handle_all_page($page[0]);
                }
                $result = false;
                break;
        }
    }
    
    return $result;
}
