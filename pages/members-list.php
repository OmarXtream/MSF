          <h2>الأعضاء</h2>
          <!-- <button type="button" name="refreshMembers" class="float-left">تحديث البيانات</button> -->
          <div class="clearFix"></div>
          <table>
            <thead>
              <tr>
                <th>العضو</th>
                <th>التخصص</th>
                <th>تليقرام</th>
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
$ranks = (int)$members['user_admin'];
if(empty($members['user_tele'])){
$teles = 'غير مسجل';

}else{
$teles = htmlspecialchars($members['user_tele']);
}
echo'
    <tr>
      <th scope="row"><center>'.$users.'</th>
      <td><center>'.getRank($ranks).'</td>
      <td><center>'.$teles.'</td>
    </tr>


';

}
}
?>
  </tbody>
</table>
