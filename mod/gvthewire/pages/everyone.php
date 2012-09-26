<?php
/**
 * All wire posts
 * 
 */

elgg_push_breadcrumb(elgg_echo('thewire'));

$title = elgg_echo('thewire:everyone');

$content = '';
if (elgg_is_logged_in()) {
	$form_vars = array('class' => 'thewire-form');
	$content .= elgg_view_form('thewire/add', $form_vars);
	$content .= elgg_view('input/urlshortener');
}

$db_prefix = elgg_get_config('dbprefix');
$options = array('types' => 'object',
                 'subtypes' => 'thewire',
                 'limit' => 15, 
                 'order_by' => 'e.guid', 
                 'reverse_order_by' => true,
                 'joins' => array("LEFT JOIN {$db_prefix}groups_entity AS g ON e.container_guid = g.guid "),
                 'wheres' => array("g.guid IS NULL"));

$content .= elgg_list_entities($options);

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('thewire/sidebar'),
));

echo elgg_view_page($title, $body);
