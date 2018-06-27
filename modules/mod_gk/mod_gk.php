<?php
defined('_JEXEC') or die;

/* special objects */
$db			= JFactory::getDbo();				/* database */
$app		= JFactory::getApplication();		/* JApp */
$input	= $app->input;

$document = JFactory::getDocument();
$document->addStyleSheet(DS.'modules'.DS.'mod_gk'.DS.'mod_gk.css');

$title	= $_GET['title'] ?? false; //$input->get('title');
$region	= $input->getInt('region');
$year 	= $input->getInt('year');
$type 	= $input->getInt('type');
$lang		= (JFactory::getLanguage()->getTag() == 'pl-PL'? 'pl' : 'en');

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

?>
<div class="mod_gk">
	<p class="mod_gk_title">
	<?php if ($lang == 'pl'): ?>
	Wyrusz z nami w niezwykłą podróż po Polsce, podążaj śladami certyfikowanych produktów turystycznych! Znajdź produkt turystyczny:
	<?php else: ?>
	Join us on a remarkable journey through Poland, follow certified tourism products! Find a tourist product:
	<?php endif; ?>
	</p>
	<table border="0" cellspacing="0" width="100%">
	<tr>
		<td>
			<?php if ($lang == 'pl'): ?>
			<a href="https://pdf.polska.travel/najlepsze_produkty_turystyczne_pl">
			<?php else: ?>
			<a href="https://pdf.polska.travel/best_2008-2015_en">
			<?php endif; ?>
			<img src="images/stories/produktowy/okladka_<?php echo ($lang == 'pl')? 'pl' : 'en'; ?>-200.jpg" />
			</a>
		</td>
		<td>
	<form action="<?php echo JRoute::_('index.php');?>" method="GET">
	<input type="hidden" name="option" value="com_gk" />
	<input type="hidden" name="catid" value="<?php echo ($lang == 'pl')? 19 : 23; ?>" />
	<input type="text" name="title" placeholder="<?php echo ($lang == 'pl')? '(Nazwa)' : '(Name)'; ?>" value="<?php if ($title) echo urldecode($title); ?>"/>
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
		for ($value = 2017; $value > 2002; $value--) {
			if ($value == $year) {
				echo "<option value='$value' selected>$value</option>";
			} else {
				echo "<option value='$value'>$value</option>";
			}
		}
	?>
	</select>
	<input type="submit" class="submit" value="<?php echo ($lang == 'pl')? 'Szukaj' : 'Search'; ?>" />
	</form>
		</td>
	</tr>
	</table>
</div>
