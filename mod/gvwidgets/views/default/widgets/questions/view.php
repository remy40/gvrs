<?php
/**
 *	Questions widget content
 **/

$widget = $vars['entity'];

echo elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'question',
	'owner_guid' => elgg_get_logged_in_user_guid,
	'limit' => $widget->limit,
));
