<?php
/**
 * New users admin widget
 */

$num = (int) $vars['entity']->num_display;

echo elgg_list_entities(array(
	'type' => 'user',
	'limit' => $num,
	'subtype'=> null,
	'full_view' => FALSE
));
