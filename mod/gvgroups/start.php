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
	elgg_register_library('elgg:discussion', elgg_get_plugins_path() . 'gvgroups/lib/discussion.php');

    // add admin menu
	elgg_register_admin_menu_item('administer', 'createlocal', 'groups');
	elgg_register_admin_menu_item('administer', 'deletelocal', 'groups');

    // unregister the sidebar menu (my groups, group that I own, ...)
	elgg_unregister_event_handler('pagesetup', 'system', 'groups_setup_sidebar_menus');

    // add some page handler
    elgg_register_plugin_hook_handler("route", "groups", "gvgroups_route_groups_handler");
    elgg_register_plugin_hook_handler("route", "discussion", "gvgroups_route_discussion_handler");
    
   	// override some actions
	$action_base = elgg_get_plugins_path() . 'gvgroups/actions';
	elgg_register_action("gvgroups/edit", "$action_base/gvgroups/edit.php");
   
    // register some new actions
    elgg_register_action("admin/createlocal", "$action_base/admin/createlocal.php");
    elgg_register_action("admin/deletelocal", "$action_base/admin/deletelocal.php");
    
    // add a hook to transform group menu item in a dropdown menu
    elgg_register_plugin_hook_handler('register', 'menu:site', 'gvgroups_custom_sitemenu_setup');

    // add an event handler to add the user in local groups, according to his profile
    elgg_register_event_handler('profileupdate', 'user', 'gvgroups_profileupdate');
    
    // manage some specific subscribing (town groups)
    elgg_register_event_handler('create', 'member', 'gvgroups_join_group');

    // add "my groups" menu to the topbar
    elgg_register_menu_item('topbar', array(
    'name' => 'mygroups',
    'href' => "groups/member/$user->username",
    'text' => elgg_echo('gvgroups:mygroups'),
    'section' => 'alt'
    ));

    // extend CSS view
    elgg_extend_view('css/elgg', 'gvgroups/css');

    // check if the user is member of the group before showing owner menu
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'gvgroups_owner_block_menu');

	elgg_register_plugin_hook_handler('register', 'menu:entity', 'gvgroups_entity_menu_setup');
}

/**
 * 
 */
function gvgroups_entity_menu_setup($hook, $type, $return, $params) {

	$handler = elgg_extract('handler', $params, false);

	if ($handler != 'groups') {
		foreach ($return as $index => $item) {
			if (in_array($item->getName(), array('comment'))) {
				unset($return[$index]);
			}
		}
		return $return;
	}

	foreach ($return as $index => $item) {
		if (in_array($item->getName(), array('dislikes', 'feature'))) {
			unset($return[$index]);
		}
	}
	
	return $return;
}

/**
 * manage ownerblock
 * 
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function gvgroups_owner_block_menu($hook, $type, $return, $params) {

    $return_value = $return;
    
	if (elgg_instanceof($params['entity'], 'group')) {
		if (!$params['entity']->isMember(elgg_get_logged_in_user_guid())) {
            $return_value = array();
            foreach ($return as $item) {
                if (($item->getName() == 'questions') ||
                    ($item->getName() == 'blog')){
                    $return_value[] = $item;
                }
            }
		}
	}

	return $return_value;
}

function add_user_to_local_group($user, $groupname, $localtype) {
    $options["type"] = 'group';
    $options["limit"] = NULL;
    $options["metadata_name_value_pairs"][] = array(
            "name" => 'grouptype',
            "value" => 'local');
    $options["metadata_name_value_pairs"][] = array(
            "name" => 'localtype',
            "value" => $localtype);
    $options["joins"] = array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid");
    $options["wheres"] = array ("ge.name = '". sanitise_string($groupname) . "'");

    $groups = elgg_get_entities_from_metadata($options);

    if ($groups && (count($groups) == 1)) {
        if ($groups[0]->join($user)) {
            system_message(elgg_echo("gvgroups:localgroups:subscribe", array($groups[0]->name)));
        }
        else {
            register_error(elgg_echo("gvgroups:localgroups:error_subscribe", array($groups[0]->name)));
        }
    }
}

function gvgroups_leave_group($group, $user) {
    if ($group->leave($user)) {
        system_message(elgg_echo("gvgroups:localgroups:unsubscribe", array($group->name)));
    }
    else {
        register_error(elgg_echo("gvgroups:localgroups:error_unsubscribe", array($group->name)));
    }
}

/**
 * some specific group subscribing (town groups)
 */
function gvgroups_join_group($hook, $type, $relationship) {
    $result = true;
    
    if ($relationship instanceof ElggRelationship) {
        $user  = get_entity($relationship->guid_one);
        $group = get_entity($relationship->guid_two);
        
        if (($user instanceof ElggUser) && ($group instanceof ElggGroup) &&
            $user && $group) {

            // to be a member of a town group, the user must be a member of the parent group (which is a departemental group) 
            if (($group->grouptype == 'local') && ($group->localtype == 'town')) {
                $parentgroup = $group->getEntitiesFromRelationship('parent');
                
                if ($parentgroup) {
                    if (!$parentgroup[0]->isMember($user)) {
                        register_error(elgg_echo("gvgroups:towngroups:error_subscribe"), array($group->name, $parentgroup[0]->name));
                        $result = false;
                    }
                }
            }
        }
    }
    
    return $result;
}

/**
 * Add the user in local groups, according to his profile
 */
function gvgroups_profileupdate($hook, $type, $user) {
    elgg_load_library('elgg:groups');

    $addtonationalgroup = true;
    $addtoregionalgroup = true;
    $addtodepartementalgroup = true;
    
    // get current user's local groups
    $nationalgroup = get_local_group_for_user($user->guid, 'national');
    $regionalgroup = get_local_group_for_user($user->guid, 'regional');
    $departementalgroup = get_local_group_for_user($user->guid, 'departemental');
    $towngroups = get_local_group_for_user($user->guid, 'town');

    // extract objects from array (easier to manipulate)
    if (count($nationalgroup) == 1) {
        $nationalgroup = $nationalgroup[0];
    }
    else {
        // never happen
        $nationalgroup = false;
    }

    if (count($regionalgroup) == 1) {
        $regionalgroup = $regionalgroup[0];
    }
    else {
        // never happen
        $regionalgroup = false;
    }

    if (count($departementalgroup) == 1) {
        $departementalgroup = $departementalgroup[0];
    }
    else {
        // never happen
        $departementalgroup = false;
    }

    // get the names of new local groups  
    $nationalgroup_name = $user->country;
    $regionalgroup_name = get_regional_group_name_from_postalcode($user->country, $user->postalcode);
    $departementalgroup_name = get_departemental_group_name_from_postalcode($user->country, $user->postalcode);
    
    if ($nationalgroup) {
        // if the country has changed, leave all local groups
        if ($nationalgroup->name != $nationalgroup_name) {
            gvgroups_leave_group($nationalgroup, $user);
        
            if ($regionalgroup) {
                gvgroups_leave_group($regionalgroup, $user);
                $regionalgroup = false;
            }
            
            if ($departementalgroup) {
                gvgroups_leave_group($departementalgroup, $user);
                $departementalgroup = false;
                
                // leave every town groups
                if ($towngroups) {
                    foreach($towngroups as $towngroup) {
                        gvgroups_leave_group($towngroup, $user);
                    }
                }
            }
        }
        else {
            $addtonationalgroup = false;
        }
    }

    // then, check departement group
    if ($departementalgroup) {
        if (!$departementalgroup_name || 
            ($departementalgroup_name && ($departementalgroup->name != $departementalgroup_name))) {
            gvgroups_leave_group($departementalgroup, $user);

            // leave every town groups
            if ($towngroups) {
                foreach($towngroups as $towngroup) {
                    gvgroups_leave_group($towngroup, $user);
                }
            }
        }
        else {
            $addtodepartementalgroup = false;
        }
    }

    // then, check regional group
    if ($regionalgroup) {
        if (!$regionalgroup_name ||
        ($regionalgroup_name && ($regionalgroup->name != $regionalgroup_name))) {
            gvgroups_leave_group($regionalgroup, $user);
        }
        else {
            $addtoregionalgroup = false;
        }
    }
    
    // add user to local groups if necessary
    if ($addtonationalgroup) {
        add_user_to_local_group($user, $nationalgroup_name, 'national');
    }
    if ($addtoregionalgroup) {
        add_user_to_local_group($user, $regionalgroup_name, 'regional');
    }
    if ($addtodepartementalgroup) {
        add_user_to_local_group($user, $departementalgroup_name, 'departemental');
    }
}

/**
 * Transform group item site menu to a dropdrown menu with local and working group menu items
 */
function gvgroups_custom_sitemenu_setup($hook, $type, $values) {
   
   $menus = array();
   
    foreach($values as $item) {
        if ($item->getName() == 'groups') {
            // remove menu item link
            $item->setHref('');
            
            // add 2 children items (local groups and working groups)
            $localgroup_item = new ElggMenuItem('localgroups', elgg_echo('gvgroups:localgroups'), 'groups/local');
            $localgroup_item->setItemClass('gvgroup-child-menu');
            $item->addChild($localgroup_item);

            $workinggroup_item = new ElggMenuItem('workinggroups', elgg_echo('gvgroups:workinggroups'), 'groups/working');
            $workinggroup_item->setItemClass('gvgroup-child-menu');
            $item->addChild($workinggroup_item);
        }
        
        $menus[] = $item;
    }
    
    return $menus;
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
            case 'all':
                // remove this url to avoid normal group access
                forward(REFERER);
                $result = false;
                break;
            case 'add':
                // remove this url to avoid normal group creation
                forward(REFERER);
                $result = false;
                break;
            case 'profile':
                $group = get_entity($page[1]);
                
                elgg_pop_breadcrumb();
                if ($group instanceof ElggGroup) {
                    if ($group->grouptype == 'local') {
                        elgg_push_breadcrumb(elgg_echo('gvgroups:localgroups'), "groups/local");
                    }
                    else {
                        elgg_push_breadcrumb(elgg_echo('gvgroups:workinggroups'), "groups/working");
                    }
                    groups_handle_profile_page($page[1]);
                }
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

/**
 * discussion page handler
 */
function gvgroups_route_discussion_handler($hook, $type, $return_value, $params) {
    
	elgg_load_library('elgg:discussion');
    
    /**
     * $return_value contains:
     * $return_value['handler'] => requested handler
     * $return_value['segments'] => url parts ($page)
     */
    $result = $return_value;

    if(!empty($return_value) && is_array($return_value)){
        $page = $return_value['segments'];

        switch ($page[0]) {
            case 'all':
                // remove this url to avoid sitewide discussion access
                forward(REFERER);
                $result = false;
                break;
        }
    }
    
    return $result;
}
