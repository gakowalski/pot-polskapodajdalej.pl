<?php defined('_JEXEC') or die;

$app 			= JFactory::getApplication();
$db				= JFactory::getDbo();

$input = $app->input;

$view_id = $input->getInt('id');

function JRouteLangFix($_friendly_url) {
	$postfix = substr($_friendly_url, -4);
	//var_dump($postfix);
	$result = $_friendly_url;
	if ($postfix == '/en/' || $postfix == '/pl/') {
		$result = substr($_friendly_url, 0, -4);
	};
	return $result;
}

if ($view_id) {
	$app->redirect(JRoute::_('index.php?option=com_k2&view=item&layout=item&id='.$view_id));
} else {
	$title	= $_REQUEST['title'] ?? false; // this gets sanitized later in the code as I have some problems with $input->get('title');
	$region	= $input->getInt('region');
	$year 	= $input->getInt('year');
	$type 	= $input->getInt('type');
	$lang	= $input->get('lang');
	$catid	= $input->getInt('catid');
	$featured = $input->getInt('featured');
	$readon = $input->getInt('readon');
	$limit = $input->get('limit');

	$query = 'SELECT id, title, introtext FROM #__k2_items WHERE published = 1 AND trash = 0';

	if ($catid)		$query .= " AND catid = $catid";
	if ($title && !empty($title)) {
		$title = filter_var(urldecode($title), FILTER_SANITIZE_STRING);
		$query .= " AND title LIKE '%$title%'";
	}
	if ($region)	$query .= " AND extra_fields LIKE '%\"id\":\"3\",\"value\":\"$region\"%'";
	if ($year)		$query .= " AND extra_fields LIKE '%\"id\":\"2\",\"value\":\"$year\"%'";
	if ($type)		$query .= " AND extra_fields LIKE '%\"id\":\"1\",\"value\":\"$type\"%'";
	if ($lang)		$query .= " AND language LIKE '$lang%'";
	else			$query .= " AND language LIKE 'pl-PL'";
	if ($featured)	$query .= ' AND featured = 1';

	$query .= " ORDER BY ordering ASC";

	if ($limit)	$query .= ' LIMIT ' . $limit;

	$db->setQuery($query);
	$results = $db->loadAssocList('id');

	foreach ($results as $result) {
		echo '<div class="gk_single_item">';
		echo '<h2><a href="'. JRouteLangFix(JRoute::_('index.php?option=com_k2&view=item&layout=item&id='.$result['id'])) .'">'.$result['title'].'</a></h2>';
		echo '<div class="introtext">'.$result['introtext'].'</div>';
		echo '</div>';
		if ($readon) echo '<p><a href="'. JRouteLangFix(JRoute::_('index.php?option=com_k2&view=item&layout=item&id='.$result['id'])) .'" class="readon">Więcej&hellip;</a></p>';
	}
}
