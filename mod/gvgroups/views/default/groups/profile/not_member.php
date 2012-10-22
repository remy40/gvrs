<?php
?>
<p class="mtm">
<?php 
echo elgg_echo('gvgroups:opengroups');
echo "</p>";
if (elgg_is_logged_in()) {
echo "<p>";
	$group = $vars['entity'];
	
	if ($group->grouptype == 'local') {
		echo ' ' . elgg_echo('gvgroups:opengroups:localgroup');
	}
	else {
		echo ' ' . elgg_echo('gvgroups:opengroups:request');
	}
echo "</p>";
}
?>
