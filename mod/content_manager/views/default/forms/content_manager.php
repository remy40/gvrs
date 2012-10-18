<?php

$content_subtypes_filter = get_input("content_subtypes_filter");
$content_types_filter = get_input("content_types_filter");
$offset = get_input("offset", 0);
$limit = 30;

// check input values
if (trim($content_types_filter)) {
	$content_types_filter = explode($content_types_filter);
}
else {
	$content_types_filter = array();
}

if (trim($content_subtypes_filter)) {
	$content_subtypes_filter = explode($content_subtypes_filter);
}
else {
	$content_subtypes_filter = array();
}

if (elgg_is_sticky_form('content_manager')) {
	extract(elgg_get_sticky_values('content_manager'));
	elgg_clear_sticky_form('content_manager');
}

// extract all entity types and subtypes
$registered_entities = elgg_get_config("registered_entities");

if (!empty($registered_entities)) {
	foreach ($registered_entities as $type => $ar) {
		if (count($registered_entities[$type])) {
			foreach ($registered_entities[$type] as $subtype) {
				$keyname = 'item:' . $type . ':' . $subtype;
				$subtypes_list[elgg_echo($keyname)] = "{$subtype}";
			}
		} else {
			$keyname = 'item:' . $type;
			$types_list[elgg_echo($keyname)] = "{$type}";
		}
	}
}

// if no type and subtype have been selected, select all subtypes
if (empty($content_types_filter) && empty($content_subtypes_filter)) {
	foreach($subtypes_list as $key => $subtype) {
		$content_subtypes_filter[] = $subtype;
	}
}

echo "<label>".elgg_echo("content_manager:content_types_filter")."</label>";
echo elgg_view('input/button', array('value' => elgg_echo('content_manager:toggle'), 'class' => 'elgg-button', 'id' => 'content_manager-toggle-types'));
echo "<div>";
echo elgg_view("input/checkboxes", array("name" => "content_types_filter", "value" => $content_types_filter, "options" => $types_list, "id" => "cb-content-types", "class" => "cb-content-list-type"));
echo "</div><br>";
echo "<label>".elgg_echo("content_manager:content_subtypes_filter")."</label>";
echo elgg_view('input/button', array('value' => elgg_echo('content_manager:toggle'), 'class' => 'elgg-button', 'id' => 'content_manager-toggle-subtypes'));
echo "<div>";
echo elgg_view("input/checkboxes", array("name" => "content_subtypes_filter", "value" => $content_subtypes_filter, "options" => $subtypes_list, "id" => "cb-content-subtypes", "class" => "cb-content-list-type"));
echo "</div><br>";
echo elgg_view('input/button', array('value' => elgg_echo('content_manager:toggle'), 'class' => 'elgg-button elgg-button-cancel', 'id' => 'content_manager-toggle'));
echo elgg_view("input/submit", array("name" => "filter", "value" => elgg_echo("content_manager:filtrer")));

// analyse types filter
$query_types = array();
if (!empty($content_types_filter)) {
	$query_types = $content_types_filter;
}

// analyse subtypes filter
if (!empty($content_subtypes_filter)) {
	if (!in_array('object', $query_types)) {
		$query_types[] = 'object';
	}
	
	$query_subtypes = $content_subtypes_filter;
}

// request entities only if at least there is a entity type (otherwise -> fatal error) 
if (!empty($query_types)) {
	$options = array('types' => $query_types,
					 'subtypes' => $query_subtypes,
					 'pagination' => true,
					 'full_view' => false,
					 'limit' => NULL,
					 'count' => true);
	
	$count = elgg_get_entities($options);
	
	unset($options['count']);
	$options['limit'] = $limit;
	$options['offset'] = $offset;
		
	$entities = elgg_get_entities($options);
}
else {
	$count = 0;
	$entities = array();
}

echo "</br><label>".elgg_echo("content_manager:content")."</label>";
echo "<table class='elgg-table content-manager-table'>";
echo "<thead>";
echo "<tr>";
echo "<th class='center'></th>";
echo "<th class='center'>".elgg_echo("content_manager:type")."</th>";
echo "<th class='center'>".elgg_echo("content_manager:creator")."</th>";
echo "<th class='center'>".elgg_echo("content_manager:container")."</th>";
echo "<th class='center'>".elgg_echo("content_manager:date")."</th>";
echo "<th class='center'>".elgg_echo("content_manager:title")."</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

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
	
	echo "<tr>";
	echo "<td class='center'>".elgg_view('input/checkbox', array('name' => "entity-{$entity->guid}", 'id' => 'cb-content_manager', 'class' => 'cb-content_manager-toogle'))."</td>";
	echo "<td class='center'>".$type."</td>";
	echo "<td class='center' title='$owner->name'>".$owner->username."</td>";
	echo "<td class='center' title='$container->name'>".$container_type."</td>";
	echo "<td class='center'>".date("Y-m-d", $timeCreated)."</td>";
	echo "<td>".$title."</td>";
	echo "</tr>";
}

echo "</tbody>";
echo "</table>";

echo elgg_view('navigation/pagination', 
				array('base_url' => 'admin/administer_utilities/content_manager',
					  'count' => $count,
					  'limit' => $limit,
					  'offset' => $offset,
					  'offset_key' => 'offset'));
				
echo elgg_view('input/hidden', array('name' => 'entities_guids', 'value' => $entities_guids));
echo elgg_view('input/submit', array('name' => 'delete', 'value' => elgg_echo('content_manager:delete')));
