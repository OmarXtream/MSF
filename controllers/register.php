<?php


include '../inc/db-connection.php';
include '../password_compat/lib/password.php';
include '../inc/protection.php';

$db = $database->openConnection();
$boss = $_SESSION['user'];

    if (isset($_SESSION['rg']) and $_SESSION['rg'] >= microtime(true)) {
	echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("خطأ","يجب عليك الانتظار بين محاولاتك","error");';
	echo '}, 1000);</script>';

    } else {

        $_SESSION['rg'] = microtime(true) + 2.5;

  $error = array(); // تعيين جدول لجمع الأخطاء

  if (empty($_POST['pseudo'])) { //إذا كان حقل الإسم فارغا
    //إضافة خطأ للجدول
    $error[] = 'المرجو ملأ حقل إسم المستخدم '; 
  } else {
    $user = $_POST['pseudo']; //إنشاء متغير للإسم
  }
if (!empty($_POST['pseudo']) and !preg_match("/^[a-zA-Z0-9]*$/",$user)) {
    $error[] = 'لا يسمح الا بالحروف الإنقليزيه والارقام في الاسم '; 
}
  if (empty($_POST['email'])) {
    $error[] = 'المرجو ملأ حقل البريد الإلكتروني';
  } else {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $error[] = "! عذرا ، البريد الإلكتروني غير صحيح";
    } else {
      $email = $_POST['email'];
    }
  }

  if (empty($_POST['password'])) {
    $error[] = 'المرجو ملأ حقل كلمة المرور ';
  } else {
    $password = $_POST['password'];
  }
  if (empty($_POST['tele'])) {
    $error[] = 'المرجو ملأ حقل حساب التلقرام ';
  } else {
    $tele = $_POST['tele'];
  }
  if (!isset($_POST['rank']) ) {
    $error[] = 'المرجو ملأ حقل المنصب ';
  } else {
    $hisr = $_POST['rank'];
  }

 // التأكد بأن العضو لم يستعمل إسما أو بريدا إلكترونيا موجودين مسبقا في القاعدة

  $response = $db->prepare('SELECT user_name, user_email
            FROM site_members
           ');
  $response->execute();
  $members = $response->fetchALL();
  $response->CloseCursor();

  if (!empty($_POST['pseudo']) AND !empty($_POST['email'])) {
    foreach ($members as $member) {
      if ($_POST['pseudo'] == $member['user_name']) {
        $error[] = 'المرجو تغيير إسم المستخدم . هذا الإسم موجود مسبقا';
      }
      if ($_POST['email'] == $member['user_email']) {
        $error[] = 'المرجو تغيير العنوان الإلكتروني ، هذا البريد موجود مسبقا';
      }
    }
  }

   /* إذا لم نسجل أي خطأ ، نرسل البيانات إلى القاعدة */
  if (empty($error))
  {
    $options = array("cost" => 12);
$hash_pass = password_hash($password, PASSWORD_DEFAULT, $options);

    // تعيين شيفرة تفعيل العضوية 
    $activation = md5(uniqid(rand(), true));
    // تخزين البيانات في القاعدة 
    $stmt= $db->prepare('INSERT INTO site_members (user_name, user_email, user_password, user_admin, user_tele, boss) 
              VALUES (:name, :mail, :pass, :a, :t, :b)
            ');
    $stmt->bindValue(':name',$user,PDO::PARAM_STR);
    $stmt->bindValue(':mail',$email,PDO::PARAM_STR);
    $stmt->bindValue(':pass',$hash_pass,PDO::PARAM_STR);
    $stmt->bindValue(':a',$hisr,PDO::PARAM_INT);
    $stmt->bindValue(':t',$tele,PDO::PARAM_STR);
    $stmt->bindValue(':b',$boss,PDO::PARAM_STR);

    $stmt->execute();

    $stmt->CloseCursor();

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

echo'<div class="table-responsive">
<table class="table table-striped table-vcenter">
<thead>
<tr>
<th class="text-center" style="width: 120px;"><center><i class="fa fa-user"></i></th>
<th><center>الأسم</th>
<th><center>الإيميل</th>
<th><center>تلقرام</th>
<th ><center>المنصب</th>
<th class="text-center" style="width: 100px;"><center>إزالة</th>
</tr>
</thead>
<tbody>
';
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
$email = htmlspecialchars($members['user_email']);
$ranks = (int)$members['user_admin'];
if(empty($members['user_tele'])){
$teles = 'غير مسجل';

}else{
$teles = htmlspecialchars($members['user_tele']);
}



echo'

<tr id='.$users_id.'>
<td class="text-center">
<img  src="imgs/user.png" >
</td>
<td class="font-w600"><center>'.$users.'</td>
<td class="font-w600"><center>'.$email.'</td>
<td><center><input size="2" class="form-control input-sm" type="text" id="example-input-small" name="example-input-small" value="'.$teles.'" placeholder="'.$teles.'"></td>

<td>
<center><span class="label label-info">'.getRank($ranks).'</span>
</td>
<td class="text-center">
<div class="btn-group">
<center><i style="color:red" onclick="rvm('.$users_id.');" class="fa fa-times" title="إزالة "></i>

</div>
</td></tr></div>';


}
}else{
    echo '<h2 class="errors"> لا يوجد اي حساب  </h2><hr>';
}
echo'</tbody>
</table>
</div>
	</div>		
';


  ?>