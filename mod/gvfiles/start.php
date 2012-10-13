<?php
/**
 * GV files plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvfiles_init');

/**
 * Initialize the GV files plugin.
 */
function gvfiles_init() {
    elgg_register_plugin_hook_handler("route", "file", "gvfiles_route_file_handler");
}

/**
 * Re-route some url handler
 */
function gvfiles_route_file_handler($hook, $type, $return_value, $params) {
    /**
     * $return_value contains:
     * $return_value['handler'] => requested handler
     * $return_value['segments'] => url parts ($page)
     */
    $result = $return_value;

    if(!empty($return_value) && is_array($return_value)){
        $page = $return_value['segments'];

		elgg_load_library('elgg:file');

        $file_dir = elgg_get_plugins_path() . 'gvfiles/pages/';
        switch ($page[0]) {
			case 'all':
				file_register_toggle();
				include "$file_dir/world.php";
                $result = false;
				break;
			case 'view':
			case 'read': // Elgg 1.7 compatibility
				set_input('guid', $page[1]);
				include "$file_dir/view.php";
                $result = false;
				break;
			case 'owner':
				file_register_toggle();
				include "$file_dir/owner.php";
				$result = false;
				break;
			case 'group':
				file_register_toggle();
				include "$file_dir/owner.php";
				$result = false;
				break;
			case 'add':
				include "$file_dir/upload.php";
				$result = false;
				break;
			case 'edit':
				set_input('guid', $page[1]);
				include "$file_dir/edit.php";
				$result = false;
				break;
        }
    }
    
    return $result;
}
