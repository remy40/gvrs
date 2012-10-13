<?php
/**
 * GV page plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvpages_init');

/**
 * Initialize the GV pages plugin.
 */
function gvpages_init() {
    // deactivate some url handlers
    elgg_register_plugin_hook_handler("route", "pages", "gvpages_route_pages_handler");
    elgg_register_plugin_hook_handler("route", "etherpad", "gvpages_route_pages_handler");
}

/**
 * Re-route some url handler
 */
function gvpages_route_pages_handler($hook, $type, $return_value, $params) {
    /**
     * $return_value contains:
     * $return_value['handler'] => requested handler
     * $return_value['segments'] => url parts ($page)
     */
    $result = $return_value;

	elgg_load_library('elgg:pages');

    if(!empty($return_value) && is_array($return_value)){
        $page = $return_value['segments'];
        $handler = $return_value['handler'];

        $base_dir = elgg_get_plugins_path() . "gvpages/pages/$handler";
        switch ($page[0]) {
            case 'owner':
                include "$base_dir/owner.php";
                $result = false;
                break;
            case 'view':
				set_input('guid', $page[1]);
                include "$base_dir/view.php";
                $result = false;
                break;
			case 'add':
				set_input('guid', $page[1]);
				include "$base_dir/new.php";
                $result = false;
				break;
			case 'edit':
				set_input('guid', $page[1]);
				include "$base_dir/edit.php";
                $result = false;
				break;
			case 'group':
				set_input('guid', $page[1]);
                include "$base_dir/owner.php";
                $result = false;
                break;
            case 'all':
            case 'friends':
                // remove this url to avoid sitewite page access
                forward(REFERER);
                $result = false;
                break;
        }
    }
    
    return $result;
}
