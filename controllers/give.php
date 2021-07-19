<?php

include '../inc/db-connection.php';
include '../inc/protection.php';

$db = $database->openConnection();

$boss = $_SESSION['user'];
 $hisrank = $_SESSION['rank'];

  $error = array(); // تعيين جدول لجمع الأخطاء

  if (empty($_POST['id']) or !is_numeric($_POST['id'])) {
    $error[] = 'لم يتم العثور على المهمه ';
  } else {
    $id = (int)$_POST['id'];
  }

  if (!isset($_POST['money']) or !is_numeric($_POST['money'])) {
    $error[] = 'خطا غير متوقع ';
  } else {
    $money = (int)$_POST['money'];
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
$agent = $check['task_agent'];
$status = $check['status'];
$money = $check['money'];

if($status != '2'){
    $error[] = 'المهمة غير مكتمله ! ';

}
if($money == '0'){
    $error[] = ' لا يوجد مستحقات ماليه  ';

}


}
}else{
    $error[] = 'لم يتم العثور على المهمه ';
$money = 0;
}
}
if($hisrank < 4){
    $error[] = 'لا تملك صلاحيات كافيه ';
}


   /* إذا لم نسجل أي خطأ ، نرسل البيانات إلى القاعدة */
  if (empty($error))
  {


    // تخزين البيانات في القاعدة 
try 
{

        $stmt = $db->prepare('UPDATE site_members 
                SET money  = money + :mn
                WHERE user_name = :cb
                ');
        $stmt->bindValue(':mn', $money,  PDO::PARAM_INT);
        $stmt->bindValue(':cb',$agent,PDO::PARAM_STR);
        $stmt->execute();        
        $stmt->CloseCursor();

        $stmt = $db->prepare('UPDATE member_tasks 
                SET money = :st
                WHERE task_id = :cb
                ');
        $stmt->bindValue(':st', '0',  PDO::PARAM_INT);
        $stmt->bindValue(':cb',$id,PDO::PARAM_INT);
        $stmt->execute();        
        $stmt->CloseCursor();

$sucess = true;
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

echo'<td><center> '.$money.' <img src="imgs/money_add.png" style="width:16px;height:16px;"/> </td>';


}

if(isset($sucess)){
echo'<center> 0 <img src="imgs/emblem_money.png" style="width:16px;height:16px;"/>';
}


?>

