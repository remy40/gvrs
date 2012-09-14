<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('groups:notfound');
	return true;
}

$group = $vars['entity'];
$owner = $group->getOwnerEntity();

?>
<div class="groups-profile clearfix elgg-image-block">
	<div class="groups-profile-fields elgg-body">
		<?php
            echo "<label>".elgg_echo("gvgroups:description").": </label>".$group->description;
//            echo "<label>".elgg_echo("groups:members").": </label>" . $group->getMembers(0, 0, TRUE);
		?>
	</div>
</div>

