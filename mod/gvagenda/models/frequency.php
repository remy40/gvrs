<?php

/**
 * get frequency options for the dropdown form item
 */
function gvagenda_get_frequency_options() {
    return array('eachday' => elgg_echo('gvagenda:eachday'),
              'eachweek' => elgg_echo('gvagenda:eachweek'),
              'eachtwoweeks' => elgg_echo('gvagenda:eachtwoweeks'),
              'eachthreeweeks' => elgg_echo('gvagenda:eachthreeweeks'),
              'eachmonth' => elgg_echo('gvagenda:eachmonth'),
              'eachtwomonths' => elgg_echo('gvagenda:eachtwomonths'),
              'eachthreemonths' => elgg_echo('gvagenda:eachthreemonths'),
              'eachfourmonths' => elgg_echo('gvagenda:eachfourmonths'),
              'eachsixmonths' => elgg_echo('gvagenda:eachsixmonths'),
              'eachyear' => elgg_echo('gvagenda:eachyear'));
}

/**
 * compute the date interval according to the selected frequency
 */
function gvagenda_get_dateinterval($frequency) {
    $dateinterval = false;
        
    switch ($frequency) {
      case 'eachday':
        $dateinterval = new DateInterval("P1D");
        break;
      case 'eachweek':
        $dateinterval = new DateInterval("P1W");
        break;
      case 'eachtwoweeks':
        $dateinterval = new DateInterval("P2W");
        break;
      case 'eachthreeweeks':
        $dateinterval = new DateInterval("P3W");
        break;
      case 'eachmonth':
        $dateinterval = new DateInterval("P1M");
        break;
      case 'eachtwomonths':
        $dateinterval = new DateInterval("P2M");
        break;
      case 'eachthreemonths':
        $dateinterval = new DateInterval("P3M");
        break;
      case 'eachfourmonths':
        $dateinterval = new DateInterval("P4M");
        break;
      case 'eachsixmonths':
        $dateinterval = new DateInterval("P6M");
        break;
      case 'eachyear':
        $dateinterval = new DateInterval("P1Y");
        break;
    }

    return $dateinterval;
}
