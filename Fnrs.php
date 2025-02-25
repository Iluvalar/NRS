<?php
function newton($f,$zero,$g=1){ //newton approximation find the zero of function of an arbitrary function.

	$slice=.00000001;
	echo '<br>newton('. $g .' && '. ($f($g)) .'-'. ($f($g-$slice)) .')'. $f($g);
	while($x++<100){
		$dif=($f($g))-($f($g-$slice));
		#echo '<br>('. $g .' && '. ($f($g)) .'-'. ($f($g-$slice)) .')'. $f($g);
		if($dif!=0){
			$g-=($f($g)-$zero)*$slice/( $dif );
		}
		
	}
	echo ' to:('. $g .' && '. ($f($g)) .'-'. ($f($g-$slice)) .')'. $f($g);
	return $g;
}

function Fnrs_genprop( $propname,$fac,$usename,$pts,$type='Wheeled'){ //while x++<1 , now using upgrades...
	global $sys;
	while($x++<1){
		$item=$sys['nrs']['base']['propulsion'][ $propname ];
		$nname=$usename;
		$item['id']=$nname;
		$item['name']=$nname;
		echo $x .' '. $nname;
		if($x!=1){
			$rep=[ $lastname.':'. $nname ];
		}
		$item['hitpointPctOfBody']=(2*$pts)-100;
		$item['type']=$type;
		$sys['nrs']['base']['propulsion'][ $nname ]=$item;
		
		Fnrs_add([ 'faction'=> $fac, 'use'=>$nname, 'in'=>'base','type'=> 'propulsion', 'replacedComponents'=>$rep ,'as' => ['prop','insta','strong','exshort'] ]);
		
		
		$lastname=$nname;
		//print_r($item);
	}
	//Fnrs_add([ 'faction'=> $fac, 'use'=>'Laser3BEAMMk1,Cyb-Wpn-Laser,Laser3BEAM-VTOL', 'in'=>'base','type'=> 'weapons', 'as' => ['hvy','AP','hightech','longrange','weapon'] ]);
}

function Fnrs_add($info){ //First store all the things to add in a neat array that Fnrs_generate will interpret later.
	global $sys;
	//print_r($info['in']);
	$as=$info['as'];
	//$item=$info['in'][ $info['use'] ];
	//print_r($item);
	$weight="med";
	$target="def";
	if (in_array("weapon", $as )) {
		echo 'is weapon';
	}
	if (in_array("AP", $as )) { $target="AP"; }
	if (in_array("AW", $as )) { $target="AW"; }
	if (in_array("AT", $as )) { $target="AT"; }
	if (in_array("AS", $as )) { $target="AS"; }
	if (in_array("AN", $as )) { $target="AN"; }
	if( $info['type']=='body'){ $target.='body';}
	if (in_array("hvy", $as )) { $weight="hvy"; }
	if (in_array("lgt", $as )) { $weight="lgt"; }
	if (in_array("xlgt", $as )) { $weight="xlgt"; }
	if (in_array("LM", $as )) {$weight='LM';}
	if (in_array("MH", $as )) {$weight='MH';}
	
	if (in_array("prop", $as )) { $weight="prop"; }
	if (in_array("Cyb", $as )) { $weight="Cyb"; }
	
	
	$exp=explode(',',$info['use']);
	$info['id']=$exp[0];
	//$item['use']['use']=
	//$item['as']['as']=$info['as'];
	$sys['nrs']['add'][ $info['faction'] ][ $weight ][ $target ][]=$info;
}

function Fnrs_upgradeline($class,$filter,$filtername,$param,$id,$req,$resmult=1,$name='',$sufix=''){ //generate entire lines of upgrade
	//$id=$filtername .'-'. $param .'-'. 1;
	global $sys;
	$x=0;
	$maxx=18;
	while($x++<$maxx){
		unset($r);
		unset($temp);
		$temp['iconID']='IMAGE_RES_COMPUTERTECH';
		if($x==1){
			$temp['iconID']='IMAGE_RES_POWERTECH';
		}
		
		$temp['id']='R-'. $filtername .'-'. $param .'-'. $sufix .'-'. $x;
		if($name==''){
			$name=$temp['id'];
		}
		$temp['name']=$name .' #'. $x;
		$temp['requiredResearch']=[$req];
		$temp['researchPoints']='3000';
		$temp['researchPower']=$sys['nrs']['rpoint']/9;

		$temp['researchPoints']=$sys['nrs']['time']/9*14; //1000 * 6 = 6000
		//$temp['statID']=$id;
		$temp['subgroupIconID']="IMAGE_RES_GRPUPG";
		if($param=='PowerPoints'){
			$temp['imdName']='blpower4.pie';
		}
		elseif($param=='HitPointPct'){
			$temp['imdName']='icmolql.pie';
			
		}
		elseif($param=='HitPoints'){
			$temp['imdName']='blwallh.pie';
			$maxx=36;
			
		}
		elseif($param=='ResearchPoints'){
			$temp['imdName']='blresch4.PIE';
		}
		elseif($param=='ProductionPoints'){
			$temp['imdName']='BLFACT1.PIE';
		}
		elseif($param=='ConstructorPoints'){
			$temp['imdName']='trlcon.pie';
		}
		elseif($param=='Range'){
			$temp['imdName']='GNLSNSR1.PIE';
		}
		elseif($filtername=='CyborgLegs'){
				$temp['statID']='CyborgLightBody';
				$maxx=18;
		}
		elseif($filtername=='BaBaLegs'){
				$temp['statID']='B1BaBaPerson01';
				return True;
		}
		elseif($filter=='Id'){
				$temp['statID']=$filtername;
		}
		else{
			$temp['statID']=$id;
			$temp['subgroupIconID']="IMAGE_RES_GRPDAM";
		}

		$temp['subgroupIconID']="IMAGE_RES_GRPDAM";
		$r['class']=$class;
		if($filter!=''){
			
			$r['filterParameter']=$filter;
			$r['filterValue']=$filtername;
		}
		$r['parameter']=$param;
		//$totexp=100*Fwz_Fleau($sys['nrs']['time']/9*$x*$resmult)-100;
		//$totexp=100*Fwz_Fleau($sys['nrs']['time']/9*$x*$resmult)-100;
		$totexp=100*Fwz_Fleau($temp['researchPower']*$x*$resmult)-100;
		//$r['value']=20;
		//$totexp=20*$x;
		if($param=="FirePause"){
			$totvalue=floor(100*100/($totexp+100))-100;
			//$r['value']=$totvalue-$lastvalue;
			$value=$totvalue-$lastvalue;
			$lastvalue=$totvalue;
			/*
			$r['value']=floor($r['value']);
			$temp['results'][]=$r;
			$r['parameter']='ReloadTime';
			
			$r['value']=floor($r['value']);
			*/
			//$temp['results'][]=$r;
			$subclssesno=array_search($filtername,$sys['nrs']['subclsses']);
			foreach($sys['nrs']['subclsses'] as $no=>$classeName){
				if($classeName!=''){
					
					
					$factor=1;
					
					#if($sys['nrs']['subclssesEffect'][$subclssesno]==$sys['nrs']['subclssesEffect'][$no]){
					#	$factor*=.85;
					#}
					if($sys['nrs']['subclssesWeight'][$subclssesno]==$sys['nrs']['subclssesWeight'][$no]){
						$factor=.2;
						$r['filterValue']=$classeName;
						$r['parameter']='FirePause';
						$r['value']=ceil($value*$factor);
						$temp['results'][]=$r;
						$temp['subgroupIconID']="IMAGE_RES_GRPROF";
						$r['parameter']='ReloadTime';
						$r['value']=ceil($value*$factor);
						$temp['results'][]=$r;
						
					}
					//if($classeName==$filtername){$factor=1;}				
					
					
					echo $classeName .' '. $filtername .' ' . 	$subclssesno ;
				}
			}
			$r['filterParameter']='Effect';
			$r['filterValue']=$sys['nrs']['weaponEffect'][$sys['nrs']['subclssesEffect'][$subclssesno]];
			$factor=.2;
			$r['parameter']='FirePause';
			$r['value']=ceil($value*$factor);
			$temp['results'][]=$r;
			$temp['subgroupIconID']="IMAGE_RES_GRPROF";
			$r['parameter']='ReloadTime';
			$r['value']=ceil($value*$factor);
			$temp['results'][]=$r;
			unset($r['filterParameter']);
			unset($r['filterValue']);
			$factor=.6;
			$r['parameter']='FirePause';
			$r['value']=ceil($value*$factor);
			$temp['results'][]=$r;
			$temp['subgroupIconID']="IMAGE_RES_GRPROF";
			$r['parameter']='ReloadTime';
			$r['value']=ceil($value*$factor);
			$temp['results'][]=$r;
		}
		if($param=="Damage"){
			$totvalue=$totexp;
			$value=$totvalue-$lastvalue;
			$lastvalue=$totvalue;

			$subclssesno=array_search($filtername,$sys['nrs']['subclsses']);
			foreach($sys['nrs']['subclsses'] as $no=>$classeName){
				if($classeName!=''){
									

					if($sys['nrs']['subclssesWeight'][$subclssesno]==$sys['nrs']['subclssesWeight'][$no]){
						$factor=.2;
						$r['filterValue']=$classeName;
						$r['parameter']='Damage';
						$r['value']=ceil($value*$factor);
						$temp['results'][]=$r;
						$temp['subgroupIconID']="IMAGE_RES_GRPROF";
						$r['parameter']='RadiusDamage';
						$r['value']=ceil($value*$factor);
						$temp['results'][]=$r;
						
					}
					//if($classeName==$filtername){$factor=1;}				
					
					
					echo $classeName .' '. $filtername .' ' . 	$subclssesno ;
				}
			}
			$r['filterParameter']='Effect';
			$r['filterValue']=$sys['nrs']['weaponEffect'][$sys['nrs']['subclssesEffect'][$subclssesno]];
			$factor=.2;
			$r['parameter']='Damage';
			$r['value']=ceil($value*$factor);
			$temp['results'][]=$r;
			$temp['subgroupIconID']="IMAGE_RES_GRPROF";
			$r['parameter']='RadiusDamage';
			$r['value']=ceil($value*$factor);
			$temp['results'][]=$r;
			unset($r['filterParameter']);
			unset($r['filterValue']);
			$factor=.6;
			$r['parameter']='Damage';
			$r['value']=ceil($value*$factor);
			$temp['results'][]=$r;
			$temp['subgroupIconID']="IMAGE_RES_GRPROF";
			$r['parameter']='RadiusDamage';
			$r['value']=ceil($value*$factor);
			$temp['results'][]=$r;
		}
		if($param=="Damage2" ){
			$totvalue=$totexp;
			$value=$totvalue-$lastvalue;
			//$r['value']=$totvalue-$lastvalue;
			$lastvalue=$totvalue;
			
			
			foreach($sys['nrs']['subclsses'] as $no=>$classeName){
				if($classeName!=''){
					$factor=1;
					$subclssesno=array_search($filtername,$sys['nrs']['subclsses']);
					if($sys['nrs']['subclssesEffect'][$subclssesno]!=$sys['nrs']['subclssesEffect'][$no]){
						$factor*=.85;
					}
					if($sys['nrs']['subclssesWeight'][$subclssesno]!=$sys['nrs']['subclssesWeight'][$no]){
						$factor*=.85;
					}
					if($classeName==$filtername){$factor=1;}				
					$r['filterValue']=$classeName;
					$r['parameter']='Damage';
					$r['value']=floor($value*$factor);
					$temp['results'][]=$r;
					$r['parameter']='RadiusDamage';
					$r['value']=floor($value*$factor);
					$temp['results'][]=$r;
					echo $classeName .' '. $filtername .' ' . 	$subclssesno ;
				}
			}
		}
		if($param=="buildPower" ){
			$totvalue=$totexp;
			$r['value']=$totvalue-$lastvalue;
			$lastvalue=$totvalue;
			$r['value']=floor($r['value']);
			//$temp['results'][]=$r;
			//$r['parameter']='RadiusDamage';
			$r['value']=floor($r['value']);
			$temp['results'][]=$r;
		}
		if($param=="PowerPoints"){
			$totvalue=$totexp;
			$r['value']=$totvalue-$lastvalue;
			$lastvalue=$totvalue;
			$r['value']=floor($r['value']);
			$temp['results'][]=$r;
		}
		if($param=="HitPoints"){ //walls
			$totvalue=$totexp;
			$r['value']=$totvalue-$lastvalue;
			$lastvalue=$totvalue;
			$r['value']=floor($r['value']);
			$temp['results'][]=$r;
		}
		if($param=="ConstructorPoints" ){ 
			$totvalue=$totexp;
			$totvalue=floor(Fwz_fig(($totexp+100)/100,1)*100)-100;
			$totvalue=pow($totvalue,.5); //both building and healing
			$r['value']=$totvalue-$lastvalue;
			$lastvalue=$totvalue;
			$r['value']=floor($r['value']);
			$temp['results'][]=$r;
		}
		if($param=="Range"){
			$totvalue=$totexp;
			$r['value']=$totvalue-$lastvalue;
			$lastvalue=$totvalue;
			$r['value']=floor($r['value']);
			$temp['results'][]=$r;
		}
		if($param=="ResearchPoints" or $param=="ProductionPoints"){
			//$valfunc=floor(Fwz_fig($value,1)*100)-100;
			$totvalue=$totexp;
			$totvalue=floor(Fwz_fig(($totexp+100)/100,1)*100)-100;
			$r['value']=$totvalue-$lastvalue;
			$lastvalue=$totvalue;
			$r['value']=floor($r['value']);
			$temp['results'][]=$r;
		}
		if($param=="HitPointPct"){
			$totvalue=$totexp;
			$r['value']=$totvalue-$lastvalue;
			$lastvalue=$totvalue;
			$r['value']=floor($r['value']);
			$r['value']=floor($r['value']);
			$temp['results'][]=$r;
			$r['filterValue']='Cyborgs';
			$temp['results'][]=$r;
			$r['filterValue']='PERSON';
			$r['value']=floor($r['value']);
			$temp['results'][]=$r;
		}
		if($param=="HitpointPctOfBody"){
			$statval=$sys['nrs']['file']['stat']['propulsion'][ $temp['statID'] ];
			//print_r($statval);
			$tempval=$statval['hitpointPctOfBody']+100;
			$totvalue=$tempval*(1+$totexp/100)-$tempval;
			
			//$totvalue=$totexp;
			$r['value']=$totvalue-$lastvalue;
			$lastvalue=$totvalue;
			$r['value']=floor($r['value']);
			$temp['results'][]=$r;
		}
		

		$temp['name'].=' '. floor($r['value']) .'%';
		echo '<br>'. $temp['statID'] .' '. $temp['name'] .'wiwiwiw'. $statval['hitpointPctOfBody'] .'t:'. $tempval .' '. $totvalue .' '. $totexp;
		//print_r($temp);
		$sys['nrs']['file']['stat']['research'][$temp['id']]=$temp;
		$req=$temp['id'];
	}
	$sys['nrs']['nb']['temp']='"'. $req .'"';
	
};

function Fnrs_generate(){ //interpret the Fnrs_add array, fetch the component in the appropriate files, evaluate it, balance it and build the tree
	global $sys;
	foreach($sys['nrs']['add'] as $nomfac => $val){
		echo "Faction : ". $nomfac;
		$idfac="R-Fac-". $nomfac;
		unset($temp);
		$temp['id']=$idfac;
		$temp['name']=$nomfac .' Faction';
		$temp['iconID']="IMAGE_RES_SYSTEMTECH";
		$temp['researchPoints']=1;
		$temp['researchPower']=1;
		//$temp['keyTopic']=1;
		$temp['requiredResearch']=[$sys['nrs']['startres']];
		$temp['statID']='Sys-SensoTowerWS';
		$temp['subgroupIconID']='IMAGE_RES_GRPDAM';
		if($nomfac=='start'){
			$sys['nrs']['file']['stat']['research'][$idfac]=$temp;
		}
	
		//print_r($val);
		foreach($val as $class => $val2){			
			foreach($val2 as $target => $val4){
				
				//$lastres=$idfac;
				$lastres=$sys['nrs']['startres'];
				$lastvalue=100;
				$totrespower=0;
				echo '<br/><b>'. $nomfac .'-'. $class .'-'. $target .'</b>';
				unset($subclass);
				foreach($val4 as $no => $val3){
					unset($priceclassR);
					unset($hooman2);
					//print_r($val3);
					if($no==0){
						$linename=$val3['call'];
					}
					unset($temp);
					unset($name);
					$sufix='';
					if( $val3['in'] !=='base'){
						$sufix='-'.  $val3['in'];
					}

					

					
					//$power=pow(1.1,$no);
					$weight='med';
					$resmult=1.1;
					$timefac=1;
					$respowerslice=$sys['nrs']['rpoint']/count($val4);
					$resfrac=1;
					$resstartfrac=1;
					$fake=0; 
					$eco=0;
					if (in_array("exshort", $val3['as'] )) {$timefac/=10; }
					if (in_array("vshort", $val3['as'] )) {$timefac/=3; }
					if (in_array("short", $val3['as'] )) {$timefac/=2; }
					if (in_array("long", $val3['as'] )) {$timefac*=2;}
					//if (in_array("NRSp", $val3['as'] )) {$timefac/=2; }
					
					if (in_array("xlgt", $val3['as'] )) {$weight='xlgt';}
					if (in_array("lgt", $val3['as'] )) {$weight='lgt';}
					if (in_array("hvy", $val3['as'] )) {$weight='hvy';}
					if (in_array("LM", $val3['as'] )) {$weight='LM';}
					if (in_array("MH", $val3['as'] )) {$weight='MH';}
					

					
					$typeW='O';$wepclass='KINETIC';
					if (in_array("typeA", $val3['as'] )) {$typeW='A';}
					if (in_array("typeAE", $val3['as'] )) {$typeW='AE';}
					if (in_array("typeE", $val3['as'] )) {$typeW='E';$wepclass='HEAT';}
					
					$quality=0;
					if (in_array("cheap", $val3['as'] )) {$quality=1;$hooman2.='¥';}
					if (in_array("¥", $val3['as'] )) {$quality=1;$hooman2.='¥';}
					if (in_array("good", $val3['as'] )) {$quality=-1;$hooman2.='$';}
					if (in_array("$", $val3['as'] )) {$quality=-1;$hooman2.='$';}
					if($quality==0){ $hooman2.='₽'; }
					//¥₽$
		
					
					$engineClass=0;
					if (in_array("strong", $val3['as'] )) {$engineClass=1;$hooman2.='H';}
					if (in_array("heavy", $val3['as'] )) {$engineClass=-1;$hooman2.='H';}
					if($engineClass==0){ $hooman2.='N'; }

					if (in_array("insta", $val3['as'] )) {$resstartfrac=0; }
					if (in_array("joke", $val3['as'] )) {$resstartfrac=.1; }
					if (in_array("early", $val3['as'] )) {$resstartfrac=.2; }
					if (in_array("lowtech", $val3['as'] )) {$resstartfrac=.3; }
					if (in_array("midtech", $val3['as'] )) {$resstartfrac=0.7; }
					if (in_array("hitech", $val3['as'] )) {$resstartfrac=1; }
					if (in_array("strong", $val3['as'] )) {$resmult=1.2; }
					if (in_array("weak", $val3['as'] )) {$resmult=0.7; }
					$nrsp=0;
					if (in_array("NRSp", $val3['as'] )) {$resstartfrac=0.25;$nrsp=1;}
					
					if (in_array("fake", $val3['as'] )) {$fake=1; }
					if (in_array("eco", $val3['as'] )) {$eco=1; }
					$type=$val3['type'];
					
					if(!$eco){ $id='R-NRS-'. $val3['id']. $sufix;}
					else{ $id='R-NRS-'. $val3['id'].'-'. $nomfac; }
					
					if($no==0){
						$resfrac=$resstartfrac;
					}
					$resfrac2=$resfrac;
					$respower=$respowerslice*$timefac;
					//$restime=($no+$resstartfrac)*$respowerslice;
					$punish=2+.5;
					if($no==count($val4)-1 && $no!=0){
						if(!$nrsp){			
							$resfrac=((1+.5/$punish)-$resstartfrac)*$punish;
							$resfrac2=2-$resstartfrac;
						}

						//$restime+=$respowerslice*.5;
					}					
					//$totrestime+=$sys['nrs']['time']/count($val4)*($resfrac2)*$resmult*$timefac;
					$totrespower+=$respower*($resfrac2)*$resmult;
					$respower*=$resfrac;
					$power=Fwz_Fleau($totrespower);
					$exp=explode(',',$val3['use']);

					foreach($exp as $nores=>$valres){
						
					}
					echo '<br/>'. $id .'RESFRAC:'. $resfrac .' pow:'. $power .' restot:'. $totrestime .' '. $val3['use'];
					$sufix2=$sufix;
					if($eco){ $sufix2='-eco'; }
					$temp['iconID']="IMAGE_RES_QUESTIONMARK";
					$temp['subgroupIconID']='IMAGE_RES_GRPDAM';
					$no2=0;
					while($no2<count($exp)){
						$sys['nrs']['count'][$val3['type']][$val3['in']]++;
					//foreach($exp as $no2 => $itemname){
						$itemname=$exp[$no2];
						$exp2=explode('-',$itemname);
						$rweight=$weight;
						if($exp2[ count($exp2)-1 ]=='BABA'){
							echo 'baba shit hack!';
							$weight='xlgt';
							$sufix='';
						}

						if( $itemname=='BaBaLegs'){ $val3['type']='propulsion'; }
						if( $itemname=='B1BaBaPerson01-nrs'){ $val3['type']='body'; echo 'BLLLLLLLLLLLLLLA';}
						//if( $itemname=='B1BaBaPerson01-nrs'){ $val3['type']='body'; echo 'BLLLLLLLLLLLLLLA';}

						if($exp2[ count($exp2)-1 ]=='brain'){
							echo 'brain!!!'. $itemname;
							//$braindetect=1;
							$sufix='';
							$type='brain';
							$val3['type']='brain';
							//$item['shortRange']=$item['shortRange']*1.25;
							//$item['longRange']=$item['longRange']*1.25;
						}
						$item=$sys['nrs'][ $val3['in'] ][ $val3['type'] ][ $itemname ];
						echo 'loading sys nrs '. $val3['in'] ." ". $val3['type'] .' '. $itemname;
						print_r($item);
						$braindetect=0;
						if($exp2[ count($exp2)-1 ]=='command'){
							echo 'command!!!';
							$braindetect=1;
							$sufix='';
							$item['designable']=1;
							$item['shortRange']=$item['shortRange']*1.25;
							$item['longRange']=$item['longRange']*1.25;
							$item['mountModel']="TRLCMD1.PIE";
							# "mountModel": "TRLCMD1.PIE",
						}
						
						if($val3['type']=='structure'){
							if($eco){
								$temp['resultStructures'][]=$itemname .'-eco';
							}
							else{
								$temp['resultStructures'][]=$itemname . $sufix;
							}
							if($itemname=="A0PowMod1"){
								echo "power HACK". $power;
								$sys['nrs']['file']['stat']['structure']['A0PowerGenerator']['modulePowerPoints']=$sys['nrs']['file']['stat']['structure']['A0PowerGenerator']['powerPoints']*($power*100-100)/100;
								//$sys['nrs']['file']['stat']['structure']['A0BaBaPowerGenerator']['modulePowerPoints']=$sys['nrs']['file']['stat']['structure']['A0BaBaPowerGenerator']['powerPoints']*($power*100-100)/100;
								//$sys['nrs']['file']['stat']['structure']['A0PowerGenerator']['modulePowerPoints']=($power*100-100);
							}
						}
						else{
							$temp['resultComponents'][]=$itemname . $sufix;
						}
						if (in_array("designable", $val3['as'] )) { 	$item['designable']=1; echo "some designable shit ?"; print_r($item);}
						//print_r($item);
						$item2=$item;
						if($name==''){
							$name=$item['name'];
							
						}
						Fwz_eval34($item2,$val['type']);
						print_r($item2);
						$fig=2;
						$price=$sys['nrs']['unitprice']/3/$fig; //(weapon + body) * 1.5x (wheel) = 3 things.
						$pow=1;
						$nbase=$sys['nrs']['armypower']/($price*3)/pow(2,1/3);
						$figbase=Fwz_fig($nbase);
						//$fig=3.7320;
						//$fig=2.26423;
						$bodyMod=1.10;		
						$weightfact=1;
						$bodhp=1;
						$bodkin=0;
						$bodheat=0;
						$wepmin=1;
						$wepweight=5/12;
						//$wepclass='KINETIC';
						$bodyclass='KINETIC';
						$wephp=0;
						$priceclass=0;
						
						$checkprice=$item['buildPower']*(1-$quality*.2-$engineClass*0.1)/2;
						if($type=='weapons'){
							$wephp=.25+.25*$quality;
							$priceclass=log(($checkprice**.85)/($sys['nrs']['unitprice']/3),2);
						}
						elseif($type=='body'){
							$bodhp=.75+.25*$quality*-1;
							$priceclass=log($checkprice/($sys['nrs']['unitprice']/3),2);
						}

						if (in_array("class0", $val3['as'] )) {$priceclass=-3; } //this will confuse me later lol, meant to match at best the cyborgs
						if (in_array("class1", $val3['as'] )) {$priceclass=-1.5; }
						if (in_array("class3", $val3['as'] )) {$priceclass=0; }
						if (in_array("class5", $val3['as'] )) {$priceclass=1.5; }
						if (in_array("class7", $val3['as'] )) {$priceclass=3; }
						$priceclass=max(-4,$priceclass);
						if(!$priceclassR){
							$priceclassR=floor($priceclass+4).$hooman2; //for research, pick the first item.
							
						}
						$weightfact*=$fig**$priceclass;
						$pow*=$figbase/Fwz_fig($nbase  * $fig**-$priceclass);
						$price=$sys['nrs']['unitprice']/3*2**($priceclass+1)*(1+$quality*.2+$engineClass*0.1);
						#NEED A fix
						//$nbweight='LIGHT';
						//$nbweight2='LIGHT';
						if($priceclass+4<=2){
							$nbweight='ULTRALIGHT';
							$nbweight2='ULTRALIGHT';
						}
						elseif($priceclass+4<=3){
							$nbweight='LIGHT';
							$nbweight2='LIGHT';
							
						}
						elseif($priceclass+4<=4){
							$nbweight='MEDIUM';
							$nbweight2='MEDIUM';
							
						}
						elseif($priceclass+4<=6){
							$nbweight='HEAVY';
							$nbweight2='HEAVY';
							
						}
						else{
							$nbweight='ULTRAHEAVY';
							$nbweight2='ULTRAHEAVY';
						}
						if($typeW=='E'){
							$bodyclass='THERMAL';
						}
						/*
							ULTRALIGHT: 0,
	LIGHT: 1,
	MEDIUM: 2,
	HEAVY: 3,
	ULTRAHEAVY: 4,
	*/
						
						echo '<br>priceclass:'.  $item['id'] .' '. $checkprice .'/'. $sys['nrs']['unitprice']/3 .'='. $priceclass .' pow:'. $pow .' n:'. $nbase*$fig**-$priceclass .'/'. $nbase;
						/**/
						/*
						if($weight=="xlgt"){
							$weightfact/=$fig;
							$price/=$fig;
							$pow*=$figbase/Fwz_fig($nbase  * $fig**1);
							$pow*=1.1; //shouldnt be here but scavs are week in game...
							$nbweight='ULTRALIGHT';
							$nbweight2='ULTRALIGHT';
							//$wepweight=1/16;
						}
						if($weight=="lgt"){
							$wepclass='HEAT';
							$bodhp*=pow($bodyMod,2);
							$wepmin/=pow($bodyMod,3);
							$wepweight=1/4;
							$nbweight='LIGHT';
							$nbweight2='LIGHT';
						}
						if($weight=="LM"){
							$weightfact*=$fig**.5;
							$price*=$fig**.5;
							$pow*=$figbase/Fwz_fig($nbase * $fig**-0.5);
							$bodhp*=$bodyMod**1.5;
							$wepweight=4/8;
							$nbweight='MEDIUM';
							$nbweight2='MEDIUM';
						}
						if($weight=="med"){
							$weightfact*=$fig;
							$price*=$fig;
							$pow*=$figbase/Fwz_fig($nbase * $fig**-1);
							$bodhp*=$bodyMod;
							$wepweight=7/12;
							$nbweight='MEDIUM';
							$nbweight2='MEDIUM';
						}
						if($weight=="MH"){
							$weightfact*=$fig**1.5;
							$price*=$fig**1.5;
							$pow*=$figbase/Fwz_fig($nbase * $fig**-1.5);
							$bodhp*=$bodyMod**0.5;
							$wepweight=5.5/8;
							$wephp=1/6;
							$nbweight='HEAVY';
							$nbweight2='HEAVY';
						}
						if($weight=="hvy"){
							$weightfact*=$fig*$fig;
							$price*=$fig*$fig;
							//$pow*=Fwz_fig($fig)*Fwz_fig($fig);
							$pow*=$figbase/Fwz_fig($nbase  * $fig**-2);
							$wepweight=3/4;
							$wephp=1/3;
							$nbweight='HEAVY';
							$nbweight2='HEAVY';
							$bodyclass='THERMAL';
							$bodheat=1;
						}
						
						$priceclass=$weight;
						$priceclassR=$weight;
						
						/**/
						
						$pow=pow($pow,.5);
						echo '<br/>'. $id .' '. $itemname .' '. $item['id'] .' '. $item['name'] .' '. $val3['type'] .' nbase'. $nbase .'pow:<b>'. $pow .'</b> power: '. $power .' price:'. $price .' restot:'. $totrestime .' '. $weight;
						if($val3['type']=='body'){
							
							//print_r($item2);
							
							$temp['subgroupIconID']="IMAGE_RES_DROIDTECH";
							$item['id'].=$sufix;
							//$item['model']="cybd_std.pie";
							$item['buildPower']=floor($price);
							$item['buildPoints']=floor($price*$sys['nrs']['produnit']);
							#$item['hitpoints']=50*$pow*$power*(1-$wephp)*$sys['nrs']['dmgunit'];
							$item['hitpoints']=50*$pow*(1-$wephp)*$sys['nrs']['dmgunit'];
							if($typeW=='A' or $typeW=='AE'){
								$item['armourHeat']=10000*$bodheat;
							}
							if($typeW=='E' or $typeW=='AE'){
								$item['armourKinetic']=10000*$bodkin;
							}
							//$item['name'].=" [$weight]#". ($no+1);
							$item['name'].=" [". $priceclassR ."-". $typeW ."*] #". ($no+1);
							$target=$typeW;
							$item['weaponSlots']=1;
							if (!in_array("baba", $val3['as'] )) {
								$item['designable']=1;
							}
							//if($weight=='xlgt'){ $item['designable']=0;}
							
							//$item['weight']=1000*(1-$wepweight);
							$item['weight']=1000*1.3**$priceclass*(1-.5*$engineClass);
							$item['powerOutput']=2625*1.3**$priceclass*(1-.5*$engineClass);;
							if( $item['class']=='Cyborgs'){
								$item['designable']=0;
								$item['usageClass']="Cyborg";
							}
							if( $val3['in'] =='2120' && $item['droidType']!='CYBORG'){
								$item['powerOutput']*=1.4;
								$item['hitpoints']*=.8;
							}
							if($item['droidType']=='PERSON'){
								$item['hitpoints']*=1.1;
								echo 'person detected';
							}
							
							unset($item['propulsionExtraModels']);
							if($item['size']=="LIGHT"){ $item['propulsionExtraModels']=$sys['nrs']['base'][ $val3['type'] ]['Body1REC']['propulsionExtraModels']; }
							elseif($item['size']=="MEDIUM"){ $item['propulsionExtraModels']=$sys['nrs']['base'][  $val3['type'] ]['Body5REC']['propulsionExtraModels']; }
							else { $item['propulsionExtraModels']=$sys['nrs']['base'][  $val3['type'] ]['Body11ABT']['propulsionExtraModels']; }
							if (in_array("baba", $val3['as'] )) { unset($item['propulsionExtraModels']); }
							$item['size']="LIGHT";

							if($val3['in']!="base"){
								Fwz_pieSweap($sys['nrs']['base'],$sys['nrs']['base'],'body',$item,'-'. $val3['in'] ,$sys['nrs']['dir']['save'],$sys['nrs']['dir'][ $val3['in'] ],'','');
							}
							$sys['nrs']['file']['stat'][$val3['type']][$item['id']]=$item;
							//$sys['nrs']['nb'][$linename]['body'][]='{ res: "'. $id .'", stat: "'. $item['id'] .'", weight: WEIGHT.'.$nbweight.' }';
							if($item['designable']){
								$sys['nrs']['nb']['body']['extras'][]='{ res: "'.  $id .'", stat: "'. $item['id'] .'", weight: WEIGHT.'.$nbweight2.' , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.'. $bodyclass .' }';
								if(!$fake){
									if($typeW=='E'){
										$sys['nrs']['nb2']['bodyThermal'].="			\"$id\",
	";
									}
									else{
									
										$sys['nrs']['nb2']['bodyKinetic'].="			\"$id\",
	";
									}
								}
							}
							
				//====================new upgrade=====
								$totvalue=100*$power;
								$value=$totvalue-$lastvalue;
								$lastvalue=$totvalue;
								$r['class']='Body';
								//$r['filterParameter']='HitPointPct';
								unset($r['filterParameter']);
								/*
								$subclssesno=array_search($subclass,$sys['nrs']['subclsses']);
								foreach($sys['nrs']['subclsses'] as $no=>$classeName){
									if($classeName!=''){
														
										$factor=0;
										##if($sys['nrs']['subclassesStrenght'][$subclssesno]==$sys['nrs']['subclssesWeight'][$no]){
										if($sys['nrs']['subclassesStrenght'][$no]==$engineClass){
											$factor+=.2;
										}
										if($sys['nrs']['subclassesRegion'][$no]==$quality){
											$factor+=.2;
										}
										#if($wepclass=='KINETIC'){
										if($typeW=='O'){
											if($sys['nrs']['subclassesType'][$no]!=$typeW){
												$factor-=.2;
											}
										}
										if($factor){	
											*/
											$factor=1;
											$r['filterValue']=$classeName;
											unset($r['filterValue']);
											
											$r['parameter']='HitPointPct';
											$r['value']=ceil($value*$factor);
											$temp['results'][]=$r;
											
											/*
											$r['parameter']='RadiusDamage';
											$r['value']=ceil($value*$factor);
											$temp['results'][]=$r;
											
										}
										
										//if($classeName==$filtername){$factor=1;}				
										
										
										echo '<br>upgrades:'. $classeName .' '. $subclass .' ' . 	$subclssesno .' '. $sys['nrs']['subclassesStrenght'][$no].'=?'. $engineClass;
									}
									
								}
								*/
						}
						if($val3['type']=='propulsion'){
							//print_r($item2);
							$temp['subgroupIconID']="IMAGE_HOVERCRAFT";
							 //"model": "MIBNKDRL.PIE",
							$item['id'].=$sufix;
							//unset($item['model']);
							$item['buildPower']=100;
							$item['buildPoints']=100;
							$item['hitpointPctOfBody']=100*$pow*$power;
							
							
							if($item['name']=='hover01'){ $item['hitpointPctOfBody']*=.8; }
							if($item['name']=='tracked01'){ $item['hitpointPctOfBody']*=1.2; }
							if($item['name']=='HalfTrack'){ $item['hitpointPctOfBody']*=1.1; }
						
							$item['weight']=0;
							$item['designable']=1;
							if($item['id']=='CyborgLegs'){
								$exp[0]='CyborgLightBody';
								$item['designable']=0;
							}
							$item['id'].=$sufix;
							$sys['nrs']['file']['stat'][$val3['type']][$item['id']]=$item;
							
							if($val3['in']!="base"){
								Fwz_pieSweap($sys['nrs']['base'],$sys['nrs']['base'],'body',$item,'-'. $val3['in'] ,$sys['nrs']['dir']['save'],$sys['nrs']['dir'][ $val3['in'] ],'','');
							}
							$sys['nrs']['file']['stat'][$val3['type']][$item['id']]=$item;
							$sys['nrs']['nb']['propulsion']['extras'][]='"'. $id .'"';
							//if($no==0){
								//Fnrs_upgradeline("Weapon","ImpactClass",$subclass,'Damage',$exp[0] .$sufix,$id);
								Fnrs_upgradeline("Propulsion","Id",$item['id'],'HitpointPctOfBody',$exp[0],$id,$resmult,$item['name'] .' HP');
							//}
							

						}
						if($val3['type']=='sensor'){
							$temp['subgroupIconID']="IMAGE_RES_SYSTEMTECH";
							$item['buildPower']=floor($price);
							$item['buildPoints']=floor($price*$sys['nrs']['produnit']);
							$item['hitpoints']=0;
							$item['id'].=$sufix;
							$item['designable']=1;
							$sys['nrs']['file']['stat'][$val3['type']][$item['id']]=$item;
							
							if($no2==0){
								$t2['id']='tower-'. $item['id'];
								$t2['armour']=0;
								$t2['breadth']=1;
								$t2["buildPoints"]= $price*3*$sys['nrs']['produnit'];
								$t2["buildPower"]= $price*3;
								$t2["height"]= 1;
								$t2["hitpoints"]= $pow*300;
								$t2["name"]=  $item['name'] .' tower';
								$t2["resistance"]= 150;
								$t2["sensorID"]= $item['id'];
								$t2["strength"]="HARD";
								$t2["structureModel"]=["BLGUARDR.pie"];
								$t2["thermal"]= 0;
								$t2["type"]= "DEFENSE";
								//$t2["weapons"]=[ $item['id']];
								$t2["width"]= 1;
								$sys['nrs']['file']['stat']['structure'][$t2['id']]=$t2;
								$temp['resultStructures'][]=$t2['id'];
							}
						}
						
						if($type=='weapons'){
							$temp['subgroupIconID']="IMAGE_RES_WEAPONTECH";

							
							if (in_array("AW", $val3['as'] )) {$nocl=0;$hooman='AW';$weaponEffect="ALL ROUNDER"; $nbroles='[ 0.4, 0.3, 0.1, 0.2 ]'; }
							if (in_array("AS", $val3['as'] )) {$nocl=1;$hooman='AS';$weaponEffect="ARTILLERY ROUND"; $nbroles='[ 0.1, 0.2, 0.5, 0.2 ]'; }
							if (in_array("AT", $val3['as'] )) {$nocl=2;$hooman='AT';$weaponEffect="ANTI TANK"; $nbroles='[ 0.5, 0.1, 0.2, 0.2 ]'; }
							if (in_array("AP", $val3['as'] )) {$nocl=3;$hooman='AP';$weaponEffect="ANTI PERSONNEL"; $nbroles='[ 0.1, 0.5, 0.2, 0.2 ]'; }
							if (in_array("AN", $val3['as'] )) {$nocl=4;$hooman='AN';$weaponEffect="FLAMER"; $nbroles='[ 0.3, 0.3, 0.3, 0.3 ]'; }
							if (in_array("brain", $val3['as'])  or $braindetect ) {$price*=2; $wephp+=2; $item2['Prevalue']*=3; echo '<br><b>brain weap</b>';}
							if (in_array("FOM", $val3['as'] )) { $item['fireOnMove']=1; }
							$sys['nrs']['subclssesCheat'][$subclass]=$weaponEffect .' '. $weight; 
							$noclf=($nocl*3)+1;
							if($weight=="med"){$noclf+=1;}
							if($weight=="hvy"){$noclf+=2;}
							
						
							
							if(!isset($subclass)){
								$subclass=$sys['nrs']['subclsses'][$noclf];
								echo 'noclf:'. $item['id'] .'--'. $nocl .' '. $noclf .' '. $subclass .'<br>';
								
								/*
								if (in_array("NRSp", $val3['as'] )) {
									$subclass='BOMB';
								}
								else{
									$subclass=$sys['nrs']['subclsses'][ ++$sys['nrs']['subclssescount']];
								}
								*/
							}
							#fireOnMove
							$linename=$hooman. $typeW.($quality+1).($engineClass+1);
							$sys['nrs']['nb'][$linename]['roles']=$nbroles;
							$item['buildPower']=floor($price);
							$item['buildPoints']=floor($price*$sys['nrs']['produnit']);
							#$item['hitpoints']=50*$pow*$power*$wephp*$sys['nrs']['dmgunit'];
							$item['hitpoints']=50*$pow*$wephp*$sys['nrs']['dmgunit'];
							
							//$scale=2.09*$pow*$power/$item2['Prevalue'];
							//1.50 for a while. then structures were buffed What range mod ?
							#$scale=1.5*$pow*$power/$item2['Prevalue']*$sys['nrs']['dmgunit']*$sys['nrs']['dmgscale']; //this affect the range mod !
							$scale=1.5*$pow/$item2['Prevalue']*$sys['nrs']['dmgunit']*$sys['nrs']['dmgscale']; //this affect the range mod !
							if( $typeW==0){ $item['minimumDamage']=100;}
							else{ $item['minimumDamage']=100/$sys['nrs']['wepmod']; $scale*=$sys['nrs']['wepmod']**0.5;}
							echo 'scale:'. $scale;
							echo '<br>pv:'. $item2['Prevalue'] .'<br>';
							$item['damage']*=$scale;
							$item['radiusDamage']*=$scale;
							$item['periodicalDamage']*=$scale;
							#$item['weight']=1000*$wepweight;
							$item['weight']=1000*1.3**$priceclass*(.5-.5*$engineClass);
							$item['recoilValue']=min(150,$item['recoilValue']);
							
							$item['periodicalDamageWeaponClass']=$wepclass;
							$item['periodicalDamageWeaponEffect']=$weaponEffect;
							$item['periodicalDamageWeaponSubClass']=$subclass;
							$item['weaponClass']=$wepclass;
							$item['weaponEffect']=$weaponEffect;
							$item['weaponSubClass']=$subclass;
							
							//$item['minimumDamage']=$wepmin*100;
							if($braindetect){
								echo 'changing name to commander';
								$item['name']='commander '. $item['name'];
							}
							else{
								#$item['name'].=" [". $priceclassR ." $hooman] #". ($no+1);
								$item['name'].=" [". $priceclassR ."-$hooman". $typeW ."] #". ($no+1);
							}
							$target=$hooman . $typeW;
							if($val3['in']!="base"){
								Fwz_pieSweap($sys['nrs']['base'],$sys['nrs']['base'],'weapons',$item,'-'. $val3['in'] ,$sys['nrs']['dir']['save'],$sys['nrs']['dir'][ $val3['in'] ],'','');
							}
							$item['id'].=$sufix;
							$pos = strpos($item['id'],'VTOL');
							$vtolshit=0;
							if($pos===FALSE){
								
							}
							else{
								echo '<br><b>VTOL SHIT ! </b>';	
								$vtolshit=1;			
								$sys['nrs']['nb'][$linename]['vtols'][]='{ res: "'. $id .'", stat: "'. $item['id'] .'", weight: WEIGHT.'.$nbweight.' }';
								$item['designable']=1;
							}
							$pos = strpos($item['id'],'Cyb');
							echo "<br>in:". $val3['in'];
							if($pos===FALSE){
								$item['designable']=1;
							}
							else{
								unset($item['designable']);
								$item['usageClass']="Cyborg";
							}
							if($braindetect){
								$item['designable']=0;
							}
							//$item['designable']=1;
							else{
								echo '<br><b>CYBORG SHIT ! '. $vtolshit .'</b>';
								$template['type']="CYBORG";
								$template['propulsion']="CyborgLegs";
								$template['available']="true";
								$template['name']=$item['name'] ." Cyb-Mk". $no;
								$template['id']=$item['id'] ."-Cyb";
								$pos = strpos($item['id'],'Cyb');
								if($pos===FALSE){
									$item2=$item;
									unset($item2['designable']);
									$item2['usageClass']="Cyborg";
									$item2['id'].='-Cyb';
									if($priceclass<=-2){
										unset($item2['mountModel']); 
										unset($item2['model']);
									}
									$sys['nrs']['file']['stat'][$val3['type']][$item2['id']]=$item2;
									$template['weapons']=[$item2['id']];
									$temp['resultComponents'][]=$item2['id'];
								}
								else{
									$template['weapons']=[$item['id']];
									#if($val3['in']!='mech'){
										echo '<br>undesignable!';
										unset($item['designable']);
									#}
									$item['usageClass']="Cyborg";	
								}
								$prop= "CyborgLegs";
								if($priceclass<=-2){	$template['body']="B1BaBaPerson01-nrs";  }
								else if($priceclass<=-1){	$template['body']="CyborgLightBody"; }
								else if($priceclass<=1){	$template['body']="CyborgHeavyBody"; }
								else if($priceclass<=2){	$template['body']="CyborgHeavyBody-2120"; }
								else {	$template['body']="CyborgLightBody-mech"; }
								//else if($weight=='xlgt'){	$template['body']="B1BaBaPerson01-nrs"; /*$prop= "BaBaLegs";*/ }
								//else {	$template['body']="CyborgHeavyBody"; }
								if(!$vtolshit){
									$sys['nrs']['file']['stat']['templates'][$template['id']]=$template;
									$sys['nrs']['nb'][$linename]['templates'][]='{ res: "'. $id .'", body: "'. $template['body'] .'", prop: "'. $prop .'", weapons: [ "'. $item['id'] .'", ] }';
								}
								//{ res: "R-NRS-MG1Mk1", body: "CyborgLightBody"
								//$template['propulsion']="CyborgLegs";
							}	
							//if($weight=='xlgt'){ $item['designable']=0;}

							$sys['nrs']['file']['stat'][$val3['type']][$item['id']]=$item;
							
							//print_r($item);
							if($no2==0){
								$sys['nrs']['nb'][$linename]['weapons'][]='{ res: "'. $id .'", stat: "'. $item['id'] .'", weight: WEIGHT.'. $nbweight .' }';
								//$sys['nrs']['nb'][$target.$hooman2]['weapons'][]='{ res: "'. $id .'", stat: "'. $item['id'] .'", weight: WEIGHT.'. $nbweight .' }';
								
								$t2['id']='walltower-'. $item['id'];
								$t2['thermal']=10000*$bodheat;
								$t2['armour']=10000*$bodkin;
								//$t2['armour']=0;
								$t2['breadth']=1;
								$t2["buildPoints"]= $price*3*$sys['nrs']['produnit'];
								$t2["buildPower"]= $price*3;
								
								$t2["hitpoints"]= $pow*300*$sys['nrs']['dmgunit'];
								$t2["name"]=  $item['name'] .' walltower';
								$t2["resistance"]= 150;
								$t2["sensorID"]= "DefaultSensor1Mk1";
								$t2["strength"]="HARD";
								$t2["structureModel"]=["BLGUARD1.pie"];
								//$t2["thermal"]= 0;
								$t2["type"]= "DEFENSE";
								$t2["weapons"]=[ $item['id']];
								$t2['breadth']=1;
								$t2["height"]= 1;
								$t2["width"]= 1;
								if($priceclass<=-2){	$t2['structureModel']=["BLGUARDM.PIE"];}
								else if($priceclass<=-1){		$t2['structureModel']=["BLGUARDR.pie"];}
								else if($priceclass<=1){		$t2['structureModel']=["BLGUARD1.pie"]; }
								else if($priceclass<=2){		$t2['structureModel']=["BLGUARD3.pie"]; }
								else {	$t2['structureModel']=["STWPFCAN.PIE"]; 
									$t2['breadth']=2;
									$t2["height"]= 1;
									$t2["width"]= 2;
								}
								
								$sys['nrs']['file']['stat']['structure'][$t2['id']]=$t2;
								$temp['resultStructures'][]=$t2['id'];
								$sys['nrs']['nb'][$linename]['defenses'][]='{ res: "'. $id .'", stat: "'. $t2['id'] .'", defrole: DEFROLE.STANDALONE }';
								//{ res: "R-NRS-MG1Mk1", stat: "walltower-MG1Mk1", defrole: DEFROLE.GATEWAY }, 
								
								
				//====================new upgrade=====
								$totvalue=100*$power;
								$value=$totvalue-$lastvalue;
								$lastvalue=$totvalue;
								$r['class']='Weapon';
								$r['filterParameter']='ImpactClass';
								$subclssesno=array_search($subclass,$sys['nrs']['subclsses']);
								foreach($sys['nrs']['subclsses'] as $no3=>$classeName){
									if($classeName!=''){
														
										$factor=0;
										##if($sys['nrs']['subclassesStrenght'][$subclssesno]==$sys['nrs']['subclssesWeight'][$no]){
										if($sys['nrs']['subclassesStrenght'][$no3]==$engineClass){
											$factor+=.2;
										}
										if($sys['nrs']['subclassesRegion'][$no3]==$quality){
											$factor+=.2;
										}
										#if($wepclass=='KINETIC'){
										if($typeW=='O'){
											if($sys['nrs']['subclassesType'][$no3]!=$typeW){
												$factor-=.2;
											}
										}
										if($factor){	
											$r['filterValue']=$classeName;
											$r['parameter']='Damage';
											$r['value']=ceil($value*$factor);
											$temp['results'][]=$r;
											$r['parameter']='RadiusDamage';
											$r['value']=ceil($value*$factor);
											$temp['results'][]=$r;
											
										}
										//if($classeName==$filtername){$factor=1;}				
										
										
										//echo '<br>upgrades:'. $classeName .' '. $subclass .' ' . 	$subclssesno .' '. $sys['nrs']['subclassesStrenght'][$no].'=?'. $engineClass;
									}
								}
								$r['filterParameter']='Effect';
								$r['filterValue']=$sys['nrs']['weaponEffect'][$sys['nrs']['subclssesEffect'][$subclssesno]];
								$factor=.2;
								$r['parameter']='Damage';
								$r['value']=ceil($value*$factor);
								$temp['results'][]=$r;
								$r['parameter']='RadiusDamage';
								$r['value']=ceil($value*$factor);
								$temp['results'][]=$r;
								
								if($typeW=='O'){
									$r['filterParameter']='ImpactType';
									$r['filterValue']='HEAT';
									$factor=.2;
									$r['parameter']='Damage';
									$r['value']=ceil($value*$factor);
									$temp['results'][]=$r;
									$r['parameter']='RadiusDamage';
									$r['value']=ceil($value*$factor);
									$temp['results'][]=$r;
								}
								
								$r['filterParameter']='ImpactType';
								$r['filterValue']=$wepclass;
								$factor=.2;
								$r['parameter']='Damage';
								$r['value']=ceil($value*$factor);
								$temp['results'][]=$r;
								$r['parameter']='RadiusDamage';
								$r['value']=ceil($value*$factor);
								$temp['results'][]=$r;
								
								unset($r['filterParameter']);
								unset($r['filterValue']);
								$factor=.4;
								$r['parameter']='Damage';
								$r['value']=ceil($value*$factor);
								#$temp['results'][]=$r;
								$r['parameter']='RadiusDamage';
								$r['value']=ceil($value*$factor);
								#$temp['results'][]=$r;
								
									$sys['nrs']['nb'][$linename]['micro']='MICRO.RANGED';
									if($item['longRange']<500){
										$sys['nrs']['nb'][$linename]['micro']='MICRO.MELEE';
									}
									if($item['fireOnMove']===0){
										$sys['nrs']['nb'][$linename]['micro']='MICRO.DUMB';
									}
									$sys['nrs']['nb'][$linename]['chatalias']=++$sys['nrs']['nb']['count'];								
								if($no==0){
									/*
									$thisname='';
									if($val3['call']!=''){	$thisname=$val3['call'] .' damage';	}
									Fnrs_upgradeline("Weapon","ImpactClass",$subclass,'Damage',$exp[0] .$sufix,$id,1,$thisname,$sufix);
									$sys['nrs']['nb'][$linename]['extras'][]=$sys['nrs']['nb']['temp'];
									if($val3['call']!=''){	$thisname=$val3['call'] .' ROF';	}
									Fnrs_upgradeline("Weapon","ImpactClass",$subclass,'FirePause',$exp[0] .$sufix,$id,1,$thisname,$sufix);
									$sys['nrs']['nb'][$linename]['extras'][]=$sys['nrs']['nb']['temp'];
									#if($val3['call']!=''){	$thisname=$val3['call'] .' power';	}
									#Fnrs_upgradeline("Weapon","ImpactClass",$subclass,'buildPower',$exp[0] .$sufix,$id,1,$thisname);
									#$sys['nrs']['nb'][$linename]['extras'][]=$sys['nrs']['nb']['temp'];
									*/

									//chatalias: "mg",
									//baba shit
									//	$weightfact=1/$fig;
									//	$price=20/$fig;
									//	$pow=Fwz_fig( pow(1/$fig,1) );
									//}
									//MOre cyborgs LOOK ^up^
									/*
									$template['type']="CYBORG";
									$template['propulsion']="BaBaLegs";
									$template['available']="true";
									$template['name']=$item['name'] .' cyb #'. $no;
									$template['id']=$item['id'] .'-person';
									$template['weapons']=[$item['id']];
									$template['body']="B1BaBaPerson01"; 
									$sys['nrs']['file']['stat']['templates'][$template['id']]=$template;
									*/
								}
								if($no2==0 or 1){
										$baseid=$item['id'];
										if($weight!="xlgt"){
											echo 'adding baba';
											$item['id'].='-BABA';
											//$nname=$item['id'].'-BABA';
											$sys['nrs'][ $val3['in'] ][  $val3['type'] ][$item['id'] ]=$item;
											//$exp[]=$item['id']; //what a shitty hack
											print_r($exp);
										}
										echo 'adding brain';
										$item['id']=$baseid .'-command';
										//$nname=$item['id'].'-BABA';
										$sys['nrs'][ $val3['in'] ][  $val3['type'] ][$item['id'] ]=$item;
										$exp[]=$item['id']; //what a shitty hack
										$item=$sys['nrs']['base']['brain']['CommandBrain01'];
										$item['id']=$baseid .'-brain';
										$item['turret']=$baseid .'-command';
										$item['name']=$item['id'];
										//$sys['nrs'][ $val3['in'] ]['brain'][$item['id']]=$item;
										$sys['nrs'][ $val3['in'] ]['brain'][$item['id']]=$item;
										
										$exp[]=$item['id']; //what a shitty hack
										echo 'adding brain2'. $item['id'];
										
										$template['type']="CYBORG";
										$template['propulsion']="BaBaLegs";
										$template['available']="true";
										$template['name']=$item['name'] .' baba #'. $no;
										$template['id']=$item['id'] .'-person';
										$template['weapons']=[$item['id']];
										$template['body']="B1BaBaPerson01"; 
										//$sys['nrs']['file']['stat']['templates'][$template['id']]=$template;
										
										$template['type']="CYBORG";
										//$template['propulsion']="BaBaLegs";
										$template['propulsion']="CyborgLegs";
										
										$template['available']="true";
										$template['name']=$item['name'] .' #'. $no;
										$template['id']=$item['id'] .'-person';
										$template['weapons']=[$item['id']];
										$template['body']="B1BaBaPerson01"; 
										//$sys['nrs']['file']['stat']['templates'][$template['id']]=$template;
										/*
										$template['type']="DROID";
										$template['propulsion']="wheeled01";
										$template['name']=$item['name'] ."-bus";
										$template['id']=$item['id'] .'-bus';
										$template['weapons']=[$item['id']];
										$template['body']="BusBody"; 
										$sys['nrs']['file']['stat']['templates'][$template['id']]=$template;
										
										$template['type']="DROID";
										$template['propulsion']="wheeled01";
										$template['name']=$item['name'] ."-truck";
										$template['id']=$item['id'] .'-truck';
										$template['weapons']=[$item['id']];
										$template['body']="FireBody"; 
										$sys['nrs']['file']['stat']['templates'][$template['id']]=$template;
										*/
								}
								
								
							}
							
						}
						if($val3['type']=='structure'){
							$temp['subgroupIconID']="IMAGE_PLASCRETE";
							echo 'structure found';
							if($eco){
								$item['id'].='-eco';
							}
							else{
								$item['id'].=$sufix;
							}
							
							if($item['type']=="REPAIR FACILITY"){
								$item['repairPoints']=40*$power*$sys['nrs']['dmgunit']*$sys['nrs']['dmgscale'];
							}
							$item["buildPower"]*=$sys['nrs']['powerunit'];
							$item['power']=$power;
							//$item['pow']=$pow;
							$sys['nrs']['file']['stat'][$val3['type']][$item['id']]=$item;
						
							
							$sys['nrs']['powstuff'].='<br>	'. $nomfac .'Pow+=countStruct("'. $item['id'] .'", playnum)*'. $item['buildPower'] .'*'. $power .';';
							$sys['nrs']['powstuff2']='"'. $item['id'] .'",'. $sys['nrs']['powstuff2'];
							//print_r($item);
						}
						if($val3['type']=='construction'){
							echo 'construction:'. $item2['Prevalue2'];
							$item['constructPoints']=$pow*4*$power*$sys['nrs']['dmgunit']*$sys['nrs']['dmgscale'];
							$item["buildPoints"]= $price*$sys['nrs']['produnit'];
							$item["buildPower"]= $price;
							$item['hitpoints']=50*$pow*$power*$sys['nrs']['structureHPScale'];
							//$item['weight']=1000*$wepweight;
							$item['weight']=1000*1.3**$priceclass*(.5-.5*$engineClass);
							$sys['nrs']['file']['stat'][$val3['type']][$item['id']]=$item;
							
						}
						if($val3['type']=='repair'){
							echo 'construction:'. $item2['Prevalue2'];
							$item['constructPoints']=$pow*4*$power*$sys['nrs']['dmgunit'];
							$item["buildPoints"]= $price*$sys['nrs']['produnit'];
							$item["buildPower"]= $price;
							$item['hitpoints']=50*$pow*$power*$sys['nrs']['structureHPScale'];
							$item['weight']=1000*$wepweight;
							$sys['nrs']['file']['stat'][$val3['type']][$item['id']]=$item;
							
						}
						
						if($type=='brainold'){
							echo 'brain:'. $item2['Prevalue2'];
							$id=$item2['name'] .'brain1-turret';
							//$item['id'].='-BABA';
							$item=$sys['nrs']['base']['weapons']['CommandTurret1'];
							$val3['type']='weapons';
							$val3['as'][]='brain';
							
							//$item['id']=$id;
							//$nname=$item['id'].'-BABA';
							$sys['nrs'][ $val3['in'] ][  $val3['type'] ][$item['id'] ]=$item;
							$exp[]=$item['id']; //what a shitty hack
							
						}
						if($type=='brain'){
							echo 'brain:'. $item2['Prevalue2'] .' |'. $item['id'] .'|';
							print_r($item);
							//$id=$item2['name'] .'brain1-turret';
							//$item['id'].='-BABA';
							//$item=$sys['nrs']['base']['weapons']['CommandTurret1'];
							//$val3['type']='weapons';
							//$val3['as'][]='brain';
							$item['turret']=$baseid .'-command';
							$item['name']=$item['id'];
							$targetsize=5+$sys['nrs']['armysize']/3/$weightfact*$fig;
							$max=5+$sys['nrs']['armysize']/2/$weightfact*$fig;
							$diff=$max-$targetsize;
							$step=ceil($diff*2/8);
							$min=$max-$step*8;
							$item['maxDroids']=ceil($min);
							$item['maxDroidsMult']=$step;
							unset($temparr);
							$temparr[]=0;
							$thresx=0;
							while($thresx++<7){
								$nunit=$min*$thresx+$step;
								$expi=$nunit/5 * 2**$thresx;
								$temparr[]=$expi;
							}
							$item['thresholds']=$temparr;
							echo 'B calc'. $target .' '. $hooman2 .' m:'. $max .' d:'. $diff .' N='. $min .' +'. $step;
							//$item['id']=$id;
							//$nname=$item['id'].'-BABA';
							$sys['nrs']['file']['stat'][  $type ][$item['id'] ]=$item;
							//$exp[]=$item['id']; //what a shitty hack
							
						}
						
							/*			
						        "resultStructures": [
								"A0PowMod1"
						],/
						echo 'MMM'. $sys['nrs']['dir'][ $val3['in'] ] .' '. $val3['type'];
						/*
						echo '<pre>';
						print_r($item);
						echo '</pre>';
						*/
						$weight=$rweight;
						$no2++;
					}
					$temp['statID']=$exp[0] .$sufix2;

					$temp['id']=$id;

					$temp['name']='['. $priceclassR .'-'. $target .']'. $name .'-'. $nomfac .' #'. ($no+1) ;

					
					//$respower=$sys['nrs']['stdrpoint']/count($val4);
					if($val3['replacedComponents']!=''){
						$temp['replacedComponents']=$val3['replacedComponents'];
					}
					$temp['researchPoints']=$sys['nrs']['time']/count($val4)*14*$resfrac*$timefac;
					$temp['researchPower']=$respower;
					
					if($lastres!=$sys['nrs']['startres']){
						$temp['iconID']="IMAGE_CANNON";
					}
					if($fake){
						unset($temp['requiredResearch']);
					}else{
						$temp['requiredResearch']=[$lastres];
					}
					$sys['nrs']['file']['stat']['research'][$id]=$temp;
					$lastres=$id;

				}
			}
		}
	}
}

function Fwz_NRS_dist(&$d,$var){ //scale distance of the whole mod.
	if($var[1]!=1 or $var[2]!=1){
		foreach($d['propulsion'] as $nom => $val){
			Fwz_mult($d['propulsion'][$nom]['speed'],$var[1]*$var[2]);
		}
		foreach($d['propulsiontype'] as $nom => $val){
			Fwz_mult($d['propulsiontype'][$nom]['multiplier'],$var[1]);
		}
	}
	if($var[1]!=1 or $var[3]!=1){
		
		foreach($d['sensor'] as $nom => $val){
			Fwz_mult($d['sensor'][$nom]['range'],$var[1]*$var[3]);
		}
	}
	if($var[1]!=1 or $var[4]!=1){
		foreach($d['weapons'] as $nom => $val){
			echo $nom .'...';
			Fwz_mult($d['weapons'][$nom]['shortRange'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$nom]['longRange'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$nom]['splash radius'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$nom]['incenRadius'],$var[1]*$var[4]);
			if(isset($d['weapons'][$nom]['flightSpeed'])){
				Fwz_mult($d['weapons'][$nom]['flightSpeed'],$var[1]*$var[4]);
			}
			Fwz_mult($d['weapons'][$nom]['indirectHeight'],$var[1]*$var[4]);
			Fwz_mult($d['weapons'][$nom]['minRange'],$var[1]*$var[4]);
		}
	}

}

//Make sure constant are initialized
$sys['nrs']['dmgunit']=1;
$sys['nrs']['powerunit']=1;
$sys['nrs']['dmgscale']=1;
$sys['nrs']['weaponEffect']['AW']="ALL ROUNDER";
$sys['nrs']['weaponEffect']['AS']="ARTILLERY ROUND";
$sys['nrs']['weaponEffect']['AT']="ANTI TANK";
$sys['nrs']['weaponEffect']['AP']="ANTI PERSONNEL";
$sys['nrs']['weaponEffect']['AN']="FLAMER";

/*
							if (in_array("AW", $val3['as'] )) {$hooman='AW';$weaponEffect="ALL ROUNDER"; $nbroles='[ 0.4, 0.3, 0.1, 0.2 ]'; }
							if (in_array("AS", $val3['as'] )) {$hooman='AS';$weaponEffect="ARTILLERY ROUND"; $nbroles='[ 0.1, 0.2, 0.5, 0.2 ]'; }
							if (in_array("AT", $val3['as'] )) {$hooman='AT';$weaponEffect="ANTI TANK"; $nbroles='[ 0.5, 0.1, 0.2, 0.2 ]'; }
							if (in_array("AP", $val3['as'] )) {$hooman='AP';$weaponEffect="ANTI PERSONNEL"; $nbroles='[ 0.1, 0.5, 0.2, 0.2 ]'; }
							if (in_array("AN", $val3['as'] )) {$hooman='AN';$weaponEffect="FLAMER"; $nbroles='[ 0.3, 0.3, 0.3, 0.3 ]'; }
							*/