<?php
/**
 * Elgg groups plugin language pack
 *
 * @package ElggGroups
 */

$french = array(
    'gvgroups:workinggroups' => 'Groupes de travail',
    'gvgroups:localgroups' => 'Groupes locaux',
    'gvgroups:mygroups' => 'Mes groupes',
    'gvgroups:isegoria' => 'Isegoria',

    'gvgroups:opengroups' => 'Ce groupe est ouvert mais vous n\'êtes pas membre. Vous pouvez poser une question aux membres du groupe en cliquant sur "Questions du groupe".',
	'gvgroups:opengroups:localgroup' => "Ce groupe est un groupe local et vous ne pouvez pas directement rejoindre un groupe local. Pour vous inscrire, vous devez remplir votre code postal dans votre profil et vous serez automatiquement inscrit dans les groupes locaux correspondants.",
    'gvgroups:opengroups:request' => 'Vous pouvez aussi rejoindre le groupe en cliquant sur "Rejoindre le groupe".',

    'groups:grouptype' => 'Type de groupe :',
    'groups:grouptype:local' => 'groupe local',
    'groups:grouptype:working' => 'groupe de travail',
    'groups:grouptype:default' => 'groupe libre',
    
    'gvgroups:towngroups:error_subscribe' => "Pour vous inscrire au groupe %s vous devez être membre du groupe départemental %s.",
    
    'gvgroups:localgroups:unsubscribe' => "vous avez été désinscrit du groupe %s",
    'gvgroups:localgroups:error_unsubscribe' => "impossible de vous désinscrire du groupe %s",
    'gvgroups:localgroups:subscribe' => "vous avez été inscrit au groupe %s",
    'gvgroups:localgroups:error_subscribe' => "impossible de vous inscrire au groupe %s",
    
    /**
     * Settings
     */
    'admin:groups' => 'GV groupe',
    'admin:groups:update_old_groups' => 'Mise à jour des anciens groupes',
    'gvgroups:update_old_groups:explanation' => 'Mettre à jour les anciens groupes pour prendre en compte la nouvelle classification',
    'gvgroups:update_old_groups' => 'Mettre à jour',
    'gvgroups:settings:nolimit' => 'Illimité',
    'gvgroups:settings:local_limit_title' => 'limite d\'inscription aux groupes locaux',
    'gvgroups:settings:national_limit' => 'limite pour les groupes nationaux : ',
    'gvgroups:settings:regional_limit' => 'limite pour les groupes régionaux : ',
    'gvgroups:settings:departemental_limit' => 'limite pour les groupes départementaux : ',
    'gvgroups:settings:town_limit' => 'limite pour les groupes villes : ',
    
    /**
     * Admin
     */
    'admin:groups:createlocal' => 'Création des groupes locaux',
    'admin:groups:deletelocal' => 'Suppression des groupes locaux',
    'gvgroups:createlocal:explanation' => 'Cette commande permet de créer l\'ensemble des groupes locaux. A n\'utiliser qu\'une seule fois, après l\'activation du plugin',
    'gvgroups:deletelocal:explanation' => 'Cette commande permet de supprimer l\'ensemble des groupes locaux. A n\'utiliser que pendant la mise au point du plugin !',
    'gvgroups:localgroups:settings' => 'Groupes locaux :',
    'gvgroups:localgroups:createall' => 'Créer tous les groupes',
    'gvgroups:localgroups:deleteall' => 'Supprimer tous les groupes',
    'gvgroups:deletelocal:ok' => 'Tous les groupes locaux ont été supprimés',
    'gvgroups:createlocal:ok' => 'Tous les groupes locaux ont été créés',
    'admin:groups:createfields' => 'Extension du profil utlisateur',
    'gvgroups:createfields:explanation' => 'Cette commande permet de créer les nouveaux champs du profil utilisateur relatif aux groupes locaux (pays, région, département)',
    'gvgroups:createfields' => 'Créer les champs',
    'gvgroups:createfields:ok' => 'Création des nouveaux champs effectuée',
    
    /**
     * Profile fields 
     */
    'gvgroups:mycountry' => 'Mon pays :',
    'gvgroups:myregion' => 'Ma région :',
    'gvgroups:mydepartement' => 'Mon département :',
    'gvgroups:description' => "Description du groupe",
	/**
	 * Local & Working
	 */
    'localgroups' => "Groupes locaux",
    'localgroups:add' => "Ajouter un nouveau groupe local",
    'localgroups:edit' => "Modifier le groupe local",
    'localgroups:all' => "Groupes locaux",
    'localgroups:regionname' => "Région:",
    'localgroups:national' => "Nationaux",
    'localgroups:regional' => "Régionaux",
    'localgroups:departemental' => "Départementaux",
    'localgroups:town' => "Villes",
    'localgroups:mine' => "Mes groupes locaux",
    'localgroups:nationalgroups' => "Groupes nationaux",
    'localgroups:regionalgroups' => "Groupes régionaux",
    'localgroups:departementalgroups' => "Groupes départementaux",
    'localgroups:towngroups' => "Groupes villes",
    'localgroups:addtown' => "Ajouter un groupe ville",
    'workinggroups' => "Groupes de travail",
    'workinggroups:add' => "Ajouter un nouveau groupe de travail",
    'workinggroups:edit' => "Modifier le groupe de travail",
    'workinggroups:all' => "Groupes de travail",
    'workinggroups:mine' => "Mes groupes de travail",
    'groups:alphabetical' => "Alphabétique",
    'freegroups:mine' => "Mes groupes libres",

    // override groups strings
    'groups:search' => "Chercher un groupe :",
	'groups:icon' => 'Icone du groupe',
    'groups:search:title' => "Résultats de la recherche : '%s'",
);

add_translation("fr", $french);
