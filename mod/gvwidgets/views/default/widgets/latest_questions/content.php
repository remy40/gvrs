<?php
    $limit = $vars['entity']->num_display;
        
    //if no number has been set, default to 5
    if(!$limit) $limit = 5;

    $options = array(
        'type' => 'object',
        'subtype'=>'question',
        'limit' => $limit,
        'full_view' => FALSE,
        'pagination' => FALSE,
    );
        
    $content = elgg_list_entities($options);

    echo $content;

    if ($content) {
        $more_link = elgg_view('output/url', array(
            'href' => "questions/all",
            'text' => elgg_echo('questions:more'),
            'is_trusted' => true,
        ));
        echo "<span class=\"elgg-widget-more\">$more_link</span>";
    } else {
        echo elgg_echo('questions:none');
    }
