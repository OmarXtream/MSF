  <div class="float-left text-center" style="width:50%">

  <div class="form-group">
    <label for="exampleFormControlSelect1">الأعضاء</label>
<form id="membersform" method="post" onsubmit="return false;" autocomplete="off">
<select class="form-control" name="users" onchange="showUser(this.value)" data-placeholder="إختر العضو" >
<option value="">إختر العضو</option>

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
if(empty($members['user_tele'])){
$teles = 'غير مسجل';

}else{
$teles = htmlspecialchars($members['user_tele']);
}


echo '<option value="'.$users_id.'">'.$users.'</option>';

}
}
?>

   </select>
</form>

  </div>
</div><div class="clearFix"></div>
 <div class="float-right text-center" style="width:50%">

<div id="txtHint"></div>
</div>
<script>
function updatemon(id){
    var idd = id;    
    var mn = $('#TheMoney').val();


$.post('controllers/moneyupdate.php',{id:idd, money:mn},
function(data,ts,xhr)
{

$('#txtHint').html(data);

});
}
</script>

<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","controllers/meminfo.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
<div class="clearFix"></div>
