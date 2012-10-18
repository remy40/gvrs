// content manager plugin types toggle
elgg.register_hook_handler('init', 'system', function() {
	$("#content_manager-toggle-types").click(function() {
		$('input[id=cb-content-types]').click();
	});
});

// content manager plugin subtypes toggle
elgg.register_hook_handler('init', 'system', function() {
	$("#content_manager-toggle-subtypes").click(function() {
		$('input[id=cb-content-subtypes]').click();
	});
});

// content manager plugin toggle
elgg.register_hook_handler('init', 'system', function() {
	$("#content_manager-toggle").click(function() {
		$('input[id=cb-content_manager]').click();
	});
});
