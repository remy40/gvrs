<?php
/**
 * All groups listing page navigation
 *
 * @uses $vars['selected'] Name of the tab that has been selected
 */

if (isset($vars['grouptype']) && ($vars['grouptype'] == 'local')) {
    $tabs = array(
        'national' => array(
            'text' => elgg_echo('localgroups:national'),
            'href' => 'groups/local?filter=national',
            'priority' => 100,
        ),
        'regional' => array(
            'text' => elgg_echo('localgroups:regional'),
            'href' => 'groups/local?filter=regional',
            'priority' => 200,
        ),
        'departemental' => array(
            'text' => elgg_echo('localgroups:departemental'),
            'href' => 'groups/local?filter=departemental',
            'priority' => 300,
        ),
        'town' => array(
            'text' => elgg_echo('localgroups:town'),
            'href' => 'groups/local?filter=town',
            'priority' => 400,
        ),
    );
}
else {
    if (isset($vars['grouptype']) && ($vars['grouptype'] != 'default')) {
        $handler = 'groups/'.$vars['grouptype'];
    }
    else {
        $handler = 'groups/all';
    }
    
    $tabs = array(
        'newest' => array(
            'text' => elgg_echo('groups:newest'),
            'href' => $handler.'?filter=newest',
            'priority' => 200,
        ),
        'popular' => array(
            'text' => elgg_echo('groups:popular'),
            'href' => $handler.'?filter=popular',
            'priority' => 300,
        ),
        'alphabetical' => array(
            'text' => elgg_echo('groups:alphabetical'),
            'href' => $handler.'?filter=alphabetical',
            'priority' => 400,
        ),
    );
}

foreach ($tabs as $name => $tab) {
	$tab['name'] = $name;

	if ($vars['selected'] == $name) {
		$tab['selected'] = true;
	}

	elgg_register_menu_item('filter', $tab);
}

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
