<?php
/**
 * Show list of parent and children local groups
 *
 * @uses $vars['group_guid'] Group GUID
 */

$group_guid = elgg_extract('group_guid', $vars, 0);

if ($group_guid) {
    $group = get_entity($group_guid);
    
    if ($group) {
        if ($group->localtype != 'national') {
            $parentEntities = $group->getEntitiesFromRelationship('parent');
            $title = get_entity_list_title($group->localtype, 'parent');
            show_entities_list($title, $parentEntities);
        }
        
        if ($group->localtype != 'town') {
            $childEntities  = $group->getEntitiesFromRelationship('child');
            $title = get_entity_list_title($group->localtype, 'child');
            show_entities_list($title, $childEntities);
        }
    }
}

function show_entities_list($title, $entities) {

    $body = '';

    if ($entities) {
        foreach ($entities as $entity) {
            $body .= "<a href='" . $entity->getURL() . "'>" . $entity->name . "</a><br>";
        }
    }
    else {
        $body .= "aucun.<br>";
    }
    
    echo elgg_view_module('aside', $title, $body);

}

function get_entity_list_title($localtype, $relationship) {
    
    $title = '';
    
    switch ($localtype) {
        case 'national':
            $title = elgg_echo('localgroups:regionalgroups');
            break;
        case 'regional':
            if ($relationship == 'parent') {
                $title = elgg_echo('localgroups:nationalgroups');
            }
            else {
                $title = elgg_echo('localgroups:departementalgroups');
            }
            break;
        case 'departemental':
            if ($relationship == 'parent') {
                $title = elgg_echo('localgroups:regionalgroups');
            }
            else {
                $title = elgg_echo('localgroups:towngroups');
            }
            break;
        case 'town':
            $title = elgg_echo('localgroups:departementalgroups');
            break;
    }
    
    return $title;
}
