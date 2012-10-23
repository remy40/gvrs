<?php
/**
* One page login pageshell
*/
// Set the content type
header("Content-type: text/html; charset=UTF-8");

	$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php echo elgg_view('page/elements/head', $vars); ?>
</head>
<body>
	<div class="elgg-page-messages">
		<?php echo $messages; ?>
	</div>
	<?php echo $vars['body']; ?>
</body>
</html>
