<?php
/**
 * Help language file
 */

$french = array(
	// titles
	'help:admin' => 'FAQ',
	'help:categories' => 'Catégorie d\'aide',

	// menu items and instructions
	'help:admin:instruct' => "Créer et éditer les FAQ",
	'help:back' => "Retour aux catégories",
	'help:topics' => "Sujet d'aide",

	// category titles
	'help:title:getting_started' => 'Bien commencer',
	'help:title:isegoria' => 'Isegoria',
	'help:title:groups' => 'Les groupes',
	'help:title:tools' => 'Les outils',
	'help:title:mystuff' => 'Mes informations',
	'help:title:misc' => 'Divers',

	// category blurbs
	'help:blurb:getting_started' => 'Info générales, compte',
	'help:blurb:isegoria' => 'fonctionnement de l\'espace commun',
	'help:blurb:groups' => 'fonctionnement, création, inscription',
	'help:blurb:tools' => 'blogs, sondage, chat, agenda, ...',
	'help:blurb:mystuff' => 'mes messages, mon profil, mon compte',
	'help:blurb:misc' => 'le reste',

	// form
	'help:label:category' => 'Catégorie',
	'help:label:question' => 'Question',
	'help:label:answer' => 'Réponse',

	// status messages
	'help:status:deletequestion' => 'La question a été suppprimé.',
	'help:error:nodelete' => 'Impossible de supprimer la question',
	'help:status:save' => 'La question a été sauvée',
	'help:error:nosave' => 'Impossible de sauver la question',

	// Elgg's generic name for this object type
	'item:object:help' => 'FAQ',
);

add_translation("fr", $french);
