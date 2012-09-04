<?php
    elgg_load_library('elgg:groups');
    update_old_groups();
    system_message(elgg_echo('gvgroups:update_old_groups:ok'));
    forward(REFERER);
