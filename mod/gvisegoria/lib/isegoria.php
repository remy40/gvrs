<?php

// setup default widgets for user dashboard
function isegoria_add_default_widget($user_guid) {
    isegoria_add_widget($user_guid, "latestPolls", "dashboard", 2);
    isegoria_add_widget($user_guid, "pages", "dashboard", 2);
    $widget = isegoria_add_widget($user_guid, "river_widget", "dashboard", 2);

    if ($widget) {
        $widget->num_display = 5;
    }
/*
    $widget = isegoria_add_widget($user_guid, "group_activity", "dashboard", 1);
    
    if ($widget) {
        $ŵidget->group_guid = 70;
        $widget->num_display = 5;
    }
*/    
    isegoria_add_widget($user_guid, "event_calendar", "dashboard", 1);
}

// add a default widget to the user dashboard
function isegoria_add_widget($owner_guid, $handler, $context, $column) {
    $guid = elgg_create_widget($owner_guid, $handler, $context);
    $widget = false;
    if ($guid) {
        $widget = get_entity($guid);
        $widget->move($column, 0);
    }
    
    return $widget;
}
