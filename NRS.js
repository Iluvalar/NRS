//nrs stuff
	var culture=[0,0,0,0,0,0,0,0,0,0];
	var honor=[0,0,0,0,0,0,0,0,0,0];
	var banks=[0,0,0,0,0,0,0,0,0,0];
	var powerGen=[0,0,0,0,0,0,0,0,0,0];
	var restInc=[0,0,0,0,0,0,0,0,0,0];
	
	//var resources=[0,0,0,0,0,0,0,0,0,0];
	var resourcesNames=['W','S','E','P','Hi','$','Env','war','food','cash'];
	var resourcesNames2=['Work','Service','Electric','Pop','density','rich','environement','F','P','B','C'];
	var totHonor=0;
	//var powerLast=[0,0,0,0,0,0,0,0];
	var totIncome=0;
	var tick=0;
	var structureData = {
	//--NRSstructureData
	};
	setTimer("powerStuff", 5000);
	setTimer("powerStuffAnim", 500);
	// POWER STUFF
	for (var playnum = 0; playnum < maxPlayers; playnum++){
		setPower(27*7*3, playnum);
		makeComponentAvailable("CyborgLegs", playnum);
		makeComponentAvailable("CyborgLightBody", playnum);
		makeComponentAvailable("CyborgHeavyBody", playnum);
		makeComponentAvailable("CyborgHeavyBody-2120", playnum);
		//addSpotter(128, 128, playnum, 500, 1, 300);
		//hackAddMessage("brief1-2", RES_MSG, playnum, true);
		//$fac='start';
	}
	//var powertypefact=2**(powerType-0.5);
	var powertypefact=1;

function sumArray(a, b) {
      var c = [];
      for (var i = 0; i < Math.max(a.length, b.length); i++) {
        c.push((a[i] || 0) + (b[i] || 0));
      }
      return c;
}
	
function powerStuffAnim(){
	for (var playnum = 0; playnum < maxPlayers; playnum++){
		pow=playerPower(playnum);
		pow+=powerGen[playnum];
		if(pow>400000){ pow=400000; }
		if(pow<0){ pow=0; }
		setPower(pow, playnum);
		
	}
}
function powerStuff(){
	tick++;
	//var interest=0.023696500687;
	//var interest=0.006;
	//var interest=0.00694;
	var conDeb="";
	var dumpText="";
	//var interest=.0088451341778;
	//--NRSInterest
	//var oilpf=4;
	//var bankval=22.5*oilpf;
	//var basepower=16958;
	//--NRSbasepower
	//var powerunit=10;

	//bankval=412;
	var resources = Array.from(Array(11), () => new Array(12))
	//var resources = new Array(11).fill(new Array(11));
	var derrick=0;
	var basePow=0;
	var honorPow=0;
	var resPow=0;
	var greenPow=0;
	var propPow=0;
	var serPow=0;
	var cultPow=0;
	var energyPow=0;
	var energy2Pow=0;
	var playPow=0;
	//var totpropPow=0.001; //prop
	var tothonorPow=0;
	var totcultPow=0; //forest
	var totserPow=0; //services
	var totworkPow=0; //electronics
	var totresPow=0; //residence
	var totenergyPow=0; //residence
	var totHonor=1;
	var nbank=0;
	var ncult=0;
	var richestPlayer=0;
	var richestValue=-100000;
	var cultPlayer=0;
	var cultValue=-100000;
	var honorPlayer=0;
	var honorValue=-100000;
	var income=0;
	var thisincome=0;
	//var powProp=-powerType*basepower/2;
	//var	totpropPow=powProp;
	var	totpropPow=0;
	var	aiprop=0;
	var	npow=0;
	var	nbase=0;
	var	ndiff=0;
	
	var factories=0;
	var droids =0;
	//var basebank=1+getMultiTechLevel()
	var basebank=5-getMultiTechLevel();
	//var techLevel = getMultiTechLevel();
	//var list = enumStruct([player[, structure type[, looking player]]]);
	for (var j = 0; j < 10; j++){
		resources[0][j]=-(2-powerType)*basepower/5;
	}
	var startprop=(resources[0][0] || 0)+(resources[0][3] || 0)-(resources[0][2] || 0);
	for (var playnum = 0; playnum < maxPlayers; playnum++){
		var list;
		list = enumStruct(playnum);
		if (list){
			for (var i = 0; i <list.length; ++i) {
				//dumpText+=i +" "+ list[i].name +"="+ list[i].cost +" is"+ list[i].status;
				var data=structureData[list[i].name];
				if(data){
					var p=list[i].player+1;
					dumpText+=i +" FOD "+ list[i].name +"="+ list[i].cost +" is"+ list[i].status +" p:"+ list[i].player  +" #"+ p +" "+ list[i];
					for (var j = 0; j < 10; j++){
						//resources[0][j]+=data[j+1]*list[i].cost;
						//resources[0][j]+=data[j+1];
						//resources[0][j]+=1;
						if(list[i].status){
							var factor=resources[p][11]/100;
							if(structureIdle(list[i])){
								factor-=resources[p][10]/100;
							}
							var add=0;
							if(data[j]>0){
								//resources[list[i].player+1][j]+=data[j+1];
								//resources[0][j]=parseInt(resources[0][j])+data[j+1]*parseInt(list[i].cost);
								add=data[j]/100*list[i].cost;
								resources[p][j]=(resources[p][j] || 0)+add;
								nbase+=add;
							}
							if(data[j]<0){
								//add=data[j+1]/data[0]*list[i].cost*1.25;
								add=data[j]/100*list[i].cost;
							}
						
						
							resources[0][j]=(resources[0][j] || 0)+add;
						}
						//resources[1][j]+=data[j+1]/data[0]*list[i].cost;
					}
				}
				
			}
		}
		nbank=getMultiTechLevel()+countStruct("A2CommandCentre", playnum);
		totpropPow-=countStruct("A1CommandCentre", playnum)*2500
		//console("2player:"+ playnum +"=="+ totPow +" house:"+ countStruct("Housing-nrs", playnum));
		if(nbank>banks[playnum]){
			//playPow+=(nbank-banks[playnum])*basepower/5;
			setPower(playerPower(playnum)+(nbank-banks[playnum])*basepower/5, playnum);
			banks[playnum]=nbank;
			//culture[playnum]*=.9;
		}
		var powtoadd=playerPower(playnum)-basepower/5;
		resources[playnum][9]+=powtoadd;
		resources[0][9]+=powtoadd;
		nbase+=powtoadd;
	}
	resources[0][2]+=(1-powerType)*3*basepower/5;
	
	//var playnum0;
	//console("interest:"+ interest);
	for (var playnum = 0; playnum < maxPlayers; playnum++){
		//resources[0]=sumArray(resources[0],structureData['Ruin1']);
		//npow+=playerPower(playnum);
		ncult+=culture[playnum];
		totHonor+=honor[playnum];
		/*
		cultPow=0;
		serPow=0;
		workPow=0;
		energyPow=0;
		resPow=0;
		energyPow+=countStruct("A0ResourceExtractor", playnum)*(40*1.75);		
		cultPow+=countStruct("Park-nrs", playnum)*500*1.0431407391498;
		cultPow+=countStruct("Boulder1-nrs", playnum)*500*1.0894264832732;
		cultPow+=countStruct("Forest-nrs", playnum)*750*1.1382855066803;
		cultPow+=countStruct("Boulder2-nrs", playnum)*500*1.189691570555;
		cultPow+=countStruct("arizonabush3-nrs", playnum)*500*1.2436974342886;
		cultPow+=countStruct("Boulder3-nrs", playnum)*1000*1.3003878034908;
		cultPow+=countStruct("Tree-nrs", playnum)*200*1.3598655493809;
		cultPow+=countStruct("BigForest-nrs", playnum)*1000*1.4222463190062;
		resPow+=countStruct("Ruin1-nrs", playnum)*300*1.0381651419658;
		resPow+=countStruct("BarbHUT-nrs", playnum)*300*1.078914494226;
		resPow+=countStruct("cabin-nrs", playnum)*500*1.1217173187994;
		resPow+=countStruct("building10-nrs", playnum)*600*1.1665275994974;
		resPow+=countStruct("LogCabin3-nrs", playnum)*300*1.2133686975491;
		resPow+=countStruct("building12-nrs", playnum)*800*1.2622911687111;
		resPow+=countStruct("building11-nrs", playnum)*1000*1.3133603014221;
		resPow+=countStruct("building2-nrs", playnum)*1200*1.3666511660073;
		resPow+=countStruct("building3-nrs", playnum)*1200*1.4222463190062;
		serPow+=countStruct("BarbWarehouse1-nrs", playnum)*1000*1.0582745027308;
		serPow+=countStruct("road-nrs", playnum)*100*1.1217173187994;
		serPow+=countStruct("Pickup-nrs", playnum)*500*1.189691570555;
		serPow+=countStruct("BarbWarehouse3-nrs", playnum)*1000*1.2622911687111;
		serPow+=countStruct("BarbWarehouse2-nrs", playnum)*1000*1.3397230157169;
		serPow+=countStruct("WaterTower-nrs", playnum)*500*1.4222463190062;
		workPow+=countStruct("AirTrafficControl-nrs", playnum)*300*1.0495892697146;
		workPow+=countStruct("OilTower-nrs", playnum)*1000*1.1031272262422;
		workPow+=countStruct("Propaganda-nrs", playnum)*1500*1.1600027242233;
		workPow+=countStruct("Advmaterialslab-nrs", playnum)*1000*1.2202287957939;
		workPow+=countStruct("Aerodynamicslab-nrs", playnum)*1000*1.2839108970143;
		workPow+=countStruct("Rotarywepslab-nrs", playnum)*1200*1.3511938092843;
		workPow+=countStruct("Heavywepslab-nrs", playnum)*1200*1.4222463190062;
		energyPow+=countStruct("NuclearReactor", playnum)*1000*1.0582745027308;
		energyPow+=countStruct("CoolingTower", playnum)*750*1.1217173187994;
		energyPow+=countStruct("SolarPower-nrs", playnum)*1000*1.189691570555;
		energyPow+=countStruct("Powlab-nrs", playnum)*1000*1.2622911687111;
		//energyPow+=countStruct("A0PowerGenerator", playnum)*500*Upgrades[playnum]["Building"]["Power Generator"]["Power Generator"];
		//energyPow+=countStruct("A0BaBaPowerGenerator", playnum)*2000*Upgrades[playnum]["Building"]["Scavenger Power Generator"]["PowerPoints"];
		energyPow+=countStruct("A0PowerGenerator", playnum)*500;
		energyPow+=countStruct("A0BaBaPowerGenerator", playnum)*2000;
		energyPow+=countStruct("A0ResourceExtractor", playnum)*400*1.75;
		*/
		honorPow+=countStruct("A3CommandCentre", playnum)*500*1;
		//honorPow-=countStruct("A1CommandCentre", playnum)*500*1;
		
		/*
		totcultPow+=countStruct("Park-nrs", playnum)*50*1.1*1.0431407391498;
		totcultPow+=countStruct("Boulder1-nrs", playnum)*50*1.1*1.0894264832732;
		totcultPow+=countStruct("Forest-nrs", playnum)*75*1.1*1.1382855066803;
		totcultPow+=countStruct("Boulder2-nrs", playnum)*50*1.1*1.189691570555;
		totcultPow+=countStruct("arizonabush3-nrs", playnum)*50*1.1*1.2436974342886;
		totcultPow+=countStruct("Boulder3-nrs", playnum)*100*1.1*1.3003878034908;
		totcultPow+=countStruct("Tree-nrs", playnum)*20*1.1*1.3598655493809;
		totcultPow+=countStruct("BigForest-nrs", playnum)*100*1.1*1.4222463190062;
		totresPow+=countStruct("Ruin1-nrs", playnum)*30*1.1*1.0381651419658;
		totresPow+=countStruct("BarbHUT-nrs", playnum)*30*1.1*1.078914494226;
		totresPow+=countStruct("cabin-nrs", playnum)*50*1.1*1.1217173187994;
		totresPow+=countStruct("building10-nrs", playnum)*60*1.1*1.1665275994974;
		totresPow+=countStruct("LogCabin3-nrs", playnum)*30*1.1*1.2133686975491;
		totresPow+=countStruct("building12-nrs", playnum)*80*1.1*1.2622911687111;
		totresPow+=countStruct("building11-nrs", playnum)*100*1.1*1.3133603014221;
		totresPow+=countStruct("building2-nrs", playnum)*120*1.1*1.3666511660073;
		totresPow+=countStruct("building3-nrs", playnum)*120*1.1*1.4222463190062;
		totserPow+=countStruct("BarbWarehouse1-nrs", playnum)*100*1.1*1.0431407391498;
		totserPow+=countStruct("road-nrs", playnum)*10*1.1*1.0894264832732;
		//totserPow+=countStruct("OilDrum-nrs", playnum)*50*1.1*1.1382855066803;
		totserPow+=countStruct("Pickup-nrs", playnum)*50*1.1*1.189691570555;
		totserPow+=countStruct("BarbWarehouse3-nrs", playnum)*100*1.1*1.2436974342886;
		//totserPow+=countStruct("Crate-nrs", playnum)*50*1.1*1.3003878034908;
		totserPow+=countStruct("BarbWarehouse2-nrs", playnum)*100*1.1*1.3598655493809;
		totserPow+=countStruct("WaterTower-nrs", playnum)*50*1.1*1.4222463190062;
		totworkPow+=countStruct("AirTrafficControl-nrs", playnum)*30*1.1*1.0495892697146;
		totworkPow+=countStruct("OilTower-nrs", playnum)*100*1.1*1.1031272262422;
		totworkPow+=countStruct("Propaganda-nrs", playnum)*150*1.1*1.1600027242233;
		totworkPow+=countStruct("Advmaterialslab-nrs", playnum)*100*1.1*1.2202287957939;
		totworkPow+=countStruct("Aerodynamicslab-nrs", playnum)*100*1.1*1.2839108970143;
		totworkPow+=countStruct("Rotarywepslab-nrs", playnum)*120*1.1*1.3511938092843;
		totworkPow+=countStruct("Heavywepslab-nrs", playnum)*120*1.1*1.4222463190062;
		totenergyPow+=countStruct("NuclearReactor", playnum)*100*1.1*1.0582745027308;
		totenergyPow+=countStruct("CoolingTower", playnum)*75*1.1*1.1217173187994;
		totenergyPow+=countStruct("SolarPower-nrs", playnum)*100*1.1*1.189691570555;
		totenergyPow+=countStruct("Powlab-nrs", playnum)*100*1.1*1.2622911687111;
		/*
		totcultPow+=countStruct("Park-nrs", playnum)*50*1.1*1.0894264832732;
		totcultPow+=countStruct("Forest-nrs", playnum)*75*1.1*1.189691570555;
		totcultPow+=countStruct("Tree-nrs", playnum)*20*1.1*1.3003878034908;
		totcultPow+=countStruct("BigForest-nrs", playnum)*100*1.1*1.4222463190062;
		totenergyPow+=countStruct("NuclearReactor", playnum)*100*1.1*1.078914494226;
		totenergyPow+=countStruct("SolarPower-nrs", playnum)*100*1.1*1.1665275994974;
		totenergyPow+=countStruct("Powlab-nrs", playnum)*100*1.1*1.2622911687111;
		totpropPow+=countStruct("Propaganda-nrs", playnum)*150*1.1*1.0894264832732;
		totpropPow+=countStruct("WaterTower-nrs", playnum)*50*1.1*1.189691570555;
		totpropPow+=countStruct("OilTower-nrs", playnum)*100*1.1*1.3003878034908;
		totpropPow+=countStruct("AirTrafficControl-nrs", playnum)*30*1.1*1.4222463190062;
		totresPow+=countStruct("Ruin1-nrs", playnum)*30*1.1*1.0381651419658;
		totresPow+=countStruct("BarbHUT-nrs", playnum)*30*1.1*1.078914494226;
		totresPow+=countStruct("cabin-nrs", playnum)*50*1.1*1.1217173187994;
		totresPow+=countStruct("building10-nrs", playnum)*60*1.1*1.1665275994974;
		totresPow+=countStruct("LogCabin3-nrs", playnum)*30*1.1*1.2133686975491;
		totresPow+=countStruct("building12-nrs", playnum)*80*1.1*1.2622911687111;
		totresPow+=countStruct("building11-nrs", playnum)*100*1.1*1.3133603014221;
		totresPow+=countStruct("building2-nrs", playnum)*120*1.1*1.3666511660073;
		totresPow+=countStruct("building3-nrs", playnum)*120*1.1*1.4222463190062;
		totserPow+=countStruct("BarbWarehouse1-nrs", playnum)*100*1.1*1.0894264832732;
		totserPow+=countStruct("road-nrs", playnum)*10*1.1*1.3003878034908;
		totserPow+=countStruct("BarbWarehouse3-nrs", playnum)*100*1.1*1.4222463190062;
		totserPow+=countStruct("BarbWarehouse2-nrs", playnum)*100*1.1*1.5562301097509;
		totworkPow+=countStruct("Advmaterialslab-nrs", playnum)*100*1.1*1.0582745027308;
		totworkPow+=countStruct("Aerodynamicslab-nrs", playnum)*100*1.1*1.1217173187994;
		totworkPow+=countStruct("Rotarywepslab-nrs", playnum)*120*1.1*1.2254018358465;
		totworkPow+=countStruct("Heavywepslab-nrs", playnum)*120*1.1*1.3397230157169;
		*/
		/*
		totcultPow+=countStruct("Park-nrs", playnum)*50*1.1*1.0894264832732;
		totcultPow+=countStruct("Forest-nrs", playnum)*75*1.1*1.189691570555;
		totcultPow+=countStruct("Tree-nrs", playnum)*20*1.1*1.3003878034908;
		totcultPow+=countStruct("BigForest-nrs", playnum)*100*1.1*1.4222463190062;
		nder+=countStruct("NuclearReactor", playnum)*100*1.1*1.0461429639986;
		nder+=countStruct("SolarPower-nrs", playnum)*100*1.1*1.0957943033921;
		totworkPow+=countStruct("Powlab-nrs", playnum)*100*1.1*1.1483619246521;
		totworkPow+=countStruct("Advmaterialslab-nrs", playnum)*100*1.1*1.2038358438532;
		totworkPow+=countStruct("Aerodynamicslab-nrs", playnum)*100*1.1*1.2622911687111;
		totpropPow+=countStruct("Propaganda-nrs", playnum)*150*1.1*1.0705965291054;
		totpropPow+=countStruct("WaterTower-nrs", playnum)*50*1.1*1.1483619246521;
		totpropPow+=countStruct("OilTower-nrs", playnum)*100*1.1*1.2326845235587;
		totpropPow+=countStruct("AirTrafficControl-nrs", playnum)*30*1.1*1.3238381921874;
		//totpropPow+=countStruct("WreckedTransporter", playnum)*150*1.1*1.4222463190062;
		totresPow+=countStruct("Ruin1-nrs", playnum)*30*1.1*1.0381651419658;
		totresPow+=countStruct("BarbHUT-nrs", playnum)*30*1.1*1.078914494226;
		totresPow+=countStruct("cabin-nrs", playnum)*50*1.1*1.1217173187994;
		totresPow+=countStruct("building10-nrs", playnum)*60*1.1*1.1665275994974;
		totresPow+=countStruct("LogCabin3-nrs", playnum)*30*1.1*1.2133686975491;
		totresPow+=countStruct("building12-nrs", playnum)*80*1.1*1.2622911687111;
		totresPow+=countStruct("building11-nrs", playnum)*100*1.1*1.3133603014221;
		totresPow+=countStruct("building2-nrs", playnum)*120*1.1*1.3666511660073;
		totresPow+=countStruct("building3-nrs", playnum)*120*1.1*1.4222463190062;
		totserPow+=countStruct("BarbWarehouse1-nrs", playnum)*100*1.1*1.0705965291054;
		totserPow+=countStruct("BarbWarehouse2-nrs", playnum)*100*1.1*1.1483619246521;
		totserPow+=countStruct("BarbWarehouse3-nrs", playnum)*100*1.1*1.2326845235587;
		totserPow+=countStruct("Rotarywepslab-nrs", playnum)*120*1.1*1.3238381921874;
		totserPow+=countStruct("Heavywepslab-nrs", playnum)*120*1.1*1.4222463190062;
		totserPow+=countStruct("road-nrs", playnum)*10*1.1*1;
		*/
		/*
		totenergyPow+=energyPow;
		totcultPow+=cultPow;
		totresPow+=resPow;
		totserPow+=serPow;
		totworkPow+=workPow;
		tothonorPow+=honorPow;
		*/
		if(playerData[playnum].difficulty>0){
			ndiff+=playerData[playnum].difficulty;
			//aiprop+=playerData[playnum].difficulty*basepower;
		}
		//totresPow+=250; //one by player
		//totserPow+=200; //one by player line #108
		
		
	}
	totpropPow+=aiprop;
	//totpropPow+=totworkPow*.5+totresPow*.3+totcultPow*.2-totserPow*.4;
	
	//totpropPow+=resources[0][0]+resources[0][1]+resources[0][3]-resources[0][2]+npow;
	totpropPow+=-startprop+(resources[0][0] || 0)+(resources[0][3] || 0)-(resources[0][2] || 0)+npow;
	//nbase=totworkPow+ncult+totresPow+totserPow+totenergyPow;
	//nbase+=basebank*basepower/5*maxPlayers;
	nbase+=basepower*maxPlayers;
	for (var playnum = 0; playnum < maxPlayers; playnum++){
		//console("1player:"+ playnum +"=="+ totPow +" house:"+ countStruct("Housing-nrs", playnum));
		factories = countStruct("A0LightFactory", playnum) + countStruct("A0CyborgFactory", playnum); // nope
		droids = countDroid(DROID_ANY, playnum);
		if (droids == 0 && factories == 0)
		{
			setPower(0, playnum);
			continue;
		}
		//playPow=playerPower(playnum);	
		playPow=0;
		//extraPowerTime(5000, playnum);
		//var powproduced=Upgrades[playnum]["Building"]["Scavenger Power Generator"]["PowerPoints"];
		//var powproduced="";
		//for (var cname in Upgrades[player][v['class']]) 
		//for (var cname in Stats["Building"]["Scavenger Power Generator"]){
		//	dumpText+=cname +","+ Upgrades[playnum]["Building"]["Scavenger Power Generator"][cname] +"00";
		//}
		//powerLast[playnum]=playPow;
		
		//basePow=(3+getMultiTechLevel()*2-banks[playnum])*basepower/5;
		basePow=0;
		/*
		cultPow=0;
		serPow=0;
		workPow=0;
		energyPow=0;
		energy2Pow=0;
		resPow=0;
		*/
		income=0;
		/*	else if (powerType == 2)
	{
		setPowerModifier(125, player);
	}

	// insane difficulty is meant to be insane...
	if (playerData[player].difficulty == INSANE)*/
		//derrick=0;
		//nbank=countStruct("A2CommandCentre", playnum);
		/*
		nbank=getMultiTechLevel()+countStruct("A2CommandCentre", playnum);
		//console("2player:"+ playnum +"=="+ totPow +" house:"+ countStruct("Housing-nrs", playnum));
		if(nbank>banks[playnum]){
			playPow+=(nbank-banks[playnum])*basepower/5;
			setPower(playPow, playnum);
			banks[playnum]=nbank;
			culture[playnum]*=.9;
		}
		*/
		//playPow+=(basebank-banks[playnum]-getMultiTechLevel())*basepower/5;
		playPow+=(basebank-banks[playnum]+getMultiTechLevel())*basepower/5;
		//console("3player:"+ playnum +"=="+ totPow +" house:"+ countStruct("Housing-nrs", playnum));
		
		/*
		cultPow+=countStruct("Park-nrs", playnum)*50*1.1*1.0431407391498;
		cultPow+=countStruct("Boulder1-nrs", playnum)*50*1.1*1.0894264832732;
		cultPow+=countStruct("Forest-nrs", playnum)*75*1.1*1.1382855066803;
		cultPow+=countStruct("Boulder2-nrs", playnum)*50*1.1*1.189691570555;
		cultPow+=countStruct("arizonabush3-nrs", playnum)*50*1.1*1.2436974342886;
		cultPow+=countStruct("Boulder3-nrs", playnum)*100*1.1*1.3003878034908;
		cultPow+=countStruct("Tree-nrs", playnum)*20*1.1*1.3598655493809;
		cultPow+=countStruct("BigForest-nrs", playnum)*100*1.1*1.4222463190062;
		resPow+=countStruct("Ruin1-nrs", playnum)*30*1.1*1.0381651419658;
		resPow+=countStruct("BarbHUT-nrs", playnum)*30*1.1*1.078914494226;
		resPow+=countStruct("cabin-nrs", playnum)*50*1.1*1.1217173187994;
		resPow+=countStruct("building10-nrs", playnum)*60*1.1*1.1665275994974;
		resPow+=countStruct("LogCabin3-nrs", playnum)*30*1.1*1.2133686975491;
		resPow+=countStruct("building12-nrs", playnum)*80*1.1*1.2622911687111;
		resPow+=countStruct("building11-nrs", playnum)*100*1.1*1.3133603014221;
		resPow+=countStruct("building2-nrs", playnum)*120*1.1*1.3666511660073;
		resPow+=countStruct("building3-nrs", playnum)*120*1.1*1.4222463190062;
		serPow+=countStruct("BarbWarehouse1-nrs", playnum)*100*1.1*1.0431407391498;
		serPow+=countStruct("road-nrs", playnum)*10*1.1*1.0894264832732;
		//serPow+=countStruct("OilDrum-nrs", playnum)*50*1.1*1.1382855066803;
		serPow+=countStruct("Pickup-nrs", playnum)*50*1.1*1.189691570555;
		serPow+=countStruct("BarbWarehouse3-nrs", playnum)*100*1.1*1.2436974342886;
		//serPow+=countStruct("Crate-nrs", playnum)*50*1.1*1.3003878034908;
		serPow+=countStruct("BarbWarehouse2-nrs", playnum)*100*1.1*1.3598655493809;
		serPow+=countStruct("WaterTower-nrs", playnum)*50*1.1*1.4222463190062;
		workPow+=countStruct("AirTrafficControl-nrs", playnum)*30*1.1*1.0495892697146;
		workPow+=countStruct("OilTower-nrs", playnum)*100*1.1*1.1031272262422;
		workPow+=countStruct("Propaganda-nrs", playnum)*150*1.1*1.1600027242233;
		workPow+=countStruct("Advmaterialslab-nrs", playnum)*100*1.1*1.2202287957939;
		workPow+=countStruct("Aerodynamicslab-nrs", playnum)*100*1.1*1.2839108970143;
		workPow+=countStruct("Rotarywepslab-nrs", playnum)*120*1.1*1.3511938092843;
		workPow+=countStruct("Heavywepslab-nrs", playnum)*120*1.1*1.4222463190062;
		energyPow+=countStruct("NuclearReactor", playnum)*100*1.1*1.0582745027308;
		energyPow+=countStruct("CoolingTower", playnum)*75*1.1*1.1217173187994;
		energyPow+=countStruct("SolarPower-nrs", playnum)*100*1.1*1.189691570555;
		energyPow+=countStruct("Powlab-nrs", playnum)*100*1.1*1.2622911687111;
		energyPow+=countStruct("A0ResourceExtractor", playnum)*40*1.75;	
		//basePow+=serPow*totresPow/totserPow;
		basePow+=culture[playnum]/1.1**((totworkPow+totpropPow-ncult)/basepower); //forest suffer from work & propaganda
		basePow+=serPow*1.1**((totresPow-totserPow)/basepower-ndiff/8); //services benefit from housing
		basePow+=resPow*1.05**((totserPow-totresPow)/basepower); //housing benefit from services but less
		basePow+=workPow*1.1**((ncult-totworkPow)/basepower-.5); //work benefit from forest
		basePow+=propPow*1.1**((totenergyPow+totserPow+ncult-totpropPow)/basepower-2); //propaganda benefit from derrick & service & cult But start bad.
		basePow+=energyPow/1.1**((totworkPow+totresPow)/basepower); //energy suffer from work
		*/
/*
		cultPow+=countStruct("Park-nrs", playnum)*500*1.0431407391498;
		cultPow+=countStruct("Boulder1-nrs", playnum)*500*1.0894264832732;
		cultPow+=countStruct("Forest-nrs", playnum)*750*1.1382855066803;
		cultPow+=countStruct("Boulder2-nrs", playnum)*500*1.189691570555;
		cultPow+=countStruct("arizonabush3-nrs", playnum)*500*1.2436974342886;
		cultPow+=countStruct("Boulder3-nrs", playnum)*1000*1.3003878034908;
		cultPow+=countStruct("Tree-nrs", playnum)*200*1.3598655493809;
		cultPow+=countStruct("BigForest-nrs", playnum)*1000*1.4222463190062;
		resPow+=countStruct("Ruin1-nrs", playnum)*300*1.0381651419658;
		resPow+=countStruct("BarbHUT-nrs", playnum)*300*1.078914494226;
		resPow+=countStruct("cabin-nrs", playnum)*500*1.1217173187994;
		resPow+=countStruct("building10-nrs", playnum)*600*1.1665275994974;
		resPow+=countStruct("LogCabin3-nrs", playnum)*300*1.2133686975491;
		resPow+=countStruct("building12-nrs", playnum)*800*1.2622911687111;
		resPow+=countStruct("building11-nrs", playnum)*1000*1.3133603014221;
		resPow+=countStruct("building2-nrs", playnum)*1200*1.3666511660073;
		resPow+=countStruct("building3-nrs", playnum)*1200*1.4222463190062;
		serPow+=countStruct("BarbWarehouse1-nrs", playnum)*1000*1.0582745027308;
		serPow+=countStruct("road-nrs", playnum)*100*1.1217173187994;
		serPow+=countStruct("Pickup-nrs", playnum)*500*1.189691570555;
		serPow+=countStruct("BarbWarehouse3-nrs", playnum)*1000*1.2622911687111;
		serPow+=countStruct("BarbWarehouse2-nrs", playnum)*1000*1.3397230157169;
		serPow+=countStruct("WaterTower-nrs", playnum)*500*1.4222463190062;
		workPow+=countStruct("AirTrafficControl-nrs", playnum)*300*1.0495892697146;
		workPow+=countStruct("OilTower-nrs", playnum)*1000*1.1031272262422;
		workPow+=countStruct("Propaganda-nrs", playnum)*1500*1.1600027242233;
		workPow+=countStruct("Advmaterialslab-nrs", playnum)*1000*1.2202287957939;
		workPow+=countStruct("Aerodynamicslab-nrs", playnum)*1000*1.2839108970143;
		workPow+=countStruct("Rotarywepslab-nrs", playnum)*1200*1.3511938092843;
		workPow+=countStruct("Heavywepslab-nrs", playnum)*1200*1.4222463190062;
		

		energyPow+=countStruct("NuclearReactor", playnum)*1000*1.0582745027308;
		energyPow+=countStruct("CoolingTower", playnum)*750*1.1217173187994;
		energyPow+=countStruct("SolarPower-nrs", playnum)*1000*1.189691570555;
		energyPow+=countStruct("Powlab-nrs", playnum)*1000*1.2622911687111;
		energy2Pow+=countStruct("A0PowerGenerator", playnum)*500;
		energy2Pow+=countStruct("A0BaBaPowerGenerator", playnum)*2000;
		energyPow+=countStruct("A0ResourceExtractor", playnum)*400*1.75;
		energyPow+=energy2Pow;
		energy2Pow+=cultPow;
		*/
		honorPow+=countStruct("A3CommandCentre", playnum)*500*1;
		honorPow-=countStruct("A1CommandCentre", playnum)*500*1;
		/*
		basePow+=culture[playnum]/1.1**((totworkPow+totpropPow-ncult)/basepower); //forest suffer from work & propaganda
		basePow+=serPow*1.1**((totresPow-totserPow)/basepower-ndiff/8); //services benefit from housing
		basePow+=resPow*1.05**((totserPow-totresPow)/basepower); //housing benefit from services but less
		basePow+=workPow*1.1**((ncult-totworkPow)/basepower-.5); //work benefit from forest
		basePow+=propPow*1.1**((totenergyPow+totserPow+ncult-totpropPow)/basepower-2); //propaganda benefit from derrick & service & cult But start bad.
		basePow+=energyPow/1.1**((totworkPow+totresPow)/basepower); //energy suffer from work
		*/
		//basePow+=resPow*1.1**((totcultPow+totserPow*2-totresPow*2.5)/basepower);
		//basePow+=cultPow*1.1**((totserPow+totenergyPow*2-totcultPow*2.5)/basepower-maxPlayers);
		//basePow+=totserPow*1.1**((totenergyPow+totworkPow*2-totserPow*2.5)/basepower-maxPlayers/2);
		//basePow+=totenergyPow*1.1**((totworkPow+totresPow*2-totenergyPow*2.5)/basepower);
		//basePow+=totworkPow*1.1**((totresPow+totcultPow*2-totworkPow*2.5)/basepower);
		//basePow+=resPow*1.1**((totcultPow+totserPow*2-totresPow*2)/basepower);
		//basePow+=resPow*1.1**((totcultPow+totserPow*2-totresPow*2)/basepower);
		//basePow+=resPow*1.1**((totcultPow+totserPow*2-totresPow*2)/basepower);
		//basePow+=derrick*(50*1.75+powerType*20+playerData[playnum].difficulty*35);
		//basePow+=derrick*(50*1.75)/1.1**((totcultPow+totresPow)/basepower);
		
		//basePow-=(totcultPow+totresPow)/(7*5*maxPlayers)*derrick; //derrick suffers from forest and housing
		//basePow+=propPow*.75;
		//basePow+=serPow;
		
		//cultPow/=1.1**(totworkPow/basepower-1);
		//basePow-=totpropPow*150*1.1*1.1399*2;
		//basePow+=totresPow/(1000*maxPlayers);

		//basePow+=(5*bankval/oilpf+50)*derrick;
		
		//basePow+=nbank*bankval*1.1;
		var p=playnum+1;
		for (var j = 0; j < 10; j++){
			if((resources[p][j] || 0)>0){
				basePow+=resources[p][j]/1.1**((resources[0][j] || 0)/(basepower/5));
			}
		}
		
		if(richestValue<(basePow+playPow) && playnum != maxPlayers){
			richestValue=(basePow+playPow);
			richestPlayer=playnum;
		}
		if(cultValue<culture[playnum]){
			cultValue=culture[playnum];
			cultPlayer=playnum;
		}
		if(honorValue<honor[playnum]){
			honorValue=honor[playnum];
			honorPlayer=playnum;
		}
		var fractprop=2**((totpropPow)/(basepower*(1.25-1)*maxPlayers));
		//if(totpropPow!=0){
		//	totPow+=totIncome*(1-(1/fractprop))*propPow/(totpropPow)/2;
		//}

		
		if(income*maxPlayers<totIncome/4){
			//basePow+=totIncome*(1-(1/fractprop))*.25/4;
		}
		//basePow/
		//var powProp=-powerType*basepower/2;
		//if(powerType==1){ powertypefact=15000; }
		//if(powerType==2){ powertypefact=25000; }
		//if(powerType==3){ powertypefact=45000; }
		//var badNamedVariable=basePow/interest;
		//var equity= .9*(((playPow+basePow)/(npow+nbase))**2);
		var equity=1*(((playPow+basePow)/(npow+nbase))**2);
		//dumpText+=".9*(("+ playPow +"+"+ basePow +")**3)/("+ npow +"+"+ nbase +")**3 ="+ equity;
		var founds=(npow-basebank*maxPlayers*basepower/5)/(30000*maxPlayers*powertypefact)+nbase/(30000*maxPlayers*powertypefact);
		var foundsFact=3**(founds);
		foundsFact=1;
		//var tax=(1-interest)**(founds-1);
		//var taxV2=(1-interest)**(npow/(25000*powertypefact)+thisincome/(25000*powertypefact*interest));
		//totPow*=tax;
		//income=(totPow*.9**((npow/basePow)/maxPlayers)+basePow)*interest;
		//income=(totPow+basePow)*tax*.9**((npow/basepower)/maxPlayers);
		/*
		var equityTax=equity*(playPow*.9+basePow-banks[playnum]*basepower/5);
		if(culture[playnum]>equityTax){ 
			culture[playnum]-=equityTax;
			equityTax=0;
		}
		else{
			equityTax-=culture[playnum];
			culture[playnum]=0;
		}
		*/
		//income=(playPow*.9+basePow-energy2Pow)*(interest)/foundsFact-equityTax;
		income=(playPow+basePow-energy2Pow)*(interest)*(1-equity)/foundsFact;
		//income=(basePow-energy2Pow-equityTax)*(interest)/foundsFact;
		//income=(totPow+basePow)*tax*.9**((npow/basePow)/maxPlayers);
		//income*=2**(aiprop/(basepower*maxPlayers/2));
		

		thisincome+=income;
		//income*=2**(powerType-1)/fractprop;
		income*=powertypefact/fractprop;
		//income*=powertypefact;
		
		if(playerData[playnum].difficulty>0){
			var aiFact=tothonorPow/(500)/(maxPlayers*4);
			var factordif=2**playerData[playnum].difficulty-.5;
			factordif=3.5;
			if(playerData[playnum].difficulty==1){ factordif=1.7+aiFact; }
			if(playerData[playnum].difficulty==2){ factordif=2.20+aiFact; }
			if(playerData[playnum].difficulty==3){ factordif=2.40+aiFact; }
			if(playerData[playnum].difficulty==4){ factordif=3+aiFact; }
			//propPow=playerData[playnum].difficulty*basepower;
			//income=income*(2**playerData[playnum].difficulty-1);
			income=income*factordif;
		}
		//var powerToSet=totPow+income-(basePow+totPow)*(1-tax);
		var cultureToSet=culture[playnum]+cultPow*interest;
		if(cultureToSet>100000){ income+=cultureToSet-100000; cultureToSet=100000; }
		culture[playnum]=cultureToSet;
		honor[playnum]+=(honorPow+( ndiff/maxPlayers-1.5)*500 )*5*1000;
		powerGen[playnum]= Math.floor(income/10+restInc[playnum]); //
		restInc[playnum]= Math.floor(income/10+restInc[playnum]-powerGen[playnum]*1000)/1000;
		//powerLast[playnum]+=income;
		var powMult=powertypefact/fractprop/foundsFact*(1-equity);
		if(powMult<0){ powMult=0; }
		setPowerModifier(powMult*100, playnum);
		
		//dumpText+=culture[playnum] +"/1.1**"+ totworkPow +"+"+ totpropPow +"-"+ ncult +"/basepower"; 

		setExperienceModifier(playnum, 1000*1.41**((totenergyPow-totserPow)/basepower));
		
		//setPower(2000, playnum);
		conDeb+=Math.ceil(equity*100) +",";
		//chat(playnum, "hi"+ playPow +"&"+ basePow +"&"+ resources[playnum] );
	}
	totIncome=thisincome;
	var conText="";
	//conDeb +="ndiff"+ ndiff;
	if(tick%3==0){
		conText+="richest"+  playerData[richestPlayer].name +"("+ richestPlayer +")@"+ Math.ceil(richestValue) +"$P cult:"+ playerData[cultPlayer].name +"("+ cultPlayer +")@"+ Math.ceil(cultValue) +" honor:"+ playerData[honorPlayer].name +"("+ honorPlayer +")@"+ Math.ceil(honorValue/gameTime);
		conText+=" propaganda:"+  Math.ceil(totpropPow)  +"("+  Math.ceil(1/fractprop*100) +"%) founds:"+ Math.ceil(1/foundsFact*100) +"% equ:"+ conDeb;
	}if(tick%3==1){
		if(tick==1){
			conText+=" Welcome to NRS";
		}else if(tick%12==4){
			//conText+=" Light outnumber Medium which outnumber Heavy which can't even feel Light";
		}else if(tick%12==7){
			conText+=" Structure <> Wheel , Track <> Personnal. H>L>M>H>L";
		}else{
			conText+=" Don't try anything ! This mod is made to be boring. Always Follow the rules !";
		}
		//conText+="bla"+ resources;
		//conText+=" R:"+   Math.ceil(totresPow) +" C:"+  Math.ceil(totcultPow)  +" S:"+ Math.ceil(totserPow) +" E:"+  Math.ceil(totenergyPow) +" W:"+  Math.ceil(totworkPowPow);
	}if(tick%3==2){
			//conText+="E W R:"+   Math.ceil(totresPow/basepower) +" C:"+  Math.ceil(totcultPow/basepower)  +" S:"+ Math.ceil(totserPow/basepower) +" E:"+  Math.ceil(totenergyPow/basepower-maxPlayers/2) +" W:"+  Math.ceil(totworkPow/basepower) +" R C";
			for (var j = 0; j < 10; j++){
				conText+=" "+  resourcesNames[j] +"="+   Math.ceil(resources[0][j]*10/(basepower/5));
			}

	}
	if(dumpText!=""){
		dump("--"+ dumpText);
	}
	console(conText);
}