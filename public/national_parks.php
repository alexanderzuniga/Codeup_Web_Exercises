<!DOCTYPE html>
<html>
<head>
	<title>National Parks</title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>
<div id="container">
	<? 
	function getOffset() {
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		return ($page - 1) * 4;
	}
	$dbc = new PDO('mysql:host=127.0.0.1;dbname=national_park_db', 'root', '');

	$dbc-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$query = 'SELECT * FROM national_parks LIMIT 4 OFFSET ' .  getOffset();

	$parks = $dbc->query($query)->fetchAll(PDO::FETCH_ASSOC);

	$count = $dbc-> query('SELECT count(*) FROM national_parks')->fetchColumn();

	$numPages = ceil($count / 4);

	$page = isset($_GET['page']) ? $_GET['page'] : 1;

	$nextPage = $page + 1;

	$prevPage = $page - 1;

	if(!empty($_POST)) {
		try {
			foreach ($_POST as $key => $value) {
				if ($value == ''){
					throw new Exception("Please insert item to $key ", 1);
				}
			} 

			$entries[] = $_POST;
			var_dump($entries);

			$stmt = $dbc->prepare('INSERT INTO national_parks (name, location, date_established, area_in_acres, description) 
			    VALUES (:name, :location, :date_established, :area_in_acres, :description)');

			foreach ($entries as $item) {
			    $stmt->bindValue(':name', $item['name'], PDO::PARAM_STR);
			    $stmt->bindValue(':location',  $item['state'],  PDO::PARAM_STR);
			    $stmt->bindValue(':date_established',  $item['date'],  PDO::PARAM_STR);
			    $stmt->bindValue(':area_in_acres',  $item['area'],  PDO::PARAM_INT);
			    $stmt->bindValue(':description',  $item['description'],  PDO::PARAM_STR);

			    $stmt->execute();
			}

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
?>

<table>
	<tr>
		<th>| Name  </th>
		<th>| Location  </th>
		<th>| Date Established  </th>
		<th>| Area in Acres  </th>
		<th>| Description  </th>
	</tr>	
	<tr>	
	<? foreach ($parks as $park) : ?> 
		<td> <?= $park['name'] ?> 			  </td> 
		<td> <?= $park['location'] ?> 		  </td> 
		<td> <?= $park['date_established'] ?> </td> 
		<td> <?= $park['area_in_acres'] ?>    </td>
		<td> <?= $park['description'] ?>      </td> 
	</tr>
<? endforeach; ?>	
</table>
<? if ($prevPage > 0) : ?>
<button><a href= "?page=<?=$prevPage; ?>"> Previous </a></button>
<? endif ?>
<? if ($nextPage <= $numPages) : ?>
<button><a href= "?page=<?=$nextPage; ?>"> Next </a></button>
<?endif?>
<form method= "POST"> 
	<p>
		<label> Name <input id="name" name="name" type="text" autofocus></label>
	</p>
	<p>
		<label> State <select name="state">
			<option value="AL">Alabama</option>
				<option value="Alaska">Alaska</option>
				<option value="Arizona">Arizona</option>
				<option value="Arkansas">Arkansas</option>
				<option value="California">California</option>
				<option value="Colorado">Colorado</option>
				<option value="Connecticut">Connecticut</option>
				<option value="Delaware">Delaware</option>
				<option value="DC">District Of Columbia</option>
				<option value="Florida">Florida</option>
				<option value="Georgia">Georgia</option>
				<option value="Hawaii">Hawaii</option>
				<option value="Idaho">Idaho</option>
				<option value="Illinois">Illinois</option>
				<option value="Indiana">Indiana</option>
				<option value="Iowa">Iowa</option>
				<option value="Kansas">Kansas</option>
				<option value="Kentucky">Kentucky</option>
				<option value="Louisiana">Louisiana</option>
				<option value="Maine">Maine</option>
				<option value="Maryland">Maryland</option>
				<option value="Massachusetts">Massachusetts</option>
				<option value="Michigan">Michigan</option>
				<option value="Minnesota">Minnesota</option>
				<option value="Mississippi">Mississippi</option>
				<option value="Missouri">Missouri</option>
				<option value="Montana">Montana</option>
				<option value="Nebraska">Nebraska</option>
				<option value="Nevada">Nevada</option>
				<option value="New Hampshire">New Hampshire</option>
				<option value="New Jersey">New Jersey</option>
				<option value="New Mexico">New Mexico</option>
				<option value="New York">New York</option>
				<option value="North Carolina">North Carolina</option>
				<option value="North Dakota">North Dakota</option>
				<option value="Ohio">Ohio</option>
				<option value="Oklahoma">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="Oregon">Pennsylvania</option>
				<option value="Rhode Island">Rhode Island</option>
				<option value="South Carolina">South Carolina</option>
				<option value="South Dakota">South Dakota</option>
				<option value="Tennessee">Tennessee</option>
				<option value="Texas">Texas</option>
				<option value="Utah">Utah</option>
				<option value="Vermont">Vermont</option>
				<option value="Virginia">Virginia</option>
				<option value="Washington">Washington</option>
				<option value="West Virginia">West Virginia</option>
				<option value="Wisconsin">Wisconsin</option>
				<option value="Wyoming">Wyoming</option>
			</select>
		</label>
	</p>
	<p>
		<label> Date Established <input id="date" name="date" type="date" placeholder= "YYYY-MM-DD"></label>
	</p>
	<p>
		<label> Area in Acres <input id="area" name="area" type="text" autofocus></label>
	</p>
	<p>
		<label> Description <input id="description" name="description" type="text" autofocus></label>
	</p>
	<p>
		<button type="submit"> Submit </button>
	</p>
</form>
</div>
</body>
</html>