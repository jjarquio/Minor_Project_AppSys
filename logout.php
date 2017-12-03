<?php 

setcookie('datas', '', time() - (86400 * 30));
setcookie('datar', '', time() - (86400 * 30));
header("location:/Minor_Project_AppSys");

?>
