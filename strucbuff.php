<?php
include('mod.php'); 
$basedir='./mp4.3.5/';
$savedir='./tempmodfile/';
$data['structure']= json_decode(file_get_contents($basedir .'stats/structure.json'), TRUE);
foreach($data['structure'] as $nom=>$val){
	print_r('<br>'. $nom);
	print_r($val);
	$data['structure'][$nom]['hitpoints']=floor($data['structure'][$nom]['hitpoints']*1.4);
}

$dump=json_encode($data['structure'],JSON_PRETTY_PRINT);
file_put_contents($savedir .'\\stats\\structure.json', $dump);