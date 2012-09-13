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

    // override polls actions
	$action_path = elgg_get_plugins_path() . 'gvpolls/actions/polls';
	elgg_register_action("polls/edit","$action_path/edit.php");
	elgg_register_action("polls/vote","$action_path/vote.php");
}
