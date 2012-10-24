<?php
/**
 * GV polls plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvpolls_init');

/**
 * Initialize the GV polls plugin.
 */
function gvpolls_init() {
    
    // override polls library
	elgg_register_library('elgg:polls', elgg_get_plugins_path() . 'gvpolls/models/model.php');

	// Set up menu for logged in users
    elgg_unregister_menu_item('site', 'polls');
    $item = new ElggMenuItem('polls', elgg_echo('poll'), 'polls/all');
	elgg_register_menu_item('site', $item);

    // override polls actions
	$action_path = elgg_get_plugins_path() . 'gvpolls/actions/polls';
	elgg_register_action("polls/edit","$action_path/edit.php");
	elgg_register_action("polls/vote","$action_path/vote.php");
	elgg_register_action("polls/add_choices","$action_path/add_choices.php");
	elgg_register_action("polls/cancelvote","$action_path/cancelvote.php");

	// register the JavaScript
	$js = elgg_get_simplecache_url('js', 'polls/js');
	elgg_register_simplecache_view('js/polls/js');
	elgg_register_js('elgg.polls', $js);
}
