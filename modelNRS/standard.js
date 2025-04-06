
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
const randomTemplates = 1;

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
	"R-NRS--A0BaBaFactory",
	"R-NRS--tracked01",
	//"R-NRS-CyborgHeavyBody-2120",
	"R-NRS--A0RepairCentre3",
	//"R-NRS-A0CyborgFactory",
	//"R-NRS-NuclearReactor",
	//"R-NRS-Park-nrs",
	"R-NRS-BigForest-eco3",
	"R--ResearchPoints--3",
	"R--ProductionPoints--3",
	"R-NRS-LogCabin3-eco3",
	"R--ResearchPoints--6",
	"R--ProductionPoints--6",
	"R-Sys--Autorepair-General",
	"R-NRS-Heavywepslab-eco3",
	"R--ResearchPoints--9",
	"R--ProductionPoints--9",	
	//"R-hover01-HitpointPctOfBody-9",
	//"R-wheeled01-HitpointPctOfBody-9",
	"R-NRS-Forest-eco3",
	"R--Range--9",
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
	"R--ResearchPoints--9",
];

// body and propulsion arrays don't affect fixed template droids
const bodyStats = [
	//--bodylist
];

const classResearch = {
	kinetic: [
		[ // OBJTYPE.TANK
			//"R-Droids-HitPointPct--9",
			//--bodyKinetic
			"R-tracked01-HitpointPctOfBody--9",
		],
		[ // OBJTYPE.BORG
			//"R-Droids-HitPointPct--9",
			//--bodyKinetic
			"R-CyborgLegs-HitpointPctOfBody--18",
		],
		[ // OBJTYPE.DEFS			
			"R-Wall-HitPoints--18",
			//--bodyKinetic
		],
		[ // OBJTYPE.VTOL
			//"R-Droids-HitPointPct--9",
		],
	],
	thermal: [
		[ // OBJTYPE.TANK
			//--bodyThermal
			"R-tracked01-HitpointPctOfBody--9",
			//"R-Droids-HitPointPct--9",
		],
		[ // OBJTYPE.BORG
			//--bodyThermal
			"R-CyborgLegs-HitpointPctOfBody--18",
			//"R-Droids-HitPointPct--9",
		],
		[ // OBJTYPE.DEFS
			"R-Wall-HitPoints--18",
			//--bodyThermal
		],
		[ // OBJTYPE.VTOL
			//"R-Droids-HitPointPct--9",
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

const fallbackWeapon = 'APO11';

// Unlike bodies and propulsions, weapon lines don't have any specific meaning.
// You can make as many weapon lines as you want for your ruleset.
const weaponStats = {
	//--weaponstats
};
