<center><strong><span> لتفاصيل المهمه قم بمراجعة المسؤول في التلقرام </span></strong></center>
          <h2>المهام</h2>

<div = id="upbut">
<button  class="float-left" type="button"  onclick="taskup();" ><strong> تحديث </strong><i class="fa fa-spinner fa-pulse  fa-fw"></i> </button>
</div>
          <div class="clearFix"></div>
<div id ='miss'>

          <table>
            <thead>
              <tr>
                <th>م.</th>
                <th>المهمة</th>
                <th>موعد التسليم</th>
                <th>المسؤول</th>
                <th>تم تحريرها</th>
                <th>المبلغ المستحق</th>
                <th>التفاصيل</th>
                <th>تحكم</th>
              </tr>
            </thead>

            <tbody>
<?php 

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

/*
CREATE TABLE IF NOT EXISTS `member_tasks` (
  `task_id` int(11) unsigned NOT NULL,
  `task_name` text NOT NULL,
  `task_time` datetime NOT NULL,
  `task_boss` varchar(70) NOT NULL,
  `task_agent` varchar(70) NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

$task_id = (int)$task['task_id'];
$task_name = $task['task_name'];
$task_time = $task['task_time'];
$task_boss = $task['task_boss'];
$task_agent = $task['task_agent'];
$task_start = $task['creation_date'];
$money = (int)$task['money'];
$task_details = $task['task_details'];

$status = $task['status'];

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

?>

  </tbody>
</table> 
</div>
<script>
function schange(tid,tstatus){
    var idd = tid;    
    var stat = tstatus;                

$.post('controllers/change.php',{id:idd,status:stat},
function(data,ts,xhr)
{

$('#mtatresult-'+idd).html(data);

});
}
</script>
<script>
function taskup(){
document.getElementById("miss").innerHTML = '<center><img style="width:20%" src="ajax-loader.gif"></center>';
$.post('controllers/taskup.php',
function(data,ts,xhr)
{

$('#miss').html(data);

});
}
</script>


