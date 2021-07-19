<?php
// no spam
sleep(1.5);

?>


<table   class="table table-bordered">
 <thead>
    <tr>
      <th scope="col"><center>#</th>
      <th scope="col"><center>المهمة</th>
      <th scope="col"><center>موعد التسليم</th>
      <th scope="col"><center>المسؤول </th>
      <th scope="col"><center>حررت </th>
      <th scope="col"><center>المبلغ المستحق </th>
      <th scope="col"><center>التفاصيل </th>
      <th scope="col"><center>تحكم </th>


    </tr>
  </thead>
  <tbody>

<?php 
include '../inc/db-connection.php';
include '../inc/protection.php';
$db = $database->openConnection();
$user = $_SESSION['user'];







$taskcount = 0;

    $response = $db->prepare('SELECT *
            FROM member_tasks
            WHERE task_agent = :nom 
           ');
    $response->bindValue(':nom',$user,PDO::PARAM_STR);
    $response->execute();
    $tasks = $response->fetchAll();
    $response->CloseCursor();
if($response->rowCount() > 0 )
{
foreach($tasks as $task){
$taskcount++;

$task_id = (int)$task['task_id'];
$task_name = $task['task_name'];
$task_time = $task['task_time'];
$task_boss = $task['task_boss'];
$task_agent = $task['task_agent'];
$money = (int)$task['money'];
$task_start = $task['creation_date'];
$status = $task['status'];
$task_details = $task['task_details'];

if($status == 0){
$statuscol = 'PRIMARY';
}elseif($status == 2){
$statuscol = 'SUCCESS';
}else{
$statuscol = 'DANGER';
}

$timeago = strtotime($task_start);


echo'
    <tr>
      <th id ="mtatresult-'.$task_id.'" scope="row"><center><span class="text-'.strtolower($statuscol).'">'.$task_id.'</span></th>
      <td><center><center>'.htmlspecialchars($task_name).'</td>
      <td><center><center>'.$task_time.'</td>
      <td><center><center>'.htmlspecialchars($task_boss).'</td>
         <td><center> <span title="'.$task_start.'"><center>قبل  '.humanTiming($timeago).'</span></td>
<td><center> '.$money.' <img src="imgs/money_add.png" style="width:16px;height:16px;"/> </td>
                  <td> <textarea name="detalis" id="detalis" disabled>'.htmlspecialchars($task_details).'</textarea> </td>


      <td>
<center>
<i style="color:red" onclick="schange('.$task_id.',1);" class="fa fa-exclamation-triangle" title="تبليغ عن خلل "></i>
<i style="color:blue" onclick="schange('.$task_id.',0);" class="fa fa-coffee" title="قيد التنفيذ "></i>
<i style="color:green" onclick="schange('.$task_id.',2);" class="fa fa-check" title="تمت "></i>
</td>
    </tr>
';


}
}else{
    echo '<h2 class="errors"> لا يوجد اي مهمه حاليا  </h2><hr>';
}
echo'
<script>
document.getElementById("taskcount").innerHTML = "<i class="fas fa-arrow-left"></i> '.$taskcount.'";
</script>
';

    $response = $db->prepare('SELECT *
            FROM site_members
            WHERE user_name = :nom 
           ');
    $response->bindValue(':nom',$user,PDO::PARAM_STR);
    $response->execute();
    $member = $response->fetch();
    $response->CloseCursor();
$money = (int)$member['money'];
echo'
<script>
document.getElementById("moneycount").innerHTML = "<i class="fas fa-arrow-left"></i> $ '.$money.'";
</script>
';



?>
  </tbody>
</table> 
