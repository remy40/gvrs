<?php
/**
 * List all projects
 */

$title = elgg_echo('gvprojects:all');

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('gvprojects'));

$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => 'project',
	'full_view' => false,
));
if (!$content) {
	$content = '<p>' . elgg_echo('gvprojects:none') . '</p>';
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('projects/sidebar'),
));

echo elgg_view_page($title, $body);
