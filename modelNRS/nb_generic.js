
/*
 * This file defines a standard AI personality for the base game. 
 * 
 * It relies on ruleset definition in /rulesets/ to provide
 * standard strategy descriptions and necessary game stat information.
 * 
 * Then it passes control to the main code.
 * 
 */

// You can redefine these paths when you make a customized AI
// for a map or a challenge.
NB_PATH = "/multiplay/skirmish/";
NB_INCLUDES = NB_PATH + "nb_includes/";
NB_RULESETS = NB_PATH + "nb_rulesets/";
NB_COMMON = NB_PATH + "nb_common/";

// please don't touch this line
include(NB_INCLUDES + "_head.js");

////////////////////////////////////////////////////////////////////////////////////////////
// Start the actual personality definition

// the rules in which this personality plays
include(NB_RULESETS + "standard.js");
include(NB_COMMON + "standard_build_order.js");

// variables defining the personality
var subpersonalities = {
	//--persos
	/*
	Scav: {
		chatalias: "Scav",
		weaponPaths: [ // weapons to use; put late-game paths below!
			weaponStats.scavenger, 
		],
		earlyResearch: [ // fixed research path for the early game
			"R-NRS-BusCannon",
		],
		minTanks: 1, // minimal attack force at game start
		becomeHarder: 1, // how much to increase attack force every 5 minutes
		maxTanks: 10, // maximum for the minTanks value (since it grows at becomeHarder rate)
		minTrucks: 2, // minimal number of trucks around
		minHoverTrucks: 3, // minimal number of hover trucks around
		maxSensors: 1, // number of mobile sensor cars to produce
		minMiscTanks: 1, // number of tanks to start harassing enemy
		maxMiscTanks: 10, // number of tanks used for defense and harass
		vtolness: 0, // the chance % of not making droids when adaptation mechanism chooses vtols
		defensiveness: 65, // same thing for defenses; set this to 100 to enable turtle AI specific code
		maxPower: 700, // build expensive things if we have more than that
		repairAt: 50, // how much % healthy should droid be to join the attack group instead of repairing
	},
	MR: {
		chatalias: "mr",
		weaponPaths: [ // weapons to use; put late-game paths below!
			weaponStats.APO11, 
			//weaponStats.cannon, 
		],
		earlyResearch: [ // fixed research path for the early game
			"R-NRS-MG1Mk1",
		],
		minTanks: 1, // minimal attack force at game start
		becomeHarder: 1, // how much to increase attack force every 5 minutes
		maxTanks: 10, // maximum for the minTanks value (since it grows at becomeHarder rate)
		minTrucks: 2, // minimal number of trucks around
		minHoverTrucks: 3, // minimal number of hover trucks around
		maxSensors: 1, // number of mobile sensor cars to produce
		minMiscTanks: 1, // number of tanks to start harassing enemy
		maxMiscTanks: 10, // number of tanks used for defense and harass
		vtolness: 0, // the chance % of not making droids when adaptation mechanism chooses vtols
		defensiveness: 65, // same thing for defenses; set this to 100 to enable turtle AI specific code
		maxPower: 700, // build expensive things if we have more than that
		repairAt: 50, // how much % healthy should droid be to join the attack group instead of repairing
	},
	/*
	FS: {
		chatalias: "fs",
		weaponPaths: [
			weaponStats.flammer, 
			weaponStats.ASrocket, 
		],
		earlyResearch: [ 
			"R-NRS-Flame1Mk1",
		],
		minTanks: 1, 
		becomeHarder: 1,
		maxTanks: 10,
		minTrucks: 2, 
		minHoverTrucks: 3, 
		maxSensors: 1,
		minMiscTanks: 1,
		maxMiscTanks: 10, 
		vtolness: 0,
		defensiveness: 65, 
		maxPower: 700,
		repairAt: 50, 
	},
	MRH: {
		chatalias: "mrh",
		weaponPaths: [ // weapons to use; put late-game paths below!
			weaponStats.machinegun, 
			weaponStats.heavyrocket, 
		],
		earlyResearch: [ // fixed research path for the early game
			"R-NRS-MG1Mk1",
		],
		minTanks: 1, // minimal attack force at game start
		becomeHarder: 1, // how much to increase attack force every 5 minutes
		maxTanks: 10, // maximum for the minTanks value (since it grows at becomeHarder rate)
		minTrucks: 2, // minimal number of trucks around
		minHoverTrucks: 3, // minimal number of hover trucks around
		maxSensors: 1, // number of mobile sensor cars to produce
		minMiscTanks: 1, // number of tanks to start harassing enemy
		maxMiscTanks: 10, // number of tanks used for defense and harass
		vtolness: 0, // the chance % of not making droids when adaptation mechanism chooses vtols
		defensiveness: 65, // same thing for defenses; set this to 100 to enable turtle AI specific code
		maxPower: 700, // build expensive things if we have more than that
		repairAt: 50, // how much % healthy should droid be to join the attack group instead of repairing
	},
	LR: {
		chatalias: "lr",
		weaponPaths: [
			weaponStats.mediumlaser, 
			weaponStats.rocket, 
		],
		earlyResearch: [ 
			"R-NRS-Rocket-Pod",
		],
		minTanks: 1, 
		becomeHarder: 1,
		maxTanks: 10,
		minTrucks: 2, 
		minHoverTrucks: 3, 
		maxSensors: 1,
		minMiscTanks: 1,
		maxMiscTanks: 10, 
		vtolness: 0,
		defensiveness: 65, 
		maxPower: 700,
		repairAt: 50, 
	},
	FL: {
		chatalias: "fl",
		weaponPaths: [
			weaponStats.flammer, 
			weaponStats.mediumlaser, 
		],
		earlyResearch: [ 
			"R-NRS-Flame1Mk1",
		],
		minTanks: 1, 
		becomeHarder: 1,
		maxTanks: 10,
		minTrucks: 2, 
		minHoverTrucks: 3, 
		maxSensors: 1,
		minMiscTanks: 1,
		maxMiscTanks: 10, 
		vtolness: 0,
		defensiveness: 65, 
		maxPower: 700,
		repairAt: 50, 
	},
	MQ: {
		chatalias: "mq",
		weaponPaths: [
			//weaponStats.mortar, 
			weaponStats.rocket,
			weaponStats.quark, 
		],
		earlyResearch: [ 
			"R-NRS-RailGun1Mk1-2120",
		],
		minTanks: 1, 
		becomeHarder: 1,
		maxTanks: 10,
		minTrucks: 2, 
		minHoverTrucks: 3, 
		maxSensors: 1,
		minMiscTanks: 1,
		maxMiscTanks: 10, 
		vtolness: 0,
		defensiveness: 65, 
		maxPower: 700,
		repairAt: 50, 
	},
	LRH: {
		chatalias: "lrh",
		weaponPaths: [
			weaponStats.heavylaser, 
			weaponStats.heavyrocket, 
		],
		earlyResearch: [ 
			"R-NRS-Laser3BEAMMk1",
		],
		minTanks: 1, 
		becomeHarder: 1,
		maxTanks: 10,
		minTrucks: 2, 
		minHoverTrucks: 3, 
		maxSensors: 1,
		minMiscTanks: 1,
		maxMiscTanks: 10, 
		vtolness: 0,
		defensiveness: 65, 
		maxPower: 700,
		repairAt: 50, 
	},
	RI: {
		chatalias: "ri",
		weaponPaths: [
			weaponStats.rail, 
			weaponStats.indirectmissile, 
		],
		earlyResearch: [ 
			"R-NRS-RailGun1Mk1-2120",
		],
		minTanks: 1, 
		becomeHarder: 1,
		maxTanks: 10,
		minTrucks: 2, 
		minHoverTrucks: 3, 
		maxSensors: 1,
		minMiscTanks: 1,
		maxMiscTanks: 10, 
		vtolness: 0,
		defensiveness: 65, 
		maxPower: 700,
		repairAt: 50, 
	},
	ContL: {
		chatalias: "ContL",
		weaponPaths: [
			weaponStats.extralasers, 
			weaponStats.ATlasers, 
		],
		earlyResearch: [ 
			"R-NRS-Laser-AP1-contingency",
		],
		minTanks: 1, 
		becomeHarder: 1,
		maxTanks: 10,
		minTrucks: 2, 
		minHoverTrucks: 3, 
		maxSensors: 1,
		minMiscTanks: 1,
		maxMiscTanks: 10, 
		vtolness: 0,
		defensiveness: 65, 
		maxPower: 700,
		repairAt: 50, 
	},
	ContC: {
		chatalias: "ContC",
		weaponPaths: [
			weaponStats.contmortars, 
			weaponStats.contcannons, 
		],
		earlyResearch: [ 
			"R-NRS-Cannon-Shotgun-contingency",
		],
		minTanks: 1, 
		becomeHarder: 1,
		maxTanks: 10,
		minTrucks: 2, 
		minHoverTrucks: 3, 
		maxSensors: 1,
		minMiscTanks: 1,
		maxMiscTanks: 10, 
		vtolness: 0,
		defensiveness: 65, 
		maxPower: 700,
		repairAt: 50, 
	},
	*/

};

// this function describes the early build order
// you can rely on personality.chatalias for choosing different build orders for
// different subpersonalities

function buildOrder() {
	// Only use this build order in early game, on standard difficulty, in T1 no bases.
	// Otherwise, fall back to the safe build order.
	//console(personality.chatalias)
	personality.repairAt=100-countDroid(DROID_ANY,me)*100/140;
	
	
// Define structureData from NRS.js for resource calculations
	var structureData = {
		"Oil Derrick":[0,20,60,-37,0,20,-74,0,0,0,0,130,],
		"Aerodynamicslab":[50,0,-110,0,0,0,25,25,0,0,0,137,],
		"Heavywepslab":[33,0,-110,0,0,0,16,50,0,0,0,140,],
		"Advmaterialslab":[100,0,-110,0,0,0,0,0,0,0,0,145,],
		"Rotarywepslab":[33,0,-55,0,0,0,-55,66,0,0,0,141,],
		"Powlab":[0,25,50,0,25,0,-37,-74,0,0,0,131,],
		"Solar panel":[-55,0,66,0,-55,0,33,0,0,0,0,130,],
		"*NuclearReactor*":[-37,0,50,0,25,0,25,-74,0,0,0,150,],
		"*CoolingTower*":[-37,50,50,0,0,0,0,-74,0,0,0,131,],
		"Propaganda Tower":[0,33,-37,0,-37,-37,0,66,0,0,0,132,],
		"Pickup":[0,66,0,33,-37,-37,-37,0,0,0,0,142,],
		"road":[0,75,0,0,-55,25,-55,0,0,0,0,144,],
		"BarbWarehouse2":[25,50,0,-55,25,0,-55,0,0,0,0,138,],
		"BarbWarehouse1":[50,50,-55,-55,0,0,0,0,0,0,0,150,],
		"BarbWarehouse3":[25,50,0,-55,0,25,-55,0,0,0,0,141,],
		"OilTower":[33,33,-44,0,0,33,-22,-44,0,0,0,143,],
		"WaterTower":[0,50,0,-110,0,0,50,0,0,0,0,132,],
		"AirTrafficControl":[0,33,-44,-44,0,33,-22,33,0,0,0,144,],
		"Ruin1":[-55,0,0,100,-28,-28,0,0,0,0,0,133,],
		"BarbHUT":[-28,-28,0,100,-28,-28,0,0,0,0,0,134,],
		"cabin":[0,-74,0,66,-37,33,0,0,0,0,0,145,],
		"LogCabin3":[-55,-55,0,33,0,66,0,0,0,0,0,145,],
		"building3":[-44,-44,0,100,0,-22,0,0,0,0,0,146,],
		"building2":[-55,-55,0,50,25,25,0,0,0,0,0,137,],
		"building11":[-44,-44,0,60,40,-22,0,0,0,0,0,135,],
		"building12":[-37,-37,0,40,40,20,-37,0,0,0,0,148,],
		"building10":[-37,-74,0,40,40,20,0,0,0,0,0,139,],
		"Park":[0,-37,0,-74,0,33,66,0,0,0,0,135,],
		"Forest":[0,0,0,-55,-55,0,100,0,0,0,0,147,],
		"Big Forest":[0,0,0,0,-110,0,100,0,0,0,0,148,],
		"Tree":[0,0,0,0,33,0,66,-110,0,0,0,149,],
		"Boulder3":[0,0,0,0,33,0,66,0,-110,0,0,138,],
		"Boulder2":[0,0,0,0,0,0,100,0,-110,0,0,139,],
		"Boulder1":[0,0,0,0,33,0,66,0,-110,0,0,142,],
		"arizonabush3":[0,33,0,-55,0,0,66,-55,0,0,0,151,],
		"OilTower-eco":[33,33,-44,0,0,33,-22,-44,0,0,0,143,],
		"BarbWarehouse2-eco":[25,50,0,-55,25,0,-55,0,0,0,0,138,],
		"Forest-eco":[0,0,0,-55,-55,0,100,0,0,0,0,147,],
		"Heavywepslab-eco":[33,0,-110,0,0,0,16,50,0,0,0,140,],
		"LogCabin3-eco":[-55,-55,0,33,0,66,0,0,0,0,0,145,],
		"BigForest-eco":[0,0,0,0,-110,0,100,0,0,0,0,148,],
		"cabin-eco":[0,-74,0,66,-37,33,0,0,0,0,0,145,],
		"Powlab-eco":[0,25,50,0,25,0,-37,-74,0,0,0,131,],
		"Park-eco":[0,-37,0,-74,0,33,66,0,0,0,0,135,],
		"building11-eco":[-44,-44,0,60,40,-22,0,0,0,0,0,135,],
		"AirTrafficControl-eco":[0,33,-44,-44,0,33,-22,33,0,0,0,144,],
		"Pickup-eco":[0,66,0,33,-37,-37,-37,0,0,0,0,142,],
		"building10-eco":[-37,-74,0,40,40,20,0,0,0,0,0,139,],
		"Ruin1-eco":[-55,0,0,100,-28,-28,0,0,0,0,0,133,],
		"Aerodynamicslab-eco":[50,0,-110,0,0,0,25,25,0,0,0,137,],
		"Boulder3-eco":[0,0,0,0,33,0,66,0,-110,0,0,138,],
		"Tree-eco":[0,0,0,0,33,0,66,-110,0,0,0,149,],
		"building12-eco":[-37,-37,0,40,40,20,-37,0,0,0,0,148,],
		"CoolingTower-eco":[-37,50,50,0,0,0,0,-74,0,0,0,131,],
		"SolarPower-eco":[-55,0,66,0,-55,0,33,0,0,0,0,130,],
		"Rotarywepslab-eco":[33,0,-55,0,0,0,-55,66,0,0,0,141,],
		"Boulder1-eco":[0,0,0,0,33,0,66,0,-110,0,0,142,],
		"Boulder2-eco":[0,0,0,0,0,0,100,0,-110,0,0,139,],
		"building3-eco":[-44,-44,0,100,0,-22,0,0,0,0,0,146,],
		"Advmaterialslab-eco":[100,0,-110,0,0,0,0,0,0,0,0,145,],
		"A0ResourceExtractor-eco":[0,20,60,-37,0,20,-74,0,0,0,0,130,],
	};
	
	var basepower = 2800;
	
	// Compute current resources array
	function computeResources() {
		var resources = Array.from(Array(11), () => new Array(12).fill(0));
		for (var playnum = 0; playnum < maxPlayers; playnum++) {
			var list = enumStruct(playnum);
			for (var i = 0; i < list.length; ++i) {
				var data = structureData[list[i].name];
				if (data && list[i].status == BUILT) {
					var p = list[i].player + 1;
					for (var j = 0; j < 10; j++) {
						var add = 0;
						if (data[j] > 0) {
							add = data[j] / 100 * data[11];
							resources[p][j] = (resources[p][j] || 0) + add;
						}
						if (data[j] < 0) {
							add = data[j] / 100 * data[11];
						}
						if (playerData[playnum].difficulty > 0) {
							add /= 4;
						}
						resources[0][j] = (resources[0][j] || 0) + add;
					}
				}
			}
		}
		return resources;
	}
	
	// Calculate delta basePow for building
	function calculateBuildingPower(buildingName, currentResources) {
		var data = structureData[buildingName];
		if (!data) return 0;
		
		var cost = data[11];
		var p = me + 1;
		var isAI = playerData[me].difficulty > 0;
		var deltaBasePow = 0;
		
		for (var j = 0; j < 10; j++) {
			var add_unadjusted = data[j] / 100 * cost;
			var add_adjusted = add_unadjusted;
			//if (isAI) {
			//	add_adjusted /= 2;
			//}
			var newRes0 = (currentResources[0][j] || 0) + add_adjusted;
			var demandDiv = basepower / 5;
			var demand;
			if (j === 9) {
				demand = Math.ceil((newRes0 / demandDiv - maxPlayers) / 3);
			} else {
				demand = Math.ceil(newRes0 / demandDiv);
			}
			if(personality.ecofav1==j){ demand-=2; }
			if(personality.ecofav2==j){ demand-=1; }
			if(personality.ecofav3==j){ demand-=1; }
			if (data[j] > 0) {
				deltaBasePow += add_unadjusted / Math.pow(1.1, demand);
			}
		}
		
		return deltaBasePow;
	}
	
	var currentResources = computeResources();
	
	// Sort powerstuff buildings by power contribution (highest to lowest), only available ones
	var sortedPowerStuff = structures.powerstuff.filter(function(building) {
		return isStructureAvailable(building, me);
	}).sort(function(a, b) {
		return calculateBuildingPower(b, currentResources) - calculateBuildingPower(a, currentResources);
	});
	
	/*
	if (gameTime > 300000 || difficulty === INSANE
	                      || isStructureAvailable("A0ComDroidControl") || baseType !== CAMP_CLEAN)
		return buildOrder_StandardFallback();
	if (personality.chatalias === "xxx" || personality.chatalias === "xxx") {
		if (buildMinimum(structures.labs, 1)) return true;
		if (buildMinimum(structures.factories, 1)) return true;
		if (buildMinimum(structures.labs, 2)) return true;
		if (buildMinimum(structures.factories, 2)) return true;
		if (buildMinimumDerricks(2)) return true;
		if (buildMinimum(structures.hqs, 1)) return true;
		if (buildMinimum(structures.gens, 2)) return true;
	} else {
		if (buildMinimum(structures.factories, 1)) return true;
		if (buildMinimum(structures.labs, 1)) return true;
		if (buildMinimum(structures.labs, 1)) return true;
		if (buildMinimumDerricks(4)) return true;
		if (buildMinimum(structures.hqs, 1)) return true;
		if (buildMinimum(structures.factories, 2)) return true;
		//if (buildMinimum(structures.labs, 1)) return true;
		//if (buildMinimum(structures.labs, 1)) return true;
		//if (buildMinimum(structures.gens, 2)) return true;
	}*/
	if (buildMinimum(structures.factories, 1)) return true;
	if (buildMinimum(structures.labs, 1)) return true;
	if (buildMinimumDerricks(2)) return true;
	if (buildMinimum(structures.hqs, 1)) return true;
	//if (buildMinimum(structures.labs, 1)) return true;
	if (buildMinimum(structures.factories, 2)) return true;
	//if (buildMinimum(structures.extras, 5)) return true;
	//if (buildMinimum(structures.labs, 5)) return true;
	//if (buildMinimum(structures.factories, 5)) return true;
	//if (buildMinimum(structures.labs, 8)) return true;
	var powerLimit=playerPower(me)/500;
	
	//if(playerPower(me)<500){
		//if (buildMinimum(structures.powerstuff, 5)) return true;	
	//}
	if (buildMinimum(structures.factories, 2+powerLimit/1000)) return true;
	if (buildMinimum(structures.labs, 1+powerLimit/1000)) return true;
	if( (playerPower(me) + queuedPower(me) + 500)>0 && (playerPower(me)- queuedPower(me))<2500 && throttled(5000)){
		if (buildMinimum(sortedPowerStuff, 200)) return true;
	}
	if (buildMinimum(structures.factories, 2+powerLimit/100)) return true
	if (buildMinimum(structures.templateFactories, 2+powerLimit/100)) return true
	if (buildMinimum(structures.labs, 1+powerLimit/100)) return true;
	if (buildMinimum(structures.factories, 2+powerLimit/10)) return true;
	if (buildMinimum(structures.labs, 1+powerLimit/10)) return true;
	if(withChance(25)){
		if (buildMinimum(structures.extras, 5+powerLimit*2/10)) return true;
	}
	if(withChance(25)){
		if (buildMinimum(structures.factories, 2+powerLimit)) return true;
	}
	if (buildMinimum(structures.labs, 1+powerLimit/3)) return true;
	if(withChance(25)){
		//if (buildMinimum(structures.extras, 5+powerLimit*1.5)) return true;
		if (buildMinimum(structures.extras, 5+powerLimit*1.5)) return true;
		
	}
	//if (buildMinimum(structures.factories, 10)) return true;
	//if (buildMinimum(structures.factories, 20)) return true;
	//if (buildMinimum(structures.factories, 30)) return true;
	return captureSomeOil();
}



////////////////////////////////////////////////////////////////////////////////////////////
// Proceed with the main code

include(NB_INCLUDES + "_main.js");
