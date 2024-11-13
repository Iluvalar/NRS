<?php
include('Fwz.php');
error_reporting (E_ALL & ~E_NOTICE);
ini_set('memory_limit','1G');
ini_set("display_errors", 1); 
$basedir='./mp454/';
$sys['nrs']['dir']['contingency']='./contingency/';
$sys['nrs']['dir']['vanilla']='./mp454/';
$sys['nrs']['dir']['save']='./tinymods/mgrehaul';

$type='weapons';
$modname='vanilla';
$str=file_get_contents($sys['nrs']['dir'][$modname] .'stats/'.$type.'.json');
$sys['nrs'][$modname][$type]= json_decode($str, TRUE);
$sys['nrs']['file']['stat'][$type]= $sys['nrs'][$modname][$type];

print_r($sys['nrs']['file']['stat'][$type]['MG1Mk1']);
$bpr=$sys['nrs']['file']['stat'][$type]['MG1Mk1']['buildPoints']/$sys['nrs']['file']['stat'][$type]['MG1Mk1']['buildPower']; //Whatever Build point ratio is used on the _desired design_ DEMO.




$sys['nrs']['file']['stat'][$type]['MG3Mk1']['buildPower']=37;
$sys['nrs']['file']['stat'][$type]['MG3Mk1']['buildPoints']=$sys['nrs']['file']['stat'][$type]['MG3Mk1']['buildPower']*$bpr;
$sys['nrs']['file']['stat'][$type]['MG3Mk1']['damage']=15;

$sys['nrs']['file']['stat'][$type]['MG4ROTARYMk1']['buildPower']=60;
$sys['nrs']['file']['stat'][$type]['MG4ROTARYMk1']['buildPoints']=floor($sys['nrs']['file']['stat'][$type]['MG4ROTARYMk1']['buildPower']*$bpr);
$sys['nrs']['file']['stat'][$type]['MG4ROTARYMk1']['longRange']=128*8;
$sys['nrs']['file']['stat'][$type]['MG4ROTARYMk1']['shortRange']=128*6;
$sys['nrs']['file']['stat'][$type]['MG4ROTARYMk1']['damage']-=3;

print_r($sys['nrs']['file']['stat'][$type]['MG5TWINROTARY']);
$sys['nrs']['file']['stat'][$type]['MG5TWINROTARY']['buildPower']=80;
$sys['nrs']['file']['stat'][$type]['MG5TWINROTARY']['buildPoints']=floor($sys['nrs']['file']['stat'][$type]['MG5TWINROTARY']['buildPower']*$bpr);
$sys['nrs']['file']['stat'][$type]['MG5TWINROTARY']['longRange']=128*8;
$sys['nrs']['file']['stat'][$type]['MG5TWINROTARY']['shortRange']=128*6;
$sys['nrs']['file']['stat'][$type]['MG5TWINROTARY']['damage']-=6;


$type='weapons';
$modname='contingency';
$str=file_get_contents($sys['nrs']['dir'][$modname] .'stats/'.$type.'.json');
$sys['nrs'][$modname][$type]= json_decode($str, TRUE);


$sys['nrs']['file']['stat'][$type]['MG3Twin']=$sys['nrs'][$modname][$type]['MG3Twin'];
echo "ayaya";

$sys['nrs']['file']['stat'][$type]['MG3Twin']['buildPower']=50;
$sys['nrs']['file']['stat'][$type]['MG3Twin']['hitpoints']=75;
$sys['nrs']['file']['stat'][$type]['MG3Twin']['damage']=14; //makes it more unique
$sys['nrs']['file']['stat'][$type]['MG3Twin']['weight']=$sys['nrs']['file']['stat'][$type]['MG3Mk1']['weight'];
$sys['nrs']['file']['stat'][$type]['MG3Twin']['buildPoints']=$sys['nrs']['file']['stat'][$type]['MG3Twin']['buildPower']*$bpr;
Fwz_pieSweap($sys['nrs']['file'],$sys['nrs']['file'],'weapons',$sys['nrs']['file']['stat'][$type]['MG3Twin'],'-'. $modname,$sys['nrs']['dir']['save'],$sys['nrs']['dir'][$modname],'','');
$tempeval=$sys['nrs']['file']['stat'][$type]['MG3Twin'];
Fwz_eval34($tempeval,$type);
Fwz_eval34($sys['nrs']['vanilla'][$type]['MG2Mk1'],$type);
$sys['nrs']['file']['stat'][$type]['MG3Twin']['firePause']=ceil( ($tempeval['firePause'])*$tempeval['value']/($sys['nrs']['vanilla'][$type]['MG2Mk1']['value']*1.15)); //15% better than twin machine gun :o
//$sys['nrs']['file']['stat'][$type]['MG3Twin']['firePause']=1;
print_r($tempeval);
print_r($sys['nrs']['vanilla'][$type]['MG2Mk1']);


$type='research';
$modname='vanilla';
$str=file_get_contents($sys['nrs']['dir'][$modname] .'stats/'.$type.'.json');
$sys['nrs'][$modname][$type]= json_decode($str, TRUE);
$sys['nrs']['file']['stat'][$type]= $sys['nrs'][$modname][$type];



unset($sys['nrs']['file']['stat'][$type]['R-Wpn-MG3Mk1']['redComponents']);
$temp=$sys['nrs']['file']['stat'][$type]['R-Wpn-MG3Mk1'];
$temp['id']="R-Wpn-MG3Twin";
$temp['name']="Twin Heavy Machinegun";
unset($temp['msgName']);
$temp['resultComponents']=array("MG3Twin");
$temp['resultComponents']=array("MG3Twin");
$temp['requiredResearch']=array("R-Wpn-MG3Mk1",'R-Wpn-MG-Damage06');
unset($temp['redComponents']);
$temp['statID']="MG3Twin";
$sys['nrs']['file']['stat'][$type][$temp['id']]=$temp;

$temp=$sys['nrs']['file']['stat'][$type]['R-Wpn-MG-Damage08'];
$temp['id']="R-Wpn-MG-Damage11";
$temp['name']="3D printed MG Bullets";
$temp['requiredResearch']=array("R-Struc-Research-Upgrade08",'R-Wpn-MG-Damage10');	
$temp['researchPoints']="11800";
$temp['researchPower']="500";	
$sys['nrs']['file']['stat'][$type][$temp['id']]=$temp;

/*
	"R-Wpn-MG-Damage08": {
		"iconID": "IMAGE_RES_WEAPONTECH",
		"id": "R-Wpn-MG-Damage08",
		"name": "Depleted Uranium MG Bullets",
		"requiredResearch": [
			"R-Wpn-MG-Damage07",
			"R-Struc-Research-Upgrade06"
		],
		"researchPoints": 9800,
		"researchPower": 450,*/


/*
		"iconID": "IMAGE_RES_WEAPONTECH",
		"id": "R-Wpn-MG3Mk1",
		"msgName": "RES_MG3MK1",
		"name": "Heavy Machinegun",
		"requiredResearch": [
			"R-Wpn-MG-Damage03"
		],
		"researchPoints": 1200,
		"researchPower": 37,
		"resultComponents": [
			"MG3-VTOL",
			"MG3Mk1"
		],
		"redComponents": [
			"MG2-VTOL",
			"MG2Mk1"
		],
		"statID": "MG3Mk1"
		*/
		
$type='weaponmodifier';
$modname='vanilla';
$str=file_get_contents($sys['nrs']['dir'][$modname] .'stats/'.$type.'.json');
$sys['nrs'][$modname][$type]= json_decode($str, TRUE);
$sys['nrs']['file']['stat'][$type]= $sys['nrs'][$modname][$type];
 //Actual buff...
$sys['nrs']['file']['stat'][$type]['ANTI TANK']["Wheeled"]=100;
$sys['nrs']['file']['stat'][$type]['ANTI PERSONNEL']["Half-Tracked"]+=15;
$sys['nrs']['file']['stat'][$type]['ANTI PERSONNEL']["Tracked"]+=15;
		
/*
	foreach($sys['nrs']['file']['stat']['research'] as $nom=>$val){
			echo $nom .','. $val['name'] .' '.  $val['size'] .'<br>';
			$sys['nrs']['file']['stat']['research'][$nom]['researchPoints']/=5;
			$sys['nrs']['file']['stat']['research'][$nom]['researchPower']*=3;
			
	}
*/
foreach($sys['nrs']['file']['stat'] as $nom => $val){
		$dump=json_encode($val,JSON_PRETTY_PRINT);
		echo 'saving: '. $nom  .' ';
		//print_r($val);
		file_put_contents($sys['nrs']['dir']['save'] .'\\stats\\'. $nom .'.json', $dump);
}