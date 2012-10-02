<?php 

	$french = array(
	
		// general
		'group_tools:decline' => "Décliner",
		'group_tools:revoke' => "Révoquer",
		'group_tools:add_users' => "Ajouter un utilisateur",
		'group_tools:in' => "dans",
		'group_tools:remove' => "Supprimer",
		'group_tools:clear_selection' => "Effacer la sélection",
		'group_tools:all_members' => "Tous les membres",
		'group_tools:explain' => "Explication",
		
		'group_tools:default:access:group' => "Membres du groupe uniquement",
		
		'group_tools:joinrequest:already' => "Révoquer la demande d'inscription",
		'group_tools:joinrequest:already:tooltip' => "Vous avez déjà demandé à rejoindre le groupe, cliquez-ici pour annuler la demande",
		
		// menu
		'group_tools:menu:mail' => "Envoyer un mail aux membres",
		'group_tools:menu:invitations' => "Gérer les invitations",
		
		// plugin settings
		'group_tools:settings:invite:title' => "Options d'invitation",
		'group_tools:settings:management:title' => "Options générales",
		'group_tools:settings:default_access:title' => "Accès par défaut pour les groupes",
	
		'group_tools:settings:admin_create' => "Limiter la création de groupes aux administrateurs du site",
		'group_tools:settings:admin_create:description' => "Interdire la création de groupe aux simples utilisateurs connectés",
		
		'group_tools:settings:admin_transfer' => "Autoriser le changement de propriétaire",
		'group_tools:settings:admin_transfer:admin' => "Administrateur du site seulement",
		'group_tools:settings:admin_transfer:owner' => "Propriétaires du groupe et administrateurs du site",
		
		'group_tools:settings:multiple_admin' => "Autoriser plusieurs administrateurs de groupe",
		
		'group_tools:settings:invite' => "Autoriser tous les utilisateurs à être invités (pas seulement les amis)",
		'group_tools:settings:invite_email' => "Autoriser les utilisateurs à être invités par email",
		'group_tools:settings:invite_csv' => "Autoriser les utilisateurs à être invités par fichier CSV",
	
		'group_tools:settings:mail' => "Autoriser l'envoi d'email de groupe par les administrateurs du groupe",
		
		'group_tools:settings:listing' => "Onglet de listage des groupes par défaut",
		
		'group_tools:settings:default_access' => "Quel est l'accès par défaut pour les contenus du groupe?",
		'group_tools:settings:default_access:disclaimer' => "<b>DISCLAIMER:</b> Pour faire fonctionner ce plugin, vous devez patcher le Elgg core : <a href='https://github.com/Elgg/Elgg/pull/253' target='_blank'>https://github.com/Elgg/Elgg/pull/253</a>.",
		
		'group_tools:settings:search_index' => "Autoriser l'indexation des groupes fermés par les moteurs de recherche",
		'group_tools:settings:auto_notification' => "Activer automatiquement les notifications de groupe à l'inscription",
		'group_tools:settings:auto_join' => "Groupes avec auto-inscription",
		'group_tools:settings:auto_join:description' => "Les nouveaux utilisateurs seront automatiquement inscrits aux groupes avec auto-inscription",
		
		// group invite message
		'group_tools:groups:invite:body' => "Bonjour %s,

%s vous invite à rejoindre le groupe '%s'. 
%s

Clique ci-dessous pour voir tes invitations:
%s",
	
		// group add message
		'group_tools:groups:invite:add:subject' => "Vous avez été ajouté au groupe %s",
		'group_tools:groups:invite:add:body' => "Bonjour %s,
	
%s vous a ajouté au groupe %s.
%s

Pour voir le groupe, clique sur le lien suivant:
%s",
		// group invite by email
		'group_tools:groups:invite:email:subject' => "Vous avez été invité à rejoindre le groupe %s",
		'group_tools:groups:invite:email:body' => "Bonjour,

%s vous a invité à rejoindre le groupe %s sur %s.
%s

Si vous n'avez pas de compte sur %s vous pouvez vous enregistrer ici 
%s
on
Si vous avez déjà un compte ou après vous être enregistré, cliquez sur le lien suivant pour accepter l'invitation
%s

Vous pouvez aussi aller sur \"Tous les groupes\" -> \"invitations du groupe\" et entrer le code suivant:
%s",
		// group transfer notification
		'group_tools:notify:transfer:subject' => "Administration of the group %s has been appointed to you",
		'group_tools:notify:transfer:message' => "Hi %s,
		
%s has appointed you as the new administrator of the group %s. 

To visit the group please click on the following link:
%s",
		
		// group edit tabbed
		'group_tools:group:edit:profile' => "Options de profil",
		'group_tools:group:edit:other' => "Autres options",

		// admin transfer - form
		'group_tools:admin_transfer:title' => "Transfer the ownership of this group",
		'group_tools:admin_transfer:transfer' => "Transfer group ownership to",
		'group_tools:admin_transfer:myself' => "Myself",
		'group_tools:admin_transfer:submit' => "Tranfser",
		'group_tools:admin_transfer:no_users' => "No members or friends to transfer ownership to.",
		'group_tools:admin_transfer:confirm' => "Are you sure you wish to transfer ownership?",
		
		// auto join form
		'group_tools:auto_join:title' => "Auto join options",
		'group_tools:auto_join:add' => "%sAdd this group%s to the auto join groups. This will mean that new users are automaticly added to this group on registration.",
		'group_tools:auto_join:remove' => "%sRemove this group%s from the auto join groups. This will mean that new users will no longer automaticly join this group on registration.",
		'group_tools:auto_join:fix' => "To make all site members a member of this group, please %sclick here%s.",
		
		// group admins
		'group_tools:multiple_admin:group_admins' => "Group admins",
		'group_tools:multiple_admin:profile_actions:remove' => "Remove group admin",
		'group_tools:multiple_admin:profile_actions:add' => "Add group admin",
	
		'group_tools:multiple_admin:group_tool_option' => "Enable group admins to assign other group admins",

		// cleanup options
		'group_tools:cleanup:title' => "Group sidebar cleanup",
		'group_tools:cleanup:description' => "Cleanup the sidebar of the group. This will have no effect for the group admins.",
		'group_tools:cleanup:owner_block' => "Limit the owner block",
		'group_tools:cleanup:owner_block:explain' => "The owner block can be found at the top of the sidebar, some extra links can be posted in this area (example: RSS links).",
		'group_tools:cleanup:actions' => "Do you want to allow users to join this group",
		'group_tools:cleanup:actions:explain' => "Depending on your group setting, users can directly join the group or request membership.",
		'group_tools:cleanup:menu' => "Hide side menu items",
		'group_tools:cleanup:menu:explain' => "Hide the menu links to the different group tools. The users will only be able to get access to the group tools by using the group widgets.",
		'group_tools:cleanup:members' => "Hide the group members",
		'group_tools:cleanup:members:explain' => "On the group profile page a list of the group members can be found at the highlighted section. You can choose to hide this list.",
		'group_tools:cleanup:search' => "Hide the search in group",
		'group_tools:cleanup:search:explain' => "On the group profile page a search box is available. You can choose to hide this.",
		'group_tools:cleanup:featured' => "Show featured groups in the sidebar",
		'group_tools:cleanup:featured:explain' => "You can choose to show a list of featured groups at the highlighted section on the group profile page",
		'group_tools:cleanup:featured_sorting' => "How to sort featured groups",
		'group_tools:cleanup:featured_sorting:time_created' => "Newest first",
		'group_tools:cleanup:featured_sorting:alphabetical' => "Alphabetical",

		// group default access
		'group_tools:default_access:title' => "Group default access",
		'group_tools:default_access:description' => "Here you can control what the default access of new content in your group should be.",
		
		// group notification
		'group_tools:notifications:title' => "Group notifications",
		'group_tools:notifications:description' => "This group has %s members, of those %s have enabled notifications on activity in this group. Below you can change this for all users of the group.",
		'group_tools:notifications:disclaimer' => "With large groups this could take a while.",
		'group_tools:notifications:enable' => "Enable notifications for everyone",
		'group_tools:notifications:disable' => "Disable notifications for everyone",
		
		// group profile widgets
		'group_tools:profile_widgets:title' => "Show group profile widgets to non members",
		'group_tools:profile_widgets:description' => "This is a closed group. Default no widgets are shown to non members. Here you can configure if you whish to change that.",
		'group_tools:profile_widgets:option' => "Allow non members to view widgets on the group profile page:",
		
		// group mail
		'group_tools:mail:message:from' => "From group",
		
		'group_tools:mail:title' => "Send a mail to the group members",
		'group_tools:mail:form:recipients' => "Number of recipients",
		'group_tools:mail:form:members:selection' => "Select individual members",
		
		'group_tools:mail:form:title' => "Subject",
		'group_tools:mail:form:description' => "Body",
	
		'group_tools:mail:form:js:members' => "Please select at least one member to send the message to",
		'group_tools:mail:form:js:description' => "Please enter a message",
		
		// group invite
		'group_tools:groups:invite:title' => "Invite users to this group",
		'group_tools:groups:invite' => "Invite users",
		
		'group_tools:group:invite:friends:select_all' => "Select all friends",
		'group_tools:group:invite:friends:deselect_all' => "Deselect all friends",
		
		'group_tools:group:invite:users' => "Find user(s)",
		'group_tools:group:invite:users:description' => "Enter a name or username of a site member and select him/her from the list",
		'group_tools:group:invite:users:all' => "Invite all site members to this group",
		
		'group_tools:group:invite:email' => "Using e-mail address",
		'group_tools:group:invite:email:description' => "Enter a valid e-mail address and select it from the list",
		
		'group_tools:group:invite:csv' => "Using CSV upload",
		'group_tools:group:invite:csv:description' => "You can upload a CSV file with users to invite.<br />The format must be: displayname;e-mail address. There shouldn't be a header line.",
		
		'group_tools:group:invite:text' => "Personal note (optional)",
		'group_tools:group:invite:add:confirm' => "Are you sure you wish to add these users directly?",
		
		'group_tools:group:invite:resend' => "Resend invitations to users who already have been invited",

		'group_tools:groups:invitation:code:title' => "Group invitation by e-mail",
		'group_tools:groups:invitation:code:description' => "If you have received an invitation to join a group by e-mail, you can enter the invitation code here to accept the invitation. If you click on the link in the invitation e-mail the code will be entered for you.",
	
		// group membership requests
		'group_tools:groups:membershipreq:requests' => "Membership requests",
		'group_tools:groups:membershipreq:invitations' => "Outstanding invitations",
		'group_tools:groups:membershipreq:invitations:none' => "No outstanding invitations",
		'group_tools:groups:membershipreq:invitations:revoke:confirm' => "Are you sure you wish to revoke this invitation",
	
		// group invitations
		'group_tools:group:invitations:request' => "Outstanding membership requests",
		'group_tools:group:invitations:request:revoke:confirm' => "Are you sure you wish to revoke your membership request?",
		'group_tools:group:invitations:request:non_found' => "There are no outstanding membership requests at this time",
	
		// group listing
		'group_tools:groups:sorting:alphabetical' => "Alphabetical",
		'group_tools:groups:sorting:open' => "Open",
		'group_tools:groups:sorting:closed' => "Closed",
	
		// actions
		'group_tools:action:error:input' => "Invalid input to perform this action",
		'group_tools:action:error:entities' => "The given GUIDs didn't result in the correct entities",
		'group_tools:action:error:entity' => "The given GUID didn't result in a correct entity",
		'group_tools:action:error:edit' => "You don't have access to the given entity",
		'group_tools:action:error:save' => "There was an error while saving the settings",
		'group_tools:action:success' => "The settings where saved successfully",
	
		// admin transfer - action
		'group_tools:action:admin_transfer:error:access' => "You're not allowed to transfer ownership of this group",
		'group_tools:action:admin_transfer:error:self' => "You can't transfer onwership to yourself, you're already the owner",
		'group_tools:action:admin_transfer:error:save' => "An unknown error occured while saving the group, please try again",
		'group_tools:action:admin_transfer:success' => "Group ownership was successfully transfered to %s",
		
		// group admins - action
		'group_tools:action:toggle_admin:error:group' => "The given input doesn't result in a group or you can't edit this group or the user is not a member",
		'group_tools:action:toggle_admin:error:remove' => "An unknown error occured while removing the user as a group admin",
		'group_tools:action:toggle_admin:error:add' => "An unknown error occured while adding the user as a group admin",
		'group_tools:action:toggle_admin:success:remove' => "The user was successfully removed as a group admin",
		'group_tools:action:toggle_admin:success:add' => "The user was successfully added as a group admin",
		
		// group mail - action
		'group_tools:action:mail:success' => "Message succesfully send",
	
		// group - invite - action
		'group_tools:action:invite:error:invite'=> "No users were invited (%s already invited, %s already a member)",
		'group_tools:action:invite:error:add'=> "No users were invited (%s already invited, %s already a member)",
		'group_tools:action:invite:success:invite'=> "Successfully invited %s users (%s already invited and %s already a member)",
		'group_tools:action:invite:success:add'=> "Successfully added %s users (%s already invited and %s already a member)",
		
		// group - invite - accept e-mail
		'group_tools:action:groups:email_invitation:error:input' => "Please enter an invitation code",
		'group_tools:action:groups:email_invitation:error:code' => "The entered invitation code is no longer valid",
		'group_tools:action:groups:email_invitation:error:join' => "An unknown error occured while joining the group %s, maybe you're already a member",
		'group_tools:action:groups:email_invitation:success' => "You've successfully joined the group",
		
		// group toggle auto join
		'group_tools:action:toggle_auto_join:error:save' => "An error occured while saving the new settings",
		'group_tools:action:toggle_auto_join:success' => "The new settings were saved successfully",
		
		// group fix auto_join
		'group_tools:action:fix_auto_join:success' => "Group membership fixed: %s new members, %s were already a member and %s failures",
		
		// group cleanup
		'group_tools:actions:cleanup:success' => "The cleanup settings were saved successfully",
		
		// group default access
		'group_tools:actions:default_access:success' => "The default access for the group was saved successfully",
		
		// group notifications
		'group_tools:action:notifications:error:toggle' => "Invalid toggle option",
		'group_tools:action:notifications:success:disable' => "Successfully disabled notifications for every member",
		'group_tools:action:notifications:success:enable' => "Successfully enabled notifications for every member",
	
		// Widgets
		// Group River Widget
		'widgets:group_river_widget:title' => "Activité des groupes",
	    'widgets:group_river_widget:description' => "Vous permet de suivre l'activité des groupes sélectionnés",

	    'widgets:group_river_widget:edit:num_display' => "Number of activities",
		'widgets:group_river_widget:edit:group' => "Select a group",
		'widgets:group_river_widget:edit:no_groups' => "You need to be a member of at least one group to use this widget",

		'widgets:group_river_widget:view:not_configured' => "This widget is not yet configured",

		'widgets:group_river_widget:view:more' => "Activity in the '%s' group",
		'widgets:group_river_widget:view:noactivity' => "We could not find any activity.",
		
		// Group Members
		'widgets:group_members:title' => "Group members",
  		'widgets:group_members:description' => "Shows the members of this group",

  		'widgets:group_members:edit:num_display' => "How many members to show",
  		'widgets:group_members:view:no_members' => "No group members found",
  		
  		// Group Invitations
		'widgets:group_invitations:title' => "Mes invitations en attente",
	  	'widgets:group_invitations:description' => "Affiche vos invitations à rejoindre des groupes qui sont en attente",
	  	
	  	// Discussion
		"widgets:discussion:settings:group_only" => "Only show discussions from groups you are member of",
  		'widgets:discussion:more' => "View more discussions",
  		"widgets:discussion:description" => "Affiche les dernières discussions des groupes",
  		
		// Forum topic widget
		'widgets:group_forum_topics:description' => "Show the latest discussions",
		
		// index_groups
		'widgets:index_groups:description' => "Show the latest groups on your community",
		'widgets:index_groups:show_members' => "Show members count",
		'widgets:index_groups:featured' => "Show only featured groups",
		
		// Featured Groups
		'widgets:featured_groups:description' => "Shows a random list of featured groups",
	  	'widgets:featured_groups:edit:show_random_group' => "Show a random non-featured group",
	  	
		// group_news widget
		"widgets:group_news:title" => "Derniers articles des groupes", 
		"widgets:group_news:description" => "Affiche les derniers articles de blog des groupes", 
		"widgets:group_news:no_projects" => "No groups configured", 
		"widgets:group_news:no_news" => "No blogs for this group", 
		"widgets:group_news:settings:project" => "Group", 
		"widgets:group_news:settings:no_project" => "Select a group",
		"widgets:group_news:settings:blog_count" => "Max number of blogs",
		"widgets:group_news:settings:group_icon_size" => "Group icon size",
		"widgets:group_news:settings:group_icon_size:small" => "Small",
		"widgets:group_news:settings:group_icon_size:medium" => "Medium",
		
	);
	
	add_translation("fr", $french);
  	
