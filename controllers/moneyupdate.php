<?php
include '../inc/db-connection.php';
include '../inc/protection.php';

$db = $database->openConnection();

$boss = $_SESSION['user'];
$bossrank = $_SESSION['rank'];
  $error = array(); // تعيين جدول لجمع الأخطاء


  if (empty($_POST['id']) or !is_numeric($_POST['id'])) {
    $error[] = 'لم يتم العثور على العضو ';
  } else {
    $id = (int)$_POST['id'];
  }

  if (!isset($_POST['money']) or !is_numeric($_POST['money'])) {
    $error[] = 'خطا غير متوقع ';
  } else {
    $money = (int)$_POST['money'];
  }

  if (isset($id) and isset($money)) {

    $response = $db->prepare('SELECT *
            FROM site_members
            WHERE user_id = :nom 
           ');
    $response->bindValue(':nom',$id,PDO::PARAM_INT);
    $response->execute();
    $checks = $response->fetchAll();
    $response->CloseCursor();
if($response->rowCount() > 0 )
{
    foreach ($checks as $check) {
$hismoney = $check['money'];
if($hismoney == $money){
    $error[] = 'نفس المبلغ ! تسوقها انت ؟';


}


}
}else{
    $error[] = 'لم يتم العثور على العضو ';
}
}



   /* إذا لم نسجل أي خطأ ، نرسل البيانات إلى القاعدة */
  if (empty($error))
  {


    // تخزين البيانات في القاعدة 
try 
{

        $stmt = $db->prepare('UPDATE site_members 
                SET money = :st
                WHERE user_id = :cb
                ');
        $stmt->bindValue(':st', $money,  PDO::PARAM_INT);
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
echo'<center><img src="imgs/bank.png"></center>';


?>

 