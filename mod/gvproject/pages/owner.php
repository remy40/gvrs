<?php
/**
 * List a group's pages
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('projects/all');
}

// access check for closed groups
group_gatekeeper();

$title = elgg_echo('gvprojects:owner', array($owner->name));

elgg_push_breadcrumb($owner->name);

elgg_register_title_button();

$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => 'project',
	'container_guid' => $owner->guid,
	'full_view' => false,
));
if (!$content) {
	$content = '<p>' . elgg_echo('gvprojects:none') . '</p>';
}

$params = array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
