<?php

include '../inc/db-connection.php';

$db = $database->openConnection();

if (isset($_POST['del_mem'])){
	$id = (int)$_POST['id'];

    if (isset($_SESSION['rvm']) and $_SESSION['rvm'] >= microtime(true)) {
$result = 'wait';

}else{ 
$user = $_SESSION['user'];
$hisrank = $_SESSION['rank'];

    $response = $db->prepare('SELECT * FROM site_members WHERE  user_id = :cb');
    $response->bindValue(':cb',$id,PDO::PARAM_INT);
    $response->execute();
    $checks = $response->fetchAll();
    $response->CloseCursor();
if($response->rowCount() > 0 )
{
foreach($checks as $check){

$uid = $check['user_id'];
$rank = $check['user_admin'];
$hisname = $check['user_name'];

}
}else{
$result = 'error';
}


if($hisrank > $rank and $hisrank > 3){

    $stmt = $db->prepare('DELETE FROM site_members WHERE user_id = :cb');
    $stmt->bindValue(':cb',$id,PDO::PARAM_INT);
    $stmt->execute();
    $stmt->CloseCursor(); 

$result = 'done';
	$_SESSION['rvm'] = microtime(true)+5;
}else{
$result = 'info';
}


}
echo $result;

}


?>