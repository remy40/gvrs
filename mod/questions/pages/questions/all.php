<?php
/**
 * Elgg questions plugin everyone page
 * @package Elggquestions
 */

elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'question',
	'full_view' => false,
	'list_type_toggle' => false,
	'limit' => 30,
));

$title = elgg_echo('questions:everyone');

$body = elgg_view_layout('content', array(
	'title' => $title,
	'content' => $content,
	'filter' => '',
));

echo elgg_view_page($title, $body);
