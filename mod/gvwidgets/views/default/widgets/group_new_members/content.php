<?php

    $limit = $entity->num_display;
        
    //if no number has been set, default to 5
    if(!$limit) $limit = 5;

    if (elgg_in_context('groups')) {
        $group = elgg_get_page_owner_entity();

        if ($group && ($group instanceof ElggGroup)) {
            $content = elgg_list_entities_from_relationship(array(
                'relationship' => 'member',
                'relationship_guid' => $group->guid,
                'inverse_relationship' => true,
                'types' => 'user',
                'full_view' => FALSE,
                'pagination' => FALSE,
                'limit' => $limit,
            ));

            echo $content;
            
            if ($content) {
                $more_link = elgg_view('output/url', array(
                    'href' => "groups/members/".$group->guid,
                    'text' => elgg_echo("groups:members:more"),
                    'is_trusted' => true,
                ));
                echo "<span class=\"elgg-widget-more\">$more_link</span>";
            } else {
                echo elgg_echo("groups:members:none");
            }
        }
    }

