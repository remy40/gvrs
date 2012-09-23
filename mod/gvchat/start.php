<?php
/**
 * GV chat plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvchat_init');

/**
 * Initialize the GV chat plugin.
 */
function gvchat_init() {

	// add sitewide menu
	elgg_register_menu_item('site', array(
		'name' => 'chat',
		'text' => elgg_echo('gvchat:chat'),
		'href' => 'chat'
	));

    // add page handler
    elgg_register_page_handler('chat', 'gvchat_page_handler');

    // add chat group option
	add_group_tool_option('chat', elgg_echo('gvchat:enablechat'), true);

    // add a menu item in the group menu
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'gvchat_owner_block_menu');

}

/**
 * Add a menu item to an ownerblock
 * 
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function gvchat_owner_block_menu($hook, $type, $return, $params) {

	if (elgg_instanceof($params['entity'], 'group')) {
		if ($params['entity']->gvchat_enable != 'no') {
			$url = "chat/group/{$params['entity']->guid}";
			$item = new ElggMenuItem('gvchat', elgg_echo('gvchat:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}


/**
 * gvchat page handler
 *  isegoria chat:  chat
 *  group chat:     chat/group/<guid>
 */
function gvchat_page_handler($page) {

	$pages = dirname(__FILE__) . '/pages';

    if (isset($page[0])) {
        switch ($page[0]) {
            case 'group':
                if (isset($page[1])) {
                    group_gatekeeper();
                    set_input('groupguid', $page[1]);
                    include "$pages/group.php";
                }
                break;
            default:
                return false;   
        }
    }
    else {
        include "$pages/isegoria.php";
    }
   
    return true;
}
