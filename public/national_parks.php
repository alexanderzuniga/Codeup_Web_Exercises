<!DOCTYPE html>
<html>
<head>
	<? 



	?>
	<title>National Parks</title>
</head>
<body>
	<? 
	$dbc = new PDO('mysql:host=127.0.0.1;dbname=national_park_db', 'root', '');
	$stmt = $dbc->query('SELECT * FROM national_park');	
	$array = $stmt->fetchAll(PDO::FETCH_ASSOC);
	

	?>
	<table>
		<tr>
			<th>Name</th>
			<th>Location</th>
			<th>Date Est.</th>
			<th>Area in Acres</th>
		</tr>	
		<tr>	
<? foreach ($array as $key => $value) : ?> 
		<td> <?= $value['name'] ?></td> 
		</tr>
<? endforeach; ?>
		
</table>
</body>
</html>