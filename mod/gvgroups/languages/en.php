<?php
/**
 * Elgg groups plugin language pack
 *
 * @package ElggGroups
 */

$english = array(
    'gvgroups:workinggroups' => 'Working groups',
    'gvgroups:localgroups' => 'Local groups',
    'gvgroups:mygroups' => 'My groups',
    'gvgroups:isegoria' => 'Isegoria',

    /**
     * Profile fields 
     */
    'gvgroups:mycountry' => 'My country :',
    'gvgroups:myregion' => 'My region :',
    'gvgroups:mydepartement' => 'My department :',
    
    /**
     * Plugin settings
     */
    'gvgroups:localgroups:settings' => 'Local groups :',
    'gvgroups:localgroups:createall' => 'Create all groups',
    'gvgroups:localgroups:deleteall' => 'Delete all groups',

	/**
	 * Local & Working
	 */
    'localgroups' => "Local groups",
    'localgroups:add' => "Add a new local group",
    'localgroups:edit' => "Edit the local group",
    'localgroups:all' => "Local groups",
    'localgroups:regionname' => "Region:",
    'localgroups:regional' => "Regional",
    'localgroups:departemental' => "Departemental",
    'localgroups:town' => "Town",
    'localgroups:nationalgroups' => "National groups",
    'localgroups:regionalgroups' => "Regional groups",
    'localgroups:departementalgroups' => "Departemental groups",
    'localgroups:towngroups' => "Town groups",
    'localgroups:addtown' => "Add a new town group",

    'workinggroups' => "Working groups",
    'workinggroups:add' => "Add a new working group",
    'workinggroups:edit' => "Edit the working group",
    'workinggroups:all' => "Working groups",
    'freegroups:mine' => "My free groups",

    // override groups strings
    'groups:search' => "Search a group :",
    'groups:alphabetical' => "Alphabetical",
	'groups:icon' => 'Group icon',
    'groups:search:title' => "Search results : '%s'",
);

add_translation("en", $english);
