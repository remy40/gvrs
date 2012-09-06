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
	$action_base = elgg_get_plugins_path() . 'gvthewire/actions';
	elgg_register_action("thewire/add", "$action_base/add.php");
}

function gvthewire_save_post($text, $userid, $access_id, $parent_guid = 0, $method = "site") {
	$post = new ElggObject();

	$post->subtype = "thewire";
	$post->owner_guid = $userid;
	$post->access_id = $access_id;

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