
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
		if (buildMinimum(structures.powerstuff, 200)) return true;
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
