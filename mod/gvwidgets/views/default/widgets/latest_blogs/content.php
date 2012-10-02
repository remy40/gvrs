<?php
    $limit = $vars['entity']->num_display;
        
    //if no number has been set, default to 5
    if(!$limit) $limit = 5;

    $options = array(
        'type' => 'object',
        'subtype'=>'blog',
        'limit' => $limit,
        'full_view' => FALSE,
        'pagination' => FALSE,
    );
        
    $content = elgg_list_entities($options);

    echo $content;

    if ($content) {
        $more_link = elgg_view('output/url', array(
            'href' => "blog/all",
            'text' => elgg_echo('blog:moreblogs'),
            'is_trusted' => true,
        ));
        echo "<span class=\"elgg-widget-more\">$more_link</span>";
    } else {
        echo elgg_echo('blog:noblogs');
    }
