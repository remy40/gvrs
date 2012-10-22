<?php
/**
 * Layout of the groups profile page
 *
 * @uses $vars['entity']
 */

echo elgg_view('groups/profile/summary', $vars);

if (group_gatekeeper(false)) {
    if ($vars['entity']->isMember(elgg_get_logged_in_user_guid())) {
        echo elgg_view('groups/profile/widgets', $vars);
    }
    else {
        echo elgg_view('groups/profile/not_member', $vars);
    }
} else {
	echo elgg_view('groups/profile/closed_membership');
}
