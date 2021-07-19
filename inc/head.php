<?php 
include 'inc/db-connection.php';

if(!isset($_SESSION['user']) or !isset($_SESSION['id'])){
	exit(header('Location: ./index.php'));
}
if(isset($_SESSION['user']) and isset($_SESSION['id'])){ 
$user = $_SESSION['user'];
$user_id = $_SESSION['id'];
$db = $database->openConnection();

    $response = $db->prepare('SELECT *
            FROM site_members
            WHERE user_name = :nom 
           ');
    $response->bindValue(':nom',$user,PDO::PARAM_STR);
    $response->execute();
    $member = $response->fetch();
    $response->CloseCursor();
if($member){
$user_id = $member['user_id'];
$user = $member['user_name'];
$rank = (int)$member['user_admin'];
$tele = $member['user_tele'];
if(empty($member['boss'])){
$theboss = 'انت!';

}else{
$theboss = $member['boss'];
}
$money = (int)$member['money'];

$_SESSION['rank'] = $rank;
}
}
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
}
}


?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">

    <title>مسافات لإدارة المشاريع - خاص</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <link rel="stylesheet" href="css/normalize.css" />
	<link rel="icon"  href="imgs/favicon.png">

  <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/hover.css">
<noscript><meta HTTP-EQUIV="refresh" content=0;url="Error/jsErr.php"></noscript>

    <!--[if lt IE 9]-->
    <script src="js\html5shiv.min.js"></script>

    <!--[endif]-->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body id="body">
    <nav class="float-right whitebg">
      <section class="top text-center">
        <img src="imgs/logo.png" alt="logo" onmouseover="animateCSS('#logo', 'rubberBand')" id="logo" >
        <h3 onmouseover="animateCSS('#title', 'pulse')" id="title">مسافات لإدارة المشاريع</h3>
       <?php echo' <h4>'.htmlspecialchars($user).'</h4>'; ?>
	   
        <form>
          <label class="switch" >
            <input type="checkbox" onclick="theme();" id="ThemCheckbox" checked>
            <span class="slider round"></span>
          </label>
        </form>
      </section>


      <section class="list">
        <ul>
          <li> <i class="far fa-list-alt nav" style="padding-left: 10px"></i> <a class="nav" id="missionsb" onclick="sections('missions');" onmouseover="animateCSS('#missionsb','fadeInLeft');">المهام</a> </li>
          <li> <i class="fas fa-users nav" style="padding-left: 10px"></i> <a class="nav" id="membersb" onclick="sections('members');" onmouseover="animateCSS('#membersb','fadeInLeft');">الأعضاء</a> </li>
          <?php if($_SESSION['rank'] >= 3){?><li> <i class="fas fa-gavel nav" style="padding-left: 10px"></i> <a class="nav" id="missionsmanagementb" onclick="sections('missionsmanagement');" onmouseover="animateCSS('#missionsmanagementb','fadeInLeft');">إدارة المهام</a> </li><?php }?>
          <?php if($_SESSION['rank'] >= 4){?><li> <i class="fas fa-briefcase nav" style="padding-left: 10px"></i> <a class="nav" id="membersmanagementb" onclick="sections('membersmanagement');" onmouseover="animateCSS('#membersmanagementb','fadeInLeft');">إدارة الأعضاء</a> </li><?php }?>
         <?php if($_SESSION['rank'] >= 3){?> <li> <i class="fas fa-envelope-square nav" style="padding-left: 10px"></i> <a class="nav" id="logb" onclick="sections('log');" onmouseover="animateCSS('#logb','fadeInLeft');">السجل</a> </li><?php }?>
          <?php if($_SESSION['rank'] >= 5){?> <li> <i class="fas fa-hand-holding-usd nav" style="padding-left: 10px"></i> <a class="nav" id="paymentsb" onclick="sections('payments');" onmouseover="animateCSS('#paymentsb','fadeInLeft');">الخزنة الدولية</a> </li><?php }?>
          <li> <a href='logout.php' onclick="return confirm('متأكد؟');"><i class="fas fa-power-off nav" style="padding-left: 10px"></i> <a>تسجيل خروج</a> </li>
        </ul>
      </section>
    </nav>

    <main class="float-left">
      <header class="whitebg text-center">
        <div style="width:100%; font-weight:bold">Made With <span style="color:red"><i class="fas fa-heart"></i></span> By MASAFAT</div>
      </header>





      <section class="content">
        <section class="info text-right">
          <div class="part float-right" id="part0">
            <div class="contents whitebg">
              <h3><i class="fas fa-headset"></i> المنصب الحالي:</h3>
              <h4 style="color:rgb(76, 175, 80);"><i class="fas fa-arrow-left"></i> <?php echo getRank($rank); ?></h4>
            </div>
          </div>
          <div class="part float-right" id="part1">
            <div class="contents whitebg">
              <h3><i class="fas fa-list-alt"></i> المهام الحالية:</h3>
              <h4 id="taskcount" style="color:rgb(244, 67, 54);"><i class="fas fa-arrow-left"></i> <?php echo $taskcount; ?></h4>
            </div>
          </div>
          <div class="part float-right" id="part2">
            <div class="contents whitebg">
              <h3><i class="fas fa-user"></i> المسؤول عنك:</h3>
              <h4 style="color:rgb(156, 39, 176);"><i class="fas fa-arrow-left"></i> <strong><?php echo htmlspecialchars($theboss); ?></strong></h4>
            </div>
          </div>
          <div class="part float-right" id="part3">
            <div class="contents whitebg">
              <h3><i class="fas fa-wallet"></i> المحفظة:</h3>
              <h4 id="moneycount" style="color:rgb(33, 150, 243);"><i class="fas fa-arrow-left"></i> <?php echo $money; ?>$</h4>
            </div>
          </div>
        </section>
        <div class="clearFix"></div>

