<?php
/**
 * User's wire posts
 * 
 */

$container_guid = get_input('container_guid');
$container = get_entity($container_guid);

if ($container_guid && $container && ($container instanceOf ElggGroup)) {
    $title = elgg_echo('thewire:group', array($container->name));

	elgg_push_breadcrumb(elgg_echo("gvgroups:".$container->grouptype."groups"), "groups/".$container->grouptype);
    elgg_push_breadcrumb($container->name, "thewire/group/".$container->guid);

    $form_vars = array('class' => 'thewire-form');
    $body_vars = array('container_guid' => $container_guid);

    if ($container->isMember(elgg_get_logged_in_user_guid())) {
        $content = elgg_view_form('thewire/add', $form_vars, $body_vars);
        $content .= elgg_view('input/urlshortener');

        $content .= elgg_list_entities(array(
            'type' => 'object',
            'subtype' => 'thewire',
            'container_guid' => $container_guid,
            'limit' => 15,
        ));
    }
    else {
        $content = '';
    }
    
    $body = elgg_view_layout('one_sidebar', array(
        'content' => $content,
        'title' => $title,
        'sidebar' => elgg_view('thewire/sidebar'),
    ));

    echo elgg_view_page($title, $body);
}
else {
    forward(REFERER);
}
