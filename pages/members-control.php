          <table>
            <thead>
              <tr>
                <th>العضو</th>
                <th>الإيميل</th>
                <th>الباسوورد</th>
                <th>التخصص</th>
                <th>التلقرام</th>
                <th>تحكم</th>
              </tr>
            </thead>

            <tbody>
              <tr>

			<div class="login-form-grids" style="baclground-color:#D3D3D3">
				<center><strong><span><h4 class="animated wow slideInUp" data-wow-delay=".5s">إضافة عضو</h4></span></strong></center>
<form>
				<form class="animated wow slideInUp" data-wow-delay=".5s">
					<td><input type="text" id='pseudo' name='pseudo' placeholder=" Name..." required=" "  ></td>
					<td><input type="email" id='email' name='email' placeholder="Email Address" required=" " ></td>
					<td><input type="password" id='password' name='password' placeholder="Password" required=" " ></td>
<td><select name="rank" id='rank'>

<?php
				$ranks=array(0 => array('دعم فني' => 'PRIMARY'), 1 => array('مصمم' => 'SUCCESS'), 2 => array('مبرمج' => 'SUCCESS'), 3 => array('مشرف' => 'DANGER'), 4 => array('مدير' => 'DANGER'));

		foreach($ranks as $rs=>$v){
				foreach($v as $x=>$a){
					// $x == rank name AND $a == rank color
					echo'  <option value="'.$rs.'">'.$x.'</option>';
					
		}
}
?>
</select>

					<td><input type="text" id='tele' name='tele' placeholder=" tele..." required=" "  ></td>

					<td><input style="color:green" name='submitted' type="button"  onclick="addm();" value="إضافة "></td>
				</form></form>            
</tbody>
          </table>

			</div><hr>
<script>
function addm(){
var name = $('#pseudo').val();
var pass =  $('#password').val();
var em =  $('#email').val();
var rn =  $('#rank').val();
var tl =  $('#tele').val();

document.getElementById("addresult").innerHTML = '<center><img style="width:20%" src="ajax-loader.gif"></center>';
$.post('controllers/register.php',{pseudo:name ,password:pass,email:em,rank:rn,tele:tl},
function(data,ts,xhr)
{

$('#addresult').html(data);

});
}
</script>
<div id='addresult'>

<div class="table-responsive">
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
<center><center><i style="color:red" onclick="rvm('.$users_id.');" class="fa fa-times" title="إزالة "></i>


</div>
</td></tr></div>';


}
}else{
    echo '<h2 class="errors"> لا يوجد اي حساب  </h2><hr>';
}

?>

</tbody>
</table>
</div>
	</div>		
<script>
function rvm(id){

    var rowid = id;                

swal({
  title: 'هل أنت متاكد؟',
  text: 'الرجاء مراعاة تحملك لمسؤوليه حذف العضو رقم' +rowid,
      icon: "warning",
      buttons: [
        'لا يعمي كنسل ',
        'نعم واتحمل كامل المسؤوليه !'
      ],
      dangerMode: true,
}).then(function(isConfirm) {
      if (isConfirm) {

			var xmlhttp;
			if(window.XMLHttpRequest){
				  xmlhttp = new XMLHttpRequest();
			}else{
				  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 & xmlhttp.status == 200){
						if(xmlhttp.responseText == 'done'){
							swal({
								icon: "success",
								title: "النظام",
								text: "تمت العملية بنجاح",
								allowOutsideClick: false,
								allowEscapeKey: false,
								allowEnterKey: false,
								showConfirmButton: true,
								showCancelButton: false,
								confirmButtonText: 'نعم',

							}).then((result) => {
                    $('#'+rowid).remove();

							});		
						}
						if(xmlhttp.responseText == 'wait'){
							swal({
								icon: "info",
								title: "النظام",
								text: "بشويش لا تستعجل ي حلو",
								allowOutsideClick: false,
								allowEscapeKey: false,
								allowEnterKey: false,
								showConfirmButton: true,
								showCancelButton: false,
								confirmButtonText: 'نعم',
							})			
						}
						if(xmlhttp.responseText == 'error'){
							swal({
								icon: "error",
								title: "النظام",
								text: "حدث خطأ",
								allowOutsideClick: false,
								allowEscapeKey: false,
								allowEnterKey: false,
								showConfirmButton: true,
								showCancelButton: false,
								confirmButtonText: 'نعم',
							})			
						}
						if(xmlhttp.responseText == 'info'){

							swal({
								icon: "info",
								title: "النظام",
								text: "ليس لديك النفوذ الكافي!",
								allowOutsideClick: false,
								allowEscapeKey: false,
								allowEnterKey: false,
								showConfirmButton: true,
								showCancelButton: false,
								confirmButtonText: 'نعم',
							})			
						}
				}
			}

			  xmlhttp.open("POST","controllers/rvm.php", true);
			  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			  xmlhttp.send('del_mem=1&id='+id);
    }
});

  }
</script>


