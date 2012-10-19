<?php

$context = get_input("context");

if ($context) {
	$owner_guid = get_input("owner_guid");
	$site_guid = elgg_get_config('site_guid');

	// get existing widgets and remove them
	$widgets = elgg_get_widgets($owner_guid, $context);

	$num_columns = count($widgets);
	for ($column_index = 1; $column_index <= $num_columns; $column_index++) {
		if (isset($widgets[$column_index])) {
			$column_widgets = $widgets[$column_index];
		} else {
			$column_widgets = array();
		}

		if (sizeof($column_widgets) > 0) {
			foreach ($column_widgets as $widget) {
				if ($widget) {
					$widget->delete();
					error_log("suppression widget !");
				}
			}
		}
	}

	// get default widgets and add them
	$widgets = elgg_get_widgets($site_guid, $context);

	$num_columns = count($widgets);
	for ($column_index = 1; $column_index <= $num_columns; $column_index++) {
		if (isset($widgets[$column_index])) {
			$column_widgets = $widgets[$column_index];
		} else {
			$column_widgets = array();
		}

		if (sizeof($column_widgets) > 0) {
			$line=0;
			foreach ($column_widgets as $widget) {
				if ($widget) {
					// change the container and owner
					$new_widget = clone $widget;
					$new_widget->container_guid = $owner_guid;
					$new_widget->owner_guid = $owner_guid;

					// pull in settings
					$settings = get_all_private_settings($widget->guid);

					foreach ($settings as $name => $value) {
						$new_widget->$name = $value;
					}

					$new_widget->move($column_index, $line);
					$new_widget->save();
					
					$line++; 
				}
			}
		}
	}
}
