<?php

require_once("includes/header.php");
require_once("includes/loginFunctions.php");

?>
<div id="login-form">
	<img src="src/rasilogo.png" alt="rasilogo">
	<?php displayerror('SIGNERROR'); ?>
    <form method="post">
    <div><input type="text" name="userid" placeholder="User ID">
    </div>
    <div><input type="password" name="passcode" placeholder="Passcode">
    </div>
    <div><input type="submit" name="login" value="Login">
    </div>
    </form>
</div>

<?php require_once("includes/footer.php"); ?>
