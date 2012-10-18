<?php

$options = array('type' => 'user',
				 'limit' => NULL);
				 
$users = elgg_get_entities($options);

echo "<table class='elgg-table user-manager-table'>";
echo "<thead>";
echo "<tr>";
echo "<th class='center'>".elgg_echo("user_manager:username")."</th>";
echo "<th class='center'>".elgg_echo("user_manager:name")."</th>";
echo "<th class='center'>".elgg_echo("user_manager:isadmin")."</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

foreach($users as $user) {
	if ($user->isAdmin()){
		$isAdmin = elgg_echo("user_manager:yes");
		$classAdmin = "user-manager-is-admin";
	}
	else {
		$isAdmin = elgg_echo("user_manager:no");
		$classAdmin = "user-manager-not-admin";
	}

	echo "<tr>";
	echo "<td>".elgg_view('output/url', array('text' => $user->username, 'href' => $user->getURL()))."</td>";
	echo "<td>".$user->name."</td>";
	echo "<td class='center $classAdmin'>".$isAdmin."</td>";
	echo "</tr>";
}

echo "</tbody>";
echo "</table>";
