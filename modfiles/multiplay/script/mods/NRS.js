//nrs stuff
	var culture=[0,0,0,0,0,0,0,0,0,0];
	var honor=[0,0,0,0,0,0,0,0,0,0];
	var banks=[0,0,0,0,0,0,0,0,0,0];
	var powerGen=[0,0,0,0,0,0,0,0,0,0];
	var restInc=[0,0,0,0,0,0,0,0,0,0];
	
	var resourcesNames=['W','S','E','P','Hi','$','Env','war','food','cash'];
	var resourcesNames2=['Work','Service','Electric','Pop','density','rich','environement','F','P','B','C'];
	var totHonor=0;
	var meantotHonor=0;
	//var powerLast=[0,0,0,0,0,0,0,0];
	var totIncome=0;
	var tick=0;
	var structureData = {
	
	"Oil Derrick":[0,20,60,-37,0,20,-74,0,0,0,0,130,],
	"Aerodynamicslab":[50,0,-110,0,0,0,25,25,0,0,0,147,],
	"Heavywepslab":[33,0,-110,0,0,0,16,50,0,0,0,139,],
	"Advmaterialslab":[100,0,-110,0,0,0,0,0,0,0,0,131,],
	"Rotarywepslab":[33,0,-55,0,0,0,-55,66,0,0,0,145,],
	"Powlab":[0,25,50,0,25,0,-37,-74,0,0,0,135,],
	"Solar panel":[-55,0,66,0,-55,0,33,0,0,0,0,136,],
	"*NuclearReactor*":[-37,0,50,0,25,0,25,-74,0,0,0,137,],
	"*CoolingTower*":[-37,50,50,0,0,0,0,-74,0,0,0,148,],
	"Propaganda Tower":[0,33,-37,0,-37,-37,0,66,0,0,0,133,],
	"Pickup":[0,66,0,33,-37,-37,-37,0,0,0,0,149,],
	"road":[0,75,0,0,-55,25,-55,0,0,0,0,132,],
	"BarbWarehouse2":[25,50,0,-55,25,0,-55,0,0,0,0,139,],
	"BarbWarehouse1":[50,50,-55,-55,0,0,0,0,0,0,0,133,],
	"BarbWarehouse3":[25,50,0,-55,0,25,-55,0,0,0,0,147,],
	"OilTower":[33,33,-44,0,0,33,-22,-44,0,0,0,140,],
	"WaterTower":[0,50,0,-110,0,0,50,0,0,0,0,141,],
	"AirTrafficControl":[0,33,-44,-44,0,33,-22,33,0,0,0,149,],
	"Ruin1":[-55,0,0,100,-28,-28,0,0,0,0,0,141,],
	"BarbHUT":[-28,-28,0,100,-28,-28,0,0,0,0,0,137,],
	"cabin":[0,-74,0,66,-37,33,0,0,0,0,0,142,],
	"LogCabin3":[-55,-55,0,33,0,66,0,0,0,0,0,143,],
	"building3":[-44,-44,0,100,0,-22,0,0,0,0,0,134,],
	"building2":[-55,-55,0,50,25,25,0,0,0,0,0,150,],
	"building11":[-44,-44,0,60,40,-22,0,0,0,0,0,144,],
	"building12":[-37,-37,0,40,40,20,-37,0,0,0,0,137,],
	"building10":[-37,-74,0,40,40,20,0,0,0,0,0,138,],
	"Park":[0,-37,0,-74,0,33,66,0,0,0,0,131,],
	"Forest":[0,0,0,-55,-55,0,100,0,0,0,0,145,],
	"Big Forest":[0,0,0,0,-110,0,100,0,0,0,0,146,],
	"Tree":[0,0,0,0,33,0,66,-110,0,0,0,132,],
	"Boulder3":[0,0,0,0,33,0,66,0,-110,0,0,151,],
	"Boulder2":[0,0,0,0,0,0,100,0,-110,0,0,147,],
	"Boulder1":[0,0,0,0,33,0,66,0,-110,0,0,138,],
	"arizonabush3":[0,33,0,-55,0,0,66,-55,0,0,0,151,],
	};
	setTimer("powerStuff", 5000);
	setTimer("powerStuffAnim", 500);
	// POWER STUFF
	for (var playnum = 0; playnum < maxPlayers; playnum++){
		setPower(27*7*3, playnum);		
		makeComponentAvailable("BaBaLegs", playnum);
		makeComponentAvailable("CyborgLegs", playnum);
		makeComponentAvailable("B1BaBaPerson01-nrs", playnum);
		makeComponentAvailable("CyborgLightBody", playnum);
		makeComponentAvailable("CyborgHeavyBody", playnum);
		makeComponentAvailable("CyborgHeavyBody-2120", playnum);
		makeComponentAvailable("CyborgLightBody-mech", playnum);
		makeComponentAvailable("CyborgSpade", playnum);
		//makeComponentAvailable("nowheeled01", playnum);
		
	}
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

	var conDeb="";
	var dumpText="";
	var interest=0.01798; //int
	var basepower=2800;
var powerMod=0;

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
	//var basebank=5-getMultiTechLevel();
	//var techLevel = getMultiTechLevel();
	//var list = enumStruct([player[, structure type[, looking player]]]);
	for (var j = 0; j < 10; j++){
		resources[0][j]=-(2-(powerType-powerMod))*basepower/5;
	}
	resources[0][2]+=(1-(powerType-powerMod))*3*basepower/5;
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
					//dumpText+=i +" FOD "+ list[i].name +"="+ list[i].cost +" is"+ list[i].status +" p:"+ list[i].player  +" #"+ p +" "+ list[i];
					for (var j = 0; j < 10; j++){

						if(list[i].status){
							var factor=resources[p][11]/100;
							if(structureIdle(list[i])){
								factor-=resources[p][10]/100;
							}
							var add=0;
							if(data[j]>0){

								add=data[j]/100*list[i].cost;
								resources[p][j]=(resources[p][j] || 0)+add;
								nbase+=add;
							}
							if(data[j]<0){

								add=data[j]/100*list[i].cost;
								
							}
						
							if(playerData[playnum].difficulty>0){
								add=add/4;
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
		var powtoadd=playerPower(playnum)-(banks[playnum]-getMultiTechLevel()-1)*basepower/5;
		//playPow+=(basebank-banks[playnum]+getMultiTechLevel())*basepower/5;
		//console("2player:"+ playnum +"=="+ powtoadd +"..."+ resources[playnum+1][9]);
		resources[playnum+1][9]=(playnum+1 || 0)+powtoadd;
		resources[0][9]=(resources[0][9] || 0)+powtoadd;
		
		nbase+=powtoadd;
		

		
	}

	/*
	for (var playnum = 0; playnum < maxPlayers; playnum++){
		ncult+=culture[playnum];
		tothonorPow+=honor[playnum];
		
		//honorPow+=countStruct("A3CommandCentre", playnum)*500*1;
		
		if(playerData[playnum].difficulty>0){
			ndiff+=playerData[playnum].difficulty;
		}
		
		honorPow=0;
		honorPow+=countStruct("A3CommandCentre", playnum)*500*1;
		honorPow-=countStruct("A1CommandCentre", playnum)*500*1;
		totHonor+=honorPow;
		honor[playnum]+=(honorPow+( ndiff/(maxPlayers-0.99)-0.25)*500 )*5*1000;
		
		
	}
	*/
	//totpropPow+=aiprop;
	var currentDiff=0;
	for (var playnum = 0; playnum < maxPlayers; playnum++){
		ndiff=0;
		for (var playnum2 = 0; playnum2 < maxPlayers; playnum2++){
			if(playnum == playnum2){
			}
			else{
				if(playerData[playnum2].isAI){
					currentDiff=0.7+.30*playerData[playnum2].difficulty;
				}
				else{
					currentDiff=1.6;
				}
				if(playerData[playnum2].team == playerData[playnum]){
					ndiff-=currentDiff;
				}
				else{
					ndiff+=currentDiff;
				}
			}
		}
		honorPow=0;
		honorPow+=countStruct("A3CommandCentre", playnum)*500*1;
		honorPow-=countStruct("A1CommandCentre", playnum)*500*1;
		totHonor+=honorPow;
		honor[playnum]+=(honorPow+ndiff*1000)/100*5*1000;
		meantotHonor+=(honorPow+ndiff*1000)/100/maxPlayers*5*1000;
	}

	totpropPow+=-startprop+(resources[0][0] || 0)+(resources[0][3] || 0)-(resources[0][2] || 0);

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

		basePow=0;

		income=0;
		
		//playPow+=(basebank-banks[playnum]-getMultiTechLevel())*basepower/5;
		//playPow+=(basebank-banks[playnum]+getMultiTechLevel())*basepower/5;
		//console("3player:"+ playnum +"=="+ totPow +" house:"+ countStruct("Housing-nrs", playnum));
		

		
		var p=playnum+1;
		for (var j = 0; j < 10; j++){
			if((resources[p][j] || 0)>0){
				if(j==9){
					basePow+=resources[p][j]/1.1**Math.ceil(((resources[0][j] || 0)/(basepower/5)-maxPlayers)/3); //removing 1 bank worth per player... given as base.
				}
				else{
					basePow+=resources[p][j]/1.1**Math.ceil((resources[0][j] || 0)/(basepower/5));
				}
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
		var fractprop=Math.ceil((2**(Math.ceil(totpropPow/(basepower*(1.25-1)*maxPlayers)*100)/100))*100)/100;
		//if(totpropPow!=0){
		//	totPow+=totIncome*(1-(1/fractprop))*propPow/(totpropPow)/2;
		//}

		
		//var timetoscale=((playPow+basePow)/(basepower*1.5)-1)/(interest-1);
		var expPower=(playPow+basePow)/(2/5*basepower);
		var timetoscale=Math.log(expPower)/Math.log(1+interest);
		var linearPower=(interest)*timetoscale+1;
		//var expPower=interest**timetoscale;
		//var equity=-((playPow+basePow)/(basepower*1.5))/expPower+1;
		var equity=Math.ceil(1000*linearPower/(expPower+0.0001))/1000;
		//var equity=Math.ceil(1*(((playPow+basePow)/(npow+nbase))**2)*100)/100;
		//dumpText+=".9*(("+ playPow +"+"+ basePow +")**3)/("+ npow +"+"+ nbase +")**3 ="+ equity;
		//var founds=(npow-basebank*maxPlayers*basepower/5)/(30000*maxPlayers*powertypefact)+nbase/(30000*maxPlayers*powertypefact);
		//var foundsFact=3**(founds);
		var foundsFact=1;
		
		income=(playPow+basePow)*(interest);
		if(income>0){
			income*=(equity)*1.5; //and line 323 Not sure why i need that x1.5 but I believe it's needed to match the ttpower
		}
		

		thisincome+=income;
		//income*=2**(powerType-1)/fractprop;
		income*=powertypefact/fractprop;
		//income*=powertypefact;
		
		if(playerData[playnum].difficulty>0){
			var aiFact=totHonor/(500)/(maxPlayers*4);
			//var factordif=2**playerData[playnum].difficulty-.5;
			var factordif=1.5;
			if(playerData[playnum].difficulty==1){ factordif=1.1; }
			if(playerData[playnum].difficulty==2){ factordif=1.30; }
			if(playerData[playnum].difficulty==3){ factordif=1.50; }
			if(playerData[playnum].difficulty==4){ factordif=2; }
			//propPow=playerData[playnum].difficulty*basepower;
			//income=income*(2**playerData[playnum].difficulty-1);
			income=income*(factordif+aiFact);
		}
		//var powerToSet=totPow+income-(basePow+totPow)*(1-tax);
		var cultureToSet=culture[playnum]+cultPow*interest;
		if(cultureToSet>100000){ income+=cultureToSet-100000; cultureToSet=100000; }
		culture[playnum]=cultureToSet;
		
		powerGen[playnum]= Math.floor(income/10+restInc[playnum]); //
		restInc[playnum]= Math.floor((income/10+restInc[playnum]-powerGen[playnum])*1000)/1000;
		//powerLast[playnum]+=income;
		var powMult=powertypefact/fractprop/foundsFact*(equity)*1.5;
		if(powMult<0){ powMult=0; }
		setPowerModifier(powMult*100, playnum);
		
		//dumpText+=culture[playnum] +"/1.1**"+ totworkPow +"+"+ totpropPow +"-"+ ncult +"/basepower"; 

		//setExperienceModifier(playnum, 1000*1.41**((totenergyPow-totserPow)/basepower));
		setExperienceModifier(playnum, 1000);
		
		//setPower(2000, playnum);
		conDeb+=Math.ceil(equity*100) +",";
		//chat(playnum, "hi"+ playPow +"&"+ basePow +"&"+ resources[playnum] );
	}
	totIncome=thisincome;
	var conText="";
	//conDeb +="ndiff"+ ndiff;
	if(tick%3==0){
		conText+="richest"+  playerData[richestPlayer].name +"("+ richestPlayer +")@"+ Math.ceil(richestValue) +"$P honor:"+ playerData[honorPlayer].name +"("+ honorPlayer +")@"+ Math.ceil(honorValue/gameTime);
		conText+=" propaganda:"+  Math.ceil(totpropPow)  +"("+  Math.ceil(1/fractprop*100) +"%) equ:"+ conDeb;
	}if(tick%3==1){
		if(tick==1){
			conText+=" Welcome to NRS";
		}else if(tick%12==4){
			//conText+=" Light outnumber Medium which outnumber Heavy which can't even feel Light";
		}else if(tick%12==7){
			
			var input=playerData[richestPlayer].name;
			var output = 0;
			for (let i = 0; i < input.length; i++) {
				output += input[i].charCodeAt(0)*(26**i);
			}
			
			conText+=" Structure <> Wheel , Track <> Personnal. H>L>M>H>L"+ output;
		}else{
			conText+=" Don't try anything ! This mod is made to be boring. Always Follow the rules !";
		}
		//conText+="bla"+ resources;
		//conText+=" R:"+   Math.ceil(totresPow) +" C:"+  Math.ceil(totcultPow)  +" S:"+ Math.ceil(totserPow) +" E:"+  Math.ceil(totenergyPow) +" W:"+  Math.ceil(totworkPowPow);
	}if(tick%3==2){
			//conText+="E W R:"+   Math.ceil(totresPow/basepower) +" C:"+  Math.ceil(totcultPow/basepower)  +" S:"+ Math.ceil(totserPow/basepower) +" E:"+  Math.ceil(totenergyPow/basepower-maxPlayers/2) +" W:"+  Math.ceil(totworkPow/basepower) +" R C";
			for (var j = 0; j < 10; j++){
				if(j==9){
					conText+=" "+  resourcesNames[j] +"="+   String(Math.ceil(100*1/1.1**Math.ceil(((resources[0][j] || 0)/(basepower/5)-maxPlayers)/3) )) +"%";
				}
				else{
					conText+=" "+  resourcesNames[j] +"="+   String(Math.ceil(100*1/1.1**((resources[0][j] || 0)/(basepower/5)))) +"%";
				}
				
			}

	}
	if(dumpText!=""){
		dump("--"+ dumpText);
	}
	console(conText);
}