<?php
    elgg_load_library('elgg:groups');
    delete_all_local_groups();
    system_message(elgg_echo('gvgroups:deletelocal:ok'));
    forward(REFERER);
