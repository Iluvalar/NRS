<?php

//error_reporting(E_ERROR | E_PARSE);
ini_set('memory_limit','1G');

include('Fwz.php');
include('Fnrs.php');
include('mod.php'); //I think the distance mod might be in this one ?

$basedir='./mp454/';
/* TA mod
$savedir='./tinymods/ta/';
$str=file_get_contents($basedir .'stats/research.json');
$sys['wz']['data']['research']= json_decode($str, TRUE);
foreach($sys['wz']['data']['research'] as $nom=>$val){
	$sys['wz']['data']['research'][$nom]['researchPoints']/=3;
	$sys['wz']['data']['research'][$nom]['researchPower']*=1.5;
		
}

$dump=json_encode($sys['wz']['data']['research'],JSON_PRETTY_PRINT);
file_put_contents($savedir .'\\stats\\research.json', $dump);
print_r($sys['wz']['data']['research']);
//*/
/* Tiny mod
$basedir='./base/';
$savedir='./tinymods/mini/';
$scale=.5;
$folders2=explode(',','./base/,./mp4.3.5/');
$folders=explode(',','components/prop,components/weapons,components/bodies,effects,structs,audio/sfx/weapons');
foreach($folders2 as $no2 => $basedir){
	foreach($folders as $no => $val){
		$filename='/'. $val .'/';
		echo '--'. $basedir.$filename.'<br/>';
		if ($handle = opendir($basedir.$filename)) {
			while (false !== ($file = readdir($handle))) {
				echo '<br>'. $file;
				$str=file_get_contents($basedir .$filename.$file);
				$str=scale_pie_model($str, $scale);
				if($val=='components/prop' and false){
					$exp=explode('.',$file);
					$str=file_put_contents($savedir .$filename.$exp[0].'-s.'.$exp[1],$str);
				}
				else{
					$str=file_put_contents($savedir .$filename.$file,$str);
				}
			}				
		
			closedir($handle);
		}
		
	}
}
$str=file_get_contents($basedir .'stats/body.json');
$sys['wz']['data']['body']= json_decode($str, TRUE);
foreach($sys['wz']['data']['body'] as $nom=>$val){
	echo '<br>'. $nom;
	foreach($val['propulsionExtraModels'] as $nomodel=>$val2){
		foreach($val2 as $nomodel2=>$val3){
			echo '<br>--'. $val3;		
			$exp=explode('.',$val3);
			$name2=$exp[0].'-s.'.$exp[1];
			echo '=>'. $name2;
			$sys['wz']['data']['body'][$nom]['propulsionExtraModels'][$nomodel][$nomodel2]=$name2;
		}
	}
}
$dump=json_encode($sys['wz']['data']['body'],JSON_PRETTY_PRINT);
//file_put_contents($savedir .'\\stats\\body.json', $dump);
/*			
$str=file_get_contents($basedir .'components/bodies/drlbod01.pie');
$str=scale_pie_model($str, $scale);
$str=file_put_contents($savedir .'components/bodies/drlbod01.pie',$str);
*/
//*Test mod
#mod designed to allow quick set skirmish fight at abritraty T level.
$savedir='./tinymods/quicktest/';
$str=file_get_contents($basedir .'stats/structure.json');
$sys['wz']['data']['structure']= json_decode($str, TRUE);
$sys['wz']['data']['structure']['A0CyborgFactory']['productionPoints']=1000000;
$sys['wz']['data']['structure']['A0LightFactory']['productionPoints']=1000000;
$sys['wz']['data']['structure']['A0PowerGenerator']['powerPoints']=0;
$sys['wz']['data']['structure']['A0PowerGenerator']['modulePowerPoints']=0;
$dump=json_encode($sys['wz']['data']['structure'],JSON_PRETTY_PRINT);
file_put_contents($savedir .'\\stats\\structure.json', $dump);

$str=file_get_contents($basedir .'stats/construction.json');
$sys['wz']['data']['construction']= json_decode($str, TRUE);
$sys['wz']['data']['construction']['Spade1Mk1']['constructPoints']=100000;
$dump=json_encode($sys['wz']['data']['construction'],JSON_PRETTY_PRINT);
file_put_contents($savedir .'\\stats\\construction.json', $dump);
//*/