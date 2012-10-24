<?php
if (isset($vars['entity']))
{
	$poll = $vars['entity'];
	//set up our variables
	$question = $poll->question;
	$tags = $poll->tags;
	$access_id = $poll->access_id;
}
else
{
	register_error(elgg_echo("polls:blank"));
	forward('polls/all');
}

//convert $responses to radio inputs for form display
$responses = polls_get_choice_array($poll);
 
if ($poll->multiple_choices) {
    $response_inputs = elgg_view('input/checkboxes', array('name' => 'response','options' => $responses));
}
else {
    $response_inputs = elgg_view('input/radio', array('name' => 'response','options' => $responses));
}

// add "add response" box 
if ($poll->add_response) {
	$add_response_input = elgg_view('input/hidden', array('name'	=>	'number_of_choices', 'id'	=>	'number_of_choices', 'value' => 0));
	$add_response_input .= elgg_view('input/hidden',array('name' =>	'poll_guid', 'id' =>	'poll_guid', 'value' => 	$poll->guid));
	$add_response_input .= '<div id="new_choices_area"></div>';
	$add_response_input .= elgg_view('input/button', array('id'	=>	'add_choice', 'value' => elgg_echo('polls:add_choice'), 'type' => 'button'));
	$add_response_input .= elgg_view('input/submit', array('name' => 'add_choice-submit', 'value' => elgg_echo('polls:validate_new_choices')));
}

$submit_input = '<br />'.elgg_view('input/submit', array('name' => 'vote-submit', 'value' => elgg_echo('polls:vote')));

if (isset($vars['entity'])) {
	$entity_hidden = elgg_view('input/hidden', array('name' => 'guid', 'value' => $poll->guid));
	$entity_hidden .= elgg_view('input/hidden', array('name' => 'callback', 'value' => $vars['callback']));
} else {
	$entity_hidden = '';
}

$form_body = "<label>".elgg_echo("gvpolls:answers")."</label>";
$form_body .=  "<p>" . $response_inputs . "</p>";
if ($add_response_input) {
	$form_body .=  $add_response_input;
}
$form_body .= "<p>" . $submit_input . $entity_hidden . "</p>";
if ($vars['form_display']) {
	echo '<div id="poll-vote-form-container-'.$poll->guid.'" style="display:'.$vars['form_display'].'">';
} else {
	echo  '<div class="poll-vote-form-container-'.$poll->guid.'">';
}

echo $form_body;

echo '</div>';
?>
<script type="text/javascript">
$('#add_choice').click(
	function() {
		var cnum = parseInt($('#number_of_choices').val());
		$('#number_of_choices').val(cnum+1);
		var new_html = '<div id="choice_container_'+cnum+'">';
		new_html += '<input type="text" class="input-poll-choice" name="choice_text_'+cnum+'"> ';
		new_html += '<a href="#" title="<?php echo elgg_echo('polls:delete_choice'); ?>" alt="<?php echo elgg_echo('polls:delete_choice'); ?>" id="choice_delete_'+cnum+'" onclick="javascript:polls_delete_choice('+cnum+'); return false;">';
		new_html += '<img src="<?php echo $vars['url']; ?>mod/polls/graphics/16-em-cross.png"></a>'
		new_html += '</div>';
		$('#new_choices_area').append(new_html);
	}
);

function polls_delete_choice(cnum) {
	$("#choice_container_"+cnum).remove();
}

</script>
