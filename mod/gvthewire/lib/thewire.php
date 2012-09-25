<?php
/**
 * The wire functions
 *
 */

/**
 * extract only sitewide microblog posts (those one that have not container_guid which is a group)
 */
function elgg_get_sitewide_thewire($options) {
	$db_prefix = elgg_get_config('dbprefix');

    $query = "SELECT DISTINCT e.* FROM {$db_prefix}entities e, {$db_prefix}entities e2, {$db_prefix}entity_subtypes sub ";
    $query .= "WHERE e.type = 'object' AND e.subtype = sub.id AND sub.subtype = 'thewire' AND e.container_guid = e2.guid AND e2.type != 'group' ";

   	if ($options['reverse_order_by']) {
		$options['order_by'] = elgg_sql_reverse_order_by_clause($options['order_by']);
	}

	if (!$options['count']) {
		if ($options['order_by'] = sanitise_string($options['order_by'])) {
			$query .= " ORDER BY {$options['order_by']}";
		}
    }

    if ($options['limit']) {
        $limit = sanitise_int($options['limit'], false);
        $offset = sanitise_int($options['offset'], false);
        $query .= " LIMIT $offset, $limit";
    }
    
    $dt = get_data($query, entity_row_to_elggstar);
    return $dt;
}
