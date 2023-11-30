<?php
echo 'new WZmap?';


error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ERROR | E_PARSE);
$time = microtime(true); 

function path($from,$to,$dist){
	global $sys;
	$at=$from;
	$xpath=0;
	$done=false;
	while($xpath++<400 and !$done){
		
		$xdir=0;
		$dist1=(($from['x']-$to['x'])**2+($from['y']-$to['y'])**2)**.5;

		$idealtrav=($dist1)/max(($dist-$xpath),1);
		$idealdist=$dist-$xpath;
		$ratio=$xpath/$dist;
		$sinus=sin($ratio*pi()*3);
		echo ' <br>'. $xpath .' ('. $from['x'] .','. $from['y'] .') it:'. $idealdist .' dist:'. $dist1 .' sin'. $sinus .'<br>';
		$bestscore=0;
		while($xdir++<4){
			$vec['x']=floor(sin( deg2rad($xdir*90))+.5);
			$vec['y']=floor(cos( deg2rad($xdir*90))+.5);
			$dest['x']=$from['x']+$vec['x'];
			$dest['y']=$from['y']+$vec['y'];
			
			$dist2=(($dest['x']-$to['x'])**2+($dest['y']-$to['y'])**2)**.5;
			$dist3=(($dest['x']-$sys['maxx']/2)**2+($dest['y']-$sys['maxy']/2)**2)**.5;
			$diff=$dist1-$dist2;

			//$cdistB=($sys['maxx']/2-$dist3)*$sinus;
			$cdist=$dist3/($sys['maxx']/2);
			$cdistB=(1-abs(.4*$sinus-$cdist));
			if($xpath>$dist/2){
				//$cdistB=-$cdistB;
			}
			//$cdistB=1;
			#$score=(1-abs($diff-$idealtrav))*$cdistB;
			//$diff=abs($dist2-$idealdist);
			$distBoost=10/max(abs($dist2-$idealdist),1);
			$dirBoost=(1-abs($diff-$idealtrav));
			if($dirBoost<0 && $distBoost<0){
				$dirBoost*=-1;
			}
			$score=$distBoost*$dirBoost*(1+$sys['path'][$from['x']][$from['y']]*.1)+$cdistB*25+(rand()%10)/100-$addpath[$from['x']][$from['y']];
			echo ' ('. $vec['x'] .','. $vec['y'] .')'. $diff .' ='. $dirBoost .'*'. $distBoost .'*'. $cdist .'<b>'. $score .'</b>';
			if($score>$bestscore){
				$choiceDir=$xdir;
				$bestscore=$score;
			}
		}
		$vec['x']=floor(sin( deg2rad($choiceDir*90))+.5);
		$vec['y']=floor(cos( deg2rad($choiceDir*90))+.5);
		$from['x']+=$vec['x'];
		$from['y']+=$vec['y'];
		$addpath[$from['x']][$from['y']]+=1;
		//$sys['path'][$from['x']][$from['y']]+=1;
		if($from['x']==$to['x'] && $from['y']==$to['y']){
			$done=true;
		}
		
	}
	foreach($addpath as $x=>$val2){
		foreach($val2 as $y=>$val){
			$sys['path'][$x][$y]+=$val;
		}
	}
}

$sys['img']='./data/25.jpg';
$sys['maxx']=180;
$sys['maxy']=180;

$np=6;
$xp=0;

while($xp++<$np){
	echo '<br>figuring position of P'. $xp.'...';
	$degree=360/$np*$xp+22.5;
	echo 'deg:'. $degree;
	$vec['x']=floor(sin( deg2rad($degree))*($sys['maxx']/2-10)+.5)+$sys['maxx']/2;
	$vec['y']=floor(cos( deg2rad($degree))*($sys['maxy']/2-10)+.5)+$sys['maxy']/2;
	echo ' ('. $vec['x'] .','. $vec['y'] .')';
	$p[$xp]=$vec;
}
$xpath=0;
while($xpath++<100){
	$rand1=rand()%$np+1;
	$rand2=rand()%$np+1;
	if($rand1!=$rand2){
		if(!$done[$rand1][$rand2]){
			$dist=min(abs($rand1-$rand2),abs($rand1-($rand2%8)));
			path($p[$rand1],$p[$rand2],150+$dist*240/$np);
			$done[$rand1][$rand2]=true;
		}
		
	}
}
//path($p[1],$p[2],180);
//path($p[1],$p[3],200);
//path($p[1],$p[4],240);
//path($p[1],$p[5],260);
//path($p[1],$p[6],240);
//path($p[1],$p[7],200);
//path($p[1],$p[8],180);
//path($p[1],$p[4],120);

	$im2=imagecreatetruecolor ($sys['maxx'],$sys['maxy']);
	$maxx=$sys['maxx'];
	$maxy=$sys['maxy'];

	$x=0;
	while($x++<$sys['maxx']){
		$y=0;
		while($y++<$sys['maxy']){
			
			$sum['r']=min($sys['path'][$x][$y]*50,250);
			$sum['g']=min($sys['path'][$x][$y]*50,250);
			$sum['b']=min($sys['path'][$x][$y]*50,250);
			$color=imagecolorallocate( $im2 , $sum['r'] , $sum['g'] , $sum['b'] );
			//$color=imagecolorallocate( $im2 , 196 , 0 , 0 );
			imagesetpixel( $im2 ,$x-1 , $y-1 , $color ) ;
			//print_r($sum);
		}
	}
	imagepng($im2,'./newmap.png');
	imagedestroy($im2);

//print_r($data);
$time = microtime(true)-$time; 
echo $time .','. $max;
echo '<br/><img style="width:80%" src="./newmap.png"/>';
