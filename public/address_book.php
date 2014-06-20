<?php
//var_dump($_POST);
$new_address = [];
$errorMessage = '';
require_once ('classes/address_data_store.php');

$ads = new AddressDataStore('address_book.csv');
$address_book = $ads->read_csv(); 
class CustomException extends Exception {}

                                 			// Empty Field check. 
if (!empty($_POST['name']) && 
	!empty($_POST['address']) && 
	!empty($_POST['city']) && 
	!empty($_POST['state']) && 
	!empty($_POST['zip'])) {

	$new_address ['name'] = $_POST['name'];
$new_address ['address'] = $_POST['address'];
$new_address ['city'] = $_POST['city'];
$new_address ['state'] = $_POST['state'];
$new_address ['zip'] = $_POST['zip'];
$new_address ['phone'] = $_POST['phone'];
											// Adding new_address values to the address book
array_push($address_book, $new_address);
$ads->write_csv($address_book);
} 
else 
{
	foreach ($_POST as $key => $value) {	
		try
		{
			if (strlen($value) > 150) 
			{
				throw new CustomException ("<script type='text/javascript'>alert('Input must be less than 150 charachters');</script>");	
			}
			elseif (empty($value) && ($key != 'phone')) 
			{
				throw new Exception ("**Must enter " . ucfirst($key) . "**" . PHP_EOL);
			}
		}
		catch (CustomException $ce) 
		{
			echo  $ce->getMessage();
			$msg = $ce-> getMessage() . PHP_EOL;
		} 
		catch (Exception $e) {
			echo "Extention:" . $e->getMessage() . PHP_EOL;
			$msg = $e-> getMessage() . PHP_EOL;
		}
	} 
}
//Removing a Contact
if (isset($_GET['removeIndex'])) 
{
	$removeIndex = $_GET['removeIndex'];
	unset($address_book[$removeIndex]);
	$ads->write_csv($address_book);
	header('Location: /address_book.php');
	exit;
} 
if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {

	if ($_FILES['file1']["type"] != "text/csv") {
		echo "ERROR: file must be in text/csv!";
	} else {

		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
		$filename = basename($_FILES['file1']['name']);

		$saved_filename = $upload_dir . $uploadFilename;
		move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);

		$address_uploaded = $upload->read_csv();
		$address_book = array_merge($address_book, $address_uploaded);
		$storeData->write_csv($address_book);
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Address Book</title>
</head>
<body>
	<h2>Address Book</h2>
	<hr>
	<table border = "1">
		<tr><th> Name 	  </th>
			<th> Street   </th>
			<th> City 	  </th>
			<th> State 	  </th>
			<th> Zip Code </th>
			<th> Phone 	  </th>
		</tr>
		<? foreach($address_book as $key => $fields) : ?>
		<tr>
			<? foreach($fields as $value) : ?>
			<td> <?= htmlspecialchars(strip_tags($value)); ?> </td> 
		<? endforeach ;?>
		<td> <a href= "?removeIndex=<?= $key ?>"> Remove Contact </a><br>
		</tr>
	<? endforeach ?>
</table>	
<?= $errorMessage ?>
<form method = "POST">
	<p>
		<label> Name <input id="name" name="name" type="text" autofocus></label>
	</p>
	<p>
		<label> Address <input id="address" name="address" type="text"></label>
	</p>
	<p>
		<label> City <input id="city" name="city" type="text"></label>
	</p>
	<p>
		<label> State <select name="state">
			<option value="AL">AL</option>
			<option value="AK">AK</option>
			<option value="AZ">AZ</option>
			<option value="AR">AR</option>
			<option value="CA">CA</option>
			<option value="CO">CO</option>
			<option value="CT">CT</option>
			<option value="DE">DE</option>
			<option value="DC">DC</option>
			<option value="FL">FL</option>
			<option value="GA">GA</option>
			<option value="HI">HI</option>
			<option value="ID">ID</option>
			<option value="IL">IL</option>
			<option value="IN">IN</option>
			<option value="IA">IA</option>
			<option value="KS">KS</option>
			<option value="KY">KY</option>
			<option value="LA">LA</option>
			<option value="ME">ME</option>
			<option value="MD">MD</option>
			<option value="MA">MA</option>
			<option value="MI">MI</option>
			<option value="MN">MN</option>
			<option value="MS">MS</option>
			<option value="MO">MO</option>
			<option value="MT">MT</option>
			<option value="NE">NE</option>
			<option value="NV">NV</option>
			<option value="NH">NH</option>
			<option value="NJ">NJ</option>
			<option value="NM">NM</option>
			<option value="NY">NY</option>
			<option value="NC">NC</option>
			<option value="ND">ND</option>
			<option value="OH">OH</option>
			<option value="OK">OK</option>
			<option value="OR">OR</option>
			<option value="PA">PA</option>
			<option value="RI">RI</option>
			<option value="SC">SC</option>
			<option value="SD">SD</option>
			<option value="TN">TN</option>
			<option value="TX">TX</option>
			<option value="UT">UT</option>
			<option value="VT">VT</option>
			<option value="VA">VA</option>
			<option value="WA">WA</option>
			<option value="WV">WV</option>
			<option value="WI">WI</option>
			<option value="WY">WY</option>
		</select></label>
	</p>
	<p>
		<label> Zip Code <input id="zip" name="zip" type="text"></label>
	</p>
	<p>
		<label> Phone Number <input id="phone" name="phone" type="text"></label>
	</p>
	<p>
		<button type="submit"> Save </button>
	</p>
	<? if (isset($saved_filename)) : ?>
	<?=  "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>"; ?>
<? endif; ?>
<form method="POST" enctype="multipart/form-data" >
	<p>
		<label for="file1">File to upload: </label>
		<input type="file" id="file1" name="file1">
	</p>

	<p><input type="submit" value="Upload"></p>

</form>	
</body>
</html>