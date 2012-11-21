<div class="contentWrapper">
<?php
	/**
	 * Elgg mass mailout
	 * @package ElggMassMailout
	 * @author Dr Sanu P Moideen @ Team Webgalli
	 * @copyright Team Webgalli 2008-2015
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @link http://webgalli.com/
	 * Looking for Elgg free themes/pluggins/commercial support/elgg hosting? Visit http://webgalli.com/
	 */
	global $CONFIG;
	echo elgg_echo ('webgalli_mails:share'); 
	echo "<br />";
	$subject_title = elgg_echo('webgalli_mails:subject:title');
	$subject_text = elgg_view('input/text', array('internalname' => 'subject'));
	$message_title = elgg_echo('webgalli_mails:message:title');
	$message_text = elgg_view('input/longtext', array('internalname' => 'message'));
    $submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('webgalli_mails:message:fly')));
	$required_title = elgg_echo('webgalli_mails:message:required');
	$form = <<< END
		<div id="webgalli_mails_form">
			<br />
			<p><b>$subject_title $subject_text</b></p>
			<p><b>$message_title</b></p>
			$message_text
			$required_title<br />
			$submit_input
		</div>
END;
	
	echo elgg_view('input/form', array('body' => $form, 'action' => $CONFIG->wwwroot . "action/webgalli_mails/mailer"));
?>
</div>
