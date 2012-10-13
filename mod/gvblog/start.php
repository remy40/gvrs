<?php
/**
 * GV blog plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvblog_init');

/**
 * Initialize the GV blog plugin.
 */
function gvblog_init() {
	elgg_register_library('elgg:blog', elgg_get_plugins_path() . 'gvblog/lib/blog.php');
}
