<?php

$subtype_content_filter = get_input("subtype_content_filter");
$type_content_filter = get_input("type_content_filter");
$offset = get_input("offset", 0);
$limit = 50;

$registered_entities = elgg_get_config("registered_entities");

if (!empty($registered_entities)) {
	foreach ($registered_entities as $type => $ar) {
		if($type == "user"){
			continue;
		} else {
			if (count($registered_entities[$type])) {
				foreach ($registered_entities[$type] as $subtype) {
					$keyname = 'item:' . $type . ':' . $subtype;
					$filter_subtype_contents[elgg_echo($keyname)] = "{$subtype}";
				}
			} else {
				$keyname = 'item:' . $type;
				$filter_type_contents[elgg_echo($keyname)] = "{$type}";
			}
		}
	}
}

$form_body = "<label>".elgg_echo("content_manager:content_filter")."</label>";

$form_body .= elgg_view("input/checkboxes", array("name" => "subtype_content_filter", "value" => $subtype_content_filter, "options" => $filter_subtype_contents, "class" => "cb-content-subtype"))."</br>";
$form_body .= elgg_view("input/checkboxes", array("name" => "type_content_filter", "value" => $type_content_filter, "options" => $filter_type_contents, "class" => "cb-content-subtype"))."</br>";
$form_body .= elgg_view("input/submit", array("value" => elgg_echo("content_manager:filtrer")));
echo elgg_view("input/form", array("disable_security" => true, "action" => "/admin/administer_utilities/content_manager", "method" => "POST", "body" => $form_body));

// show content

if (!empty($type_content_filter) && empty($subtype_content_filter)) {
	$types = array();
}
else {
	$types = array('object');
}

$types = array_merge($types, $type_content_filter); 
$options = array('types' => $types,
				 'subtypes' => $subtype_content_filter,
				 'pagination' => true,
				 'full_view' => false,
				 'count' => true);

$count = elgg_get_entities($options);

unset($options['count']);
$options['limit'] = $limit;
$options['offset'] = $offset;

$entities = elgg_get_entities($options);

$form_body = "</br><label>".elgg_echo("content_manager:content")."</label>";
$form_body .= "<table class='elgg-table content-manager-table'>";
$form_body .= "<thead>";
$form_body .= "<tr>";
$form_body .= "<th class='center'>".elgg_echo("content_manager:select")."</td>";
$form_body .= "<th class='center'>".elgg_echo("content_manager:type")."</td>";
$form_body .= "<th class='center'>".elgg_echo("content_manager:creator")."</td>";
$form_body .= "<th class='center'>".elgg_echo("content_manager:container")."</td>";
$form_body .= "<th class='center'>".elgg_echo("content_manager:date")."</td>";
$form_body .= "<th class='center'>".elgg_echo("content_manager:title")."</td>";
$form_body .= "</tr>";
$form_body .= "</thead>";
$form_body .= "<tbody>";

$entities_guids = array();
foreach($entities as $entity) {
	$owner = $entity->getOwnerEntity();
	$container = $entity->getContainerEntity();
	$timeCreated = $entity->getTimeCreated();
	$entities_guids[] = $entity->guid;
	
	if ($entity->type == 'object') {
		$title = $entity->title;
		$type = get_subtype_from_id($entity->subtype);
	}
	else {
		$title = $entity->name;
		$type  = $entity->type;
	}

	if ($container instanceof ElggGroup) {
		$container_type = "Group";
	}
	else {
		$container_type = "User";
	}
	
	$form_body .= "<tr>";
	$form_body .= "<td class='center'>".elgg_view('input/checkbox', array('name' => "entity-{$entity->guid}"))."</td>";
	$form_body .= "<td class='center'>".$type."</td>";
	$form_body .= "<td class='center' title='$owner->name'>".$owner->username."</td>";
	$form_body .= "<td class='center' title='$container->name'>".$container_type."</td>";
	$form_body .= "<td class='center'>".date("Y-m-d", $timeCreated)."</td>";
	$form_body .= "<td>".$title."</td>";
	$form_body .= "</tr>";
}

$form_body .= "</tbody>";
$form_body .= "</table>";

$form_body .= elgg_view('navigation/pagination', array(
				'base_url' => 'admin/administer_utilities/content_manager',
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit,
				'offset_key' => "offset",
			));

$form_body .= elgg_view('input/hidden', array('name' => 'entities_guids', 'value' => $entities_guids));
$form_body .= elgg_view('input/hidden', array('name' => 'subtype_content_filter', 'value' => $subtype_content_filter));
$form_body .= elgg_view('input/hidden', array('name' => 'offset', 'value' => $offset));
$form_body .= elgg_view('input/submit', array('value' => elgg_echo('content_manager:delete')));

$action_link = elgg_add_action_tokens_to_url("/action/content_manager");
echo elgg_view("input/form", array("disable_security" => true, "action" => $action_link, "method" => "POST", "body" => $form_body));
