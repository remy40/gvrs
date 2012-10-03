<?php

/**
 * Show edit widget panel
 */
function show_edit_widget_panel($entity) {
    // set default value
    if (!isset($entity->num_display)) {
        $entity->num_display = 4;
    }

    $params = array(
        'name' => 'params[num_display]',
        'value' => $entity->num_display,
        'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 20),
    );
    $dropdown = elgg_view('input/dropdown', $params);

    echo "<div>";
	echo elgg_echo('widget:numbertodisplay');
	echo $dropdown;
    echo "</div>";
}

/**
 * Show "My ..." widget content
 */
function show_my_stuff_widget($entity, $type, $base_path = '', $show_more_link = true) {
    $num = $entity->num_display;

    $options = array(
        'type' => 'object',
        'owner_guid' => elgg_get_logged_in_user_guid(),
        'limit' => $num,
        'full_view' => FALSE,
        'pagination' => FALSE,
    );

    if (is_array($type)) {
        $options['subtypes'] = $type;
        $base_type = $type[0];
        
        if ($base_path == '') {
            $base_path = $base_type;
        }
    }
    else {
        $options['subtype'] = $type;
        $base_type = $type;

        if ($base_path == '') {
            $base_path = $base_type;
        }
    }

    $content = elgg_list_entities($options);

    echo $content;

    if ($content) {
        if ($show_more_link) {
            $url_more = "$base_path/owner/" . elgg_get_page_owner_entity()->username;
            $more_link = elgg_view('output/url', array(
                'href' => $url_more,
                'text' => elgg_echo("$base_type:more"),
                'is_trusted' => true,
            ));
            echo "<span class=\"elgg-widget-more\">$more_link</span>";
        }
    } else {
        echo elgg_echo("$base_type:none");
    }
}

/**
 * Show site or group widget content
 */
function show_site_stuff_widget($entity, $type, $base_path = '',$show_more_link = true) {
    $limit = $entity->num_display;
        
    //if no number has been set, default to 5
    if(!$limit) $limit = 5;

    $options = array(
        'type' => 'object',
        'limit' => $limit,
        'full_view' => FALSE,
        'pagination' => FALSE,
    );

    if (is_array($type)) {
        $options['subtypes'] = $type;
        $base_type = $type[0];
        
        if ($base_path == '') {
            $base_path = $base_type;
        }
    }
    else {
        $options['subtype'] = $type;
        $base_type = $type;

        if ($base_path == '') {
            $base_path = $base_type;
        }
    }

    if (elgg_in_context('groups')) {
        $group = elgg_get_page_owner_entity();

        if ($group && ($group instanceof ElggGroup)) {
            $options['container_guid'] = $group->guid;
        }

        $url_more = "$base_path/group/$group->guid/all";
    }
    else {
        $url_more = "$base_path/all";
    }
        
    $content = elgg_list_entities($options);

    echo $content;

    if ($content) {
        if ($show_more_link) {
            $more_link = elgg_view('output/url', array(
                'href' => $url_more,
                'text' => elgg_echo("$base_type:more"),
                'is_trusted' => true,
            ));
            echo "<span class=\"elgg-widget-more\">$more_link</span>";
        }
    } else {
        echo elgg_echo("$base_type:none");
    }
}
