<?php
/**
 * Online users widget
 */

$num = (int) $vars['entity']->num_display;

$count = find_active_users(600, $num, 0, true);
$objects = find_active_users(600, $num);

if ($objects) {
    echo elgg_view_entity_list($objects, array(
        'count' => $count,
        'limit' => $num
    ));
}
