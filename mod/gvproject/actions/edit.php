<?php
/**
 * Create or edit a project
 */

// Get guids
$project_guid = (int)get_input('project_guid');
$container_guid = (int)get_input('container_guid');

$title = get_input('title');
$short_desc = get_input('short_desc');
$description = get_input('description');
$competencies = get_input('competencies');
$tags = get_input('tags');

elgg_make_sticky_form('project');

if (!$title) {
	register_error(elgg_echo('gvprojects:error:no_title'));
	forward(REFERER);
}

if ($project_guid) {
	$project = get_entity($project_guid);
	if (!$project || !$project->canEdit()) {
		register_error(elgg_echo('gvprojects:error:no_save'));
		forward(REFERER);
	}
	$new_project = false;
} else {
	$project = new ElggObject();
	$project->subtype = 'project';
	$new_project = true;
}

$project->title = $title;
$project->short_desc = $short_desc;
$project->description = $description;
$project->tags = $tags;
$project->owner_guid = $container_guid;
$project->container_guid = $container_guid;
$project->access_id = ACCESS_LOGGED_IN;
$project->competencies = $competencies;

if ($project->save()) {

	elgg_clear_sticky_form('project');

	system_message(elgg_echo('gvprojects:saved'));

	if ($new_project) {
		add_to_river('river/object/project/create', 'create', elgg_get_logged_in_user_guid(), $project->guid);
	}

	forward($project->getURL());
} else {
	register_error(elgg_echo('gvprojects:error:notsaved'));
	forward(REFERER);
}
