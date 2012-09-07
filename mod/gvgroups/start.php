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

    // unregister the sidebar menu
//	elgg_unregister_event_handler('pagesetup', 'system', 'groups_setup_sidebar_menus');

    // add some page handler
    elgg_register_plugin_hook_handler("route", "groups", "gvgroups_route_groups_handler");
    
   	// override some actions
	$action_base = elgg_get_plugins_path() . 'gvgroups/actions/';
	elgg_register_action("groups/edit", "$action_base/groups/edit.php");
    
    // register some new actions
    elgg_register_action("admin/createlocal", "$action_base/admin/createlocal.php");
    elgg_register_action("admin/deletelocal", "$action_base/admin/deletelocal.php");
    
    // add a hook to transform group menu item in a dropdown menu
    elgg_register_plugin_hook_handler('register', 'menu:site', 'gvgroups_custom_sitemenu_setup');

    // add "my groups" menu to the topbar
    elgg_register_menu_item('topbar', array(
    'name' => 'mygroups',
    'href' => "groups/member/$user->username",
    'text' => elgg_echo('gvgroups:mygroups'),
    'section' => 'alt'
    ));
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
