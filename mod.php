<?php
//error_reporting (E_ALL & ~E_NOTICE);
ini_set("display_errors", 1); 
include_once('Fwz.php');
$modder="iluMV01";

function buildform($arr)
{
	echo '<b>'. $arr['name'] .':</b>';
	foreach ($arr['var'] as $no => $name){
		//if( isset($arr['varDef'][$no]) ){	$arr['varDef'][$no]=1;	}
		echo '<small>'. $name .':</small>';
		if($arr['varDef'][$no]==='c'){
			echo '<input type="checkbox" name="'. $arr['name'] .'_var'. $no .'" value="1">';
		}
		else{
			echo '<input name="'. $arr['name'] .'_var'. $no .'" value="'. $arr['varDef'][$no] .'">';
		}
	}
	echo '<br/>';
}
function Fwz_mod_cost(&$d,$var){
	Fwz_mod_comp($d,$var,'Build power');
}
function Fwz_mod_hp(&$d,$var){
	Fwz_mod_comp($d,$var,'HP');
}
function Fwz_mod_prod(&$d,$var){
	Fwz_mod_comp($d,$var,'Build points');
}
function Fwz_mod_compSub(&$d,$var,$what,$file,$amount,$mod){
		$d[$file]['c']=1;
		$x=0;while($x++<$d[$file]['n']){
			if($file=='structures' and $mod&1 and !($d[$file][$x-1]['Type']=='DEFENSE' or $d[$file][$x-1]['Type']=='WALL' or $d[$file][$x-1]['Type']=='CORNER WALL')){
				echo 'NNNNN'. $d[$file][$x-1]['ID'];
			}
			if($mod&2){
				$d[$file][$x-1][$what]=ceil(pow($d[$file][$x-1][$what],$amount));
			}
			else{
				Fwz_mult($d[$file][$x-1][$what],$amount);
				//if($what!='Build power'){
				$d[$file][$x-1][$what]=max(1,$d[$file][$x-1][$what]);
				//}
				echo $d[$file][$x-1]['ID'];
			}
		}
		echo 'SUB!!'. $what .'-'. $file .'::'.  $d[$file]['n'] .' '. $amount;
}
function Fwz_mod_comp(&$d,$var,$what,$mod){
	if($var[1]!=1 or $var[2]!=1){
		Fwz_mod_compSub($d,$var,$what,'body',$var[1]*$var[2],$mod);
		/*
		$d['body']['c']=1;
		$x=0;while($x++<$d['body']['n']){
			Fwz_mult($d['body'][$x-1][$what],$var[1]*$var[2]);
		}
		*/
	}
	if($var[1]!=1 or $var[3]!=1){
		Fwz_mod_compSub($d,$var,$what,'structures',$var[1]*$var[3],$mod);
	}
	if($var[1]!=1 or $var[4]!=1){
		Fwz_mod_compSub($d,$var,$what,'weapons',$var[1]*$var[4],$mod);
	}
	if($var[1]*$var[5]!=1){
		Fwz_mod_compSub($d,$var,$what,'sensor',$var[1]*$var[5],$mod);
	}
	if($var[1]*$var[6]!=1){
		Fwz_mod_compSub($d,$var,$what,'construction',$var[1]*$var[6],$mod);
	}
	if($var[1]*$var[7]!=1){
		Fwz_mod_compSub($d,$var,$what,'repair',$var[1]*$var[7],$mod);
	}


}
function Fwz_mod_auto(&$d,$var){
	global $sys;
	Fwz_evalSet($d,'body');
	$expMod=8500;
	if($var[1]!=1 or $var[2]!=1){
		$d['body']['c']=1;
		$x=0;while($x++<$d['body']['n']){
			#Fwz_mult($d['body'][$x-1][$what],$var[1]*$var[2]);
			$comp=$d['body'][$x-1];
			//if(isset($comp['res'])){
				#echo $x .':'. $comp['weaponSubClass'];
				//$fun=Fwz_getFunct($d,$comp['res']*3,'VehicleBody Upgrade','');
				//$expect=pow(1.1,pow($comp['res']/200,.5));
				$expect=fwz_expect($comp['res2']);
				$expect=pow(fwz_expect($comp['res2']+1),4);
				$value=$comp['value'];
				$change=$expect/$value;
				//echo $comp['ID'] .' '. $change .'expe:'. $expect .' real:'. $comp['value'] .' resMod:'. $fun['bodyval'] .' '. $comp['res'] .' '. $comp['res2'] .' '. $value .' ' . $comp['evalStr'] .'</br>';
				$d['body'][$x-1]['change']=$change;
				$d['body'][$x-1]['emer']=max($change,1/$change);
				Fwz_adaptor($d['body'][$x-1],$change);
				/*
				$change=pow($change,1/3);
				$priceMod=Fwz_fig(1/$change,-1);
				Fwz_mult($d['body'][$x-1]['HP'],$change);
				Fwz_mult($d['body'][$x-1]['Build power'],$priceMod);
				Fwz_mult($d['body'][$x-1]['Build points'],$priceMod);
				Fwz_mult($d['body'][$x-1]['AFRK'],$change);
				Fwz_mult($d['body'][$x-1]['AFRH'],$change);

				Fwz_mult($d['body'][$x-1]['powChange'],$change);
				Fwz_mult($d['body'][$x-1]['powChange2'],$change);
				*/
				//echo $comp['ID']  . ' '. $comp['weaponClass'] .' <b>'. floor($change*10000)/100 .'%</b> expe:'. floor($expect*100)/100 .' real:'. floor($comp['value']*100)/100 . $comp['evalStr'] .'</br>';
			//}
		}
	}
	Fwz_evalSet($d,'weapons');
	if($var[1]!=1 or $var[4]!=1){
		$ctot=1;
		$d['weapons']['c']=1;
		$x=0;while($x++<$d['weapons']['n']){
			#Fwz_mult($d['weapons'][$x-1][$what],$var[1]*$var[4]);
			$comp=$d['weapons'][$x-1];
			if($comp['res']>1){
				#echo $x .':'. $comp['weaponSubClass'];
				
				//$fun=Fwz_getFunct($d,$comp['res2']*3,'Weapon Upgrade',$comp['weaponSubClass']);			
				$expect=1+($comp['res2']-60)/$expMod;
				$expect=pow(fwz_expect($comp['res2']-60+1),4);
				//$expect=pow(fwz_expect($comp['res2']-60),4);
				$value=$comp['value'];
				$change=$expect/$value;
				#echo $comp['ID'] .' '. floor($change*10000)/100 .'% <br/>';
				$ctot+=$change;
				$cnum++;
				$d['weapons'][$x-1]['change']=$change;
				$d['weapons'][$x-1]['emer']=max($change,1/$change);
				Fwz_adaptor($d['weapons'][$x-1],$change);
				/*
				$change=pow($change,.5);
				//$priceMod=Fwz_fig(Fwz_fig($obj['priceMod'],1)/$change,-1);
				$fig=Fwz_fig($d['weapons'][$x-1]['priceMod'],-1);
				$priceMod=Fwz_fig($fig/$change,-1);
				echo $comp['ID']  . ' '. $comp['weaponClass'] .' <b>'. floor($change*10000)/100 .'%</b> expe:'. floor($expect*100)/100 .'&'. floor($fig*100)/100 .' real:'. floor($comp['value']*100)/100 . $comp['evalStr'] .'</br>';
				$dmg=($d['weapons'][$x-1]['damage']-15*$expect)*$change+15*$expect;
				//echo $comp['ID']  . ' '. $comp['weaponClass'] .' <b>'. floor($change*10000)/100 .'%</b> expe:'. floor($expect*100)/100 .'('.  $d['weapons'][$x-1]['damage'] .'=>'. $dmg .') real:'. floor($comp['value']*100)/100 . $comp['evalStr'] .'</br>';
				Fwz_mult($d['weapons'][$x-1]['HP'],$change);
				Fwz_mult($d['weapons'][$x-1]['Build power'],$priceMod);
				Fwz_mult($d['weapons'][$x-1]['Build points'],$priceMod);
				Fwz_mult($d['weapons'][$x-1]['damage'],$change);
				Fwz_mult($d['weapons'][$x-1]['splash damage'],$change);
				Fwz_mult($d['weapons'][$x-1]['incenDamage'],$change);
				Fwz_mult($d['weapons'][$x-1]['powChange'],$change);
				Fwz_mult($d['weapons'][$x-1]['powChange2'],$change);
				Fwz_mult($d['weapons'][$x-1]['powChange3'],$change);
				*/
			}
		}
		echo 'tot:'. $ctot/$cnum;
	}
	Fwz_evalSet($d,'weapons');
	Fwz_evalSet($d,'structures');
	if($var[1]!=1 or $var[3]!=1){
		$d['structures']['c']=1;
		$nos1=$d['structures']['k']['ID'][ $sys['wz']['eval']['structures']['base'] ];
		$s1=$d['structures'][ $nos1 ];
		$expect1=fwz_expect($s1['res2']);
		$expect1=pow(fwz_expect($s1['res2']),4);
		echo $s1['ID'] .'trf'. $nos1 .' exp'. $expect1;
		$x=0;while($x++<$d['structures']['n']){
			#Fwz_mult($d['structures'][$x-1][$what],$var[1]*$var[3]);
			$comp=$d['structures'][$x-1];
			if(isset($comp['res']) and $comp['Type']=="DEFENSE" or $comp['Type']=="WALLCORNER" or $comp['Type']=="GATE" or $comp['Type']=="DOOR"){
				//$expect=fwz_expect($comp['res2']);
				$expect=pow(fwz_expect($comp['res2']+1),4);
				$value=$comp['value'];
				$change=$expect/$value/$expect1;
				$d['structures'][$x-1]['change']=$change;
				$d['structures'][$x-1]['emer']=max($change,1/$change);
				Fwz_adaptor($d['structures'][$x-1],$change);
				//$priceMod=Fwz_fig(1/$change,-1);
				#echo $comp['ID']  . ' '. $comp['weaponClass'] .' <b>'. floor($change*10000)/100 .'%</b> expe:'. floor($expect*100)/100 .' real:'. floor($comp['value']*100)/100 .' '.  $comp['evalStr'] .'</br>';
				/*
				Fwz_mult($d['structures'][$x-1]['Build power'],$priceMod);
				Fwz_mult($d['structures'][$x-1]['Build points'],$priceMod);
				Fwz_mult($d['structures'][$x-1]['armour'],$change);
				
				Fwz_mult($d['structures'][$x-1]['powChange'],$change);
				Fwz_mult($d['weapons'][$x-1]['powChange'],$change);
				*/
			}
		}
	}
	if($var[1]!=1 or $var[5]!=1){
		$d['propulsion']['c']=1;
		$x=0;while($x++<$d['propulsion']['n']){
			$change=1/$d['propulsion'][$x-1]['timing'];
			$d['propulsion'][$x-1]['change']=$change;
			$d['propulsion'][$x-1]['emer']=max($change,1/$change);
			//Fwz_adaptor($d['propulsion'][$x-1],1/$d['propulsion'][$x-1]['timing']);
			Fwz_adaptor($d['propulsion'][$x-1],$change);
			/*
			Fwz_propulsionSwitch($t,1);
			$d['propulsion'][$x-1]['HP']=max(floor($d['propulsion'][$x-1]['HP']*$change),0);
			$d['propulsion'][$x-1]['change']=$change;
			Fwz_propulsionSwitch($t,-1);	

			*/			
		}
		//$cybno=$d['propulsion']['k']['ID']['CyborgLegs'];
		//$d['propulsion'][$cybno]['HP']=0; //hugly patch :D
		
	}

}
function Fwz_mod_normalize(&$d,$var){
	if($var[1]!=0 or $var[2]!=0){
		$what='body';
		$d[$what]['c']=1;
		$x=0;while($x++<$d[$what]['n']){
			Fwz_exp($d[$what][$x-1]["HP"],80,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["Build power"],50,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["Build points"],350,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["AFRK"],10,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["AFRH"],10,1+(.1*$var[1])*1+(.1*$var[2]));
		}
	}
	if($var[1]!=0 or $var[3]!=0){
		$what='structures';
		$d[$what]['c']=1;
		$x=0;while($x++<$d[$what]['n']){
			Fwz_exp($d[$what][$x-1]["HP"],100,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["Build power"],100,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["Build points"],1000,1+(.1*$var[1])*1+(.1*$var[2]));
		}
	}
	if($var[1]!=0 or $var[4]!=0){
		$what='weapons';
		$d[$what]['c']=1;
		$x=0;while($x++<$d[$what]['n']){
			Fwz_exp($d[$what][$x-1]["HP"],100,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["Build power"],50,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["Build points"],350,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["damage"],35,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["splash damage"],35,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["shortRange"],128*5,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["longRange"],128*8,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["incenDamage"],5,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["reloadTime"],10,1+(.1*$var[1])*1+(.1*$var[2]));
			Fwz_exp($d[$what][$x-1]["firePause"],10,1+(.1*$var[1])*1+(.1*$var[2]));
		}
	}

}
function Fwz_mod_res(&$d,$var){
	if($var[1]!=1 or $var[2]!=0){
		$d['research']['c']=1;
		$x=0;while($x++<$d['research']['n']){
			Fwz_exp($d['research'][$x-1]['ResearchPoints'],2400,1+(.1*$var[2]));
			Fwz_mult($d['research'][$x-1]['ResearchPoints'],$var[1]);
			if($d['research'][$x-1]['ResearchPoints']>65000){
				$d['research'][$x-1]['ResearchPoints']=65000;
			}
		}
	}
	if($var[3]!=1 or $var[1]!=1){
		$d['functions']['c']=1;
		$x=0;while($x++<$d['functions']['n']){
			if($d['functions'][$x-1]['type']=='Research'){
				$d['functions'][$x-1]['v1']=floor($d['functions'][$x-1]['v1']*$var[1]*$var[3]);
			}
		}
	}
	
}
function Fwz_mod_upgrade(&$d,$var){

	if($var[1]!=1 or $var[2]!=0 or $var[3]!=1 ){
		$d['functions']['c']=1;
		$x=0;while($x++<$d['functions']['n']){
			$f=$d['functions'][$x-1];
			$exp=explode(" ",$f['type']);
			//echo $exp[0];
			if($exp[1]=='Upgrade'){
				$xv=0;
				while($xv++<10){
					if($f['v'. $xv]!=''){
						if($f['v'. $xv]*1==$f['v'. $xv] and $f['v'. $xv]!=1 and $f['v'. $xv]!=0){
							Fwz_mult($d['functions'][$x-1]['v'. $xv],$var[1]);
							if($var[3]!=0){
								$val=pow( 1+.1*$var[3],$f['v'. $xv]/30 );
								if($f['type']=='Weapon Upgrade' and $xv==2){
									$d['functions'][$x-1]['v'. $xv]=valToRof($val);
								}
								else{
									$d['functions'][$x-1]['v'.$xv]=floor(($val-1)*100);
								}
							}
							if($var[4]!=0){
								$expect=Fwz_expect( $f['res']);
								if($f['type']=='Weapon Upgrade'){	
									$expect=pow($expect,1/2);
								}
								if($f['type']=='Weapon Upgrade' and ($f['v2']>0 or  $f['v3']>0)){	
								}
								else{
								
									echo $f['name'] .'expect:'. $expect .$f['type']. '='. $xv.'<br/>';
									if($f['type']=='Weapon Upgrade' and $xv==2){
										$d['functions'][$x-1]['v'. $xv]=valToRof($expect);
										echo 'ROF';
									}
									else{
										$d['functions'][$x-1]['v'. $xv]=floor(($expect-1)*100);
									}
								}
								#$d['functions'][$x-1]['v'.$xv]=floor( pow( 1+.1*$var[3],$f['v'. $xv]/30 ) *100)-100;
							}
							Fwz_exp($d['functions'][$x-1]['v'. $xv],2400*$var[1],1+(.10*$var[2]));
						}
					}
				}
			}
		}
	}


}
function Fwz_mod_dist(&$d,$var){
	echo 'dist modding...';
	if($var[1]!=1 or $var[2]!=1){
		$d['propulsion']['c']=1;
		$d['propulsiontype']['c']=1;
		$x=0;while($x++<$d['propulsion']['n']){
			Fwz_mult($d['propulsion'][$x-1]['maxSpeed'],$var[1]*$var[2]);
		}
		$x=0;while($x++<$d['propulsiontype']['n']){
			Fwz_mult($d['propulsiontype'][$x-1]['multiplier'],$var[1]*$var[2]);
		}
	}
	if($var[1]!=1 or $var[3]!=1){
		$d['sensor']['c']=1;
		$x=0;while($x++<$d['sensor']['n']){
			Fwz_mult($d['sensor'][$x-1]['range'],$var[1]*$var[3]);
		}
	}
	if($var[1]!=1 or $var[4]!=1){
		$d['weapons']['c']=1;
		$x=0;while($x++<$d['weapons']['n']){
			Fwz_mult($d['weapons'][$x-1]['shortRange'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$x-1]['longRange'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$x-1]['splash radius'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$x-1]['incenRadius'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$x-1]['flightSpeed'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$x-1]['indirectHeight'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$x-1]['minRange'],$var[1]*$var[4]);
		}
	}

}
function Fwz_mod_distV2(&$d,$var){
	echo 'dist modding...';
	if($var[1]!=1 or $var[2]!=1){
		//$d['propulsion']['c']=1;
		//$d['propulsiontype']['c']=1;
		foreach($d['propulsion'] as $x => $val){
			print_r($val);
			Fwz_mult($d['propulsion'][$x]['maxSpeed'],$var[1]*$var[2]);
		}
		foreach($d['propulsiontype'] as $x => $val){
			Fwz_mult($d['propulsiontype'][$x]['multiplier'],$var[1]*$var[2]);
		}
	}
	if($var[1]!=1 or $var[3]!=1){
		//$d['sensor']['c']=1;
		foreach($d['sensor'] as $x => $val){
			Fwz_mult($d['sensor'][$x]['range'],$var[1]*$var[3]);
		}
	}
	if($var[1]!=1 or $var[4]!=1){
		//$d['weapons']['c']=1;
		foreach($d['weapons'] as $x => $val){
			Fwz_mult($d['weapons'][$x]['shortRange'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$x]['longRange'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$x]['radius'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$x]['periodicalDamageRadius'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$x]['flightSpeed'],$var[1]*$var[4]);
			//Fwz_mult($d['weapons'][$x]['indirectHeight'],$var[1]*$var[4]);
			//Fwz_mult($d['weapons'][$x]['minRange'],$var[1]*$var[4]);
		}
	}

}
function Fwz_TechTree(&$data,$var){
	$r=0;
	//$d['weapons']['c']=1;
	$x=0;while($x++<$d['weapons']['n']){
		$obj=$d['weapons'][$x-1];
		$techlvl=floor($obj['res']);
		$pr2[$pr2['n']++]=array();
	}

	
}
function Fwz_exp(&$data,$norm,$var){
	$data=floor(pow($data,$var)*pow($norm,1-$var));
	return $data;
}
if($_GET['interface']){
	$temp['name']="auto";
	$temp['var'][1]="all";
	$temp['varDef'][1]='c';
	$temp['var'][2]="body";
	$temp['varDef'][2]='c';
	$temp['var'][3]="struct";
	$temp['varDef'][3]='c';
	$temp['var'][4]="weap";
	$temp['varDef'][4]='c';
	$temp['var'][5]="prop";
	$temp['varDef'][5]='c';
	$mod[ ++$mod['n'] ]=$temp;
	unset($temp);
	
	$temp['name']="cost";
	$temp['var'][1]="all";
	$temp['var'][2]="body";
	$temp['var'][3]="struct";
	$temp['var'][4]="weap";
	$temp['var'][5]="sens";
	$temp['var'][6]="const";
	$temp['var'][7]="repair";
	$mod[ ++$mod['n'] ]=$temp;
	unset($temp);
	
	$temp['name']="prod";
	$temp['var'][1]="all";
	$temp['var'][2]="body";
	$temp['var'][3]="struct";
	$temp['var'][4]="weap";
	$mod[ ++$mod['n'] ]=$temp;
	unset($temp);
	
	$temp['name']="hp";
	$temp['var'][1]="all";
	$temp['var'][2]="body";
	$temp['var'][3]="struct";
	$temp['var'][4]="weap";
	$mod[ ++$mod['n'] ]=$temp;
	unset($temp);
	
	$temp['name']="normalize";
	$temp['var'][1]="all";
	$temp['varDef'][1]=0;
	$temp['var'][2]="body";
	$temp['varDef'][2]=0;
	$temp['var'][3]="struct";
	$temp['varDef'][3]=0;
	$temp['var'][4]="weap";
	$temp['varDef'][4]=0;
	$mod[ ++$mod['n'] ]=$temp;
	unset($temp);
	
	$temp['name']="res";
	$temp['var'][1]="price";
	$temp['var'][2]="exp";
	$temp['varDef'][2]=0;
	$temp['var'][3]="speed";
	$mod[ ++$mod['n'] ]=$temp;
	unset($temp);
	
	$temp['name']="dist";
	$temp['var'][1]="all";
	$temp['var'][2]="prop";
	$temp['var'][3]="sensor";
	$temp['var'][4]="weap";
	$mod[ ++$mod['n'] ]=$temp;
	unset($temp);
	
	
	$temp['name']="upgrade";
	$temp['var'][1]="val";
	$temp['var'][2]="exp(2^x)";
	$temp['varDef'][2]=0;
	$temp['var'][3]="Exp2(x^2)";
	$temp['varDef'][3]=0;
	$temp['var'][4]="Xpect fun";
	$temp['varDef'][4]='c';
	$mod[ ++$mod['n'] ]=$temp;
	unset($temp);
	
	
	$temp['name']="TechTree";
	$temp['var'][1]="rebuilt";
	$temp['varDef'][1]='c';
	Fwz_style();
	$basedir='/home/patrick/warzone2100-2.3.8/data/mp';
	$savedir='/home/patrick/warzone2100-2.3.8/data/mods/multiplay/';
	$branch="2.3.8";
	//$basedir='/home/patrick/warzone2100-2.3.8/data/mods/multiplay/aaProtoV06-2.3.8-iluMV01';
	$data=Fwz_loadall($basedir);
	
	$basedir='/home/patrick/warzone2100-2.3.8/data/mods/multiplay/NTT/';
	//$data=Fwz_loadall($basedir,$data);
	/*
	$basedir='/home/patrick/warzone2100-2.3.8/data/mods/multiplay/NTT';
	$data['propulsion']=Fwz_loader($basedir,'propulsion2');
	$data['research']=Fwz_loader($basedir,'research');
	$data['redcomponents']=Fwz_loader($basedir,'redcomponents');
	$data['resultcomponent']=Fwz_loader($basedir,'resultcomponent');
	$data['structureweapons']=Fwz_loader($basedir,'structureweapons');
	//$data['structures']=Fwz_loader($basedir,'structures');
	$data['functions']=Fwz_loader($basedir,'functions2');
	$data['weapons']=Fwz_loader($basedir,'weapons2');
	$data['brain']=Fwz_loader($basedir,'brain');
	$data['researchfunctions']=Fwz_loader($basedir,'researchfunctions');
	*/
	//$basedir='/home/patrick/warzone2100-2.3.8/data/mods/multiplay/aaProtoV06-2.3.8-iluMV01';
	//$data['weapons']=Fwz_loader($basedir,'weapons');
	//$data['structures']=Fwz_loader($basedir,'structures');
	//$data['body']=Fwz_loader($basedir,'body');
	Fwz_resTime($data);
	Fwz_evalSet($data,'weapons');
	Fwz_evalSet($data,'body');
	Fwz_evalSet($data,'structures');
	Fwz_evalSet($data,'propulsion');
	Fwz_evalSet($data,'sensor');
	Fwz_evalSet($data,'brain');
	//print_r($data['names']['k']['ID']);
	//print_r($data['weapons'][14]);
	//print_r($data['weapons'][2]);
	
	#echo '<br><br>';
	
	//print_r($data['assignweapons']['k']['ID']);
	//Fwz_getFunct($data,15000,'Weapon Upgrade','ROCKET');
	
	echo 'test1:'. Fwz_exp($t=10,10,2);
	echo 'test1:'. Fwz_exp($t=20,10,2);
	echo '<form name="form1" method="post">';
	echo 'sufix:<input name="sufix" value="'. $_POST['sufix'].'"><br/>';
	echo 'mod name:<input name="modname" value="'. $_POST['modname'].'"><br/>';
	$xmod=0;
	while($xmod++<$mod['n']){
		unset($temp);
		unset($launch);
		unset($tdesc);
		unset($tmname);
		$m=$mod[$xmod];
		foreach($m['var'] as $no => $name){
			//echo $m['name'] .'_var'. $no .':'. $_POST[ $m['name'] .'_var'. $no ] .' ='.  $_POST['cost_var'. $no].'<br/>';
			$temp[$no]=$_POST[ $m['name'] .'_var'. $no ] ;
			if( !isset($m['varDef'][$no]) ){	$m['varDef'][$no]=1;	}
			if($_POST[ $m['name'] .'_var'. $no ] !=$m['varDef'][$no] and isset($_POST[ $m['name'] .'_var'. $no ])){
				$launch=1;
				$tmname.=$name[0];
				$div=0;
				if($tdesc==''){
					$tdesc.=' of '. $name;
					
				}
				else{
					$tdesc.=' and '. $name;
				}
				if($_POST[ $m['name'] .'_var'. $no ]<1 and $_POST[ $m['name'] .'_var'. $no ]>-1){
					$div=1;
					if($m['varDef'][$no]==0){
						$pre=' exposed by ';
					}
					else{
						$value=1/$_POST[ $m['name'] .'_var'. $no ];
						$tmname.='d';
						$pre=' divided by ';
					}
					
				}
				else{
					$value=$_POST[ $m['name'] .'_var'. $no ];
					if($m['varDef'][$no]==0){
						$pre=' exposed by ';
					}
					else{
						$pre=' multiplied by ';
					}
				}
				if($m['varDef'][$no]==='c'){
				}
				else{
					$tdesc.=$pre.$value;
					$tmname.=floor($value+.0001);
				}
				$m['varDef'][$no]=$_POST[ $m['name'] .'_var'. $no ];
			}
		}
		if($launch){
			$funcname='Fwz_mod_'. $m['name'];
			$funcname($data,$temp);
			if($mname!=''){ $mmname.=" and "; }
			if($desc!=''){ $desc.=" and "; }
			$mname.=$m['name'][0] . $tmname;
			$desc.=$m['name'] . $tdesc;
		}
		//print_r($m);
		buildform($m);
	}
	echo '<input type="submit" name="launch" value="go">';
	echo '</form>';
	$mname.=$_POST['sufix'] .'-'. $branch .'-'. $modder;
	echo 'mod name:'.$_POST['modname'] .'<br/>';
	echo 'mod name:'.$mname .'<br/>';
	echo 'mod desc:'.$desc .'<br/>';
	$data['changelog'][]['str']='mod name:		'.$_POST['modname'];
	$data['changelog'][]['str']='auto name:		'.$mname;
	$data['changelog'][]['str']='description:		'.$desc;
	//phpinfo();
	//Fwz_sort($data,'structures');
	//Fwz_sort($data,'weapons','change');
	//Fwz_sort($data,'structures','change');
	//Fwz_sort($data,'body','change');
	$data['all']=array_merge($data['body'],$data['structures']);
	$data['all']=array_merge($data['all'],$data['weapons']);
	$data['all']=array_merge($data['all'],$data['propulsion']);
	Fwz_mkKey($data,'all');
	//$data['all']=$data['propulsion'];
	echo 'fig:'. Fwz_fig(3,-1) .'</br>';;
	//Fwz_sort($data,'all','emer');
	Fwz_showall($data,'all');
	//Fwz_showall($data,'propulsion');
	//Fwz_sort($data,'research','value');
	//Fwz_showall($data,'research');
	print_r($data['changelog']);
	////////////
	/*
	$res=$data['research'];
	$xr=0;
	while($xr++<$res['n']){
		if($res[$xr]['value']>0){
			echo 'camTech	['. $count*1 .']	RESEARCHSTAT	"'.  $res[$xr]['ID'] .'"';
			//echo $res[$xr]['value']/(1000*pow(2,$lniv));
			if(floor($res[$xr]['value']/(1000*pow(2,$lniv)))){
				echo '//'. 1000*pow(2,$lniv);
				$lniv++;
			}
			echo '<br/>';
			//echo $count .' '. $res[$xr]['ID'] .'<br/>';
			$count++;
		}
	}
	
	/*
	echo '<table>';
	$xw=0;
	while($xw++<$data['weapons']['n']){
		
		$type=$data['weapons'][$xw]['weaponSubClass'];
		if(!$typedone[$type]){
			echo '<tr>';
			$typedone[$type]=1;
			$weaptype=$type;
			echo '<td>'. $weaptype .'</td>';
			$x=0;
			while($x++<50){
				$restime=($x-1)*3200;
				$val=Fwz_getFunct($data,$restime,'Weapon Upgrade',$weaptype);
				echo  '<td>'. floor($val['weapval']*100) .'</td>';
			}
			print_r($val);
			echo '</tr>';
		}
	}
	echo '</table>';
	*/
	/*
	$data['weapons']['c']=1;
	$mname='TDV01';
	$xw=0;
	while($xw++<$data['weapons']['n']){
		$w=$data['weapons'][$xw];
		echo $xw .' '. $w['ID'];
		$data['weapons'][$xw]['designable']=0;
		
	}
	*/
	Fwz_saveall($savedir . $mname,$data);
	//Fwz_zip($savedir,$mname);
}

//form




