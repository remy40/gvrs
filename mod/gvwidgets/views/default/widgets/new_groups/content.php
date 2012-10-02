<?php
    $limit = $vars['entity']->num_display;
        
    //if no number has been set, default to 5
    if(!$limit) $limit = 5;

    $options = array(
        'type' => 'group',
        'limit' => $limit,
        'full_view' => FALSE,
        'pagination' => FALSE,
        'metadata_name' => 'grouptype',
        'metadata_value'=> 'working',
    );
        
    $content = elgg_list_entities_from_metadata($options);

    echo $content;

    if ($content) {
        $more_link = elgg_view('output/url', array(
            'href' => "groups/working",
            'text' => elgg_echo('groups:more'),
            'is_trusted' => true,
        ));
        echo "<span class=\"elgg-widget-more\">$more_link</span>";
    } else {
        echo elgg_echo('groups:none');
    }
