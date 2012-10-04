<?php
/**
 * Group edit form
 * 
 * @package ElggGroups
 */

$user = elgg_get_logged_in_user_entity();

// new groups default to open membership
if (isset($vars['entity'])) {
	$membership = $vars['entity']->membership;
	$access = $vars['entity']->access_id;
	if ($access != ACCESS_PUBLIC && $access != ACCESS_LOGGED_IN) {
		// group only - this is done to handle access not created when group is created
		$access = ACCESS_PRIVATE;
	}
} else {
	$membership = ACCESS_PUBLIC;
	$access = ACCESS_PUBLIC;
}
?>
<div>
	<label><?php echo elgg_echo("groups:name"); ?></label><br />
	<?php echo elgg_view("input/text", array(
		'name' => 'name',
		'value' => $vars['entity']->name,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo("groups:icon"); ?></label>
	<?php echo elgg_view("input/file", array('name' => 'icon')); ?>
</div>
<?php

$group_profile_fields = elgg_get_config('group');
if ($group_profile_fields > 0) {
    foreach ($group_profile_fields as $shortname => $valtype) {
        $line_break = '<br />';
        if ($valtype == 'longtext') {
            $line_break = '';
        }
        echo '<div><label>';
        echo elgg_echo("groups:{$shortname}");
        echo "</label>$line_break";
        echo elgg_view("input/{$valtype}", array(
            'name' => $shortname,
            'value' => $vars['entity']->$shortname,
        ));
        echo '</div>';
    }
}

// admins are able to modify grouptype in case of group editing (not adding)
if (isset($vars['entity']) && $user->isAdmin()) {
    $grouptype = $vars['entity']->grouptype;
?>
<div>
    <label>
		<?php echo elgg_echo('groups:grouptype'); ?>
		<?php echo elgg_view('input/access', array(
			'name' => 'grouptype_set_by_admin',
			'value' => $grouptype,
			'options_values' => array(
				'local' => elgg_echo('groups:grouptype:local'),
				'working' => elgg_echo('groups:grouptype:working'),
                'default' => elgg_echo('groups:grouptype:default'))));
		?>
	</label>
</div>
    
<?php
}

if ($vars['group_type'] != 'local') {
?>
<div>
	<label>
		<?php echo elgg_echo('groups:membership'); ?>
		<?php echo elgg_view('input/access', array(
			'name' => 'membership',
			'value' => $membership,
			'options_values' => array(
				ACCESS_PRIVATE => elgg_echo('groups:access:private'),
				ACCESS_PUBLIC => elgg_echo('groups:access:public')
			)
		));
		?>
	</label>
</div>
<?php
}

if (elgg_get_plugin_setting('hidden_groups', 'groups') == 'yes') {
	$this_owner = $vars['entity']->owner_guid;
	if (!$this_owner) {
		$this_owner = elgg_get_logged_in_user_guid();
	}
	$access_options = array(
		ACCESS_PRIVATE => elgg_echo('groups:access:group'),
		ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
		ACCESS_PUBLIC => elgg_echo("PUBLIC")
	);
?>

<div>
	<label>
			<?php echo elgg_echo('groups:visibility'); ?>
			<?php echo elgg_view('input/access', array(
				'name' => 'vis',
				'value' =>  $access,
				'options_values' => $access_options,
			));
			?>
	</label>
</div>

<?php 	
}

$tools = elgg_get_config('group_tool_options');
if ($tools) {
    echo "<table class='elgg-table'>";
    echo "<tbody>";
    echo "<tr><th class='center'>".elgg_echo('tools')."</th><th class='center'>".elgg_echo('enable')."</th></tr>";
	usort($tools, create_function('$a,$b', 'return strcmp($a->label,$b->label);'));
	foreach ($tools as $group_option) {
		$group_option_toggle_name = $group_option->name . "_enable";
		if ($group_option->default_on) {
			$group_option_default_value = 'yes';
		} else {
			$group_option_default_value = 'no';
		}
		$value = $vars['entity']->$group_option_toggle_name ? $vars['entity']->$group_option_toggle_name : $group_option_default_value;
?>	
<tr>
    <td>
		<?php echo $group_option->label; ?>
	</td>
    <td class="center">
		<?php echo elgg_view("input/radio", array(
			"name" => $group_option_toggle_name,
			"value" => $value,
			'options' => array(
				elgg_echo('groups:yes') => 'yes',
				elgg_echo('groups:no') => 'no',
			),
            'align' => 'horizontal',
		));
		?>
    </td>
</tr>
<?php
	}
    echo "</tbody>";
    echo "</table>";
}
?>
<div class="elgg-foot">
<?php

if (isset($vars['entity'])) {
	echo elgg_view('input/hidden', array(
		'name' => 'group_guid',
		'value' => $vars['entity']->guid,
	));

    echo elgg_view('input/hidden', array(
        'name' => 'group_type',
        'value' => $vars['entity']->group_type,
    ));
}
else
{
    echo elgg_view('input/hidden', array(
        'name' => 'group_type',
        'value' => $vars['group_type'],
    ));

	echo elgg_view('input/hidden', array(
		'name' => 'parent_guid',
		'value' => $vars['parent_guid'],
	));
}

echo elgg_view('input/submit', array('value' => elgg_echo('save')));

if (isset($vars['entity'])) {
	$delete_url = 'action/groups/delete?guid=' . $vars['entity']->guid;
	echo elgg_view('output/confirmlink', array(
		'text' => elgg_echo('groups:delete'),
		'href' => $delete_url,
		'confirm' => elgg_echo('groups:deletewarning'),
		'class' => 'elgg-button elgg-button-delete float-alt',
	));
}
?>
</div>
