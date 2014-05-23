<?php 
	var_dump($_GET);
	var_dump($_POST);
?>
<form method="POST">
    <p>
    	<label>Username:  <input id="username" name="crazyman90" type="text" placeholder="Username Here" autofocus></label>
    </p>
    <p>
        <label for = "Password">Password: </label>
        	<input id="password" name="codeup" type="password" placeholder="Password Here"></label>
    </p>
    <p>
        <button type="submit"> Login </button>
    </p>
</form>