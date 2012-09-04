<?php
    $form_body = "<div>";
    $form_body .= "<p>" . elgg_echo('gvgroups:createlocal:explanation') . "</p>";
    $form_body .= elgg_view('input/submit', array('value' => elgg_echo('gvgroups:localgroups:createall')));
    $form_body .= "</div>";

    echo $form_body;
