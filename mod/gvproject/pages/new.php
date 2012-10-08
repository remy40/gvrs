<?php
/**
 * Create a new project
 */

group_gatekeeper();

$container_guid = (int) get_input('guid');
elgg_set_page_owner_guid($container_guid);

$title = elgg_echo('gvprojects:add');
elgg_push_breadcrumb($title);

$vars['container_guid'] = $container_guid;
$content = elgg_view_form('projects/edit', array(), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
