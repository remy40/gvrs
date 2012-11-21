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
	 
	 	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		$page_owner = page_owner_entity();
		set_context('admin');
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
		$area2 = elgg_view_title(elgg_echo('webgalli_mails:plugin:name')); 
		$area2 .= elgg_view("webgalli_mails/index"); 
		page_draw(elgg_echo('webgalli_mails:plugin:name'),elgg_view_layout("two_column_left_sidebar", $area1, $area2));
	
?>