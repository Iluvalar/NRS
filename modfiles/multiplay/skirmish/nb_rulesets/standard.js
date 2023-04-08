
/*
 * This file describes standard stats and strategies of
 * the base (unmodded) game.
 *
 * If you want to make an AI specially designed for your mod, start by
 * making a copy of this file and modifying it according to your mod's rules.
 *
 * Then provide a personality to use the ruleset, similar to
 * how nb_generic.[js|ai] is provided for this ruleset.
 *
 * You may find some useful functions for working with these stats
 * in stats.js .
 *
 */

// a factor for figuring out how large things are in this ruleset,
// or simply a typical radius of a player's base
const baseScale = 40;

// diameter of laser satellite splash/incendiary damage
// for use in lassat.js
const lassatSplash = 4;

// set this to 1 to choose templates randomly, instead of later=>better.
const randomTemplates = 0;

// this function is used for avoiding AI cheats that appear due to
// being able to build droids before designing them
function iCanDesign() {
	if (difficulty === INSANE) // won't make INSANE much worse ...
		return true;
	return countFinishedStructList(structures.hqs) > 0;
}

const structures = {
	factories: [ "A0LightFactory", "WreckedTransporter" ,"OldFactory", "A0CyborgFactory"],
	templateFactories: [ "A0CyborgFactory", ],
	vtolFactories: [ "A0VTolFactory1", ],
	labs: [ "A0ResearchFacility", "Laseropticslab", ],
	gens: [ "A0PowerGenerator", "A0BaBaPowerGenerator",],
	hqs: [ "A0CommandCentre", ],
	vtolPads: [ "A0VtolPad", ],
	derricks: [ "A0ResourceExtractor" ,],
	extras: [ "A0RepairCentre3", "A0Sat-linkCentre", "A0LasSatCommand" ],
//	powerstuff: ["AirTrafficControl-nrs", "Propaganda-nrs","WaterTower-nrs","OilTower-nrs", "Park-nrs","Forest-nrs","Tree-nrs","BigForest-nrs","NuclearReactor","SolarPower-nrs","Powlab-nrs","Advmaterialslab-nrs","Aerodynamicslab-nrs","Ruin1-nrs","BarbHUT-nrs","cabin-nrs","building10-nrs","LogCabin3-nrs","building12-nrs","building11-nrs","building2-nrs","building3-nrs","BarbWarehouse1-nrs","BarbWarehouse2-nrs","BarbWarehouse3-nrs","Rotarywepslab-nrs","Heavywepslab-nrs" ],
	powerstuff: ["OilTower-eco","BarbWarehouse2-eco","Forest-eco","Heavywepslab-eco","LogCabin3-eco","BigForest-eco","cabin-eco","Powlab-eco","Park-eco","building11-eco","AirTrafficControl-eco","Pickup-eco","building10-eco","Ruin1-eco","Aerodynamicslab-eco","Boulder3-eco","Tree-eco","building12-eco","CoolingTower-eco","SolarPower-eco","Rotarywepslab-eco","Boulder1-eco","Boulder2-eco","building3-eco","Advmaterialslab-eco","A0ResourceExtractor-eco"],
	//powerstuff: ["A0RepairCentre3","AirTrafficControl-nrs","OilTower-nrs","WaterTower-nrs","Propaganda-nrs","Aerodynamicslab-nrs","Advmaterialslab-nrs","Powlab-nrs","SolarPower-nrs","NuclearReactor","BigForest-nrs","Tree-nrs","Forest-nrs","Park-nrs","road-nrs","Heavywepslab-nrs","Rotarywepslab-nrs","BarbWarehouse3-nrs","BarbWarehouse2-nrs","BarbWarehouse1-nrs","building3-nrs","building2-nrs","building11-nrs","building12-nrs","LogCabin3-nrs","building10-nrs","cabin-nrs","BarbHUT-nrs","Ruin1-nrs","A0FacMod1","A0PowMod1"],
	sensors: [ "Sys-SensoTower02", "Sys-CB-Tower01", "Sys-RadarDetector01", "Sys-SensoTowerWS", ],
};

const oilResources = [ "OilResource", ];

const powerUps = [ "OilDrum", "Crate" ];

// NOTE: you cannot use specific stats as bases, but only stattypes
// probably better make use of .name rather than of .stattype here?
const modules = [
	{ base: POWER_GEN, module: "A0PowMod1", count: 1, cost: MODULECOST.CHEAP },
	{ base: FACTORY, module: "A0FacMod1", count: 2, cost: MODULECOST.EXPENSIVE },
	{ base: VTOL_FACTORY, module: "A0FacMod1", count: 2, cost: MODULECOST.EXPENSIVE },
	{ base: RESEARCH_LAB, module: "A0ResearchModule1", count: 1, cost: MODULECOST.EXPENSIVE },
];

const targets = []
	.concat(structures.derricks)
	.concat(structures.derricks)
	.concat(structures.derricks)
	.concat(structures.factories)
	.concat(structures.factories)
	.concat(structures.templateFactories)
	.concat(structures.templateFactories)
	.concat(structures.vtolFactories)
	.concat(structures.extras)
	.concat(structures.powerstuff)
;

const miscTargets = []
	.concat(structures.derricks)
	.concat(structures.powerstuff)
;

const sensorTurrets = [
	"SensorTurret1Mk1", // sensor
	"Sensor-WideSpec", // wide spectrum sensor
];
//BarbHUT,building10,building3,Park,AirTrafficControl
//"BigForest-eco","LogCabin3-eco","Heavywepslab-eco","Forest-eco","cabin-eco","OilTower-eco"]
const fundamentalResearch = [
	//"R-NRS-road-nrs",
	"R-NRS-A0BaBaFactory",
	"R-NRS-tracked01",
	//"R-NRS-CyborgHeavyBody-2120",
	"R-NRS-A0RepairCentre3",
	//"R-NRS-A0CyborgFactory",
	//"R-NRS-NuclearReactor",
	//"R-NRS-Park-nrs",
	"R-NRS-BigForest-eco3",
	"R--ResearchPoints-3",
	"R--ProductionPoints-3",
	"R-NRS-LogCabin3-eco3",
	"R--ResearchPoints-6",
	"R--ProductionPoints-6",
	"R--ResearchPoints-9",
	"R--ProductionPoints-9",	
	"R-Sys-Autorepair-General",
	"R-NRS-Heavywepslab-eco3",
	//"R-hover01-HitpointPctOfBody-9",
	//"R-wheeled01-HitpointPctOfBody-9",
	"R-NRS-Forest-eco3",
	"R--Range-9",
	"R-NRS-OilTower-eco3",
	/*
	"R-Struc-RprFac-Upgrade01",
	"R-Sys-Sensor-Tower02",
	"R-Vehicle-Prop-Halftracks",
	"R-Struc-Power-Upgrade01c",
	"R-Vehicle-Prop-Tracks",
	"R-Sys-CBSensor-Tower01",
	"R-Struc-VTOLPad-Upgrade01",
	"R-Struc-Power-Upgrade03a",
	"R-Struc-VTOLPad-Upgrade03",
	"R-Sys-Autorepair-General",
	"R-Wpn-LasSat",
	"R-Struc-RprFac-Upgrade04",
	"R-Struc-VTOLPad-Upgrade06",
	"R-Struc-RprFac-Upgrade06",
	*/
];

const fastestResearch = [
	"R--ResearchPoints-9",
];

// body and propulsion arrays don't affect fixed template droids
const bodyStats = [
			//{ res: "R-NRS-CyborgLightBody", stat: "CyborgLightBody", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			//{ res: "R-NRS-CyborgHeavyBody", stat: "CyborgHeavyBody", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			//{ res: "R-NRS-CyborgHeavyBody-2120", stat: "CyborgHeavyBody-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			/*
			{ res: "R-NRS-CyborgLightBody", stat: "CyborgLightBody", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-CyborgHeavyBody", stat: "CyborgHeavyBody", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-CyborgHeavyBody-2120", stat: "CyborgHeavyBody-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body11ABT", stat: "Body11ABT", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body12SUP", stat: "Body12SUP", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body9REC", stat: "Body9REC", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body10MBT", stat: "Body10MBT", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body13SUP", stat: "Body13SUP", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body14SUP", stat: "Body14SUP", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			*/
			{ res: "R-NRS-A0BaBaFactory", stat: "B1BaBaPerson01", weight: WEIGHT.ULTRALIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body5REC", stat: "Body5REC", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body11ABT", stat: "Body11ABT", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			//{ res: "R-NRS-Body9REC", stat: "Body9REC", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-ScavCamperBody", stat: "ScavCamperBody", weight: WEIGHT.ULTRALIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-ScavIcevanBody", stat: "ScavIcevanBody", weight: WEIGHT.ULTRALIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-B3body-sml-buggy01-Ultimate", stat: "B3body-sml-buggy01-Ultimate", weight: WEIGHT.ULTRALIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-B2tractor", stat: "B2tractor", weight: WEIGHT.ULTRALIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-ScavNEXUStrack", stat: "ScavNEXUStrack", weight: WEIGHT.ULTRALIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-BusBody", stat: "BusBody", weight: WEIGHT.ULTRALIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-B2JeepBody-Ultimate", stat: "B2JeepBody-Ultimate", weight: WEIGHT.ULTRALIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-FireBody", stat: "FireBody", weight: WEIGHT.ULTRALIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-B4body-sml-trike01-Ultimate", stat: "B4body-sml-trike01-Ultimate", weight: WEIGHT.ULTRALIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-B3bodyRKbuggy01-Ultimate", stat: "B3bodyRKbuggy01", weight: WEIGHT.ULTRALIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body1REC", stat: "Body1REC", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			/*
			{ res: "R-NRS-Body4ABT", stat: "Body4ABT", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body2SUP", stat: "Body2SUP", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body3MBT", stat: "Body3MBT", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body3MBT-2120", stat: "Body3MBT-2120", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			
			{ res: "R-NRS-Body8MBT", stat: "Body8MBT", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body6SUPP", stat: "Body6SUPP", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body7ABT", stat: "Body7ABT", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			*/
			{ res: "R-NRS-Body7ALT-2120", stat: "Body7ALT-2120", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body1UPG-2120", stat: "Body1UPG-2120", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body2SUP-2120", stat: "Body2SUP-2120", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body3MBT-2120", stat: "Body3MBT-2120", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body3SUP-2120", stat: "Body3SUP-2120", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body3ALT-2120", stat: "Body3ALT-2120", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body4ABT-2120", stat: "Body4ABT-2120", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body4UPG-2120", stat: "Body4UPG-2120", weight: WEIGHT.LIGHT , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body9REC-2120", stat: "Body9REC-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body10REC-2120", stat: "Body10REC-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body12SUPP-2120", stat: "Body12SUPP-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body10ALT-2120", stat: "Body10ALT-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body7ABT-2120", stat: "Body7ABT-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body11UPG-2120", stat: "Body11UPG-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body12SUP-2120", stat: "Body12SUP-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body12UPG-2120", stat: "Body12UPG-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body14SUP-2120", stat: "Body14SUP-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body13SUP-2120", stat: "Body13SUP-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body17SUUP-2120", stat: "Body17SUUP-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body26SUP-2120", stat: "Body26SUP-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body27SUP-2120", stat: "Body27SUP-2120", weight: WEIGHT.HEAVY , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL },
			{ res: "R-NRS-Body7ALT-2120", stat: "Body7ALT-2120", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body8MBT-2120", stat: "Body8MBT-2120", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body8UPG-2120", stat: "Body8UPG-2120", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body16MBTT-2120", stat: "Body16MBTT-2120", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body25DKD-2120", stat: "Body25DKD-2120", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body6SUPP-2120", stat: "Body6SUPP-2120", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			{ res: "R-NRS-Body7SUPP-2120", stat: "Body7SUPP-2120", weight: WEIGHT.MEDIUM , usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC },
			
			
			/*
	{ res: "R-Vehicle-Body01", stat: "Body1REC", weight: WEIGHT.LIGHT, usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC }, // viper
	{ res: "R-Vehicle-Body05", stat: "Body5REC", weight: WEIGHT.MEDIUM, usage: BODYUSAGE.COMBAT, armor: BODYCLASS.KINETIC }, // cobra
	{ res: "R-Vehicle-Body11", stat: "Body11ABT", weight: WEIGHT.HEAVY, usage: BODYUSAGE.GROUND, armor: BODYCLASS.KINETIC }, // python
	{ res: "R-Vehicle-Body02", stat: "Body2SUP", weight: WEIGHT.LIGHT, usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.KINETIC }, // leopard
	{ res: "R-Vehicle-Body06", stat: "Body6SUPP", weight: WEIGHT.MEDIUM, usage: BODYUSAGE.COMBAT, armor: BODYCLASS.KINETIC }, // panther
	{ res: "R-Vehicle-Body09", stat: "Body9REC", weight: WEIGHT.HEAVY, usage: BODYUSAGE.GROUND, armor: BODYCLASS.KINETIC }, // tiger
	{ res: "R-Vehicle-Body13", stat: "Body13SUP", weight: WEIGHT.HEAVY, usage: BODYUSAGE.GROUND, armor: BODYCLASS.KINETIC }, // wyvern
	{ res: "R-Vehicle-Body14", stat: "Body14SUP", weight: WEIGHT.HEAVY, usage: BODYUSAGE.GROUND, armor: BODYCLASS.KINETIC }, // dragon
	{ res: "R-Vehicle-Body04", stat: "Body4ABT", weight: WEIGHT.LIGHT, usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL }, // bug
	{ res: "R-Vehicle-Body08", stat: "Body8MBT", weight: WEIGHT.HEAVY, usage: BODYUSAGE.COMBAT, armor: BODYCLASS.THERMAL }, // scorpion
	{ res: "R-Vehicle-Body12", stat: "Body12SUP", weight: WEIGHT.HEAVY, usage: BODYUSAGE.GROUND, armor: BODYCLASS.THERMAL }, // mantis
	{ res: "R-Vehicle-Body03", stat: "Body3MBT", weight: WEIGHT.MEDIUM, usage: BODYUSAGE.UNIVERSAL, armor: BODYCLASS.THERMAL }, // retaliation
	{ res: "R-Vehicle-Body07", stat: "Body7ABT", weight: WEIGHT.HEAVY, usage: BODYUSAGE.COMBAT, armor: BODYCLASS.THERMAL }, // retribution
	{ res: "R-Vehicle-Body10", stat: "Body10MBT", weight: WEIGHT.HEAVY, usage: BODYUSAGE.GROUND, armor: BODYCLASS.THERMAL }, // vengeance
	*/
];

const classResearch = {
	kinetic: [
		[ // OBJTYPE.TANK
			"R-Droids-HitPointPct-9",
			"R-tracked01-HitpointPctOfBody-9",
		],
		[ // OBJTYPE.BORG
			"R-Droids-HitPointPct-9",
			"R-CyborgLegs-HitpointPctOfBody-18",
		],
		[ // OBJTYPE.DEFS
			"R-Wall-HitPoints-18",
		],
		[ // OBJTYPE.VTOL
			"R-Droids-HitPointPct-9",
		],
	],
	thermal: [
		[ // OBJTYPE.TANK
			"R-Droids-HitPointPct-9",
		],
		[ // OBJTYPE.BORG
			"R-Droids-HitPointPct-9",
		],
		[ // OBJTYPE.DEFS
			"R-Wall-HitPoints-18",
		],
		[ // OBJTYPE.VTOL
			"R-Droids-HitPointPct-9",
		],
	],
};

// NOTE: Please don't put hover propulsion into the ground list, etc.!
// NOTE: Hover propulsion should be placed AFTER ground propulsion!
// Adaptation code relies on that for discovering map topology.
// Ground propulsions need to be ground only, hover propulsions shouldn't
// be able to cross cliffs, but should be able to cross seas, etc.
const propulsionStats = [
	{ res: "R-NRS-wheeled01", stat: "wheeled01", usage: PROPULSIONUSAGE.GROUND },
	{ res: "R-NRS-HalfTrack", stat: "HalfTrack", usage: PROPULSIONUSAGE.GROUND },
	{ res: "R-NRS-tracked01", stat: "tracked01", usage: PROPULSIONUSAGE.GROUND },
	{ res: "R-NRS-hover01", stat: "hover01", usage: PROPULSIONUSAGE.HOVER },
	//{ res: "R-Vehicle-Prop-VTOL", stat: "V-Tol", usage: PROPULSIONUSAGE.VTOL },
];


const truckTurrets = [
	"Spade1Mk1",
];

const truckTemplates = [
	{ body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "CyborgSpade", ] } // engineer
];

const fallbackWeapon = 'machinegun';

// Unlike bodies and propulsions, weapon lines don't have any specific meaning.
// You can make as many weapon lines as you want for your ruleset.
const weaponStats = {
	heavylaser : {
		roles : [ 0.1, 0.5, 0.2, 0.2 ],
		micro : MICRO.RANGED,
		chatalias : 1,
		weapons : [
			{ res: "R-NRS-Laser3BEAMMk1", stat: "Laser3BEAMMk1", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Laser2PULSEMk1", stat: "Laser2PULSEMk1", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-AAGunLaser", stat: "AAGunLaser", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Laser3BEAMMk1-2120", stat: "Laser3BEAMMk1-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Laser4-PlasmaCannon", stat: "Laser4-PlasmaCannon", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-HeavyLaser", stat: "HeavyLaser", weight: WEIGHT.HEAVY },
		],
		vtols : [
			{ res: "R-NRS-Laser3BEAMMk1", stat: "Laser3BEAM-VTOL", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Laser2PULSEMk1", stat: "Laser2PULSE-VTOL", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Laser3BEAMMk1-2120", stat: "Laser3BEAM-VTOL-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-HeavyLaser", stat: "HeavyLaser-VTOL", weight: WEIGHT.HEAVY },
		],
		defenses : [
			{ res: "R-NRS-Laser3BEAMMk1", stat: "walltower-Laser3BEAMMk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Laser2PULSEMk1", stat: "walltower-Laser2PULSEMk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-AAGunLaser", stat: "walltower-AAGunLaser", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Laser3BEAMMk1-2120", stat: "walltower-Laser3BEAMMk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Laser4-PlasmaCannon", stat: "walltower-Laser4-PlasmaCannon", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-HeavyLaser", stat: "walltower-HeavyLaser", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-Laser3BEAMMk1", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Laser3BEAMMk1", ] },
			{ res: "R-NRS-Laser3BEAMMk1", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-Laser", ] },
			{ res: "R-NRS-Laser3BEAMMk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Laser3BEAMMk1-BABA", ] },
			{ res: "R-NRS-Laser2PULSEMk1", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Laser2PULSEMk1", ] },
			{ res: "R-NRS-Laser2PULSEMk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Laser2PULSEMk1-BABA", ] },
			{ res: "R-NRS-AAGunLaser", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "AAGunLaser", ] },
			{ res: "R-NRS-AAGunLaser", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "AAGunLaser-BABA", ] },
			{ res: "R-NRS-Laser3BEAMMk1-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Laser3BEAMMk1-2120", ] },
			{ res: "R-NRS-Laser3BEAMMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Laser3BEAMMk1-2120-BABA", ] },
			{ res: "R-NRS-Laser4-PlasmaCannon", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Laser4-PlasmaCannon", ] },
			{ res: "R-NRS-Laser4-PlasmaCannon", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Laser4-PlasmaCannon-BABA", ] },
			{ res: "R-NRS-HeavyLaser", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "HeavyLaser", ] },
			{ res: "R-NRS-HeavyLaser", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-PulseLsr", ] },
			{ res: "R-NRS-HeavyLaser", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "HeavyLaser-BABA", ] },
		],
		extras: [
			"R-CANNON-Damage-9",
			"R-CANNON-FirePause-9",
		],
	},
	rail : {
		roles : [ 0.4, 0.3, 0.1, 0.2 ],
		micro : MICRO.RANGED,
		chatalias : 2,
		weapons : [
			{ res: "R-NRS-RailGun1Mk1", stat: "RailGun1Mk1", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-RailGun2Mk1", stat: "RailGun2Mk1", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-RailGun3Mk1", stat: "RailGun3Mk1", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Cannon4AUTOMk1-2120", stat: "Cannon4AUTOMk1-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Cannon5VulcanMk1-2120", stat: "Cannon5VulcanMk1-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Cannon775mmMk1-2120", stat: "Cannon775mmMk1-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-MG5TWINROTARY-2120", stat: "MG5TWINROTARY-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Cannon6TwinAslt-2120", stat: "Cannon6TwinAslt-2120", weight: WEIGHT.HEAVY },
		],
		vtols : [
			{ res: "R-NRS-RailGun2Mk1", stat: "RailGun2-VTOL", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Cannon5VulcanMk1-2120", stat: "Cannon5Vulcan-VTOL-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Cannon775mmMk1-2120", stat: "Cannon7-VTOL-2120", weight: WEIGHT.HEAVY },
		],
		defenses : [
			{ res: "R-NRS-RailGun1Mk1", stat: "walltower-RailGun1Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-RailGun2Mk1", stat: "walltower-RailGun2Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-RailGun3Mk1", stat: "walltower-RailGun3Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Cannon4AUTOMk1-2120", stat: "walltower-Cannon4AUTOMk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Cannon5VulcanMk1-2120", stat: "walltower-Cannon5VulcanMk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Cannon775mmMk1-2120", stat: "walltower-Cannon775mmMk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-MG5TWINROTARY-2120", stat: "walltower-MG5TWINROTARY-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Cannon6TwinAslt-2120", stat: "walltower-Cannon6TwinAslt-2120", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-RailGun1Mk1", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "RailGun1Mk1", ] },
			{ res: "R-NRS-RailGun1Mk1", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-Rail1", ] },
			{ res: "R-NRS-RailGun1Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun1Mk1-BABA", ] },
			{ res: "R-NRS-RailGun2Mk1", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "RailGun2Mk1", ] },
			{ res: "R-NRS-RailGun2Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun2Mk1-BABA", ] },
			{ res: "R-NRS-RailGun3Mk1", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "RailGun3Mk1", ] },
			{ res: "R-NRS-RailGun3Mk1", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-RailGunner", ] },
			{ res: "R-NRS-RailGun3Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun3Mk1-BABA", ] },
			{ res: "R-NRS-Cannon4AUTOMk1-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cannon4AUTOMk1-2120", ] },
			{ res: "R-NRS-Cannon4AUTOMk1-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "CyborgCannon-2120", ] },
			{ res: "R-NRS-Cannon4AUTOMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cannon4AUTOMk1-2120-BABA", ] },
			{ res: "R-NRS-Cannon5VulcanMk1-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cannon5VulcanMk1-2120", ] },
			{ res: "R-NRS-Cannon5VulcanMk1-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-HPV-2120", ] },
			{ res: "R-NRS-Cannon5VulcanMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cannon5VulcanMk1-2120-BABA", ] },
			{ res: "R-NRS-Cannon775mmMk1-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cannon775mmMk1-2120", ] },
			{ res: "R-NRS-Cannon775mmMk1-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-Lcannon-2120", ] },
			{ res: "R-NRS-Cannon775mmMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cannon775mmMk1-2120-BABA", ] },
			{ res: "R-NRS-MG5TWINROTARY-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "MG5TWINROTARY-2120", ] },
			{ res: "R-NRS-MG5TWINROTARY-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-Mcannon-2120", ] },
			{ res: "R-NRS-MG5TWINROTARY-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG5TWINROTARY-2120-BABA", ] },
			{ res: "R-NRS-Cannon6TwinAslt-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cannon6TwinAslt-2120", ] },
			{ res: "R-NRS-Cannon6TwinAslt-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-RailHyp-2120", ] },
			{ res: "R-NRS-Cannon6TwinAslt-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cannon6TwinAslt-2120-BABA", ] },
		],
		extras: [
			"R-MORTARS-Damage-9",
			"R-MORTARS-FirePause-9",
		],
	},
	mortar : {
		roles : [ 0.1, 0.2, 0.5, 0.2 ],
		micro : MICRO.DUMB,
		chatalias : 3,
		weapons : [
			{ res: "R-NRS-Mortar1Mk1", stat: "Mortar1Mk1", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Howitzer105Mk1", stat: "Howitzer105Mk1", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Mortar0Mk1-2120", stat: "Mortar0Mk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Howitzer150Mk1", stat: "Howitzer150Mk1", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Mortar2Mk1", stat: "Mortar2Mk1", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Howitzer03-Rot", stat: "Howitzer03-Rot", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Mortar3ROTARYMk1", stat: "Mortar3ROTARYMk1", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Howitzer150Mk1-2120", stat: "Howitzer150Mk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Mortar2Mk1-2120", stat: "Mortar2Mk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Mortar3ROTARYMk1-2120", stat: "Mortar3ROTARYMk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Mortar3ROTARYMk1-2120", stat: "Mortar3ROTARYMk1-2120", weight: WEIGHT.MEDIUM },
		],
		vtols : [
		],
		defenses : [
			{ res: "R-NRS-Mortar1Mk1", stat: "walltower-Mortar1Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Howitzer105Mk1", stat: "walltower-Howitzer105Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Mortar0Mk1-2120", stat: "walltower-Mortar0Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Howitzer150Mk1", stat: "walltower-Howitzer150Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Mortar2Mk1", stat: "walltower-Mortar2Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Howitzer03-Rot", stat: "walltower-Howitzer03-Rot", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Mortar3ROTARYMk1", stat: "walltower-Mortar3ROTARYMk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Howitzer150Mk1-2120", stat: "walltower-Howitzer150Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Mortar2Mk1-2120", stat: "walltower-Mortar2Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Mortar3ROTARYMk1-2120", stat: "walltower-Mortar3ROTARYMk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Mortar3ROTARYMk1-2120", stat: "walltower-Mortar3ROTARYMk1-2120", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-Mortar1Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar1Mk1", ] },
			{ res: "R-NRS-Mortar1Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-Grenade", ] },
			{ res: "R-NRS-Mortar1Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar1Mk1-BABA", ] },
			{ res: "R-NRS-Howitzer105Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Howitzer105Mk1", ] },
			{ res: "R-NRS-Howitzer105Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Howitzer105Mk1-BABA", ] },
			{ res: "R-NRS-Mortar0Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar0Mk1-2120", ] },
			{ res: "R-NRS-Mortar0Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar0Mk1-2120-BABA", ] },
			{ res: "R-NRS-Howitzer150Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Howitzer150Mk1", ] },
			{ res: "R-NRS-Howitzer150Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Howitzer150Mk1-BABA", ] },
			{ res: "R-NRS-Mortar2Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar2Mk1", ] },
			{ res: "R-NRS-Mortar2Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar2Mk1-BABA", ] },
			{ res: "R-NRS-Howitzer03-Rot", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Howitzer03-Rot", ] },
			{ res: "R-NRS-Howitzer03-Rot", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Howitzer03-Rot-BABA", ] },
			{ res: "R-NRS-Mortar3ROTARYMk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar3ROTARYMk1", ] },
			{ res: "R-NRS-Mortar3ROTARYMk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar3ROTARYMk1-BABA", ] },
			{ res: "R-NRS-Howitzer150Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Howitzer150Mk1-2120", ] },
			{ res: "R-NRS-Howitzer150Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Howitzer150Mk1-2120-BABA", ] },
			{ res: "R-NRS-Mortar2Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar2Mk1-2120", ] },
			{ res: "R-NRS-Mortar2Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar2Mk1-2120-BABA", ] },
			{ res: "R-NRS-Mortar3ROTARYMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar3ROTARYMk1-2120", ] },
			{ res: "R-NRS-Mortar3ROTARYMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar3ROTARYMk1-2120-BABA", ] },
			{ res: "R-NRS-Mortar3ROTARYMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar3ROTARYMk1-2120", ] },
			{ res: "R-NRS-Mortar3ROTARYMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-Grenade-2120", ] },
			{ res: "R-NRS-Mortar3ROTARYMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Mortar3ROTARYMk1-2120-BABA", ] },
		],
		extras: [
			"R-MISSILE-Damage-9",
			"R-MISSILE-FirePause-9",
		],
	},
	scavenger : {
		roles : [ 0.3, 0.3, 0.3, 0.3 ],
		micro : MICRO.RANGED,
		chatalias : 4,
		weapons : [
			{ res: "R-NRS-BusCannon", stat: "BusCannon", weight: WEIGHT.ULTRALIGHT },
			{ res: "R-NRS-BabaRocket", stat: "BabaRocket", weight: WEIGHT.ULTRALIGHT },
			{ res: "R-NRS-BabaFlame", stat: "BabaFlame", weight: WEIGHT.ULTRALIGHT },
			{ res: "R-NRS-BabaPitRocket", stat: "BabaPitRocket", weight: WEIGHT.ULTRALIGHT },
			{ res: "R-NRS-BabaPitRocketAT", stat: "BabaPitRocketAT", weight: WEIGHT.ULTRALIGHT },
			{ res: "R-NRS-ScavNEXUSlink", stat: "ScavNEXUSlink", weight: WEIGHT.ULTRALIGHT },
			{ res: "R-NRS-BuggyMG", stat: "BuggyMG", weight: WEIGHT.ULTRALIGHT },
			{ res: "R-NRS-BJeepMG", stat: "BJeepMG", weight: WEIGHT.ULTRALIGHT },
		],
		vtols : [
		],
		defenses : [
			{ res: "R-NRS-BusCannon", stat: "walltower-BusCannon", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-BabaRocket", stat: "walltower-BabaRocket", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-BabaFlame", stat: "walltower-BabaFlame", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-BabaPitRocket", stat: "walltower-BabaPitRocket", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-BabaPitRocketAT", stat: "walltower-BabaPitRocketAT", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-ScavNEXUSlink", stat: "walltower-ScavNEXUSlink", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-BuggyMG", stat: "walltower-BuggyMG", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-BJeepMG", stat: "walltower-BJeepMG", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-BusCannon", body: "B1BaBaPerson01-nrs", prop: "CyborgLegs", weapons: [ "BusCannon", ] },
			{ res: "R-NRS-BusCannon", body: "B1BaBaPerson01-nrs", prop: "CyborgLegs", weapons: [ "bTrikeMG", ] },
			{ res: "R-NRS-BabaRocket", body: "B1BaBaPerson01-nrs", prop: "CyborgLegs", weapons: [ "BabaRocket", ] },
			{ res: "R-NRS-BabaFlame", body: "B1BaBaPerson01-nrs", prop: "CyborgLegs", weapons: [ "BabaFlame", ] },
			{ res: "R-NRS-BabaPitRocket", body: "B1BaBaPerson01-nrs", prop: "CyborgLegs", weapons: [ "BabaPitRocket", ] },
			{ res: "R-NRS-BabaPitRocketAT", body: "B1BaBaPerson01-nrs", prop: "CyborgLegs", weapons: [ "BabaPitRocketAT", ] },
			{ res: "R-NRS-ScavNEXUSlink", body: "B1BaBaPerson01-nrs", prop: "CyborgLegs", weapons: [ "ScavNEXUSlink", ] },
			{ res: "R-NRS-BuggyMG", body: "B1BaBaPerson01-nrs", prop: "CyborgLegs", weapons: [ "BuggyMG", ] },
			{ res: "R-NRS-BJeepMG", body: "B1BaBaPerson01-nrs", prop: "CyborgLegs", weapons: [ "BJeepMG", ] },
		],
		extras: [
			"R-ROCKET-Damage-9",
			"R-ROCKET-FirePause-9",
		],
	},
	machinegun : {
		roles : [ 0.1, 0.5, 0.2, 0.2 ],
		micro : MICRO.RANGED,
		chatalias : 5,
		weapons : [
			{ res: "R-NRS-MG1Mk1", stat: "MG1Mk1", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-MG2Mk1", stat: "MG2Mk1", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-MG3Mk1", stat: "MG3Mk1", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-MG4ROTARYMk1", stat: "MG4ROTARYMk1", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-MG5TWINROTARY", stat: "MG5TWINROTARY", weight: WEIGHT.LIGHT },
		],
		vtols : [
			{ res: "R-NRS-MG1Mk1", stat: "MG1-VTOL", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-MG2Mk1", stat: "MG2-VTOL", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-MG3Mk1", stat: "MG3-VTOL", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-MG4ROTARYMk1", stat: "MG4ROTARY-VTOL", weight: WEIGHT.LIGHT },
		],
		defenses : [
			{ res: "R-NRS-MG1Mk1", stat: "walltower-MG1Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-MG2Mk1", stat: "walltower-MG2Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-MG3Mk1", stat: "walltower-MG3Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-MG4ROTARYMk1", stat: "walltower-MG4ROTARYMk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-MG5TWINROTARY", stat: "walltower-MG5TWINROTARY", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-MG1Mk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "MG1Mk1", ] },
			{ res: "R-NRS-MG1Mk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "CyborgChaingun", ] },
			{ res: "R-NRS-MG1Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG1Mk1-BABA", ] },
			{ res: "R-NRS-MG2Mk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "MG2Mk1", ] },
			{ res: "R-NRS-MG2Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG2Mk1-BABA", ] },
			{ res: "R-NRS-MG3Mk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "MG3Mk1", ] },
			{ res: "R-NRS-MG3Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG3Mk1-BABA", ] },
			{ res: "R-NRS-MG4ROTARYMk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "MG4ROTARYMk1", ] },
			{ res: "R-NRS-MG4ROTARYMk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG4ROTARYMk1-BABA", ] },
			{ res: "R-NRS-MG5TWINROTARY", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "MG5TWINROTARY", ] },
			{ res: "R-NRS-MG5TWINROTARY", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "CyborgRotMG", ] },
			{ res: "R-NRS-MG5TWINROTARY", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG5TWINROTARY-BABA", ] },
		],
		extras: [
			"R-ENERGY-Damage-9",
			"R-ENERGY-FirePause-9",
		],
	},
	cannon : {
		roles : [ 0.4, 0.3, 0.1, 0.2 ],
		micro : MICRO.RANGED,
		chatalias : 6,
		weapons : [
			{ res: "R-NRS-Cannon1Mk1", stat: "Cannon1Mk1", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Cannon2A-TMk1", stat: "Cannon2A-TMk1", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Cannon375mmMk1", stat: "Cannon375mmMk1", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Cannon4AUTOMk1", stat: "Cannon4AUTOMk1", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Cannon5VulcanMk1", stat: "Cannon5VulcanMk1", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Cannon6TwinAslt", stat: "Cannon6TwinAslt", weight: WEIGHT.LIGHT },
		],
		vtols : [
			{ res: "R-NRS-Cannon1Mk1", stat: "Cannon1-VTOL", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Cannon375mmMk1", stat: "MG4ROTARY-VTOL", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Cannon4AUTOMk1", stat: "Cannon4AUTO-VTOL", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Cannon5VulcanMk1", stat: "Cannon5Vulcan-VTOL", weight: WEIGHT.LIGHT },
		],
		defenses : [
			{ res: "R-NRS-Cannon1Mk1", stat: "walltower-Cannon1Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Cannon2A-TMk1", stat: "walltower-Cannon2A-TMk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Cannon375mmMk1", stat: "walltower-Cannon375mmMk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Cannon4AUTOMk1", stat: "walltower-Cannon4AUTOMk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Cannon5VulcanMk1", stat: "walltower-Cannon5VulcanMk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Cannon6TwinAslt", stat: "walltower-Cannon6TwinAslt", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-Cannon1Mk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Cannon1Mk1", ] },
			{ res: "R-NRS-Cannon1Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cannon1Mk1-BABA", ] },
			{ res: "R-NRS-Cannon2A-TMk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Cannon2A-TMk1", ] },
			{ res: "R-NRS-Cannon2A-TMk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-Mcannon", ] },
			{ res: "R-NRS-Cannon2A-TMk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cannon2A-TMk1-BABA", ] },
			{ res: "R-NRS-Cannon375mmMk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Cannon375mmMk1", ] },
			{ res: "R-NRS-Cannon375mmMk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cannon375mmMk1-BABA", ] },
			{ res: "R-NRS-Cannon4AUTOMk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Cannon4AUTOMk1", ] },
			{ res: "R-NRS-Cannon4AUTOMk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-Acannon", ] },
			{ res: "R-NRS-Cannon4AUTOMk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cannon4AUTOMk1-BABA", ] },
			{ res: "R-NRS-Cannon5VulcanMk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Cannon5VulcanMk1", ] },
			{ res: "R-NRS-Cannon5VulcanMk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cannon5VulcanMk1-BABA", ] },
			{ res: "R-NRS-Cannon6TwinAslt", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Cannon6TwinAslt", ] },
			{ res: "R-NRS-Cannon6TwinAslt", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-HPV", ] },
			{ res: "R-NRS-Cannon6TwinAslt", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cannon6TwinAslt-BABA", ] },
		],
		extras: [
			"R-GAUSS-Damage-9",
			"R-GAUSS-FirePause-9",
		],
	},
	flammer : {
		roles : [ 0.5, 0.1, 0.2, 0.2 ],
		micro : MICRO.MELEE,
		chatalias : 7,
		weapons : [
			{ res: "R-NRS-Flame1Mk1", stat: "Flame1Mk1", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Flame2", stat: "Flame2", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-PlasmiteFlamer", stat: "PlasmiteFlamer", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Flame1Mk1-2120", stat: "Flame1Mk1-2120", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Flame2-2120", stat: "Flame2-2120", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Flame3Mk1-2120", stat: "Flame3Mk1-2120", weight: WEIGHT.LIGHT },
		],
		vtols : [
		],
		defenses : [
			{ res: "R-NRS-Flame1Mk1", stat: "walltower-Flame1Mk1", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Flame2", stat: "walltower-Flame2", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-PlasmiteFlamer", stat: "walltower-PlasmiteFlamer", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Flame1Mk1-2120", stat: "walltower-Flame1Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Flame2-2120", stat: "walltower-Flame2-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Flame3Mk1-2120", stat: "walltower-Flame3Mk1-2120", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-Flame1Mk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Flame1Mk1", ] },
			{ res: "R-NRS-Flame1Mk1", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "CyborgFlamer01", ] },
			{ res: "R-NRS-Flame1Mk1", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Flame1Mk1-BABA", ] },
			{ res: "R-NRS-Flame2", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Flame2", ] },
			{ res: "R-NRS-Flame2", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-Thermite", ] },
			{ res: "R-NRS-Flame2", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Flame2-BABA", ] },
			{ res: "R-NRS-PlasmiteFlamer", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "PlasmiteFlamer", ] },
			{ res: "R-NRS-PlasmiteFlamer", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "PlasmiteFlamer-BABA", ] },
			{ res: "R-NRS-Flame1Mk1-2120", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Flame1Mk1-2120", ] },
			{ res: "R-NRS-Flame1Mk1-2120", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "CyborgFlamer01-2120", ] },
			{ res: "R-NRS-Flame1Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Flame1Mk1-2120-BABA", ] },
			{ res: "R-NRS-Flame2-2120", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Flame2-2120", ] },
			{ res: "R-NRS-Flame2-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Flame2-2120-BABA", ] },
			{ res: "R-NRS-Flame3Mk1-2120", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Flame3Mk1-2120", ] },
			{ res: "R-NRS-Flame3Mk1-2120", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-Thermite-2120", ] },
			{ res: "R-NRS-Flame3Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Flame3Mk1-2120-BABA", ] },
		],
		extras: [
			"R-FLAME-Damage-9",
			"R-FLAME-FirePause-9",
		],
	},
	rocket : {
		roles : [ 0.5, 0.1, 0.2, 0.2 ],
		micro : MICRO.RANGED,
		chatalias : 8,
		weapons : [
			{ res: "R-NRS-Rocket-Pod", stat: "Rocket-Pod", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Rocket-LtA-T", stat: "Rocket-LtA-T", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Rocket-Pod-2120", stat: "Rocket-Pod-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Rocket-HvyA-T", stat: "Rocket-HvyA-T", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Missile-A-T-2120", stat: "Missile-A-T-2120", weight: WEIGHT.MEDIUM },
		],
		vtols : [
		],
		defenses : [
			{ res: "R-NRS-Rocket-Pod", stat: "walltower-Rocket-Pod", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Rocket-LtA-T", stat: "walltower-Rocket-LtA-T", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Rocket-Pod-2120", stat: "walltower-Rocket-Pod-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Rocket-HvyA-T", stat: "walltower-Rocket-HvyA-T", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Missile-A-T-2120", stat: "walltower-Missile-A-T-2120", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-Rocket-Pod", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-Pod", ] },
			{ res: "R-NRS-Rocket-Pod", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-Pod-BABA", ] },
			{ res: "R-NRS-Rocket-LtA-T", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-LtA-T", ] },
			{ res: "R-NRS-Rocket-LtA-T", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-Atmiss", ] },
			{ res: "R-NRS-Rocket-LtA-T", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-LtA-T-BABA", ] },
			{ res: "R-NRS-Rocket-Pod-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-Pod-2120", ] },
			{ res: "R-NRS-Rocket-Pod-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-Pod-2120-BABA", ] },
			{ res: "R-NRS-Rocket-HvyA-T", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-HvyA-T", ] },
			{ res: "R-NRS-Rocket-HvyA-T", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-TK", ] },
			{ res: "R-NRS-Rocket-HvyA-T", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-HvyA-T-BABA", ] },
			{ res: "R-NRS-Missile-A-T-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Missile-A-T-2120", ] },
			{ res: "R-NRS-Missile-A-T-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-TK-2120", ] },
			{ res: "R-NRS-Missile-A-T-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Missile-A-T-2120-BABA", ] },
		],
		extras: [
			"R-HOWITZERS-Damage-9",
			"R-HOWITZERS-FirePause-9",
		],
	},
	quark : {
		roles : [ 0.4, 0.3, 0.1, 0.2 ],
		micro : MICRO.RANGED,
		chatalias : 9,
		weapons : [
			{ res: "R-NRS-RailGun1Mk1-2120", stat: "RailGun1Mk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-RailGun2Mk1-2120", stat: "RailGun2Mk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-RailGun3Mk1-2120", stat: "RailGun3Mk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-RailGun4Mk1-2120", stat: "RailGun4Mk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-RailGun5Mk1-2120", stat: "RailGun5Mk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-RailGun6Mk1-2120", stat: "RailGun6Mk1-2120", weight: WEIGHT.MEDIUM },
		],
		vtols : [
			{ res: "R-NRS-RailGun1Mk1-2120", stat: "RailGun1-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-RailGun2Mk1-2120", stat: "RailGun002-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-RailGun3Mk1-2120", stat: "RailGun3-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-RailGun4Mk1-2120", stat: "RailGun4-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-RailGun5Mk1-2120", stat: "RailGun5-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-RailGun6Mk1-2120", stat: "RailGun6-VTOL-2120", weight: WEIGHT.MEDIUM },
		],
		defenses : [
			{ res: "R-NRS-RailGun1Mk1-2120", stat: "walltower-RailGun1Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-RailGun2Mk1-2120", stat: "walltower-RailGun2Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-RailGun3Mk1-2120", stat: "walltower-RailGun3Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-RailGun4Mk1-2120", stat: "walltower-RailGun4Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-RailGun5Mk1-2120", stat: "walltower-RailGun5Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-RailGun6Mk1-2120", stat: "walltower-RailGun6Mk1-2120", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-RailGun1Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun1Mk1-2120", ] },
			{ res: "R-NRS-RailGun1Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-Rail1-2120", ] },
			{ res: "R-NRS-RailGun1Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun1Mk1-2120-BABA", ] },
			{ res: "R-NRS-RailGun2Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun2Mk1-2120", ] },
			{ res: "R-NRS-RailGun2Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-RailGunner2-2120", ] },
			{ res: "R-NRS-RailGun2Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun2Mk1-2120-BABA", ] },
			{ res: "R-NRS-RailGun3Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun3Mk1-2120", ] },
			{ res: "R-NRS-RailGun3Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-RailGunner-2120", ] },
			{ res: "R-NRS-RailGun3Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun3Mk1-2120-BABA", ] },
			{ res: "R-NRS-RailGun4Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun4Mk1-2120", ] },
			{ res: "R-NRS-RailGun4Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun4Mk1-2120-BABA", ] },
			{ res: "R-NRS-RailGun5Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun5Mk1-2120", ] },
			{ res: "R-NRS-RailGun5Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun5Mk1-2120-BABA", ] },
			{ res: "R-NRS-RailGun6Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun6Mk1-2120", ] },
			{ res: "R-NRS-RailGun6Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-RailGunner-2120", ] },
			{ res: "R-NRS-RailGun6Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "RailGun6Mk1-2120-BABA", ] },
		],
		extras: [
			"R-MACHINE GUN-Damage-9",
			"R-MACHINE GUN-FirePause-9",
		],
	},
	ASrocket : {
		roles : [ 0.1, 0.2, 0.5, 0.2 ],
		micro : MICRO.RANGED,
		chatalias : 10,
		weapons : [
			{ res: "R-NRS-Rocket-BB", stat: "Rocket-BB", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Rocket-Sunburst", stat: "Rocket-Sunburst", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Rocket-BB-2120", stat: "Rocket-BB-2120", weight: WEIGHT.LIGHT },
			{ res: "R-NRS-Missile-BB-2120", stat: "Missile-BB-2120", weight: WEIGHT.LIGHT },
		],
		vtols : [
		],
		defenses : [
			{ res: "R-NRS-Rocket-BB", stat: "walltower-Rocket-BB", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Rocket-Sunburst", stat: "walltower-Rocket-Sunburst", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Rocket-BB-2120", stat: "walltower-Rocket-BB-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Missile-BB-2120", stat: "walltower-Missile-BB-2120", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-Rocket-BB", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Rocket-BB", ] },
			{ res: "R-NRS-Rocket-BB", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-BB-BABA", ] },
			{ res: "R-NRS-Rocket-Sunburst", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Rocket-Sunburst", ] },
			{ res: "R-NRS-Rocket-Sunburst", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-Sunburst-BABA", ] },
			{ res: "R-NRS-Rocket-BB-2120", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Rocket-BB-2120", ] },
			{ res: "R-NRS-Rocket-BB-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-BB-2120-BABA", ] },
			{ res: "R-NRS-Missile-BB-2120", body: "CyborgLightBody", prop: "CyborgLegs", weapons: [ "Missile-BB-2120", ] },
			{ res: "R-NRS-Missile-BB-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Missile-BB-2120-BABA", ] },
		],
		extras: [
			"R-A-A GUN-Damage-9",
			"R-A-A GUN-FirePause-9",
		],
	},
	heavyrocket : {
		roles : [ 0.5, 0.1, 0.2, 0.2 ],
		micro : MICRO.RANGED,
		chatalias : 11,
		weapons : [
			{ res: "R-NRS-Rocket-HvyA-T-2120", stat: "Rocket-HvyA-T-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Rocket-HvyA-T2-2120", stat: "Rocket-HvyA-T2-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Rocket-MRL-2120", stat: "Rocket-MRL-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Rocket-LtA-T-2120", stat: "Rocket-LtA-T-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Rocket-LtA-T2-2120", stat: "Rocket-LtA-T2-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Missile-A-T-2120", stat: "Missile-A-T-2120", weight: WEIGHT.HEAVY },
		],
		vtols : [
		],
		defenses : [
			{ res: "R-NRS-Rocket-HvyA-T-2120", stat: "walltower-Rocket-HvyA-T-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Rocket-HvyA-T2-2120", stat: "walltower-Rocket-HvyA-T2-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Rocket-MRL-2120", stat: "walltower-Rocket-MRL-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Rocket-LtA-T-2120", stat: "walltower-Rocket-LtA-T-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Rocket-LtA-T2-2120", stat: "walltower-Rocket-LtA-T2-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Missile-A-T-2120", stat: "walltower-Missile-A-T-2120", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-Rocket-HvyA-T-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Rocket-HvyA-T-2120", ] },
			{ res: "R-NRS-Rocket-HvyA-T-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-A-T-2120", ] },
			{ res: "R-NRS-Rocket-HvyA-T-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-Acannon-2120", ] },
			{ res: "R-NRS-Rocket-HvyA-T-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-HvyA-T-2120-BABA", ] },
			{ res: "R-NRS-Rocket-HvyA-T2-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Rocket-HvyA-T2-2120", ] },
			{ res: "R-NRS-Rocket-HvyA-T2-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-A-T2-2120", ] },
			{ res: "R-NRS-Rocket-HvyA-T2-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-HvyA-T2-2120-BABA", ] },
			{ res: "R-NRS-Rocket-MRL-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Rocket-MRL-2120", ] },
			{ res: "R-NRS-Rocket-MRL-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "CyborgRocket-2120", ] },
			{ res: "R-NRS-Rocket-MRL-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-MRL-2120-BABA", ] },
			{ res: "R-NRS-Rocket-LtA-T-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Rocket-LtA-T-2120", ] },
			{ res: "R-NRS-Rocket-LtA-T-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-Atmiss-2120", ] },
			{ res: "R-NRS-Rocket-LtA-T-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-LtA-T-2120-BABA", ] },
			{ res: "R-NRS-Rocket-LtA-T2-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Rocket-LtA-T2-2120", ] },
			{ res: "R-NRS-Rocket-LtA-T2-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-LtA-T2-2120-BABA", ] },
			{ res: "R-NRS-Missile-A-T-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Missile-A-T-2120", ] },
			{ res: "R-NRS-Missile-A-T-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-Atmiss2-2120", ] },
			{ res: "R-NRS-Missile-A-T-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Missile-A-T-2120-BABA", ] },
		],
		extras: [
			"R-SLOW MISSILE-Damage-9",
			"R-SLOW MISSILE-FirePause-9",
		],
	},
	indirectmissile : {
		roles : [ 0.1, 0.2, 0.5, 0.2 ],
		micro : MICRO.RANGED,
		chatalias : 12,
		weapons : [
			{ res: "R-NRS-Rocket-MRL", stat: "Rocket-MRL", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Rocket-IDF", stat: "Rocket-IDF", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Missile-MdArt", stat: "Missile-MdArt", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Rocket-IDF-2120", stat: "Rocket-IDF-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Missile-HvyArt", stat: "Missile-HvyArt", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Missile-MdArt-2120", stat: "Missile-MdArt-2120", weight: WEIGHT.HEAVY },
			{ res: "R-NRS-Missile-HvyArt-2120", stat: "Missile-HvyArt-2120", weight: WEIGHT.HEAVY },
		],
		vtols : [
		],
		defenses : [
			{ res: "R-NRS-Rocket-MRL", stat: "walltower-Rocket-MRL", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Rocket-IDF", stat: "walltower-Rocket-IDF", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Missile-MdArt", stat: "walltower-Missile-MdArt", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Rocket-IDF-2120", stat: "walltower-Rocket-IDF-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Missile-HvyArt", stat: "walltower-Missile-HvyArt", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Missile-MdArt-2120", stat: "walltower-Missile-MdArt-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Missile-HvyArt-2120", stat: "walltower-Missile-HvyArt-2120", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-Rocket-MRL", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Rocket-MRL", ] },
			{ res: "R-NRS-Rocket-MRL", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-MRL-BABA", ] },
			{ res: "R-NRS-Rocket-IDF", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Rocket-IDF", ] },
			{ res: "R-NRS-Rocket-IDF", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-IDF-BABA", ] },
			{ res: "R-NRS-Missile-MdArt", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Missile-MdArt", ] },
			{ res: "R-NRS-Missile-MdArt", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Missile-MdArt-BABA", ] },
			{ res: "R-NRS-Rocket-IDF-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Rocket-IDF-2120", ] },
			{ res: "R-NRS-Rocket-IDF-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Rocket-IDF-2120-BABA", ] },
			{ res: "R-NRS-Missile-HvyArt", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Missile-HvyArt", ] },
			{ res: "R-NRS-Missile-HvyArt", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Missile-HvyArt-BABA", ] },
			{ res: "R-NRS-Missile-MdArt-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Missile-MdArt-2120", ] },
			{ res: "R-NRS-Missile-MdArt-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Missile-MdArt-2120-BABA", ] },
			{ res: "R-NRS-Missile-HvyArt-2120", body: "CyborgHeavyBody-2120", prop: "CyborgLegs", weapons: [ "Missile-HvyArt-2120", ] },
			{ res: "R-NRS-Missile-HvyArt-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Missile-HvyArt-2120-BABA", ] },
		],
		extras: [
			"R-SLOW ROCKET-Damage-9",
			"R-SLOW ROCKET-FirePause-9",
		],
	},
	mediumlaser : {
		roles : [ 0.1, 0.5, 0.2, 0.2 ],
		micro : MICRO.RANGED,
		chatalias : 13,
		weapons : [
			{ res: "R-NRS-MG1Mk1-2120", stat: "MG1Mk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG2Mk1-2120", stat: "MG2Mk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG7LGTGATTLINGMk1-2120", stat: "MG7LGTGATTLINGMk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG3Mk1-2120", stat: "MG3Mk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG7MEDGATTLINGMk1-2120", stat: "MG7MEDGATTLINGMk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG4ROTARYMk1-2120", stat: "MG4ROTARYMk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG7GATTLINGMk1-2120", stat: "MG7GATTLINGMk1-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Laser2PULSEMk1-2120", stat: "Laser2PULSEMk1-2120", weight: WEIGHT.MEDIUM },
		],
		vtols : [
			{ res: "R-NRS-MG1Mk1-2120", stat: "MG1-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG2Mk1-2120", stat: "MG2-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG7LGTGATTLINGMk1-2120", stat: "MG7LGTGATTLING-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG3Mk1-2120", stat: "MG3-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG7MEDGATTLINGMk1-2120", stat: "MG7MEDGATTLING-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG4ROTARYMk1-2120", stat: "MG4ROTARY-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-MG7GATTLINGMk1-2120", stat: "MG7GATTLING-VTOL-2120", weight: WEIGHT.MEDIUM },
			{ res: "R-NRS-Laser2PULSEMk1-2120", stat: "Laser2PULSE-VTOL-2120", weight: WEIGHT.MEDIUM },
		],
		defenses : [
			{ res: "R-NRS-MG1Mk1-2120", stat: "walltower-MG1Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-MG2Mk1-2120", stat: "walltower-MG2Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-MG7LGTGATTLINGMk1-2120", stat: "walltower-MG7LGTGATTLINGMk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-MG3Mk1-2120", stat: "walltower-MG3Mk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-MG7MEDGATTLINGMk1-2120", stat: "walltower-MG7MEDGATTLINGMk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-MG4ROTARYMk1-2120", stat: "walltower-MG4ROTARYMk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-MG7GATTLINGMk1-2120", stat: "walltower-MG7GATTLINGMk1-2120", defrole: DEFROLE.STANDALONE },
			{ res: "R-NRS-Laser2PULSEMk1-2120", stat: "walltower-Laser2PULSEMk1-2120", defrole: DEFROLE.STANDALONE },
		],
		templates: [
			{ res: "R-NRS-MG1Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG1Mk1-2120", ] },
			{ res: "R-NRS-MG1Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "CyborgChaingun-2120", ] },
			{ res: "R-NRS-MG1Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG1Mk1-2120-BABA", ] },
			{ res: "R-NRS-MG2Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG2Mk1-2120", ] },
			{ res: "R-NRS-MG2Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG2Mk1-2120-BABA", ] },
			{ res: "R-NRS-MG7LGTGATTLINGMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG7LGTGATTLINGMk1-2120", ] },
			{ res: "R-NRS-MG7LGTGATTLINGMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "CyborgChaingunMed-2120", ] },
			{ res: "R-NRS-MG7LGTGATTLINGMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG7LGTGATTLINGMk1-2120-BABA", ] },
			{ res: "R-NRS-MG3Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG3Mk1-2120", ] },
			{ res: "R-NRS-MG3Mk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG3Mk1-2120-BABA", ] },
			{ res: "R-NRS-MG7MEDGATTLINGMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG7MEDGATTLINGMk1-2120", ] },
			{ res: "R-NRS-MG7MEDGATTLINGMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG7MEDGATTLINGMk1-2120-BABA", ] },
			{ res: "R-NRS-MG4ROTARYMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG4ROTARYMk1-2120", ] },
			{ res: "R-NRS-MG4ROTARYMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cyb-Wpn-Laser-2120", ] },
			{ res: "R-NRS-MG4ROTARYMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG4ROTARYMk1-2120-BABA", ] },
			{ res: "R-NRS-MG7GATTLINGMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG7GATTLINGMk1-2120", ] },
			{ res: "R-NRS-MG7GATTLINGMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "MG7GATTLINGMk1-2120-BABA", ] },
			{ res: "R-NRS-Laser2PULSEMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Laser2PULSEMk1-2120", ] },
			{ res: "R-NRS-Laser2PULSEMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Cyb-Hvywpn-PulseLsr-2120", ] },
			{ res: "R-NRS-Laser2PULSEMk1-2120", body: "CyborgHeavyBody", prop: "CyborgLegs", weapons: [ "Laser2PULSEMk1-2120-BABA", ] },
		],
		extras: [
			"R-BOMB-Damage-9",
			"R-BOMB-FirePause-9",
		],
	},
};
