<?php

	$french = array(
	
		/**
		 * Menu items and titles
		 */
	
			'poll' => "Sondage",
      'polls:add' => "Nouveau sondage",
			'polls' => "Sondages",
			'polls:votes' => "votes",
			'polls:user' => "Sondage de %s",
			'polls:group_polls' => "Sondage du groupe",
			'polls:group_polls:listing:title' => "Sondage de %s",
			'polls:user:friends' => "Sondage des amis de %s",
			'polls:your' => "Vos sondages",
			'polls:not_me' => "Sondage de %s",
			'polls:posttitle' => "Sondage de %s: %s",
			'polls:friends' => "Sondage des amis",
			'polls:not_me_friends' => "Sondage des amis de %s",
			'polls:yourfriends' => "Les derniers sondages de vos amis",
			'polls:everyone' => "Tous les sondages",
			'polls:read' => "Voir un sondage",
			'polls:addpost' => "Créer un sondage",
			'polls:editpost' => "Editer un sondage: %s",
			'polls:edit' => "Editer un sondage",
			'polls:text' => "Question",
			'polls:strapline' => "%s",			
			'item:object:poll' => 'Sondages',
			'item:object:poll_choice' => "Réponses possibles",
			'polls:question' => "Question",
			'polls:responses' => "Réponses possibles",
			'polls:results' => "[+] Voir les résultats",
			'polls:show_results' => "Voir les résultats",
			'polls:show_poll' => "Voir le sondage",
			'polls:add_choice' => "Ajouter une réponse",
			'polls:delete_choice' => "Supprimer une réponse",
			'polls:settings:group:title' => "Sondages du groupe",
			'polls:settings:group_polls_default' => "oui activé par défaut",
			'polls:settings:group_polls_not_default' => "oui, désactivé par défaut",
			'polls:settings:no' => "non",
			'polls:settings:group_profile_display:title' => "Si les sondages de groupes sont activés, oú les sondage doivent être affichés dans le profil du groupe?",
			'polls:settings:group_profile_display_option:left' => "gauche",
			'polls:settings:group_profile_display_option:right' => "droite",
			'polls:settings:group_profile_display_option:none' => "aucun",
			'polls:settings:group_access:title' => "Si les sondages de groupes sont activés, qui peut créer des sondages?",
			'polls:settings:group_access:admins' => "propriétaires du groupe et administrateurs seulement",
			'polls:settings:group_access:members' => "tous les membres du groupe",
			'polls:settings:front_page:title' => "Les administrateurs peuvent ajouter un sondage en première page (le thème doit le supporter)",
			'polls:none' => "Aucun sondage trouvé.",
			'polls:permission_error' => "Vous n'avez pas les droits pour éditer ce sondage.",
			'polls:vote' => "Vote",
			'polls:login' => "Connectez-vous pour pouvoir voter pour ce sondage.",
			'group:polls:empty' => "Aucun sondage",
			'polls:settings:site_access:title' => "Qui peut créer des sondages globaux (hors groupe)?",
			'polls:settings:site_access:admins' => "Administrateurs seulement",
			'polls:settings:site_access:all' => "Tous les utilisateurs connectés",
			'polls:can_not_create' => "Vous n'avez pas les droits pou créer un sondage",
			'polls:front_page_label' => "Mettre ce sondage en première page.",
		/**
	     * poll widget
	     **/
			'polls:latest_widget_title' => "Derniers sondages",
			'polls:latest_widget_description' => "Afficher les plus récents sondages.",
			'polls:my_widget_title' => "Mes sondages",
			'polls:my_widget_description' => "Ce widget affichera vos sondages.",
			'polls:widget:label:displaynum' => "Combien de sondages souhaitez-vous afficher?",
			'polls:individual' => "Dernier sondage",
			'poll_individual_group:widget:description' => "Afficher le dernier sondage pour ce groupe.",
			'poll_individual:widget:description' => "Afficher votre dernier sondage",
			'polls:widget:no_polls' => "Il n'y aucun sondage pour %s.",
			'polls:widget:nonefound' => "Aucun sondage trouvé.",
			'polls:widget:think' => "Faire savoir à %s ce que vous pensez!",
			'polls:enable_polls' => "Activer les sondges",
			'polls:group_identifier' => "(dans %s)",
			'polls:noun_response' => "réponse",
			'polls:noun_responses' => "réponses",
	        'polls:settings:yes' => "oui",
			'polls:settings:no' => "non",
			
         /**
	     * poll river
	     **/
      'polls:settings:create_in_river:title' => "Afficher les créations de sondages dans le flux d'activité",
			'polls:settings:vote_in_river:title' => "Afficher les votes  dans le flux d'activité",
			'river:create:object:poll' => '%s a crée le sondage %s',
			'river:vote:object:poll' => '%s a voté pour le sondage %s',
			'river:comment:object:poll' => '%s a commenté le sondage %s',
		/**
		 * Status messages
		 */
	
			'polls:added' => "Votre sondage a été ajouté.",
			'polls:edited' => "Votre sondage a été enregistré.",
			'polls:responded' => "Merci d'avoir voté, votre réponse a été enregistrée.",
			'polls:deleted' => "Votre sondage a été supprimé.",
			'polls:totalvotes' => "Nombre total de votes: ",
			'polls:voted' => "Votre vote a été pris en compte pour ce sondage. Merci d'avoir voté.",
			
	
		/**
		 * Error messages
		 */
	
			'polls:save:failure' => "Votre sondage n'a pu être enregistré. Veuillez réessayer.",
			'polls:blank' => "Vous devez remplir les champs question et réponses avant d'enregistrer votre sondage.",
			'polls:novote' => "Vous devez définir au moins une réponse avant d'enregistrer votre sondage.",
			'polls:notfound' => "Désolé, nous n'avons pas trouvé ce sondage.",
			'polls:nonefound' => "Aucun sondage n'a été trouvé pour %s",
			'polls:notdeleted' => "Désolé, vous ne pouvez pas supprimer ce sondage."
	);
					
	add_translation("fr",$french);

?>
