<?php
include '../inc/db-connection.php';
include '../inc/protection.php';

$db = $database->openConnection();

$boss = $_SESSION['user'];

    if (isset($_SESSION['as']) and $_SESSION['as'] >= microtime(true)) {
	echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("خطأ","يجب عليك الانتظار بين محاولاتك","error");';
	echo '}, 1000);</script>';

    } else {

        $_SESSION['as'] = microtime(true) + 2.5;

  $error = array(); // تعيين جدول لجمع الأخطاء

  if (empty($_POST['Task'])) {
    $error[] = 'المرجو ملأ حقل المهمة ';
  } else {
    $Task = $_POST['Task'];
  }
  if (empty($_POST['detalis'])) {
    $error[] = 'المرجو ملأ التفاصيل ';
  } else {
    $details = $_POST['detalis'];
  }

  if (!isset($_POST['agent']) ) {
    $error[] = 'المرجو تحديد المنفذ ';
  } else {
    $agentid = $_POST['agent'];
  }
  if (empty($_POST['time']) or !is_numeric($_POST['time'])) {
    $error[] = 'المرجو تحديد مدة التنفيذ ';
  } else {
    $day = (int)$_POST['time'];
  }
  if (empty($_POST['Money']) or !is_numeric($_POST['Money'])) {
    $error[] = 'المرجو تحديد المبلغ المستحق ';
  } else {
    $money = (int)$_POST['Money'];
  }


  if (isset($_POST['agent']) ) {

    $response = $db->prepare('SELECT *
            FROM site_members
            WHERE user_id = :nom 
           ');
    $response->bindValue(':nom',$agentid,PDO::PARAM_INT);
    $response->execute();
    $checks = $response->fetchAll();
    $response->CloseCursor();
if($response->rowCount() > 0 )
{
foreach($checks as $check){
$agent = $check['user_name'];

}
}else{
    $error[] = 'المرجو تحديد المنفذ ';
}
}
   /* إذا لم نسجل أي خطأ ، نرسل البيانات إلى القاعدة */
  if (empty($error))
  {

    // تخزين البيانات في القاعدة 
$startDate = time();
$endtime = date('Y-m-d h:i:s', strtotime('+'.$day.' day', $startDate));
//date('Y-m-d H:i:s');
try 
{

        $stmt= $db->prepare('INSERT INTO member_tasks ( task_name, task_time, task_boss, task_agent, creation_date, money , task_details) 
                             VALUES (:cd, :et, :sg, :ag, NOW(), :mn, :td)
                           ');
        $stmt->bindValue(':cd',"$Task",PDO::PARAM_STR);
        $stmt->bindValue(':et',"$endtime",PDO::PARAM_STR);
        $stmt->bindValue(':sg', "$boss", PDO::PARAM_STR);
        $stmt->bindValue(':ag', "$agent", PDO::PARAM_STR);
        $stmt->bindValue(':mn', "$money", PDO::PARAM_INT);
        $stmt->bindValue(':td', "$details", PDO::PARAM_STR);



        $stmt->execute();        
        $stmt->CloseCursor();
} 
catch(PDOException $e)
{
  die('خطأ:'. $e->getMessage());
}

    // إنهاء الصفحة
 echo' <script type="text/javascript">

       toastr.success("تمت العملية بنجاح..");
</script>';
		

 } else { // أو نقوم بعرض الأخطاء الناجمة
       echo '<script type="text/javascript">';

       foreach ($error as $key => $values) {
       
       echo 'toastr.warning("' . $values . '");';
}
       echo '</script>';


}
}
// تحديث بيانات الجدول في حالة الإضافة
?>
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
$money = (int)$task['money'];
$task_start = $task['creation_date'];
$task_details = $task['task_details'];

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


  