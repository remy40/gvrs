<?php
/**
 * GV agenda plugin
 *
 */
elgg_register_event_handler('init', 'system', 'gvagenda_init');

/**
 * Initialize the GV agenda plugin.
 */
function gvagenda_init() {
  
    // override library
//	elgg_register_library('elgg:event_calendar', elgg_get_plugins_path() . 'gvagenda/models/model.php');

    // override actions
//	$action_path = elgg_get_plugins_path() . 'gvagenda/actions';
//	elgg_register_action("event_calendar/edit","$action_path/edit.php");

    // override some entity menu items
//	elgg_register_plugin_hook_handler('register', 'menu:entity', 'gvagenda_entity_menu_setup');

    // extend css
    elgg_extend_view('css/elgg', 'gvagenda/css');

/*
    $events = elgg_get_entities(array('type' => 'object', 'subtype' => 'event_calendar', 'limit' => null));
    foreach($events as $event) {
        $event->delete();
    }
*/
}

/**
 * 
 */
function gvagenda_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'event_calendar') {
		return $return;
	}

    // if it is a repeat event, use the parent link to modify it
    if ($entity->repeat_event) {
        $items = array();
        foreach($return as $item) {
            if ($item->getName() == 'edit') {
                $parent = $entity->getEntitiesFromRelationship('child_event');
                
                if ($parent) {
                    $item->setHref('event_calendar/edit/' . $parent[0]->guid);
                }
            }
            
            $items[] = $item;
        }
    }    
}
