<!DOCTYPE html>
<html>
<head>
	<title>National Parks</title>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>
	<? 
	function getOffset() {
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		return ($page - 1) * 4;
	}
	$dbc = new PDO('mysql:host=127.0.0.1;dbname=national_park_db', 'root', '');

	$dbc-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$query = 'SELECT * FROM national_park LIMIT 4 OFFSET ' .  getOffset();

	$parks = $dbc->query($query)->fetchAll(PDO::FETCH_ASSOC);

	$count = $dbc-> query('SELECT count(*) FROM national_park')->fetchColumn();

	$numPages = ceil($count / 4);

	$page = isset($_GET['page']) ? $_GET['page'] : 1;

	$nextPage = $page + 1;

	$prevPage = $page - 1;
?>
<div #table>
<table>
	<tr>
		<th>Name</th>
		<th>Location</th>
		<th>Date Established</th>
		<th>Area in Acres</th>
	</tr>	
	<tr>	
	<? foreach ($parks as $park) : ?> 
		<td> <?= $park['name'] ?> 			  </td> 
		<td> <?= $park['location'] ?> 		  </td> 
		<td> <?= $park['date_established'] ?> </td> 
		<td> <?= $park['area_in_acres'] ?>    </td> 
	</tr>
<? endforeach; ?>	
</table>
<div>
<? if ($prevPage > 0) : ?>
<button><a href= "?page=<?=$prevPage; ?>"> Previous </button>
<? endif ?>
<? if ($nextPage < 4) : ?>
<button><a href= "?page=<?=$nextPage; ?>"> Next </button>
<?endif?>
</body>
</html>