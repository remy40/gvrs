<?php
elgg_register_event_handler('init', 'system', 'gvtheme_init');

function gvtheme_init() {

    // custom index page
    elgg_register_plugin_hook_handler('index', 'system', 'gvtheme_custom_index_page', 1);

    // custom topbar
    elgg_unregister_menu_item('topbar', 'elgg_logo');
    elgg_register_plugin_hook_handler('register', 'menu:topbar', 'gvtheme_custom_topbarmenu_setup');

	elgg_extend_view('css/elgg', 'gvtheme/css');
}

/* custom the index page */
function gvtheme_custom_index_page($hook, $type, $return, $params){
	if ($return == true) {
		// another hook has already replaced the front page
		return $return;
	}

	if (!include_once(dirname(__FILE__) . "/index.php")) {
		return false;
	}

	// return true to signify that we have handled the front page
	return true;
}

// custom the toolbar
function gvtheme_custom_topbarmenu_setup ($hook, $type, $values) {
    if (elgg_is_logged_in()) {
        $user = elgg_get_logged_in_user_entity();

        /* the profile item becomes a dropdown menu */
        foreach($values as $key => $item) {
            if ($item->getName() == 'profile') {
                $values[$key]->setText("<span class=\"elgg-icon elgg-icon-users \"/>".$values[$key]->getText()."</span>".$user->name);
                $values[$key]->setHref('');
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
