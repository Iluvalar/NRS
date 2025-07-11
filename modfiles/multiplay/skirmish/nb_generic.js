
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
		APE21: {
				chatalias: "APE21",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.APE21, 
					weaponStats.APE20, 
					weaponStats.APE11, 
					weaponStats.APO21, 
					weaponStats.ATE21, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.ASO21, 
					weaponStats.AWE11, 
					weaponStats.APO01, 
					weaponStats.ASE20, 
					weaponStats.APE10, 
					weaponStats.AWA21, 
					weaponStats.ASE11, 
					weaponStats.APO11, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
					weaponStats.ASA20, 
					weaponStats.AWA20, 
					weaponStats.ATO01, 
					weaponStats.ATE10, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.ASO01, 
					weaponStats.APA00, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.AWA11, 
					weaponStats.AWA01, 
					weaponStats.AWO01, 
					weaponStats.APO10, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ATE11: {
				chatalias: "ATE11",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ATE11, 
					weaponStats.AWE11, 
					weaponStats.ATE10, 
					weaponStats.APE11, 
					weaponStats.ASE11, 
					weaponStats.ATO11, 
					weaponStats.ATE21, 
					weaponStats.APE21, 
					weaponStats.ATE20, 
					weaponStats.ATO01, 
					weaponStats.APE10, 
					weaponStats.ATO10, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
					weaponStats.AWA11, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.AWA10, 
					weaponStats.APE20, 
					weaponStats.APO01, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.ATO00, 
					weaponStats.AWA21, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.APO21, 
					weaponStats.AWA01, 
					weaponStats.AWO01, 
					weaponStats.APO10, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ATE20: {
				chatalias: "ATE20",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ATE20, 
					weaponStats.APE20, 
					weaponStats.ATE10, 
					weaponStats.ASE20, 
					weaponStats.ATO20, 
					weaponStats.ATE21, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.ASA20, 
					weaponStats.AWA20, 
					weaponStats.ASE00, 
					weaponStats.ATO00, 
					weaponStats.APE10, 
					weaponStats.ATO10, 
					weaponStats.ATO21, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.AWA10, 
					weaponStats.AWE11, 
					weaponStats.ATO01, 
					weaponStats.APE11, 
					weaponStats.ASO00, 
					weaponStats.ASA00, 
					weaponStats.AWA21, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.AWA00, 
					weaponStats.ATO11, 
					weaponStats.APO21, 
					weaponStats.APO10, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ASA20: {
				chatalias: "ASA20",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ASA20, 
					weaponStats.AWA20, 
					weaponStats.ASA00, 
					weaponStats.ASE20, 
					weaponStats.ATE20, 
					weaponStats.ASO21, 
					weaponStats.AWA10, 
					weaponStats.APE20, 
					weaponStats.ASO00, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.AWA21, 
					weaponStats.ASO10, 
					weaponStats.APA00, 
					weaponStats.AWA00, 
					weaponStats.APE21, 
					weaponStats.AWO10, 
					weaponStats.ATE10, 
					weaponStats.ATO00, 
					weaponStats.APE10, 
					weaponStats.ASO01, 
					weaponStats.ASE11, 
					weaponStats.AWO00, 
					weaponStats.ATO10, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.AWA11, 
					weaponStats.AWA01, 
					weaponStats.ATE21, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
					weaponStats.APO10, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ASO21: {
				chatalias: "ASO21",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ASO21, 
					weaponStats.ASO01, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.ATO21, 
					weaponStats.APE21, 
					weaponStats.ASA20, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.ASO00, 
					weaponStats.ASE20, 
					weaponStats.ATO20, 
					weaponStats.AWA21, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.ATO11, 
					weaponStats.APO11, 
					weaponStats.ATE21, 
					weaponStats.AWO01, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.AWO10, 
					weaponStats.AWA20, 
					weaponStats.APE20, 
					weaponStats.AWE11, 
					weaponStats.APE11, 
					weaponStats.ASA00, 
					weaponStats.ASE00, 
					weaponStats.ATO00, 
					weaponStats.AWO00, 
					weaponStats.ATO10, 
					weaponStats.AWA11, 
					weaponStats.AWA01, 
					weaponStats.APA11, 
					weaponStats.APO10, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			AWO10: {
				chatalias: "AWO10",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.AWO10, 
					weaponStats.AWA10, 
					weaponStats.ASO10, 
					weaponStats.AWO00, 
					weaponStats.ATO10, 
					weaponStats.APO10, 
					weaponStats.AWA20, 
					weaponStats.AWE11, 
					weaponStats.ATE10, 
					weaponStats.ASO00, 
					weaponStats.ATO20, 
					weaponStats.ATO00, 
					weaponStats.APE10, 
					weaponStats.AWA00, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
					weaponStats.AWA11, 
					weaponStats.AWO01, 
					weaponStats.APO00, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.APE20, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.APE11, 
					weaponStats.ASA00, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.AWA21, 
					weaponStats.ASO01, 
					weaponStats.ASE11, 
					weaponStats.APA00, 
					weaponStats.APO21, 
					weaponStats.AWA01, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			AWA10: {
				chatalias: "AWA10",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.AWA10, 
					weaponStats.AWO10, 
					weaponStats.AWA20, 
					weaponStats.AWA00, 
					weaponStats.AWA11, 
					weaponStats.ASA20, 
					weaponStats.AWE11, 
					weaponStats.ATE10, 
					weaponStats.ASA00, 
					weaponStats.APE10, 
					weaponStats.AWA21, 
					weaponStats.ASO10, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.ATO10, 
					weaponStats.AWA01, 
					weaponStats.APA11, 
					weaponStats.APO10, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.APE20, 
					weaponStats.APE11, 
					weaponStats.ASO00, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.ATO00, 
					weaponStats.ASE11, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
					weaponStats.AWO01, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			AWA20: {
				chatalias: "AWA20",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.AWA20, 
					weaponStats.ASA20, 
					weaponStats.AWA10, 
					weaponStats.AWA21, 
					weaponStats.AWA00, 
					weaponStats.ATE20, 
					weaponStats.AWO10, 
					weaponStats.APE20, 
					weaponStats.ASA00, 
					weaponStats.ASE20, 
					weaponStats.ATO20, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.AWA11, 
					weaponStats.AWA01, 
					weaponStats.APE21, 
					weaponStats.ASO21, 
					weaponStats.AWE11, 
					weaponStats.ATE10, 
					weaponStats.ASO00, 
					weaponStats.ASE00, 
					weaponStats.ATO00, 
					weaponStats.APE10, 
					weaponStats.ASO10, 
					weaponStats.ATO10, 
					weaponStats.APO21, 
					weaponStats.ATE21, 
					weaponStats.AWO01, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
					weaponStats.APO10, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			APE20: {
				chatalias: "APE20",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.APE20, 
					weaponStats.APE21, 
					weaponStats.ATE20, 
					weaponStats.ASE20, 
					weaponStats.APE10, 
					weaponStats.ASA20, 
					weaponStats.AWA20, 
					weaponStats.ATE10, 
					weaponStats.APE11, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.APA00, 
					weaponStats.APO21, 
					weaponStats.ATE21, 
					weaponStats.APO10, 
					weaponStats.APO00, 
					weaponStats.ATE11, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.AWA10, 
					weaponStats.AWE11, 
					weaponStats.APO01, 
					weaponStats.ASO00, 
					weaponStats.ASA00, 
					weaponStats.ATO00, 
					weaponStats.AWA21, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.AWO00, 
					weaponStats.AWA00, 
					weaponStats.ATO10, 
					weaponStats.APO11, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			AWE11: {
				chatalias: "AWE11",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.AWE11, 
					weaponStats.ATE11, 
					weaponStats.APE11, 
					weaponStats.ASE11, 
					weaponStats.AWA11, 
					weaponStats.APE21, 
					weaponStats.AWO10, 
					weaponStats.AWA10, 
					weaponStats.ATE10, 
					weaponStats.APE10, 
					weaponStats.AWA21, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
					weaponStats.AWA01, 
					weaponStats.ATE21, 
					weaponStats.AWO01, 
					weaponStats.APA11, 
					weaponStats.ATE20, 
					weaponStats.ASO21, 
					weaponStats.AWA20, 
					weaponStats.APE20, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.AWO00, 
					weaponStats.AWA00, 
					weaponStats.ATO10, 
					weaponStats.APO21, 
					weaponStats.ATO21, 
					weaponStats.APO10, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ATO01: {
				chatalias: "ATO01",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.ATO00, 
					weaponStats.ASO01, 
					weaponStats.ATO11, 
					weaponStats.AWO01, 
					weaponStats.ATO21, 
					weaponStats.ATE11, 
					weaponStats.ASO21, 
					weaponStats.ASO00, 
					weaponStats.ATO20, 
					weaponStats.AWO00, 
					weaponStats.ATO10, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.APO11, 
					weaponStats.AWA01, 
					weaponStats.ATE21, 
					weaponStats.APO00, 
					weaponStats.APE21, 
					weaponStats.ATE20, 
					weaponStats.AWO10, 
					weaponStats.AWE11, 
					weaponStats.ATE10, 
					weaponStats.APE11, 
					weaponStats.ASA00, 
					weaponStats.ASE00, 
					weaponStats.AWA21, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.APA00, 
					weaponStats.AWA00, 
					weaponStats.AWA11, 
					weaponStats.APA11, 
					weaponStats.APO10, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ATE10: {
				chatalias: "ATE10",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ATE10, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.APE10, 
					weaponStats.ATO10, 
					weaponStats.AWO10, 
					weaponStats.AWA10, 
					weaponStats.APE20, 
					weaponStats.AWE11, 
					weaponStats.APE11, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.ATO00, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.ATO11, 
					weaponStats.ATE21, 
					weaponStats.APO10, 
					weaponStats.APE21, 
					weaponStats.ASA20, 
					weaponStats.AWA20, 
					weaponStats.ATO01, 
					weaponStats.ASO00, 
					weaponStats.ASA00, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.AWA00, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
					weaponStats.AWA11, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			APO01: {
				chatalias: "APO01",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.APO01, 
					weaponStats.ATO01, 
					weaponStats.ASO01, 
					weaponStats.APO21, 
					weaponStats.APO11, 
					weaponStats.AWO01, 
					weaponStats.APO00, 
					weaponStats.APE21, 
					weaponStats.ASO21, 
					weaponStats.APE11, 
					weaponStats.ASO00, 
					weaponStats.ATO00, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.AWA01, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
					weaponStats.APO10, 
					weaponStats.ATE11, 
					weaponStats.AWO10, 
					weaponStats.APE20, 
					weaponStats.AWE11, 
					weaponStats.ASA00, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.APE10, 
					weaponStats.AWA21, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.AWA00, 
					weaponStats.ATO10, 
					weaponStats.AWA11, 
					weaponStats.ATE21, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			APE11: {
				chatalias: "APE11",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.APE11, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.AWE11, 
					weaponStats.APE10, 
					weaponStats.ASE11, 
					weaponStats.APO11, 
					weaponStats.APA11, 
					weaponStats.APE20, 
					weaponStats.ATE10, 
					weaponStats.APO01, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.AWA11, 
					weaponStats.ATE21, 
					weaponStats.APO10, 
					weaponStats.ATE20, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.AWA10, 
					weaponStats.ATO01, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.AWA21, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.APA00, 
					weaponStats.ATO10, 
					weaponStats.AWA01, 
					weaponStats.AWO01, 
					weaponStats.ATO21, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ASO00: {
				chatalias: "ASO00",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ASO00, 
					weaponStats.ASA00, 
					weaponStats.ASE00, 
					weaponStats.ATO00, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.AWO00, 
					weaponStats.APO00, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.ASE20, 
					weaponStats.ATO20, 
					weaponStats.APA00, 
					weaponStats.AWA00, 
					weaponStats.ATO10, 
					weaponStats.ASO11, 
					weaponStats.AWO01, 
					weaponStats.APO10, 
					weaponStats.ATE20, 
					weaponStats.AWA10, 
					weaponStats.AWA20, 
					weaponStats.APE20, 
					weaponStats.ATE10, 
					weaponStats.APE10, 
					weaponStats.ASE11, 
					weaponStats.ATO11, 
					weaponStats.APO21, 
					weaponStats.APO11, 
					weaponStats.AWA01, 
					weaponStats.ATO21, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ASA00: {
				chatalias: "ASA00",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ASA00, 
					weaponStats.ASA20, 
					weaponStats.ASO00, 
					weaponStats.ASE00, 
					weaponStats.APA00, 
					weaponStats.AWA00, 
					weaponStats.AWA10, 
					weaponStats.AWA20, 
					weaponStats.ASE20, 
					weaponStats.ATO00, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.AWO00, 
					weaponStats.AWA01, 
					weaponStats.APO00, 
					weaponStats.ATE20, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.APE20, 
					weaponStats.ATO01, 
					weaponStats.ATE10, 
					weaponStats.APO01, 
					weaponStats.ATO20, 
					weaponStats.APE10, 
					weaponStats.AWA21, 
					weaponStats.ASE11, 
					weaponStats.ATO10, 
					weaponStats.ASO11, 
					weaponStats.AWA11, 
					weaponStats.AWO01, 
					weaponStats.APA11, 
					weaponStats.APO10, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ASE20: {
				chatalias: "ASE20",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ASE20, 
					weaponStats.ATE20, 
					weaponStats.ASA20, 
					weaponStats.APE20, 
					weaponStats.ASE00, 
					weaponStats.APE21, 
					weaponStats.ASO21, 
					weaponStats.AWA20, 
					weaponStats.ATE10, 
					weaponStats.ASO00, 
					weaponStats.ASA00, 
					weaponStats.ATO20, 
					weaponStats.APE10, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.ATE21, 
					weaponStats.ATE11, 
					weaponStats.AWO10, 
					weaponStats.AWA10, 
					weaponStats.AWE11, 
					weaponStats.APE11, 
					weaponStats.ATO00, 
					weaponStats.AWA21, 
					weaponStats.ASO01, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.AWA00, 
					weaponStats.ATO10, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.ATO21, 
					weaponStats.APO10, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ASE00: {
				chatalias: "ASE00",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ASE00, 
					weaponStats.ASO00, 
					weaponStats.ASA00, 
					weaponStats.ASE20, 
					weaponStats.ATE20, 
					weaponStats.ASA20, 
					weaponStats.APE20, 
					weaponStats.ATE10, 
					weaponStats.ATO00, 
					weaponStats.APE10, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.ASE11, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.AWA00, 
					weaponStats.APO00, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.AWA10, 
					weaponStats.AWA20, 
					weaponStats.AWE11, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.APE11, 
					weaponStats.ATO20, 
					weaponStats.ATO10, 
					weaponStats.ASO11, 
					weaponStats.AWA01, 
					weaponStats.ATE21, 
					weaponStats.AWO01, 
					weaponStats.APO10, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ATO20: {
				chatalias: "ATO20",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ATO20, 
					weaponStats.ATE20, 
					weaponStats.ATO00, 
					weaponStats.ATO10, 
					weaponStats.ATO21, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.AWA20, 
					weaponStats.APE20, 
					weaponStats.ATO01, 
					weaponStats.ATE10, 
					weaponStats.ASO00, 
					weaponStats.ASE20, 
					weaponStats.ASO10, 
					weaponStats.AWO00, 
					weaponStats.ATO11, 
					weaponStats.APO21, 
					weaponStats.ATE21, 
					weaponStats.APO10, 
					weaponStats.APO00, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.AWA10, 
					weaponStats.APO01, 
					weaponStats.ASA00, 
					weaponStats.ASE00, 
					weaponStats.APE10, 
					weaponStats.AWA21, 
					weaponStats.ASO01, 
					weaponStats.APA00, 
					weaponStats.AWA00, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
					weaponStats.AWO01, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ATO00: {
				chatalias: "ATO00",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ATO00, 
					weaponStats.ATO01, 
					weaponStats.ASO00, 
					weaponStats.ATO20, 
					weaponStats.AWO00, 
					weaponStats.ATO10, 
					weaponStats.APO00, 
					weaponStats.ATE20, 
					weaponStats.AWO10, 
					weaponStats.ATE10, 
					weaponStats.APO01, 
					weaponStats.ASA00, 
					weaponStats.ASE00, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.APA00, 
					weaponStats.AWA00, 
					weaponStats.ATO11, 
					weaponStats.AWO01, 
					weaponStats.ATO21, 
					weaponStats.APO10, 
					weaponStats.ATE11, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.AWA10, 
					weaponStats.AWA20, 
					weaponStats.APE20, 
					weaponStats.ASE20, 
					weaponStats.APE10, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.APO11, 
					weaponStats.AWA01, 
					weaponStats.ATE21, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			APE10: {
				chatalias: "APE10",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.APE10, 
					weaponStats.APE20, 
					weaponStats.ATE10, 
					weaponStats.APE11, 
					weaponStats.APO10, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.AWO10, 
					weaponStats.AWA10, 
					weaponStats.AWE11, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.APA00, 
					weaponStats.ATO10, 
					weaponStats.APO11, 
					weaponStats.APA11, 
					weaponStats.APO00, 
					weaponStats.ASA20, 
					weaponStats.AWA20, 
					weaponStats.APO01, 
					weaponStats.ASO00, 
					weaponStats.ASA00, 
					weaponStats.ATO20, 
					weaponStats.ATO00, 
					weaponStats.AWO00, 
					weaponStats.AWA00, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.AWA11, 
					weaponStats.ATE21, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			AWA21: {
				chatalias: "AWA21",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.AWA21, 
					weaponStats.AWA20, 
					weaponStats.AWA11, 
					weaponStats.AWA01, 
					weaponStats.APE21, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.AWA10, 
					weaponStats.AWE11, 
					weaponStats.AWA00, 
					weaponStats.APO21, 
					weaponStats.ATE21, 
					weaponStats.AWO01, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.AWO10, 
					weaponStats.APE20, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.APE11, 
					weaponStats.ASA00, 
					weaponStats.ASE20, 
					weaponStats.ATO20, 
					weaponStats.ASO01, 
					weaponStats.ASE11, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ASO10: {
				chatalias: "ASO10",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ASO10, 
					weaponStats.AWO10, 
					weaponStats.ASO00, 
					weaponStats.ATO10, 
					weaponStats.ASO11, 
					weaponStats.APO10, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.AWA10, 
					weaponStats.ATE10, 
					weaponStats.ASA00, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.ATO00, 
					weaponStats.APE10, 
					weaponStats.ASO01, 
					weaponStats.ASE11, 
					weaponStats.AWO00, 
					weaponStats.ATO11, 
					weaponStats.APO11, 
					weaponStats.APO00, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.AWA20, 
					weaponStats.APE20, 
					weaponStats.AWE11, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.APE11, 
					weaponStats.APA00, 
					weaponStats.AWA00, 
					weaponStats.APO21, 
					weaponStats.AWA11, 
					weaponStats.AWO01, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ASO01: {
				chatalias: "ASO01",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ASO01, 
					weaponStats.ASO21, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.ASO00, 
					weaponStats.ASO11, 
					weaponStats.AWO01, 
					weaponStats.ASA00, 
					weaponStats.ASE00, 
					weaponStats.ATO00, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.AWO00, 
					weaponStats.ATO11, 
					weaponStats.APO21, 
					weaponStats.APO11, 
					weaponStats.AWA01, 
					weaponStats.ATO21, 
					weaponStats.APO00, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.ASA20, 
					weaponStats.AWO10, 
					weaponStats.AWE11, 
					weaponStats.APE11, 
					weaponStats.ASE20, 
					weaponStats.ATO20, 
					weaponStats.AWA21, 
					weaponStats.APA00, 
					weaponStats.AWA00, 
					weaponStats.ATO10, 
					weaponStats.AWA11, 
					weaponStats.ATE21, 
					weaponStats.APA11, 
					weaponStats.APO10, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ASE11: {
				chatalias: "ASE11",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ASE11, 
					weaponStats.ATE11, 
					weaponStats.AWE11, 
					weaponStats.APE11, 
					weaponStats.ASO11, 
					weaponStats.APE21, 
					weaponStats.ASO21, 
					weaponStats.ATE10, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.APE10, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.ATO11, 
					weaponStats.APO11, 
					weaponStats.AWA11, 
					weaponStats.ATE21, 
					weaponStats.APA11, 
					weaponStats.ATE20, 
					weaponStats.ASA20, 
					weaponStats.AWO10, 
					weaponStats.AWA10, 
					weaponStats.APE20, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.ASO00, 
					weaponStats.ASA00, 
					weaponStats.AWA21, 
					weaponStats.ATO10, 
					weaponStats.APO21, 
					weaponStats.AWA01, 
					weaponStats.AWO01, 
					weaponStats.ATO21, 
					weaponStats.APO10, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			APA00: {
				chatalias: "APA00",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.APA00, 
					weaponStats.ASA00, 
					weaponStats.AWA00, 
					weaponStats.APO00, 
					weaponStats.ASA20, 
					weaponStats.AWA10, 
					weaponStats.AWA20, 
					weaponStats.APE20, 
					weaponStats.APO01, 
					weaponStats.ASO00, 
					weaponStats.ASE00, 
					weaponStats.ATO00, 
					weaponStats.APE10, 
					weaponStats.AWO00, 
					weaponStats.AWA01, 
					weaponStats.APA11, 
					weaponStats.APO10, 
					weaponStats.APE21, 
					weaponStats.ATE20, 
					weaponStats.AWO10, 
					weaponStats.ATO01, 
					weaponStats.ATE10, 
					weaponStats.APE11, 
					weaponStats.ASE20, 
					weaponStats.ATO20, 
					weaponStats.AWA21, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.ATO10, 
					weaponStats.APO21, 
					weaponStats.APO11, 
					weaponStats.AWA11, 
					weaponStats.AWO01, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			AWO00: {
				chatalias: "AWO00",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.AWO00, 
					weaponStats.AWO10, 
					weaponStats.ASO00, 
					weaponStats.ATO00, 
					weaponStats.AWA00, 
					weaponStats.AWO01, 
					weaponStats.APO00, 
					weaponStats.AWA10, 
					weaponStats.AWA20, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.ASA00, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.APA00, 
					weaponStats.ATO10, 
					weaponStats.AWA01, 
					weaponStats.APO10, 
					weaponStats.ATE20, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.APE20, 
					weaponStats.AWE11, 
					weaponStats.ATE10, 
					weaponStats.ASE20, 
					weaponStats.APE10, 
					weaponStats.AWA21, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.APO11, 
					weaponStats.AWA11, 
					weaponStats.ATO21, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			AWA00: {
				chatalias: "AWA00",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.AWA00, 
					weaponStats.AWA10, 
					weaponStats.AWA20, 
					weaponStats.ASA00, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.AWA01, 
					weaponStats.ASA20, 
					weaponStats.AWO10, 
					weaponStats.ASO00, 
					weaponStats.ASE00, 
					weaponStats.ATO00, 
					weaponStats.AWA21, 
					weaponStats.AWA11, 
					weaponStats.AWO01, 
					weaponStats.APO00, 
					weaponStats.ATE20, 
					weaponStats.APE20, 
					weaponStats.AWE11, 
					weaponStats.ATO01, 
					weaponStats.ATE10, 
					weaponStats.APO01, 
					weaponStats.ASE20, 
					weaponStats.ATO20, 
					weaponStats.APE10, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.ATO10, 
					weaponStats.APA11, 
					weaponStats.APO10, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ATO10: {
				chatalias: "ATO10",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ATO10, 
					weaponStats.AWO10, 
					weaponStats.ATE10, 
					weaponStats.ATO20, 
					weaponStats.ATO00, 
					weaponStats.ASO10, 
					weaponStats.ATO11, 
					weaponStats.APO10, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.AWA10, 
					weaponStats.ATO01, 
					weaponStats.ASO00, 
					weaponStats.APE10, 
					weaponStats.AWO00, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
					weaponStats.ATO21, 
					weaponStats.APO00, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.AWA20, 
					weaponStats.APE20, 
					weaponStats.AWE11, 
					weaponStats.APO01, 
					weaponStats.APE11, 
					weaponStats.ASA00, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.ASO01, 
					weaponStats.ASE11, 
					weaponStats.APA00, 
					weaponStats.AWA00, 
					weaponStats.APO21, 
					weaponStats.AWA11, 
					weaponStats.ATE21, 
					weaponStats.AWO01, 
					weaponStats.APA11, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ATO11: {
				chatalias: "ATO11",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ATO11, 
					weaponStats.ATE11, 
					weaponStats.ATO01, 
					weaponStats.ATO10, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
					weaponStats.ATO21, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.AWE11, 
					weaponStats.ATE10, 
					weaponStats.APO01, 
					weaponStats.APE11, 
					weaponStats.ATO20, 
					weaponStats.ATO00, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.ASE11, 
					weaponStats.APO21, 
					weaponStats.AWA11, 
					weaponStats.ATE21, 
					weaponStats.AWO01, 
					weaponStats.APA11, 
					weaponStats.APO10, 
					weaponStats.APE21, 
					weaponStats.ATE20, 
					weaponStats.AWA10, 
					weaponStats.ASO00, 
					weaponStats.APE10, 
					weaponStats.AWA21, 
					weaponStats.AWO00, 
					weaponStats.AWA01, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ASO11: {
				chatalias: "ASO11",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ASO11, 
					weaponStats.ASO21, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.ASE11, 
					weaponStats.ATO11, 
					weaponStats.APO11, 
					weaponStats.ATE11, 
					weaponStats.AWO10, 
					weaponStats.AWE11, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.APE11, 
					weaponStats.ASO00, 
					weaponStats.ATO10, 
					weaponStats.APO21, 
					weaponStats.AWA11, 
					weaponStats.AWO01, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
					weaponStats.APO10, 
					weaponStats.APE21, 
					weaponStats.ASA20, 
					weaponStats.AWA10, 
					weaponStats.ATE10, 
					weaponStats.ASA00, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.ATO00, 
					weaponStats.APE10, 
					weaponStats.AWA21, 
					weaponStats.AWO00, 
					weaponStats.AWA01, 
					weaponStats.ATE21, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			APO21: {
				chatalias: "APO21",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.APO21, 
					weaponStats.APE21, 
					weaponStats.ASO21, 
					weaponStats.APO01, 
					weaponStats.APO11, 
					weaponStats.ATO21, 
					weaponStats.APE20, 
					weaponStats.ATO01, 
					weaponStats.APE11, 
					weaponStats.ATO20, 
					weaponStats.AWA21, 
					weaponStats.ASO01, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.ATE21, 
					weaponStats.AWO01, 
					weaponStats.APA11, 
					weaponStats.APO10, 
					weaponStats.APO00, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.ASA20, 
					weaponStats.AWO10, 
					weaponStats.AWA20, 
					weaponStats.AWE11, 
					weaponStats.ASO00, 
					weaponStats.ASE20, 
					weaponStats.ATO00, 
					weaponStats.APE10, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.ATO10, 
					weaponStats.AWA11, 
					weaponStats.AWA01, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			APO11: {
				chatalias: "APO11",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.APO11, 
					weaponStats.APO01, 
					weaponStats.APE11, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.APA11, 
					weaponStats.APO10, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.AWE11, 
					weaponStats.ATO01, 
					weaponStats.APE10, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.ASE11, 
					weaponStats.ATO10, 
					weaponStats.AWA11, 
					weaponStats.AWO01, 
					weaponStats.ATO21, 
					weaponStats.APO00, 
					weaponStats.AWA10, 
					weaponStats.APE20, 
					weaponStats.ATE10, 
					weaponStats.ASO00, 
					weaponStats.ATO20, 
					weaponStats.ATO00, 
					weaponStats.AWA21, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.AWA01, 
					weaponStats.ATE21, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			AWA11: {
				chatalias: "AWA11",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.AWA11, 
					weaponStats.AWA10, 
					weaponStats.AWE11, 
					weaponStats.AWA21, 
					weaponStats.AWA01, 
					weaponStats.APA11, 
					weaponStats.ATE11, 
					weaponStats.AWO10, 
					weaponStats.AWA20, 
					weaponStats.APE11, 
					weaponStats.ASE11, 
					weaponStats.AWA00, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
					weaponStats.AWO01, 
					weaponStats.APE21, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.ATO01, 
					weaponStats.ATE10, 
					weaponStats.APO01, 
					weaponStats.ASA00, 
					weaponStats.APE10, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.ATO10, 
					weaponStats.APO21, 
					weaponStats.ATE21, 
					weaponStats.ATO21, 
					weaponStats.APO10, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			AWA01: {
				chatalias: "AWA01",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.AWA01, 
					weaponStats.AWA21, 
					weaponStats.AWA00, 
					weaponStats.AWA11, 
					weaponStats.AWO01, 
					weaponStats.AWA10, 
					weaponStats.AWA20, 
					weaponStats.AWE11, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.ASA00, 
					weaponStats.ASO01, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.APA11, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.APE11, 
					weaponStats.ASO00, 
					weaponStats.ASE00, 
					weaponStats.ATO00, 
					weaponStats.ASE11, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.APO11, 
					weaponStats.ATE21, 
					weaponStats.ATO21, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ATE21: {
				chatalias: "ATE21",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ATE21, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.ATO21, 
					weaponStats.ASO21, 
					weaponStats.APE20, 
					weaponStats.AWE11, 
					weaponStats.ATO01, 
					weaponStats.ATE10, 
					weaponStats.APE11, 
					weaponStats.ASE20, 
					weaponStats.ATO20, 
					weaponStats.AWA21, 
					weaponStats.ASE11, 
					weaponStats.ATO11, 
					weaponStats.APO21, 
					weaponStats.ASA20, 
					weaponStats.AWA20, 
					weaponStats.APO01, 
					weaponStats.ASE00, 
					weaponStats.ATO00, 
					weaponStats.APE10, 
					weaponStats.ASO01, 
					weaponStats.ATO10, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
					weaponStats.AWA11, 
					weaponStats.AWA01, 
					weaponStats.AWO01, 
					weaponStats.APA11, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			AWO01: {
				chatalias: "AWO01",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.AWO01, 
					weaponStats.ATO01, 
					weaponStats.APO01, 
					weaponStats.ASO01, 
					weaponStats.AWO00, 
					weaponStats.AWA01, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.AWE11, 
					weaponStats.ASO00, 
					weaponStats.ATO00, 
					weaponStats.AWA21, 
					weaponStats.AWA00, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.APO11, 
					weaponStats.AWA11, 
					weaponStats.ATO21, 
					weaponStats.APO00, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.AWA10, 
					weaponStats.AWA20, 
					weaponStats.APE11, 
					weaponStats.ASA00, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.APA00, 
					weaponStats.ATO10, 
					weaponStats.ATE21, 
					weaponStats.APA11, 
					weaponStats.APO10, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			ATO21: {
				chatalias: "ATO21",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.ATO21, 
					weaponStats.ASO21, 
					weaponStats.ATO01, 
					weaponStats.ATO20, 
					weaponStats.ATO11, 
					weaponStats.APO21, 
					weaponStats.ATE21, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.APO01, 
					weaponStats.ATO00, 
					weaponStats.AWA21, 
					weaponStats.ASO01, 
					weaponStats.ATO10, 
					weaponStats.ASO11, 
					weaponStats.APO11, 
					weaponStats.AWO01, 
					weaponStats.ASA20, 
					weaponStats.AWO10, 
					weaponStats.AWA20, 
					weaponStats.APE20, 
					weaponStats.AWE11, 
					weaponStats.ATE10, 
					weaponStats.APE11, 
					weaponStats.ASO00, 
					weaponStats.ASE20, 
					weaponStats.ASO10, 
					weaponStats.ASE11, 
					weaponStats.AWO00, 
					weaponStats.AWA11, 
					weaponStats.AWA01, 
					weaponStats.APA11, 
					weaponStats.APO10, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			APA11: {
				chatalias: "APA11",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.APA11, 
					weaponStats.APE11, 
					weaponStats.APO11, 
					weaponStats.AWA11, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.AWA10, 
					weaponStats.AWE11, 
					weaponStats.APO01, 
					weaponStats.APE10, 
					weaponStats.AWA21, 
					weaponStats.ASE11, 
					weaponStats.APA00, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.AWA01, 
					weaponStats.APO10, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.AWO10, 
					weaponStats.AWA20, 
					weaponStats.APE20, 
					weaponStats.ATO01, 
					weaponStats.ATE10, 
					weaponStats.ASA00, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.AWA00, 
					weaponStats.ATO10, 
					weaponStats.ATE21, 
					weaponStats.AWO01, 
					weaponStats.ATO21, 
					weaponStats.APO00, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			APO10: {
				chatalias: "APO10",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.APO10, 
					weaponStats.AWO10, 
					weaponStats.APE10, 
					weaponStats.ASO10, 
					weaponStats.ATO10, 
					weaponStats.APO11, 
					weaponStats.APO00, 
					weaponStats.AWA10, 
					weaponStats.APE20, 
					weaponStats.ATE10, 
					weaponStats.APO01, 
					weaponStats.APE11, 
					weaponStats.ASO00, 
					weaponStats.ATO20, 
					weaponStats.ATO00, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.APO21, 
					weaponStats.APA11, 
					weaponStats.APE21, 
					weaponStats.ATE11, 
					weaponStats.ATE20, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.AWA20, 
					weaponStats.AWE11, 
					weaponStats.ATO01, 
					weaponStats.ASA00, 
					weaponStats.ASE20, 
					weaponStats.ASE00, 
					weaponStats.ASO01, 
					weaponStats.ASE11, 
					weaponStats.AWA00, 
					weaponStats.AWA11, 
					weaponStats.AWO01, 
					weaponStats.ATO21, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
			APO00: {
				chatalias: "APO00",
				weaponPaths: [ // weapons to use; put late-game paths below!
					weaponStats.APO00, 
					weaponStats.APO01, 
					weaponStats.ASO00, 
					weaponStats.ATO00, 
					weaponStats.APA00, 
					weaponStats.AWO00, 
					weaponStats.APO10, 
					weaponStats.AWO10, 
					weaponStats.APE20, 
					weaponStats.ATO01, 
					weaponStats.ASA00, 
					weaponStats.ASE00, 
					weaponStats.ATO20, 
					weaponStats.APE10, 
					weaponStats.ASO10, 
					weaponStats.ASO01, 
					weaponStats.AWA00, 
					weaponStats.ATO10, 
					weaponStats.APO21, 
					weaponStats.APO11, 
					weaponStats.AWO01, 
					weaponStats.APE21, 
					weaponStats.ATE20, 
					weaponStats.ASA20, 
					weaponStats.ASO21, 
					weaponStats.AWA10, 
					weaponStats.AWA20, 
					weaponStats.ATE10, 
					weaponStats.APE11, 
					weaponStats.ASE20, 
					weaponStats.ATO11, 
					weaponStats.ASO11, 
					weaponStats.AWA01, 
					weaponStats.ATO21, 
					weaponStats.APA11, 
		
				],
				earlyResearch: [ // fixed research path for the early game
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
