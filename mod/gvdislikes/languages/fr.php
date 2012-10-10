<?php
/**
 * GVDislikes English language file
 */

$french = array(
	'gvdislikes:dislikes:this' => "n'a pas aimé ça",
	'dislikes:this' => "n'a pas aimé ça",
	'gvdislikes:dislikes:deleted' => "Votre appréciation a été retiré",
	'gvdislikes:dislikes:see' => "Voir ceux qui n'ont pas aimé ça",
	'gvdislikes:dislikes:remove' => "N'aime plus ça",
	'gvdislikes:dislikes:notdeleted' => "Il y a eu un problème, lors de la suppresion d'appréciation",
	'gvdislikes:dislikes' => "Vous n'aimez pas ça maintenant",
	'gvdislikes:dislikes:failure' => "Il y a eu un problème d'appréciation sur cet élément",
	'gvdislikes:dislikes:alreadyliked' => "Vous avez déjà porté votre appréciation sur cet élément",
	'gvdislikes:dislikes:notfound' => "L'élément que vous essayez d'apprécier ne peut être trouvé",
	'gvdislikes:dislikes:likethis' => "Aime ça",
	'gvdislikes:dislikes:userdislikedthis' => "%s n'aime pas",
	'gvdislikes:dislikes:usersdislikedthis' => "%s n'aiment pas",
	'gvdislikes:dislikes:river:annotate' => "n'aime pas",

	'river:likes' => "n'aiment pas %s %s",

	// notifications. yikes.
	'gvdislikes:dislikes:notifications:subject' => "%s n'aime pas votre message \"%s\"",
	'gvdislikes:dislikes:notifications:body' =>
"Bonjour %1$s,

%2$s n'aime pas votre message '%3$s' sur %4$s

Voir votre message original ici :

%5$s

ou voir le profil de %2$s ici :

%6$s

Merci,
%4$s
",
	
);

add_translation("fr", $french);
