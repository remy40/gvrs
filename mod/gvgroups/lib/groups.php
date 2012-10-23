<?php
/**
 * Groups function library
 */

// add country functions
require_once(dirname(__FILE__) . "/country.php");

/**
 * Check if a group name already exists
 * @name : name of the group
 * @entities: a group list
 */
function is_group_name_existing($name, $entities) {
    foreach($entities as $entity) {
        if ($entity->name == $name) {
            return true;
        }
    }
    return false;
}

/**
 * Delete all local groups
 */
function delete_all_local_groups() {
    $depgroup = array();
    $options["type"] = 'group';
    $options["limit"] = NULL;
    $options["metadata_name"] = 'grouptype';
    $options["metadata_value"]= 'local';

    $localgroups = elgg_get_entities_from_metadata($options);

    foreach($localgroups as $localgroup) {
        $localgroup->delete();
    }
}

/**
 * Create all local groups
 */
function create_local_groups() {

    // first, creates country groups
    $countrygroup_guid = array();
    $options["type"] = 'group';
    $options["limit"] = NULL;
    $options["metadata_name_value_pairs"][] = array(
            "name" => 'grouptype',
            "value" => 'local');
    $options["metadata_name_value_pairs"][] = array(
            "name" => 'localtype',
            "value" => 'national');

    $existing_countrygroups = elgg_get_entities_from_metadata($options);

    $country_data = get_country_data();
    foreach($country_data as $country) {
        if (!is_group_name_existing($country, $existing_countrygroups)) {
            $group = new ElggGroup;
            $group->name = $country;
            $group->description = "";
            $group->grouptype = 'local';
            $group->localtype = 'national';
            $group->membership = ACCESS_PUBLIC;
            $group->access_id = ACCESS_LOGGED_IN;
            $group->save();
            $countrygroup_guid[$country] = $group->guid;
        }
    }    

    // then, creates departement groups
    $depgroup_guids = array();
    $options["type"] = 'group';
    $options["limit"] = NULL;
    $options["metadata_name_value_pairs"][] = array(
            "name" => 'grouptype',
            "value" => 'local');
    $options["metadata_name_value_pairs"][] = array(
            "name" => 'localtype',
            "value" => 'departemental');

    $existing_depgroups = elgg_get_entities_from_metadata($options);

    $departements_data = get_departement_data();
    foreach($departements_data as $num => $name) {
        $groupname = $num." - ".$name;
       
        if (!is_group_name_existing($groupname, $existing_depgroups)) {
            $group = new ElggGroup;
            $group->name = $groupname;
            $group->description = "";
            $group->grouptype = 'local';
            $group->localtype = 'departemental';
            $group->membership = ACCESS_PUBLIC;
            $group->access_id = ACCESS_LOGGED_IN;
            $group->save();
            $depgroup_guids[$num] = $group->guid;
        }
    }

    // finally, creates region groups
      $options["metadata_name_value_pairs"] = array(
        array(
            'name' => 'grouptype',
            'value' => 'local',
            'operand' => '=',
            'case_sensitive' => TRUE,),
        array(
            'name' => 'localtype',
            'value' => 'regional',
            'operand' => '=',
            'case_sensitive' => TRUE,)
            );        
    
    $existing_region_groups = elgg_get_entities_from_metadata($options);

    $regions_data = get_region_data();
    foreach($regions_data as $name => $dep_nums) {
        
        if (!is_group_name_existing($name, $existing_region_groups)) {
            $group = new ElggGroup;
            $group->name = $name;
            $group->grouptype = 'local';
            $group->localtype = 'regional';
            $group->membership = ACCESS_PUBLIC;
            $group->access_id = ACCESS_LOGGED_IN;
            $group->save();
            
            //add relationship with departement groups
            foreach ($dep_nums as $num) {
                
                $depgroup = get_entity($depgroup_guids[$num]);

                if ($depgroup) {
                    $group->addRelationship($depgroup->guid, 'child');
                    $depgroup->addRelationship($group->guid, 'parent');
                    $depgroup->save();
                }
            }
            
            // add relationship with country group
            $countrygroup = get_entity($countrygroup_guid['France']);
            
            if ($countrygroup) {
                $countrygroup->addRelationship($group->guid, 'child');
                $group->addRelationship($countrygroup->guid, 'parent');
                $countrygroup->save();
            }
            
            $group->save();
        }
    }
}

/**
 * Get the local group of type $localtype where the user subscribed 
 */
function get_local_group_for_user($user_guid, $localtype) {
  	$group_options["type"] = 'group';
	$group_options["relationship"] = 'member';
	$group_options["relationship_guid"] = $user_guid;
	$group_options["inverse_relationship"] = false;
	$group_options["full_view"] = false;
	$group_options["limit"] = NULL;
    $group_options["joins"]	= array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid");
    $group_options["order_by"] = "ge.name ASC";
    $group_options["metadata_name_value_pairs"][] = array(
                    "name" => 'grouptype',
                    "value" => 'local');
    $group_options["metadata_name_value_pairs"][] = array(
                    "name" => 'localtype',
                    "value" => $localtype);

	return elgg_get_entities_from_relationship($group_options);
}

/**
 * Get the local groups list where the user subscribed 
 */
function get_local_groups_for_user($user_guid) {
  	$group_options["type"] = 'group';
	$group_options["relationship"] = 'member';
	$group_options["relationship_guid"] = $user_guid;
	$group_options["inverse_relationship"] = false;
	$group_options["full_view"] = false;
	$group_options["limit"] = NULL;
    $group_options["joins"]	= array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid");
    $group_options["order_by"] = "ge.name ASC";

    // first, local groups
    $group_options["metadata_name"] = 'grouptype';
    $group_options["metadata_value"] = 'local';

	return elgg_get_entities_from_relationship($group_options);
}

/**
 * Create the page title according to options
 */
function groups_get_pagetitle($action, $type) {
    
    $title='';
    
    switch ($type)
    {
        case 'local':
            switch ($action)
            {
                case 'add':
                    $title = elgg_echo('localgroups:add');
                    break;
                case 'edit':
                    $title = elgg_echo('localgroups:edit');
                    break;
                case 'showall':
                    $title = elgg_echo('localgroups:all');
                    break;
            }
            break;
        case 'working':
            switch ($action)
            {
                case 'add':
                    $title = elgg_echo('workinggroups:add');
                    break;
                case 'edit':
                    $title = elgg_echo('workinggroups:edit');
                    break;
                case 'showall':
                    $title = elgg_echo('workinggroups:all');
                    break;
            }
            break;
        case 'default':
        default:
            switch ($action)
            {
                case 'add':
                    $title = elgg_echo('groups:add');
                    break;
                case 'edit':
                    $title = elgg_echo('groups:edit');
                    break;
                case 'showall':
                    $title = elgg_echo('groups:all');
                    break;
            }
    }

    return $title;
}

/**
 * Show create content button according to options
 */
function groups_register_title_button($type) {

	if (elgg_is_logged_in() && ($type != 'local')) {
		$owner = elgg_get_page_owner_entity();
		if (!$owner) {
			// no owns the page so this is probably an all site list page
			$owner = elgg_get_logged_in_user_entity();
		}
		if ($owner && $owner->canWriteToContainer()) {
            
            if ($type == 'working') {
                $handler = 'groups/working';
                $label = 'workinggroups';
            } 
            else {
                $handler = 'groups';
                $label = 'groups';
            }
            
			elgg_register_menu_item('title', array(
				'name' => 'add',
				'href' => "$handler/add",
				'text' => elgg_echo("$label:add"),
				'link_class' => 'elgg-button elgg-button-action',
			));
		}
	}
}
/**
 * List all groups
 */
function groups_handle_all_page($type = 'default') {

    $title = groups_get_pagetitle('showall', $type);
    groups_register_title_button($type);
    $dbprefix = elgg_get_config("dbprefix");

    if ($type == 'local') {
        $selected_tab = get_input('filter', 'national');
        $content = elgg_list_entities_from_metadata(array(
                'type' => 'group',
                'full_view' => false,
                'metadata_name_value_pairs' => array(
                    array(
                        'name' => 'grouptype',
                        'value' => 'local'),
                    array(
                        'name' => 'localtype',
                        'value' => $selected_tab)
                        ),
                'limit' => 20,
                'joins'	=> array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid"),
                'order_by' => "ge.name ASC",
            ));
        if (!$content) {
            $content = elgg_echo('groups:none');
        }
    }
    else {
        $selected_tab = get_input('filter', 'newest');

        $group_options["type"] = 'group';
        $group_options["full_view"] = false;
        $group_options["limit"] = 20;
        $group_options["metadata_name"] = 'grouptype';
        $group_options["metadata_value"] = $type;

        switch ($selected_tab) {
            case 'popular':
                $group_options["relationship"] = 'member';
                $group_options["inverse_relationship"] = false;
                $content = elgg_list_entities_from_relationship_count($group_options);
                break;
            case 'alphabetical':
                $group_options["joins"]	= array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid");
                $group_options["order_by"] = "ge.name ASC";
                $content = elgg_list_entities_from_metadata($group_options);
                break;
            case 'newest':
            default:
                $content = elgg_list_entities_from_metadata($group_options);
                break;
        }

        if (!$content) {
            $content = elgg_echo('groups:none');
        }
    }

    switch ($type) {
        case 'local':
            $title = elgg_echo('localgroups');
            break;
        case 'working':
            $title = elgg_echo('workinggroups');
            break;
        default:
            $title = elgg_echo('groups');
    }

	$filter = elgg_view('groups/group_sort_menu', array('selected' => $selected_tab, 'grouptype' => $type));
	
	$sidebar = elgg_view('groups/sidebar/find');
	$sidebar .= elgg_view('groups/sidebar/featured');

	$params = array(
        'title' => $title,
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => $filter,
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * return a list of groups that match options (used to search in name and description)
 */
function elgg_get_group_by_name($options) {
	$db_prefix = elgg_get_config('dbprefix');

    $query = "SELECT DISTINCT e.* FROM {$db_prefix}entities e, {$db_prefix}groups_entity g ";
    $query .= "WHERE e.guid = g.guid AND e.type = 'group' AND (g.name LIKE '%" . sanitise_string($options['groupname']) . "%' ";
    $query .= " OR g.description LIKE '%" . sanitise_string($options['groupname']) . "%')";

    $dt = get_data($query, entity_row_to_elggstar);
    return $dt;
}

/**
 * show the group search page
 */
function groups_search_page() {
	$searchstring = get_input("searchstring");
	$title = elgg_echo('groups:search:title', array($searchstring));

    $params = array(
        'groupname' => $searchstring,
        'full_view' => 'false',
        );
	$content = elgg_list_entities($params, elgg_get_group_by_name);

if (!$content) {
		$content = elgg_echo('groups:search:none');
	}

	$sidebar = elgg_view('groups/sidebar/find');
	$sidebar .= elgg_view('groups/sidebar/featured');

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => false,
		'title' => $title,
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * List owned groups
 */
function groups_handle_owned_page() {

	$page_owner = elgg_get_page_owner_entity();

	$title = elgg_echo('groups:owned');
	elgg_push_breadcrumb($title);

	elgg_register_title_button();

	$content = elgg_list_entities(array(
		'type' => 'group',
		'owner_guid' => elgg_get_page_owner_guid(),
		'full_view' => false,
	));
	if (!$content) {
		$content = elgg_echo('groups:none');
	}

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * List groups the user is memober of
 */
function groups_handle_mine_page() {

	$title = elgg_echo('groups:yours');

	$username = get_input('username');
	if ($username) {
		$user = get_user_by_username($username);
	}
	
	if (!$username || !$user) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo("menu:home"), "dashboard");
	elgg_push_breadcrumb(elgg_get_logged_in_user_entity()->name, "pages/owner/".$user->guid."/all");
	
	$group_options["type"] = 'group';
	$group_options["relationship"] = 'member';
	$group_options["relationship_guid"] = $user->guid;
	$group_options["inverse_relationship"] = false;
	$group_options["full_view"] = false;
	$group_options["limit"] = NULL;
    $group_options["joins"]	= array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid");
    $group_options["order_by"] = "ge.name ASC";

    // first, local groups
    $group_options["metadata_name"] = 'grouptype';
    $group_options["metadata_value"] = 'local';

    $pagecontent = elgg_view('page/elements/subtitle', array('title' => elgg_echo('localgroups:mine'), 'class' => 'elgg-subtitle'));

	$content = elgg_list_entities_from_relationship_count($group_options);
	if (!$content) {
		$content = elgg_echo('groups:none');
	}
    
    $pagecontent .= $content;
    
    // then, working groups
    $group_options["metadata_name"] = 'grouptype';
    $group_options["metadata_value"] = 'working';

    $pagecontent .= elgg_view('page/elements/subtitle', array('title' => elgg_echo('workinggroups:mine'), 'class' => 'elgg-subtitle'));

	$content = elgg_list_entities_from_relationship_count($group_options);
	if (!$content) {
		$content = elgg_echo('groups:none');
	}
    
    $pagecontent .= $content;

	$params = array(
		'content' => $pagecontent,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}


/**
 * Create local group (which is a town group)
 *
 */
function groups_handle_add_local_page($guid) {
    //here, $guid is the guid of the parent group (which is departemental)
    elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
    $title = groups_get_pagetitle('add', 'local');
    $content = elgg_view('groups/edit', array('group_type' => 'local', 'parent_guid' => $guid));
    
    $params = array(
    'content' => $content,
    'title' => $title,
    'filter' => '',
	);

	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Create or edit a group
 *
 * @param string $page
 * @param int $guid
 */
function groups_handle_edit_page($page, $type, $guid = 0) {
	gatekeeper();
	
	if ($page == 'add') {
		elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
        $title = groups_get_pagetitle('add', $type);        
//		elgg_push_breadcrumb($title);
		$content = elgg_view('groups/edit', array('group_type' => $type));
	} else {
        $title = groups_get_pagetitle('edit', $type);        
		$group = get_entity($guid);

		if ($group && $group->canEdit()) {
			elgg_set_page_owner_guid($group->getGUID());
//			elgg_push_breadcrumb($group->name, $group->getURL());
//			elgg_push_breadcrumb($title);
			$content = elgg_view("groups/edit", array('entity' => $group, 'group_type' => $type));
		} else {
			$content = elgg_echo('groups:noaccess');
		}
	}
	
	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Group invitations for a user
 */
function groups_handle_invitations_page() {
	gatekeeper();

	$username = get_input('username');
	if ($username) {
		$user = get_user_by_username($username);
	}
	
	if (!$username || !$user) {
		$user = elgg_get_logged_in_user_entity();
	}

	$title = elgg_echo('groups:invitations');
	elgg_push_breadcrumb($title);

	$invitations = groups_get_invited_groups($user->guid);
	$content = elgg_view('groups/invitationrequests', array('invitations' => $invitations));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Group profile page
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_profile_page($guid) {
	elgg_set_page_owner_guid($guid);

	// turn this into a core function
	global $autofeed;
	$autofeed = true;

	$group = get_entity($guid);
	if (!$group) {
		forward('groups/all');
	}

	$content = elgg_view('groups/profile/layout', array('entity' => $group));

    $sidebar = '';
    if ($group->grouptype == 'local') {
        $sidebar .= elgg_view('groups/sidebar/localgrouplist', array('group_guid' => $group->getGUID()));
    }

	if (group_gatekeeper(false)) {
		if (elgg_is_active_plugin('search')) {
			$sidebar .= elgg_view('groups/sidebar/search', array('entity' => $group));
		}
		$sidebar .= elgg_view('groups/sidebar/members', array('entity' => $group));
	}
    
	groups_register_profile_buttons($group);

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'title' => $group->name,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($group->name, $body);
}

/**
 * Group activity page
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_activity_page($guid) {

	elgg_set_page_owner_guid($guid);

	$group = get_entity($guid);
	if (!$group || !elgg_instanceof($group, 'group')) {
		forward();
	}

	group_gatekeeper();

	$title = elgg_echo('groups:activity');

	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo("gvgroups:".$group->grouptype."groups"), "groups/".$group->grouptype);
	elgg_push_breadcrumb($group->name, "groups/activity/".$group->guid);

	$db_prefix = elgg_get_config('dbprefix');

	$content = elgg_list_river(array(
		'joins' => array("JOIN {$db_prefix}entities e ON e.guid = rv.object_guid"),
		'wheres' => array("e.container_guid = $guid")
	));
	if (!$content) {
		$content = '<p>' . elgg_echo('groups:activity:none') . '</p>';
	}
	
	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Group members page
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_members_page($guid) {

	elgg_set_page_owner_guid($guid);

	$group = get_entity($guid);
	if (!$group || !elgg_instanceof($group, 'group')) {
		forward();
	}

	group_gatekeeper();

	$title = elgg_echo('groups:members:title', array($group->name));

	elgg_push_breadcrumb($group->name, $group->getURL());
	elgg_push_breadcrumb(elgg_echo('groups:members'));

	$content = elgg_list_entities_from_relationship(array(
		'relationship' => 'member',
		'relationship_guid' => $group->guid,
		'inverse_relationship' => true,
		'types' => 'user',
		'limit' => 20,
	));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Invite users to a group
 *
 * @param int $guid Group entity GUID
 */
function groups_handle_invite_page($guid) {
	gatekeeper();

	elgg_set_page_owner_guid($guid);

	$group = get_entity($guid);

	$title = elgg_echo('groups:invite:title');

	elgg_push_breadcrumb($group->name, $group->getURL());
	elgg_push_breadcrumb(elgg_echo('groups:invite'));

	if ($group && $group->canEdit()) {
		$content = elgg_view_form('groups/invite', array(
			'id' => 'invite_to_group',
			'class' => 'elgg-form-alt mtm',
		), array(
			'entity' => $group,
		));
	} else {
		$content .= elgg_echo('groups:noaccess');
	}

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Manage requests to join a group
 * 
 * @param int $guid Group entity GUID
 */
function groups_handle_requests_page($guid) {

	gatekeeper();

	elgg_set_page_owner_guid($guid);

	$group = get_entity($guid);

	$title = elgg_echo('groups:membershiprequests');

	if ($group && $group->canEdit()) {
		elgg_push_breadcrumb($group->name, $group->getURL());
		elgg_push_breadcrumb($title);
		
		$requests = elgg_get_entities_from_relationship(array(
			'type' => 'user',
			'relationship' => 'membership_request',
			'relationship_guid' => $guid,
			'inverse_relationship' => true,
			'limit' => 0,
		));
		$content = elgg_view('groups/membershiprequests', array(
			'requests' => $requests,
			'entity' => $group,
		));

	} else {
		$content = elgg_echo("groups:noaccess");
	}

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Registers the buttons for title area of the group profile page
 *
 * @param ElggGroup $group
 */
function groups_register_profile_buttons($group) {
    $user = elgg_get_logged_in_user_entity();
	$actions = array();

	// group owners
	if ($group->canEdit()) {
        // local groups except town groups cannot be edited (except by admins)
        if (($group->grouptype != 'local') || 
            (($group->grouptype == 'local') && ($group->localtype == 'town')) ||
            $user->isAdmin()) {
            $url = elgg_get_site_url() . "groups/edit/{$group->getGUID()}";
            $actions[$url] = 'groups:edit';
        }

        // local groups except town groups cannot use invitation system
        if (($group->grouptype != 'local') || 
            (($group->grouptype == 'local') && ($group->localtype == 'town'))) {
            $url = elgg_get_site_url() . "groups/invite/{$group->getGUID()}";
            $actions[$url] = 'groups:invite';
        }
	}

    // add a button to allow adding town groups (only for group members)
    if (($group->grouptype == 'local') && ($group->localtype == 'departemental') &&
         $group->isMember(elgg_get_logged_in_user_entity())) {
        $url = elgg_get_site_url() . "groups/local/add/{$group->getGUID()}";
        $actions[$url] = 'localgroups:addtown';
    }

	// group members (not for local groups except town group)
    if ((($group->grouptype == 'local') && ($group->localtype == 'town')) ||
        ($group->grouptype != 'local')) {
        if ($group->isMember(elgg_get_logged_in_user_entity())) {
            if ($group->getOwnerGUID() != elgg_get_logged_in_user_guid()) {
                // leave
                $url = elgg_get_site_url() . "action/groups/leave?group_guid={$group->getGUID()}";
                $url = elgg_add_action_tokens_to_url($url);
                $actions[$url] = 'groups:leave';
            }
        } elseif (elgg_is_logged_in()) {
            // join - admins can always join.
            $url = elgg_get_site_url() . "action/groups/join?group_guid={$group->getGUID()}";
            $url = elgg_add_action_tokens_to_url($url);
            if ($group->isPublicMembership() || $group->canEdit()) {
                $actions[$url] = 'groups:join';
            } else {
                // request membership
                $actions[$url] = 'groups:joinrequest';
            }
        }
    }

    if ($actions) {
        foreach ($actions as $url => $text) {
            elgg_register_menu_item('title', array(
                'name' => $text,
                'href' => $url,
                'text' => elgg_echo($text),
                'link_class' => 'elgg-button elgg-button-action',
            ));
        }
    }
}
