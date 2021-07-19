<div class="clearFix"></div>
<div class="float-left" style="width:50%">
<td  bgcolor="#213A3F">
<?php
$file = "adminlog.txt";
$f = fopen($file, "r") or exit("Unable to open file!");
// read file line by line until the end of file (feof)
while(!feof($f))
{
  echo fgets($f)."<br />";
}

fclose($f);
?>
</td>
 
</div><div class="clearFix"></div>