<?php
/**
 * Initialize the TinyMCE script
 */

elgg_load_js('extended_tinymce');

switch ($vars['style']) {
    case 'full':
        elgg_load_js('elgg.extended_tinymce_full');
        break;
    default:
        elgg_load_js('elgg.extended_tinymce_simple');
}
