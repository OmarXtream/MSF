

<?php
include 'inc/head.php';
?>
          <div class="clearFix"></div>
          
    <script src="js/jobs.js" type="text/javascript"></script>

          <!-- Second Section -->
          <!-- First edit -->
        <section class="hideable text-center whitebg" id="missions">
          <div class="clearFix"></div>

<?php 

include 'pages/missions.php';

?>
</section>

<?php if($_SESSION['rank'] >= 3){?>

        <section class="hideable text-center whitebg" id="missionsmanagement">          
<div class="clearFix"></div>

<?php 

include 'pages/tasks.php';



?>
</section>
<?php } ?>

          <!-- Second edit -->
        <section class="hideable text-center whitebg" id="members">
          <div class="clearFix"></div>

<?php 
include 'pages/members-list.php';
?>
          </section>
<?php if($_SESSION['rank'] >= 4){?>

        <section class="hideable text-center whitebg" id="membersmanagement">
          <div class="clearFix"></div>

<?php 
include 'pages/members-control.php';

?>   
          </section>
<?php } ?>
<?php if($_SESSION['rank'] >= 3){?>
        <section class="hideable text-center whitebg" id="log">
          <div class="clearFix"></div>


<?php 
include 'pages/log.php';

?>   

          </section>
<?php } ?>
<?php if($_SESSION['rank'] >= 5){?>

        <section class="hideable text-center whitebg" id="payments">
          <div class="clearFix"></div>

<?php 
include 'pages/moneycon.php';

?>   
          </section>
<?php } ?>


  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/script.js"></script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/a2bd7673/cloudflare-static/rocket-loader.min.js" data-cf-settings="ead26de6100505a2f800b1ec-|49" defer=""></script></body>

  </body>
</html>
