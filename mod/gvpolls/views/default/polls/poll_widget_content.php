<?php
elgg_load_library('elgg:polls');

$poll = elgg_extract('entity', $vars);

if($msg = elgg_extract('msg', $vars)) {
	echo '<p>'.$msg.'</p>';
}

if (elgg_is_logged_in()) {
	$user_guid = elgg_get_logged_in_user_guid();
	$can_vote = !polls_check_for_previous_vote($poll, $user_guid);
	
	//if user has voted, show the results
	if (!$can_vote) {
		$results_display = "block";
		$poll_display = "none";
		$show_text = elgg_echo('polls:show_poll');
		$voted_text = elgg_echo("polls:voted");
	} else {
		$results_display = "none";
		$poll_display = "block";
		$show_text = elgg_echo('polls:show_results');
	}
} else {
	$results_display = "block";
	$poll_display = "none";
	$show_text = elgg_echo('polls:show_poll');
	$voted_text = elgg_echo('polls:login');
	$can_vote = FALSE;
}
?>
<?php 
    if ($poll->description) {
        echo "<div id=\"poll-description\">";
        echo "<label>".elgg_echo("gvpolls:description")."</label>";
        echo "<p>".$poll->description."</p>";
        echo "</div></br>";
    }
?>

<div id="poll-post-body-<?php echo $poll->guid; ?>" class="poll_post_body" style="display:<?php echo $results_display ?>;">
<?php 
    echo "<label>".elgg_echo("gvpolls:results")."</label>";
    if (!$can_vote) {echo '<p>'.$voted_text.'</p>';}
    echo elgg_view('polls/results_for_widget', array('entity' => $poll)); ?>
</div>

<?php 
echo elgg_view_form('polls/vote', array('id'=>'poll-vote-form-'.$poll->guid),array('entity' => $poll,'callback'=>1,'form_display'=>$poll_display));

    if ($results_display != 'none') {
        $cancel_url = 'action/polls/cancelvote?guid=' . $poll->guid;
        echo elgg_view('output/confirmlink', array(
            'text' => elgg_echo('gvpolls:cancelvote'),
            'href' => $cancel_url,
            'confirm' => elgg_echo('gvpolls:cancelwarning'),
            'class' => 'elgg-button',
        ));
    }
    
if ($can_vote) {			
?>
	<!-- show display toggle -->
	<p align="center"><a href="javascript:void(0);" rel="<?php echo $poll->guid; ?>" class="poll-show-link"><?php echo $show_text; ?></a></p>
<?php
}
