<?php
include '../inc/db-connection.php';

$user = (int)$_GET['q'];
$db = $database->openConnection();

    $response = $db->prepare('SELECT *
            FROM site_members
            WHERE user_id = :nom 
           ');
    $response->bindValue(':nom',$user,PDO::PARAM_STR);
    $response->execute();
    $member = $response->fetch();
    $response->CloseCursor();
if($member){
$user_id = $member['user_id'];
$user = $member['user_name'];
$rank = (int)$member['user_admin'];
$tele = $member['user_tele'];
$money = (int)$member['money'];

if(empty($member['boss'])){
$theboss = 'لا يوجد';

}else{
$theboss = $member['boss'];
}
$money = (int)$member['money'];

$_SESSION['rank'] = $rank;

echo'
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

<form class="form-inline" >
  <div class="form-group">
    <center><img  src="imgs/user.png" ><h4>'.$user.'</h4> - <center><h5><i class="fa fa-telegram"></i> '.$tele.'</h5></center>

    <center><label for="user">المستحقات الماليه</label></center>
  <span>
    <i class="fa fa-dollar-sign" aria-hidden="true"></i>
  </span>
<form>
<input style="width:25%" class="form-control" type="number" id="TheMoney" name="TheMoney" placeholder="المبلغ" required=" "  value="'.$money.'" />
  </div>
  <button type="button" onclick="updatemon('.$user_id.');" class="btn btn-Primary">تحديث </button>
</form></form>
';





}else{
echo 'لم يتم العثور على العضو';
}
 ?>