<?php
$ecoscale=10*$sys['nrs']['dmgscale']; //10 = Factory(1000)/100 power;
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

$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']=$sys['nrs']['base']['structure']['A0ResearchFacility'];
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['name']='quick labs';
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['structureModel']=['aerolab.pie'];
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['buildPower']=($sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['buildPower'])*$sys['nrs']['powerunit'];
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['hitpoints']=100*$sys['nrs']['dmgunit'];
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['buildPoints']=1;
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['id']='A0ResearchFacility-nrs';
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility']['buildPower']=50*$sys['nrs']['powerunit'];

/////Default values
$t2=$sys['nrs']['file']['stat']['structure']['A0CommandCentre'];
$t2["thermal"]= 0;
$t2['armour']=0;
$t2["type"]= "DEFENSE";
$t2["strength"]="HARD";

$t2["buildPoints"]=100;
$t2["buildPower"]=50;
$t2["height"]= 0;
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;

$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];


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
$t2["hitpoints"]=$ecoscale*$t2["buildPower"]*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$ecoscale*$t2["buildPower"]*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$ecoscale*$t2["buildPower"]*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$ecoscale*$t2["buildPower"]*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Boulder1'; $t2['id']=$t1['id'];
$t2["type"]=  "WALL";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Boulder2'; $t2['id']=$t1['id'];
$t2["type"]=  "REARM PAD";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]=2; $t2["breadth"]=2;
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Boulder3'; $t2['id']=$t1['id'];
$t2["type"]=  "WALL";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 100;
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='OilDrum'; $t2['id']=$t1['id'];
$t2["type"]=  "REARM PAD";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;

$t1['id']='Pickup'; $t2['id']=$t1['id'];
$t2["type"]=  "WALL";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]= $t1['width']; $t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;



$t1['id']='arizonabush3'; $t2['id']=$t1['id'];
$t2["type"]=  "REARM PAD";
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["buildPoints"]= $sys['nrs']['bankval']*1.5;
$t2["buildPower"]= 50;
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
$t2['name']=$t1['id'];$t2["structureModel"]=$t1['model']; $t2["width"]=2; $t2["breadth"]=2;
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;


$t1['id']='Indirectlab';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2['type']='RESEARCH';
$t2['researchPoints']=12;
$t2['moduleResearchPoints']=7;

$t2['name']='Indirectlab';		
$t2["buildPoints"]=1;
$t2["buildPower"]=1;
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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

$sys['nrs']['file']['stat']['structure']['A0MechFactory']=$sys['nrs']['base']['structure']['A0CyborgFactory'];
$sys['nrs']['file']['stat']['structure']['A0MechFactory']['productionPoints']=40*$sys['nrs']['powerunit'];
$sys['nrs']['file']['stat']['structure']['A0MechFactory']['name']='Mech factory';
$sys['nrs']['file']['stat']['structure']['A0MechFactory']["buildPoints"]=125;
$sys['nrs']['file']['stat']['structure']['A0MechFactory']["buildPower"]=$sys['nrs']['unitprice']*2*4;
$sys['nrs']['file']['stat']['structure']['A0MechFactory']["hitpoints"]=125*20*$sys['nrs']['structureHPScale'];

//$sys['nrs']['file']['stat']['structure']['A0LightFactory']['productionPoints']=8;

// buildings
$t1['id']='building2';
$t2['id']=$t1['id'];
$t1=$sys['nrs']['file']['stat']['features'][$t1['id']];
$t2["type"]=  "DEFENSE";
$t2['name']='building2';							
$t2["buildPower"]=120;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;


$t2['id']='cabin';
$t2['name']='cabin';							
$t2["buildPoints"]=100;
$t2["buildPower"]=50;
$t2["buildPoints"]=2*$t2["buildPower"];
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
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
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=$t1['model'];
$t2["width"]= $t1['width'];
$t2["breadth"]= $t1['breadth'];
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;


$t2['id']='road';
$t2['name']='road';		
$t2["buildPoints"]=20;
$t2["buildPower"]=10;
$t2["hitpoints"]=1.5*$t2["buildPower"]*$ecoscale*$sys['nrs']['structureHPScale'];
$t2["resistance"]= 150;
$t2["structureModel"]=['blvtolpd.pie'];
$t2["width"]= 1;
$t2["breadth"]= 1;
$t2["type"]=  "REARM PAD";
$sys['nrs']['nrs']['structure'][$t2['id']]=$t2;


$sys['nrs']['2120']['structure']['A0ResearchFacility']['name']="x3 research lab";
$sys['nrs']['2120']['structure']['A0ResearchFacility']['buildPower']=300*$sys['nrs']['powerunit'];
$sys['nrs']['2120']['structure']['A0ResearchFacility']['researchPoints']=14*3;
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-2120']=$sys['nrs']['2120']['structure']['A0ResearchFacility'];
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-2120']['id']='A0ResearchFacility-2120';
$sys['nrs']['file']['stat']['structure']['A0ResearchFacility-nrs']['structureModel']=['nanolab.pie'];






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


