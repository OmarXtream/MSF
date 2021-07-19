          <table>
            <thead>
              <tr>
                <th>م.</th>
                <th>المهمة</th>
                <th>موعد التسليم</th>
                <th>المسؤول</th>
                <th>تم تحريرها</th>
                <th>المبلغ المستحق</th>
                <td>تفاصيل</td>
                <th>تحكم</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <td> / </td>
                  <td> <input type="missionsName" id='Task' name='Task' placeholder="المهمة"> </td>
                  <td> <input type="number"  id='time' name='time' placeholder="مدة التنفيذ"> </td>
                  <td><select name="agent" id='agent'>

<?php
$db = $database->openConnection();

    $response = $db->prepare('SELECT *
            FROM site_members
           ');
$response->execute();
$mems = $response->fetchAll();
$response->CloseCursor();

if($response->rowCount() > 0 )
{
foreach($mems as $members){
$users_id = (int)$members['user_id'];
$users = htmlspecialchars($members['user_name']);
$ranks = (int)$members['user_admin'];




echo'  <option value="'.$users_id.'">'.$users.'</option>';

}
}

?>
</select>
                  </td>
                  <td> / </td>
                  <td> <input type="number" id="Money" name="Money" placeholder="المبلغ المستحق"> </td>
                  <td> <textarea name="detalis" id="detalis"></textarea> </td>
                  <td>   <button type="button" onclick="addtask();" class="btn btn-default">إضافة </button> </td>
                </tr>

            </tbody>
          </table>

<script>
function addtask(){
var tsk = $('#Task').val();
var ag =  $('#agent').val();
var tl =  $('#time').val();
var mn =  $('#Money').val();
var info = $('#detalis').val();



document.getElementById("taskresult").innerHTML = '<center><img style="width:20%" src="ajax-loader.gif"></center>';
$.post('controllers/addtask.php',{Task:tsk ,agent:ag,time:tl,Money:mn,detalis:info},
function(data,ts,xhr)
{

$('#taskresult').html(data);

});
}
</script>

			<hr>

<div id='taskresult'>


<table class="table table-bordered">

  <thead>
    <tr>
      <th scope="col"><center>#</th>
      <th scope="col"><center>المهمة</th>
      <th scope="col"><center>موعد التسليم</th>
      <th scope="col"><center>المسؤول </th>
      <th scope="col"><center>حررت </th>
      <th scope="col"><center>المنفذ</th>
      <th scope="col"><center>المبلغ المستحق</th>
      <th scope="col"><center>التفاصيل</th>
      <th scope="col"><center>التحكم</th>



    </tr>
  </thead>
  <tbody>
<?php 

    $response = $db->prepare('SELECT *
            FROM member_tasks
           ');
    $response->execute();
    $tasks = $response->fetchAll();
    $response->CloseCursor();
if($response->rowCount() > 0 )
{
foreach($tasks as $task){

$task_id = (int)$task['task_id'];
$task_name = $task['task_name'];
$task_time = $task['task_time'];
$task_boss = $task['task_boss'];
$task_agent = $task['task_agent'];
$task_details = $task['task_details'];
$money = (int)$task['money'];

$task_start = $task['creation_date'];
$status = (int)$task['status'];

if($status == 0){
$statuscol = 'PRIMARY';
}elseif($status == 2){
$statuscol = 'SUCCESS';
}else{
$statuscol = 'DANGER';
}
$timeago = strtotime($task_start);
echo'
    <tr id='.$task_id.'>
      <th id ="statresult-'.$task_id.'" scope="row"><center><span class="text-'.strtolower($statuscol).'">'.$task_id.'</span></th>
      <td><center>'.htmlspecialchars($task_name).'</td>
      <td><center>'.$task_time.'</td>
      <td><center>'.htmlspecialchars($task_boss).'</td>
         <td><center> <span title="'.$task_start.'">قبل  '.humanTiming($timeago).'</span></td>
      <td><center>'.$task_agent.'</td>
<td id="moneygo"><center>'.$money.'<img src="imgs/money_add.png" style="width:16px;height:16px;"/> </td>
                  <td> <textarea  disabled>'.htmlspecialchars($task_details).'</textarea> </td>


      <td><center>
<i style="color:red"  onclick="rdone('.$task_id.');" class="fa fa-times" title="حذف "></i>
<i style="color:blue" onclick="rchange('.$task_id.',0);" class="fa fa-reply" title="قيد التنفيذ "></i>
<i style="color:green" onclick="rchange('.$task_id.',2);" class="fa fa-check" title="تمت "></i>
<i style="color:orange" onclick="rgive('.$task_id.','.$money.');" class="fa fa-dollar-sign" title="تسليم المبلغ "></i>

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
function rdone(id){

    var rowidd = id;         

swal({
  title: 'هل أنت متاكد؟',
  text: ' تأكد من تسليم المبلغ للمهمه رقم'   +rowidd,
      icon: "warning",
      buttons: [
        'لا يعمي كنسل ',
        'نعم واتحمل كامل المسؤوليه !'
      ],
      dangerMode: true,
}).then(function(isConfirm) {
      if (isConfirm) {
			var xmlhttp;
			if(window.XMLHttpRequest){
				  xmlhttp = new XMLHttpRequest();
			}else{
				  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 & xmlhttp.status == 200){
						if(xmlhttp.responseText == 'done'){
							swal({
								icon: "success",
								title: "النظام",
								text: "تمت العملية بنجاح",
								allowOutsideClick: false,
								allowEscapeKey: false,
								allowEnterKey: false,
								showConfirmButton: true,
								showCancelButton: false,
								confirmButtonText: 'نعم',

							}).then((result) => {
                    $('#'+rowidd).remove();

							});		
						}
						if(xmlhttp.responseText == 'wait'){
							swal({
								icon: "info",
								title: "النظام",
								text: "بشويش لا تستعجل ي حلو",
								allowOutsideClick: false,
								allowEscapeKey: false,
								allowEnterKey: false,
								showConfirmButton: true,
								showCancelButton: false,
								confirmButtonText: 'نعم',
							})			
						}
						if(xmlhttp.responseText == 'error'){
							swal({
								icon: "error",
								title: "النظام",
								text: "حدث خطأ",
								allowOutsideClick: false,
								allowEscapeKey: false,
								allowEnterKey: false,
								showConfirmButton: true,
								showCancelButton: false,
								confirmButtonText: 'نعم',
							})			
						}
						if(xmlhttp.responseText == 'info'){

							swal({
								icon: "info",
								title: "النظام",
								text: "ليس لديك النفوذ الكافي!",
								allowOutsideClick: false,
								allowEscapeKey: false,
								allowEnterKey: false,
								showConfirmButton: true,
								showCancelButton: false,
								confirmButtonText: 'نعم',
							})			
						}
				}
			}
			  xmlhttp.open("POST","controllers/rms.php", true);
			  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			  xmlhttp.send('del_ts=1&id='+id);
    }
});

  }

</script>

<script>
function rgive(tid,money){
    var idd = tid;    
    var mon = money;                

$.post('controllers/give.php',{id:idd,money:mon},
function(data,ts,xhr)
{

$('#moneygo').html(data);

});
}
</script>

<script>
function rchange(tid,tstatus){
    var idd = tid;    
    var stat = tstatus;                

$.post('controllers/change.php',{id:idd,status:stat},
function(data,ts,xhr)
{

$('#statresult-'+idd).html(data);

});
}
</script>

<center><strong><small>
 تنويه:
<br>
لون رقم المهمه يدل على حالتها
<br>
<b style="color:blue">أزرق</b>
 =  جاري التنفيذ
<br><b style="color:red">أحمر</b>

 = يوجد خلل
<br>
<b style="color:green">أخضر</b>

 = تمت
<br>
<b style="color:red">لا تنسى تسلم له المبلغ قبل م تحذف المهمه</b>



 </small></strong></center>
