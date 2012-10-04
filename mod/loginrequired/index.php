<?php
/**
 * Elgg index page for web-based applications
 *
 * @package Elgg
 * @subpackage Core
 */

if (elgg_is_logged_in()) {
	forward('dashboard');
}
else {
    $body = elgg_view_layout('one_page_login');
    // use our own page shell
    echo elgg_view_page('', $body, 'one_page_login');
}
