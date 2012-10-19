<?php
/**
 * Button area for showing the add widgets panel
 */

?>
<div class="elgg-widget-add-control">
<?php
	$url = "/action/dashboard/reinitialize?context=".$vars["context"]."&owner_guid=".$vars["owner_guid"];
	$options = array(
			'id' => 'widgets-reinitialize',
			'href' => $url,
			'text' => elgg_echo('gvwidgets:reinitialize'),
			'class' => 'elgg-button elgg-button-action',
			'is_action' => true,
			'is_trusted' => true,
		);
	
	if(elgg_in_context("iframe_dashboard")){
		$options["style"] = "visibility: hidden;";
	}
	echo elgg_view('output/url', $options);

	$options = array(
			'id' => 'widgets-add-panel',
			'href' => '#widget_manager_widgets_select',
			'text' => elgg_echo('widgets:add'),
			'class' => 'elgg-button elgg-button-action',
			'is_trusted' => true,
		);
	
	if(elgg_in_context("iframe_dashboard")){
		$options["style"] = "visibility: hidden;";
	}
	echo elgg_view('output/url', $options);
	
?>
</div>
