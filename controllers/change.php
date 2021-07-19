<?php

include '../inc/db-connection.php';
include '../inc/protection.php';

$db = $database->openConnection();

$boss = $_SESSION['user'];
$bossrank = $_SESSION['rank'];

  $error = array(); // تعيين جدول لجمع الأخطاء

  if (empty($_POST['id']) or !is_numeric($_POST['id'])) {
    $error[] = 'لم يتم العثور على المهمه ';
  } else {
    $id = (int)$_POST['id'];
  }

  if (!isset($_POST['status']) or !is_numeric($_POST['status'])) {
    $error[] = 'خطا غير متوقع ';
  } else {
    $status = (int)$_POST['status'];
  }

  if (isset($_POST['id']) ) {

    $response = $db->prepare('SELECT *
            FROM member_tasks
            WHERE task_id = :nom 
           ');
    $response->bindValue(':nom',$id,PDO::PARAM_INT);
    $response->execute();
    $checks = $response->fetchAll();
    $response->CloseCursor();
if($response->rowCount() > 0 )
{
    foreach ($checks as $check) {
if($status == $check['status']){
    $error[] = 'م صار شي ترا نفس الحالة';

}
}
}else{
    $error[] = 'لم يتم العثور على المهمه ';
}
}



   /* إذا لم نسجل أي خطأ ، نرسل البيانات إلى القاعدة */
  if (empty($error))
  {


    // تخزين البيانات في القاعدة 
try 
{

        $stmt = $db->prepare('UPDATE member_tasks 
                SET status = :st
                WHERE task_id = :cb
                ');
        $stmt->bindValue(':st', $status,  PDO::PARAM_INT);
        $stmt->bindValue(':cb',$id,PDO::PARAM_INT);
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

// تحديث بيانات الجدول في حالة الإضافة
if($status == 0){
$statuscol = 'PRIMARY';
}elseif($status == 2){
$statuscol = 'SUCCESS';
}else{
$statuscol = 'DANGER';
}
echo'<th id ="statresult-'.$id.'" scope="row"><center><span class="text-'.strtolower($statuscol).'">'.$id.'</span></th>';



?>

