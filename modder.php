<?php

//error_reporting(E_ERROR | E_PARSE);
ini_set('memory_limit','1G');

include('Fwz.php');
include('Fnrs.php');
include('mod.php'); //I think the distance mod might be in this one ?

$basedir='./mp4.3.5/';
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