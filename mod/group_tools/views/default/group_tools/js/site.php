<?php
?>
//<script>
elgg.provide("elgg.group_tools");

elgg.group_tools.mail_form_submit = function(){
	var result = false;
	var error_msg = "";
	var error_count = 0;

	if($('#group_tools_mail_member_selection input[name="user_guids[]"]:checked').length == 0){
		error_msg += elgg.echo("group_tools:mail:form:js:members") + '\n';
		error_count++;
	}
	
	if($(this).find('input[name="description"]').val() == ""){
		error_msg += elgg.echo("group_tools:mail:form:js:description") + '\n';
		error_count++;
	}

	if(error_count > 0){
		alert(error_msg);
	} else {
		result = true;
	}
	
	return result;
}

elgg.group_tools.mail_clear_members = function(){
	$('#group_tools_mail_member_selection input[name="user_guids[]"]:checked').each(function(){
		$(this).removeAttr('checked');
	});

	elgg.group_tools.mail_update_recipients();
}

elgg.group_tools.mail_all_members = function(){
	$('#group_tools_mail_member_selection input[name="user_guids[]"]').each(function(){
		$(this).attr('checked', 'checked');
	});

	elgg.group_tools.mail_update_recipients();
}

elgg.group_tools.mail_update_recipients = function(){
	var count = $('#group_tools_mail_member_selection input[name="user_guids[]"]:checked').length;

	$('#group_tools_mail_recipients_count').html(count);
}

elgg.group_tools.admin_transfer_confirm = function(){
	return confirm(elgg.echo("group_tools:admin_transfer:confirm"));
}

elgg.group_tools.cleanup_highlight = function(section){
	switch(section){
		case "owner_block":
			$('div.elgg-sidebar ul.elgg-menu-extras').addClass('group-tools-highlight');
			break;
		case "menu":
			$('div.elgg-sidebar ul.elgg-menu-owner-block').addClass('group-tools-highlight');
			break;
		case "search":
			$('div.elgg-sidebar').append('<div id="group_tools_search_example" class="group-tools-highlight">' + elgg.echo('groups:search_in_group') + '</div>');
			break;
		case "members":
			$('div.elgg-sidebar').append('<div id="group_tools_members_example" class="group-tools-highlight">' + elgg.echo('groups:members') + '</div>');
			break;
		case "featured":
			$('div.elgg-sidebar').append('<div id="group_tools_featured_example" class="group-tools-highlight">' + elgg.echo('groups:featured') + '</div>');
			break;
	}
}

elgg.group_tools.cleanup_unhighlight = function(section){
	switch(section){
		case "owner_block":
			$('div.elgg-sidebar ul.elgg-menu-extras').removeClass('group-tools-highlight');
			break;
		case "menu":
			$('div.elgg-sidebar ul.elgg-menu-owner-block').removeClass('group-tools-highlight');
			break;
		case "search":
			$('#group_tools_search_example').remove();
			break;
		case "members":
			$('#group_tools_members_example').remove();
			break;
		case "featured":
			$('#group_tools_featured_example').remove();
			break;
	}
}

elgg.group_tools.init = function(){
	// admin tranfser
	$('#group_tools_admin_transfer_form').submit(elgg.group_tools.admin_transfer_confirm);

	// group mail members
	$('#group_tools_mail_member_selection input[type=checkbox]').live("change", elgg.group_tools.mail_update_recipients);
	$('#group_tools_mail_form').submit(elgg.group_tools.mail_form_submit);
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.group_tools.init);