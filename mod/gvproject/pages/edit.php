<?php
/**
 * Edit a project
 */

group_gatekeeper();

$project_guid = (int)get_input('guid');
$project = get_entity($project_guid);

if (!$project) {
	register_error(elgg_echo('noaccess'));
	forward('');
}

$container = $project->getContainerEntity();
if (!$container) {
	register_error(elgg_echo('noaccess'));
	forward('');
}

elgg_set_page_owner_guid($container->getGUID());

$owner = elgg_get_page_owner_entity();
if ($owner instanceof ElggGroup) {
	elgg_push_breadcrumb(elgg_echo("gvgroups:".$owner->grouptype."groups"), "groups/".$owner->grouptype);
	elgg_push_breadcrumb($owner->name, "projects/group/".$owner->guid."/all");
}
else {
	elgg_push_breadcrumb(elgg_echo("menu:home"), "dashboard");
	elgg_push_breadcrumb($owner->name, "projects/owner/".$owner->guid."/all");
}
elgg_push_breadcrumb($project->title, $project->getURL());
elgg_push_breadcrumb(elgg_echo('edit'));

$title = elgg_echo("gvprojects:edit");

if ($project->canEdit()) {
    $vars['entity'] = $project;
    $vars['container_guid'] = $container->guid;
	$content = elgg_view_form('projects/edit', array(), $vars);
} else {
	$content = elgg_echo("gvprojects:noaccess");
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
