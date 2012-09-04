<?php
    elgg_load_library('elgg:groups');
    create_local_groups();
    system_message(elgg_echo('gvgroups:createlocal:ok'));
    forward(REFERER);
