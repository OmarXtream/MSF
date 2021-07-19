
<?php
include 'inc/db-connection.php';
include 'password_compat/lib/password.php';


 if(isset($_SESSION['user']) and isset($_SESSION['id'])){
echo'<meta http-equiv="refresh" content="0; url=main.php" />';
die;
}

?>


<?php
include 'controllers/login.php';
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
        <style id="css-main">@font-face{font-family:myFirstFont;src:url(hcdd.ttf)/*tpa=*/ format('truetype');unicode-range:U +0600-06EF , U +06FA-0903}@font-face{font-family:dinar2;src:url(ge-dinar2.ttf)/*tpa=*/ format("truetype");font-weight:normal;font-style:normal;unicode-range:U +0600-06EF , U +06FA-0903}@font-face{font-family:h-tunisia;src:url(H-Tunisia.ttf)/*tpa=*/ format('truetype');unicode-range:U +0600-06EF , U +06FA-0903}@font-face{font-family:h-tunisia;src:url(H-Tunisia-B.ttf)/*tpa=*/ format('truetype');font-weight:bold;unicode-range:U +0600-06EF , U +06FA-0903}@font-face{font-family:h-pro;src:url(H-Promoter.ttf)/*tpa=*/ format('truetype');unicode-range:U +0600-06EF , U +06FA-0903}@font-face{font-family:h-pro;src:url(H-Promoter-M.ttf)/*tpa=*/ format('truetype');font-weight:bold;unicode-range:U +0600-06EF , U +06FA-0903}div h1,div h2,div h3,div h4,div p,div.h1,div.h2,div.h3,div.h3{font-family:'Open Sans',dinar2}div{font-family:myFirstFont,'Open Sans'}font1{font-family:myFirstFont,'Open Sans'!important}font2{font-family:dinar2,'Open Sans'!important}.progamer{font-family:h-pro!important;font-weight:bold!important}</style>

<head>
	<title>مسافات لإدارة المشاريع</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">

<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" type="text/css" href="css/hover.css">
	<link rel="shortcut icon" type="image/x-icon" href="imgs/favicon.png">

  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Acme' rel='stylesheet' type='text/css'><!-- //fonts -->
 <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.12.1/sweetalert2.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.12.1/sweetalert2.min.js"></script>
		<noscript><meta HTTP-EQUIV="refresh" content=0;url="Error/jsErr.php"></noscript>

<!--===============================================================================================-->
</head>
<body>

	<div class="contact1">
		<div class="container-contact1">
			<form class="contact1-form validate-form" >
				<span class="contact1-form-title">
					<strong> تسجيل دخول </strong>
				</span>
<script type="text/javascript" src="js/bostrap.js"></script>
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>

<div id="result">
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
</div>

			<div class="contact1-pic js-tilt" data-tilt>
				<img src="imgs/Logo.png" alt="IMG">
			</div>
		</div>
	</div>

<!--===============================================================================================-->
	<script src="js/main.js"></script>
<script type="text/javascript" src="js/snowstorm.js"></script>

</body>
</html>
