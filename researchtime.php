<?php

error_reporting(E_ERROR | E_PARSE);

$basedir='./mp4.3.5/';
$str=file_get_contents($basedir .'stats/research.json');
$data['research']= json_decode($str, TRUE);
$temp['id']='R-Sys-Sensor-Turret01';
$temp['rp']=0;
$done[$temp['id']]=$temp['rp'];
$temp['id']='R-Wpn-MG1Mk1';
$temp['rp']=0;
$done[$temp['id']]=$temp['rp'];
$temp['id']='R-Sys-Engineering01';
$temp['rp']=0;
$done[$temp['id']]=$temp['rp'];
while(!$stop){
	$phase++;
	echo "<h3>phase: $phase </h3>";
	$stop=1;
	foreach ($data['research'] as $id =>$val){
		//echo '<br>'. $id;
		if(!isset($done[$id])){
			unset($tot);
			unset($countdone);
			$pow=0;
			$time=0;
			foreach( $val['requiredResearch'] as $no2 => $id2){
				$tot++;
				if(isset($done[$id2])){
					$time=max($done[$id2],$time);
					$pow+=$donepow[$id2];
					$countdone++;
					//echo '<br>--<b>'. $id2 .'</b>';
				}
				else{
					//echo '<br>--'. $id2 .'';
				}
			}
			if($tot==$countdone){
				
				$temp['id']=$id;
				$temp['rp']=$time+$val['researchPoints'];
				$temp['rpow']=$pow+$val['researchPower'];
				$done[$temp['id']]=$temp['rp'];
				$donepow[$temp['id']]=$temp['rpow'];
				$resData[]=$temp;
				echo '<br>'. $id .' is researchable with '. $temp['rp'] .' RP and '. $temp['rpow'] .'$';
				$stop=0;
			}
		}
	}
}
$done2=asort($done);
print_r($done2);
foreach($done as $id => $val){
	echo '<br>'. $id .' is researchable with '. $val .'RP and '. $donepow[$id].'$';
}