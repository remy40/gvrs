<?php
/**
 * Remove a project
 */

$guid = get_input('guid');
$project = get_entity($guid);
if (elgg_instanceof($project, 'object', 'project')) {
	// only allow owners and admin to delete
	if (elgg_is_admin_logged_in() || elgg_get_logged_in_user_guid() == $project->getOwnerGuid()) {
		
		if ($project->delete()) {
			system_message(elgg_echo('gvprojects:delete:success'));
				forward("projects/group/$container->guid/all");
		}
	}
}

register_error(elgg_echo('gvprojects:delete:failure'));
forward(REFERER);
