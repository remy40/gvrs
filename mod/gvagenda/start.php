<?php
/**
 * GV agenda plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvagenda_init');

/**
 * Initialize the GV agenda plugin.
 */
function gvagenda_init() {
    elgg_extend_view('css/elgg', 'gvagenda/css');
}
