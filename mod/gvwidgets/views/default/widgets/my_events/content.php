<?php
    $num = $entity->num_display;

	if (elgg_in_context('profile')) {
		$owner_guid = elgg_get_page_owner_guid();
	}
	else {
		$owner_guid = elgg_get_logged_in_user_guid();
	}

    $options = array(
        'type' => 'object',
        'subtype' => 'event_calendar',
		'relationship' => 'personal_event',
		'relationship_guid' => $owner_guid,
        'limit' => $num,
        'full_view' => FALSE,
        'pagination' => FALSE,
    );
    $content = elgg_list_entities($options);

    echo $content;

    if ($content) {

		if ((!elgg_in_context('profile') || (elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid())) {
			$url_more = "event_calendar/list/".date('Y-m-d')."/month/mine";
			$more_link = elgg_view('output/url', array(
				'href' => $url_more,
				'text' => elgg_echo("event_calendar:more"),
				'is_trusted' => true,
			));
			echo "<span class=\"elgg-widget-more\">$more_link</span>";
		}
    } else {
        echo elgg_echo("event_calendar:none");
    }
