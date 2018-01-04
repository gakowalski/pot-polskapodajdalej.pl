<?php defined('_JEXEC') or die;

$app	= JFactory::getApplication();
$db		= JFactory::getDbo();
$input	= $app->input;

$document = JFactory::getDocument();
$document->addStyleSheet('administrator'.DS.'components'.DS.'com_gk'.DS.DS.'com_gk.css');

$task	= $input->getInt('task', 1);

function mysql_escape($inp) {
	return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
}

/*
	tasks enumeration:
		0	About/Configuration page
		1	Add product form
		2	Add product from POST request
		3	List all titles and aliases
		4 Update SEF links in Simple Custom Router
*/

switch ($task) {
	/* About/Configuration page */
	case 0:
?><h1><img src="http://www.vip-consult.co.uk/sites/default/files/styles/40-40-s/public/shared_images/green-exclamation.png">
Brak możliwości konfiguracji wyszukiwania w tej wersji komponentu.</h1><?php
		break;

	/* Add product from POST request
	CAUTION: This case is purposefuly placed before case 1! */
	case 2:
		if (isset($_POST['title'])
			& isset($_POST['abstract'])
			& isset($_POST['body'])
			& isset($_POST['address'])
			& isset($_POST['region'])
			/* & isset($_POST['type']) // juz niewymagane */
			& isset($_POST['year'])
			& isset($_POST['catid'])) {

			$title 		= mysql_escape(filter_var(trim(urldecode($_POST['title'])), 			FILTER_SANITIZE_STRING));
			$abstract 	= mysql_escape(strtr(filter_var(trim(urldecode($_POST['abstract'])), 	FILTER_SANITIZE_STRING), array("\r\n" => '</p><p>')));
			$body 		= mysql_escape(strtr(filter_var(trim(urldecode($_POST['body'])), 		FILTER_SANITIZE_STRING), array("\r\n" => '</p><p>')));
			$address	= mysql_escape(strtr(filter_var(trim(urldecode($_POST['address'])), 	FILTER_SANITIZE_STRING), array("\r\n" => '</p><p>')));
			$region 	= $input->getInt('region', 0);
			$types 		= $input->get('type', array(), 'ARRAY');
			$year 		= $input->getInt('year', date('Y'));
			$catid 		= $input->getInt('catid', 19);

			$langCode		= $catid == 19 ? 'pl-PL' : 'en-GB';

			$extraFields	= array();
			if (isset($_POST['copyAttribs']) & isset($_POST['sourceId'])) {
				$sourceId = $input->getInt('sourceId', 0);

				$query = "SELECT extra_fields FROM `j25_k2_items` WHERE id = $sourceId";
				$db->setQuery($query);
				$extraFields = $db->loadResult();
			} else {
				foreach ($types as $type) {
					$extraFields[]	= json_encode(array('id' => '1', 'value' => $type));
				}
				$extraFields[] = json_encode(array('id' => '2', 'value' => "$year"));
				$extraFields[] = json_encode(array('id' => '3', 'value' => "$region"));
				$extraFields	= '[' . implode(',', $extraFields) . ']';
			}

			$slug = JFilterOutput::stringURLSafe($title);

			$nextId = $input->getInt('newId', 0);

			if ($nextId === 0) {
				$query = "SELECT MAX(id) FROM `j25_k2_items` WHERE `catid` = $catid AND `catid` IN (19, 23)";
				$db->setQuery($query);
				$nextId = $db->loadResult() + 1;
			}

			/* TO DO some checks for catid value and return value of the query*/

			$query =
			"INSERT INTO j25_k2_items
				(
				`id` ,
				`title` ,
				`alias` ,
				`catid` ,
				`published` ,
				`introtext` ,
				`fulltext` ,
				`video` ,
				gallery ,
				extra_fields ,
				extra_fields_search ,
				created ,
				created_by ,
				created_by_alias ,
				checked_out ,
				checked_out_time ,
				modified ,
				modified_by ,
				publish_up ,
				publish_down ,
				trash ,
				access ,
				ordering ,
				featured ,
				featured_ordering ,
				image_caption ,
				image_credits ,
				video_caption ,
				video_credits ,
				hits ,
				params ,
				metadesc ,
				metadata ,
				metakey ,
				plugins ,
				language )

				VALUES
				(
				$nextId,
				'$title',
				'$slug',
				$catid,
				1,
				'<p>$abstract</p>',
				'<table border=\"0\" id=\"product\"><tr><td id=\"fulltext\"><p>$body</p></td><td id=\"address\"><p>$address</p></td></tr></table>',
				NULL,
				NULL,
				'$extraFields',
				'',
				NOW(),
				0,
				'POT',
				0,
				0,
				NOW(),
				0,
				NOW(),
				0,
				0,
				1,
				$nextId,
				0,
				$nextId,
				'',
				'',
				'',
				'',
				0,
				'',
				'',
				'',
				'',
				'',
				'$langCode')";
				//echo $query;
				$db->setQuery($query);
				$db->query();
				echo "<h1>Database query for $title has been generated and executed.</h1>";
		} else {
			echo '<h1>Incomplete data, cannot generate correct SQL query.</h1>';
		}
		//break;

	/* Add product from */
	case 1:
	default:
		$types = array();
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

		$regions = array();
		//$regions[0] = '(województwo)';
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
?>
<form class="com_gk" action="?option=com_gk&task=2" method="post">
<div>
	<fieldset>
		<legend>Text content</legend>
		<label for="textTitle">Title</label>
		<input type="text" name="title" id="textTitle" required>
		<label for="textAbstract">Abstract</label>
		<textarea name="abstract" id="textAbstract" required></textarea>
		<label for="textBody">Body</label>
		<textarea name="body" id="textBody" required></textarea>
		<label for="textAddress">Address</label>
		<textarea name="address" id="textAddress" required></textarea>
	</fieldset>
</div>
<div>
	<fieldset>
		<legend>Attributes</legend>
		<label for="selectRegion">Region</label>
		<select name="region" id="selectRegion">
		<?php
			foreach ($regions as $index => $value) {
				echo "<option value='$index'>$value</option>";
			}
		?>
		</select>
		<label for="selectType">Type</label>
		<select name="type[]" id="selectType" multiple size="<?php echo count($types); ?>">
		<?php
			foreach ($types as $index => $value) {
				echo "<option value='$index'>$value</option>";
			}
		?>
		</select>
		<label for="selectYear">Year</label>
		<select name="year" id="selectYear">
		<?php
			$thisYear = date('Y');
			for ($value = $thisYear; $value > 2002; $value--) {
				if ($value == $thisYear) {
					echo "<option value='$value' selected>$value</option>";
				} else {
					echo "<option value='$value'>$value</option>";
				}
			}
		?>
		</select>
		<label for="selectLang">Language</label>
		<select name="catid" id="selectLang">
			<option value="19" selected>Polski</option>
			<option value="23">English</option>
		</select>
	</fieldset>
</div>
<div>
	<fieldset>
		<legend>For special purposes</legend>
		<label for="newId">New ID</label>
		<input type="text" name="newId" id="newId">
		<p>(Unwritten rule: English ID = Polish ID + 300)</p>
		<label for="copyAttribs"><input type="checkbox" name="copyAttribs" id="copyAttribs"> Copy attributes (except language) from</label>
		<label for="sourceId">Source ID</label>
		<input type="text" name="sourceId" id="sourceId">
	</fieldset>
	<fieldset>
		<legend>Actions</legend>
		<input type="Submit" value="Add">
	</fieldset>
</div>
<div style="clear:both"></div>
</form>
<?php
	break;

	/* List all titles and aliases, resolve conflicts */
	case 3:
		if (isset($_GET['id']) & isset($_GET['slug'])) {
			$id = $input->getInt('id', 0);
			$slug = mysql_escape(filter_var(trim(urldecode($_GET['slug'])), FILTER_SANITIZE_STRING));

			if ($id != 0) {
				$query = "update j25_k2_items set alias = '{$slug}', modified = now() where id = $id";
				$db->setQuery($query);
				$db->query();
				echo "<h1>Database query for $id has been generated and executed.</h1>";
			} else {
				echo '<h1>Incomplete data, cannot generate correct SQL query.</h1>';
			}
		}
?>
		<form action="?option=com_gk&task=3" method="get">
			<label for="newId">ID</label>
				<input type="text" name="id" id="id" required>
			<label for="textAlias">New alias</label>
				<input type="text" name="textAlias" id="textAlias" required>
			<input type="Submit" value="Change">
		</form>
		<hr>
		<?php

		$query = 'select group_concat(id) as ids, alias from j25_k2_items group by alias having count(*) > 1';
		$db->setQuery($query);
		$results = $db->loadAssocList('ids');

		echo '<table><tr><th>Conflicting IDs</th><th>Alias</th></tr>';

		foreach ($results as $row) {
			echo "<tr><td>{$row['ids']}</td><td>{$row['alias']}</td></td></tr>";
		}

		echo '</table>';
		echo '<hr>';

		$query = 'select id, title, alias from j25_k2_items order by modified asc';
		$db->setQuery($query);
		$results = $db->loadAssocList('id');

		$superQuery = '';

		echo '<table><tr><th>ID</th><th>Title</th><th>Alias</th><th>Proposal</th><th>Action</th></tr>';

		foreach ($results as $row) {
			$slug = JFilterOutput::stringURLSafe($row['title']);
			echo "<tr><td>{$row['id']}</td><td>{$row['title']}</td><td>{$row['alias']}</td><td>{$slug}</td><td><a href='?option=com_gk&task=3&id={$row['id']}&slug={$slug}'>Accept proposal</a></td></tr>";
			$superQuery .= "update j25_k2_items set alias = '{$slug}', modified = now() where id = {$row['id']};<br>";
		}

		echo '</table>';
		echo '<hr>';
		echo $superQuery;
	break;

	/* 4 Update SEF links in Simple Custom Router */
	case 4:
		if (isset($_GET['id']) & isset($_GET['category']) & isset($_GET['slug'])) {
			$id = $input->getInt('id', 0);
			$category = mysql_escape(filter_var(trim(urldecode($_GET['category'])), FILTER_SANITIZE_STRING));
			$slug = mysql_escape(filter_var(trim(urldecode($_GET['slug'])), FILTER_SANITIZE_STRING));

			$category .= '/';

			if ($id != 0) {
				$query = "INSERT INTO j25_simplecustomrouter (id, path, query, itemId) VALUES({$id}, '{$category}{$slug}', 'option=com_k2&view=item&layout=item&id={$id}', 0)
				ON DUPLICATE KEY UPDATE path=VALUES(path), query=VALUES(query)";
				$db->setQuery($query);
				$db->query();
				echo "<h1>Database query for $id has been generated and executed.</h1>";
			} else {
				echo '<h1>Incomplete data, cannot generate correct SQL query.</h1>';
			}
		}

		$query = 'select group_concat(id) as ids, path from j25_simplecustomrouter group by path having count(*) > 1';
		$db->setQuery($query);
		$results = $db->loadAssocList('ids');

		echo '<table><tr><th>Conflicting IDs</th><th>Alias</th></tr>';

		foreach ($results as $row) {
			echo "<tr><td>{$row['ids']}</td><td>{$row['path']}</td></td></tr>";
		}

		echo '</table>';
		echo '<hr>';

		$query = "
		select
		  k2.id as 'id',
		  k2.catid as 'category_id',
		  k2.title as 'title',
		  rt.path as 'path',
		  rt.query as 'query',
		  k2.alias as 'alias'
		from
		  j25_k2_items as k2
		left join
		  j25_simplecustomrouter as rt
		on (k2.id = rt.id)
		where
		  k2.catid in (19, 23)
		order by
		  rt.path asc, k2.catid asc
		";

		$db->setQuery($query);
		$results = $db->loadAssocList('id');

		$superQuery = '';

		echo '<table><tr><th>ID</th><th>Cat ID</th><th>Title</th><th>Path</th><th>Query</th><th>Proposed Path</th><th>Proposed Query</th><th>Action</th></tr>';

		foreach ($results as $row) {
			if ($row['category_id'] == 19) {
				$segment = 'certyfikowane-produkty-turystyczne';
			} else {
				$segment = 'certified-tourist-attractions';
			}
			echo "<tr><td>{$row['id']}</td><td>{$row['category_id']}</td><td>{$row['title']}</td><td>{$row['path']}</td><td>{$row['query']}</td><td>{$segment}/{$row['alias']}</td><td>option=com_k2&view=item&layout=item&id={$row['id']}</td><td><a href='?option=com_gk&task=4&id={$row['id']}&category={$segment}&slug={$row['alias']}'>Accept proposal</a></td></tr>";
			$superQuery .= "
				INSERT INTO j25_simplecustomrouter (id, path, query, itemId) VALUES({$row['id']}, '{$segment}/{$row['alias']}', 'option=com_k2&view=item&layout=item&id={$row['id']}', 0)
				ON DUPLICATE KEY UPDATE path=VALUES(path), query=VALUES(query);<br>";
		}

		echo '</table>';
		echo '<hr>';
		echo $superQuery;
	break;
}

?>
<hr>
<p align="right"><a href="mailto:grzegorz.kowalski@pot.gov.pl">Grzegorz Kowalski</a></p>
