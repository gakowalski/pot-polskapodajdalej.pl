<?php
defined('_JEXEC') or die;

/* special parameters */
$extension_name = 'mod_gk';		/* same as folder name, ex. "mod_foo" */

/* default joomla parameters */
//$module_tag 	= $params->get('module_tag');		/* string, tag name, ex. "div" */
//$header_tag 	= $params->get('header_tag');		/* string, tag name, ex. "h3" */
$header_class	= $params->get('header_class');		/* string, so called 'moduleclass_sfx', ex. "_myown" or empty */
//$bootstrap_size = $params->get('bootstrap_size');	/* string with number, how many layout columns this extension uses, ex. "0" */
//$style			= $params->get('style');			/* string, "0" = inherited, otherwise in format Template-Style, ex. "System-html5" */

/* special objects */
$db				= JFactory::getDbo();				/* database */
//$user 			= JFactory::getUser();				/* user visiting website, JUser, http://api.joomla.org/Joomla-Platform/User/JUser.html */
//$uri			= JFactory::getURI();				/* uri to this script, JUri */
//$session		= JFactory::getSession();			/* JSession */
//$language		= JFactory::getLanguage();			/* JLanguage */
$app	= JFactory::getApplication();		/* JApp */
$input	= $app->input;


$title	= $_GET['title'] ?? false; //$input->get('title');
$region	= $input->getInt('region');
$year 	= $input->getInt('year');
$type 	= $input->getInt('type');
//$lang	= $input->get('lang');
$lang	= (JFactory::getLanguage()->getTag() == 'pl-PL'? 'pl' : 'en');

//$types[0] = '(wybierz typ turystyki)';
if ($lang == 'pl') {
	$types[0] = '(typ turystyki)';
	$types[1] = 'City breaks';
	$types[2] = 'Imprezy kulturalne';
	$types[3] = 'Imprezy sportowe';
	$types[4] = 'Kulinaria';
	$types[5] = 'Muzea i centra edukacyjne';
	$types[6] = 'Obiekty sakralne';
	$types[7] = 'Parki rozrywki';
	$types[8] = 'Spa & wellness';
	$types[9] = 'Szlaki i trasy turystyczne';
	$types[10] = 'Turystyka aktywna';
	$types[11] = 'Turystyka biznesowa / incentive';
	$types[12] = 'Turystyka industrialna';
	$types[13] = 'Turystyka krajoznawcza / edukacyjna';
	$types[14] = 'Turystyka przyrodnicza';
	$types[15] = 'Turystyka rodzinna';
	$types[16] = 'Turystyka wiejska';
	$types[17] = 'Twierdze';
	$types[18] = 'Zamki i pałace';
} else {
	$types[0] = '(product type)';
	$types[1] = 'City breaks';
	$types[2] = 'Cultural events';
	$types[3] = 'Sporting events';
	$types[4] = 'Culinary tourism';
	$types[5] = 'Museums and education centres';
	$types[6] = 'Religious buildings';
	$types[7] = 'Amusement parks';
	$types[8] = 'Spa & wellness';
	$types[9] = 'Tourist routes and trails';
	$types[10] = 'Active tourism';
	$types[11] = 'Business tourism / Incentive';
	$types[12] = 'Industrial tourism';
	$types[13] = 'Heritage tourism / Educational tourism';
	$types[14] = 'Nature tourism';
	$types[15] = 'Family tourism';
	$types[16] = 'Rural tourism';
	$types[17] = 'Fortresses';
	$types[18] = 'Castles and palaces';
}

//$regions[0] = '(wybierz województwo)';
if ($lang == 'pl') {
	$regions[0] = '(województwo)';
	$regions[1] = 'dolnośląskie';
	$regions[2] = 'kujawsko-pomorskie';
	$regions[3] = 'lubelskie';
	$regions[4] = 'lubuskie';
	$regions[5] = 'łódzkie';
	$regions[6] = 'małopolskie';
	$regions[7] = 'mazowieckie';
	$regions[8] = 'opolskie';
	$regions[9] = 'podkarpackie';
	$regions[10] = 'podlaskie';
	$regions[11] = 'pomorskie';
	$regions[12] = 'śląskie';
	$regions[13] = 'świętokrzyskie';
	$regions[14] = 'warmińsko-mazurskie';
	$regions[15] = 'wielkopolskie';
	$regions[16] = 'zachodniopomorskie';
} else {
	$regions[0] = '(region)';
	$regions[1] = 'dolnośląskie (Lower Silesian)';
	$regions[2] = 'kujawsko-pomorskie (kuyavian-pomeranian)';
	$regions[3] = 'lubelskie';
	$regions[4] = 'lubuskie';
	$regions[5] = 'łódzkie';
	$regions[6] = 'małopolskie (Lesser Poland)';
	$regions[7] = 'mazowieckie (Mazovia)';
	$regions[8] = 'opolskie';
	$regions[9] = 'podkarpackie';
	$regions[10] = 'podlaskie';
	$regions[11] = 'pomorskie (Pomeranian)';
	$regions[12] = 'śląskie (Silesian)';
	$regions[13] = 'świętokrzyskie';
	$regions[14] = 'warmińsko-mazurskie (Warmian-Masurian)';
	$regions[15] = 'wielkopolskie';
	$regions[16] = 'zachodniopomorskie (West Pomerania)';
}

/*
SELECT
COUNT(id) AS licznik,
SUBSTR(extra_fields, 18 + LOCATE('"id":"3"', extra_fields), 2) AS region
FROM `j25_k2_items`
WHERE `extra_fields` LIKE '%"id":"3"%' AND language LIKE 'pl-PL'
GROUP BY region
ORDER BY region ASC
*/
$searchURL		= '/index.php?option=com_gk&region=';
$flashWidth		= 460;
$flashHeight	= 200;
$flashName		= 'mapa_small.swf';

$flashVars		= http_build_query(array(
		'dolnoslaskie' => $searchURL.'1',
		'kujaw' => $searchURL.'2',
		'lubelskie' => $searchURL.'3',
		'lubuskie' => $searchURL.'4',
		'lodzkie' => $searchURL.'5',
		'malopolskie' => $searchURL.'6',
		'mazowieckie' => $searchURL.'7',
		'opolskie' => $searchURL.'8',
		'podkarpackie' => $searchURL.'9',
		'podlaskie' => $searchURL.'10',
		'pomorskie' => $searchURL.'11',
		'slaskie' => $searchURL.'12',
		'swietokrzyskie' => $searchURL.'13',
		'warmia' => $searchURL.'14',
		'wielkopolskie' => $searchURL.'15',
		'zpomorskie' => $searchURL.'16',
		'region' => '0',

		// last updated: 2017-03-03 by GK
		'dolnoslaskievar12' 	=> ($lang == 'pl')? 15 : 15,
		'kujawvar5' 			=> ($lang == 'pl')? 10 : 10,
		'lubelskievar10' 		=> ($lang == 'pl')? 11 : 10,
		'lubuskievar7' 			=> ($lang == 'pl')? 9 : 9,
		'lodzkievar9' 			=> ($lang == 'pl')? 13 : 13,
		'malopolskievar15' 		=> ($lang == 'pl')? 16 : 15,
		'mazowieckievar8' 		=> ($lang == 'pl')? 10 : 9,
		'opolskievar13' 		=> ($lang == 'pl')? 5 : 5,
		'podkarpackievar16' 	=> ($lang == 'pl')? 9 : 8,
		'podlaskievar4' 		=> ($lang == 'pl')? 12 : 12,
		'pomorskievar1' 		=> ($lang == 'pl')? 17 : 17,
		'slaskievar14' 			=> ($lang == 'pl')? 14 : 12,
		'swietokrzyskievar11' 	=> ($lang == 'pl')? 15 : 13,
		'warmiavar3' 			=> ($lang == 'pl')? 8 : 8,
		'wielkopolskievar6' 	=> ($lang == 'pl')? 12 : 10,
		'zpomorskievar2' 		=> ($lang == 'pl')? 11 : 11,

		/*
		'pomorskievar1' => $results[11]['licznik'],
		'zpomorskievar2' => $results[16]['licznik'],
		'warmiavar3' => $results[14]['licznik'],
		'podlaskievar4' => $results[10]['licznik'],
		'kujawvar5' => $results[2]['licznik'],
		'wielkopolskievar6' => $results[15]['licznik'],
		'lubuskievar7' => $results[4]['licznik'],
		'mazowieckievar8' => $results[7]['licznik'],
		'lodzkievar9' => $results[5]['licznik'],
		'lubelskievar10' => $results[3]['licznik'],
		'swietokrzyskievar11' => $results[13]['licznik'],
		'dolnoslaskievar12' => $results[1]['licznik'],
		'opolskievar13' => $results[8]['licznik'],
		'slaskievar14' => $results[12]['licznik'],
		'malopolskievar15' => $results[6]['licznik'],
		'podkarpackievar16' => $results[9]['licznik']
		*/
	));


?>
<div class="<?php echo $extension_name . $header_class; ?>">
	<table border="0" cellspacing="0" width="100%">
	<tr>
		<td style="padding: 25px">
			<?php if ($lang == 'pl'): ?>
			<a href="https://pdf.polska.travel/najlepsze_produkty_turystyczne_pl">
			<?php else: ?>
			<a href="https://pdf.polska.travel/best_2008-2015_en">
			<?php endif; ?>
			<img src="images/stories/produktowy/okladka_<?php echo ($lang == 'pl')? 'pl' : 'en'; ?>-200.jpg" />
			</a>
		</td>
		<td>
			<object type="application/x-shockwave-flash" id="embed-polish-flash-map" data="<?php echo $flashName;?>" width="<?php echo $flashWidth;?>" height="<?php echo $flashHeight;?>" align="middle">
                <param name="movie" value="<?php echo $flashName;?>" />
                <param name="quality" value="high" />
                <param name="play" value="true" />
                <param name="loop" value="true" />
                <param name="scale" value="showall" />
                <param name="devicefont" value="false" />
                <param name="salign" value="" />
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="menu" value="false"/>
                <param name="wmode" value="transparent"/>
				<param name="flashvars" value="<?php echo $flashVars;?>"/>
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="<?php echo $flashName;?>" width="<?php echo $flashWidth;?>" height="<?php echo $flashHeight;?>">
                    <param name="movie" value="<?php echo $flashName;?>" />
                    <param name="quality" value="high" />
                    <param name="play" value="true" />
                    <param name="loop" value="true" />
                    <param name="scale" value="showall" />
                    <param name="devicefont" value="false" />
                    <param name="salign" value="" />
                    <param name="allowScriptAccess" value="sameDomain" />
                    <param name="menu" value="false"/>
                    <param name="wmode" value="transparent"/>
                <!--<![endif]-->
                    <a href="https://www.adobe.com/go/getflash">
                        <img src="https://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Pobierz odtwarzacz Adobe Flash Player" />
                    </a>
                <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
            </object>
		</td>
		<!--<td width="200">-->
		<td>
	<form action="<?php echo JRoute::_('index.php');?>" method="GET">
	<input type="hidden" name="option" value="com_gk" />
	<input type="hidden" name="catid" value="<?php echo ($lang == 'pl')? 19 : 23; ?>" />
	<input type="text" name="title" id="searchTitle" value="<?php if ($title) echo urldecode($title); ?>"/>
	<select name="region" id="selectRegion" class="product-search-region">
	<?php
		foreach ($regions as $index => $value) {
			if ($index == $region) {
				echo "<option value='$index' selected>$value</option>";
			} else {
				echo "<option value='$index'>$value</option>";
			}
		}
	?>
	</select>
	<select name="type" id="selectType" class="product-search-type">
	<?php
		foreach ($types as $index => $value) {
			if ($index == $type) {
				echo "<option value='$index' selected>$value</option>";
			} else {
				echo "<option value='$index'>$value</option>";
			}
		}
	?>
	</select>
	<select name="year" id="selectYear" class="product-search-date">
		<!-- <option value="0">(wybierz rok)</option> -->
		<option value="0">(<?php echo ($lang == 'pl')? 'rok' : 'year';?>)</option>
	<?php
		for ($value = 2016; $value > 2002; $value--) {
			if ($value == $year) {
				echo "<option value='$value' selected>$value</option>";
			} else {
				echo "<option value='$value'>$value</option>";
			}
		}
	?>
	</select>
	<input type="submit" class="submit" id="submitSzukaj" value="<?php echo ($lang == 'pl')? 'Szukaj' : 'Search'; ?>" />
	</form>
		</td>
	</tr>
	</table>
</div>
