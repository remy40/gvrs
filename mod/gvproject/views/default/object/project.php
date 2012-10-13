<?php
/**
 * View for page object
 *
 * @package ElggPages
 *
 * @uses $vars['entity']    The page object
 * @uses $vars['full_view'] Whether to display the full view
 */

$entity = $vars['entity'];
$full_view = $vars['full_view'];

if ($entity) {
	$container = $entity->getContainerEntity();

	$container_icon = elgg_view_entity_icon($container, 'tiny');
	$container_link = elgg_view('output/url', array(
				'href' => "groups/profile/{$container->guid}/{$container->name}",
				'text' => $container->name,
				'is_trusted' => true));
	$author_text = elgg_echo('gvprojects:byline', array($container_link));
	$tags = elgg_view('output/tags', array('tags' => $entity->tags));
	$date = elgg_view_friendly_time($entity->time_created);

    $comments_count = $entity->countComments();
    //only display if there are commments
    if ($comments_count != 0) {
        $text = elgg_echo("comments") . " ($comments_count)";
        $comments_link = elgg_view('output/url', array(
                    'href' => $entity->getURL() . '#poll-comments',
                    'text' => $text,
                    'is_trusted' => true,
        ));
    } else {
        $comments_link = '';
    }

	// do not show the metadata and controls in widget view
	if (elgg_in_context('widgets')) {
		$metadata = '';
	} else {
		$metadata = elgg_view_menu('entity', array(
					'entity' => $entity,
					'handler' => 'projects',
					'sort_by' => 'priority',
					'class' => 'elgg-menu-hz'));
	}

	$subtitle .= "$author_text $date $comments_link";

    if ($full_view) {
		$body = "<br><label>" . elgg_echo("gvprojects:description") . "</label>";
		$body .= elgg_view('output/longtext', array('value' => $entity->description));
		$body .= "<br><label>" . elgg_echo("gvprojects:competencies") . "</label>";

		if ($entity->competencies) {
			$competencies = $entity->competencies;
		}
		else {
			$competencies = elgg_echo("gvproject:no_competency");
		}

		$body .= elgg_view('output/longtext', array('value' => $competencies));
		
		$body .= "<br>" . elgg_echo("gvproject:participate", array($container_link));
		
		$params = array(
			'entity' => $entity,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
		);
		$params = $params + $vars;
		$summary = elgg_view('object/elements/summary', $params);

		echo elgg_view('object/elements/full', array(
			'entity' => $entity,
			'title' => true,
			'icon' => $container_icon,
			'summary' => $summary,
			'body' => $body,
		));
    }
    else {
		// brief view
	
		$params = array(
			'entity' => $entity,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'tags' => $tags,
			'content' => $entity->short_desc,
		);
		$params = $params + $vars;
		$list_body = elgg_view('object/elements/summary', $params);
	
		echo elgg_view_image_block($container_icon, $list_body);
    }
}
