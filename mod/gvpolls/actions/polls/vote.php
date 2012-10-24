<?php
/**
 * Elgg Poll plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

// Get input data
$vote_flag = get_input('vote-submit', false);
$add_choices_flag = get_input('add_choice-submit', false);
$response = get_input('response');
$guid = get_input('guid');

// manage add_choice sub-action
if ($add_choices_flag) {
	elgg_load_library('elgg:polls');

	$number_of_choices = get_input('number_of_choices', 0);
	$poll_guid = get_input('poll_guid');

	if ($poll_guid) {
		$poll = get_entity($poll_guid);

		if ($number_of_choices) {
			$count = 0;
			$new_choices = array();
			for($i=0;$i<$number_of_choices;$i++) {
				$text = get_input('choice_text_'.$i,'');
				if ($text) {
					$new_choices[] = $text;
					$count ++;
				}
			}
		}

		// add choices to the poll
		polls_add_choices($poll, $new_choices);
	}
}

// manage vote sub-action
if ($vote_flag) {
	//get the poll entity
	$poll = get_entity($guid);
	if (elgg_instanceof($poll,'object','poll')) {
			
		// Make sure the response isn't blank
		if (empty($response)) {
				register_error(elgg_echo("polls:novote"));
				forward($poll->getUrl());
			// Otherwise, save the poll vote
		} else {

			$user_guid = elgg_get_logged_in_user_guid();
			
			// check to see if this user has already voted
			$options = array('annotation_name' => 'vote', 'annotation_owner_guid' => $user_guid, 'guid' => $guid);
			if (!elgg_get_annotations($options)) {
				//add vote as an annotation
				
				if (is_array($response)) {
					foreach ($response as $a_response) {
						$poll->annotate('vote', $a_response, $poll->access_id);
					}
				}
				else {
					$poll->annotate('vote', $response, $poll->access_id);
				}
				
				// Add to river
				$polls_vote_in_river = elgg_get_plugin_setting('vote_in_river','polls');
				if ($polls_vote_in_river != 'no') {
					add_to_river('river/object/poll/vote','vote',$user_guid,$poll->guid);
				}
					
				// Success message
				system_message(elgg_echo("polls:responded"));
				// Forward to the poll page
				forward($poll->getUrl());
			}
		}		
	}
}
