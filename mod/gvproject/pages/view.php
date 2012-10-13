<?php
/**
 * View a single project
 */

$project_guid = get_input('guid');
$project = get_entity($project_guid);
if (!$project) {
	register_error(elgg_echo('noaccess'));
	forward();
}

elgg_set_page_owner_guid($project->getContainerGUID());

group_gatekeeper();

$container = elgg_get_page_owner_entity();
$title = $project->title;

if ($container instanceof ElggGroup) {
	elgg_push_breadcrumb(elgg_echo("gvgroups:".$container->grouptype."groups"), "groups/".$container->grouptype);
	elgg_push_breadcrumb($container->name, "projects/group/".$container->guid."/all");
}
else {
	elgg_push_breadcrumb(elgg_echo("menu:home"), "dashboard");
	elgg_push_breadcrumb($container->name, "projects/owner/".$container->guid."/all");
}
elgg_push_breadcrumb($title);

$content = elgg_view_entity($project, array('full_view' => true));
$content .= elgg_view_comments($project);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => '',
));

echo elgg_view_page($title, $body);
