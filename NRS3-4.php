<?php

error_reporting(E_ERROR | E_PARSE);
ini_set('memory_limit','1G');

include('Fwz.php');
include('Fnrs.php');
$modder="iluMV01";


$sys['nrs']['oilpf']=7;
$sys['nrs']['derrickprice']=400;

$sys['nrs']['scaleTime']=1;
$sys['nrs']['scaleDist']=1.25;
$sys['nrs']['time']=30*60*($sys['nrs']['scaleTime']);
$sys['nrs']['trtime']=120*($sys['nrs']['scaleTime']);
$sys['nrs']['wepmod']=1.25;
$sys['nrs']['powerpersec']=300/100;
$sys['nrs']['powerinTT']=$sys['nrs']['oilpf']*$sys['nrs']['derrickprice']/($sys['nrs']['wepmod']/($sys['nrs']['wepmod']-1));
$sys['nrs']['powerpersec']=$sys['nrs']['powerinTT']/$sys['nrs']['trtime'];
$sys['nrs']['armysize']=35; //medium units;
$sys['nrs']['dmgscale']=1.5;


/*# Era mode. 
$sys['nrs']['scaleDist']=.4;
$sys['nrs']['powerpersec']=300/100;
$sys['nrs']['time']=60*60;
$sys['nrs']['trtime']=120/($sys['nrs']['scaleDist']);
$sys['nrs']['armysize']=7; //medium units;
$sys['nrs']['dmgscale']=1.4;
/**/

$sys['nrs']['dmgunit']=10; //unit of damage expressed in % of damage. To avoid rounding mistakes
$sys['nrs']['powerunit']=10; //unit of damage expressed in % of damage. To avoid rounding mistakes
$sys['nrs']['powerMult']=1.3;
$sys['nrs']['intIncome']=1; //power with interest
$sys['nrs']['ppf']=1;
$sys['nrs']['ppf2']=2;


//dont touch !
$sys['nrs']['interestShift']=1;
$sys['nrs']['ParalelLine']=5;
$sys['nrs']['Buildtime']=4;
$sys['nrs']['stdNumStep']=4; //??

$sys['nrs']['ttpower']=$sys['nrs']['powerpersec']*$sys['nrs']['trtime']*$sys['nrs']['powerunit'];

function Fnrs_progress($x){
	global $sys;
	//return Fwz_fig($x)-0.2/$x-1;
	//return (Fwz_fig($x+1)/Fwz_fig($x))-1.2;
	return (Fwz_fig($sys['nrs']['armysize']+$x)/Fwz_fig($sys['nrs']['armysize']))-$sys['nrs']['wepmod'];
}
$nfig=newton('Fnrs_progress',0,4);
$sys['nrs']['percent']=.162;
$medprice=$sys['nrs']['ttpower']/2/$nfig;
$sys['nrs']['produnit']=2048/($medprice);
$per=Fwz_fig($sys['nrs']['armysize']+$nfig)/Fwz_fig($sys['nrs']['armysize']);
$startpow=$sys['nrs']['ttpower']*($sys['nrs']['wepmod']/($sys['nrs']['wepmod']-1));
echo 'nfig:'. $nfig .' '.Fwz_fig($nfig) .'/'. Fwz_fig($nfig+1).' med:'. $medprice .' per:'.  $per .' truck time power:'. $sys['nrs']['ttpower'] .' suggStart:'. $startpow;
$sys['nrs']['percent']=.2; //max 66 * .08 :( = 5.28 or 90 *.06 (633) ||now: .05 and 120
$sys['nrs']['unitprice']=$medprice/2;
$sys['nrs']['structureHPScale']=$sys['nrs']['dmgunit']*Fwz_fig($sys['nrs']['armysize'])/Fwz_fig(40)*.9; //scale structures hp with army size.
//$power=$sys['nrs']['oilpf']*$sys['nrs']['time']*55/100*$sys['nrs']['percent']; //55 power gen param
$trpower=$sys['nrs']['ttpower']/2/$sys['nrs']['percent'];
$sys['nrs']['armypower']=$trpower;
//$sys['nrs']['armypower']=$trpower;
//$power2=$sys['nrs']['oilpp']*$sys['nrs']['time']*55/100*1/5;
//$power3=($power+$power2)/2;
//$rpoint=32*$power*$sys['nrs']['intIncome'];
//$rpoint=$power*$sys['nrs']['intIncome'];
//$sys['nrs']['restime']=$sys['nrs']['trtime'];
$sys['wz']['fleauscale']=$sys['nrs']['ttpower']/1.5; //was 2 assume scouting now ?
$sys['nrs']['rpoint']=$sys['nrs']['powerpersec']*$sys['nrs']['time']/5*$sys['nrs']['powerunit'];
//$sys['nrs']['stdrpoint']=$rpoint/$sys['nrs']['stdNumStep'];
$sys['nrs']['rspeed']=ceil($rpoint/$sys['nrs']['time']);
//$testfleau=pow(Fwz_fleau($sys['nrs']['ttpower']),$sys['nrs']['stdNumStep']);
$testfleau=Fwz_fleau($sys['nrs']['ttpower']);

function Fnrs_powercomp($x2){
	global $sys;
		$baseprice=$x2/75;
		$baseprice=$x2;
		//$baseprice=100;
		$x=2;
		$baseN=$sys['nrs']['armypower']/$baseprice/$x;
		//$x=$x2/$baseprice*2;
		//$x=$x2;
		$b=pow(1.2,3);
		//$smed=Fwz_fig($sys['nrs']['armypower']*$x/$baseprice)/Fwz_fig($sys['nrs']['armypower']/$baseprice)*$b;
		//$shvy=Fwz_fig($sys['nrs']['armypower']/$baseprice)*$smed/Fwz_fig($sys['nrs']['armypower']/$x/$baseprice)*$b;
		
		//echo '<br>smed:'. $smed .' xx'. $shvy .' x='. $x;
		//return Fwz_fig($sys['nrs']['armypower']*$x/$baseprice)/(Fwz_fig($sys['nrs']['armypower']/$x/$baseprice)*$shvy);
		return Fwz_fig($baseN*pow($x,2))/( pow(Fwz_fig($baseN*$x),2)*$b );
		
}

//$testNewt=newton('Fnrs_powercomp',1,300);
//$x=$testNewt;
//echo 'testnewt:'. $testNewt .'=='. $sys['nrs']['armypower']/$testNewt .'/'. ($sys['nrs']['armypower']/$x/$x/40) .'| '. Fwz_fig($sys['nrs']['armypower']/40);


echo '<B> WELCOME TO NRS :D </B>tf:'. $testfleau .'!';
 $sys['nrs']['bankval']=$trpower*1/5;
//$sys['nrs']['interest']=pow($testfleau/1.1,5/$sys['nrs']['trtime']);
$sys['nrs']['interest']=pow($testfleau,5/$sys['nrs']['trtime']);
//$sys['nrs']['basepower']=$sys['nrs']['powerpersec']*5/($sys['nrs']['interest']-1);
//$sys['nrs']['basepower']=$sys['nrs']['powerpersec']*5/($sys['nrs']['interest']-1);
$sys['nrs']['basepower']=$sys['nrs']['ttpower']*($sys['nrs']['wepmod']/($sys['nrs']['wepmod']-1));
echo 'rpoint:'. $sys['nrs']['rpoint'] .' '. $sys['nrs']['trtime'] .' '. $testfleau .' startpower'. $trpower*3/5  .' bank amount'.  $sys['nrs']['bankval'];
//echo '<br>ttpower'. $sys['nrs']['ttpower'] .' '. $sys['nrs']['restime'] .' '. $testfleau .' startpower'. $trpower*3/5  .' bank amount'.  $sys['nrs']['bankval'];
echo '<br>ttpower'. $sys['nrs']['ttpower'] .' armypower:'.  $sys['nrs']['armypower'] .' '. $sys['nrs']['trtime'] .' '. $testfleau .' basepower:'. $sys['nrs']['basepower'] .' bank amount'.  $sys['nrs']['bankval'];
echo '<br><b>structureHPScale:'. $sys['nrs']['structureHPScale'] .'</b>';
echo '<br>INTEREST PER 5='. $sys['nrs']['interest'];
//echo '<br>INTEREST PER 5='. pow(Fwz_fleau($sys['nrs']['ttpower']/$sys['nrs']['trtime']*4.5),$sys['nrs']['stdNumStep']) ;
$sys['nrs']['subclsses']=['',"CANNON","MORTARS","MISSILE","ROCKET","ENERGY","GAUSS","FLAME","HOWITZERS","MACHINE GUN","A-A GUN","SLOW MISSILE","SLOW ROCKET","BOMB","COMMAND","EMP","LAS_SAT",];
//ELECTRONIC
$sys['nrs']['startres']="R-Wpn-MG1Mk1";
$sys['nrs']['startres']="R-Fac-start";

echo "OL:". Fwz_fig(50)/Fwz_fig(30);

include('mod.php');
$realbasedir='./base/';
$basedir='./mp3.4/';
$dir2120='./2120/';
//$dirnrs='./8c-oligarchyNRSpV150/';
//$savedir='C:\Users\patag\AppData\Roaming\Warzone 2100 Project\Warzone 2100 4.0\mods\multiplay\NRS';
$savedir='./NRS/';
$sys['nrs']['dir']['base']='./mp3.4/';
$sys['nrs']['dir']['2120']='./2120/';
$sys['nrs']['dir']['save']='./NRS/';
//$str=file($basedir .'stats/weapons.json');
//$handle=fopen($basedir .'stats/weapons.json',"r");
//$handle=fopen($basedir .'stats/weapons.json',"r");
//$str=fread($handle, 128000000);
//print_r($str);
//$base['weapons.json'] = json_decode($str, TRUE);
//$handle=fopen($basedir .'stats/research.json',"r");
//$str=fread($handle, 128000000);
$str=file_get_contents($dir2120 .'stats/weapons.json');
$sys['nrs']['2120']['weapons']= json_decode($str, TRUE);
$str=file_get_contents($dir2120 .'stats/research.json');
$sys['nrs']['2120']['research']= json_decode($str, TRUE);
$sys['nrs']['2120']['body']= json_decode(file_get_contents($dir2120 .'stats/body.json'), TRUE);
//print_r($sys['nrs']['2120-weapons']);

$str=file_get_contents($basedir .'stats/weapons.json');
$sys['nrs']['file']['stat']['weapons']= json_decode($str, TRUE);
$sys['nrs']['base']['weapons']=$sys['nrs']['file']['stat']['weapons'];
$str=file_get_contents($basedir .'stats/research.json');
$sys['nrs']['file']['stat']['research']= json_decode($str, TRUE);
//$str=file_get_contents($basedir .'stats/structure.json');
//$sys['nrs']['file']['stat']['structure']= json_decode($str, TRUE);
$sys['nrs']['base']['body']= json_decode(file_get_contents($basedir .'stats/body.json'), TRUE);
$sys['nrs']['base']['structure']= json_decode(file_get_contents($basedir .'stats/structure.json'), TRUE);
$sys['nrs']['2120']['structure']= json_decode(file_get_contents($dir2120 .'stats/structure.json'), TRUE);
//$sys['nrs']['nrs']['structure']= json_decode(file_get_contents($dirnrs .'stats/structure.json'), TRUE);
$sys['nrs']['base']['propulsion']= json_decode(file_get_contents($basedir .'stats/propulsion.json'), TRUE);
$sys['nrs']['file']['stat']['propulsion']= $sys['nrs']['base']['propulsion'];
$sys['nrs']['base']['repair']= json_decode(file_get_contents($basedir .'stats/repair.json'), TRUE);
$sys['nrs']['file']['stat']['repair']= $sys['nrs']['base']['repair'];
$nextfile='sensor';
$sys['nrs']['base']['sensor']= json_decode(file_get_contents($basedir .'stats/'. $nextfile .'.json'), TRUE);
$sys['nrs']['file']['stat'][$nextfile]= $sys['nrs']['base'][$nextfile];
$nextfile='templates';
$sys['nrs']['file']['stat'][$nextfile]= json_decode(file_get_contents($basedir .'stats/'. $nextfile .'.json'), TRUE);
$nextfile='construction';
$sys['nrs']['base'][$nextfile]=json_decode(file_get_contents($basedir .'stats/'. $nextfile .'.json'), TRUE);
$sys['nrs']['file']['stat'][$nextfile]= json_decode(file_get_contents($basedir .'stats/'. $nextfile .'.json'), TRUE);
$basedir='./base/';
$nextfile='features';
$sys['nrs']['file']['stat'][$nextfile]= json_decode(file_get_contents($basedir .'stats/'. $nextfile .'.json'), TRUE);
$nextfile='propulsiontype';
$sys['nrs']['file']['stat'][$nextfile]= json_decode(file_get_contents($basedir .'stats/'. $nextfile .'.json'), TRUE);
$nextfile='brain';
$sys['nrs']['base'][$nextfile]= json_decode(file_get_contents($realbasedir .'stats/'. $nextfile .'.json'), TRUE);
$sys['nrs']['file']['stat'][$nextfile]= $sys['nrs']['base'][$nextfile];
//$nextfile='weaponmodifier';
//$sys['nrs']['file']['stat'][$nextfile]=json_decode(file_get_contents($basedir .'stats/'. $nextfile .'.json'), TRUE);
//print_r($data);
//Fwz_import_comp($data,$data2120,'structures','A0ResearchFacility','-2120',$savedir,$dir2120);
$file='2120-weapons';
$name='RailGun1Mk1';
echo '---------------this is a faster line';
/*
	$comp=Fwz_get($from[$file],'ID',$name);
	if(!$comp){
		$comp=Fwz_get($from[$file],'name',$name);
	}
	*/
	//$comp=$sys['nrs']['2120-weapons'][$name];
	//print_r($comp);
//Fwz_pieSweap($sys['nrs'],$sys['nrs'],$file,$sys['nrs']['2120-weapons'][$name],'-2120',$savedir,$dir2120,'','');

/*
foreach ($sys['nrs']['base-weapons'] as $nom => $val){
		Fwz_eval34($val,'weapons');
		echo '<br><b>'. $nom .'='. $val['value'] .' '. $val['evalStr'] .'</b>';
		//print_r($val);
}
*/
$mods=['base','2120'];
foreach($mods as $no => $modname){
	$listtype='body';
	foreach($sys['nrs'][$modname][$listtype] as $nom=>$val){
			//echo $nom .','. $val['name'] .' '.  $val['size'] .'<br>';
			$sys['nrs'][$modname][$listtype][$nom]['armourKinetic']=0;
			$sys['nrs'][$modname][$listtype][$nom]['armourHeat']=0;
			
	}
	$listtype='propulsion';
	foreach($sys['nrs'][$modname][$listtype] as $nom=>$val){
			//echo $nom .','. $val['name'] .' '.  $val['size'] .'<br>';
			$sys['nrs'][$modname][$listtype][$nom]['speed']*=10;
			
	}
	$listtype='structure';
	foreach($sys['nrs'][$modname][$listtype] as $nom=>$val){
			//echo $nom .','. $val['name'] .'<br>';
			$sys['nrs'][$modname][$listtype][$nom]['armour']=0;
			$sys['nrs'][$modname][$listtype][$nom]['thermal']=0;
			$sys['nrs'][$modname][$listtype][$nom]['buildPower']/=10*$sys['nrs']['armypower']/1000;
			$sys['nrs'][$modname][$listtype][$nom]['buildPoints']=max(1,$sys['nrs'][$modname][$listtype][$nom]['buildPoints']*.8);
			$sys['nrs'][$modname][$listtype][$nom]['strength']='HARD';
			//$sys['nrs'][$modname][$listtype][$nom]['repairPoints']*=$sys['nrs']['dmgunit'];
			
			if( $sys['nrs'][$modname][$listtype][$nom]['type']!="DEFENSE"){
				$sys['nrs'][$modname][$listtype][$nom]['hitpoints']*=2*$sys['nrs']['structureHPScale'];
			}
			//$sys['nrs'][$modname][$listtype][$nom]['hitpoints']*=$sys['nrs']['dmgunit'];
			
	}
	$listtype='weapons';
	foreach($sys['nrs'][$modname][$listtype] as $nom=>$val){
			echo $nom .','. $val['name'] .' '. $val['weaponSubClass']  .'<br>';
			$sys['nrs'][$modname][$listtype][$nom]['armour']=0;
			$sys['nrs'][$modname][$listtype][$nom]['thermal']=0;
			$sys['nrs'][$modname][$listtype][$nom]['flags']='ShootAir';
			
			//        "flags": "ShootAir",
	}
	$listtype='sensor';
	foreach($sys['nrs'][$modname][$listtype] as $nom=>$val){
			$sys['nrs'][$modname][$listtype][$nom]['range']*=1.25;
			//echo $nom .','. $val['name'] .' '. $val['weaponSubClass']  .'<br>';
	}
	$listtype='construction';
	foreach($sys['nrs'][$modname][$listtype] as $nom=>$val){
	//	$sys['nrs'][$modname][$listtype][$nom]['constructPoints']*=$sys['nrs']['dmgunit'];
	}
	$listtype='repair';
	foreach($sys['nrs'][$modname][$listtype] as $nom=>$val){
		$sys['nrs'][$modname][$listtype][$nom]['repairPoints']*=$sys['nrs']['dmgunit'];
	}
	
	
	//$listtype='template';
	//foreach($sys['nrs'][$modname][$listtype] as $nom=>$val){
	//}
}
	$sys['nrs']['base']['structure']['A0ResourceExtractor']['buildPower']=40;
	$sys['nrs']['base']['structure']['A0ResourceExtractor']['buildPoints']=240;
	$resourcesNames2=['Work','Service','Electric', 'Pop','density','rich', 'environement','War','F','B','C'];
	//"A0ComDroidControl","A0ResourceExtractor","A0BaBaPowerGenerator","A0PowerGenerator",
	//"","","Heavywepslab-nrs","Rotarywepslab-nrs","Aerodynamicslab-nrs","Advmaterialslab-nrs",
	
	$structureData = [
		'A0ResourceExtractor'=>	[0,1,3, -1,0,1, -2,0,0,0,0],
		'Aerodynamicslab'=>		[2,0,-2, 0,0,0, 1,1,0,0,0],
		'Heavywepslab'=>		[2,0,-1, 0,0,0, 1,3,0,0,0],
		'Advmaterialslab'=>		[3,0,-1, 0,0,0, 0,0,0,0,0],
		'Rotarywepslab'=>		[1,0,-1, 0,0,0, -1,2,0,0,0],
		'Powlab'=>				[0,1,2, 0,1,0, -1,-2,0,0,0],
		'SolarPower'=>			[-1,0,2, 0,-1,0, 1,0,0,0,0],
		'NuclearReactor'=>		[-1,0,2, 0,1,0, 1,-2,0,0,0],
		'CoolingTower'=>		[-1,1,1, 0,0,0, 0,-2,0,0,0],
		'Propaganda'=>		[0,1,-1, 0,-1,-1, 0,2,0,0,0],
		'Pickup'=>			[0,2,0, 1,-1,-1, -1,0,0,0,0],
		'road'=>			[0,3,0, 0,-1,1, -1,0,0,0,0],
		'BarbWarehouse2'=>	[1,2,0, -1,1,0, -1,0,0,0,0],
		'BarbWarehouse1'=>	[2,2,-1, -1,0,0, 0,0,0,0,0],
		'BarbWarehouse3'=>	[1,2,0, -1,0,1, -1,0,0,0,0],
		'OilTower'=>		[1,1,-2, 0,0,1, -1,-2,0,0,0],
		'WaterTower'=>		[0,1,0, -1,0,0, 1,0,0,0,0],
		'AirTrafficControl'=>[0,1,-2, -2,0,1, -1,1,0,0,0],
		'Ruin1'=>				[-2,0,0, 2,-1,-1, 0,0,0,0,0],
		'BarbHUT'=>			[-1,-1,0, 2,-1,-1, 0,0,0,0,0],
		'cabin'=>			[0,-2,0, 2,-1,1, 0,0,0,0,0],
		'LogCabin3'=>		[-1,-1,0, 1,0,2, 0,0,0,0,0],
		'building3'=>		[-2,-2,0, 2,0,-1, 0,0,0,0,0],
		'building2'=>		[-1,-1,0, 2,1,1, 0,0,0,0,0],
		'building11'=>		[-2,-2,0, 3,2,-1, 0,0,0,0,0],
		'building12'=>		[-1,-1,0, 2,2,1, -1,0,0,0,0],
		'building10'=>		[-1,-2,0, 2,2,1, 0,0,0,0,0],
		'Park'=>			[0,-1,0, -2,0,1, 2,0,0,0,0],
		'Forest'=>			[0,0,0, -1,-1,0, 2,0,0,0,0],
		'BigForest'=>		[0,0,0, 0,-2,0, 2,0,0,0,0],
		'Tree'=>			[0,0,0, 0,1,0, 2,-1,0,0,0],
		'Boulder3'=>		[0,0,0, 0,1,0, 2,0,-1,0,0],
		'Boulder2'=>		[0,0,0, 0,0,0, 2,0,-1,0,0],
		'Boulder1'=>		[0,0,0, 0,1,0, 2,0,-1,0,0],
		'arizonabush3'=>	[0,1,0, -1,0,0, 2,-1,0,0,0],
		'Tree'=>			[0,0,0, 0,1,0, 2,-1,0,0,0],
	//"A0FacMod1","A0PowMod1","A0BaBaFactory","A0Sat-linkCentre","A3CommandCentre","A2CommandCentre","A1CommandCentre","A0CommandCentre","A0HardcreteMk1Gate","A0HardcreteMk1Wall","barrier-nrs","A0BaBaHorizontalWall","A0TankTrap","epicRepair-nrs","Crane-nrs","A0RepairCentre3","ScavRepairCentre"	
	];
	print_r($structureData);
	
	$id='A0ResourceExtractor'; $t2=$sys['nrs']['base']['structure'][$id];
	$sys['nrs']['nrs']['structure'][$id]=$t2;
	$id='NuclearReactor'; $t2=$sys['nrs']['base']['structure'][$id];
	$sys['nrs']['nrs']['structure'][$id]=$t2;
	$id='CoolingTower'; $t2=$sys['nrs']['base']['structure'][$id];
	$sys['nrs']['nrs']['structure'][$id]=$t2;
/*
foreach($sys['nrs']['2120'][$listtype] as $nom=>$val){
		echo $nom .','. $val['name'] .'<br>';
		$sys['nrs']['2120'][$listtype][$nom]['armourKinetic']=0;
		$sys['nrs']['2120'][$listtype][$nom]['armourHeat']=0;
}
*/
$sys['nrs']['file']['stat']['structure']=$sys['nrs']['base']['structure'];
$sys['nrs']['file']['stat']['body']= $sys['nrs']['base']['body'];
$sys['nrs']['file']['stat']['construction']['Spade1Mk1']['weight']=350;
//$sys['nrs']['file']['stat']['construction']['Spade1Mk1']['constructPoints']*=$sys['nrs']['dmgunit'];

/*    "R-Struc-Power-Upgrade01": {
        "iconID": "IMAGE_RES_POWERTECH",
        "id": "R-Struc-Power-Upgrade01",
        "imdName": "blpower4.pie",
        "keyTopic": 1,
        "msgName": "RES_POWU1",
        "name": "Gas Turbine Generator",
        "requiredResearch": [
            "R-Struc-Research-Upgrade04",
            "R-Struc-PowerModuleMk1"
        ],
        "researchPoints": 6000,
        "researchPower": 187,
        "results": [
            {
                "class": "Building",
                "parameter": "PowerPoints",
                "value": 50
            }
        ],
        "subgroupIconID": "IMAGE_RES_GRPUPG"
    },
	                "class": "Body",
                "filterParameter": "BodyClass",
                "filterValue": "Droids",
                "parameter": "HitPointPct",
	
	*/

Fnrs_upgradeline("Building","",'','PowerPoints','power',$sys['nrs']['startres'],1,'Power upgrade');
Fnrs_upgradeline("Building","",'','ResearchPoints','Research speed',$sys['nrs']['startres'],1,'research speed');
Fnrs_upgradeline("Building","",'','ProductionPoints','Prod speed',$sys['nrs']['startres'],1,'production speed');
Fnrs_upgradeline("Construct","",'','ConstructorPoints','Research speed',$sys['nrs']['startres'],1,'construction speed');
Fnrs_upgradeline("Body","BodyClass",'Droids','HitPointPct','HP',$sys['nrs']['startres'],1,'ALL units hp');
Fnrs_upgradeline("Building","Type",'Wall','HitPoints','wallHP',$sys['nrs']['startres'],1,'structure HP');
Fnrs_upgradeline("Sensor","",'','Range','Sensor',$sys['nrs']['startres'],1,'sensor range');
//Fnrs_upgradeline("Sensor","",'','Engine??','Sensor',$sys['nrs']['startres'],1,'sensor range');

/*
                "class": "Building",
                "filterParameter": "Type",
                "filterValue": "Wall",
                "parameter": "HitPoints",
				*/
//weapmod
//$sys['nrs']['file']['stat'][$nextfile]
//$sys['nrs']['file']['stat']['repair']['ZNULLREPAIR']['repairPoints']=100;
//$sys['nrs']['file']['stat']['repair']['ZNULLREPAIR']['time']=75;

$fac='free';


$fac='start';

//Fnrs_genprop('BaBaLegs',$fac,'BaBaLegs',100);
Fnrs_genprop('CyborgLegs',$fac,'CyborgLegs',100,"Legged");
Fnrs_genprop('wheeled01',$fac,'wheeled01',100);
Fnrs_genprop('tracked01',$fac,'tracked01',130,"Tracked");

//Fnrs_genprop('Naval',$fac,'Naval',115,"Propellor");
//Fnrs_genprop('Helicopter',$fac,'Helicopter',115,"Lift");

Fnrs_genprop('hover01',$fac,'hover01',85,"Hover");
Fnrs_genprop('HalfTrack',$fac,'HalfTrack',115,"Tracked");

$t2=$sys['nrs']['file']['stat']['structure']['A0RepairCentre3'];
$t1['id']='Crane'; $t2['id']=$t1['id'];
$t2["type"]=  "REPAIR FACILITY";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["repairPoints"]= 100;
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*10*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Pylon'; $t2['id']='epicRepair';
$t2["type"]=  "REPAIR FACILITY";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["repairPoints"]= 100;
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*10*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

//Fnrs_add([ 'faction'=> $fac, 'use'=> "A0CyborgFactory", 'in'=>'base', 'type'=> 'structure', 'as' => ['lgt','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "ScavRepairCentre", 'in'=>'base', 'type'=> 'structure', 'as' => ['med','hitech','vshort',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0RepairCentre3", 'in'=>'base', 'type'=> 'structure', 'as' => ['med','hitech','vshort',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Crane", 'in'=>'nrs', 'type'=> 'structure', 'as' => ['med','hitech','vshort',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "niceCrane", 'in'=>'nrs', 'type'=> 'structure', 'as' => ['med','hitech','short',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "goodRepair", 'in'=>'nrs', 'type'=> 'structure', 'as' => ['med','hitech','short',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "epicRepair", 'in'=>'nrs', 'type'=> 'structure', 'as' => ['med','hitech','vshort',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "Crane", 'in'=>'nrs', 'type'=> 'structure', 'as' => ['med','hitech','vshort',''] ]);

$t2=$sys['nrs']['file']['stat']['structure']['A0HardcreteMk1Wall'];
$t1['id']='barrier'; $t2['id']=$t1['id'];
$t2["type"]=  "GATE";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t2=$sys['nrs']['file']['stat']['structure']['A0CommandCentre'];
$t2['id']='A1CommandCentre';
$t2['name']='Financial center';
$t2['structureModel']=['blhq2.pie'];
$sys['nrs']['base']['structure'][$t2['id']]=$t2;
$t2['id']='A2CommandCentre';
$t2['name']='Bank';
$t2['structureModel']=['blhq3.pie'];
$sys['nrs']['base']['structure'][$t2['id']]=$t2;
$t2['id']='A3CommandCentre';
$t2['name']='Honor hall';
$t2["buildPower"]= 50;
$t2['structureModel']=['blhq4.pie'];
$sys['nrs']['base']['structure'][$t2['id']]=$t2;

Fnrs_add([ 'faction'=> $fac, 'use'=> "A0TankTrap", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','joke','','short'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0BaBaHorizontalWall", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','joke','','short'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "barrier", 'in'=>'nrs', 'type'=> 'structure', 'as' => ['hvy','joke','','short'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0HardcreteMk1Wall", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','joke','','short'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0HardcreteMk1Gate", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','joke','','short'] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "SensorTower2Mk1", 'in'=>'base', 'type'=> 'sensor', 'as' => ['med','AW','lowtech'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Sys-CBTurret01", 'in'=>'base', 'type'=> 'sensor', 'as' => ['med','AW','lowtech'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Sys-VTOLCBTower01,Sys-VTOLCBTurret01,Sys-VTOLRadarTower01,Sys-VstrikeTurret01", 'in'=>'base', 'type'=> 'sensor', 'as' => ['med','AW','lowtech'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "RadarDetector", 'in'=>'base', 'type'=> 'sensor', 'as' => ['med','AW','lowtech'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Sensor-WideSpec", 'in'=>'base', 'type'=> 'sensor', 'as' => ['med','AW','lowtech'] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "Spade1Mk1", 'in'=>'base', 'type'=> 'construction', 'as' => ['med','AP','insta','exshort','','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "CyborgSpade", 'in'=>'base', 'type'=> 'construction', 'as' => ['lgt','AP','insta','exshort','','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0CommandCentre", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','AP','insta','exshort','','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A1CommandCentre", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','AP','insta','exshort','','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A2CommandCentre", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','AP','insta','exshort','','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A3CommandCentre", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','AP','insta','exshort','','fake'] ]);


/*
	enableStructure("A0CommandCentre", player)
	enableStructure("A0CyborgFactory", player);
	
	
	enableStructure("A0BaBaFactory", player);
*/

Fnrs_add([ 'faction'=> $fac, 'use'=> "CyborgLightBody", 'in'=>'base', 'type'=> 'body', 'as' => ['lgt','AS','insta','exshort','Cyb','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "CyborgHeavyBody", 'in'=>'base', 'type'=> 'body', 'as' => ['med','AS','insta','exshort','Cyb','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "CyborgHeavyBody", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','AS','insta','exshort','Cyb','fake'] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "CCSensor", 'in'=>'base', 'type'=> 'sensor', 'as' => ['med','AW','lowtech'] ]);

/*
SensorTurret1Mk1,Sensor Turret
Sys-CBTurret01,CB Radar Turret

SensorTower2Mk1,Hardened Sensor Tower
RadarDetector,Radar Detector
Sensor-WideSpec,Wide Spectrum Sensor
CCSensor,*CC Sensor*
UplinkSensor,Uplink Sensor

*/

//hitpointPctOfBody

/*                "class": "Construct",
                "parameter": "ConstructorPoints",*/
				
//Fwz_eval34($data['MG3Mk1'],'weapons');
//print_r($data['MG3Mk1']);

//Fnrs_add([ 'faction'=> 'nexus', 'use'=>"AAGunLaser", 'in'=>'NTW-weapons', 'as' => ['med','AP','hightech','longrange','weapon'] ]);


//prStr2($data2,$step*20,$target,'R-Start,R-Wpn-RailGun01-2120,R-Wpn-MG5-2120,R-Wpn-RailGun02-2120,R-Wpn-Cannon6TwinAslt-2120,R-Wpn-RailGun03-2120','',1.2,.10);
Fnrs_rlist('2120','R-Wpn-Cannon6TwinAslt');
Fnrs_rlist('2120','R-Wpn-RailGun03');

/*




*/



$fac='nexus';

Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser3BEAMMk1,Laser3BEAM-VTOL,Cyb-Wpn-Laser', 'in'=>'base','type'=> 'weapons', 'as' => ['hvy','AP','hightech','longrange','weapon'], 'call'=>'heavylaser' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>"Laser2PULSEMk1,Laser2PULSE-VTOL", 'in'=>'base','type'=> 'weapons', 'as' => ['hvy','AP','hightech','longrange','weapon'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>"AAGunLaser", 'in'=>'base','type'=> 'weapons', 'as' => ['hvy','AP','hightech','longrange','weapon','ground'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>"Laser3BEAMMk1,Laser3BEAM-VTOL", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AP','hightech',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>"Laser4-PlasmaCannon", 'in'=>'base','type'=> 'weapons', 'as' => ['hvy','AP','hightech','longrange','weapon'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>"HeavyLaser,HeavyLaser-VTOL,Cyb-Hvywpn-PulseLsr", 'in'=>'base','type'=> 'weapons', 'as' => ['hvy','AP','hightech','longrange','weapon'] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "RailGun1Mk1,Cyb-Wpn-Rail1", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange'], 'call'=>'rail'  ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "RailGun2Mk1,RailGun2-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "RailGun3Mk1,Cyb-Hvywpn-RailGunner", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon4AUTOMk1,CyborgCannon", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon5VulcanMk1,Cannon5Vulcan-VTOL,Cyb-Hvywpn-HPV", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon775mmMk1,Cannon7-VTOL,Cyb-Hvywpn-Lcannon", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG5TWINROTARY,Cyb-Hvywpn-Mcannon", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Cannon6TwinAslt,Cyb-Wpn-RailHyp', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange'] ]);



Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar1Mk1,Cyb-Wpn-Grenade", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AS','',''], 'call'=>'mortar' ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Howitzer105Mk1", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar0Mk1", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Howitzer150Mk1", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar2Mk1", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Howitzer03-Rot", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar3ROTARYMk1", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Howitzer150Mk1", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar2Mk1,Cyb-Wpn-Grenade", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);
//	Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar3ROTARYMk1", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar3ROTARYMk1,Cyb-Wpn-Grenade", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "Body11ABT", 'in'=>'base', 'type'=> 'body', 'as' => ['hvy','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body12SUP", 'in'=>'base', 'type'=> 'body', 'as' => ['hvy','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body9REC", 'in'=>'base', 'type'=> 'body', 'as' => ['hvy','insta','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body10MBT", 'in'=>'base', 'type'=> 'body', 'as' => ['hvy','insta','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body13SUP", 'in'=>'base', 'type'=> 'body', 'as' => ['hvy','insta','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body14SUP", 'in'=>'base', 'type'=> 'body', 'as' => ['hvy','insta','',''] ]);	

/*Body10MBT,Vengeance HEAVY
Body11ABT,Python HEAVY
Body12SUP,Mantis HEAVY
Body13SUP,Wyvern HEAVY
Body14SUP,Dragon HEAVY
Body9REC,Tiger HEAVY*/

//$sys['nrs']['base']['structure']['A0Sat-linkCentre']['buildPower']=2;
$sys['nrs']['base']['structure']['A0Sat-linkCentre']['buildPoints']=600;
$sys['nrs']['base']['structure']['A0Sat-linkCentre']['buildPower']=150;
echo '---------------this is a line';
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0Sat-linkCentre", 'in'=>'base', 'type'=> 'structure', 'as' => ['lgt','insta','vshort',''] ]);
//$sys['nrs']['file']['stat']['structure']['A0Sat-linkCentre']['buildPower']=50;
//$sys['nrs']['file']['stat']['structure']['A0Sat-linkCentre']['buildPoints']=150;

//Fnrs_add([ 'faction'=> $fac, 'use'=> "A0LasSatCommand", 'in'=>'base', 'type'=> 'structure', 'as' => ['lgt','','',''] ]);
//$sys['nrs']['file']['stat']['research']['R-Sys-Autorepair-General']['requiredResearch']=['R-Fac-'. $fac];
$id='R-Sys-Autorepair-General';
$sys['nrs']['file']['stat']['research']['R-Sys-Autorepair-General']['requiredResearch']=[$sys['nrs']['startres']];
$sys['nrs']['file']['stat']['research'][$id]['researchPoints']=$sys['nrs']['time']*10/8;
$sys['nrs']['file']['stat']['research'][$id]['researchPower']=$sys['nrs']['rpoint']/5;
$sys['nrs']['file']['stat']['repair']['AutoRepair']['repairPoints']=10;



$fac='BaBa';
$sys['nrs']['file']['stat']['templates']['BaBaPeople']['available']=true;
$sys['nrs']['base']['structure']['A0BaBaFactory']['productionPoints']=2*$sys['nrs']['powerunit'];

/*
const templates = [
    ["B4body-sml-trike01-Ultimate","bTrikeMG"],
    ["B3body-sml-buggy01-Ultimate","BuggyMG"],
    ["B2JeepBody-Ultimate","BJeepMG"],
    ["B3bodyRKbuggy01-Ultimate","BabaRocket"],
    ["B2RKJeepBody-Ultimate","BabaRocket"],
    ["BusBody","BusCannon"],
    ["BusBody","BabaPitRocketAT"],
    ["B2tractor","BabaFlame"],
    ["FireBody","BabaFlame"],
    ["FireBody","BusCannon"],
    ["FireBody","BabaPitRocket"],
    ["FireBody","BabaPitRocketAT"],
    ["ScavCamperBody","BabaPitRocket"],
    ["ScavCamperBody","BusCannon"],
    ["ScavIcevanBody","BabaFlame"],
    ["ScavIcevanBody","Mortar1Mk1"],
    ["ScavNEXUStrack","ScavNEXUSlink"],
];
*/

//Fnrs_add([ 'faction'=> $fac, 'use'=> "BaBaMG", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AP','insta',''], 'call'=>'machineguns']);
//B1BaBaPerson01

$t2=$sys['nrs']['base']['body']['B1BaBaPerson01'];
$t2['id']='B1BaBaPerson01-nrs';
$t2['droidType']='CYBORG';
$sys['nrs']['base']['body'][$t2['id']]=$t2;
echo 'ppppperson';
print_r($sys['nrs']['base']['body']['B1BaBaPerson01-nrs']);


Fnrs_add([ 'faction'=> $fac, 'use'=> "A0BaBaFactory,BaBaLegs,B1BaBaPerson01-nrs,scavCrane1,scavCrane2", 'in'=>'base', 'type'=> 'structure', 'as' => ['xlgt','insta','AS','baba'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "scavCrane1", 'in'=>'base', 'type'=> 'construction', 'as' => ['xlgt','AS','insta','exshort','designable'] ]);

//
Fnrs_add([ 'faction'=> $fac, 'use'=> "ScavCamperBody", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','designable','lowtech'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "ScavIcevanBody", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','designable',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "B3body-sml-buggy01-Ultimate", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','designable',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "B2tractor", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','designable',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "ScavNEXUStrack", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','designable',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BusBody", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','designable',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "B2JeepBody-Ultimate", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','designable',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "FireBody", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','designable',''] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "B4body-sml-trike01-Ultimate", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','lowtech','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "B3bodyRKbuggy01-Ultimate", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','fake',''] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "BusCannon,bTrikeMG", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AN','lowtech','designable'], 'call'=>'scavenger']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BabaRocket", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AN','designable','FOM'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BabaFlame", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AN','designable','FOM'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BabaPitRocket", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AN','designable',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BabaPitRocketAT", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AN','designable',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "ScavNEXUSlink", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AN','designable','FOM'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BuggyMG", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AN','lowtech','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BJeepMG", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AN','lowtech','fake'] ]);



$fac='project';


Fnrs_add([ 'faction'=> $fac, 'use'=> "MG1Mk1,MG1-VTOL,CyborgChaingun", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AP','lowtech',''], 'call'=>'machinegun']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG2Mk1,MG2-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AP','insta',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG3Mk1,MG3-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AP','insta',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG4ROTARYMk1,MG4ROTARY-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AP','insta',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG5TWINROTARY,CyborgRotMG", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AP','insta',''] ]);

//Fnrs_add([ 'faction'=> $fac, 'use'=> "BusCannon,CyborgCannon", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AW','lowtech',''], 'call'=>'cannon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon1Mk1,Cannon1-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AW','lowtech',''], 'call'=>'cannon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon2A-TMk1,Cyb-Hvywpn-Mcannon", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AW','lowtech',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon375mmMk1,MG4ROTARY-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AW','lowtech',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon4AUTOMk1,Cannon4AUTO-VTOL,Cyb-Hvywpn-Acannon", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AW','lowtech',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon5VulcanMk1,Cannon5Vulcan-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AW','lowtech',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon6TwinAslt,Cyb-Hvywpn-HPV", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AW','lowtech',''] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame1Mk1,CyborgFlamer01", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AT','',''], 'call'=>'flammer' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame2,Cyb-Wpn-Thermite", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "PlasmiteFlamer", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame1Mk1,CyborgFlamer01", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['lgt','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['lgt','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame3Mk1,Cyb-Wpn-Thermite", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['lgt','AT','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "PlasmiteFlamer", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['lgt','AT','',''] ]);

//Fnrs_add([ 'faction'=> $fac, 'use'=> "CommandBrain01", 'in'=>'base', 'type'=> 'brain', 'as' => ['hvy','AW','joke',''] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "Body1REC", 'in'=>'base', 'type'=> 'body', 'as' => ['lgt','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body4ABT", 'in'=>'base', 'type'=> 'body', 'as' => ['lgt','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body2SUP", 'in'=>'base', 'type'=> 'body', 'as' => ['lgt','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body3MBT", 'in'=>'base', 'type'=> 'body', 'as' => ['lgt','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body3MBT", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','insta','',''] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "A0PowMod1", 'in'=>'base', 'type'=> 'structure', 'as' => ['lgt','early','weak',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "LightRepair1,CyborgRepair", 'in'=>'base', 'type'=> 'repair', 'as' => ['med','AW','exshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "HeavyRepair", 'in'=>'base', 'type'=> 'repair', 'as' => ['med','AW','exshort'] ]);

$fac='collective';
$fac='Paradigm';

Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-Pod", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AT','',''], 'call'=>'rocket' ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "BabaPitRocketAT,CyborgRocket", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AT','',''], 'call'=>'rocket' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-LtA-T,Cyb-Wpn-Atmiss", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-Pod", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-HvyA-T,Cyb-Hvywpn-TK", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AT','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-PodMk2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-A-T,Cyb-Hvywpn-TK", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AT','',''] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "RailGun1Mk1,RailGun1-VTOL,Cyb-Wpn-Rail1", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange'], 'call'=>'quark' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "RailGun2Mk1,RailGun002-VTOL,Cyb-Hvywpn-RailGunner2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'RailGun3Mk1,RailGun3-VTOL,Cyb-Hvywpn-RailGunner', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'RailGun4Mk1,RailGun4-VTOL', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'RailGun5Mk1,RailGun5-VTOL', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'RailGun6Mk1,RailGun6-VTOL,Cyb-Hvywpn-RailGunner', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange'] ]);




Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-BB", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AS','hitech',''], 'call'=>'ASrocket' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-Sunburst", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AS','hitech',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-BB", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['lgt','AS','hitech',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Missile-BB', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['lgt','AS','hitech',''] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "A0FacMod1", 'in'=>'base', 'type'=> 'structure', 'as' => ['lgt','early','',''] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "Body1UPG", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body2SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body3MBT", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body3SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body3ALT", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body4ABT", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body4UPG", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','','',''] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "Body5REC", 'in'=>'base', 'type'=> 'body', 'as' => ['med','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body8MBT", 'in'=>'base', 'type'=> 'body', 'as' => ['med','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body6SUPP", 'in'=>'base', 'type'=> 'body', 'as' => ['med','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body7ABT", 'in'=>'base', 'type'=> 'body', 'as' => ['med','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body7ALT", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','insta','',''] ]);




$fac='doom';
$fac='allon';
$sys['nrs']['2120']['weapons'][ "Rocket-LtA-T2"]['name']="2120 lancer";
//Rocket-HvyA-T,Rocket-HvyA-T2,Rocket-IDF,Rocket-IDF2,Rocket-LtA-T,Rocket-LtA-T2,
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-HvyA-T,Cyb-Hvywpn-A-T,Cyb-Hvywpn-Acannon", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AT','',''], 'call'=>'heavyrocket' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-HvyA-T2,Cyb-Hvywpn-A-T2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-MRL,CyborgRocket", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AT','',''] ]);
//Fnrs_add([ 'faction'=> 'nexus', 'use'=> "Rocket-IDF2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-LtA-T,Cyb-Wpn-Atmiss", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-LtA-T2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AT','',''] ]);
$sys['nrs']['2120']['weapons']['Missile-A-T']['reloadTime']=95;
Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-A-T,Cyb-Wpn-Atmiss2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AT','',''] ]);




Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-MRL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AS','',''], 'call'=>'indirectmissile' ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-IDF", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AS','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-MdArt", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AS','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-IDF", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AS','',''] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-HvyArt", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AS','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-MdArt", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AS','',''] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-HvyArt", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AS','',''] ]);
	
	Fnrs_add([ 'faction'=> $fac, 'use'=> "MG1Mk1,MG1-VTOL,CyborgChaingun", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','',''], 'call'=>'mediumlaser' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG2Mk1,MG2-VTOL", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','',''] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "MG7LGTGATTLINGMk1,MG7LGTGATTLING-VTOL,CyborgChaingunMed", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG3Mk1,MG3-VTOL", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','',''] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "MG7MEDGATTLINGMk1,MG7MEDGATTLING-VTOL", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG4ROTARYMk1,MG4ROTARY-VTOL,Cyb-Wpn-Laser", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','',''] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "MG7GATTLINGMk1,MG7GATTLING-VTOL", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','',''] ]);
		Fnrs_add([ 'faction'=> $fac, 'use'=> "Laser2PULSEMk1,Laser2PULSE-VTOL,Cyb-Hvywpn-PulseLsr", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','',''] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "Body7ALT", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body8MBT", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body8UPG", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body16MBTT", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body25DKD", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body6SUPP", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body7SUPP", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','','',''] ]);
	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body9REC", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body10REC", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body12SUPP", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body10ALT", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body7ABT", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body11UPG", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body12SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body12UPG", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body14SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body13SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body17SUUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body26SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body27SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','','',''] ]);



//$sys['nrs']['base']['structure']['A0ResearchFacility']['buildPower']=0;
//$sys['nrs']['base']['structure']['A0ResearchFacility']['buildPoints']=0;


$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']=$sys['nrs']['base']['structure']['A0ResearchFacility'];
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['name']='quick labs';
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['structureModel']=['aerolab.pie'];
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['buildPower']=($sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['buildPower'])*$sys['nrs']['powerunit'];
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['hitpoints']=100*$sys['nrs']['dmgunit'];
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['buildPoints']=1;
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['id']='A0ResearchFacility-nrs';
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility']['buildPower']=50*$sys['nrs']['powerunit'];




/*
$sys['nrs']['2120']['structure']['A0ResearchFacility']['name']="x3 research lab";
$sys['nrs']['2120']['structure']['A0ResearchFacility']['buildPower']=300;
$sys['nrs']['2120']['structure']['A0ResearchFacility']['researchPoints']=14*3;
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0ResearchFacility", 'in'=>'2120', 'type'=> 'structure', 'as' => ['lgt','insta','',''] ]);
*/

$sys['nrs']['2120']['structure']['A0ResearchFacility']['name']="x3 research lab";
$sys['nrs']['2120']['structure']['A0ResearchFacility']['buildPower']=300*$sys['nrs']['powerunit'];
$sys['nrs']['2120']['structure']['A0ResearchFacility']['researchPoints']=14*3;
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-2120']=$sys['nrs']['2120']['structure']['A0ResearchFacility'];
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-2120']['id']='A0ResearchFacility-2120';
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['structureModel']=['nanolab.pie'];
//Fnrs_add([ 'faction'=> $fac, 'use'=> "A0ResearchFacility", 'in'=>'2120', 'type'=> 'structure', 'as' => ['lgt','insta','',''] ]);


/*
Body10ALT,Komodo Dragon HEAVY
Body7ABT,Drake MEDIUM
Body11UPG,Armageddon HEAVY
Body12SUP,Hornet HEAVY
Body12UPG,Raymantis HEAVY
Body14SUP,NightWing HEAVY
Body13SUP,Horror Wyvern HEAVY
Body17SUUP,GiGaHornet HEAVY
Body9REC,Diamond HEAVY
Body10REC,SharkWhale HEAVY
Body12SUPP,BlueWhale HEAVY
Body26SUP,Titanium Diamond HEAVY
Body27SUP,Mass Hornet HEAVY
*/	
$fac='stingers';
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'QuadMg1AAGun', 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AW','',''] ]);

$fac='fake';
unset($t2);


$t1['id']='AirTrafficControl';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
print_r($t1);
$t2['name']='AirTrafficControl';	

$t2["thermal"]= 0;
$t2['armour']=0;
$t2["type"]= "DEFENSE";
$t2["strength"]="HARD";

$t2["buildPoints"]=100;
$t2["buildPower"]=50;
$t2["height"]= 0;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;

$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
//$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

//Fnrs_add([ 'faction'=> $fac, 'use'=> 'AirTrafficControl', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);



/*
$t2['id']='Housing';
$t2['name']='Post-Nuclear Housing';							
$t2["buildPoints"]=600;
$t2["buildPower"]=250;
$t2["hitpoints"]=1500*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["sensorID"]= 'DefaultSensor1Mk1';

//$t2["structureModel"]=["solar.pie"];
$t2["structureModel"]=["blhq4.pie"];
$t2["width"]= 3;
$t2["breadth"]= 3;
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;
*/

$t2['id']='SolarPower';
$t2['name']='Solar panel';							
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 100;
$t2["hitpoints"]=1000*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=["solar.pie"];
$t2["width"]= 3;
$t2["breadth"]= 3;
unset($t2["baseModel"]);
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t2['id']='MBank';
$t2['name']='Modern bank';							
$t2["buildPoints"]=600;
$t2["buildPower"]=0;
$t2["hitpoints"]=1000*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=["blhq3.pie"];
$t2["width"]= 3;
$t2["breadth"]= 3;
$t2["baseModel"]='BLBDRDCM.pie';
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;


$t2['id']='Propaganda';
$t2['name']='Propaganda Tower';							
$t2["buildPoints"]=500;
$t2["buildPower"]=150;
$t2["hitpoints"]=1000*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=['mipylon.pie' ,'BLBDRDCM.pie'];
$t2["width"]= 3;
$t2["breadth"]= 3;
//$t2["baseModel"]='BLBDRDCM.pie';
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t2['id']='Park';
$t2['name']='Park';							
$t2["buildPower"]=50;
$t2["buildPoints"]=3*$t2["buildPower"];
$t2["hitpoints"]=10*$t2["buildPower"]*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=['arizonabush1.pie'];
//$t2["baseModel"]='BLBDRDCM.pie';
$t2["width"]= 2;
$t2["breadth"]= 2;
//$t2["type"]=  "COMMAND RELAY";
$t2["type"]=  "REARM PAD";
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

unset($t2["baseModel"]);
$t2['id']='Forest';
$t2['name']='Forest';							
$t2["buildPower"]=75;
$t2["buildPoints"]=3*$t2["buildPower"];
$t2["hitpoints"]=10*$t2["buildPower"]*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=['mitrees2.pie'];
$t2["width"]= 3;
$t2["breadth"]= 3;
$t2["type"]=  "REARM PAD";
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t2['id']='Tree';
$t2['name']='Tree';							
$t2["buildPower"]=20;
$t2["buildPoints"]=3*$t2["buildPower"];
$t2["hitpoints"]=10*$t2["buildPower"]*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=['mitrees3.pie'];
$t2["width"]= 1;
$t2["breadth"]= 1;
$t2["type"]=  "WALL";
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t2['id']='BigForest';
$t2['name']='Big Forest';							
$t2["buildPower"]=100;
$t2["buildPoints"]=3*$t2["buildPower"];
$t2["hitpoints"]=10*$t2["buildPower"]*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=['mitrees.pie'];
$t2["width"]= 4;
$t2["breadth"]= 4;
$t2["type"]=  "REARM PAD";
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Crate'; $t2['id']=$t1['id'];
$t2["type"]=  "REARM PAD";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Boulder1'; $t2['id']=$t1['id'];
$t2["type"]=  "WALL";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Boulder2'; $t2['id']=$t1['id'];
$t2["type"]=  "REARM PAD";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]=2; $t2["breadth"]=2;
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Boulder3'; $t2['id']=$t1['id'];
$t2["type"]=  "WALL";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 100;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='OilDrum'; $t2['id']=$t1['id'];
$t2["type"]=  "REARM PAD";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Pickup'; $t2['id']=$t1['id'];
$t2["type"]=  "WALL";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;



$t1['id']='arizonabush3'; $t2['id']=$t1['id'];
$t2["type"]=  "REARM PAD";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]=2; $t2["breadth"]=2;
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$fac='cult';
/*
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'MBank', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['insta','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Park', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','hvy','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Boulder1', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','hvy','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Forest', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','hvy','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Boulder2', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','hvy','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'arizonabush3', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','hvy','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Boulder3', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','hvy','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Tree', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','hvy','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'BigForest', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','hvy','',''] ]);
//$sys['nrs']['base']['structure']['A0Sat-linkCentre']['buildPower']=250;
//$sys['nrs']['base']['structure']['NuclearReactor']['buildPower']=250;
*/
// Research

$t1['id']='Indirectlab';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['type']='RESEARCH';
$t2['researchPoints']=12;
$t2['moduleResearchPoints']=7;

$t2['name']='Indirectlab';		
$t2["buildPoints"]=1;
$t2["buildPower"]=1;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;
$sys['nrs']['file']['stat']['structure'][$t2['id']]=$t2;

$t1['id']='Laseropticslab';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='Laseropticslab';	
$t2['researchPoints']=14*3;
$t2["buildPoints"]=100;
$t2["buildPower"]=200*$sys['nrs']['powerunit'];
$t2["hitpoints"]=$t2["buildPower"]*1*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;
$sys['nrs']['file']['stat']['structure'][$t2['id']]=$t2;

$t1['id']='Nanolab';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='Nanolab';							
$t2['researchPoints']=14;
$t2["buildPoints"]=100;
$t2["buildPower"]=1;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;
$sys['nrs']['file']['stat']['structure'][$t2['id']]=$t2;

//entertainement
$t1['id']='Powlab';
$t2['id']=$t1['id'];
$t2["type"]=  "WALL";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='Powlab';							
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 100;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Advmaterialslab';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='Advmaterialslab';							
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 100;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Aerodynamicslab';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='Aerodynamicslab';							
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 100;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;




//Factory
$t1['id']='OldFactory';
$t2=$sys['nrs']['file']['stat']['structure']['A0LightFactory'];
unset($t2["baseModel"]);
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['productionPoints']=7*$sys['nrs']['powerunit'];
unset($t2['userLimits']);
$t2['name']='OldFactory';							
$t2["buildPoints"]=10;
$t2["buildPower"]=5*$sys['nrs']['powerunit'];
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;
$sys['nrs']['file']['stat']['structure'][$t2['id']]=$t2;


$t1['id']='BarbWarehouse1';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["type"]= "DEFENSE";
$t2['productionPoints']=2;
$t2['name']='BarbWarehouse1';							
$t2["buildPoints"]=200;
$t2["buildPower"]=100;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='BarbWarehouse2';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='BarbWarehouse2';					
$t2['productionPoints']=3;
$t2["buildPoints"]=200;
$t2["buildPower"]=100;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='BarbWarehouse3';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['productionPoints']=4;
$t2['name']='BarbWarehouse3';							
$t2["buildPoints"]=200;
$t2["buildPower"]=100;
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$sys['nrs']['file']['stat']['structure']['A0LightFactory']['buildPower']=$sys['nrs']['unitprice']*2;
$sys['nrs']['file']['stat']['structure']['A0LightFactory']['productionPoints']=10*$sys['nrs']['powerunit'];
$sys['nrs']['file']['stat']['structure']['A0CyborgFactory']['buildPower']=$sys['nrs']['unitprice'];
$sys['nrs']['file']['stat']['structure']['A0CyborgFactory']['productionPoints']=7*$sys['nrs']['powerunit'];
$sys['nrs']['file']['stat']['structure']['WreckedTransporter']['productionPoints']=40*$sys['nrs']['powerunit'];
$sys['nrs']['file']['stat']['structure']['WreckedTransporter']['name']='Carrier ship';
$sys['nrs']['file']['stat']['structure']['WreckedTransporter']['type']=$sys['nrs']['file']['stat']['structure']['A0LightFactory']['type'];
$sys['nrs']['file']['stat']['structure']['WreckedTransporter']["buildPoints"]=125;
$sys['nrs']['file']['stat']['structure']['WreckedTransporter']["buildPower"]=$sys['nrs']['unitprice']*2*4;
$sys['nrs']['file']['stat']['structure']['WreckedTransporter']["hitpoints"]=125*20*$sys['nrs']['structureHPScale'];

//$sys['nrs']['file']['stat']['structure']['A0LightFactory']['productionPoints']=8;

// buildings
$t1['id']='building2';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["type"]=  "DEFENSE";
$t2['name']='building2';							
$t2["buildPower"]=120;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=1.5*$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='building3';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='building3';							
$t2["buildPower"]=120;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='building10';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='building10';							
$t2["buildPower"]=60;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=1.5*$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='building11';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='building11';							
$t2["buildPoints"]=100;
$t2["buildPower"]=100;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=3*$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='building12';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='building12';							
$t2["buildPoints"]=100;
$t2["buildPower"]=80;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Rotarywepslab';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='Rotarywepslab';							
$t2["buildPoints"]=100;
$t2["buildPower"]=120;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=1.5*$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;


$t1['id']='Heavywepslab';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];

$t2['name']='Heavywepslab';							
$t2["buildPoints"]=100;
$t2["buildPower"]=120;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=2*$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;


$t2['id']='cabin';
$t2['name']='cabin';							
$t2["buildPoints"]=100;
$t2["buildPower"]=50;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=["MICABIN1.PIE"];
$t2["width"]= 1;
$t2["breadth"]= 1;
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;


$t1['id']='BarbHUT';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='BarbHUT';							
$t2["buildPoints"]=60;
$t2["buildPower"]=30;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=1.5*$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Ruin1';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='Ruin1';							
$t2["buildPoints"]=60;
$t2["buildPower"]=30;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=1.5*$t2["buildPower"]*20*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='LogCabin3';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='LogCabin3';							
$t2["buildPoints"]=60;
$t2["buildPower"]=30;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=1.5*$t2["buildPower"]*40*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='WaterTower';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='WaterTower';							
$t2["buildPoints"]=100;
$t2["buildPower"]=50;
$t2["hitpoints"]=1.5*$t2["buildPower"]*40*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='OilTower';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='OilTower';							
$t2["buildPoints"]=200;
$t2["buildPower"]=100;
$t2["hitpoints"]=1.5*$t2["buildPower"]*40*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='AirTrafficControl';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['name']='AirTrafficControl';							
$t2["buildPoints"]=60;
$t2["buildPower"]=30;
$t2["hitpoints"]=1.5*$t2["buildPower"]*40*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;




//$powerscale=.25;
//$sys['nrs']['file']['stat']['structure']['A0BaBaPowerGenerator']["buildPower"]=$powerscale*$sys['nrs']['bankval']*5/$sys['nrs']['oilpf']*3+10;
$sys['nrs']['base']['structure']['A0BaBaPowerGenerator']["buildPower"]=200;
//$sys['nrs']['file']['stat']['structure']['A0BaBaPowerGenerator']["buildPoints"]=1;
//$sys['nrs']['file']['stat']['structure']['A0BaBaPowerGenerator']["powerPoints"]=$powerscale*50;
$sys['nrs']['base']['structure']['A0BaBaPowerGenerator']["powerPoints"]=20000*1.5*($sys['nrs']['interest']-1);
//$sys['nrs']['file']['stat']['structure']['A0PowerGenerator']["buildPower"]=$powerscale*$sys['nrs']['bankval']*5/4*3;
$sys['nrs']['base']['structure']['A0PowerGenerator']["buildPower"]=50;
//$sys['nrs']['base']['structure']['A0PowerGenerator']["buildPoints"]=100;
$sys['nrs']['base']['structure']['A0PowerGenerator']["powerPoints"]=5000*1.3*($sys['nrs']['interest']-1);
//$sys['nrs']['file']['stat']['structure']['A0PowerGenerator']["modulePowerPoints"]=$powerscale*55*.201; //see "power hack"
 

$fac='prop';

//Fnrs_add([ 'faction'=> $fac, 'use'=> 'WreckedTransporter', 'in'=>'base', 'type'=> 'structure', 'as' => ['short','lgt','',''] ]);

//Fnrs_add([ 'faction'=> $fac, 'use'=> 'Laseropticslab', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'Nanolab', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'Powlab', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'Advmaterialslab', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'Aerodynamicslab', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'Indirectlab', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);

$fac='res';
/*
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Ruin1', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'BarbHUT', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'cabin', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'building10', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'LogCabin3', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'building12', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'building11', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'building2', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'building3', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
*/

$t2['id']='road';
$t2['name']='road';		
$t2["buildPoints"]=20;
$t2["buildPower"]=10;
$t2["hitpoints"]=30*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=['blvtolpd.pie'];
$t2["width"]= 1;
$t2["breadth"]= 1;
$t2["type"]=  "REARM PAD";
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;


/*
$fac='ser';
Fnrs_add([ 'faction'=> $fac, 'use'=> 'BarbWarehouse1', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'road', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'OilDrum', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Pickup', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'BarbWarehouse3', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'Crate', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'BarbWarehouse2', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'WaterTower', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);

$fac='work';
Fnrs_add([ 'faction'=> $fac, 'use'=> 'AirTrafficControl', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'OilTower', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Propaganda', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Advmaterialslab', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Aerodynamicslab', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Rotarywepslab', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Heavywepslab', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
*/

$sys['nrs']['nrs']['structure']['NuclearReactor']['buildPower']= 100;
$sys['nrs']['nrs']['structure']['NuclearReactor']["hitpoints"]=(100)*3*20*$sys['nrs']['structureHPScale'];
$sys['nrs']['nrs']['structure']['CoolingTower']['buildPower']= 75;
$sys['nrs']['nrs']['structure']['CoolingTower']["hitpoints"]=(75)*3*20*$sys['nrs']['structureHPScale'];


$fac="energy";
/*
Fnrs_add([ 'faction'=> $fac, 'use'=> 'NuclearReactor', 'in'=>'base', 'type'=> 'structure', 'as' => ['vshort','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'CoolingTower', 'in'=>'base', 'type'=> 'structure', 'as' => ['vshort','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'SolarPower', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['vshort','','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Powlab', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['vshort','','',''] ]);
*/

Fnrs_add([ 'faction'=> $fac, 'use'=> "A0PowerGenerator,A0BaBaPowerGenerator,A0ResourceExtractor", 'in'=>'base', 'type'=> 'structure', 'as' => ['AP','insta','exshort','','fake'] ]);

$fac="ai";
$sys['nrs']['base']['structure']['A0ComDroidControl']['buildPower']=50;
$sys['nrs']['base']['structure']['A0ComDroidControl']["hitpoints"]=(50)*3*20*$sys['nrs']['structureHPScale'];
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0ComDroidControl", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','AT','insta','exshort','',''] ]);

$fac='protoype
';
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'A0BaBaPowerGenerator', 'in'=>'base', 'type'=> 'structure', 'as' => ['short','','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'CoolingTower', 'in'=>'base', 'type'=> 'structure', 'as' => ['short','','',''] ]);



//Fnrs_add([ 'faction'=> $fac, 'use'=> 'OldFactory', 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);



//$t2 come from above.


/*
RailGun1Mk1,Needle Gun GAUSS
RailGun2-VTOL,VTOL Rail Gun GAUSS
RailGun2Mk1,Rail Gun GAUSS
RailGun3Mk1,Gauss Cannon GAUSS
Cannon4AUTOMk1,Particle Gun CANNON
Cannon5Vulcan-VTOL,VTOL Rail Cannon CANNON
Cannon5Vulcan-Transport,Transport Rail Cannon CANNON
Cannon5VulcanMk1,Rail Cannon CANNON
Cannon7-VTOL,VTOL Hadron Cannon CANNON
Cannon7-Transport,Transport Hadron Cannon CANNON
Cannon775mmMk1,Hadron Cannon CANNON
*/
/*
AAGunLaser,
AAGun2Mk1,AA Flak Cannon 
QuadMg1AAGun,Hurricane AA Turret A-A GUN
QuadRotAAGun,Whirlwind AA Turret A-A GUN
:2120
AAGun2Mk1,Tornado AAA CANNON
AAGunLaser,Dragonslicer AAA GAUSS
Cyb-Hvywpn-AAMcannon,Mega Dragon-Slicer CANNON
AAGunLaserMk2,GiGaSlicer AAA GAUSS
QuadMg1AAGun,Duster AAA A-A GUN
QuadRotAAGun,Skysweeper AAA A-A GUN
*/

/*

Rocket-BB,Bunker Buster ROCKET
Rocket-Sunburst,Sunburst AA ROCKET
:2120
Rocket-BB,Devastator ASGM MISSILE
Missile-BB,
*/
foreach($structureData as $id=>$values){
	//$aibuild=['BarbHUT','building10','building3','Park','AirTrafficControl'];
	$aibuild=[	"BigForest","LogCabin3","Heavywepslab","Forest","cabin","OilTower"];

	$structureData2[$id]['fac1']=rand()%17;
	if(in_array($id,$aibuild)){
		echo " $id is in fac 3";
		$structureData2[$id]['fac1']=11;
	};
	
	$structureData2[$id]['fac2']=rand()%17;
	//$structureData2[$id]['fac2']=rand()%11;
}
$facs=['eco1','eco2','eco3','eco1','eco2','eco3'];
$x=-1;
while($x++<18){
	$fac=$facs[$x%3];
	foreach($structureData as $id=>$values){
		if($structureData2[$id]['fac1']==$x){
				//$sys['nrs'][$facs[$x%6]]['structure'][$id]=$sys['nrs']['nrs']['structure'][$id];
				echo '<br>'. $id .'in fac'. $facs[$x%3];
				Fnrs_add([ 'faction'=> $facs[$x%3], 'use'=> $id, 'in'=>'nrs', 'type'=> 'structure', 'as' => ['exshort','eco','',''] ]);
		}
		else if($structureData2[$id]['fac2']==$x && $facs[$x%3]!=$facs[$structureData2[$id]['fac1']%3]){
				//$sys['nrs'][$facs[$x%6]]['structure'][$id]=$sys['nrs']['nrs']['structure'][$id];
				Fnrs_add([ 'faction'=> $facs[$x%3], 'use'=> $id, 'in'=>'nrs', 'type'=> 'structure', 'as' => ['exshort','eco','',''] ]);
		}
		/*
		else if($structureData2[$id]['fac3']==$x){
				Fnrs_add([ 'faction'=> $facs[$x%3], 'use'=> $id, 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
		}
		*/
	}
}

Fnrs_generate();
Fwz_NRS_dist($sys['nrs']['file']['stat'], [0,$sys['nrs']['scaleDist'],1,1,1]);


foreach($structureData as $id=>$values){
	
	unset($totpos);
	unset($totneg);
	unset($str);
	$x=0;
	while($x++<10){
		$totpos+=max($values[$x-1],0);
		$totneg+=min($values[$x-1],0);
	}
	$x=0;
	if($id=='A0ResourceExtractor'){	$item=$sys['nrs']['file']['stat']['structure'][$id]; }
	else{ $item=$sys['nrs']['file']['stat']['structure'][$id .'-eco']; }
	//print_r($item);
	$values2[11]=floor($item['power']*130);
	while($x++<12){
		if($x<=10){
			if($values[$x-1]>0){
				$values2[$x-1]=100*$values[$x-1]/$totpos;
			}
			else{
				$values2[$x-1]=110*$values[$x-1]/-$totneg;
			}
		}
		
		$str.=floor($values2[$x-1]) .',';
	}

	$fac='economy';
	$nom=$sys['nrs']['nrs']['structure'][$id]['name'];
//	if($id=='A0ResourceExtractor'){
		echo '<br>		'. 	$sys['nrs']['file']['stat']['structure'][$nom]['name'] .':'. $nom .':econ:'.  $str;
		$sys['nrs']['structureData'].='
	"'.  	$nom  .'":['. $str .'],';
		
	//}
	/*
	else{
		$nom=$sys['nrs']['nrs']['structure'][$id]['name'].'-eco';
		echo '<br>		'. 	$sys['nrs']['file']['stat']['structure'][$nom]['name'] .':'. $nom .':'.  $str;
		$sys['nrs']['structureData'].='
	"'.  	$nom  .'":['. $str .'],';
	*/

	//}
	//'Ruin1':[3,-1,-1,0,2,1,-1,0,0,0,0,0],
}


$sys['nrs']['file']['stat']['weapons']['Mortar2Mk1-2120']['fireOnMove']=0;
$sys['nrs']['file']['stat']['weapons']['Mortar2Mk1-2120']['recoilValue']=25;

$sys['nrs']['file']['stat']['propulsion']['BaBaLegs']['designable']=false;
//$sys['nrs']['file']['stat']['structure']['A0BaBaFactory']['type']="CYBORG FACTORY";
$sys['nrs']['file']['stat']['structure']['A0BaBaFactory']['type']="FACTORY";

//$sys['nrs']['file']['stat']['research'][$sys['nrs']['startres']]['resultstructures'][]='OldFactory';
//$sys['nrs']['startres']
//$sys['nrs']['file']['stat']['research']['R-Sys-Engineering01']['researchPower']=10000;

foreach($sys['nrs']['file']['stat']['research'] as $nom => $val){
	print_r($val['requiredResearch']);
	foreach($val['requiredResearch'] as $no => $req){
		if($nom==$req){
			echo '<br><b> '. $nom .' req '. $req .'</b>';
			unset($sys['nrs']['file']['stat']['research'][$nom]['requiredResearch']);
		}
	}
}
foreach($sys['nrs']['file']['stat']['structure'] as $nom=>$item){
			//echo $nom .','. $val['name'] .'<br>';
			//$sys['nrs'][$modname][$listtype][$nom]['armour']=0;
			//$sys['nrs'][$modname][$listtype][$nom]['thermal']=0;
			//$sys['nrs'][$modname][$listtype][$nom]['buildPower']/=10*$trpower/1000;
			
			//$sys['nrs'][$modname][$listtype][$nom]['strength']='HARD';
			//if( $sys['nrs'][$modname][$listtype][$nom]['type']!="DEFENSE"){
			//	$sys['nrs'][$modname][$listtype][$nom]['hitpoints']*=2*$sys['nrs']['structureHPScale'];
			//}
			$sys['nrs']['file']['stat']['structure'][$nom]['buildPoints']=max(1,$sys['nrs']['file']['stat']['structure'][$nom]['hitpoints']*$sys['nrs']['dmgunit']/(8*$sys['nrs']['structureHPScale'])*$sys['nrs']['dmgscale']);
			if($item['type']=="REPAIR FACILITY"){
				$sys['nrs']['file']['stat']['structure'][$nom]['buildPoints']*=3;
			}
			if($item['type']=="FACTORY" or $item['type']=="RESEARCH" or $item['type']=="CYBORG FACTORY"){
				$sys['nrs']['file']['stat']['structure'][$nom]['hitpoints']*=2;
			}
			
	}
foreach($sys['nrs']['file']['stat'] as $nom => $val){
		unset($val['']); //propulsion bug ?
		$dump=json_encode($val,JSON_PRETTY_PRINT);
		echo 'saving: '. $nom  .' ';
		//print_r($val);
		file_put_contents($savedir .'\\stats\\'. $nom .'.json', $dump);
}

echo '<pre>';	
$str=file_get_contents('./modelNRS/NRS.js');
$str  = str_replace("//--NRSInterest", 'var interest='. ($sys['nrs']['interest']-1) .';',$str);
$str  = str_replace("//--NRSbasepower", 'var basepower='. floor($sys['nrs']['basepower']) .';',$str);
$str  = str_replace("//--NRSstructureData", $sys['nrs']['structureData'],$str);
file_put_contents($savedir .'\\multiplay\\script\\mods\\NRS.js',$str);

echo print_r($sys['nrs']['nrs']['structure']);
//--NRSInterest
echo 'JS STR: <script>'. $str .'</script>';
print_r($sys['nrs']['count']);
echo $sys['nrs']['powstuff'];
echo '<br>'. $sys['nrs']['powstuff2'];
foreach($sys['nrs']['nb'] as $nom =>$nb){
	if($nom!='count' && $nom!='temp' && $nom!=''){
		$msg= $nom.' : {
	';
		$msg.='	roles : '. $nb['roles'] .',
	';
		$msg.='	micro : '. $nb['micro'] .',
	';
		$msg.='	chatalias : '. $nb['chatalias'] .',
	';
	/////////////////////
	/*
	roles: [ 0.3, 0.7, 0.0, 0.0 ],
			chatalias: "fl",
			micro: MICRO.MELEE,*/
		$msg.='	weapons : [
	';
		foreach( (array) $nb['weapons'] as $no => $val){
			$msg.='		'. $val .',
	';
		}
		$msg.='	],
	';
		$msg.='	vtols : [
	';
		foreach( (array) $nb['vtols'] as $no => $val){
			$msg.='		'. $val .',
	';
		}
		$msg.='	],
	';

		$msg.='	defenses : [
	';
		foreach( (array) $nb['defenses'] as $no => $val){
			$msg.='		'. $val .',
	';
		}
		$msg.='	],
	';


		$msg.='	templates: [
	';
		foreach( (array) $nb['templates'] as $no => $val){
			$msg.='		'. $val .',
	';
		}
		$msg.='	],
	';


		$msg.='	extras: [
	';
		foreach( (array) $nb['extras'] as $no => $val){
			$msg.='		'. $val .',
	';
		}
		$msg.='	],
	';
	////////////////
		$msg.='},
	';
		echo $msg;
		//print_r($val);
	}
}

foreach($sys['nrs']['file']['stat']['weapons'] as $nom=>$item){
	Fwz_eval34($item,'weapons');
	echo '<br>'. $item['name'] .' '. $item['Prevalue'] .' '. $item['evalStr'];
}
//print_r($sys['nrs']['file']['stat']['structure']);
//echo json_encode($sys['nrs']['file']['stat']['weapons']).'</pre>';
//echo json_encode($sys['nrs']['file']['stat']['sensor'],JSON_PRETTY_PRINT,20480).'</pre>';

/*
///zip code
// Get real path for our folder
$rootPath = realpath($savedir);

// Initialize archive object
$zip = new ZipArchive();
$zip->open('C:\Users\patag\AppData\Local\Packages\48148WZ2100Project.Warzone2100forWindows_qsk72963svc8a\LocalState\Warzone 2100 Project\Warzone 2100\mods\4.2.4\autoload\NRS.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();
*/
echo  json_last_error() ;