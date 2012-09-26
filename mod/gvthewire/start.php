<?php
/**
 * GV Elgg wire plugin
 * 
 */

elgg_register_event_handler('init', 'system', 'gvthewire_init');

/**
 * The GV Wire initialization
 */
function gvthewire_init() {
   
    // override action
	$action_base = elgg_get_plugins_path() . 'gvthewire/actions';
	elgg_register_action("thewire/add", "$action_base/add.php");

    // extend thewire page handler
    elgg_register_plugin_hook_handler("route", "thewire", "gvthewire_route_handler");

    // add thewire group option
	add_group_tool_option('thewire', elgg_echo('gvthewire:enablemicroblog'), true);

    // add a menu item in the group menu
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'gvthewire_owner_block_menu');
}

/**
 * Add a menu item to an ownerblock
 * 
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function gvthewire_owner_block_menu($hook, $type, $return, $params) {

	if (elgg_instanceof($params['entity'], 'group')) {
		if ($params['entity']->thewire_enable != 'no') {
			$url = "thewire/group/{$params['entity']->guid}";
			$item = new ElggMenuItem('thewire', elgg_echo('gvthewire:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

function gvthewire_route_handler($hook, $type, $return_value, $params){
    /**
     * $return_value contains:
     * $return_value['handler'] => requested handler
     * $return_value['segments'] => url parts ($page)
     */
    $result = $return_value;
    
    if(!empty($return_value) && is_array($return_value)){
        $page = $return_value['segments'];
        
        $base_dir = elgg_get_plugins_path() . 'gvthewire/pages/';
        switch($page[0]){
            case "group":
                if (isset($page[1])) {
                    set_input('container_guid', $page[1]);
                    include "$base_dir/group.php";
                    $result = false;
                }
                break;

            case "all":
                include "$base_dir/everyone.php";
                $result = false;
                break;

            default:
                break;
        }
    }
    
    return $result;
}

function gvthewire_save_post($text, $userid, $access_id, $parent_guid = 0, $method = "site", $container_guid = 0) {
	$post = new ElggObject();

	$post->subtype = "thewire";
	$post->owner_guid = $userid;
	$post->access_id = $access_id;
    
    if ($container_guid) {
        $post->container_guid = $container_guid;
    }
    
	$text = elgg_substr($text, 0, gvthewire_get_character_limit());

	// no html tags allowed so we escape
	$post->description = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');

	$post->method = $method; //method: site, email, api, ...

	$tags = thewire_get_hashtags($text);
	if ($tags) {
		$post->tags = $tags;
	}

	// must do this before saving so notifications pick up that this is a reply
	if ($parent_guid) {
		$post->reply = true;
	}

	$guid = $post->save();

	// set thread guid
	if ($parent_guid) {
		$post->addRelationship($parent_guid, 'parent');
		
		// name conversation threads by guid of first post (works even if first post deleted)
		$parent_post = get_entity($parent_guid);
		$post->wire_thread = $parent_post->wire_thread;
	} else {
		// first post in this thread
		$post->wire_thread = $guid;
	}

	if ($guid) {
		add_to_river('river/object/thewire/create', 'create', $post->owner_guid, $post->guid);

		// let other plugins know we are setting a user status
		$params = array(
			'entity' => $post,
			'user' => $post->getOwnerEntity(),
			'message' => $post->description,
			'url' => $post->getURL(),
			'origin' => 'thewire',
		);
		elgg_trigger_plugin_hook('status', 'user', $params);
	}
	
	return $guid;
}

function gvthewire_get_character_limit() {
    $character_limit = elgg_get_plugin_setting('character_limit', 'gvthewire');

    if (!$character_limit) {
        $character_limit = 350;
    }
    
    return $character_limit;
}
