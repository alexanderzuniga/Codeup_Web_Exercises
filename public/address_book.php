<?
//var_dump($_POST);
$errorMessage = '';

class AddressDataStore {

    public $filename = 'data/address_book.csv';

    public function read_address_book()
    {
        // Code to read file $this->filename
	       $entries = [];
		if (is_readable($this->filename) && (filesize($this->filename) > 0)) {
			$handle = fopen($this->filename, 'r');
			while (!feof($handle)){
				$row = fgetcsv($handle);
				if (is_array($row)) {	
				$entries[] = $row;
		  		}
			}
			fclose($handle);
		} 
		return $entries;
    }

    public function write_address_book($addresses_array) 
    {
        // Code to write $addresses_array to file $this->filename
	       if (is_writable($this->filename)) {
			$handle = fopen($this->filename, 'w');
			foreach ($addresses_array as $fields) {
				if (isset($fields)){
					fputcsv($handle, $fields);
				} else {
					echo "Enter a new contact.\n";
				}
			} fclose($handle);	
		} 
    }
}

$ADS = new AddressDataStore();
$address_book = $ADS->read_address_book(); 



if (isset($_GET))

$new_address = [];
                                 			// Empty Field check. 
if (!empty($_POST['name']) && 
	!empty($_POST['address']) && 
	!empty($_POST['city']) && 
	!empty($_POST['state']) && 
	!empty($_POST['zip_code'])) {

	$new_address ['name'] = $_POST['name'];
	$new_address ['address'] = $_POST['address'];
	$new_address ['city'] = $_POST['city'];
	$new_address ['state'] = $_POST['state'];
	$new_address ['zip_code'] = $_POST['zip_code'];
	$new_address ['phone'] = $_POST['phone'];

	array_push($address_book, $new_address);
	$ADS->write_address_book($address_book);
} else {
	foreach ($_POST as $key => $value) {
		if (empty($value) && ($key != 'phone')) {
			$errorMessage .= "<p> **Must enter " . ucfirst($key) . "**<p>";
		}
	}
}
//Removing a Contact
if (isset($_GET['removeIndex'])) {
	$removeIndex = $_GET['removeIndex'];
	unset($address_book[$removeIndex]);
	$ADS->write_address_book($address_book);
	header('Location: /address_book.php');
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
	<tr><th>Name</th>
		<th>Street</th>
		<th>City</th>
		<th>State</th>
		<th>Zip Code</th>
		<th>Phone</th>
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
    	<label> Zip Code <input id="zip_code" name="zip_code" type="text"></label>
    </p>
    <p>
    	<label> Phone Number <input id="phone" name="phone" type="text"></label>
    </p>
    <p>
        <button type="submit"> Save </button>
    </p>	
</body>
</html>