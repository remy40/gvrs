<?php
/**
 * User blog widget display view
 */

$num = $vars['entity']->num_display;

$options = array(
	'type' => 'object',
	'subtype' => 'groupforumtopic',
	'owner_guid' => elgg_get_logged_in_user_guid(),
	'limit' => $num,
	'full_view' => FALSE,
	'pagination' => FALSE,
);
$content = elgg_list_entities($options);

echo $content;

if (!$content) {
	echo elgg_echo('grouptopic:notcreated');
}
