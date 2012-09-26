<?php

//the number of events to display
$num = (int) $vars['entity']->num_display;
if (!$num)
    $num = 5;

$options = array(
	'type' => 'object',
	'subtype' => 'event_calendar',
	'limit' => $num,
	'full_view' => FALSE,
	'pagination' => FALSE,
);

$events = elgg_get_entities($options);
		
// If there are any events to view, view them
if (is_array($events) && sizeof($events) > 0) {

    echo "<div id=\"widget_calendar\">";

    foreach($events as $event) {
        echo elgg_view("object/event_calendar",array('entity' => $event));
    }

    echo "</div>";
        
}
