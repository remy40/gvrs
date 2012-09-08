<?php

/**
 * Get the departement number from the postal code
 * @return a string that contains the departement number
 */
function get_departement_number_from_postal_code($postalcode) {
    $depnum = sprintf("%1$02d", (int)($postalcode / 1000));
    
    // manage specific cases (Corse and oversea departements)
    if ($depnum == "20") {
        if ($postalcode < 20200) {
            $depnum = "2A";
        }
        else {
            $depnum = "2B";
        }
    }
    else if ($depnum == "97") {
        $depnum = sprintf("%1$03d", (int)($postalcode / 100));
    }

    return $depnum;
}

/**
 * Get the region group name from the postal code
 * @return a string that contains the region group name
 */
function get_regional_group_name_from_postalcode($postalcode) {
    $regions = get_region_data();
    $depnum = get_departement_number_from_postal_code($postalcode);
    
    foreach ($regions as $regionname => $region_deplist) {
        if (in_array($depnum, $region_deplist)) {
            return $regionname;
        }
    }

    return false;
}

/**
 * Get the departement group name from the postal code
 * @return a string that contains the departement group name
 */
function get_departemental_group_name_from_postalcode($postalcode) {
    $departements = get_departement_data();
    $depnum = get_departement_number_from_postal_code($postalcode);
    
    return ("$depnum - ".$departements[$depnum]);
}

/**
 * return the list of countries available on the social network
 */
function get_country_data() {
    return array(
        'Belgique', 
        'France', 
        'Canada', 
        'Suisse',
        );
}
        
/**
 * return the list of departement available on the social network
 */
function get_departement_data() {
    return array(
                '01' => 'Ain',
                '02' => 'Aisne',
                '03' =>'Allier',
                '04' =>'Alpes de Hautes-Provence',
                '05' =>'Hautes-Alpes',
                '06' =>'Alpes-Maritimes',
                '07' =>'Ardèche',
                '08' =>'Ardennes',
                '09' =>'Ariège',
                '10' =>'Aube',
                '11' =>'Aude',
                '12' =>'Aveyron',
                '13' =>'Bouches-du-Rhône',
                '14' =>'Calvados',
                '15' =>'Cantal',
                '16' =>'Charente',
                '17' =>'Charente-Maritime',
                '18' =>'Cher',
                '19' =>'Corrèze',
                '2A' =>'Corse-du-Sud',
                '2B' =>'Haute-Corse',
                '21' =>'Côte-d\'Or',
                '22' =>'Côtes d\'Armor',
                '23' =>'Creuse',
                '24' =>'Dordogne',
                '25' =>'Doubs',
                '26' =>'Drôme',
                '27' =>'Eure',
                '28' =>'Eure-et-Loir',
                '29' =>'Finistère',
                '30' =>'Gard',
                '31' =>'Haute-Garonne',
                '32' =>'Gers',
                '33' =>'Gironde',
                '34' =>'Hérault',
                '35' =>'Ille-et-Vilaine',
                '36' =>'Indre',
                '37' =>'Indre-et-Loire',
                '38' =>'Isère',
                '39' =>'Jura',
                '40' =>'Landes',
                '41' =>'Loir-et-Cher',
                '42' =>'Loire',
                '43' =>'Haute-Loire',
                '44' =>'Loire-Atlantique',
                '45' =>'Loiret',
                '46' =>'Lot',
                '47' =>'Lot-et-Garonne',
                '48' =>'Lozère',
                '49' =>'Maine-et-Loire',
                '50' =>'Manche',
                '51' =>'Marne',
                '52' =>'Haute-Marne',
                '53' =>'Mayenne',
                '54' =>'Meurthe-et-Moselle',
                '55' =>'Meuse',
                '56' =>'Morbihan',
                '57' =>'Moselle',
                '58' =>'Nièvre',
                '59' =>'Nord',
                '60' =>'Oise',
                '61' =>'Orne',
                '62' =>'Pas-de-Calais',
                '63' =>'Puy-de-Dôme',
                '64' =>'Pyrénées-Atlantiques',
                '65' =>'Hautes-Pyrénées',
                '66' =>'Pyrénées-Orientales',
                '67' =>'Bas-Rhin',
                '68' =>'Haut-Rhin',
                '69' =>'Rhône',
                '70' =>'Haute-Saône',
                '71' =>'Saône-et-Loire',
                '72' =>'Sarthe',
                '73' =>'Savoie',
                '74' =>'Haute-Savoie',
                '75' =>'Paris',
                '76' =>'Seine-Maritime',
                '77' =>'Seine-et-Marne',
                '78' =>'Yvelines',
                '79' =>'Deux-Sèvres',
                '80' =>'Somme',
                '81' =>'Tarn',
                '82' =>'Tarn-et-Garonne',
                '83' =>'Var',
                '84' =>'Vaucluse',
                '85' =>'Vendée',
                '86' =>'Vienne',
                '87' =>'Haute-Vienne',
                '88' =>'Vosges',
                '89' =>'Yonne',
                '90' =>'Territoire-de-Belfort',
                '91' =>'Essonne',
                '92' =>'Hauts-de-Seine',
                '93' =>'Seine-Saint-Denis',
                '94' =>'Val-de-Marne',
                '95' =>'Val-d\'Oise',
                '971' =>'Guadeloupe',
                '972' =>'Martinique',
                '973' =>'Guyane',
                '974' =>'La Réunion',
                '976' =>'Mayotte');
}

/**
 * return the list of region available on the social network. Each region has a list of its departements.
 */
function get_region_data() {
    return array(
            'Alsace' => array ('67', '68'),
            'Aquitaine' => array ('40', '33', '64', '47', '24'),
            'Auvergne' => array ('03', '15', '43', '63'),
            'Bourgogne' => array ('21', '58', '71', '89'),
            'Bretagne' => array ('22', '29', '35', '56'),
            'Centre' => array ('18', '28', '36', '37', '41', '45'),
            'Champagne-Ardenne' => array ('08', '10', '51', '52'),
            'Corse' => array ('2A', '2B'),
            'Franche-Comté' => array ('25', '39', '70', '90'),
            'Guadeloupe' => array ('971'),
            'Guyane' => array ('973'),
            'Ile-de-France' => array ('75', '91', '92', '93', '77', '94', '95', '78'),
            'Languedoc-Roussillon' => array ('11', '30', '34', '48', '66'),
            'Limousin' => array ('19', '23', '87'),
            'Lorraine' => array ('54', '55', '57', '88'),
            'Martinique' => array ('972'),
            'Mayotte' => array ('976'),
            'Midi-Pyrénées' => array ('09', '12', '31', '32', '46', '65', '81', '82'),
            'Nord-Pas-de-Calais' => array ('59', '62'),
            'Basse-Normandie' => array ('14', '50', '61'),
            'Haute-Normandie' => array ('27', '76'),
            'Pays de la Loire' => array ('44', '49', '53', '72', '85'),
            'Picardie' => array ('02', '60', '80'),
            'Poitou-Charentes' => array ('16', '17', '79', '86'),
            'Provence-Alpes-Côte-d\'Azur' => array ('04', '05', '06', '13', '83', '84'),
            'La Réunion' => array ('974'),
            'Rhône-Alpes' => array ('01', '07', '26', '38', '42', '69', '73', '74'),
            );
    }
