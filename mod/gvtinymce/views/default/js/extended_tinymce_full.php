elgg.provide('elgg.extended_tinymce_full');

/**
 * Toggles the extended tinymce editor
 *
 * @param {Object} event
 * @return void
 */
elgg.extended_tinymce_full.toggleEditor = function(event) {
	event.preventDefault();

	var target = $(this).attr('href');
	var id = $(target).attr('id');
	tinyMCE.execCommand('mceAddControl', false, id);
}

/**
 * TinyMCE initialization script
 *
 * You can find configuration information here:
 * http://tinymce.moxiecode.com/wiki.php/Configuration
 */
elgg.extended_tinymce_full.init = function() {

	$('.extended_tinymce-toggle-editor').live('click', elgg.extended_tinymce_full.toggleEditor);

	$('.elgg-input-longtext').parents('form').submit(function() {
		tinyMCE.triggerSave();
	});

	tinyMCE.init({
		mode : "specific_textareas",
		editor_selector : "elgg-input-longtext",
		theme : "advanced",
		skin : "cirkuit",
        language : "<?php echo extended_tinymce_get_site_language(); ?>",
		plugins : "lists,autosave,fullscreen,spellchecker,style,table,advhr,advimage,emotions,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras",
		relative_urls : false,
		remove_script_host : false,
		document_base_url : elgg.config.wwwroot,
		theme_advanced_buttons1 : "spellchecker,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,table,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink",
		theme_advanced_buttons3 : "print,|,insertdate,inserttime,|,forecolor,backcolor,|,image,emotions,|,fullscreen <?php if (elgg_is_admin_logged_in()) { ?> ,|,code <?php } ?>",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "none",
		theme_advanced_resizing : false,
		theme_advanced_path : true,
        spellchecker_languages : "+French=fr",
        spellchecker_report_misspellings: true,
		width : "100%",
        height: "600",
		extended_valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup],a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],embed[src|type|wmode|width|height],object[classid|clsid|codebase|width|height],font[face|size|color|style],span[class|align|style],style[lang|media|title|type]",
		content_css: elgg.config.wwwroot + 'mod/extended_tinymce/css/elgg_extended_tinymce.css'
	});

	// work around for IE/TinyMCE bug where TinyMCE loses insert carot
        if ($.browser.msie) {
                $(".embed-control").live('hover', function() {
                        var classes = $(this).attr('class');
                        var embedClass = classes.split(/[, ]+/).pop();
                        var textAreaId = embedClass.substr(embedClass.indexOf('embed-control-') + "embed-control-".length);

                        if (window.tinyMCE) {
                                var editor = window.tinyMCE.get(textAreaId);
                                if (elgg.extended_tinymce_full.bookmark == null) {
                                        elgg.extended_tinymce_full.bookmark = editor.selection.getBookmark(2);
                                }
                        }
                });
        }
}

elgg.register_hook_handler('init', 'system', elgg.extended_tinymce_full.init);
