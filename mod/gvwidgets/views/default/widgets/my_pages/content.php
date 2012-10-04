<?php
    elgg_load_library("elgg:gvwidgets");

    if (elgg_is_active_plugin("etherpad") && elgg_get_plugin_setting("integrate_in_pages", "etherpad")) {
        show_my_stuff_widget($vars['entity'], array('page','page_top','etherpad','subpad'), 'pages');
    }
    else {
        show_my_stuff_widget($vars['entity'], array('page','page_top'), 'pages');
    }
