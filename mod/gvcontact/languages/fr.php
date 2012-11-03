<?php

	$french = array(
        'gvcontact:contact' => "Contact",
    
        'gvcontact:intro' => "Ce formulaire vous permet de contacter l'équipe des webmestres pour toute question. Pour que votre requête soit correctement traitée, essayer d'être le plus clair possible. Merci !",
        'gvcontact:yourmessage' => "Votre message :",
        'gvcontact:contactus' => "Envoyer",
        
        'gvcontact:bug' => "dysfonctionnement du site (bug)",
        'gvcontact:improvement' => "proposition d'amélioration",
        'gvcontact:help' => "demande d'aide",
        'gvcontact:misc' => "autre requête",

        'gvcontact:category' => "Type de requête :",
        'gvcontact:settings:admin' => "Administrateur(s) à notifier",
        'gvcontact:settings:admin:description' => "la liste des noms d'utilisateur des personnes à notifier lorsque le formulaire de contact est validé. Les noms d'utilisateurs doivent être séparés par une virgule ou un point-virgule.",
        'gvcontact:settings:category' => "Liste des catégories",
        'gvcontact:settings:category:description' => "Pour permettre à l'utilisateur de classer son message dans une des catégories. Les catégories sont traduites en utilisant l'identfiant gvcontact:nom_categorie (par exemple, pour 'bug', 'gvcontact:bug').",
        'gvcontact:settings:method' => "Méthode d'envoi de la requête",
        
        'gvcontact:category_error' => "Vous devez choisir une catégorie.",
        'gvcontact:yourmessage_error' => "Vous devez saisir votre message.",
        
        'gvcontact:mail_success' => "Votre message a bien été envoyé !",
        'gvcontact:mail_error' => "Une erreur est survenue dans l'envoi du mail. Veuillez réessayer plus tard.",
    );
    
	add_translation("fr", $french);

?>
