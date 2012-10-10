<?php
/**
 * Elgg delete dislike action
 *
 */

$dislikes = elgg_get_annotations(array(
	'guid' => (int) get_input('guid'),
	'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
	'annotation_name' => 'dislikes',
));
if ($dislikes) {
	if ($dislikes[0]->canEdit()) {
		$dislikes[0]->delete();
		system_message(elgg_echo("gvdislikes:dislikes:deleted"));
		forward(REFERER);
	}
}

register_error(elgg_echo("gvdislikes:dislikes:notdeleted"));
forward(REFERER);
