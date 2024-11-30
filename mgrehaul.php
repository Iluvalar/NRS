<?php

include('Fwz.php');
error_reporting (E_ALL & ~E_NOTICE);
ini_set('memory_limit','1G');
ini_set("display_errors", 1); 
$basedir='./mp454/';
$sys['nrs']['dir']['contingency']='./contingency/';
$sys['nrs']['dir']['vanilla']='./mp454/';
$sys['nrs']['dir']['save']='./tinymods/mgrehaul';

$type='structuremodifier';
$modname='vanilla';
$str=file_get_contents($sys['nrs']['dir'][$modname] .'stats/'.$type.'.json');
$sys['nrs'][$modname][$type]= json_decode($str, TRUE);
#$sys['nrs']['file']['stat'][$type]= $sys['nrs'][$modname][$type];
$sm=$sys['nrs'][$modname][$type]; //will interact massively with structure modifiers for a while.

$type='weaponmodifier';
$modname='vanilla';
$str=file_get_contents($sys['nrs']['dir'][$modname] .'stats/'.$type.'.json');
$sys['nrs'][$modname][$type]= json_decode($str, TRUE);
#$sys['nrs']['file']['stat'][$type]= $sys['nrs'][$modname][$type];
$wm=$sys['nrs'][$modname][$type]; //will interact massively with weapon modifiers for a while.

$type='propulsion';
$modname='vanilla';
$str=file_get_contents($sys['nrs']['dir'][$modname] .'stats/'.$type.'.json');
$sys['nrs'][$modname][$type]= json_decode($str, TRUE);
$sys['nrs']['file']['stat'][$type]= $sys['nrs'][$modname][$type];

//Actual buffs...
$wm['ANTI TANK']["Wheeled"]=100;
$wm['ANTI PERSONNEL']["Half-Tracked"]+=10;
$wm['ANTI PERSONNEL']["Tracked"]+=10;
///Actual buffs...

unset($tot);
Foreach($wm as $id => $data){
	if($id!='BUNKER BUSTER'){
		foreach($data as $propType => $wmv){ //weapon modifier value
			$tot[$propType]+=$wmv;
		}
		foreach($sm[$id] as $structID=>$smv){
			$tot[$structID]+=$smv;
		}
	}
}

Foreach($wm as $id => $data){
	foreach($data as $propType => $wmv){ //weapon modifier value
		if($id!='BUNKER BUSTER'){
			$wm[$id][$propType]=floor($wm[$id][$propType]*(5*100/$tot[$propType]));
		}
		
	}
}
foreach($sys['nrs']['file']['stat']['propulsion'] as $propId => $propData){
	if(isset($tot[ $propData['type']])){
		$change=($tot['Wheeled']/$tot[ $propData['type']]);
		if($propData['type']=='Tracked'){
			$change=($tot['Wheeled']/$tot['Half-Tracked'])*1.1; //very convoluted way to give a buff to tracks. 
			//Reason: This normalisation debuff the effective hp on the weapons (for htracks 8.8%). Which can be a large source of the hp. 
			//I'm okay with the debuff, as htrack are too dominant atm. But i want tracks to come out on top of the htracks not hurt by it
		}
		$sys['nrs']['file']['stat']['propulsion'][$propId]['hitpointPctOfBody']=floor($sys['nrs']['file']['stat']['propulsion'][$propId]['hitpointPctOfBody']*$change); //gee gotta love those long lines... There is no point to cache here so enjoy!
		echo '<br>'.  $propData['name'] .'='. $change;
		print_r($sys['nrs']['file']['stat']['propulsion'][$propId]);
	}

}
print_r($propData);
print_r($wm);
print_r($tot);
$sys['nrs']['file']['stat']['weaponmodifier']=$wm;


foreach($sys['nrs']['file']['stat'] as $nom => $val){
		$dump=json_encode($val,JSON_PRETTY_PRINT);
		echo 'saving: '. $nom  .' ';
		//print_r($val);
		file_put_contents($sys['nrs']['dir']['save'] .'\\stats\\'. $nom .'.json', $dump);
}

