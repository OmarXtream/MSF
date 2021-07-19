<?php

include '../inc/db-connection.php';
$db = $database->openConnection();

if (isset($_POST['del_ts'])){
	$id = (int)$_POST['id'];
  $error = array(); // تعيين جدول لجمع الأخطاء

    if (isset($_SESSION['rms']) and $_SESSION['rms'] >= microtime(true)) {
echo 'wait';
die;
}
 
$user = $_SESSION['user'];
$hisrank = $_SESSION['rank'];

    $response = $db->prepare('SELECT * FROM member_tasks WHERE  task_id = :cb');
    $response->bindValue(':cb',$id,PDO::PARAM_INT);
    $response->execute();
    $checks = $response->fetchAll();
    $response->CloseCursor();
if(!$response->rowCount() > 0 )
{

echo 'error';
die;
}


if(!$hisrank >= 3){
echo 'info';
die;
}


    $stmt = $db->prepare('DELETE FROM member_tasks WHERE task_id = :cb');
    $stmt->bindValue(':cb',$id,PDO::PARAM_INT);
    $stmt->execute();
    $stmt->CloseCursor(); 
	$_SESSION['rms'] = microtime(true)+5;

echo 'done';
die;
}




?>








