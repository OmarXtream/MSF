<?php
include 'data.php';

function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'سنة',
        2592000 => 'شهر',
        604800 => 'اسبوع',
        86400 => 'يوم',
        3600 => 'ساعة',
        60 => 'دقائق',
        1 => 'ثانية'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'':'');
    }

}
function secure($str){

         return htmlspecialchars(addslashes(trim($str)));
         
}


function log_write($message, $type)
{
	$enable_log = true;
	if ($enable_log) {
		$createlog = false;
	    $log = "[".date("Y-m-d\ h:i:s A")."][".$type."] ".$message."\n";
	    $logfile = "adminlog.txt";
	    if (!file_exists($logfile)){
			$createlog = true;
	    }
	    $openfile = fOpen($logfile , "a+");
	    if ($createlog){
			fWrite($openfile, "[".date("h:i:s A")."][Information] Creating new log file (".$logfile.")\n");
	    }
	    fWrite($openfile, $log);
	    fClose($openfile);
	}
		return true;
}
function getRank($rank) {
	$a = '';
	
				$ranks=array(0 => array('دعم فني' => 'PRIMARY'), 1 => array('مصمم' => 'SUCCESS'), 2 => array('مبرمج' => 'SUCCESS'), 3 => array('مشرف' => 'DANGER'), 4 => array('مدير' => 'DANGER'), 5 => array('مدير تنفيذي' => 'DANGER'));

		
		
		
		foreach($ranks as $rs=>$v){
			if($rs == $rank){
				foreach($v as $x=>$a){
					// $x == rank name AND $a == rank color
					
					$a = '<span class="text-'.strtolower($a).'">'.$x.'</span>';
					
				
			}
		}
	}
return $a;
}
?>