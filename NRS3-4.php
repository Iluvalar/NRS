<?php

error_reporting(E_ERROR | E_PARSE);
ini_set('memory_limit','1G');

include('Fwz.php');
include('Fnrs.php');
include('mod.php'); //I think the distance mod might be in this one ?
$modder="ilu";

//Mod modifiers
$sys['nrs']['mod']['instadeath']=0;
$sys['nrs']['mod']['4x']=0;

$sys['nrs']['oilpf']=7;
$sys['nrs']['derrickprice']=400; //not actually just the derrick 2/5 goes in baseinterest and 1/5 to derricks and 2/5 to powergens
//$sys['nrs']['wepmod']=1.25; //Approximation of the weap modifers bonus. (i still write weaponmodifier.json manually)
$sys['nrs']['wepmod']=1.33; //Approximation of the weap modifers bonus. (i still write weaponmodifier.json manually

$sys['nrs']['scaleTime']=1*(1+3*$sys['nrs']['mod']['4x']); //?? //Fnrs line 91
$sys['nrs']['scaleDist']=1.25/(1+3*$sys['nrs']['mod']['4x']); //Scale all distance in the mod.
$sys['nrs']['time']=30*60*($sys['nrs']['scaleTime']); //time to research the last component.
$sys['nrs']['trtime']=100/$sys['nrs']['scaleDist']; //Truck time between bases
$sys['nrs']['powerpersec']=300/100; //mean power per second
$sys['nrs']['armysize']=35/(1+1*$sys['nrs']['mod']['4x']); //medium units;
$sys['nrs']['dmgscale']=2*(1+2*$sys['nrs']['mod']['instadeath']);

/*# Era mode. 
$sys['nrs']['scaleDist']=.4;
$sys['nrs']['powerpersec']=300/100;
$sys['nrs']['time']=60*60;
$sys['nrs']['trtime']=120/($sys['nrs']['scaleDist']);
$sys['nrs']['armysize']=7; //medium units;
$sys['nrs']['dmgscale']=1.4;
/**/

$sys['nrs']['dmgunit']=3; //unit of damage expressed in % of damage. To avoid rounding mistakes
$sys['nrs']['powerunit']=1; //unit of damage expressed in % of damage. To avoid rounding mistakes


//dont touch !
$sys['nrs']['interestShift']=1;
$sys['nrs']['ParalelLine']=5;
$sys['nrs']['Buildtime']=4;
$sys['nrs']['stdNumStep']=4; //??

$sys['nrs']['powerinTT']=$sys['nrs']['oilpf']*$sys['nrs']['derrickprice']/($sys['nrs']['wepmod']/($sys['nrs']['wepmod']-1));
$sys['nrs']['powerpersec']=$sys['nrs']['powerinTT']/$sys['nrs']['trtime'];
$sys['nrs']['ttpower']=$sys['nrs']['powerpersec']*$sys['nrs']['trtime']*$sys['nrs']['powerunit'];

function Fnrs_progress($x){
	global $sys;
	//return Fwz_fig($x)-0.2/$x-1;
	//return (Fwz_fig($x+1)/Fwz_fig($x))-1.2;
	return (Fwz_fig($sys['nrs']['armysize']+$x)/Fwz_fig($sys['nrs']['armysize']))-$sys['nrs']['wepmod'];
}
$nfig=newton('Fnrs_progress',0,4); //number of figures (medium unit) it takes to beat the weapon modifier.

//Other bunch of complex things needing to be calculated...
$medprice=$sys['nrs']['ttpower']/2/$nfig;
$sys['nrs']['produnit']=205/($medprice);
$per=Fwz_fig($sys['nrs']['armysize']+$nfig)/Fwz_fig($sys['nrs']['armysize']);
$startpow=$sys['nrs']['ttpower']*($sys['nrs']['wepmod']/($sys['nrs']['wepmod']-1));
echo 'nfig:'. $nfig .' '.Fwz_fig($nfig) .'/'. Fwz_fig($nfig+1).' med:'. $medprice .' per:'.  $per .' truck time power:'. $sys['nrs']['ttpower'] .' suggStart:'. $startpow .' armysize: '. $sys['nrs']['armysize'];
$sys['nrs']['percent']=.2; //max 66 * .08 :( = 5.28 or 90 *.06 (633) ||now: .05 and 120
$sys['nrs']['unitprice']=$medprice;
$sys['nrs']['structureHPScale']=$sys['nrs']['dmgunit']*Fwz_fig($sys['nrs']['armysize'])/Fwz_fig(40)*1; //scale structures hp with army size.
#$trpower=$sys['nrs']['ttpower']/2/$sys['nrs']['percent'];
#$sys['nrs']['armypower']=$trpower;
$sys['nrs']['armypower']=$sys['nrs']['ttpower']/($sys['nrs']['wepmod']-1);
$sys['wz']['fleauscale']=$sys['nrs']['ttpower']; //was 2 assume scouting now ?
$sys['nrs']['rpoint']=$sys['nrs']['powerpersec']*$sys['nrs']['time']/5*$sys['nrs']['powerunit'];
$sys['nrs']['rspeed']=ceil($rpoint/$sys['nrs']['time']);
$testfleau=Fwz_fleau($sys['nrs']['ttpower']); 

echo '<B> WELCOME TO NRS :D </B>tf:'. $testfleau .'!';
 $sys['nrs']['bankval']=$trpower*1/5;
//$sys['nrs']['interest']=pow($testfleau/1.1,5/$sys['nrs']['trtime']);
$sys['nrs']['interest']=pow($testfleau,5/$sys['nrs']['trtime']); //these 2 get injected in NRS.js
$sys['nrs']['basepower']=$sys['nrs']['ttpower']*($sys['nrs']['wepmod']/($sys['nrs']['wepmod']-1));

echo 'rpoint:'. $sys['nrs']['rpoint'] .' '. $sys['nrs']['trtime'] .' '. $testfleau .' startpower'. $trpower*3/5  .' bank amount'.  $sys['nrs']['bankval'] .' basepower:'. $sys['nrs']['basepower'];
echo '<br>ttpower'. $sys['nrs']['ttpower'] .' armypower:'.  $sys['nrs']['armypower'] .' '. $sys['nrs']['trtime'] .' '. $testfleau .' basepower:'. $sys['nrs']['basepower'] .' bank amount'.  $sys['nrs']['bankval'];
echo '<br><b>structureHPScale:'. $sys['nrs']['structureHPScale'] .'</b>';
echo '<br>INTEREST PER 5='. $sys['nrs']['interest'];
$sys['nrs']['subclsses']=['',"CANNON","MORTARS","MISSILE","ROCKET","ENERGY","GAUSS","FLAME","HOWITZERS","MACHINE GUN","A-A GUN","SLOW MISSILE","SLOW ROCKET","BOMB","COMMAND","EMP","LAS_SAT",];
$sys['nrs']['subclssesEffect']=['','AW','AW','AW','AS','AS','AS','AT','AT','AT','AP','AP','AP','AN']; //I hate doing that manually. But i need a functionning prototype in my lifetime.
$sys['nrs']['subclssesWeight']=['','lgt','med','hvy','lgt','med','hvy','lgt','med','hvy','lgt','med','hvy','xlgt'];

$sys['nrs']['subclassesType']=['','O','O','N','N','O','O','N','N','O','O','N','N','N']; 
$sys['nrs']['subclassesRegion']=['','-1','-1','-1','-1','0','0','0','0','1','1','1','1','0']; 
$sys['nrs']['subclassesStrenght']=['','1','0','1','0','1','0','1','0','1','0','1','0','1']; 
/*    It's even more stupid that i generate this cheat sheet at the end of the code. XD . But saddly it doesnt happen in the right sequence

//Even stupider now that the pattern exists. This non-sens should be made obsolete soon.
    [SLOW MISSILE] => ANTI PERSONNEL med
    [HOWITZERS] => ANTI TANK med
    [ENERGY] => ARTILLERY ROUND med
    [MORTARS] => ALL ROUNDER med
    [SLOW ROCKET] => ANTI PERSONNEL hvy
    [MISSILE] => ALL ROUNDER hvy
    [BOMB] => FLAMER xlgt
    [A-A GUN] => ANTI PERSONNEL lgt
    [CANNON] => ALL ROUNDER lgt
    [FLAME] => ANTI TANK lgt
    [ROCKET] => ARTILLERY ROUND lgt
    [MACHINE GUN] => ANTI TANK hvy
    [GAUSS] => ARTILLERY ROUND hvy
	*/


//ELECTRONIC
$sys['nrs']['startres']="R-Fac-start";
$unit1=100;
$unit2=90;
echo "OL:". Fwz_fig(35)/Fwz_fig(35*$unit1/$unit2);
echo "test:".  "OL:". Fwz_fig(35+3)/Fwz_fig((35+3)*$unit1/$unit2);

/// OK SETUP DONE ///
/// We load the stats files in to the $sys['nrs'] array.

$realbasedir='./base/';
$basedir='./mp4.3.5/';
$dir2120='./2120/';
//$dirnrs='./8c-oligarchyNRSpV150/';
//$savedir='C:\Users\patag\AppData\Roaming\Warzone 2100 Project\Warzone 2100 4.0\mods\multiplay\NRS';
$savedir='./modfiles/';
$sys['nrs']['dir']['base']='./mp4.3.5/';
$sys['nrs']['dir']['2120']='./2120/';
$sys['nrs']['dir']['ntw']='./ntw/';
$sys['nrs']['dir']['mech']='./mech/';
$sys['nrs']['dir']['cr2']='./cr2/'; //To be continued...
$sys['nrs']['dir']['contingency']='./contingency/';
$sys['nrs']['dir']['grok3']='./grok3/';
$sys['nrs']['dir']['save']='./modfiles/';

$str=file_get_contents($dir2120 .'stats/weapons.json');
$sys['nrs']['2120']['weapons']= json_decode($str, TRUE);
$str=file_get_contents($dir2120 .'stats/research.json');
$sys['nrs']['2120']['research']= json_decode($str, TRUE);
$sys['nrs']['2120']['body']= json_decode(file_get_contents($dir2120 .'stats/body.json'), TRUE);


$sys['nrs']['contingency']['weapons']=  json_decode(file_get_contents($sys['nrs']['dir']['contingency'] .'stats/weapons.json'), TRUE);
$sys['nrs']['contingency']['research']=  json_decode(file_get_contents($sys['nrs']['dir']['contingency'] .'stats/research.json'), TRUE);
$sys['nrs']['contingency']['body']= json_decode(file_get_contents($sys['nrs']['dir']['contingency'] .'stats/body.json'), TRUE);

//$sys['nrs']['grok3']['structure']=  json_decode(file_get_contents($sys['nrs']['dir']['grok3'] .'stats/structure.json'), TRUE);


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


/*	"Body1REC": {
		"armourHeat": 4,
		"armourKinetic": 10,
		"buildPoints": 150,
		"buildPower": 30,
		"class": "Droids",
		"designable": 1,
		"hitpoints": 65,
		"id": "Body1REC",
		"model": "drlbod01.pie",
		"name": "Viper",
		"powerOutput": 5000,
		"propulsionExtraModels": {
		},
		"size": "LIGHT",
		"weaponSlots": 1,
		"weight": 600
	},
	*/
$bodycvsorder=explode(',','id,Unused,size,buildPower,buildPoints,weight,hitpoints,model,Unused,weaponSlots,powerOutput,armourKinetic,armourHeat,Unused,Unused,Unused,Unused,Unused,Unused,Unused,Unused,Unused,Unused,Unused,designable');
$row = 1;
if (($handle = fopen("./NTW/stats/body.txt", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
       //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
			$temp[$bodycvsorder[$c]]=$data[$c];
            //echo $data[$c] . "<br />\n";
        }
		$temp['name']=$temp['id'];
		$temp['class']='Droids';
		unset($temp['Unused']);
		$temp['propulsionExtraModels']=$sys['nrs']['base']['body']['viper']['propulsionExtraModels'];
		$sys['nrs']['ntw']['body'][$temp['id']]=$temp;
		
    }
    fclose($handle);
}

unset($sys['nrs']['ntw']['body']['TruckBody']);
unset($sys['nrs']['ntw']['body']['Body0REC']); //seems to have an error in the pie files.


$id='Chaingun';
$sys['nrs']['mech']['weapons'][$id]=$sys['nrs']['base']['weapons']['Cyborg'. $id];
$sys['nrs']['mech']['weapons'][$id]['designable']=1;
$sys['nrs']['mech']['weapons'][$id]['id']=$id;

$id='Cannon';
$sys['nrs']['mech']['weapons'][$id]=$sys['nrs']['base']['weapons']['Cyborg'. $id];
$sys['nrs']['mech']['weapons'][$id]['designable']=1;
$sys['nrs']['mech']['weapons'][$id]['id']=$id;

$id='Flamer01';
$sys['nrs']['mech']['weapons'][$id]=$sys['nrs']['base']['weapons']['Cyborg'. $id];
$sys['nrs']['mech']['weapons'][$id]['designable']=1;
$sys['nrs']['mech']['weapons'][$id]['id']=$id;

$id='Rocket';
$sys['nrs']['mech']['weapons'][$id]=$sys['nrs']['base']['weapons']['Cyborg'. $id];
$sys['nrs']['mech']['weapons'][$id]['designable']=1;
$sys['nrs']['mech']['weapons'][$id]['id']=$id;

$id='RotMG';
$sys['nrs']['mech']['weapons'][$id]=$sys['nrs']['base']['weapons']['Cyborg'. $id];
$sys['nrs']['mech']['weapons'][$id]['designable']=1;
$sys['nrs']['mech']['weapons'][$id]['id']=$id;


$id='Wpn-Thermite';
$sys['nrs']['mech']['weapons'][$id]=$sys['nrs']['base']['weapons']['Cyb-'. $id];
$sys['nrs']['mech']['weapons'][$id]['designable']=1;
$sys['nrs']['mech']['weapons'][$id]['id']=$id;

$id='Wpn-Rail1';
$sys['nrs']['mech']['weapons'][$id]=$sys['nrs']['base']['weapons']['Cyb-'. $id];
$sys['nrs']['mech']['weapons'][$id]['designable']=1;
$sys['nrs']['mech']['weapons'][$id]['id']=$id;

$id='Wpn-Laser';
$sys['nrs']['mech']['weapons'][$id]=$sys['nrs']['base']['weapons']['Cyb-'. $id];
$sys['nrs']['mech']['weapons'][$id]['designable']=1;
$sys['nrs']['mech']['weapons'][$id]['id']=$id;

$id='Wpn-Grenade';
$sys['nrs']['mech']['weapons'][$id]=$sys['nrs']['base']['weapons']['Cyb-'. $id];
$sys['nrs']['mech']['weapons'][$id]['designable']=1;
$sys['nrs']['mech']['weapons'][$id]['id']=$id;

$id='Wpn-Atmiss';
$sys['nrs']['mech']['weapons'][$id]=$sys['nrs']['base']['weapons']['Cyb-'. $id];
$sys['nrs']['mech']['weapons'][$id]['designable']=1;
$sys['nrs']['mech']['weapons'][$id]['id']=$id;




#list of body to be shown first. To help people not to get lost.
$sys['nrs']['basic']['body']['Body1REC']=$sys['nrs']['base']['body']['Body1REC'];
$sys['nrs']['basic']['body']['Body5REC']=$sys['nrs']['base']['body']['Body5REC'];
$sys['nrs']['basic']['body']['Body11ABT']=$sys['nrs']['base']['body']['Body11ABT'];
#$sys['nrs']['basic']['body']['Body23SUP']=$sys['nrs']['contingency']['body']['Body23SUP']; //hard to find the pie file once the mode is changed...
$sys['nrs']['basic']['body']['ScavIcevanBody']=$sys['nrs']['base']['body']['ScavIcevanBody'];
$sys['nrs']['basic']['body']['FireBody']=$sys['nrs']['base']['body']['FireBody'];
#$sys['nrs']['basic']['body']['Body14SUP']=$sys['nrs']['2120']['body']['Body14SUP'];

//print_r($sys['nrs']['ntw']);
//Setting default values for the mods.
$mods=['basic','base','ntw','2120','contingency'];
$bannedbodies=['SuperTransportBody','GunshipBody','TransporterBody','HeavyChopper','ScavengerChopper','ZNULLBODY','ChinookBody','Body18REC','Body13ABT'];
foreach($mods as $no => $modname){
	$listtype='body';
	foreach($sys['nrs'][$modname][$listtype] as $nom=>$val){
	
			$armorPow=($val['armourKinetic']+$val['armourHeat'])/($val['hitpoints']+0.1);
			$armorRatio=($val['armourKinetic']+1)/($val['armourHeat']+1);
			$enginePow=$val['powerOutput']/(100+$val['weight'])/(1+$val['buildPower']**.5);
			$hpRatio=$val['hitpoints']/(1+$val['buildPower']**.5);
			//¥₽$
			if($hpRatio<20){
				$region='¥';
			}
			elseif($hpRatio<30){
				$region='₽';
			}
			else{
				$region='$';
			}
			if($armorPow<0.15){
				$type='O';
			}
			elseif($armorRatio<1.05){
				$type='E';
			}
			elseif($armorRatio>1.3){
				$type='A';
			}
			else{
				$type='AE';
			}
			$engineClass='N';
			if($enginePow>1){
				$engineClass='H';
			}
			$bp=$sys['nrs'][$modname][$listtype][$nom]['buildPower'];
			$bp*=2**($bp/($sys['nrs']['unitprice']/3*8));
			$sys['nrs'][$modname][$listtype][$nom]['buildPower']=$bp;
			$priceCheck=log($bp/($sys['nrs']['unitprice']/3),2);
			$priceclass=floor($priceCheck);
			if(!isset($bodyDone[$nom]) and !in_array($nom, $bannedbodies)){
				unset($temp);
				$temp['id']=$nom;
				$temp['from']=$modname;
				$temp['type']=$type;
				$temp['name']=$val['name'];
				$temp['priceclass']=$priceclass;
				$temp['engineClass']=$engineClass;
				$temp['region']=$region;
				$bodySort[$priceclass][$engineClass][$region][]=$temp;
				$bodyDone[$nom]=$temp;
			}
			echo $nom .','. $val['name'] .' '.  $val['size'] .' '. $modname .' armor power:'. $armorPow .' ratio:'. $armorRatio .' engineClass:'. $engineClass.' hp:'.  $hpRatio . $region .' price class:'. $priceclass .'<br>';			
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
				$sys['nrs'][$modname][$listtype][$nom]['hitpoints']*=$sys['nrs']['structureHPScale'];
			}
			//$sys['nrs'][$modname][$listtype][$nom]['hitpoints']*=$sys['nrs']['dmgunit'];
			
	}
	$listtype='weapons';
	foreach($sys['nrs'][$modname][$listtype] as $nom=>$val){
			echo $nom .','. $modname .','. $val['name'] .' '. $val['weaponSubClass']  .'<br>';
			$sys['nrs'][$modname][$listtype][$nom]['armour']=0;
			$sys['nrs'][$modname][$listtype][$nom]['thermal']=0;
			$sys['nrs'][$modname][$listtype][$nom]['flags']='ShootAir';
			$sys['nrs'][$modname][$listtype][$nom]['splash radius']*=0.5/1.25; //will be multiplied by 1.25 in the scaledist code later.
			
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
$mods=['basic','base','ntw','2120','contingency'];
foreach($mods as $no => $modname){
	$listtype='body';
	if($modname=='basic'){
		$basedir='./base/';
	}
	else{
		$basedir='./'. $modname .'/';
	}
	
	//$savedir='./tinymods/mini/';
	$threshbody=6;
	foreach($sys['nrs'][$modname][$listtype] as $nom=>$val){
		$pos = strpos($nom,'Cyb');
		$pos2 = strpos($nom,'BaBa');
		//$pos3	 = strpos($item['id'],'BaBa');
		if($pos===FALSE && $pos2===FALSE){
			if(!isset($bodyDone2[$nom]) and !in_array($nom, $bannedbodies)){
								$done=0;
				echo '<br>'. $nom;
				print_r($bodyDone[$nom]);
				$newbod=$val;
				$bs=$bodyDone[$nom]; //Body specs
				if( ($check=$bodySort[$bs['priceclass']+1][$bs['engineClass']][$bs['region']] or 1) and ($check ? count($check) : 0 )<$threshbody and ($bs['priceclass']+1)<4 ){
					echo 'higher price';
					$newnamemod='big';
					$scale=array('x'=>2**(1/3),'y'=>2**(1/3),'z'=>2**(1/3));			
					$newbod['buildPower']*=2;
					$bs['priceclass']+=1;
					$done=1;
				}
				elseif( ($check=$bodySort[$bs['priceclass']-1][$bs['engineClass']][$bs['region']] or 1) and ($check ? count($check) : 0 )<$threshbody and ($bs['priceclass']-1)>-5 ){
					echo 'lower price';
					$newnamemod='small';
					$scale=array('x'=>.5**(1/3),'y'=>.5**(1/3),'z'=>.5**(1/3));			
					$newbod['buildPower']/=2;
					$bs['priceclass']-=1;
					$done=1;
					
				}
				elseif( ($check=$bodySort[$bs['priceclass']]['N'][$bs['region']] or 1) and ($check ? count($check) : 0 )<$threshbody and ($bs['engineClass']!='N') ){
					echo 'normal class';
					$newnamemod='flat';
					$scale=array('x'=>1,'y'=>.6,'z'=>1);			
					$bs['engineClass']='N';
					$done=1;
				}
				elseif( ($check=$bodySort[$bs['priceclass']]['H'][$bs['region']] or 1) and ($check ? count($check) : 0 )<$threshbody and ($bs['engineClass']!='H') ){
					echo 'heavy class';
					$newnamemod='tall';
					$scale=array('x'=>1,'y'=>1.4,'z'=>1);			
					$bs['engineClass']='H';
					$done=1;
				}
				elseif( ($check=$bodySort[$bs['priceclass']][$bs['engineClass']]['$'] or 1) and ($check ? count($check) : 0 )<$threshbody and ($bs['region']!='$') ){
					echo '$ region';
					$newnamemod='long';
					$scale=array('x'=>.75,'y'=>1,'z'=>1.5);			
					$bs['region']='$';
					$done=1;
				}
				elseif( ($check=$bodySort[$bs['priceclass']][$bs['engineClass']]['₽'] or 1) and ($check ? count($check) : 0 )<$threshbody and ($bs['region']!='₽') ){
					echo '₽ region';
					$newnamemod='slim';
					$scale=array('x'=>.8,'y'=>.8,'z'=>1);			
					$bs['region']='₽';
					$done=1;
				}
				elseif( ($check=$bodySort[$bs['priceclass']][$bs['engineClass']]['¥'] or 1) and ($check ? count($check) : 0 )<$threshbody and ($bs['region']!='¥') ){
					echo ' region';
					$newnamemod='short';
					$scale=array('x'=>1.2,'y'=>1,'z'=>.6);			
					$bs['region']='¥';
					$done=1;
				}
				if($done){
					$file=$basedir .'components/bodies/'.$val['model'];
					if(!file_exists($file)){
						echo '<br>'. $file .' doesnt exist';
						//$basedir='./mp454/';
						$file='./mp454/' .'components/bodies/'.$val['model'];
						if(!file_exists($file)){
							echo '<br>'. $file .' still doesnt exist';
						}
					}
					$str=file_get_contents($file);
					$str=scale_pie_model($str, $scale);
					if( $modname!="basic" and  $modname!="base"){
						$str=updatePieTexture($str,'-'. $modname,'./'. $modname .'/texpages/' );
					}
					echo '<br>piefile:'. $file .':'. $str;
					$newbod['id']=$newnamemod .'_'. $newbod['id'];
					$newbod['name']=$newnamemod .'_'. $newbod['name'];
					$newbod['model']=strtolower($newnamemod .'_'. $newbod['model']);
					$file=$savedir .'components/bodies/' . $newbod['model'];
					echo '<br> creating...'. $file;
					file_put_contents(strtolower($file),$str);
					$actual_path = realpath($file);
					echo "Actual path: " . $actual_path;
					$sys['nrs'][$modname][$listtype][$newbod['id']]=$newbod;
					$bs['id']=$newbod['id'];
					$bs['name']=$newbod['name'];
					$bodySort[$bs['priceclass']][$bs['engineClass']][$bs['region']][]=$bs;
					$bodyDone[$bs['id']]=$temp;
					$bodyDone2[$nom]=$temp;
				}
			}
		}
		
	}
}
echo '<pre>';
echo 'bodysort!';
#print_r($bodySort);

foreach($bodySort as $priceclass =>$val){
	 
		foreach($val as $engineClass =>$val2){
			//print_r($val2);
			foreach($val2 as $region =>$val3){
				$fac=(($priceclass+2)) . $region . $engineClass;
				echo '<br>' . $fac;
				foreach($val3 as $no => $item){
					
					$pos = strpos($item['id'],'Cyb');
					$pos2 = strpos($item['id'],'BaBa');
					$strenght='normal';
					if($engineClass=='H'){
						$strenght='strong';
					}
					if($pos===FALSE && $pos2===FALSE){
						echo '<br>'. $item['id'] .'('. $item['name']  .') from '. $item['from'] .' type'. $item['type'];
						Fnrs_add([ 'faction'=> $fac, 'use'=>  $item['id'], 'in'=>$item['from'], 'type'=> 'body', 'as' => ['lgt',$strenght,'type'. $item['type'],$region,'insta','vshort'] ]);
					}
				}
				//print_r($val3);
			}
		}
}
echo '</pre>';
//$sys['nrs']['base']['structure']['Farm']=$sys['nrs']['grok3']['structure']['Farm'];
//$sys['nrs']['structsource']['Farm']='grok3';
//Fnrs_add([ 'faction'=> $fac, 'use'=> "Body1UPG", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','strong','','insta','vshort'] ]);
///// Economic structure definition... could hide... 
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
	//print_r($structureData);
	

	$sys['nrs']['base']['structure']['A0ResourceExtractor']['buildPower']=$sys['nrs']['derrickprice']*1/5;
	$sys['nrs']['base']['structure']['A0ResourceExtractor']['buildPoints']=$sys['nrs']['derrickprice'];	
	$id='A0ResourceExtractor'; $t2=$sys['nrs']['base']['structure'][$id];
	$sys['nrs']['nrs']['structure'][$id]=$t2;
	$id='NuclearReactor'; $t2=$sys['nrs']['base']['structure'][$id];
	$sys['nrs']['nrs']['structure'][$id]=$t2;
	$id='CoolingTower'; $t2=$sys['nrs']['base']['structure'][$id];
	$sys['nrs']['nrs']['structure'][$id]=$t2;

$sys['nrs']['file']['stat']['structure']=$sys['nrs']['base']['structure']; //This look out of place.
$sys['nrs']['file']['stat']['body']= $sys['nrs']['base']['body'];
$sys['nrs']['file']['stat']['construction']['Spade1Mk1']['weight']=350;

include('NRS_components.php'); //Buildings and stuff added in NRS

//generating upgrades
Fnrs_upgradeline("Building","",'','PowerPoints','power',$sys['nrs']['startres'],0.7,'Power upgrade');
Fnrs_upgradeline("Building","",'','ResearchPoints','Research speed',$sys['nrs']['startres'],1,'research speed');
Fnrs_upgradeline("Building","",'','ProductionPoints','Prod speed',$sys['nrs']['startres'],1,'production speed');
Fnrs_upgradeline("Construct","",'','ConstructorPoints','Research speed',$sys['nrs']['startres'],1,'construction speed');
//Fnrs_upgradeline("Body","BodyClass",'Droids','HitPointPct','HP',$sys['nrs']['startres'],1,'ALL units hp');
Fnrs_upgradeline("Building","Type",'Wall','HitPoints','wallHP',$sys['nrs']['startres'],1,'structure HP');
Fnrs_upgradeline("Sensor","",'','Range','Sensor',$sys['nrs']['startres'],1,'sensor range');
//Fnrs_upgradeline("Sensor","",'','Engine??','Sensor',$sys['nrs']['startres'],1,'sensor range');





$fac='start';
$sys['nrs']['base']['propulsion']['antiGravity']=$sys['nrs']['base']['propulsion']['wheeled01'];
unset($sys['nrs']['base']['propulsion']['antiGravity']['model']);
//Fnrs_genprop('BaBaLegs',$fac,'BaBaLegs',100);
Fnrs_genprop('wheeled01',$fac,'wheeled01',100);
Fnrs_genprop('tracked01',$fac,'tracked01',130,"Tracked");
//Fnrs_genprop('Naval',$fac,'Naval',115,"Propellor");
//Fnrs_genprop('Helicopter',$fac,'Helicopter',115,"Lift");
Fnrs_genprop('hover01',$fac,'hover01',85,"Hover");
Fnrs_genprop('HalfTrack',$fac,'HalfTrack',115,"Tracked");
Fnrs_genprop('CyborgLegs',$fac,'CyborgLegs',100,"Legged");
Fnrs_genprop('antiGravity',$fac,'antiGravity',100);



//Fnrs_add([ 'faction'=> $fac, 'use'=> "A0CyborgFactory", 'in'=>'base', 'type'=> 'structure', 'as' => ['lgt','insta','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0RepairCentre3", 'in'=>'base', 'type'=> 'structure', 'as' => ['med','hitech','vshort',''] ]); //the garage first make more sens, but confuse noobs.
Fnrs_add([ 'faction'=> $fac, 'use'=> "ScavRepairCentre", 'in'=>'base', 'type'=> 'structure', 'as' => ['med','hitech','vshort',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Crane", 'in'=>'nrs', 'type'=> 'structure', 'as' => ['med','hitech','vshort',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "niceCrane", 'in'=>'nrs', 'type'=> 'structure', 'as' => ['med','hitech','short',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "goodRepair", 'in'=>'nrs', 'type'=> 'structure', 'as' => ['med','hitech','short',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "epicRepair", 'in'=>'nrs', 'type'=> 'structure', 'as' => ['med','hitech','vshort',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "Crane", 'in'=>'nrs', 'type'=> 'structure', 'as' => ['med','hitech','vshort',''] ]);


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


Fnrs_add([ 'faction'=> $fac, 'use'=> "Spade1Mk1", 'in'=>'base', 'type'=> 'construction', 'as' => ['med','AP','insta','exshort','heavy','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "CyborgSpade", 'in'=>'base', 'type'=> 'construction', 'as' => ['lgt','AP','insta','exshort','','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0CommandCentre", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','AP','insta','exshort','','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A1CommandCentre", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','AP','insta','exshort','','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A2CommandCentre", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','AP','insta','exshort','','fake'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "A3CommandCentre", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','AP','insta','exshort','','fake'] ]);

$t2=$sys['nrs']['base']['body']['B1BaBaPerson01'];
$t2['id']='B1BaBaPerson01-nrs';
$t2['droidType']='CYBORG';
$sys['nrs']['base']['body'][$t2['id']]=$t2;

$sys['nrs']['base']['body']['B1BaBaPerson01-nrs']['usageClass']="Cyborg";
$sys['nrs']['base']['body']['B1BaBaPerson01-nrs']['class']="Cyborgs";
print_r($sys['nrs']['base']['body']['B1BaBaPerson01-nrs']);

$sys['nrs']['mech']['body']['CyborgLightBody']=$sys['nrs']['base']['body']['CyborgLightBody'];
Fnrs_add([ 'faction'=> $fac, 'use'=> "B1BaBaPerson01-nrs,BaBaLegs", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','AS','insta','exshort','Cyb','fake','class0'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "CyborgLightBody", 'in'=>'base', 'type'=> 'body', 'as' => ['lgt','AS','insta','exshort','Cyb','fake','class1'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "CyborgHeavyBody", 'in'=>'base', 'type'=> 'body', 'as' => ['med','AS','insta','exshort','Cyb','fake','class3'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "CyborgHeavyBody", 'in'=>'2120', 'type'=> 'body', 'as' => ['hvy','AS','insta','exshort','Cyb','fake','class5'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "CyborgLightBody", 'in'=>'mech', 'type'=> 'body', 'as' => ['shvy','AS','insta','exshort','Cyb','fake','class7'] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "CCSensor", 'in'=>'base', 'type'=> 'sensor', 'as' => ['med','AW','lowtech'] ]);





$fac='NRSP';
Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-AP1', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AP','longrange','weapon','NRSp','¥','typeE'], 'call'=>'extralasers' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-AP2', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AP','longrange','weapon','NRSp','¥','typeE'], 'call'=>'extralasers' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-AP3', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AP','longrange','weapon','NRSp','¥','typeE'], 'call'=>'extralasers' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-AP4', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AP','longrange','weapon','NRSp','¥','typeE','heavy'], 'call'=>'extralasers' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-AA2', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AP','longrange','weapon','NRSp','¥','typeE','heavy'], 'call'=>'extralasers' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-Sonic', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AP','longrange','weapon','NRSp','¥','typeE','heavy'], 'call'=>'extralasers' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-AT1', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AT','hightech','longrange','weapon','NRSp','typeE'], 'call'=>'ATlasers' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-AT2', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AT','hightech','longrange','weapon','NRSp','typeE'], 'call'=>'ATlasers' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-AT3', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AT','hightech','longrange','weapon','NRSp','typeE'], 'call'=>'ATlasers' ]);

$fac='NRSP2';
Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-AT4', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AT','hightech','longrange','weapon','NRSp','typeE','¥','heavy'], 'call'=>'ATlasers' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-TankDest2Lgt', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AT','hightech','longrange','weapon','NRSp','typeE','¥','heavy'], 'call'=>'ATlasers' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser-TankDestLgt', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AT','hightech','longrange','weapon','NRSp','typeE','¥','heavy'], 'call'=>'ATlasers' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'Mortar-GaussRamjet', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','longrange','weapon','NRSp','typeA','heavy','¥'], 'call'=>'contmortars' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Mortar-Gauss', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','longrange','weapon','NRSp','typeA','heavy','¥'], 'call'=>'contmortars' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Mortar-GaussHvy', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','longrange','weapon','NRSp','typeA','heavy','¥'], 'call'=>'contmortars' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Mortar-GaussRot', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','longrange','weapon','NRSp','typeA','heavy','¥'], 'call'=>'contmortars' ]);



$fac='NRSP3';
Fnrs_add([ 'faction'=> $fac, 'use'=>'Mortar-Ramjet', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','longrange','weapon','NRSp','¥'], 'call'=>'contmortars' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Mortar-RamjetRot', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','longrange','weapon','NRSp','¥'], 'call'=>'contmortars' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Mortar-RamjetHvy', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','longrange','weapon','NRSp','¥'], 'call'=>'contmortars' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Mortar-GaussRamjetHvy', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','longrange','weapon','NRSp','¥'], 'call'=>'contmortars' ]);



Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-Shotgun', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','lowtech','weapon','NRSp','heavy',''], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-HPVAslt', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','lowtech','weapon','NRSp','heavy',''], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-HPVGattling', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','lowtech','weapon','NRSp','heavy',''], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-Sniper-Bunker', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','lowtech','weapon','NRSp','heavy','typeA'], 'call'=>'contcannons' ]);

$fac='NRSP4';
Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-HPVLgt', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','lowtech','weapon','NRSp','heavy','typeA','¥'], 'call'=>'contcannons¥' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-HPVHvy', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','lowtech','weapon','NRSp','heavy','typeA','¥'], 'call'=>'contcannons¥' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-HPVTankDestLgt', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','lowtech','weapon','NRSp','heavy','typeA','¥'], 'call'=>'contcannons¥' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-HPVTwinAslt', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','lowtech','weapon','NRSp','heavy','typeA','¥'], 'call'=>'contcannons¥' ]);



$fac='NRSPabc';
Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-Inc', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','','weapon','NRSp','typeE'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-IncTankDest', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','','weapon','NRSp','typeE'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-Plas', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','','weapon','NRSp','typeE'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon-PlasTankDest', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','','weapon','NRSp','typeE'], 'call'=>'contcannons' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "MG3Inc", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['lgt','AP','typeE','NRSp'], 'call'=>'machinegunInc']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG3IncTwin", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['lgt','AP','typeE','NRSp'], 'call'=>'machinegunInc']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG4Inc", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['lgt','AP','typeE','NRSp'], 'call'=>'machinegunInc']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG4IncTwin", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['lgt','AP','typeE','NRSp'], 'call'=>'machinegunInc']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MGPlasSuper", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['lgt','AP','typeE','NRSp'], 'call'=>'machinegunInc']);


Fnrs_add([ 'faction'=> $fac, 'use'=> "MG-AntiTank", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['lgt','AT','$','NRSp'], 'call'=>'machinegun$AT']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG-AntiTankTwin", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['lgt','AT','$','NRSp'], 'call'=>'machinegun$AT']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG-AntiTank2", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['lgt','AT','$','NRSp'], 'call'=>'machinegun$AT']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG-AntiTank2Twin", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['lgt','AT','$','NRSp'], 'call'=>'machinegun$AT']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG-AntiTankGss", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['medium','AT','$','NRSp'], 'call'=>'machinegun$']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG-AntiTankGssTwin", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['medium','AT','$','NRSp'], 'call'=>'machinegun$']);

//alone!!
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG2Mk1,MG2-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['medium','AP','$','insta','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG3Twin", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['medium','AP','$','NRSp'], 'call'=>'machinegun$']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG5TWINROTARY,CyborgRotMG", 'in'=>'base', 'type'=> 'weapons', 'as' => ['medium','AP','$','insta','NRSp'] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame1Hvy", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['med','AT','typeE','NRSp','heavy'], 'call'=>'machinegunInc']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame1Med", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['med','AT','typeE','NRSp','heavy'], 'call'=>'machinegunInc']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame2Hvy", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['med','AT','typeE','NRSp','heavy'], 'call'=>'machinegunInc']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame2Med", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['med','AT','typeE','NRSp','heavy'], 'call'=>'machinegunInc']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flamer-PlasCan-TankDest", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['med','AT','typeE','NRSp','heavy'], 'call'=>'machinegunInc']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flamer-PlasmaCannon", 'in'=>'contingency', 'type'=> 'weapons', 'as' => ['med','AT','typeE','NRSp','heavy'], 'call'=>'machinegunInc']);

Fnrs_add([ 'faction'=> $fac, 'use'=>'Howitzer150Mk1', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','$','heavy'], 'call'=>'conthowi' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGattling', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','$','heavy'], 'call'=>'conthowi' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussBB', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','$','heavy'], 'call'=>'conthowi' ]);

$fac='NRSPdef';
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGattlingGauss', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','$','heavy','typeA'], 'call'=>'conthowi' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGauss', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','$','heavy','typeA'], 'call'=>'conthowi' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussHvy', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','$','heavy','typeA'], 'call'=>'conthowi' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussRot', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','$','heavy','typeA'], 'call'=>'conthowi' ]);


Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerRamjet', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AT','longrange','weapon','NRSp','¥','heavy'], 'call'=>'conthowi2' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerRamjetHvy', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AT','longrange','weapon','NRSp','¥','heavy'], 'call'=>'conthowi2' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerRamjetRot', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AT','longrange','weapon','NRSp','¥','heavy'], 'call'=>'conthowi2' ]);

$fac='NRSPghi';
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussRamjet', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AT','longrange','weapon','NRSp','$','heavy'], 'call'=>'conthowi2' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussRamjetHvy', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AT','longrange','weapon','NRSp','$','heavy'], 'call'=>'conthowi2' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussRamjetRot', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AT','longrange','weapon','NRSp','$','heavy'], 'call'=>'conthowi2' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerHvyPlas', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','¥','heavy','typeE'], 'call'=>'conthowi' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Mortar-GaussHvyPlas', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','longrange','weapon','NRSp','¥'], 'call'=>'contmortars' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerRotPlas', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','¥','heavy','typeE'], 'call'=>'conthowi' ]);

$fac='NRSP5';
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussInc', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','$','heavy','typeE'], 'call'=>'conthowi' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussHvyPlas', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','$','heavy','typeE'], 'call'=>'conthowi' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussRotPlas', 'in'=>'contingency','type'=> 'weapons', 'as' => ['hvy','AS','longrange','weapon','NRSp','$','heavy','typeE'], 'call'=>'conthowi' ]);


$fac='NRSP3';


/*
Cannon-Ramjet,contingency,Jet-Assisted Cannon CANNON
Cannon-Ramjet-TankDest,contingency,Fixed-Mounted Jet-Assisted Cannon CANNON
CannonPlasSuper,contingency,Super Thermite Cannon CANNON
CannonRotSuper,contingency,Super Autocannon CANNON



Laser-TankDest,contingency,Fixed-Mounted Laser Cannon ENERGY
Laser-TankDest2,contingency,Fixed-Mounted Pulse Laser Cannon ENERGY
LaserPlasmaSuper,contingency,Death Ray ENERGY
LaserSuper,contingency,Obelisk of Light ENERGY
LaserSuper2,contingency,Monkeylord's Microwave Laser of Doom ENERGY

MG-AntiTank,contingency,Vulcan Gattling Gun MACHINE GUN
MG-AntiTankTwin,contingency,Twin Vulcan Gattling Gun MACHINE GUN
MG-AntiTank2,contingency,Punisher Gattling Gun MACHINE GUN
MG-AntiTank2Twin,contingency,Twin Punisher Gattling Gun MACHINE GUN

MG3Twin,contingency,Twin Heavy Machinegun MACHINE GUN
MG-AntiTankGss,contingency,Hellfury Gauss Minigun MACHINE GUN
MG-AntiTankGssTwin,contingency,Twin Hellfury Gauss Minigun MACHINE GUN


MGSuper,contingency,Super Gattling Gun MACHINE GUN


Railgun-Aslt,contingency,Assault Needlegun GAUSS
Railgun-Aslt-VTOL,contingency,VTOL Assault Needlegun GAUSS
Railgun-Flak,contingency,Gauss Flak Cannon GAUSS
Railgun-Gattling,contingency,Leadsprayer MACHINE GUN
Railgun-Gattling-VTOL,contingency,VTOL Leadsprayer MACHINE GUN
Railgun-GattlingAA,contingency,Sandstorm AA Railgun MACHINE GUN
Railgun-GattlingAALgt,contingency,Dust Devil AA Railgun MACHINE GUN
Railgun-GattlingAT,contingency,Eviscerator GAUSS
Railgun-GattlingInc,contingency,Hellsprayer MACHINE GUN
Railgun-GattlingInc-VTOL,contingency,VTOL Hellsprayer MACHINE GUN
Railgun-GattlingIncTwin,contingency,Twin Hellsprayer MACHINE GUN
Railgun-GattlingTwin,contingency,Twin Leadsprayer MACHINE GUN
Railgun-Proto,contingency,Proto-Railgun GAUSS
Railgun-ProtoTankDest,contingency,Fixed-Mounted Proto-Railgun GAUSS
Railgun-Shotgun,contingency,Scattershot GAUSS
Railgun-Shotgun-VTOL,contingency,VTOL Gauss Flak Cannon GAUSS
Railgun-Sniper-Bunker,contingency,Gauss Flak Cannon Bunker GAUSS
Railgun-TankDest,contingency,Fixed-Mounted Gauss Cannon GAUSS
Railgun-TankDestLgt,contingency,Tankbuster Railgun GAUSS
Railgun-TwinAslt,contingency,Twin Assault Needlegun GAUSS
RailgunGattlingPlasSuper,contingency,Flame-Spitting Death Machine GAUSS
RailgunGattlingSuper,contingency,Sasha's Future Counterpart MACHINE GUN
RailgunSuper,contingency,Super Gauss Autocannon GAUSS
Rocket-BB,contingency,Bunker Buster ROCKET
Rocket-BB2,contingency,Devastator BB Missile ROCKET
Rocket-Cherub,contingency,Cherub AA Array ROCKET
Rocket-Gattling,contingency,Rocketstorm ROCKET
Rocket-HvyA-T,contingency,Tank Killer ROCKET
Rocket-HvyA-THvy,contingency,Heavy Tank Killer ROCKET
Rocket-IDF,contingency,Ripple Rockets ROCKET
Rocket-LasProp-AP,contingency,Apollo Missile ROCKET
Rocket-LasProp-AT,contingency,Ballista Missile ROCKET
Rocket-LasProp-Plas,contingency,Sunrider Missile ROCKET
Rocket-LtA-T,contingency,Lancer ROCKET
Rocket-LtA-THvy,contingency,Heavy Lancer ROCKET
Rocket-MRL,contingency,Mini-Rocket Array ROCKET
Rocket-MRLHvy,contingency,Heavy Mini-Rocket Array ROCKET
Rocket-Pod,contingency,Mini-Rocket Pod ROCKET
Rocket-Pod2,contingency,Rocket Assault Pod ROCKET
Rocket-Pod2Quad,contingency,Quad Rocket Assault Pod ROCKET
Rocket-Pod2Twin,contingency,Twin Rocket Assault Pod ROCKET
Rocket-Pod3,contingency,Erinyes Missile Pod ROCKET
Rocket-Pod3Quad,contingency,Quad Erinyes Missile Pod ROCKET
Rocket-Pod3Twin,contingency,Twin Erinyes Missile Pod ROCKET
Rocket-PodQuad,contingency,Quad Mini-Rocket Pod ROCKET
Rocket-PodTwin,contingency,Twin Mini-Rocket Pod ROCKET
Rocket-Sunburst,contingency,Sunburst AA Array ROCKET
Rocket-TopAtkInc,contingency,Incendiary Rocket Array ROCKET
Rocket-TopAtkIncHvy,contingency,Heavy Incendiary Rocket Array ROCKET
Rocket-TopAtkPlas,contingency,Ifrit Missile Array ROCKET
Rocket-TopAtkPlasHvy,contingency,Heavy Ifrit Missile Array ROCKET
Rocket-TopAttack,contingency,Rocket Assault Array ROCKET
Rocket-TopAttackHvy,contingency,Heavy Rocket Assault Array ROCKET

TBM-Earthquake,contingency,Hellshaker TBM Launcher MISSILE
TBM-FuelAir,contingency,Harbinger TBM Launcher MISSILE
TBM-Plasmite,contingency,Armageddon TBM Launcher MISSILE
TBM-Precision,contingency,Oblivion TBM Launcher MISSILE


*/
/*
Fnrs_add([ 'faction'=> $fac, 'use'=>'Body17LGT', 'in'=>'contingency','type'=> 'body', 'as' => ['LM','AW','insta','','NRSp'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Body16MED', 'in'=>'contingency','type'=> 'body', 'as' => ['LM','AW','insta','','NRSp'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Body18MED', 'in'=>'contingency','type'=> 'body', 'as' => ['LM','AW','insta','','NRSp'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Body15LGT', 'in'=>'contingency','type'=> 'body', 'as' => ['LM','AW','insta','','NRSp'], 'call'=>'contcannons' ]);


Fnrs_add([ 'faction'=> $fac, 'use'=>'Body20LGT', 'in'=>'contingency','type'=> 'body', 'as' => ['LM','AT','insta','','NRSp','cheap'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Body21MED', 'in'=>'contingency','type'=> 'body', 'as' => ['LM','AT','insta','','NRSp','cheap'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Body22HVY', 'in'=>'contingency','type'=> 'body', 'as' => ['LM','AT','insta','','NRSp','cheap'], 'call'=>'contcannons' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'Body23SUP', 'in'=>'contingency','type'=> 'body', 'as' => ['hvy','AW','insta','','NRSp','good'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Body24SUP', 'in'=>'contingency','type'=> 'body', 'as' => ['hvy','AW','insta','','NRSp','good'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Body25SUP', 'in'=>'contingency','type'=> 'body', 'as' => ['hvy','AW','insta','','NRSp','good'], 'call'=>'contcannons' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'Body26SUP', 'in'=>'contingency','type'=> 'body', 'as' => ['hvy','AT','insta','','NRSp'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Body27SUP', 'in'=>'contingency','type'=> 'body', 'as' => ['hvy','AT','insta','','NRSp'], 'call'=>'contcannons' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Body28SUP', 'in'=>'contingency','type'=> 'body', 'as' => ['hvy','AT','insta','','NRSp'], 'call'=>'contcannons' ]);
*/




$fac='nexus';

Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser3BEAMMk1,Laser3BEAM-VTOL,Cyb-Wpn-Laser', 'in'=>'base','type'=> 'weapons', 'as' => ['hvy','AP','hightech','longrange','weapon','typeE','NRSp'], 'call'=>'heavylaser' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>"Laser2PULSEMk1,Laser2PULSE-VTOL", 'in'=>'base','type'=> 'weapons', 'as' => ['hvy','AP','hightech','longrange','weapon','typeE','NRSp'] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>"Laser3BEAMMk1,Laser3BEAM-VTOL", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AP','hightech','typeE','NRSp'] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>"HeavyLaser,HeavyLaser-VTOL,Cyb-Hvywpn-PulseLsr", 'in'=>'base','type'=> 'weapons', 'as' => ['hvy','AP','hightech','longrange','weapon','typeE','NRSp','heavy'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>"Laser4-PlasmaCannon", 'in'=>'base','type'=> 'weapons', 'as' => ['hvy','AP','hightech','longrange','weapon','typeE','NRSp','heavy'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>"AAGunLaser", 'in'=>'base','type'=> 'weapons', 'as' => ['hvy','AP','hightech','longrange','weapon','ground','typeE','NRSp','heavy'] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "RailGun1Mk1,Cyb-Wpn-Rail1", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange','typeA','NRSp','heavy'], 'call'=>'rail'  ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "RailGun2Mk1,RailGun2-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange','typeA','NRSp','heavy'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "RailGun3Mk1,Cyb-Hvywpn-RailGunner", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange','typeA','NRSp','heavy'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon4AUTOMk1,CyborgCannon", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AW','hitech','longrange','typeA','NRSp','heavy'] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon5VulcanMk1,Cannon5Vulcan-VTOL,Cyb-Hvywpn-HPV", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['HM','AW','hitech','longrange','typeA','¥','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon775mmMk1,Cannon7-VTOL,Cyb-Hvywpn-Lcannon", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['HM','AW','hitech','longrange','typeA','¥','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG5TWINROTARY,Cyb-Hvywpn-Mcannon", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['HM','AW','hitech','longrange','typeA','¥','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Cannon6TwinAslt,Cyb-Wpn-RailHyp', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['HM','AW','hitech','longrange','typeA','¥','NRSp'] ]);



Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar1Mk1,Cyb-Wpn-Grenade", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AS','','NRSp','heavy'], 'call'=>'mortar' ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Howitzer105Mk1", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AS','','NRSp','heavy','$'], 'call'=>'Howitzer'  ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar0Mk1", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['lgt','AS','','NRSp','heavy'] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Howitzer150Mk1", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AS','','NRSp','heavy','$'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar2Mk1", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AS','','NRSp','heavy'] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Howitzer03-Rot", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AS','','NRSp','heavy','$'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar3ROTARYMk1", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AS','','NRSp','heavy'] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Howitzer150Mk1", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AS','NRSp','','heavy','$'] ]);
#Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar2Mk1,Cyb-Wpn-Grenade", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]); //besiege have "invalid shadowpoints" and cause critical crash as of 4.5.1
//	Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar3ROTARYMk1", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "Mortar3ROTARYMk1,Cyb-Wpn-Grenade", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AS','',''] ]);

$fac="super¥";
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerRamjetSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','hightech','¥','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','hightech','¥','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussRamjetSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','hightech','$','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);

$fac="super";
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussPlasSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','hightech','$','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerGaussSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','hightech','$','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'HowitzerPlasSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','hightech','$','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);



Fnrs_add([ 'faction'=> $fac, 'use'=>'MortarSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['lgt','AS','','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'MortarGaussPlasSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['lgt','AS','','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'MortarGaussSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['lgt','AS','','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'MortarPlasSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['lgt','AS','','','weapon','NRSp','class7','typeE'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Mortar-GaussRotPlas', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AS','longrange','weapon','NRSp','typeE'], 'call'=>'contmortars' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'MortarHvyPlas', 'in'=>'contingency','type'=> 'weapons', 'as' => ['lgt','AS','','','weapon','NRSp','class7','typeE'], 'call'=>'mechWeapon' ]);


Fnrs_add([ 'faction'=> $fac, 'use'=>'MortarRamjetSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['lgt','AS','¥','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'MortarGaussRamjetSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['lgt','AS','¥','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'LaserSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AP','hightech','typeA','$','weapon','NRSp','class7','heavy'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'LaserSuper2', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AP','hightech','typeA','$','weapon','NRSp','class7','heavy'], 'call'=>'mechWeapon' ]);
#Fnrs_add([ 'faction'=> $fac, 'use'=>'GattlinggunSuper', 'in'=>'2120','type'=> 'weapons', 'as' => ['medium','AP','hightech','typeE','$','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'LaserPlasmaSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AP','hightech','typeA','$','weapon','NRSp','class7','heavy'], 'call'=>'mechWeapon' ]);


Fnrs_add([ 'faction'=> $fac, 'use'=>'CannonSuper', 'in'=>'base','type'=> 'weapons', 'as' => ['medium','AW','','heavy','weapon','NRSp','class7','$'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'CannonSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','','heavy','weapon','NRSp','class7','$'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'CannonRotSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','','heavy','weapon','NRSp','class7','$'], 'call'=>'mechWeapon' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'FlamerPlasmaSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AT','typeE','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'CannonPlasSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AT','typeE','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'MissileArrayPlasSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AT','typeE','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);

$fac="superheavy";
Fnrs_add([ 'faction'=> $fac, 'use'=>'RailgunGattlingPlasSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','typeA','heavy','weapon','NRSp','class7','$'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'RailgunSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AW','typeA','heavy','weapon','NRSp','class7','$'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Superweapon2', 'in'=>'2120','type'=> 'weapons', 'as' => ['medium','AW','typeA','heavy','weapon','NRSp','class7','$'], 'call'=>'mechWeapon' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'RocketSuper', 'in'=>'base','type'=> 'weapons', 'as' => ['medium','AT','','','weapon','NRSp','class7','heavy'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'MissileArraySuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AT','','','weapon','NRSp','class7','heavy'], 'call'=>'mechWeapon' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'MissileSuper', 'in'=>'base','type'=> 'weapons', 'as' => ['medium','AT','','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
#Fnrs_add([ 'faction'=> $fac, 'use'=>'RocketSuper', 'in'=>'2120','type'=> 'weapons', 'as' => ['medium','AT','','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'MissileSuper', 'in'=>'2120','type'=> 'weapons', 'as' => ['medium','AT','','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'MissileSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['medium','AT','','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);



#Fnrs_add([ 'faction'=> $fac, 'use'=>'MachinegunSuper', 'in'=>'2120','type'=> 'weapons', 'as' => ['lgt','AP','','','¥','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'MGPlasSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['lgt','AP','','','¥','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'MGSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['lgt','AP','','','¥','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Superweapon', 'in'=>'contingency','type'=> 'weapons', 'as' => ['lgt','AP','','','¥','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
#Fnrs_add([ 'faction'=> $fac, 'use'=>'RailgunGattlingSuper', 'in'=>'contingency','type'=> 'weapons', 'as' => ['lgt','AP','','','¥','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);

$fac="mech";
Fnrs_add([ 'faction'=> $fac, 'use'=>'Chaingun', 'in'=>'mech','type'=> 'weapons', 'as' => ['medium','AP','hightech','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'RotMG', 'in'=>'mech','type'=> 'weapons', 'as' => ['medium','AP','hightech','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Wpn-Grenade', 'in'=>'mech','type'=> 'weapons', 'as' => ['medium','AP','hightech','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Wpn-Laser', 'in'=>'mech','type'=> 'weapons', 'as' => ['medium','AP','hightech','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);

Fnrs_add([ 'faction'=> $fac, 'use'=>'Cannon', 'in'=>'mech','type'=> 'weapons', 'as' => ['medium','AT','hightech','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Flamer01', 'in'=>'mech','type'=> 'weapons', 'as' => ['medium','AT','hightech','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Rocket', 'in'=>'mech','type'=> 'weapons', 'as' => ['medium','AT','hightech','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Wpn-Thermite', 'in'=>'mech','type'=> 'weapons', 'as' => ['medium','AT','hightech','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Wpn-Atmiss', 'in'=>'mech','type'=> 'weapons', 'as' => ['medium','AT','hightech','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=>'Wpn-Rail1', 'in'=>'mech','type'=> 'weapons', 'as' => ['medium','AT','hightech','','weapon','NRSp','class7'], 'call'=>'mechWeapon' ]);


/*
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body11ABT", 'in'=>'base', 'type'=> 'body', 'as' => ['MH','insta','NRSp',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body12SUP", 'in'=>'base', 'type'=> 'body', 'as' => ['MH','insta','NRSp',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body9REC", 'in'=>'base', 'type'=> 'body', 'as' => ['MH','insta','NRSp',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body10MBT", 'in'=>'base', 'type'=> 'body', 'as' => ['MH','insta','NRSp',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body13SUP", 'in'=>'base', 'type'=> 'body', 'as' => ['MH','insta','NRSp',''] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body14SUP", 'in'=>'base', 'type'=> 'body', 'as' => ['MH','insta','NRSp',''] ]);	
*/

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
//"usageClass": "Cyborg",
//"class": "Cyborgs",

$sys['nrs']['file']['stat']['templates']['BaBaPeople']['available']=true;
$sys['nrs']['base']['structure']['A0BaBaFactory']['productionPoints']=2*$sys['nrs']['powerunit'];

Fnrs_add([ 'faction'=> $fac, 'use'=> "A0BaBaFactory", 'in'=>'base', 'type'=> 'structure', 'as' => ['xlgt','insta','AS','baba'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "scavCrane1", 'in'=>'base', 'type'=> 'construction', 'as' => ['xlgt','AS','insta','exshort','designable'] ]);

//
/*
Fnrs_add([ 'faction'=> $fac, 'use'=> "ScavCamperBody", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','designable','lowtech','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "ScavIcevanBody", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','designable','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "B2tractor", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','baba','designable','vshort'] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "ScavNEXUStrack", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','AT','baba','designable','vshort','strong'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BusBody", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','AT','baba','designable','vshort','strong'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "FireBody", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','AT','baba','designable','vshort','strong'] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "B3body-sml-buggy01-Ultimate", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','AP','baba','designable','NRSp','cheap'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "B4body-sml-trike01-Ultimate", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','AP','baba','lowtech','NRSp','cheap'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "B3bodyRKbuggy01-Ultimate", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','AP','baba','NRSp','cheap'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "B2JeepBody-Ultimate", 'in'=>'base', 'type'=> 'body', 'as' => ['xlgt','AT','baba','designable','NRSp','cheap'] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "BusCannon,bTrikeMG", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AT','lowtech','designable','¥','NRSp'], 'call'=>'scavenger']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BabaRocket", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AT','designable','FOM','¥','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BabaPitRocket", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AT','designable','¥','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BabaPitRocketAT", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AT','designable','¥','NRSp'] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "BuggyMG", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AP','lowtech','fake','¥','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BJeepMG", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AP','lowtech','fake','¥','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "BabaFlame", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AP','designable','FOM','¥','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "ScavNEXUSlink", 'in'=>'base', 'type'=> 'weapons', 'as' => ['xlgt','AP','designable','FOM','¥','NRSp'] ]);
*/


$fac='project';


Fnrs_add([ 'faction'=> $fac, 'use'=> "MG1Mk1,MG1-VTOL,CyborgChaingun", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AP','lowtech','NRSp'], 'call'=>'machinegun']);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG3Mk1,MG3-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AP','insta','NRSp'] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "MG4ROTARYMk1,MG4ROTARY-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AP','insta','NRSp'] ]);



//Fnrs_add([ 'faction'=> $fac, 'use'=> "BusCannon,CyborgCannon", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AW','lowtech',''], 'call'=>'cannon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon1Mk1,Cannon1-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AW','lowtech','typeA','NRSp'], 'call'=>'cannon' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon2A-TMk1,Cyb-Hvywpn-Mcannon", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AW','lowtech','typeA','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon375mmMk1,MG4ROTARY-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AW','lowtech','typeA','NRSp'] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon4AUTOMk1,Cannon4AUTO-VTOL,Cyb-Hvywpn-Acannon", 'in'=>'base', 'type'=> 'weapons', 'as' => ['LM','AW','lowtech','typeA','$','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon5VulcanMk1,Cannon5Vulcan-VTOL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['LM','AW','lowtech','typeA','$','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Cannon6TwinAslt,Cyb-Hvywpn-HPV", 'in'=>'base', 'type'=> 'weapons', 'as' => ['LM','AW','lowtech','typeA','$','NRSp'] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame1Mk1,CyborgFlamer01", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AT','typeE','NRSp'], 'call'=>'flammer' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame2,Cyb-Wpn-Thermite", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AT','typeE','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "PlasmiteFlamer", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AT','typeE','NRSp'] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame1Mk1,CyborgFlamer01", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['LM','AT','typeE','¥','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['LM','AT','typeE','¥','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Flame3Mk1,Cyb-Wpn-Thermite", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['LM','AT','typeE','¥','NRSp'] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "PlasmiteFlamer", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['lgt','AT','',''] ]);

//Fnrs_add([ 'faction'=> $fac, 'use'=> "CommandBrain01", 'in'=>'base', 'type'=> 'brain', 'as' => ['hvy','AW','joke',''] ]);

/*
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body1REC", 'in'=>'base', 'type'=> 'body', 'as' => ['lgt','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body4ABT", 'in'=>'base', 'type'=> 'body', 'as' => ['lgt','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body2SUP", 'in'=>'base', 'type'=> 'body', 'as' => ['lgt','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body3MBT", 'in'=>'base', 'type'=> 'body', 'as' => ['lgt','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body3MBT", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','insta','vshort'] ]);
*/


Fnrs_add([ 'faction'=> $fac, 'use'=> "A0PowMod1", 'in'=>'base', 'type'=> 'structure', 'as' => ['lgt','early','weak',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "LightRepair1,CyborgRepair", 'in'=>'base', 'type'=> 'repair', 'as' => ['med','AW','exshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "HeavyRepair", 'in'=>'base', 'type'=> 'repair', 'as' => ['med','AW','exshort'] ]);


$fac='Paradigm';
$fac='collective';
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-Pod", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AT','',''], 'call'=>'rocket' ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "BabaPitRocketAT,CyborgRocket", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AT','',''], 'call'=>'rocket' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-LtA-T,Cyb-Wpn-Atmiss", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-Pod", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-HvyA-T,Cyb-Hvywpn-TK", 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AT','',''] ]);
//Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-PodMk2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AT','',''] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-A-T,Cyb-Hvywpn-TK", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AT','',''] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "RailGun1Mk1,RailGun1-VTOL,Cyb-Wpn-Rail1", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange','typeA','NRSp','$'], 'call'=>'quark' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "RailGun2Mk1,RailGun002-VTOL,Cyb-Hvywpn-RailGunner2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange','typeA','NRSp','$'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'RailGun3Mk1,RailGun3-VTOL,Cyb-Hvywpn-RailGunner', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange','typeA','NRSp','$'] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> 'RailGun4Mk1,RailGun4-VTOL', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange','$','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'RailGun5Mk1,RailGun5-VTOL', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange','$','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'RailGun6Mk1,RailGun6-VTOL,Cyb-Hvywpn-RailGunner', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AW','hitech','longrange','$','NRSp'] ]);




Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-BB", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AS','hitech','NRSp'], 'call'=>'ASrocket' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-Sunburst", 'in'=>'base', 'type'=> 'weapons', 'as' => ['lgt','AS','hitech','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-BB", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['lgt','AS','hitech','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> 'Missile-BB', 'in'=>'2120', 'type'=> 'weapons', 'as' => ['lgt','AS','hitech','NRSp'] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "A0FacMod1", 'in'=>'base', 'type'=> 'structure', 'as' => ['lgt','early','',''] ]);

/*
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body1UPG", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','strong','','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body2SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','strong','','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body3MBT", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','strong','','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body3SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['lgt','strong','','insta','vshort'] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "Body3ALT", 'in'=>'2120', 'type'=> 'body', 'as' => ['LM','strong','$','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body4ABT", 'in'=>'2120', 'type'=> 'body', 'as' => ['LM','strong','$','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body4UPG", 'in'=>'2120', 'type'=> 'body', 'as' => ['LM','strong','$','insta','vshort'] ]);

Fnrs_add([ 'faction'=> $fac, 'use'=> "Body5REC", 'in'=>'base', 'type'=> 'body', 'as' => ['med','insta','','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body8MBT", 'in'=>'base', 'type'=> 'body', 'as' => ['med','insta','','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body6SUPP", 'in'=>'base', 'type'=> 'body', 'as' => ['med','insta','','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body7ABT", 'in'=>'base', 'type'=> 'body', 'as' => ['med','insta','','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body7ALT", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','insta','','vshort'] ]);
*/



$fac='doom';
$fac='allon';
$sys['nrs']['2120']['weapons'][ "Rocket-LtA-T2"]['name']="2120 lancer";
//Rocket-HvyA-T,Rocket-HvyA-T2,Rocket-IDF,Rocket-IDF2,Rocket-LtA-T,Rocket-LtA-T2,
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-HvyA-T,Cyb-Hvywpn-A-T,Cyb-Hvywpn-Acannon", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['HM','AT','¥','NRSp'], 'call'=>'heavyrocket' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-HvyA-T2,Cyb-Hvywpn-A-T2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['HM','AT','¥','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-MRL,CyborgRocket", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['HM','AT','¥','NRSp'] ]);
//Fnrs_add([ 'faction'=> 'nexus', 'use'=> "Rocket-IDF2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AT','',''] ]);


Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-LtA-T,Cyb-Wpn-Atmiss", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AT','','NRSp','heavy'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-LtA-T2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AT','','NRSp','heavy'] ]);
$sys['nrs']['2120']['weapons']['Missile-A-T']['reloadTime']=95;
Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-A-T,Cyb-Wpn-Atmiss2", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AT','','NRSp','heavy'] ]);




Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-MRL", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AP','$','NRSp'], 'call'=>'indirectmissile' ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-IDF", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AS','','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-MdArt", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AP','$','NRSp','heavy'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-IDF", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AP','$','NRSp','heavy'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Rocket-MRL-Hvy", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AP','$','NRSp','heavy'] ]);

	Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-HvyArt", 'in'=>'base', 'type'=> 'weapons', 'as' => ['hvy','AS','$','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-MdArt", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AP','','NRSp','heavy'] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "Missile-HvyArt", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['hvy','AS','$','NRSp'] ]);
	
	
	Fnrs_add([ 'faction'=> $fac, 'use'=> "MG1Mk1,MG1-VTOL,CyborgChaingun", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','typeA','NRSp'], 'call'=>'mediumlaser$' ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG2Mk1,MG2-VTOL", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','typeA','NRSp', 'call'=>'mediumlaser'] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "MG7LGTGATTLINGMk1,MG7LGTGATTLING-VTOL,CyborgChaingunMed", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['MH','AP','$','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG3Mk1,MG3-VTOL", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','typeA','NRSp'] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "MG7MEDGATTLINGMk1,MG7MEDGATTLING-VTOL", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['MH','AP','$','NRSp'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "MG4ROTARYMk1,MG4ROTARY-VTOL,Cyb-Wpn-Laser", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','','NRSp','heavy'] ]);
	Fnrs_add([ 'faction'=> $fac, 'use'=> "MG7GATTLINGMk1,MG7GATTLING-VTOL", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['MH','AP','$','NRSp','heavy'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Laser2PULSEMk1,Laser2PULSE-VTOL,Cyb-Hvywpn-PulseLsr", 'in'=>'2120', 'type'=> 'weapons', 'as' => ['med','AP','','NRSp','heavy'] ]);

/*
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body7ALT", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','strong','','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body8MBT", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','strong','','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body8UPG", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','strong','','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body16MBTT", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','strong','','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body25DKD", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','strong','','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body6SUPP", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','strong','','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body7SUPP", 'in'=>'2120', 'type'=> 'body', 'as' => ['med','strong','','insta','vshort'] ]);
	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body9REC", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','','','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body10REC", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','','','insta','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body12SUPP", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','','','insta','vshort'] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body10ALT", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','','','insta','vshort'] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body7ABT", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','','','insta','vshort'] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body11UPG", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','','','insta','vshort'] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body12SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','','','insta','vshort'] ]);
	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body12UPG", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','good','AT','vshort'] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body14SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','good','AT','vshort'] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body13SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','good','AT','vshort'] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body17SUUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','good','AT','vshort'] ]);	
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body26SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','good','AT','vshort'] ]);
Fnrs_add([ 'faction'=> $fac, 'use'=> "Body27SUP", 'in'=>'2120', 'type'=> 'body', 'as' => ['MH','good','AT','vshort'] ]);
*/


//$sys['nrs']['base']['structure']['A0ResearchFacility']['buildPower']=0;
//$sys['nrs']['base']['structure']['A0ResearchFacility']['buildPoints']=0;


$fac='stingers';
//Fnrs_add([ 'faction'=> $fac, 'use'=> 'QuadMg1AAGun', 'in'=>'base', 'type'=> 'weapons', 'as' => ['med','AW','',''] ]);

$fac='fake';
unset($t2);




//$powerscale=.25;
//$sys['nrs']['file']['stat']['structure']['A0BaBaPowerGenerator']["buildPower"]=$powerscale*$sys['nrs']['bankval']*5/$sys['nrs']['oilpf']*3+10;
$sys['nrs']['base']['structure']['A0BaBaPowerGenerator']["buildPower"]=$sys['nrs']['derrickprice']*1/5*4*2;
//$sys['nrs']['file']['stat']['structure']['A0BaBaPowerGenerator']["buildPoints"]=1;
//$sys['nrs']['file']['stat']['structure']['A0BaBaPowerGenerator']["powerPoints"]=$powerscale*50;
$sys['nrs']['base']['structure']['A0BaBaPowerGenerator']["powerPoints"]=25*$sys['nrs']['base']['structure']['A0BaBaPowerGenerator']["buildPower"]/5*1.3*($sys['nrs']['interest']-1);
//$sys['nrs']['file']['stat']['structure']['A0PowerGenerator']["buildPower"]=$powerscale*$sys['nrs']['bankval']*5/4*3;
$sys['nrs']['base']['structure']['A0PowerGenerator']["buildPower"]=$sys['nrs']['derrickprice']*1/5*4;
$sys['nrs']['base']['structure']['A0PowMod1']["buildPower"]=$sys['nrs']['derrickprice']*1/5*4;

//$sys['nrs']['base']['structure']['A0PowerGenerator']["buildPoints"]=100;
$sys['nrs']['base']['structure']['A0PowerGenerator']["powerPoints"]=25*$sys['nrs']['base']['structure']['A0PowerGenerator']["buildPower"]/5*1.3*($sys['nrs']['interest']-1);
//$sys['nrs']['base']['structure']['A0PowerGenerator']["powerPoints"]=5000*1.3*($sys['nrs']['interest']-1);
$sys['nrs']['base']['structure']['A0PowerGenerator']["modulePowerPoints"]=$sys['nrs']['base']['structure']['A0PowerGenerator']["powerPoints"]; //see "power hack"
 

$sys['nrs']['nrs']['structure']['NuclearReactor']['buildPower']= 100;
$sys['nrs']['nrs']['structure']['NuclearReactor']["hitpoints"]=(100)*3*20*$sys['nrs']['structureHPScale'];
$sys['nrs']['nrs']['structure']['CoolingTower']['buildPower']= 75;
$sys['nrs']['nrs']['structure']['CoolingTower']["hitpoints"]=(75)*3*20*$sys['nrs']['structureHPScale'];


$fac="energy";
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0PowerGenerator,A0BaBaPowerGenerator,A0ResourceExtractor", 'in'=>'base', 'type'=> 'structure', 'as' => ['AP','insta','exshort','','fake'] ]);

$fac="ai";
$sys['nrs']['base']['structure']['A0ComDroidControl']['buildPower']=50;
$sys['nrs']['base']['structure']['A0ComDroidControl']["hitpoints"]=(50)*3*20*$sys['nrs']['structureHPScale'];
Fnrs_add([ 'faction'=> $fac, 'use'=> "A0ComDroidControl", 'in'=>'base', 'type'=> 'structure', 'as' => ['hvy','AT','insta','exshort','',''] ]);


//This part set the economic buildings into 3 randomized lines
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
		$source='nrs';
		if($sys['nrs']['structsource'][$id]!=''){
			$source=$sys['nrs']['structsource'][$id];
			echo 'found source:'. $source;
		}
		if($structureData2[$id]['fac1']==$x){
				//$sys['nrs'][$facs[$x%6]]['structure'][$id]=$sys['nrs']['nrs']['structure'][$id];
				echo '<br>'. $id .'in fac'. $facs[$x%3];
				Fnrs_add([ 'faction'=> $facs[$x%3], 'use'=> $id, 'in'=>$source, 'type'=> 'structure', 'as' => ['exshort','eco','',''] ]);
				$ecofac[$facs[$x%3]][]=$id;
		}
		else if($structureData2[$id]['fac2']==$x && $facs[$x%3]!=$facs[$structureData2[$id]['fac1']%3]){
				//$sys['nrs'][$facs[$x%6]]['structure'][$id]=$sys['nrs']['nrs']['structure'][$id];
				Fnrs_add([ 'faction'=> $facs[$x%3], 'use'=> $id, 'in'=>$source, 'type'=> 'structure', 'as' => ['exshort','eco','',''] ]);
				$ecofac[$facs[$x%3]][]=$id;
		}
		/*
		else if($structureData2[$id]['fac3']==$x){
				Fnrs_add([ 'faction'=> $facs[$x%3], 'use'=> $id, 'in'=>'nrs', 'type'=> 'structure', 'as' => ['short','','',''] ]);
		}
		*/
	}
}
echo 'generate...';
Fnrs_generate();
Fwz_NRS_dist($sys['nrs']['file']['stat'], [0,$sys['nrs']['scaleDist'],2,1,1]);


/* More economic stuff, why do i generate in between ? */
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
		

}

//few dirty fixes...
#$sys['nrs']['file']['stat']['weapons']['Mortar2Mk1-2120']['fireOnMove']=0;
#$sys['nrs']['file']['stat']['weapons']['Mortar2Mk1-2120']['recoilValue']=25;

$sys['nrs']['file']['stat']['propulsion']['BaBaLegs']['designable']=false;
//$sys['nrs']['file']['stat']['structure']['A0BaBaFactory']['type']="CYBORG FACTORY";
$sys['nrs']['file']['stat']['structure']['A0BaBaFactory']['type']="FACTORY";


//Could i avoid this to happen in the frist place instead of this patch ?
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
			$sys['nrs']['file']['stat']['structure'][$nom]['buildPoints']=max(1,$sys['nrs']['file']['stat']['structure'][$nom]['hitpoints']*$sys['nrs']['dmgunit']/(8*$sys['nrs']['structureHPScale'])*$sys['nrs']['dmgscale']);
			if($item['type']=="REPAIR FACILITY"){
				$sys['nrs']['file']['stat']['structure'][$nom]['buildPoints']*=3;
			}
			if($item['type']=="FACTORY" or $item['type']=="RESEARCH" or $item['type']=="CYBORG FACTORY"){
				$sys['nrs']['file']['stat']['structure'][$nom]['hitpoints']*=2;
			}
			
	}
	/*
 "_config_": {
    "baseStructDamageExpLevel": 0
  },
	*/
$sys['nrs']['file']['stat']['research']['_config_']['calculationMode']="improved";
$sys['nrs']['file']['stat']['structure']['_config_']['baseStructDamageExpLevel']="0";

foreach($sys['nrs']['file']['stat']['body'] as $nom=>$item){
	$sys['nrs']['file']['stat']['body'][$nom]['propulsionExtraModels']['Naval']['left']="prhnaval1.pie";
	echo '<br>'. $item['name'] .' '. $item['Prevalue'] .' '. $item['evalStr'];

}

foreach($sys['nrs']['file']['stat'] as $nom => $val){
		unset($val['']); //propulsion bug ?
		$dump=json_encode($val,JSON_PRETTY_PRINT);
		echo 'saving: '. $nom  .' ';
		file_put_contents($savedir .'\\stats\\'. $nom .'.json', $dump);
}

//Generating scripts bits
echo '<pre>';	
$str=file_get_contents('./modelNRS/NRS.js');
$str  = str_replace("//--NRSInterest", 'var interest='. floor( ($sys['nrs']['interest']-1)*100000)/100000 .'; //int',$str);
$str  = str_replace("//--NRSbasepower", 'var basepower='. floor($sys['nrs']['basepower']) .';
var powerMod='. floor($sys['nrs']['mod']['4x']*3) .';',$str); 
$str  = str_replace("//--NRSstructureData", $sys['nrs']['structureData'],$str);
file_put_contents($savedir .'\\multiplay\\script\\mods\\NRS.js',$str);

echo print_r($sys['nrs']['nrs']['structure']);
//--NRSInterest
echo 'JS STR: '. $savedir  .' '. $str .'End script<br>';
print_r($sys['nrs']['count']);
echo $sys['nrs']['powstuff'];
echo '<br>'. $sys['nrs']['powstuff2'];

$str=file_get_contents('./modelNRS/standard.js');
foreach($sys['nrs']['nb'] as $nom =>$nb){
	unset($bodymsg);
	if($nom!='count' && $nom!='temp' && $nom!=''){
		$msg=''. $nom.' : {
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
			$bodymsg.='		'. $val .',
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
	if($nom=='body'){
		$str  = str_replace("//--bodylist", $bodymsg,$str);
		
	}
	elseif($nom !='body' && $nom !='propulsion' && $nom !='temp' && $nom !='count'){
		$msgtot.=$msg .'';
		
		//$nom='AWA00';
		unset($perso);
		foreach($sys['nrs']['nb'] as $nom2 =>$nb2){
			$xs=0; $diff=0;
			while($xs< strlen($nom)){
				//echo $nom[$xs-1] .'Ð';

				if($nom[$xs]!=$nom2[$xs]){
					$diff++;
				}
				$xs++;
			}
			echo '<br>'.$nom .' '. $nom2 .' '. $diff;
			$perso[$diff].='			weaponStats.'. $nom2 .', 
		';	
		}
		echo $perso[0].$perso[1].$perso[2];
		$fullperso='	'. $nom .': {
				chatalias: "'. $nom .'",
				weaponPaths: [ // weapons to use; put late-game paths below!
		'. $perso[0].$perso[1].$perso[2].$perso[3].'
				],
				earlyResearch: [ // fixed research path for the early game
				],
				minTanks: 1, // minimal attack force at game start
				becomeHarder: 1, // how much to increase attack force every 5 minutes
				maxTanks: 10, // maximum for the minTanks value (since it grows at becomeHarder rate)
				minTrucks: 2, // minimal number of trucks around
				minHoverTrucks: 3, // minimal number of hover trucks around
				maxSensors: 1, // number of mobile sensor cars to produce
				minMiscTanks: 1, // number of tanks to start harassing enemy
				maxMiscTanks: 10, // number of tanks used for defense and harass
				vtolness: 0, // the chance % of not making droids when adaptation mechanism chooses vtols
				defensiveness: 65, // same thing for defenses; set this to 100 to enable turtle AI specific code
				maxPower: 700, // build expensive things if we have more than that
				repairAt: 50, // how much % healthy should droid be to join the attack group instead of repairing
			},
		';
$persos.=$fullperso;
	}
}



echo $persos;

	$str  = str_replace("//--weaponstats", $msgtot,$str);
	$str  = str_replace("//--bodyKinetic", $sys['nrs']['nb2']['bodyKinetic'],$str);
	$str  = str_replace("//--bodyThermal", $sys['nrs']['nb2']['bodyThermal'],$str);
	//R-NRS-Heavywepslab-eco3
	echo '<br>ecofac';
	print_r($ecofac);
	$str  = str_replace("//--eco1", '"R-NRS-'. $ecofac['eco1'][2] .'-eco1",',$str);
	$str  = str_replace("//--eco2", '"R-NRS-'. $ecofac['eco2'][2] .'-eco2",',$str);
	$str  = str_replace("//--eco3", '"R-NRS-'. $ecofac['eco3'][2] .'-eco3",',$str);
	$str  = str_replace("//--eco4", '"R-NRS-'. $ecofac['eco1'][6] .'-eco1",',$str);
	$str  = str_replace("//--eco5", '"R-NRS-'. $ecofac['eco2'][6] .'-eco2",',$str);
	$str  = str_replace("//--eco6", '"R-NRS-'. $ecofac['eco3'][6] .'-eco3",',$str);
	$str  = str_replace("//--eco7", '"R-NRS-'. $ecofac['eco1'][count($ecofac['eco1'])-1] .'-eco1",',$str);
	$str  = str_replace("//--eco8", '"R-NRS-'. $ecofac['eco2'][count($ecofac['eco2'])-1]  .'-eco2",',$str);
	$str  = str_replace("//--eco9", '"R-NRS-'. $ecofac['eco3'][count($ecofac['eco3'])-1]  .'-eco3",',$str);
	
	file_put_contents($savedir .'\\multiplay\\skirmish\\nb_rulesets\\standard.js',$str);
	
	$str=file_get_contents('./modelNRS/nb_generic.js');
	$str  = str_replace("//--persos", $persos,$str);
	file_put_contents($savedir .'\\multiplay\\skirmish\\nb_generic.js',$str);

//Just for debug purpose
foreach($sys['nrs']['file']['stat']['weapons'] as $nom=>$item){
	Fwz_eval34($item,'weapons');
	echo '<br>'. $countweap++ .':'. $item['name'] .' '. $item['Prevalue'] .' '. $item['evalStr'];
	if($item["weaponClass"]!='KINETIC' and $item["weaponClass"]!='HEAT'){
		echo '<br>WTF!';
	}
}


/*
        "propulsionExtraModels": {
            "HalfTrack": {
                "left": "prhhtr3.pie"
            },
            "Helicopter": {
                "left": "prhheli3.pie",
                "still": "heavyheli_rotor_stationary.pie",
                "moving": "fxheli11.pie"
            },
            "Naval": {
                "left": "prhnaval1.pie"
				*/

print_r($sys['nrs']['subclssesCheat']);

//perso checker
$l1=['AT','AS','AP','AW'];
$l2=['0','1'];
$l3=['0','1','2'];
$l4=['O','A','E'];
$x1=0;   
while($x1++<count($l1)){
	$s1=$l1[$x1-1];
	$x2=0;
	while($x2++<count($l2)){
		$s2=$l2[$x2-1];
		$x3=0;
		while($x3++<count($l3)){
			$s3=$l3[$x3-1];
			$x4=0; while($x4++<count($l4)){
				$s4=$l4[$x4-1];
				$str=$s1.$s4.$s3.$s2; //looks dumb, but it's to generate in the right relevant order
				if(!isset($sys['nrs']['nb'][$str])){
					echo '<br>no personnality:'.  $str;
				}
				else{
				echo '<br>count personnality '. $str .':'.count($sys['nrs']['nb'][$str]['weapons']) .' '. $sys['nrs']['nb'][$str]['weapons'][0];
				}
			}
		}
		echo '<br>';
	}
	echo '<hr>';
}

//Attempts to zip automatically failed so far...
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