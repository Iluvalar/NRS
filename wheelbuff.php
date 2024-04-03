<?php
include('mod.php'); 
$basedir='./mp4.3.5/';
$savedir='./tempmodfile/';
$file='weaponmodifier.json';
$data[$file]= json_decode(file_get_contents($basedir .'stats/'. $file), TRUE);
foreach($data[$file] as $nom=>$val){
	print_r('<br>'. $nom);
	print_r($val);
	$data[$file][$nom]['Wheeled']=ceil($data[$file][$nom]['Wheeled']*0.9);
	$data[$file][$nom]['Hover']=ceil($data[$file][$nom]['Hover']*0.9);	
}

$dump=json_encode($data[$file],JSON_PRETTY_PRINT);
file_put_contents($savedir .'\\stats\\'. $file, $dump);