<?php
?>
<p class="mtm">
<?php 
echo elgg_echo('gvgroups:opengroups');
echo "</p>";
if (elgg_is_logged_in()) {
echo "<p>";
	echo ' ' . elgg_echo('gvgroups:opengroups:request');
echo "</p>";
}
?>
