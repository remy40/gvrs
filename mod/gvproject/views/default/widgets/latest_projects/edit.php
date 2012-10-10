<?php
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
