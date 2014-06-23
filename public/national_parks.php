<!DOCTYPE html>
<html>
<head>
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
			<th>Date Established</th>
			<th>Area in Acres</th>
		</tr>	
		<tr>	
<? foreach ($array as $key => $value) : ?> 
		<td> <?= $value['name'] ?></td> 
		<td> <?= $value['location'] ?></td> 
		<td> <?= $value['date_established'] ?></td> 
		<td> <?= $value['area_in_acres'] ?></td> 


		</tr>
<? endforeach; ?>
		
</table>
</body>
</html>