<?php
/**
 * Search for content in this group
 *
 * @uses vars['entity'] ElggGroup
 */

if ($vars['entity'] && ($vars['entity'] instanceof ElggGroup) && 
    $vars['entity']->isMember(elgg_get_logged_in_user_guid())) {
    $url = elgg_get_site_url() . 'groups/search';
    $body = elgg_view_form('groups/search', array(
        'action' => $url,
        'method' => 'get',
        'disable_security' => true,
    ), $vars);

    echo elgg_view_module('aside', elgg_echo('groups:search_in_group'), $body);
}
