<?php

elgg_make_sticky_form('content_manager');

$filter_flag = get_input("filter", false);
$delete_flag = get_input("delete", false);

error_log("filter_flag: ".$filter_flag);
error_log("delete_flag: ".$delete_flag);

if ($filter_flag) {
	// without offset
	forward('admin/administer_utilities/content_manager');
}

if ($delete_flag) {
	$entities_guids = explode(" ", get_input('entities_guids'));

	$deleted_entities = 0;
	foreach ($entities_guids as $entity_guid) {
		$checked = get_input("entity-".$entity_guid, 0);

		if ($checked) {
			$entity = get_entity($entity_guid);
			
			if ($entity) {
				$entity->delete();
				$deleted_entities += 1;
			}
		}
	}

	if ($deleted_entities) {
		system_message(elgg_echo("content_manager:delete_entities", array($deleted_entities)));
	}
	else {
		register_error(elgg_echo("content_manager:no_deleted_entities"));
	}
}

return true;
