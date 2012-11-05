<?php
elgg_register_event_handler('init', 'system', 'gvtheme_init');

function gvtheme_init() {
    // custom topbar
    elgg_unregister_menu_item('topbar', 'elgg_logo');
    elgg_register_plugin_hook_handler('register', 'menu:topbar', 'gvtheme_custom_topbarmenu_setup');
    elgg_register_plugin_hook_handler('register', 'menu:entity', 'gvtheme_custom_entitymenu_setup');
    elgg_register_plugin_hook_handler('register', 'menu:river', 'gvtheme_custom_rivermenu_setup');

    elgg_register_event_handler('pagesetup', 'system', 'gvtheme_custom_usersettings_pagesetup');

	elgg_extend_view('css/elgg', 'gvtheme/css');

	elgg_extend_view('page/elements/head', 'gvtheme/head');

    // remove entities statistics views from user account
    elgg_unextend_view('core/settings/statistics', 'core/settings/statistics/numentities');
    
    // override some actions
	$action_base = elgg_get_plugins_path() . 'gvtheme/actions';
	elgg_register_action("avatar/upload", "$action_base/avatar/upload.php");
	elgg_register_action("avatar/crop", "$action_base/avatar/crop.php");
	elgg_register_action("friends/add", "$action_base/friends/add.php");

	// get number of users
	$num_members = get_number_users();

    elgg_register_menu_item('topbar', array(
		'name' => 'member_number',
		'href' => "members/newest",
		'text' => elgg_echo("gvtheme:num_members", array($num_members)),
		'priority' => 1000,
		'section' => 'alt',
		));
}

function gvtheme_custom_usersettings_pagesetup(){
    elgg_unregister_menu_item('page', '1_statistics');
    elgg_unregister_menu_item('page', '1_plugins');
}

//
function gvtheme_custom_entitymenu_setup($hook, $type, $values, $params) {
	$entity = $params['entity'];

	$return_values = array();
	foreach($values as $key => $item) {
		if ($item->getName() == 'edit') {
			$title = elgg_echo('edit');
			$class = "elgg-icon elgg-icon-settings-alt";
			$item->setText("<span class='$class' title='$title'></span>");
		}
		
		$return_values[] = $item;
	}
	
	return $return_values;
}

//
function gvtheme_custom_rivermenu_setup($hook, $type, $values, $params) {
	$entity = $params['entity'];

	$return_values = array();
	foreach($values as $key => $item) {
		if ($item->getName() != 'comment'){
			$return_values[] = $item;
		}
	}
	
	return $return_values;
}

// custom the toolbar
function gvtheme_custom_topbarmenu_setup ($hook, $type, $values) {
    if (elgg_is_logged_in()) {
        $user = elgg_get_logged_in_user_entity();

        /* the profile item becomes a dropdown menu */
        foreach($values as $key => $item) {
            if ($item->getName() == 'profile') {
                $values[$key]->setText("<span class=\"elgg-icon elgg-icon-users \"/>".$values[$key]->getText()."</span>".$user->name);
                $profileItem = $values[$key];
            }
        }

        if (isset($profileItem)) {
            foreach($values as $key => $item) {
                if ($item->getName() == 'administration')
                {
                    $item->setText(elgg_echo('admin'));
                    $item->setItemClass('gvtheme-profile-child-menu');
                    $profileItem->addChild($item);
                }
                elseif ($item->getName() == 'usersettings')
                {
                    $item->setText(elgg_echo('settings:user'));
                    $item->setItemClass('gvtheme-profile-child-menu');
                    $profileItem->addChild($item);
                }
                elseif ($item->getName() == 'logout')
                {
                    $item->setItemClass('gvtheme-profile-child-menu');
                    $profileItem->addChild($item);
                }
                else
                {
                    // add labels to topbar icons
                    if ($item->getName() == 'messages')
                    {
                        $item->setText($item->getText().elgg_echo('gvtheme:mymessages'));
                        $item->setSection('alt');
                    }
                    
                    if ($item->getName() == 'friends')
                    {
                        $item->setText($item->getText().elgg_echo('gvtheme:myfriends'));
                        $item->setSection('alt');
                    }
                    
                    $return[] = $item;
                }
            }
        }
    
        // add "my profile" menu item
        $myprofileitem = new ElggMenuItem('myprofile', elgg_echo('gvtheme:myprofile'), "profile/".$user->username); 
        $myprofileitem->setSection('alt');
        $return[] = $myprofileitem;

        $return[] = $profileItem;
    }
    else
    {
        $return = $value;
    }
    
    return $return;
}
?>
