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
    elgg_extend_view('css/elgg', 'gvchat/css');
}
