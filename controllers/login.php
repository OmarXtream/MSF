<?php
if (isset($_POST['pseudo']) && isset($_POST['password'])) {
    if (isset($_SESSION['Rd_G']) and $_SESSION['Rd_G'] >= microtime(true)) {
	echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("خطأ","يجب عليك الانتظار بين محاولاتك","error");';
	echo '}, 1000);</script>';

echo'
<form>
				<div class="wrap-input1 validate-input" data-validate = "Name is required">
					<input id="pseudo" class="input1" type="text" name="pseudo" placeholder="Name" required>
					<span class="shadow-input1"></span>
				</div>

				<div class="wrap-input1 validate-input" data-validate = "Valid  is required">
					<input  id="password" class="input1" type="password" name="password" placeholder="password" required>
					<span class="shadow-input1"></span>
				</div>

				<div class="container-contact1-form-btn">
								<input class="contact1-form-btn hvr-bounce-in" type="button"  value="تسجيل الدخول" onclick="post();" >

					</button>
				</div>
			</form>
';
die;
    } else {
        $_SESSION['Rd_G'] = microtime(true) + 2.5;


  $error = array(); // تعيين جدول لجمع الأخطاء
  
  if (empty($_POST['pseudo'])) { //إذا كان حقل الإسم فارغا
    //إضافة خطأ للجدول
    $error[] = 'المرجو ملأ حقل إسم المستخدم '; 
  } else {
    $user = secure($_POST['pseudo']); //إنشاء متغير للإسم
  }

  if (empty($_POST['password'])) {
    $error[] = 'المرجو ملأ حقل كلمة المرور ';
  } else {
    $password = secure($_POST['password']);
  }   
 
  if (empty($error))
  {
    // أخذ البيانات من القاعدة اعتمادا على إسم العضو و كلمة مروره 
    // و عضويته يجب أن تكون مفعلة

$db = $database->openConnection();

    $response = $db->prepare('SELECT user_id, user_name,user_password
            FROM site_members
            WHERE user_name = :nom 
           ');
    $response->bindValue(':nom',$user,PDO::PARAM_STR);
    $response->execute();
    $member = $response->fetch();
    $response->CloseCursor();

    if(!$member || !password_verify($password, $member['user_password'])) {
 echo' <script type="text/javascript">

       toastr.info("نسيتها ؟ راجعنا ي الغالي");
       toastr.error("البيانات غير صحيحة");


</script>';
echo'
<form>
				<div class="wrap-input1 validate-input" data-validate = "Name is required">
					<input id="pseudo" class="input1" type="text" name="pseudo" placeholder="Name" required>
					<span class="shadow-input1"></span>
				</div>

				<div class="wrap-input1 validate-input" data-validate = "Valid  is required">
					<input  id="password" class="input1" type="password" name="password" placeholder="password" required>
					<span class="shadow-input1"></span>
				</div>

				<div class="container-contact1-form-btn">
								<input class="contact1-form-btn hvr-bounce-in" type="button"  value="تسجيل الدخول" onclick="post();" >

					</button>
				</div>
			</form>
';

    } else {
	  // تعيين متغيرات الجلسة
      $_SESSION['id'] = $member['user_id'];
      $_SESSION['user'] = $member['user_name'];
         // عرض رسالة ربط الإتصال بنجاح أو تحويله تلقائيا إلى صفحة أخرى
 echo' <script type="text/javascript">

       toastr.success("جاري تسجيل الدخول..");


</script>';
$message = '
'.$member["user_name"].' logged in

';
log_write($message, 'info');
	  echo '<meta http-equiv="refresh" content="1; url=main.php" />';
die;
    }	
	
  } else { // أو نقوم بعرض الأخطاء الناجمة


       echo '<script type="text/javascript">';
       foreach ($error as $key => $values) {
       echo ' 
       toastr.info("' . $values . '");


';
    }
       echo '</script>';

echo'
<form>
				<div class="wrap-input1 validate-input" data-validate = "Name is required">
					<input id="pseudo" class="input1" type="text" name="pseudo" placeholder="Name" required>
					<span class="shadow-input1"></span>
				</div>

				<div class="wrap-input1 validate-input" data-validate = "Valid  is required">
					<input  id="password" class="input1" type="password" name="password" placeholder="password" required>
					<span class="shadow-input1"></span>
				</div>

				<div class="container-contact1-form-btn">
								<input class="contact1-form-btn hvr-bounce-in" type="button"  value="تسجيل الدخول" onclick="post();" >

					</button>
				</div>
			</form>
';
    }

} 
die;

}
?>