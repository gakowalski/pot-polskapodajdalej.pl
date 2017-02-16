<?php defined('_JEXEC') or die; ?>
<?php 
$app 			= JFactory::getApplication();
$db				= JFactory::getDbo();

$input = $app->input;

$view_id = $input->getInt('id');

if ($view_id) {
	$app->redirect(JRoute::_('index.php?option=com_k2&view=item&layout=item&id='.$view_id));
	/*
	$query = "SELECT `id`, `title`, `introtext`, `fulltext` FROM #__k2_items WHERE id = $view_id AND published = 1";
	$db->setQuery($query);
	$result = $db->loadAssoc('id');
	
	echo '<a id="article"><p class="contentheading">' . trim($result['title']) . '</p></a>';
	echo '<p>' . $result['fulltext'] . '</p>';
	
	if ($view_id > 300) $view_id -= 300;
	
?><table width="auto" border="0" align="center" id="ppd_media">
<tr valign="top" align="center">
<td><a href="images/stories/produkty/<?php echo $view_id; ?>-1.jpg" rel="lightbox"><img src="images/stories/produkty/t/<?php echo $view_id; ?>-1.jpg" /></a></td>
<td><a href="images/stories/produkty/<?php echo $view_id; ?>-2.jpg" rel="lightbox"><img src="images/stories/produkty/t/<?php echo $view_id; ?>-2.jpg" /></a></td>
</tr>
<tr valign="top" align="center">
<td><a href="images/stories/produkty/<?php echo $view_id; ?>-3.jpg" rel="lightbox"><img src="images/stories/produkty/t/<?php echo $view_id; ?>-3.jpg" /></a></td>
<td><a href="images/stories/produkty/<?php echo $view_id; ?>-4.jpg" rel="lightbox"><img src="images/stories/produkty/t/<?php echo $view_id; ?>-4.jpg" /></a></td>
</tr>
</table><?php
	*/
} else {
	$title	= $_REQUEST['title']; // this gets sanitized later in the code as I have some problems with $input->get('title');
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
	//else			$query .= ' AND catid = 19';
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
	
	//$query .= ' AND id NOT BETWEEN 232 AND 242';

	$query .= " ORDER BY ordering ASC";

	if ($limit)	$query .= ' LIMIT ' . $limit;

	$db->setQuery($query);
	$results = $db->loadAssocList('id');

	//var_dump($title);
	//var_dump($region);

	foreach ($results as $result) {
		echo '<h2><a href="'. JRoute::_('index.php?option=com_k2&view=item&layout=item&id='.$result['id']) .'">'.$result['title'].'</a></h2>';
		//echo '<h2><a href="'. JRoute::_("index.php?option=com_gk&lang=$lang&id=".$result['id']) .'#article">'.$result['title'].'</a></h2>';
		echo '<div id="introtext">'.$result['introtext'].'</div>';
		if ($readon) echo '<p><a href="'. JRoute::_('index.php?option=com_k2&view=item&layout=item&id='.$result['id']) .'" class="readon">Więcej&hellip;</a></p>';
		//if ($readon) echo '<p><a href="'. JRoute::_("index.php?option=com_gk&lang=$lang&id=".$result['id']) .'#article" class="readon">Więcej&hellip;</a></p>';
	}
	
	//echo $query;
}
?>