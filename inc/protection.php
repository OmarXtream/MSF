<?php

if(count(get_included_files()) == 1){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

if(!isset($_SESSION['user']) or !isset($_SESSION['id'])){
echo'<meta http-equiv="refresh" content="0; url=logout.php" />';

die;
}





?> 