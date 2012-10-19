<?php
/**
 * GV tinymce plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvtinymce_init');

/**
 * Initialize the GV tinymce plugin.
 */
function gvtinymce_init() {

	// extend CSS
	elgg_extend_view('css/elgg', 'gvtinymce/css');
    
    // unregister the default config
    elgg_unregister_js('elgg.extended_tinymce');
    
    // full tinymce configuration
    elgg_register_js('elgg.extended_tinymce_full', elgg_get_simplecache_url('js', 'extended_tinymce_full'));
    elgg_register_simplecache_view('js/extended_tinymce_full');

    // simple tinymce configuration
	elgg_register_js('elgg.extended_tinymce_simple', elgg_get_simplecache_url('js', 'extended_tinymce_simple'));
    elgg_register_simplecache_view('js/extended_tinymce_simple');

	elgg_unregister_plugin_hook_handler('register', 'menu:longtext', 'extended_tinymce_longtext_menu');
}
