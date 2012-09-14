<?php
/**
 * Elgg Poll plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

elgg_load_library('elgg:polls');

// Get input data
$guid = get_input('guid');

//get the poll entity
$poll = get_entity($guid);

if (elgg_instanceof($poll,'object','poll')) {
    $user_guid = elgg_get_logged_in_user_guid();

    gvpolls_remove_previous_vote($poll, $user_guid);    
           
    // Success message
    system_message(elgg_echo("gvpolls:canceled"));
    // Forward to the poll page
    forward($poll->getUrl());
}
