<?php
function sign($n) {
    return ($n > 0) - ($n < 0);
}
function Fwz_loader($basedir,$file,$data){
	global $sys;
	//echo 'load:'. $file;
	$s=$sys['wz']['file'][$file];
	if($s['type']=='sfile'){
	}
	elseif(file_exists($basedir.$s['pos'])){
		$str=file($basedir.$s['pos']);
		//echo $basedir.$s['pos'];
		if($file=='piestats'){
			$ret=$str;
			$ret['n']=count($ret);
		}
		else{
			$arrName=$s['arrName'];
			$key=$s['key'];
			$key2=$s['key2'];
			//echo $filename .'....'. $str[1];
			foreach($str as $no => $vala){
				if($file=='names'){
					unset($temp);
					$temp1=explode('	',$vala);
					if(count($temp1)<2){
						$temp1=explode(' ',$vala);
					}
					foreach($temp1 as $no3 => $val){
						if($val!=''){
							$valf=$val;
							$type='???';
							if(strpos($val,'_("')!==false){
								//echo '-dsdf';
								$val2=explode('_("',$val);
								$val3=explode('")',$val2[1]);
								$valf=$val3[0];
								$type='official';
							}
							elseif(strpos($val,'"*')!==false){
								$val2=explode('"*',$val);
								$val3=explode('*"',$val2[1]);
								$valf=$val3[0];
								$type='inside';
							}
							elseif(strpos($val,'"')!==false){
								$val2=explode('"',$val);
								$val3=explode('"',$val2[1]);
								$valf=$val3[0];
								$type='official';
							}
							//$val3=explode("\")",$val2[0]);
							$temp[]=$valf;
						}
					}
					$temp[2]=$type;
					if($type=='???'){
						$temp[0]=$vala;
					}
					//print_r($temp);
					
				}
				else{
					$temp=explode(',',$vala);
				}
				$ret['n']++;
				$count=count($temp);
				foreach($temp as $no2 => $val2){
					$ret[$no][ $arrName[$no2] ]=$val2;
					if(isset($key)){	if( in_array($arrName[$no2],$key) ){
						$ret['k'][$arrName[$no2]][$val2]=$no;
					} }
					if(isset($key2)){ if( in_array($arrName[$no2],$key2) ){
						$ret['k'][$arrName[$no2]][$val2][ ++$ret['k'][$arrName[$no2]][$val2]['n'] ]=$no;
					} }
				}
				//names ?
				if($file!='names'){
					$noName=$data['names']['k']['ID'][ $ret[$no]['ID'] ];
					//echo $ret[$no]['ID'] .'</br>';
					if($noName){
						$ret[$no]['name']=$data['names'][ $noName ]['name'];
						//echo $ret['name'] .' '. $ret[$no]['ID'];
					}
					$ret[$no]['no']=$no;
				}
			}
			//print_r($data['names']['k']['ID']);
		}
		return $ret;
	}
}
/*
function Fwz_add(&$data,$file,$arr){
	$data[$file][ $data[$file]['n']++ ]=$arr;
}
*/
function Fwz_specFileSaver($file,$data){
	global $sys;
	$basedir=$sys['wz']['load']['modelFolder'];
	$s=$sys['wz']['file'][$file];
	echo 'specfile'. $basedir.$s['pos'];
	$pos=$s['pos'];
	if($s['posload']!=''){
		$pos=$s['posload'];
	}
	if(file_exists($basedir.$pos)){
		$str=file($basedir.$pos);
		foreach($str as $no => $val){
			//echo $val;
			if(strpos($val,'[[')!==false){
				echo '-dsdf'. $val;
				$val2=explode('[[',$val);
				$val3=explode(']]',$val2[1]);
				$val4=explode('|',$val3[0]);
				if(isset( $data[$file][$val4[0]] ) ){
					echo 'changed';
					$val4[1]=$data[$file][$val4[0]];
				}
				$str[$no]=$val2[0].$val4[1].$val3[1];
			}
		}
	}
	else{
		echo 'Warning:file do not exist in ./model directory';
	}
	return $str;
}
function Fwz_mkKey(&$data,$file){
	global $sys;
	$s=$sys['wz']['file'][$file];
	$c=$data[$file]['c'];
	unset($data[$file]['n']);
	unset($data[$file]['k']);
	unset($data[$file]['c']);
	$data[$file]['n']=count($data[$file]);
	$data[$file]['c']=$c;
	$x=0;
	$key=$s['key'];
	$key2=$s['key2'];
	while($x++<$data[$file]['n']){
		foreach($key as $no => $nom){
			$data[$file]['k'][$nom][ $data[$file][$x-1][$nom] ]=$x-1;
		}
		if($key2){
			foreach($key2 as $no => $nom){
				$data[$file]['k'][$nom][ $data[$file][$x-1][$nom] ][ ++$data[$file]['k'][$nom][ $data[$file][$x-1][$nom] ]['n'] ]=$x-1;
			}
			$data[$file][$x-1]['no']=$x-1;
		}
	}
}
function Fwz_saver($basedir,$file,$data){
	global $sys;
	$d=$data[$file];
	$s=$sys['wz']['file'][$file];
	$arrName=$s['arrName'];
	$key=$s['key'];
	$key2=$s['key2'];
	$x=0;
	if($s['type']=='sfile'){
		$str= Fwz_specFileSaver($file,$data);
	}
	elseif($file=='piestats'){
		unset($d['c']);
		unset($d['n']);
		$str=$d;
	}
	else{
		while($x++<$d['n']){
			$dx=$d[$x-1];
			if($file=='names'){
				if($dx['type']=='???'){
					$ts=$dx['ID'];
				}
				elseif($dx['type']=='inside'){
					$ts=$dx['ID'] .'							"*'. $dx['name'] .'*"';
				}
				elseif($dx['type']=='official'){
					$ts=$dx['ID'] .'							_("'. $dx['name'] .'")';
				}
				else{
					unset($ts);
				}
			}
			else{
				unset($temp);
				foreach($arrName as $no => $nom){
					//echo $nom;
					if(!($dx[$nom]==='' or $dx[$nom]===NULL)){
						$temp[]=$dx[$nom];
					}
				}
				//print_r($temp);
				$ts=implode(',',$temp);	
			}
			$c=strlen($ts);
			if($ts[$c-1]!="\n" and $x!=$d['n']){
				$ts.="\n";
			}

			if($x>5 or $file!=='names'){
				$str[]=$ts;
			}
		}	

		$exp=explode('/',$s['pos']);
		$rand=$basedir;
		$c=0;
		foreach($exp as $no => $nom){
			$rand.='/'. $nom;
			//echo $rand;
			$c++;
			if($c<count($exp)){
				$oldumask = umask(0);
				//mkdir('mydir', 0777); // or even 01777 so you get the sticky bit set
				@mkdir($rand,0777,true);
				umask($oldumask);
			}
		}
	}
	echo '('. $basedir.$s['pos'] .')';
	file_put_contents($basedir.$s['pos'],$str);
}
function Fwz_loadall($basedir,$data){
	global $sys;
	
	foreach($sys['wz']['file'] as $nom => $val){
		$temp=Fwz_loader($basedir,$nom,$data);
		if($temp['n']>0){
			$data[$nom]=$temp;
			//echo '------'. $nom .'<br/>';;
		}
	}
	
	return $data;
}
function Fwz_saveall($basedir,$data){
	global $sys;
	if(!file_exists($basedir)){	
		$oldumask = umask(0);
		//mkdir('mydir', 0777); // or even 01777 so you get the sticky bit set
		@mkdir($basedir,0777,true);
		umask($oldumask);
	}
	$data['changelog']['n']=count($data['changelog']);
	if($data['changelog']['n']>0){
		$data['changelog']['c']=1;
	}
	foreach($sys['wz']['file'] as $nom => $val){
		echo $nom;
		if($data[$nom]['me']){
			print_r($data[$nom]);
		}
		if($data[$nom]['c']){
			echo 'saving:'. $basedir .' '. $nom .'<br/>';
			Fwz_saver($basedir,$nom,$data);
		}
		//$ret[$nom]=Fwz_loader($basedir,$nom);
	}
	//file_put_contents($basedir . '/wrf/piestats.wrf',$data['pie']);
	return $ret;
}
function Fwz_zip($basedir,$name){
	$zip = new Zipper;
	$res = $zip->open($basedir .'/'. $name .'.wz',ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
	if ($res === TRUE) {
		$path=$basedir .'/'. $name ;
		$zip->addDir($path,$path);
		$zip->close();
	} else {
		echo 'failed, code:' . $res;
	}

}
class Zipper extends ZipArchive {
   
public function addDir($path,$base) {
    //print 'adding ' . $path . '<br>';
    //$this->addEmptyDir($path);
    $nodes = glob($path . '/*');
    foreach ($nodes as $node) {
	$path2=str_replace($base,'',$node);
	print $node . '=>'. $path2 . '<br>';
        if (is_dir($node)) {
 	    $this->addEmptyDir($path2);
            $this->addDir($node,$base);
        } else if (is_file($node))  {
            $this->addFile($node,$path2);
        }
    }
}
   
} // class Zipper


function Fwz_propulsionSwitch(&$obj,$sign,$body=NULL){
	global $sys;
	if($body!=NULL){
		$boost=$body;
	}
	else{
		$boost=$sys['wz']['mean']['body'];
	}
	//$arr=explode(',','buildPower,buildPoints,weight,HP');
	$arr=explode(',','buildPower,buildPoints,weight,hitpoints');
	foreach($arr as $no => $val){
		if($sign<0){
			$obj[$val]/=$boost[$val]/100;
		}
		$obj[$val]+=$sign*100;
		if($sign>0){
			$obj[$val]*=$boost[$val]/100;
		}

	}
	//print_r($obj);
}
function Fwz_weapModNormAll(&$data,$key,$devWanted){
	$data['weaponmodifier']['c']=1;
	$data['structuremodifier']['c']=1;
	$x=0;
	while($x++<$data['weaponmodifier']['k']['propulsion type']['Lift']['n']){
		$no=$data['weaponmodifier']['k']['propulsion type']['Lift'][$x];
		$temp=$data['weaponmodifier'][$no];
		$wt=$temp['weapon type'];
		
		if($wt=='FLAMER' or $wt=='BUNKER BUSTER' or $wt=='ARTILLERY ROUND'){ //stupid vtol resistance to impossible situation (or close)
			$data['weaponmodifier'][$no]['value']=10;
		}
	}
	foreach($data['weaponmodifier']['k'][$key] as $id => $val){
		Fwz_weapModNorm($data,$id,$devWanted);
	}
}
function Fwz_weapModNorm(&$data,$type,$devWanted){
	if($data['weaponmodifier']['k']['weapon type'][$type]['n']){
		$key='weapon type';
	}
	elseif($data['weaponmodifier']['k']['propulsion type'][$type]['n']){
		$key='propulsion type';
	}
	elseif($data['structuremodifier']['k']['structure type'][$type]['n']){
		$key='structure type';
	}
	if($key){
		$x=0;
		while($x++<$data['weaponmodifier']['k'][$key][$type]['n']){
			$no=$data['weaponmodifier']['k'][$key][$type][$x];
			$temp=$data['weaponmodifier'][$no];
			$sum+=$temp['value']/100;
		}
		if($type=='ALL ROUNDER'){
			$type='ANTI AIRCRAFT';
		}
		$x2=0;
		while($x2++<$data['structuremodifier']['k'][$key][$type]['n']){
			$no=$data['structuremodifier']['k'][$key][$type][$x2];
			$temp=$data['structuremodifier'][$no];
			$sum+=$temp['value']/100;
		}
		$mean=$sum/($data['weaponmodifier']['k'][$key][$type]['n']+$data['structuremodifier']['k'][$key][$type]['n']);
		if($key!='weapon type'){
			//$mean=1/$mean;
		}
		//phase 2 (deviation)
		$x=0;
		while($x++<$data['weaponmodifier']['k'][$key][$type]['n']){
			$no=$data['weaponmodifier']['k'][$key][$type][$x];
			$temp=$data['weaponmodifier'][$no];
			$dev+=abs($mean-$temp['value']/100);
		}
		if($type=='ALL ROUNDER'){
			$type='ANTI AIRCRAFT';
		}
		$x2=0;
		while($x2++<$data['structuremodifier']['k'][$key][$type]['n']){
			$no=$data['structuremodifier']['k'][$key][$type][$x2];
			$temp=$data['structuremodifier'][$no];
			$dev+=abs($mean-$temp['value']/100);
		}
		if($type=='Lift'){
			$meandev=$dev/($data['weaponmodifier']['k'][$key][$type]['n']+$data['structuremodifier']['k'][$key][$type]['n'])*2;
			$mean=.6;
		}
		else{
			$meandev=$dev/($data['weaponmodifier']['k'][$key][$type]['n']+$data['structuremodifier']['k'][$key][$type]['n']);
		}
		$scale=$devWanted/$meandev;
		//phase 3 (execution)
		$x=0;
		while($x++<$data['weaponmodifier']['k'][$key][$type]['n']){
			$no=$data['weaponmodifier']['k'][$key][$type][$x];
			$temp=$data['weaponmodifier'][$no];
			$data['weaponmodifier'][$no]['value']=floor(($mean*100-($mean*100-$temp['value'])*$scale)/$mean);
			echo $temp['weapon type'] .' '. ($mean*100) .'-'. ($mean*100-$temp['value']) .'='. $data['weaponmodifier'][$no]['value'] .'<br/>';
		}
		if($type=='ALL ROUNDER'){
			$type='ANTI AIRCRAFT';
		}
		$x2=0;
		while($x2++<$data['structuremodifier']['k'][$key][$type]['n']){
			$no=$data['structuremodifier']['k'][$key][$type][$x2];
			$temp=$data['structuremodifier'][$no];
			$data['structuremodifier'][$no]['value']=floor($mean+($mean*100-$temp['value'])*$scale*100/$mean);
		}
		echo $type .' IS A '.  $key .'  '. $sum .' '. ($data['weaponmodifier']['k'][$key][$type]['n']+$data['structuremodifier']['k'][$key][$type]['n']).'='. $mean .'('. $meandev .'): '. $scale .'<br/>';
	}
	else{
		$mean=1;
	}
	return $mean;
}
function Fwz_WeapMod($data,$type){
	if($data['weaponmodifier']['k']['weapon type'][$type]['n']){
		$key='weapon type';;
	}
	elseif($data['weaponmodifier']['k']['propulsion type'][$type]['n']){
		$key='propulsion type';
	}
	elseif($data['structuremodifier']['k']['structure type'][$type]['n']){
		$key='structure type';
	}
	if($key){
		//$obj['type'].$obj['weaponEffect'].$obj['Strength']
		$x=0;
		while($x++<$data['weaponmodifier']['k'][$key][$type]['n']){
			$no=$data['weaponmodifier']['k'][$key][$type][$x];
			$temp=$data['weaponmodifier'][$no];
			if($key=='weapon type'){
				$mult=$data['propulsion']['k']['type'][$temp['propulsion type']]['n'];
			}
			else{
				$mult=$data['weapons']['k']['weaponEffect'][$temp['weapon type']]['n'];
			}
			$sum+=$temp['value']*$mult;
			$tot+=$mult;
		}
		if($type=='ALL ROUNDER'){
			$type='ANTI AIRCRAFT';
		}
		$x2=0;
		while($x2++<$data['structuremodifier']['k'][$key][$type]['n']){
			$no=$data['structuremodifier']['k'][$key][$type][$x2];
			$temp=$data['structuremodifier'][$no];
			if($key=='weapon type'){
				$mult=$data['structures']['k']['Strength'][$temp['structure type']]['n'];
			}
			else{
				$mult=$data['weapons']['k']['weaponEffect'][$temp['weapon type']]['n'];
			}
			//echo 'no:'. $no .$key;
			//print_r($temp);
			$sum2+=$temp['value']*$mult;
			$tot2+=$mult;
		}
		if($key=='weapon type'){
			$mean=($sum/$tot*3+$sum2/$tot2)/4/100;
		}
		elseif($key=='propulsion type'){
			$mean=$sum/$tot/100;
		}
		else{
			$mean=$sum2/$tot2/100;
		}
		//$mean=$sum/($x+$x2-2)/100;
		if($key!='weapon type'){
			$mean=1/$mean;
		}
		//echo $type .' IS A '.  $key .':D '. $mean .': '. $tot .'+'. $tot2 .'<br/>';
	}
	else{
		$mean=1;
	}
	return $mean;
}
function Fwz_eval34(&$obj,$type,$calibrate=1){
	global $sys;
	global $data;
	//print_r($obj);
	//echo 'TYPE--:' .$type;
	if($type=='templates'){
		$noBody=$data['body']['k']['ID'][ $obj['BODY'] ];
		$noProp=$data['propulsion']['k']['ID'][ $obj['PROPULSION'] ];
		$noAss=$data['assignweapons']['k']['ID'][$obj['ID'] ];
		$ass=$data['assignweapons'][$noAss];
		$noW1=$data['weapons']['k']['ID'][ $ass['w1'] ];
		$noW2=$data['weapons']['k']['ID'][ $ass['w2'] ];
		$temp=Fwz_template($data,$noW1,$noBody,$noProp,$noW2);
		$obj=array_merge($obj,$temp);
		//print_r($ret[$no]);
		//echo 'template:'. $obj['name'] .' '. $noBody .' '. $noW1 .'<br/>';
	}
	
	$boost=$sys['wz']['boost'][$type];
	//print_r($boost);
	if($type=='propulsion'){ Fwz_propulsionSwitch($obj,1); }
	$tol=Fwz_get($data['structures'],'ID','A0VTolFactory1');
	//echo 'tolres:'. $tol['res'];
	if(($obj['numAttackRuns'] or (!$obj['surfaceToAir']<1 and $obj['surfaceToAir']<50)) and $obj['res']<$tol['res']){
		$obj['res2']=$tol['res']; //vtol restime
	}
	else{
		$obj['res2']=$obj['res'];
	}
	$expect=Fwz_expect($obj['res2'],$type);
	$obj['miscMod']=1;
	$obj['hitpoints']=max(1,$obj['hitpoints']);
	$obj2=$obj; //some calculation that I dont want saved
	//$obj['buildPower']=max(1,$obj['buildPower']);
	//$obj['buildPoints']=max(1,$obj['buildPoints']);
	$obj['modMod']=Fwz_WeapMod($data,$obj['weaponEffect']);
	$obj['modMod']*=Fwz_WeapMod($data,$obj['type'].$obj['Strength']);
	$obj['modMod']=pow($obj['modMod'],.5); //<= Decision modifier "you shall not build them in stupid time"
	$obj['expect']=$expect;
	$boost['hitpoints']*=$expect;
	$boost['weap']*=$expect;
	//print_r($boost);
	$res=$obj['res2']*1.5+18000;
	if($type=='weapons' or $type=='sensor' or $type=='templates'  or $type=='construction'  or $type=='repair'){	
		$fun=Fwz_getFunct($data,$res,'Weapon Upgrade',$obj['weaponSubClass']);
		$weapval=$fun['weapval'];
		$fun=Fwz_getFunct($data,$res,'VehicleBody Upgrade','');
		$obj['bodyval']=$fun['bodyval'];

		//echo $obj['ID'] .':'. $weapval .' '. $res .'<br/>';
		if($type=='templates'){
			//echo $obj['ID'] .':'. $weapval;
		}
		if($obj['ID']=='AutoRepair'){
			$boost['weap']+=$sys['wz']['boost']['body']['weap'];
		}
	}
	if($type=='body' or $type=='propulsion'){
		//$boost['weap']=1;
		$fun=Fwz_getFunct($data,$res,'Weapon Upgrade','MORTARS');
		$weapval=$fun['weapval'];
		$fun=Fwz_getFunct($data,$res,'Weapon Upgrade','ENERGY');
		$weapval*=pow($fun['weapval'],1);
		$weapval=pow($weapval,3/4);
		$fun=Fwz_getFunct($data,$res,'VehicleBody Upgrade','');
		$obj['bodyval']=$fun['bodyval'];
	}
	if($type=='structures'){
		if($obj['Type']=="DEFENSE" or $obj['Type']=="WALL" or $obj['Type']=="WALLCORNER" or $obj['Type']=="GATE" or $obj['Type']=="BLASTDOOR"){
			$fun=Fwz_getFunct($data,$res,'WallDefence Upgrade','');
		}	
		else{
			$fun=Fwz_getFunct($data,$res,'Structure Upgrade','');
		}
		$obj['bodyval']=$fun['structval'];
		$weapval=1;
		
	}
	if($obj['radiusDamage']>0){
		//$obj['sdmg']=Fwz_armor($obj['splash damage'])*(pow($obj['splash radius']/128,1.41)-1/4)*$obj['splash chance']/100/2;
		//$obj['sdmg']=Fwz_armor($obj['radiusDamage'])*(pow($obj['radius']/128,1.41)-1/4)*$obj['radiusLife']/100/2;
		$obj['sdmg']=Fwz_armor($obj['radiusDamage'],0)*(pow($obj['radius']/128,1.41)-1/4); //-1/4 is for the center radius
	}
	$totrange=$obj['shortRange']+$obj['longRange']+1; //+1 will never happen anyway (0+0/0[+1])
	$obj['longHit']=min(100,$obj['longHit']);
	$obj['shortHit']=min(100,$obj['shortHit']);
	$obj['kdmg']=Fwz_armor($obj['damage'],$obj['armourKinetic'])*($obj['shortHit']*$obj['shortRange']/$totrange+$obj['longHit']*$obj['longRange']/$totrange)/100;
	//$obj['kdmg']=Fwz_armor($obj['damage'],0)*($obj['shortHit']+$obj['longHit'])/100/2;
	if($obj['periodicalDamageTime']>0){
		$obj['fdmg']=Fwz_armor($obj['periodicalDamage']+15*5,$obj['armourHeat'])*pow(($obj['periodicalDamageRadius'])/128,1.41)*$obj['periodicalDamageTime']/20/3;
	}
	if($obj['weaponSubClass']=='EMP'){
		$obj['edmg']=$calibrate*$expect*2;
	}
	if($obj['weaponSubClass']=='ELECTRONIC'){
		$obj['kdmg']*=100; //200 / half life
	}
	if($obj['weaponSubClass']=='COMMAND'){
		$obj['miscBonus']=$calibrate*$expect;
	}
	if($type=='sensor'){
		if($obj['type']=='SUPER'){
			$obj['kdmg']=40;
		}
		else{
			$obj['kdmg']=20;
		}
	}
	if($obj['ID']=='TransporterBody'){
		//echo 'transbody!<br/>';
		//$obj['kdmg']+=$boost['weap']*2/60;
		$obj['kdmg']+=$boost['weap']*2;
		
	}
		//FIXME
		$weapval=1;
		$obj['bodyval']=1;
	$obj['kdmg']+=$obj['constructPoints']+$obj['repairPoints'];
	$obj['kdmg']+=$sys['wz']['mean']['weapons']['weap']*($obj['FunctionSet']+$obj['FunctionSet2']);
	$obj['tdmg']=$obj['kdmg']+$obj['fdmg']+$obj['sdmg']+$obj['edmg'];
	$rounds=max(1,$obj['numRounds'],$obj['numAttackRuns']);
	$range=($obj['longRange']+$obj['shortRange']+$obj['range']*2)/128/2;
	$range=($obj['longRange']+$obj['range'])/128;
	if($obj['weaponSubClass']=='LAS_SAT'){
		$range=250;
		$obj['miscMod']*=1.5/2; //Target hability * limit constraint
	}

	if($obj['numAttackRuns']){
		#echo $obj['ID'] .'='. $obj['numAttackRuns'];
		//$slotmult*=pow( $obj['numAttackRuns'],.5);
		//$obj['rof']=$obj['numAttackRuns']/($obj['numAttackRuns']*20+(80));
		$obj['rof']=60*($rounds)/($obj['reloadTime']+$rounds*30+550);
		$range*=1.5;
	}
	elseif($obj['reloadTime']>0){
		//$obj['rof']=60*($rounds)/($obj['reloadTime'])*pow(1.10,$rounds-1);
		//$obj['rof']=60*($rounds)/($obj['reloadTime'])*pow(1.10,$rounds-1);
		$obj['rof']=60*($rounds)/($rounds*($obj['firePause']+5)+$obj['reloadTime']);
	}
	elseif($obj['firePause']>0){
		#$obj['rof']=10/(($obj['firePause']+5)*($rounds)+$obj['reloadTime']/$rounds);
		$obj['rof']=60/($obj['firePause']+5);
	}
	elseif($obj['time']>0){
		$obj['rof']=60/$obj['time'];
		$range=1;
	}
	else{
		$obj['rof']=6; // 6 because look next line
	}
	$obj['rof']*=10/60; //convert into shots per seconds
	$obj['rof']=$obj['rof']**.85; //First hit bonus.
	//$obj['rangeMod']=pow($range,1+2/($range/7+1));
	//$obj['rangeMod']=pow(($obj['long$calibrateRange']+$obj['shortRange'])/128/2/5,1);
	if($obj['numAttackRuns']){
		#echo $obj['ID'] .'='. $obj['numAttackRuns'];
		//$slotmult*=pow( $obj['numAttackRuns'],.5);
		//$obj['rof']=$obj['numAttackRuns']/($obj['numAttackRuns']*20+(80));
		//$range*=1.5;
	}
	if($range!=0){
		
		//$obj['rangeMod']=($fac-.996**$range**2)/($fac-.996**6**2);
		//DefaultSensor1Mk1
		$sensorrange=1024/128;
		if($sys['nrs']['scaleDist']){
			$sensorrange*=$sys['nrs']['scaleDist'];
		}
		
		if($range>$sensorrange){
			$range=($range-$sensorrange)*.666+$sensorrange; //sensor range wall...
			//echo 'sensorrange:'. $sensorrange;
		}
		//$obj['rangeMod']=(1-pow(.996,pow($range+3/$sys['nrs']['dmgscale'],2)))/(1-pow(.996,pow(6+3/$sys['nrs']['dmgscale'],2)));
		$obj['rangeMod']=(1-pow(.997,pow($range+6/$sys['nrs']['dmgscale'],2)))/(1-pow(.997,pow(6+6/$sys['nrs']['dmgscale'],2)));
	}
	else{
		$obj['rangeMod']=1;
	}
	if($obj['surfaceToAir']<1){ }
	elseif($obj['surfaceToAir']<50){ $obj['miscMod']*=pow(1/6*3/4,.5); }
	else{ $obj['miscMod']*=pow((1+1/6)*3/4,.5); }
	$obj['miscMod']*=$obj['penetrate']*0.5+1;
	$obj['miscMod2']=-($obj['fireOnMove']=="NO")*.4+1;
	#$obj['HPmod']=($obj['hitpoints']*$bodyval+$boost['hitpoints'])/($basehp=250)*4;
	$hp2=$obj['hitpoints'];
	if($type=='body'){
		$hp2=$obj['hitpoints']*311/135; //propulsion account
		$obj2['buildPower']*=1.75;
		$obj2['buildPoints']*=1.75;
		$obj2['weight']*=4;
	}
	if($obj['Weapon slots']){
		$slotmult=$obj['Weapon slots'];
	}
	else{
		$slotmult=1;
	}
	$delta=$sys['wz']['mean'][$type]['buildPower']/$sys['wz']['eval']['currency']/($obj2['buildPower']+.01);
	$delta=pow($delta,.5);
	//$delta=min($delta,2);
	if($sys['wz']['mean'][$type]!=''){
		foreach($boost as $nom => $val){
			if($nom=='buildPower' or $nom=='buildPoints'){
				//$boost[$nom]/=$delta/$slotmult; #2020 not sure about those 2
			}
			else{
				//$boost[$nom]/=pow(Fwz_fig($delta),.4)/$slotmult;
			}
		}
	}
	$slotmult=1;
	//$weapval*=450/2800; //damage equilibrium
	//print_r($obj);
	//print_r($obj);
	$obj['propHP']=$hp2/($hp2+$boost['hitpoints']);
	$obj['HPmod']=($hp2+$boost['hitpoints'])*$obj['bodyval'];
	$meddmg=30*pow($expect,2); //both upgrade and turret
	$medHp=($sys['wz']['mean']['body']['hitpoints']*311/135+$sys['wz']['mean']['weapons']['hitpoints'])*pow($expect,2);
	$obj['armDmg']=$meddmg;
	$obj['armAprox']=min($meddmg-.1,($obj['armourKinetic']*4+$obj['armourHeat']*3+$obj['AFRH'])/4);
	$obj['armMod']=$meddmg/($meddmg-$obj['armAprox']);
	$obj['armMod']=min(3,$obj['armMod']);
	//$obj['evalStr'].='m:'. $meddmg .'/'. ($obj['AFRK']*2+$obj['AFRH'])/3;
	if($obj['weight']!=''){
		$obj['weightMod']=pow(7000/($obj2['weight']+$boost['weight']),.3);
	}else{
		$obj['weightMod']=1;
	}
	if($obj['powerOutput']>0){
		$obj['weightMod']*=pow(($obj['powerOutput']/15000),.3);
		if($obj['weightMod']>0.94){ $obj['weightMod']=0.94; } //appear to be the max?
	}
	$obj['crystalMod']=1;
	if(isset($obj['spinAngle']) and $obj['spinAngle']<60){
		$obj['crystalMod']=.7071;	
	}


	//$data['structureweapons'][$nolist]['w1'];
	//$obj['Prevalue']=($obj['tdmg']*$obj['rof']*$obj['rangeMod']*$obj['miscMod']+$boost['weap'])*$weapval;
	$nolist=$data['structureweapons']['k']['ID'][ $obj['ID'] ];
	
	$xw=0;
	while($xw++<4){
		$idWeap=$data['structureweapons'][$nolist]['w'. $xw];
		if($idWeap!=''){
			$noWeap=$data['weapons']['k']['ID'][ $idWeap ];
			$weap=$data['weapons'][$noWeap];
			$boost['weap']+=$weap['Prevalue'];
			$obj['haveweap']=1;
			$fun=Fwz_getFunct($data,$res,'Weapon Upgrade',$weap['weaponSubClass']);
			$weapval=$fun['weapval'];
			//echo $obj['ID'] .'=='. $nolist .' '. $idWeap .' '. $noWeap.' '. $weap['Prevalue'].'<br/>';
		}
	
	}
	//$obj['Prevalue']=($obj['tdmg']*$obj['rof']*$obj['rangeMod']*$obj['miscMod']+$boost['weap']);
	$obj['Prevalue']=($obj['tdmg']*$obj['rof']*$obj['rangeMod']*$obj['miscMod']);
	//This is the value I use for NRS All those parameters are set above.
	
	$obj['FunctionVal']=($obj['Prevalue']*$obj['miscMod2']*$weapval+$obj['miscBonus']) *$slotmult;
	$obj['FunctionVal']+=$sys['wz']['mean']['weapons']['weap']/4; //being----------------------------------
	$propDmg=1-$obj['FunctionVal']*$obj['modMod']*$sys['wz']['eval']['msSynch']/1000/$medHp*3/4;
	$obj['FunctionVal']/=max(.1,$propDmg);
	//echo $obj['ID'] .'=='. $sno .' '. $obj['Sensor key'] .' '. $data['sensor'][$sno]['Prevalue'] .'<br/>';
	#OLD
	//$obj['Prevalue2']=(($obj['Prevalue']*$obj['miscMod2'])+$obj['HPmod']*$obj['armMod']+$obj['miscBonus'])*$slotmult;
	#NEW
	//prop account
	if($obj['type']=='Propellor'){
		$obj['HPmod']/=1.5;
	}
	if($obj['type']=='Lift'){
		$obj['HPmod']*=1.5;
	}
	if($obj['type']=='Hover'){
		$obj['HPmod']*=1.25;
	}
	$obj['HPfin']=$obj['HPmod']*$obj['armMod']*$obj['crystalMod'];
	$obj['Prevalue2']=$obj['FunctionVal']*$obj['HPfin'];
	$obj['priceMod']=pow(Fwz_fig(150/((($obj2['buildPower']+.001)+$boost['buildPower'])*$sys['wz']['eval']['currency'])),1);
	//echo $obj['ID'] .' price:'. (($obj2['buildPower']+$boost['buildPower'])*$sys['wz']['eval']['currency']);
	$obj['prodMod']=pow(Fwz_fig(600/($obj2['buildPoints']+$boost['buildPoints']+.0001)),.1);
	//$obj['value']=$obj['Prevalue2']*pow(600/($obj['buildPoints']+$boost['buildPoints']),.2)*200/($obj['buildPower']*$sys['wz']['eval']['currency']+$boost['buildPower'])*$obj['weightMod']*$calibrate;
	//$obj['value']=$obj['Prevalue2']*$calibrate;
	$obj['value']=$obj['Prevalue2']*$obj['priceMod']*$obj['prodMod']*$obj['weightMod']*$obj['modMod']*$calibrate;
	if($obj['value']==0 and $obj['no']==0){
		$obj['value']=-1;
	}
	$obj['prodProfile']=$obj['buildPoints']/($obj['buildPower']+0.001);
	$obj['hpProfile']=$obj['hitpoints']/($obj['buildPower']+.00001);
	$obj['timing']=$obj['value']/pow($expect,4);
	//$obj['timing']=$obj['value']/pow($expect,4);

	$obj['evalStr']='('. floor($obj['kdmg']);
	$obj['evalStr'].='+'. floor($obj['sdmg']);
	$obj['evalStr'].='+'. floor($obj['fdmg']);
	$obj['evalStr'].='+'. floor($obj['edmg']);
	$obj['evalStr'].=')='. floor($obj['tdmg']);
	$obj['evalStr'].='×'. floor(1000*$obj['rof'])/1000;
	$obj['evalStr'].='×◎'. floor($obj['rangeMod']*1000)/1000;
	$obj['evalStr'].='×<u>'. floor(10*$obj['miscMod'])/10 .'</u>';
	$obj['evalStr'].='×'. floor(10*$weapval)/10;
	//$obj['evalStr'].='*?'. floor(100*$propDmg)/100;
	//$obj['evalStr'].='--'. floor(100*$delta)/100;
	$obj['evalStr'].='=><i>'. floor(10*$obj['Prevalue'])/10;
	$obj['evalStr'].='=><u>'. floor(10*$obj['FunctionVal'])/10 .'';
	$obj['evalStr'].='*'. floor($obj['HPmod']*10)/10 .'</u>';
	$obj['evalStr'].='*C'. floor($obj['crystalMod']*10)/10 .' A:'. $obj['spinAngle'] .'</u>';
	$obj['evalStr'].='</i>×'. floor($hp2*10)/10;
	//$obj['evalStr'].='</i>*'. floor($bodyval*10)/10;
	$obj['evalStr'].='×'. floor($obj['bodyval']*100)/100;
	//$obj['evalStr'].='*('. floor($bodyval*100)/100 .'-'. $hp2 .' '. $obj['hitpoints'] .' '. $boost['hitpoints'] .')';
	$obj['evalStr'].='×'. floor($obj['armMod']*100)/100;
	$obj['evalStr'].='('. floor($expect*100)/100 .')';
	$obj['evalStr'].='=><i>'. floor(10*$obj['Prevalue2'])/10 .'</i>';
	if($obj['res']>0 or $type=='weapons'){
		$sys['eval']['sumtest']+=$obj['Prevalue']/$expect/$weapval;
		//$sys['eval']['sumtest']+=$obj['Prevalue']/$expect;
		$sys['eval']['sumtestCount']++;
		//$sys['eval']['sumtest2']+=$hp2/$expect/$bodyval*$obj['armMod'];
		$sys['eval']['sumtest2']+=$hp2/$expect/$obj['bodyval']*$obj['armMod'];
	}
	$obj['evalStr'].='×'. floor($obj['priceMod']*100)/100;
	$obj['evalStr'].='$×'. floor($obj['prodMod']*100)/100;
	$obj['evalStr'].='@×'. floor($obj['weightMod']*100)/100;
	$obj['evalStr'].='&#8594;×\''. floor($obj['modMod']*100)/100;
	//$obj['evalStr'].='***'. $calibrate;
	if($type=='propulsion'){ Fwz_propulsionSwitch($obj,-1); }
	//echo $obj['evalStr'] .'<br/>';
	/*
				$rounds=max(1,$d[22]);
				$reload=(($d[20]+5)*($rounds)+$d[23])/$rounds;
				$tdmg=($sdmg+$fdmg+$dmg+$empdmg);
				if($d[29]){
					#$tdmg+=15/5; //burn damage
				}
				X $HPboost=$d[7]/65*4;
				$resu=$tdmg;
				$resu*=$range;
				$resu*=100/$reload;
				if($d[49]==0){ //ground
				}
				elseif($d[49]<50){
					$resu*=.3;	//air
					echo 'AA';
				}
				else{
					$resu*=1.3; //versatile
				}5
				$resu*=$d[52]*.7+1; //penetrate
				$resu*=$typeval[$d[37]]+1;
				$resu*=($d[35]=='NO')*-.2+1;
	*/
	//return $obj['value'];
}

function FWz_adaptor(&$obj,$scale,$modPow=0,$adjust=0){
	global $sys;
	echo '[b]'. $obj['name'] .'[/b] ('. $obj['ID'] .')* [b]'. floor($scale*100)  .'%[/b]</br>';
	if($obj['maxSpeed']){
		$prevHp=$obj['HP'];
		Fwz_propulsionSwitch($obj,1);
		$obj['HP']*=$scale;
		
		$obj['change']=$scale;
		Fwz_propulsionSwitch($obj,-1);
		$obj['HP']=floor($obj['HP']);
		echo 'HP:'. $prevHp .'=>'. $obj['HP'] .'<br/>';
		$obj['HP']=max($obj['HP'],1);
		return true;
	}
	else{
		$price=1/Fwz_fig($obj['priceMod'],-1)*150/$sys['wz']['eval']['currency'];
		$prod=1/Fwz_fig(pow($obj['prodMod'],1/.1),-1)*600;
		$pprice=$price/$obj['buildPower'];
		$pprod=$prod/$obj['buildPoints'];
		$price1=$price-$obj['buildPower'];
		$prod1=$prod-$obj['buildPoints'];
		$exprice=$obj['buildPower'];	
		$exprod=$obj['buildPoints'];
		//Fwz_mult($obj['buildPower'],pow(1/$scale,(1+$modPow)/2)); //apply half the change here
		//Fwz_mult($obj['buildPoints'],pow(1/$scale,(1+$modPow)/2),1);
		$scale2=pow(1/$scale,(1+$modPow)/2);
		$obj['buildPower']=ceil($obj['buildPower']*$scale2);
		$obj['buildPoints']=ceil($obj['buildPoints']*$scale2);
		//if($obj['buildPower']<0){ $obj['buildPower']=0; }
		//if($obj['buildPoints']<0){ $obj['buildPoints']=0; }
		$price1+=$obj['buildPower'];
		$prod1+=$obj['buildPoints'];
		//$mod=Fwz_fig(150/($price1*$sys['wz']['eval']['currency']),1);
		//$mod2=pow(Fwz_fig(600/$prod1,1),.1);
		//$mod=Fwz_fig(150/($price1*$sys['wz']['eval']['currency']),1);
		//$mod2=pow(Fwz_fig(600/$prod1,1),.1);
		$mod=Fwz_fig(150/($obj['buildPower']*$pprice*$sys['wz']['eval']['currency']),1);
		$mod2=pow(Fwz_fig(600/$obj['buildPower']*$pprod,1),.1);
		$varia=$obj['priceMod']/$mod;
		$varia2=$obj['prodMod']/$mod2;
		$obj['priceMod']=$mod;
		$obj['prodMod']=$mod2;
		$obj['priceMod']*=$scale2;
		$obj['prodMod']*=$scale2;
		//$obj['priceMod']*=pow(1/$scale,1+$modPow/2);
		//$remain=$scale*pow($varia,1.2);
		$remain=$scale*pow($varia,1)*$varia2;
		$remain=$scale*pow($scale2,1);
		if($adjust>0){
			$remain=($varia2*$varia);
			$remain=$scale2;
		}
		
		//echo 'price/'. floor($scale*100) .'% '. floor($price/$price1*$obj['buildPower']) .'$ => '. $obj['buildPower'] .'<br/>';
		echo 'price: '. $exprice .'$ => '. $obj['buildPower'] .'$<br/>';
		//echo 'prod:'. floor($prod/$prod1*$obj['buildPoints']) .'$ => '. $obj['buildPoints'] .'  remain:'. 	floor($remain*100) .'%<br/>';
		echo 'prod:'. $exprod .' => '. $obj['buildPoints'] .'<br/>';
		//echo 'prod:'. $price .'$ => '. $price1 .'$ ('. $obj['buildPower'] .') remain:'. $remain .'('. $mod .','. $mod2 .')<br/>';
		//echo 'prod:'. $prod .'$ => '. $prod1 .'$ ('. $obj['buildPoints'] .') remain:'. $remain .'('. $mod .','. $mod2 .')<br/>';
	}
	

	$prop=1;
	$obj['change']=$scale;
	$obj['aimed']=$obj['value']*$scale;
	if($obj['damage'] or $obj['constructPoints'] or $obj['repairPoints']){
		$prop++;
	}
	if($obj['armAprox']){
		$prevArmMod=$obj['armMod'];
		$meddmg=$obj['armDmg'];
		$exarm=$obj['armAprox'];
		$scaleArm=pow($remain+.02,1/($prop+1)/3);
		$armMod2=$obj['armMod']*$scaleArm;
		$a2=max(5,$obj['armDmg']-$obj['armDmg']/$armMod2);
		$varia=$a2/$obj['armAprox'];
		Fwz_mult($obj['AFRK'],$varia);
		Fwz_mult($obj['AFRH'],$varia);
		Fwz_mult($obj['armour'],$varia);
		//am=d/(d-a);am=d*1/(d-a);am/d=1/(d-a);d/am=d-a;d-d/am=a;
		$obj['armAprox']=min($meddmg-.1,($obj['Armour']*3+$obj['AFRK']*2+$obj['AFRH'])/3);
		$obj['armMod']=$meddmg/($meddmg-$obj['armAprox']);
		$remain*=$prevArmMod/$obj['armMod'];
		//echo 'armour*'. floor($scaleArm*100) .'%  '. $exarm .'=>'. $a2 .'  remain:'. floor($remain*100) .'<br/>';
		echo 'armour '. $exarm .'=>'. floor($a2) .'<br/>';
		$dmg=$obj['armMod'];
	}
	$scaleHp=pow($remain,1/$prop);
	$prevHp=$obj['HP'];
	//echo 'floor(max('. $obj['HP'] .'+'. $obj['HP'] .'/'. $obj['propHP'] .'*'. ($scaleHp-1) .','. $obj['HP']/3 .'));<br/>';
	$obj['HP']=floor(max($obj['HP']+$obj['HP']/$obj['propHP']*($scaleHp-1),$obj['HP']/3));
	//$v=h+h/p*(s-1); = h*(1+1/p*(s-1); v/h=1+1/p*(s-1); v/h-1=1/p*(s-1); (v/h-1)*p=s-1; ^^
	$scaleHp=($obj['HP']/$prevHp-1)*$obj['propHP']+1;
	//$scaleHp=$obj['HP']*$obj['propHP']/$prevHp*$obj['propHP'];
	$remain/=$scaleHp;
	//echo 'HP*'. floor($scaleHp*100) .' '. $prevHp .'=>'. $obj['HP'] .'%  remain:'. floor($remain*100)  .'<br/>';
	echo 'HP:'. $prevHp .'=>'. $obj['HP'] .' <br/>';
	$prevDmg=$obj['damage'];
	if($obj['damage']){
		$scaleWeap=pow($remain,1);
		if($obj['weaponSubClass']=='ELECTRONIC'){ //no armor in electronic weapon
			$obj['damage']=max(1,floor(($obj['damage'])*$scaleWeap));
			$obj['splash damage']=max(1,floor(($obj['splash damage'])*$scaleWeap));
			$obj['incenDamage']=max(1,floor(($obj['incenDamage'])*$scaleWeap));
		}
		else{
			$obj['damage']=max(0,floor(($obj['damage']-10)*$scaleWeap+10));
			$obj['splash damage']=max(0,floor(($obj['splash damage']-10)*$scaleWeap+10));
			$obj['incenDamage']=max(0,floor(($obj['incenDamage']-10)*$scaleWeap+10));
		}
		
		$remain/=$scaleWeap;
		//echo 'DMG*'. floor($scaleWeap*100) . '% '. $prevDmg .'=>'. $obj['damage'] .' remain:'. floor($remain*100) .'<br/>';
		echo 'DMG '. $prevDmg .'=>'. $obj['damage'] .'<br/>';
	}
	if($obj['constructPoints']){
		$scaleWeap=pow($remain,1);
		echo 'constructPoints '. $obj['constructPoints'] .'*'. $scaleWeap .'=>';
		$obj['constructPoints']=max(0,floor($obj['constructPoints']*$scaleWeap));
		echo $obj['constructPoints'] .'<br/>';
	}
	if($obj['repairPoints']){
		$scaleWeap=pow($remain,1);
		echo 'repairPoints '. $obj['repairPoints'] .'*'. $scaleWeap .'=>';
		$obj['repairPoints']=max(0,floor($obj['repairPoints']*$scaleWeap));
		echo $obj['repairPoints'] .'<br/>';
	}
	
}
function Fwz_mult(&$data,$var,$max=0){

	$data=max($max,floor($data*$var));
	
}
function Fwz_evalSet(&$data,$type){
	global $sys;
	global $data;
	$e=$sys['wz']['eval'][$type];
	$d=$data[$type];
	$group=$type;
	if($e['group']!=''){
		$group=$e['group'];
	}
	$noBase=$d['k'][ $sys['wz']['file'][$group]['key'][0] ][ $e['base'] ];
	//print_r($data[$type][$noBase]);
	Fwz_eval($data[$type][$noBase],$type);
	$value=$data[$type][$noBase]['value'];
	echo 'nobase='. $noBase .'=='. $value .' -- '. $sys['wz']['file'][$type]['key'][0] . '---'.  $e['base'] .'<br/>';
	unset($sys['eval']['sumtest']);
	unset($sys['eval']['sumtest2']);
	unset($sys['eval']['sumtestCount']);

	$x=0;
	while($x++<$data[$type]['n']){
		Fwz_eval($data[$type][$x-1],$type,$e['baseValue']/$value);
	}
	echo '<br/>'. $type .'sumtest:'. ($sys['eval']['sumtest']/$sys['eval']['sumtestCount']);
	echo '<br/>'. $type .'sumtest2:'. ($sys['eval']['sumtest2']/$sys['eval']['sumtestCount']);
}
function Fwz_armor($dmg,$arm=10){
	return max($dmg/3,$dmg-$arm);
}
function Fwz_showall($data,$type){
	global $sys;
	$e=$sys['wz']['show'][$type];
	$d=$data[$type];
	$which[0]=explode(',',$e['pre'] );
	$which[1]=explode(',',$e['str'] );
	$which[2]=explode(',',$e['post'] );
	echo 'n:'. $d['n'] ;
	echo '<table class="alternance">';
	foreach($which[0] as $no => $val){
		echo $which[0][$no] . $which[1][$no];
	}
	
	$x=0;
	while($x++<$d['n']){
		Fwz_show($d[$x-1],$which,$x);
	}
	echo '</table>';
}
function Fwz_show($data,$which,$count=NULL){
	foreach($which[0] as $no => $val){
		unset($no2);
		unset($no3);
		if($no==0){
			$no2=$data['no'];
			$no3=$count .':';
		}
		if($data[$which[1][$no]]!=0 and gettype($data[$which[1][$no]])!='string'){
			echo $which[0][$no] . floor($data[$which[1][$no]]*100)/100;
		}
		else{
			echo $which[0][$no] . $no3 . $no2 .' '. $data[$which[1][$no]];
		}
	}
	//echo $data['Weapon ID'];
}
function Fwz_cmp_value($a, $b){	return $a["value"]*1>$b["value"]*1;}
function Fwz_cmp_res($a, $b){	return $a["res"]*1>$b["res"]*1;}
function Fwz_cmp_change($a, $b){	return $a["change"]*1>$b["change"]*1;}
function Fwz_cmp_emer($a, $b){	return $a["emer"]*1<$b["emer"]*1;}
function Fwz_cmp_prodProfile($a, $b){	return $a["prodProfile"]*1<$b["prodProfile"]*1;}
function Fwz_cmp_time($a, $b){	return $a["time"]*1<$b["time"]*1;}
function Fwz_cmp_timing($a, $b){	return $a["timing"]*1<$b["timing"]*1;}
function Fwz_sort(&$data,$what,$id="value"){
	$c=$data[$what]['c'];
	$data['weapons'][0]['res']=-1;
	$data['structures'][0]['res']=-1;
	$data['body'][0]['res']=-1;
	unset($data[$what]['k']);
	unset($data[$what]['n']);
	unset($data[$what]['c']);
	usort($data[$what],"Fwz_cmp_". $id);
	$data[$what]['c']=$c;
	Fwz_mkKey($data,$what);
}
function Fwz_getFunct($data,$restime,$type,$stype=NULL){
	$xf=0;
	$f=$data['functions'];
	while($xf++<$f['n']){
		//echo '##'. $xf .' - '. $f[$xf]['type'] .' =='. $type .'<br/>';;
		if($type==$f[$xf]['type']){
			if($stype==NULL or $f[$xf]['v1']==$stype){
				//echo '--'. $f[$xf]['ID'] .' '. $type .' '. $f[$xf]['res'] .' '. $restime .'</br>';;
				if($restime>=$f[$xf]['res'] and $f[$xf]['res']>0){
					//echo '--'. $f[$xf]['ID'] .' '. $f[$xf]['res'] .' '. $restime .' '. $type .' '. $stype .'</br>';
					$xv=0;
					while($xv++<10){
						$nv='v'. $xv;
						$ret[$nv]=max($ret[$nv],$f[$xf][$nv]);
					}
				}
			}
		}
	}
//firePause, shortHit, longHit, damage,	radiusDamage, incenDamage, radiusHit;
	$ret['weapval']=100/(100-$ret['v2'])*(($ret['v3']+$ret['v4'])/2+60)/60*(100+max($ret['v5'],$ret['v6'],$ret['v7']))/100*(100+$ret['v8'])/100;
	//$ret['bodyval']=pow(1+$ret['v1']/100,.25)*($ret['v2']+$ret['v3']+$ret['v4']+300)/300;
	$ret['bodyval']=($ret['v2']+$ret['v3']+$ret['v4']+300)/300;
	$ret['structval']=($ret['v1']+$ret['v2']+200)/200*pow(1+$ret['v3']/100,.1);
	$ret['engineval']=1+$ret['v1']/100;
	if($type=='VehicleBody Upgrade'){
		//print_r($ret);	
	}
	return $ret;
	
}
function Fwz_resTime($data){
	global $sys;
	$matrix[ ++$matrix['n'] ]['nom']='R-Sys-Sensor-Turret01';
	$matrix[ $matrix['n'] ]['preq']=100;
	$matrix['k']['nom']['R-Sys-Sensor-Turret01']=$matrix['n'];
	$matrix[ ++$matrix['n'] ]['nom']='R-Wpn-MG1Mk1';
	$matrix[ $matrix['n'] ]['preq']=100;
	$matrix['k']['nom']['R-Wpn-MG1Mk1']=$matrix['n'];
	$matrix[ ++$matrix['n'] ]['nom']='R-Sys-Engineering01';
	$matrix[ $matrix['n'] ]['preq']=100;
	$matrix['k']['nom']['R-Sys-Engineering01']=$matrix['n'];
	//$matrix[ ++$matrix['n'] ]['nom']='R-Tech-level-1';
	//$matrix[ $matrix['n'] ]['preq']=100;
	//$matrix['k']['nom']['R-Tech-lvl-l']=$matrix['n'];
	/*
	cleanRes[0]	RESEARCHSTAT	"R-Sys-Sensor-Turret01"
	cleanRes[1]	RESEARCHSTAT	"R-Wpn-MG1Mk1"
	//cleanRes[2]	RESEARCHSTAT	"R-Struc-Factory-Cyborg"
	cleanRes[2]	RESEARCHSTAT	"R-Sys-Engineering01"
	*/
	$x=0;
	while($x++<30){
		$x2=0;
		while($x2++< $matrix['n'] ){
			$temp=$matrix[$x2];
			if(!$temp['done']){
				$rno=$data['research']['k']['ID'][ $temp['nom'] ];
				$r=$data['research'][$rno];
				if( $temp['preq']*1 >= $r['Prereqs'] ){
					$temp['get']=$temp['see']+$r['ResearchPoints'];
					$temp['tot']+=$r['ResearchPoints'];
					//echo 'no '. $rno .' '. $temp['nom'] .' '. $temp['preq'] .'/'. $r['Prereqs'] .' '. $temp['get'] .'('. $temp['tot'] .')<br/>';
					$prreq=$data['prresearch']['k']['require'][$temp['nom']];
					//print_r($prreq);
					$x3=0;
					while($x3++<$prreq['n']){
						$p=$prreq[$x3];
						//echo '--'. $data['prresearch'][$p]['this'] .'<br/>';
						$nom=$data['prresearch'][$p]['this'];
						$mno=$matrix['k']['nom'][ $nom ];
						if($mno==''){
							$matrix[ ++$matrix['n'] ]['nom']=$nom;
							$matrix['k']['nom'][$nom]=$matrix['n'];
							$mno=$matrix['n'];
						}
						$matrix[ $mno ]['preq']++;
						if($matrix[ $mno ]['see']<$temp['get']){
							$matrix[ $mno ]['see']=$temp['get'];
							$matrix[ $mno ]['from']=$temp['nom'];
						}
						$matrix[ $mno ]['tot']+=$temp['tot'];
					}
					$temp['done']=1;
					/*
					$func=$data['researchfunctions']['k']['ID'][$temp['nom']];
					$x3=0;
					while($x3++<$func['n']){
						$f=$func[$x3];
						$nom=$data['researchfunctions'][$f]['function'];
						$fno=$data['functions']['k']['name'][$nom];
						$f2=$data['functions'][$fno];
						echo '---'. $nom .' '. $fno .' '. $f2['type'].'<br/>';
						if($f2['type']=='Research Upgrade'){
						}
					}
					*/
					$matrix[$x2]=$temp;
				}
			}
		}
	}
	$t['rpoint']=4200;
	$mod=(12+14)/14;
	//$mod=1;
	$t['val']=$mod*1.3;
	$res[++$res['n']]=$t;
	$x=0;
	while($x++<$data['functions']['n']){
		$f=$data['functions'][$x];
		if($f['type']=='Research Upgrade'){
			$fno=$data['researchfunctions']['k']['function'][$f['name']];
			$mno=$matrix['k']['nom'][$data['researchfunctions'][$fno]['ID']];
			$m=$matrix[$mno];
			$t['rpoint']=$m['get'];
			$t['rpoint2']=$m['get']+12*30;
			$t['rpoint3']=$m['get']+12*60;
			$t['val']=(1+$f['v1']/100)*$mod;
			$res[++$res['n']]=$t;
			//echo $f['name'] . $fno .' ='. $m['get'] .' '. $f['v1'] .' '. $t['val'] .'<br/>';
		}
	}
	
	$t['rpoint']=10000000000000;
	$res[++$res['n']]=$t;
	$baseres=14;
	$x=0;
	while($x++<$matrix['n']){
		$m=$matrix[$x];
		$m['time2']=$m['time'];
		$m['time3']=$m['time'];
		$get=$m['get'];
		$get2=$m['get'];
		$get3=$m['get'];
		$x2=0;
		//echo $m['nom'];
		$lval=$baseres*1.3;
		while($get>=0 and $x2<15){
			$r=$res[++$x2];
			//echo '-'. $x2 .'--'.  $r['rpoint'] .'['. $lval .']';
			$get-=$r['rpoint'];
			$get2-=$r['rpoint2'];
			$get3-=$r['rpoint3'];
			if($get<0){	$r['rpoint']+=$get;	}
			if($get2<0){	$r['rpoint2']+=$get2;	}
			if($get3<0){	$r['rpoint3']+=$get3;	}
			$timeI=$r['rpoint']/$lval;
			$timeI2=$r['rpoint2']/$lval;
			$timeI3=$r['rpoint3']/$lval;
			$lval=($r['val'])*$baseres;
			$m['time']+=$timeI;
			$m['time2']+=$timeI2;
			$m['time3']+=$timeI3;
		}
		$matrix[$x]=$m;
		//echo '===='. $m['time2'] .'<br/>';
	}
	$big=$matrix;
	unset($temp);
	$x1=0;
	while($x1<$big['n']){
		$x2=$x1;
		$min=1000000000;
		while($x2<$big['n']){	
			if($big[$x2]['get']<$min){
				$min=$big[$x2]['get'];
				$minno=$x2;
			}
			$x2++;
		}
		$temp=$big[$x1];
		$big[$x1]=$big[$minno];
		$big[$minno]=$temp;
		$t[ $big[$x1]['name']]=$x1;
		$x1++;
	}
	$x=0;
	while($x++<$big['n']){
		$m=$big[$x];
		$per=floor($m['tot']/$m['get']*100);
		//$m['time']+=$per/100*30;
		$m['time']+=30;
		$m['time2']+=$per/100*30;
		$m['time3']+=$per/100*30;
		$min=floor($m['time']/60);
		$s=floor($m['time']-$min*60);
		$min2=floor($m['time2']/60);
		$s2=floor($m['time2']-$min2*60);
		$x2=0;
		$str='';
		$next=$m['from'];
		while($next!='' and $x2++<30){
			$str=$next .'=>'. $str ;
			$mno=$matrix['k']['nom'][$next];
			$use[ $next ] ++;
			$next=$matrix[$mno]['from'];
		}
	
		if($s<10){ $s='0'. $s; }
		$nores=$data['research']['k']['ID'][$m['nom']];
		$data['research'][$nores]['value']=$m['get'];
		$data['research'][$nores]['time']=$min .':'. $s;
		$data['research'][$nores]['path']=$str;
		//$nores2=$data['research']['k']['ID'][$m['from']];
		//$data['research'][$nores]['resresult']++;;
		$listRes=$data['resultcomponent']['k']['ID'][$m['nom']];
		$xr=0;
		while($xr++<$listRes['n']){
			$r=$data['resultcomponent'][$listRes[$xr]];
			$type=$sys['wz']['rescomp'][$r['type']];
			$nocomp=$data[$type]['k']['ID'][ $r['result ID'] ];
			//echo $type .':'. $r['result ID'] .':'. $nocomp .'</br>';
			$data[$type][$nocomp]['res']=$m['get'];
			$data[$type][$nocomp]['research']=$m['nom'];
			$data[$type][$nocomp]['path']=$str;
			$listTemp=$data['templates']['k']['BODY'][$r['result ID']];
			$xr2=0;
			while($xr2++<$listTemp['n']){
				$t=$data['templates'][ $listTemp[$xr2] ];
				#echo 'template:'. $m['nom'] .' '. $r['result ID'] .' '. $t['ID'] .'<br/>';
				#print_r($t);
				if($t['Type']=='CYBORG' or $t['Type']=='CYBORG_SUPER'){
					$noAss=$data['assignweapons']['k']['ID'][ $t['ID'] ];
					$ass=$data['assignweapons'][$noAss];
					$noWeap=$data['weapons']['k']['ID'][ $ass['w1'] ];
					//echo 'template:'. $m['nom'] .' '. $r['result ID'] .' ='. $t['ID'] .' '. $noAss.$ass['w1'] . ' '. $data['weapons'][$noWeap]['buildPower'] .'<br/>';
					$data['weapons'][$noWeap]['res']=$m['get'];
					$data['weapons'][$noWeap]['research']=$m['nom'];
					$data['weapons'][$noWeap]['path']=$str;
					//print_r($ass);
				}
			}
		}
		$listRes=$data['researchfunctions']['k']['ID'][$m['nom']];
		$xr=0;
		while($xr++<$listRes['n']){
			$r=$data['researchfunctions'][$listRes[$xr]];
			$type='functions';
			//$type=$sys['wz']['rescomp'][$r['type']];
			//echo $m['nom'] .'===='. $r['function'];
			$nocomp=$data[$type]['k']['ID'][ $r['function'] ];
			//echo $type .':'. $r['function'] .':'. $nocomp;
			$data[$type][$nocomp]['res']=$m['get'];
			$data[$type][$nocomp]['research']=$m['nom'];
			$data[$type][$nocomp]['path']=$str;
		}	
		$listRes=$data['resultstructure']['k']['ID'][$m['nom']];
		$xr=0;
		while($xr++<$listRes['n']){
			$r=$data['resultstructure'][$listRes[$xr]];
			$type='structures';
			//$type=$sys['wz']['rescomp'][$r['type']];
			//echo $m['nom'] .'===='. $r['structure'] .'<br/>';
			$nocomp=$data[$type]['k']['ID'][ $r['structure'] ];
			//echo $type .':'. $r['function'] .':'. $nocomp;
			$data[$type][$nocomp]['res']=$m['get'];
			$data[$type][$nocomp]['research']=$m['nom'];
			$data[$type][$nocomp]['path']=$str;
		}
		//print_r($listRes);
		#echo $m['nom'] .'('. $nores .') ['. $min .':'. $s .'] '. $m['tot']/32 .'$ ('. $per .'%) '. $m['get'] .'<br/>';
		//echo '<small><small>'. $str .'</small></small><br/>';
	}
	//$data['research'][1]['value']=-1;
	//Fwz_sort($data,'research');
	//print_r($matrix);

}
function Fwz_fig($fig,$sign=1){
	//return ((pow($fig,2)+$fig)/2)/$fig;
	if($sign>0){
		//return pow($fig*($fig+1)/2,.5);
		//return $fig*($fig+1)/2
		return (pow($fig,1.825)+$fig)/2;
	}
	else{
		//$fig/=2;
		return 1/2*(pow(8*$fig+1,.5)-1);
	}
}
function Fwz_expect($restime,$type=''){
	global $sys;
	//$expect=1+$restime/5000;
	if($type=='weapons'){
		$scale=5000;
	}
	else{
		$scale=5000;
	}
	$expect=pow(	
			//pow(1+$restime/95000,1/.5)
			pow(1+$restime/$scale,1)
			//pow(1+$restime/3800,1/.8)
		,1/4);
	//$expect=1;
	if($sys['wz']['eval']['skipexpect']){
		$expect=2.5;
	}
	//$expect=pow(1.1,$restime/4000);
	//$expect=pow(1.05,pow($restime/1000,1.05)); //fleau
	return $expect;
}
function Fwz_Fleau($restime,$inv=False){
	global $sys;
	//$p1=1.167; //standard prog
	$p1=1.15;
	$p1=$sys['nrs']['wepmod'];
	$p2=1.02; //spec
	//$scale=230; //truck time ... must = 1.167 bcoz figure count of defender & 30% wep mod (x^2+x)-0.3/x-1=0
	$scale=$sys['wz']['fleauscale'];
	if($inv){
		#$expect=log($restime)/log($p1); //fleau
		#$expect=pow($expect,1/$p2)*$scale;
		$expect=($restime1-1)/($p1-1)*$scale;
	}
	else{
		#$expect=pow($p1,pow($restime/$scale,$p2)); //fleau
		$expect=1+($p1-1)*$restime/$scale; //fleau
	}
	return $expect;
}
function Fwz_FleauTRUE($restime,$inv=False){
	global $sys;
	//$p1=1.167; //standard prog
	$p1=1.15;
	$p1=$sys['nrs']['wepmod'];
	$p2=1.02; //spec
	//$scale=230; //truck time ... must = 1.167 bcoz figure count of defender & 30% wep mod (x^2+x)-0.3/x-1=0
	$scale=$sys['wz']['fleauscale'];
	if($inv){
		$expect=log($restime)/log($p1); //fleau
		$expect=pow($expect,1/$p2)*$scale;
	}
	else{
		$expect=pow($p1,pow($restime/$scale,$p2)); //fleau
	}
	return $expect;
}
function valToRof($val){
	return floor(100-1/$val*100);
}
function addPr(&$data,$this2,$require){
	$data[ $data['n']*1 ]['this']=$this2;
	$data[ $data['n']*1 ]['require']=$require;
	$data[ $data['n']*1 ]['num']=$data['n']*1;
	++$data['n'];
}
function fixResearch(&$data){
	global $sys;
	$data['research']['c']=1;
	$xr=0;
	while($xr++<$data['research']['n']){
		$r=$data['research'][$xr-1];
		$data['research'][$xr-1]['Prereqs']=$data['prresearch']['k']['this'][ $r['ID'] ]['n']*1;
		$data['research'][$xr-1]['Redundant components']=$data['redcomponents']['k']['res'][ $r['ID'] ]['n']*1;	
		$data['research'][$xr-1]['Structure results']=$data['resultstructure']['k']['ID'][ $r['ID'] ]['n']*1;
		$data['research'][$xr-1]['Structure prereqs']=$data['researchstruct']['k']['ID'][ $r['ID'] ]['n']*1;
		$data['research'][$xr-1]['Function results']=$data['researchfunctions']['k']['ID'][ $r['ID'] ]['n']*1;
		$data['research'][$xr-1]['Component results']=$data['resultcomponent']['k']['ID'][ $r['ID'] ]['n']*1;
	}
	//recount the prresearch and such and repair the research data
	
}
function Fwz_style(){
	echo '<style>
table.alternance tr:nth-child(odd){
  background-color:#D0D0D0;
</style>';
}
function Fwz_template($data,$weapid,$bodyid,$propid,$weapid2=NULL){
	$weap=$data['weapons'][$weapid];
	if($weapid2!=NULL){
		$weap2=$data['weapons'][$weapid2];
	}
	$body=$data['body'][$bodyid];
	$prop=$data['propulsion'][$propid];
	Fwz_propulsionSwitch($prop,1,$body);
//print_r($weap2);
	$obj=array_merge($body,$prop);
	$obj=array_merge($obj,$weap);
	$obj['HP']=$weap['HP']+$weap2['HP']+$prop['HP'];
	$obj['weight']=$weap['weight']+$weap2['weight']+$prop['weight'];
	$obj['buildPower']=$weap['buildPower']+$weap2['buildPower']+$prop['buildPower'];
	$obj['buildPoints']=$weap['buildPoints']+$weap2['buildPoints']+$prop['buildPoints'];
	$obj['name']=$weap['name'] .' '. $body['name'] .' on '. $prop['name'];
	$obj['res']=max($weap['res'],$body['res'],$prop['res']);
	if($obj['res']==$weap['res']){	$obj['path']=$weap['path'];	}
	if($obj['res']==$body['res']){	$obj['path']=$body['path'];	}
	if($obj['res']==$prop['res']){	$obj['path']=$prop['path'];	}
//print_r($obj);
	return $obj;
}
function Fwz_template2($data,$weapid,$bodyid,$propid,$weapid2=NULL){
	$weap=$data['weapons'][$weapid];
	if($weapid2!=NULL){
		$weap2=$data['weapons'][$weapid2];
	}
	$body=$data['body'][$bodyid];
	$prop=$data['propulsion'][$propid];
	Fwz_propulsionSwitch($prop,1,$body);
	$prop['hitpoints']=$prop['hitpointPctOfBody']*(1+$body['hitpoints']/100);
//print_r($weap2);
	$obj=array_merge($body,$prop);
	$obj=array_merge($obj,$weap);
	$obj['hitpoints']=$weap['hitpoints']+$weap2['hitpoints']+$prop['hitpoints'];
	$obj['weight']=$weap['weight']+$weap2['weight']+$prop['weight'];
	$obj['buildPower']=$weap['buildPower']+$weap2['buildPower']+$prop['buildPower'];
	$obj['buildPoints']=$weap['buildPoints']+$weap2['buildPoints']+$prop['buildPoints'];
	$obj['name']=$weap['name'] .' '. $body['name'] .' on '. $prop['name'];
	$obj['res']=max($weap['res'],$body['res'],$prop['res']);
	if($obj['res']==$weap['res']){	$obj['path']=$weap['path'];	}
	if($obj['res']==$body['res']){	$obj['path']=$body['path'];	}
	if($obj['res']==$prop['res']){	$obj['path']=$prop['path'];	}
	//print_r($obj);
	return $obj;
}
function Fwz_get($set,$by,$name){ //shortcut for non-saving datas
	$no=$set['k'][$by][$name];
	return $set[$no];
}
function Fwz_add(&$data,$file,$what){
	global $sys;
	$s=$sys['wz']['file'][$file];
	$data[$file]['c']=1;
	$no=(++$data[$file]['n'])-1;
	$data[$file][ $no ]=$what;
	$key=$s['key'];
	$key2=$s['key2'];
	//echo $file;
	if(isset($key)){
		foreach($key as $no2 => $nom){
			$data[$file]['k'][$nom][ $data[$file][$no][$nom] ]=$no;
		}
	}
	if(isset($key2)){
		foreach($key2 as $no2 => $nom){
			$data[$file]['k'][$nom][ $data[$file][ $no ][$nom] ][ ++$data[$file]['k'][$nom][ $data[$file][ $no ][$nom] ]['n'] ]=$no;
		}
	}
	$data[$file][$no]['no']=$no;
	return $data[$file][$no];
}
function Fwz_set(&$data,$file,$id,$what,$val){
	$no=$data[$file]['k']['ID'][$id];
	if(!$no){
		$no=$data[$file]['k']['ID'][$id];
		if(!$no){
			echo '<b>can\'t find "'. $id .'"</b>';
			//print_r($data[$file]['k']);
		}
	}
	$data[$file][$no][$what]=$val;
	echo 'set'. $file .' '. $no .' '. $what .'='. $val;
}
function Fwz_add_name(&$data,$from,$was,$what){
	$name=Fwz_get($from['names'],'ID',$was);
	$name['ID']=$what['ID'];
	$ret=Fwz_add($data,'names',$name);
	return $ret;
}
function Fwz_checkname(&$data,$id,$name){
	print_r($data['names']['K']['ID']);
	if(!$data['names']['k']['ID'][$id]){
		echo 'add !'. $id .'='. $name .' '. $data['names']['K']['ID'][$id] .'<br/>';
		$t['type']='official';
		$t['ID']=$id;
		$t['name']=$name;
		Fwz_add($data,'names',$t);
	}
}
function Fwz_pieSweap(&$data,$from,$type,&$comp,$sufix,$save,$load,$prefix='',$prefix2=''){
	global $sys;
	foreach($comp as $id => $val){
		print_r($val);
		if(is_array($val)){
			if($id=='propulsionExtraModels' && $sufix!='-ntw'){
				Fwz_pieSweap($data,$from,$type,$comp[$id],$sufix,$save,$load,$prefix,$prefix2);
			}

		}
		else{
				
			//echo 'val:'. $val;
			$exp=explode('.',$val);
			if(strtolower($exp[1])=='pie' or strtolower($exp[1])=='ogg'){
				
				$piename=strtolower($val);
				$folders=explode(',','components/prop,components/weapons,components/bodies,effects,structs,audio/sfx/weapons');
				foreach($folders as $no => $val){
					$filename='/'. $val .'/'. $piename;
					echo '--'. $load.$filename.'<br/>';
					if(file_exists($load.$filename)){
						$folder=$val;
						echo '??'. $filename.'<br/>';
						break;
					}
				}
				if($folder=='structs'){
					if(file_exists($save.$filename)){
						unset($filename);
					}
				}
				//$filename='/'.$sys['wz']['pie'][$file] .'/'. strtolower($val);
				//echo '='. $filename .'</br>';;
				if(file_exists($load.$filename) and isset($filename)){
					$data['piestats']['c']=1;
					//echo 'OMGPMG';
					$nname=$prefix. strtolower($exp[0]) . $sufix.'.'. strtolower($exp[1]);

					$thatpie=@file($load.$filename);
					if(strtolower($exp[1])=='pie'){
						$exp=explode('.png',$thatpie[2]);
						$exp2=explode(' ',$exp[0]);
						$countexp=count($exp2);
						$found=0;
						$name=$exp2[$countexp-1] .'.png';
						$texnewname=$exp2[$countexp-1] . $sufix .'.png';
						if($name=='page-111-laboratories.png' or $name=='page-10-labratories.png'){
							$name='page-10-laboratories.png'; //should be an array or somehting...
							$fix=1;
						}
						if ($handle = opendir($load .'/texpages')) {
							while (false !== ($file = readdir($handle))) {
								if( strpos($file,$name)!==FALSE){
									//echo "<b>file tex: $nname $name =$file\n</b>";
									$found=1;
									$name=$file;
								}
								else{
									//echo "file tex: $nname $name .' '. $file\n";
								}
							}				
						closedir($handle);
						}
						if(!$found){
							echo 'NOT FOUND! png('. $load .'/texpages/'. $name .')';
						}
						else{
							$thatpie[2]=str_replace($name, $texnewname, $thatpie[2]); 
							//echo '<br>'. $comp[$id] .' '. $sufix .' '. $load .'/texpages/'. $name . ' to '. $save .'/texpages/'. $nname .' ?';
							//echo print_r($thatpie);
							copy($load .'/texpages/'. $name,$save .'/texpages/'.$texnewname);
						}
						foreach($exp2 as $no=> $val){
							if($no==$countexp-1){
								$finalline.=$name;
							}
							else{
								$finalline.=$val .' ';
							}
						}
						$finalline.=$exp[1];
						if($fix){
							$thatpie[2]=$finalline; //effective line 
						}
						
						//event...
						$exp=explode('.pie',$thatpie[3]);
						echo '<br>pie3:'. $thatpie[3];
						if(count($exp)>1){
							echo 'there is a pie on line 3';
							$exp2=explode(' ',$exp[0]);
							$countexp=count($exp2);
							$found=0;
							$name=$exp2[$countexp-1] .'.pie';
							$texnewname=$exp2[$countexp-1] . $sufix .'.pie';
							if ($handle = opendir($load .'/components/bodies')) {
								while (false !== ($file = readdir($handle))) {
									if( strpos($file,$name)!==FALSE){
										echo "<b>file event: $nname $name =$file\n</b>";
										$found=1;
										$name=$file;
									}
									else{
										echo "file event: $nname $name .' '. $file\n";
									}
								}				
							closedir($handle);
							}
							if(!$found){
								echo 'NOT FOUND! pie('. $load .'/components/bodies/'. $name .')';
							}
							else{
								$thatpie[3]=str_replace($name, $texnewname, $thatpie[3]); 
								echo '<br>'. $comp[$id] .' '. $sufix .' '. $load .'/components/bodies/'. $name . ' to '. $save .'/components/bodies/'. $texnewname .' ?';
								//echo print_r($thatpie);
								copy($load .'/components/bodies/'. $name,$save .'/components/bodies/'.$texnewname);
							}
						}
						
						//echo $exp2[$countexp-1] .' ||'. $finalline .'</br>';
						$data['piestats'][]='directory	"'. $folder .'"
	';
						$data['piestats'][]='file		IMD	"'.  strtolower($nname) .'"
	';
					}
					file_put_contents($save.'/'. $folder .'/'. $nname ,$thatpie);
					$comp[$id]=$nname;
					//echo 'omg '. $exp[1] .' '. $id .'='. $val .' nname:'. $nname;
					//echo 'file		IMD	"'.  strtolower($nname) .'"
	//';
				}
			}
			if(strtolower($exp[1])=='ogg' and 1){
				$nname=$prefix. strtolower($exp[0]) . $sufix.'.'. strtolower($exp[1]);
				echo 'omg ogg:'. $val .' '.$comp['id'] .' ('. $type .')'. $nname;
				//print_r($data[$type]);
				//$comp2=Fwz_get($data['weaponsounds'],'ID',$comp['ID']);
				$sound=$data[$type][$comp['id']][$id];
				if($sound==''){
					$sound="smlcan.ogg";
				}
				$comp[$id]=$sound;
				//echo '==>'. $comp2['ID'];
				//$comp[$id]=$comp2[$id];
			}
		}
	}
}
function Fwz_import_comp(&$data,$from,$file,$name,$sufix,$save,$load,$prefix='',$prefix2=''){
	global $sys;
	$comp=Fwz_get($from[$file],'ID',$name);
	if(!$comp){
		$comp=Fwz_get($from[$file],'name',$name);
	}
	echo 'import '. $file .' '. $name .'<br/>';
	Fwz_pieSweap($data,$from,$file,$comp,$sufix,$save,$load);
	$was=$comp['ID'];
	$comp['ID']=$prefix2.$comp['ID'] .$sufix;
$comp['buildPower']=ceil($comp['buildPower']/$sys['wz']['eval']['currency']);
	Fwz_add_name($data,$from,$was,$comp);
	Fwz_add($data,$file,$comp);
	if($file=='body'){
		$li=$from['bodypropulsionimd']['k']['body'][$was];
		//echo '<br>'. $was .':';
		$xi=0;
		while($xi++<$li['n']){
			$i=$from['bodypropulsionimd'][ $li[$xi] ];
			$i['body']=$comp['ID'];
			Fwz_pieSweap($data,$from,'propulsion',$i,$sufix,$save,$load,$prefix,$prefix2);
			Fwz_add($data,'bodypropulsionimd',$i);
		}
		$lt=$from['templates']['k']['BODY'][$name];
		$xt=0;
		while($xt++<$lt['n']){
			$t=$from['templates'][$lt[$xt]];
			if($t['Type']=='CYBORG'){
				$t['mpID']=800+$sys['import']['templatecount']++;
				$ass=Fwz_get($from['assignweapons'],'ID',$t['ID']);
				$ass['ID']=$prefix2. $ass['ID'] .$sufix;
				if(!$data['weapons']['k']['ID'][$prefix2.$ass['w1'].$sufix]){
					Fwz_import_comp($data,$from,'weapons',$ass['w1'],$sufix,$save,$load,$prefix,$prefix2);
				}
				$ass['w1']=$prefix2. $ass['w1'].$sufix;
				Fwz_add($data,'assignweapons',$ass);
				$was=$t['ID'];
				$t['ID']=$prefix2. $t['ID'] .$sufix;
				Fwz_add_name($data,$from,$was,$t);
				$t['BODY']=$comp['ID'];
				Fwz_add($data,'templates',$t);
				//echo 'BORGS!';
			}
			
		}
		//print_r($lt);
	}
	if($file=='weapons'){
		$sound=Fwz_get($from['weaponsounds'],'ID',$was);
		Fwz_pieSweap($data,$from,'weaponsounds',$sound,$sufix,$save,$load,$prefix,$prefix2);
		$sound['ID']=$prefix2. $sound['ID'] .$sufix;
		Fwz_add($data,'weaponsounds',$sound);
		//echo '<br>------------'. $was .':';
		$a=$from['structureweapons']['k']['w1'][$was];
		$xa=0;
		while($xa++<$a['n']){
			$no=$from['structureweapons'][ $a[$xa] ]['ID'];
			$ax=Fwz_get($from['structures'],'ID',$no);
			//print_r($ax);
			Fwz_import_comp($data,$from,'structures',$ax['ID'],$sufix,$save,$load,$prefix,$prefix2);
		}
		//$assign=Fwz_get($from['structureweapons'],'w1',$was);
		
		//print_r($sound);	
	}
	if($file=='structures'){
		$assign=Fwz_get($from['structureweapons'],'ID',$was);
		//Fwz_pieSweap($data,$from,'structure',$comp,$sufix,$save,$load,$prefix,$prefix2);
		if($assign['ID']!=''){
			//Fwz_pieSweap($data,$from,'structureweapons',$sound,$sufix,$save,$load);
			$assign['w1']=$prefix2.$assign['w1'] .$sufix;
			$assign['ID']=$prefix2.$assign['ID'] .$sufix;
			Fwz_add($data,'structureweapons',$assign);
			//echo '<br>------------'. $was .':';
			//print_r($assign);	
		}
		echo 'foiund function'. $was;
		$func=Fwz_get($data['structurefunctions'],'ID',$was);
		//print_r($func);
		if($func['func']!=''){
			echo 'shit '. $was ;
			$funct=$func;
			$funct['ID']=$prefix2.$func['ID'] .$sufix;
			$funct['func']=$prefix2.$func['func'] .$sufix;
			Fwz_add($data,'structurefunctions',$funct);
			$func2=Fwz_get($from['functions'],'ID',$func['func']);
			$func2['ID']=$prefix2.$func2['ID'] .$sufix;
			Fwz_add($data,'functions',$func2);
		}
	}
}
function Fwz_import_res(&$data,$from,$name,$sufix,$save,$load,$prefix='',$prefix2=''){ //import the res and the results
	//prefix2 is only used for the templates name to avoid a bug in the ID (when id is too identical, they mix in multiplay)
	global $sys;
	$res=Fwz_get($from['research'],'ID',$name);
	$res['ID']=$prefix.$name . $sufix;
	if($res['CompName']!='0'){
		$res['CompName']=$prefix2.$res['CompName'].$sufix;
	}

	Fwz_add_name($data,$from,$name,$res);
	Fwz_add($data,'research',$res);
	$data['changelog'][ ++$data['changelog']['n']-1]['str']='importing '. $name .' and all components attached from '. $sufix .'. I\'d like to thanks in this very personnal message the people behind this work.';
	//results...
	$lc=$from['resultcomponent']['k']['ID'][$name];
	$xc=0;
	while($xc++<$lc['n']){
		$rc=$from['resultcomponent'][ $lc[$xc] ];
		//echo $xc .' 00090'. $rc['result ID'] .'<br/>';
		$rc['ID']=$prefix. $rc['ID'] .$sufix;
		$rc['replace']=0;
		$rc['typereplace']=0;
		$type=$sys['wz']['rescomp'][$rc['type']];
		Fwz_import_comp($data,$from,$type,$rc['result ID'],$sufix,$save,$load,$prefix,$prefix2);
		$rc['result ID']=$prefix2.$rc['result ID'].$sufix;
		Fwz_add($data,'resultcomponent',$rc);
	}
	$lc=$from['resultstructure']['k']['ID'][$name];
	
	//print_r($from['resultstructure']['k']['ID']);
	$xc=0;
	while($xc++<$lc['n']){
		$rc=$from['resultstructure'][ $lc[$xc] ];
		echo $xc .' 00090'. $rc['structure'] .'<br/>';
		$rc['ID'].=$sufix;
		Fwz_import_comp($data,$from,'structures',$rc['structure'],$sufix,$save,$load,$prefix,$prefix2);
		$rc['structure'].=$sufix;
		Fwz_add($data,'resultstructure',$rc);
	}
	
	$lc=$from['researchfunctions']['k']['ID'][$name];
	$xc=0;
	while($xc++<$lc['n']){
		$rc=$from['researchfunctions'][ $lc[$xc] ];
		$func=Fwz_get($from['functions'],'ID',$rc['function']);
		//echo $xc .'<br/>';
		$rc['ID']=$prefix. $rc['ID'] .$sufix;
		//Fwz_import_comp($data,$from,'functions',$rc['function'],$sufix,$save,$load);
		$rc['function']=$prefix. $rc['function'] .$sufix;
		$func['ID']=$rc['function'];
		Fwz_add($data,'researchfunctions',$rc);
		Fwz_add($data,'functions',$func);
	}
	
	//print_r($res);
}
function Fwz_weapResGen(&$data,$type,$dmgName,$rofName,$CompName){
	$typef=ereg_replace(' ','-',$type);
	while($x++<5){
		$res=Fwz_get($data['research'],'ID','R-Wpn-Cannon-ROF01');
		$res['ID']='R-Wpn-'. $typef .'-ROF0'. $x;
		$res['CompName']=$CompName;
		Fwz_add($data,'research',$res);
		$res['name']=$rofName .' Mk'. $x;
		$res['type']='official';
		Fwz_add($data,'names',$res);
		$fun=Fwz_get($data['functions'],'ID','Wpn-Cannon-ROF01');
		$fun['v1']=$type;
		$fun['ID']='Wpn-'. $typef .'-ROF0'. $x;
		Fwz_add($data,'functions',$fun);
		$resno=$data['researchfunctions']['k']['ID']['R-Wpn-Cannon-ROF01'][1];
		$t=$data['researchfunctions'][$resno];
		$t['ID']=$res['ID'];
		$t['function']=$fun['ID'];
		Fwz_add($data,'researchfunctions',$t);
	}
	$x=0;
	while($x++<9){
		$res=Fwz_get($data['research'],'ID','R-Wpn-Cannon-Damage01');
		$res['ID']='R-Wpn-'. $typef .'-Damage0'. $x;
		$res['CompName']=$CompName;
		Fwz_add($data,'research',$res);
		$res['name']=$dmgName .' Mk'. $x;
		$res['type']='official';
		Fwz_add($data,'names',$res);
		$fun=Fwz_get($data['functions'],'ID','Wpn-Cannon-Damage01');
		$fun['v1']=$type;
		$fun['ID']='Wpn-'. $typef .'-Damage0'. $x;
		Fwz_add($data,'functions',$fun);
		$resno=$data['researchfunctions']['k']['ID']['R-Wpn-Cannon-Damage01'][1];
		$t=$data['researchfunctions'][$resno];
		$t['ID']=$res['ID'];
		$t['function']=$fun['ID'];
		Fwz_add($data,'researchfunctions',$t);
	}
}
function Fwz_sensorResGen(&$data,$upgName){
	$x=3;
	while($x++<6){
		$res=Fwz_get($data['research'],'ID','R-Sys-Sensor-Upgrade01');
		$res['ID']='R-Sys-Sensor-Upgrade0'. $x;
		Fwz_add($data,'research',$res);
		$res['name']=$upgName .' Mk'. $x;
		$res['type']='official';
		Fwz_add($data,'names',$res);
		$fun=Fwz_get($data['functions'],'ID','Sys-Sensor-Upgrade01');
		$fun['ID']='Sys-Sensor-Upgrade0'. $x;
		Fwz_add($data,'functions',$fun);
		$resno=$data['researchfunctions']['k']['ID']['R-Sys-Sensor-Upgrade01'][1];
		$t=$data['researchfunctions'][$resno];
		$t['ID']=$res['ID'];
		$t['function']=$fun['ID'];
		Fwz_add($data,'researchfunctions',$t);
	}
}
function Fwz_emptyFuncFix(&$data){ //add a fake function at the end
	$fun=Fwz_get($data['functions'],'ID','Sys-Sensor-Upgrade01');
	$fun['ID']='Sys-Sensor-Upgrade99';
	Fwz_add($data,'functions',$fun);
}
function Fwz_genVlo(&$data){
	$base=$data['player0.vlo'];
	$x=0;
	while($x++<8){
		$no=$x-1;
		$name="player$no.vlo";
		//echo 'gen vlo:'. $name;
		$data[$name]=$base;
		$data[$name]['c']=1;
		$data[$name]['me']=$no;
		//print_r($data[$name]);
	}
}
function Fwz_evalboost($mean1,$mean2){
	foreach($mean1 as $nom =>$val){
		$boost[$nom]=($val+$mean2[$nom])/$mean2[$nom];
	}
	return $boost;
}
function Fwz_setFuncVal(&$f,$value){
	if(strpos($f['ID'],'ROF')!==False){
		$valfunc=valToRof($value);
	}
	elseif(strpos($f['ID'],'Research')!==False or strpos($f['ID'],'Factory')!==False  or strpos($f['ID'],'Engineering')!==False ){
		$valfunc=floor(Fwz_fig($value,1)*100)-100;
	}
	else{
		$valfunc=floor($value*100)-100;
	}
	
	$xv=0;
	while($xv++<10){
		if($f['v'. $xv]!=''){
			if($f['v'. $xv]*1==$f['v'. $xv] and $f['v'. $xv]!=1 and $f['v'. $xv]!=0){
				$f['v'. $xv]=$valfunc;
				//echo 'xv'. $xv; 
			}
		}
	}
}
//By grok3
// Helper function to scale and round coordinates
function scale_coordinates($line, $scale) {
    // Split the line into coordinates, removing extra whitespace
    $coords = preg_split('/\s+/', trim($line));
    // Check if the line has exactly 3 coordinates (x, y, z)
    if (count($coords) == 3) {
        $x = floatval($coords[0]) * $scale['x']; // Scale X coordinate
		//$x = floatval(sign($coords[0])*abs($coords[0])**(1+$coords[2]/200)) * $scale; // Scale X coordinate
        $y = floatval($coords[1]) * $scale['y']; // Scale Y coordinate
        $z = floatval($coords[2]) * $scale['z']; // Scale Z coordinate
        // Format to 2 decimal places and return as a string
        return sprintf("%.2f %.2f %.2f", $x, $y, $z);
    } else {
        // If not 3 coordinates, return the line unchanged
        return $line;
    }
}

// Main function to scale the PIE model
function scale_pie_model($pie_string, $scale) {
    // Split the input string into lines
    $lines = explode("\n", $pie_string);
    $output_lines = array();
    $points_to_scale = 0;      // Counter for points
    $connectors_to_scale = 0;  // Counter for connectors

    foreach ($lines as $line) {
        // Check if this line defines a POINTS section
        if (preg_match('/^POINTS\s+(\d+)/', $line, $matches)) {
            $points_to_scale = intval($matches[1]);
            $output_lines[] = $line; // Keep the POINTS line unchanged
        }
        // Check if this line defines a CONNECTORS section
        elseif (preg_match('/^CONNECTORS\s+(\d+)/', $line, $matches)) {
            $connectors_to_scale = intval($matches[1]);
            $output_lines[] = $line; // Keep the CONNECTORS line unchanged
        }
        // Process lines that are part of a POINTS section
        elseif ($points_to_scale > 0) {
            $output_lines[] = scale_coordinates($line, $scale);
            $points_to_scale--;
        }
        // Process lines that are part of a CONNECTORS section
        elseif ($connectors_to_scale > 0) {
            $output_lines[] = scale_coordinates($line, $scale);
            $connectors_to_scale--;
        }
        // For all other lines (e.g., LEVEL, POLYGONS, TEXTURE), copy as is
        else {
            $output_lines[] = $line;
        }
    }

    // Join the lines back into a single string
    return implode("\n", $output_lines);
}
// Function to process the PIE file content
function updatePieTexture($pieContent, $suffix = "-2120",$folder) {
    // Split the content into lines
    $lines = explode("\n", $pieContent);
    $updatedLines = [];

    foreach ($lines as $line) {
        // Look for the TEXTURE line
        if (preg_match('/^TEXTURE\s+\d+\s+([^\s]+\.png)\s+(\d+\s+\d+)$/', trim($line), $matches)) {
            // Extract the filename and dimensions
            $filename = $matches[1];
			if($filename=='page-111-laboratories.png' or $filename=='page-10-labratories.png'){
				$filename='page-10-laboratories.png'; //should be an array or somehting...
				$fix=1;
			}
            $dimensions = $matches[2];
            
            // Split filename into name and extension
            $fileParts = pathinfo($filename);
            $newFilename = $fileParts['filename'] . $suffix . '.' . $fileParts['extension'];
            // Reconstruct the TEXTURE line
			if(file_exists($folder.$filename )){
				echo '<br>updatePieTexture found';
				$line = "TEXTURE 0 $newFilename $dimensions";
			}
			else{
				echo '<br>updatePieTexture notfound'. $folder.$filename ;
			}
        }
        // Add the line (modified or not) to the updated array
        $updatedLines[] = $line;
    }

    // Join the lines back together
    return implode("\n", $updatedLines);
}
function Fwz_addcat(&$cat, $string){
	if($cat==''){
		$cat.=$string;
	}
	else{
		$cat.=' & '. $string;
	}
}
/*
function scale_pie_model($pie_string, $scale) {
    // Split the PIE string into an array of lines
    $lines = explode("\n", $pie_string);
    $output_lines = array();
    $points_to_scale = 0;

    // Process each line
    foreach ($lines as $line) {
        // Check if this line defines a POINTS section
        if (preg_match('/^POINTS\s+(\d+)/', $line, $matches)) {
            $points_to_scale = intval($matches[1]);
            $output_lines[] = $line; // Preserve the POINTS line
        }
        // If we’re in a points section, scale the vertex coordinates
        elseif ($points_to_scale > 0) {
            $coords = preg_split('/\s+/', trim($line));
            if (count($coords) == 3) {
                // Scale each coordinate
                $x = floatval($coords[0]) * $scale;
                $y = floatval($coords[1]) * $scale;
                $z = floatval($coords[2]) * $scale;
                // Format with 6 decimal places for consistency
                $scaled_line = sprintf("%.6f %.6f %.6f", $x, $y, $z);
                $output_lines[] = $scaled_line;
            } else {
                // If the line isn’t a valid vertex, copy it as is
                $output_lines[] = $line;
            }
            $points_to_scale--;
        }
        // Copy all other lines unchanged
        else {
            $output_lines[] = $line;
        }
    }

    // Reconstruct the modified PIE file string
    return implode("\n", $output_lines);
}
*/
$sys['wz']['eval']['currency']=1;
$sys['wz']['eval']['skipexpect']=0;
$sys['wz']['eval']['msSynch']=450;

$sys['wz']['load']['modelFolder']='model';

$nom='names';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,name,type');
$sys['wz']['file'][$nom]['pos']='/messages/strings/names.txt';
$sys['wz']['file'][$nom]['key']=array('ID');

$nom='weapons';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,-,buildPower,buildPoints,weight,-,-,HP,GfxFile,MountGfx,muzzleGfx,flightGfx,hitGfx,missGfx,waterGfx,trailGfx,shortRange,longRange,shortHit,longHit,firePause,-,numRounds,reloadTime,damage,splash radius,splash chance,splash damage,incenTime,incenDamage,incenRadius,directLife,radiusLife,flightSpeed,indirectHeight,fireOnMove,weaponClass,weaponSubClass,movement,weaponEffect,rotate,maxElevation,minElevation,facePlayer,faceInFlight,recoilValue,minRange,LightWorld,effectSize,surfaceToAir,numAttackRuns,designable,penetrate');
$sys['wz']['file'][$nom]['pos']='/stats/weapons.txt';
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['file'][$nom]['key2']=array('weaponEffect');
$sys['wz']['eval'][$nom]['base']='MG1Mk1';
$sys['wz']['eval'][$nom]['baseValue']=1;
$sys['wz']['show'][$nom]['pre']='<tr><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td></tr>';
$sys['wz']['show'][$nom]['str']='ID,change,buildPower,buildPoints,weight,HP,shortRange,value,res,prodProfile,hpProfile,evalStr';
$sys['wz']['show'][$nom]['post']='</td>,</td>,</td>,</td>,</td>,</td>,</td></tr>';
/*
$sys['wz']['boost'][$nom]['HP']=315;
//$sys['wz']['boost'][$nom]['HP']=480;
$sys['wz']['boost'][$nom]['buildPower']=150;
$sys['wz']['boost'][$nom]['buildPoints']=600;
$sys['wz']['boost'][$nom]['buildPower']=75;
$sys['wz']['boost'][$nom]['buildPoints']=300;
$sys['wz']['boost'][$nom]['weight']=3000;
*/
/*
$sys['wz']['mean'][$nom]['HP']=150;
$sys['wz']['mean'][$nom]['buildPower']=25;
$sys['wz']['mean'][$nom]['buildPoints']=100;
$sys['wz']['mean'][$nom]['weight']=1000;
$sys['wz']['mean'][$nom]['weap']=20;
*/
$sys['wz']['mean'][$nom]['hitpoints']=200;
$sys['wz']['mean'][$nom]['buildPower']=150;
$sys['wz']['mean'][$nom]['buildPoints']=500;
$sys['wz']['mean'][$nom]['weight']=5000;
$sys['wz']['mean'][$nom]['weap']=10;

$sys['wz']['file']['weapons2']=$sys['wz']['file'][$nom];
$sys['wz']['file']['weapons2']['pos']='/stats/weapons2.txt';

$nom='all';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,emer,change,value');
$sys['wz']['file'][$nom]['pos']='/stats/all.txt';
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['show'][$nom]['pre']='<tr><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td></tr>';
$sys['wz']['show'][$nom]['str']='ID,change,emer,HP,buildPower,buildPoints,weight,prodProfile,hpProfile,value,res,evalStr';
$sys['wz']['show'][$nom]['pre']='<tr><td>,<br/><small>,</small></td><td>,<br/><small><span title=",">,</span>/,/,</small></td><td>,</br><small>, / , / ,</small>
<td>,<br/><small>,</small></td><td><span title=",">,</span></td>
<td>,,/,<br/><small>,</small></td>
<td>,,,, + , <small>(,*,)</small> + , <small>(,)</small></td><td>,/,=,</td><td>,</td></tr>';
$sys['wz']['show'][$nom]['str']='name,ID,change,evalStr,value,timing,aimed,HP,AFRK,AFRH,Armour,buildPower,buildPoints,path,res,shortRange,Range,longRange,rangeMod,damage,range,constructPoints,repairPoints,incenDamage,incenTime,incenRadius,splash,splash radius,Engine power,weight,weightMod,evalStr';
//$sys['wz']['show'][$nom]['pre']='<tr><td>,  HP:, Price:, Armour:, Damages:,</td></tr>';


$nom='weaponmodifier';
$sys['wz']['file'][$nom]['arrName']=explode(',','weapon type,propulsion type,value');
$sys['wz']['file'][$nom]['pos']='/stats/weaponmodifier.txt';
$sys['wz']['file'][$nom]['key2']=array('weapon type','propulsion type');
$sys['wz']['show'][$nom]['pre']='<tr><td>,</td><td>, </td><td>,</td></tr>';
$sys['wz']['show'][$nom]['str']='weapon type,propulsion type,value';

$nom='structuremodifier';
$sys['wz']['file'][$nom]['arrName']=explode(',','weapon type,structure type,value');
$sys['wz']['file'][$nom]['pos']='/stats/structuremodifier.txt';
$sys['wz']['file'][$nom]['key2']=array('weapon type','structure type');
$sys['wz']['show'][$nom]['pre']='<tr><td>,</td><td>, </td><td>,</td></tr>';
$sys['wz']['show'][$nom]['str']='weapon type,structure type,value';

$nom='research';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,-,Left icon,Major tech,Right icon,IMD,-,MsgName,StructName,CompName,CompType,ResearchPoints,keyTopic,Prereqs,Function results,Structure prereqs,Redundant structures,Structure results,Redundant components,Component results');
$sys['wz']['file'][$nom]['pos']='/stats/research/multiplayer/research.txt';
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['show'][$nom]['pre']='<tr><td>,</td><td>, </td><td>, </td><td>,</td></tr><tr><td colspan=3><small>';
$sys['wz']['show'][$nom]['str']='ID,value,ResearchPoints,time,path';
//$sys['wz']['show'][$nom]['post']='</td>,</td>,</td>,</td></tr><tr><td colspan=3><small>,</small></td></tr>';


$nom='prresearch';
$sys['wz']['file'][$nom]['arrName']=explode(',','this,require,num');
$sys['wz']['file'][$nom]['pos']='/stats/research/multiplayer/prresearch.txt';
$sys['wz']['file'][$nom]['key2']=array('this','require');

$nom='resultcomponent';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,result ID,type,replace,typereplace,dunno');
$sys['wz']['file'][$nom]['pos']='/stats/research/multiplayer/resultcomponent.txt';
$sys['wz']['file'][$nom]['key2']=array('ID','result ID');
$sys['wz']['rescomp']['BODY']='body';
$sys['wz']['rescomp']['WEAPON']='weapons';
$sys['wz']['rescomp']['PROPULSION']='propulsion';
$sys['wz']['rescomp']['SENSOR']='sensor';
$sys['wz']['rescomp']['CONSTRUCT']='construction';
$sys['wz']['rescomp']['BRAIN']='brain';
$sys['wz']['rescomp']['REPAIR']='repair';
$sys['wz']['pie']['weapons']='components/weapons';
$sys['wz']['pie']['body']='components/bodies';
$sys['wz']['pie']['propulsion']='components/prop';


$nom='resultstructure';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,structure,dunno,dunno2');
$sys['wz']['file'][$nom]['pos']='/stats/research/multiplayer/resultstructure.txt';
$sys['wz']['file'][$nom]['key']=array('structure');
$sys['wz']['file'][$nom]['key2']=array('ID');

$nom='redcomponents';
$sys['wz']['file'][$nom]['arrName']=explode(',','res,comp,type,dunno');
$sys['wz']['file'][$nom]['pos']='/stats/research/multiplayer/redcomponents.txt';
$sys['wz']['file'][$nom]['key']=array('comp');
$sys['wz']['file'][$nom]['key2']=array('res');

$nom='researchfunctions';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,function,dunno');
$sys['wz']['file'][$nom]['pos']='/stats/research/multiplayer/researchfunctions.txt';
$sys['wz']['file'][$nom]['key']=array('function');
$sys['wz']['file'][$nom]['key2']=array('ID');

$nom='researchstruct';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,structure,dunno');
$sys['wz']['file'][$nom]['pos']='/stats/research/multiplayer/researchstruct.txt';
$sys['wz']['file'][$nom]['key']=array('structure');
$sys['wz']['file'][$nom]['key2']=array('ID');


$nom='functions';
$sys['wz']['file'][$nom]['arrName']=explode(',','type,ID,v1,v2,v3,v4,v5,v6,v7,v8,v9,v10');
$sys['wz']['file'][$nom]['pos']='/stats/functions.txt';
$sys['wz']['file'][$nom]['key']=array('ID');

$sys['wz']['file']['functions2']=$sys['wz']['file'][$nom];
$sys['wz']['file']['functions2']['pos']='/stats/functions2.txt';

$nom='body';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,Unused,Size,buildPower,buildPoints,weight,HP,Body model,Unused,Weapon slots,Engine power,AFRK,AFRH,AREK,AREH,ALEK,ALEH,ARIK,ARIH,ATOK,ATOH,ABOK,ABOH,Flame model,designable');
$sys['wz']['eval'][$nom]['base']='Body1REC';
$sys['wz']['eval'][$nom]['baseValue']=1;
$sys['wz']['file'][$nom]['pos']='/stats/body.txt';
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['show'][$nom]['pre']='<tr><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td></tr>';
$sys['wz']['show'][$nom]['str']='ID,change,HP,buildPower,buildPoints,weight,prodProfile,hpProfile,value,res,evalStr';
$sys['wz']['show'][$nom]['post']='</td>,</td>,</td>,</td>,</td>,</td>,</td></tr>';
/*
$sys['wz']['boost'][$nom]['HP']=90;
$sys['wz']['boost'][$nom]['buildPower']=75;
$sys['wz']['boost'][$nom]['buildPoints']=300;
$sys['wz']['boost'][$nom]['weight']=1000;
$sys['wz']['boost'][$nom]['weap']=334;
*/

//$sys['wz']['mean'][$nom]['HP']=220;
//$sys['wz']['mean'][$nom]['buildPower']=80;
//$sys['wz']['mean'][$nom]['buildPoints']=320;
//$sys['wz']['mean'][$nom]['weight']=2500;

$sys['wz']['mean'][$nom]['HP']=130*2;
$sys['wz']['mean'][$nom]['buildPower']=46*2;
$sys['wz']['mean'][$nom]['buildPoints']=250*2;
$sys['wz']['mean'][$nom]['weight']=2000;
$sys['wz']['boost'][$nom]=$sys['wz']['mean']['weapons'];
$sys['wz']['boost']['weapons']=$sys['wz']['mean']['body'];


$nom='structures';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,Type,wtf!,Strength,Terrain Type,Base Width,Base Breadth,Foundation,buildPoints,Height,Armour,HP,Repair system,buildPower,-,Resistance,-,Size Modifier,ECM key,Sensor key,Weapon Slots,Structure model,Base model,Functions,Weapons');
$sys['wz']['file'][$nom]['pos']='/stats/structures.txt';
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['file'][$nom]['key2']=array('Strength');
$sys['wz']['eval'][$nom]['base']='GuardTower1';
$sys['wz']['eval'][$nom]['baseValue']=1;
$sys['wz']['show'][$nom]['pre']='<tr><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td></tr>';
$sys['wz']['show'][$nom]['str']='ID,change,buildPower,value,res,evalStr';
$sys['wz']['show'][$nom]['post']='</td>,</td>,</td>,</td>,</td>,</td>,</td></tr>';
$sys['wz']['boost'][$nom]['HP']=0;
$sys['wz']['boost'][$nom]['buildPower']=0;
$sys['wz']['boost'][$nom]['buildPoints']=0;
$sys['wz']['boost'][$nom]['weight']=0;


$nom='structureweapons';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,w1,w2,w3,w4,dummy');
$sys['wz']['file'][$nom]['pos']='/stats/structureweapons.txt';
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['file'][$nom]['key2']=array('w1');

$nom='structurefunctions';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,func,dummy');
$sys['wz']['file'][$nom]['pos']='/stats/structurefunctions.txt';
$sys['wz']['file'][$nom]['key']=array('ID','func');




$nom='propulsion';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID, dummy,buildPower,buildPoints,weight, dummyVal,dummyVal,HP,imdName,type,maxSpeed,designable');
$sys['wz']['file'][$nom]['pos']='/stats/propulsion.txt';
$sys['wz']['eval'][$nom]['base']='wheeled01';
$sys['wz']['eval'][$nom]['baseValue']=1;
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['file'][$nom]['key2']=array('type');
$sys['wz']['show'][$nom]['pre']='<tr><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td></tr>';
$sys['wz']['show'][$nom]['str']='ID,change,HP,buildPower,buildPoints,weight,prodProfile,hpProfile,value,res,evalStr';
$sys['wz']['boost'][$nom]=$sys['wz']['boost']['body'];



$sys['wz']['file']['propulsion2']=$sys['wz']['file'][$nom];
$sys['wz']['file']['propulsion2']['pos']='/stats/propulsion2.txt';

$nom='bodypropulsionimd';
$sys['wz']['file'][$nom]['arrName']=explode(',','body,propulsion,pie1,pie2,dunno');
$sys['wz']['file'][$nom]['key2']=array('body','propulsion');
$sys['wz']['file'][$nom]['pos']='/stats/bodypropulsionimd.txt';


$nom='weaponsounds';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,shoot,hit,dunno');
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['file'][$nom]['pos']='/stats/weaponsounds.txt';



$nom='sensor';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID, dummy,buildPower,buildPoints,weight, dummyVal,dummyVal,HP,GfxFile,mountGfx,range,location,type,time,power,designable');
$sys['wz']['file'][$nom]['pos']='/stats/sensor.txt';
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['show'][$nom]['pre']='<tr><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td></tr>';
$sys['wz']['show'][$nom]['str']='ID,change,emer,HP,buildPower,buildPoints,weight,prodProfile,hpProfile,value,res,evalStr';
$sys['wz']['eval'][$nom]['base']='SensorTurret1Mk1';
$sys['wz']['eval'][$nom]['baseValue']=1;
$sys['wz']['boost'][$nom]=$sys['wz']['boost']['weapons'];

$nom='construction';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID, dummy,buildPower,buildPoints,weight, dummyVal,dummyVal,HP,GfxFile,mountGfx,constructPoints,designable');
$sys['wz']['file'][$nom]['pos']='/stats/construction.txt';
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['show'][$nom]['pre']='<tr><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td></tr>';
$sys['wz']['show'][$nom]['str']='ID,change,emer,HP,buildPower,buildPoints,weight,prodProfile,hpProfile,value,res,evalStr';
//$sys['wz']['eval'][$nom]['base']='Spade1Mk1';
$sys['wz']['eval'][$nom]['baseValue']=1;
$sys['wz']['eval'][$nom]['base']='MG1Mk1';
$sys['wz']['eval'][$nom]['group']='weapons';
$sys['wz']['boost'][$nom]=$sys['wz']['boost']['weapons'];

$nom='repair';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID, dummy,buildPower,buildPoints,weight, dummyVal,dummyVal,HP,location,GfxFile,mountGfx,repairPoints,time,designable');
$sys['wz']['file'][$nom]['pos']='/stats/repair.txt';
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['show'][$nom]['pre']='<tr><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td><td>,</td></tr>';
$sys['wz']['show'][$nom]['str']='ID,change,emer,HP,buildPower,buildPoints,weight,prodProfile,hpProfile,value,res,evalStr';
//$sys['wz']['eval'][$nom]['base']='LightRepair1';
$sys['wz']['eval'][$nom]['base']='MG1Mk1';
$sys['wz']['eval'][$nom]['group']='weapons';
$sys['wz']['eval'][$nom]['baseValue']=1;

$sys['wz']['boost'][$nom]=$sys['wz']['boost']['weapons'];



$nom='brain';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID, dummy,buildPower,buildPoints,weight,dummyVal,dummyVal,weapon,progCap');
$sys['wz']['file'][$nom]['pos']='/stats/brain.txt';
$sys['wz']['file'][$nom]['key']=array('ID');


$nom='assignweapons';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,w1,w2,w3');
$sys['wz']['file'][$nom]['pos']='/stats/assignweapons.txt';
$sys['wz']['file'][$nom]['key']=array('ID');

$nom='templates';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,mpID,BODY,BRAIN,CONSTRUCT,ECM,usable,PROPULSION,REPAIRUNIT,type,SENSOR,numWeaps');
$sys['wz']['file'][$nom]['pos']='/stats/templates.txt';
$sys['wz']['file'][$nom]['key']=array('ID');
$sys['wz']['file'][$nom]['key2']=array('BODY');
$sys['wz']['eval'][$nom]['base']='ViperMG01Wheels';
$sys['wz']['eval'][$nom]['baseValue']=1;
$sys['wz']['boost'][$nom]=$sys['wz']['boost']['structures'];

$nom='propulsiontype';
$sys['wz']['file'][$nom]['arrName']=explode(',','ID,flightName,multiplier');
$sys['wz']['file'][$nom]['pos']='/stats/propulsiontype.txt';
$sys['wz']['file'][$nom]['key']=array('PropulsionName');

$nom='changelog';
$sys['wz']['file'][$nom]['arrName']=explode(',','str');
$sys['wz']['file'][$nom]['pos']='/changelog.txt';

$nom='debug';
$sys['wz']['file'][$nom]['arrName']=explode(',','str');
$sys['wz']['file'][$nom]['pos']='/stats/debug.txt';

$nom='piestats';
$sys['wz']['file'][$nom]['pos']='/wrf/piestats.wrf';

$nom='rules';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/rules.slo';
$sys['wz']['file'][$nom]['type']='sfile';

$nom='rules.js';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/rules.js';
$sys['wz']['file'][$nom]['type']='sfile';

$nom='multilim';
$sys['wz']['file'][$nom]['pos']='/multiplay/script/multilim.slo';
$sys['wz']['file'][$nom]['type']='sfile';

$nom='rules.vlo';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/rules.vlo';
$sys['wz']['file'][$nom]['type']='sfile';


$nom='player0.slo';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/player0.slo';
$sys['wz']['file'][$nom]['type']='sfile';

$nom='player0.vlo';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/player0.vlo';
$sys['wz']['file'][$nom]['type']='sfile';

$nom='player0.vlo';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/player0.vlo';
$sys['wz']['file'][$nom]['type']='sfile';
$nom='player1.vlo';
$sys['wz']['file'][$nom]['posload']='/multiplay/skirmish/player0.vlo';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/player1.vlo';
$sys['wz']['file'][$nom]['type']='sfile';
$nom='player2.vlo';
$sys['wz']['file'][$nom]['posload']='/multiplay/skirmish/player0.vlo';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/player2.vlo';
$sys['wz']['file'][$nom]['type']='sfile';
$nom='player3.vlo';
$sys['wz']['file'][$nom]['posload']='/multiplay/skirmish/player0.vlo';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/player3.vlo';
$sys['wz']['file'][$nom]['type']='sfile';
$nom='player4.vlo';
$sys['wz']['file'][$nom]['posload']='/multiplay/skirmish/player0.vlo';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/player4.vlo';
$sys['wz']['file'][$nom]['type']='sfile';
$nom='player5.vlo';
$sys['wz']['file'][$nom]['posload']='/multiplay/skirmish/player0.vlo';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/player5.vlo';
$sys['wz']['file'][$nom]['type']='sfile';
$nom='player6.vlo';
$sys['wz']['file'][$nom]['posload']='/multiplay/skirmish/player0.vlo';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/player6.vlo';
$sys['wz']['file'][$nom]['type']='sfile';
$nom='player7.vlo';
$sys['wz']['file'][$nom]['posload']='/multiplay/skirmish/player0.vlo';
$sys['wz']['file'][$nom]['pos']='/multiplay/skirmish/player7.vlo';
$sys['wz']['file'][$nom]['type']='sfile';

$sys['nrs']['dmgscale']=1; //should be wz but compatibility... this is used in NRS