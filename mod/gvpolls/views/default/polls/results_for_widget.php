<?php
/**
 * Elgg Poll plugin
 * @package Elggpoll
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @Original author John Mellberg
 * website http://www.syslogicinc.com
 * @Modified By Team Webgalli to work with ElggV1.5
 * www.webgalli.com or www.m4medicine.com
 */


if (isset($vars['entity'])) {

	//set img src
	$img_src = $vars['url'] . "mod/polls/graphics/poll.gif";

	$question = $vars['entity']->question;

	//get the array of possible responses
	$responses = polls_get_choice_array($vars['entity']);

	//get the array of user responses to the poll
	$options = array(
		'guid' => $vars['entity']->guid,
		'annotation_name' => 'vote',
		'limit' => NULL,
		'offset' => 0,
		'order_by' => 'n_table.owner_guid',
	);

//	$user_responses = $vars['entity']->getAnnotations('vote',9999,0,'desc');
	$user_responses = elgg_get_annotations($options);

	//get the count of responses
//	$user_responses_count = $vars['entity']->countAnnotations('vote');
	$user_responses_count = count($user_responses);

	// get number of voters
//	$voters_count = elgg_get_annotations($options);
if ($user_responses_count) {
	for($i=0;$i<$user_responses_count;$i++) {
		$voter = get_entity($user_responses[$i]->getOwnerGUID());
		error_log("[username=".$voter->username." name=".$voter->name. " value=".$user_responses[$i]->value."]");
	}

	$voters_count = 1;
	for($i=1;$i<$user_responses_count;$i++) {
		error_log("user_responses[guid=");
		if($user_responses[$i-1]->getOwnerGUID() != $user_responses[$i]->getOwnerGUID()) {
			$voters_count++;
		}
	}
}
	//populate array
	foreach($responses as $response)
	{
		//get count per response
		$response_count = polls_get_response_count($response, $user_responses);
			
		//calculate %
		if ($response_count && $user_responses_count) {
			$response_percentage = round(100 / ($user_responses_count / $response_count));
		} else {
			$response_percentage = 0;
		}
			
		//html
		?>
<div class="progress_indicator">
	<label><?php echo $response . " (" . $response_count . ")"; ?> </label><br>
	<div class="progressBarContainer" align="left">
		<div class="polls-filled-bar"
			style="width: <?php echo $response_percentage; ?>%"></div>
	</div>
</div>
<br>
		<?php
	}
	?>

<p>
<?php echo elgg_echo('polls:totalvotes') . $voters_count; ?>
</p>

<?php

}
else
{
	register_error(elgg_echo("polls:blank"));
	forward("mod/polls/all");
}
