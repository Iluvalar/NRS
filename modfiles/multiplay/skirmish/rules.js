//
// Skirmish Base Script.
//
// contains the rules for starting and ending a game.
// as well as warning messages.
//
// /////////////////////////////////////////////////////////////////

receiveAllEvents(true);  // If doing this in eventGameInit, it seems to be too late in T2/T3, due to some eventResearched events triggering first.

include("multiplay/script/camTechEnabler.js");
include("multiplay/script/weather.js");

var lastHitTime = 0;
var cheatmode = false;
var mainReticule = false;
var oilDrumData = {
	delay: 0, // time delay to prevent multiple drums from spawning on the same frame
	lastSpawn: 0, // time of the last successful drum added to the map
	maxOilDrums: 0 // maximum amount of random oil drums allowed on the map
};

//nrs stuff
	var culture=[0,0,0,0,0,0,0,0];
	var banks=[0,0,0,0,0,0,0,0];

function printGameSettings()
{
//add human readable method
var human = {
	scavengers : function () {
		if ( scavengers == true) {return _("Scavengers");}
		if ( scavengers == false) {return _("No Scavengers");}
		},

	alliancesType : function () {
		switch (alliancesType) {
			case NO_ALLIANCES: return _("No Alliances");
			case ALLIANCES: return _("Allow Alliances");
			case ALLIANCES_TEAMS: return _("Locked Teams");
			case ALLIANCES_UNSHARED: return _("Locked Teams, No Shared Research");
			}
		},

	powerType : function () {
		switch (powerType) {
			case 0: return _("Low Power Levels");
			case 1: return _("Medium Power Levels");
			case 2: return _("High Power Levels");
			}
		},

	baseType : function () {
		switch (baseType) {
			case CAMP_CLEAN: return _("Start with No Bases");
			case CAMP_BASE: return _("Start with Bases");
			case CAMP_WALLS: return _("Start with Advanced Bases");
			}
		},
	};

//	debug( [mapName, human.scavengers(), human.alliancesType(), human.powerType(), human.baseType(), "T" + getMultiTechLevel(), version ].join("\n"));
	console( [mapName, human.scavengers(), human.alliancesType(), human.powerType(), human.baseType() ].join("\n"));
}

const CREATE_LIKE_EVENT = 0;
const DESTROY_LIKE_EVENT = 1;
const TRANSFER_LIKE_EVENT = 2;

function reticuleManufactureCheck()
{
	var structureComplete = false;
	var facs = [FACTORY, CYBORG_FACTORY, VTOL_FACTORY,];

	for (var i = 0, len = facs.length; i < len; ++i)
	{
		var onMapFacs = enumStruct(selectedPlayer, facs[i]);
		for (var j = 0, len2 = onMapFacs.length; j < len2; ++j)
		{
			if (onMapFacs[j].status === BUILT)
			{
				structureComplete = true;
				break;
			}
		}
	}

	if (structureComplete === true)
	{
		setReticuleButton(1, _("Manufacture (F1)"), "image_manufacture_up.png", "image_manufacture_down.png");
	}
	else
	{
		setReticuleButton(1, _("Manufacture - build factory first"), "", "");
	}
}

function reticuleResearchCheck()
{
	var structureComplete = false;
	var labs = [RESEARCH_LAB,];

	for (var i = 0, len = labs.length; i < len; ++i)
	{
		var onMapResLabs = enumStruct(selectedPlayer, labs[i]);
		for (var j = 0, len2 = onMapResLabs.length; j < len2; ++j)
		{
			if (onMapResLabs[j].status === BUILT)
			{
				structureComplete = true;
				break;
			}
		}
	}
	if (structureComplete === true)
	{
		setReticuleButton(2, _("Research (F2)"), "image_research_up.png", "image_research_down.png");
	}
	else
	{
		setReticuleButton(2, _("Research - build research facility first"), "", "");
	}
}

function reticuleBuildCheck()
{
	if (enumDroid(selectedPlayer, DROID_CONSTRUCT).length > 0)
	{
		setReticuleButton(3, _("Build (F3)"), "image_build_up.png", "image_build_down.png");
	}
	else
	{
		setReticuleButton(3, _("Build - manufacture constructor droids first"), "", "");
	}
}

function reticuleDesignCheck()
{
	var structureComplete = false;
	var HQS = [HQ,];

	for (var i = 0, len = HQS.length; i < len; ++i)
	{
		var onMapHQ = enumStruct(selectedPlayer, HQS[i]);
		for (var j = 0, len2 = onMapHQ.length; j < len2; ++j)
		{
			if (onMapHQ[j].status === BUILT)
			{
				structureComplete = true;
				break;
			}
		}
	}
	if (structureComplete === true)
	{
		setReticuleButton(4, _("Design (F4)"), "image_design_up.png", "image_design_down.png");
		setMiniMap(true);
	}
	else
	{
		setReticuleButton(4, _("Design - construct HQ first"), "", "");
		setMiniMap(false);
	}
}

function reticuleCommandCheck()
{
	if (enumDroid(selectedPlayer, DROID_COMMAND).length > 0)
	{
		setReticuleButton(6, _("Commanders (F6)"), "image_commanddroid_up.png", "image_commanddroid_down.png");
	}
	else
	{
		setReticuleButton(6, _("Commanders - manufacture commanders first"), "", "");
	}
}

function setMainReticule()
{
	setReticuleButton(0, _("Close"), "image_cancel_up.png", "image_cancel_down.png");
	reticuleManufactureCheck();
	reticuleResearchCheck();
	reticuleBuildCheck();
	reticuleDesignCheck();
	setReticuleButton(5, _("Intelligence Display (F5)"), "image_intelmap_up.png", "image_intelmap_down.png");
	reticuleCommandCheck();
}

function reticuleUpdate(obj, eventType)
{
	var update_reticule = false;

	if (eventType === TRANSFER_LIKE_EVENT)
	{
		update_reticule = true;
	}
	else if (obj.player === selectedPlayer && obj.type === STRUCTURE)
	{
		if (obj.stattype === HQ || obj.stattype === RESEARCH_LAB || obj.stattype === CYBORG_FACTORY ||
			obj.stattype === VTOL_FACTORY || obj.stattype === FACTORY || obj.stattype === COMMAND_CONTROL)
		{
			update_reticule = true;
		}
	}
	else if (obj.player === selectedPlayer && obj.type === DROID)
	{
		if (obj.droidType === DROID_CONSTRUCT || obj.droidType === DROID_COMMAND)
		{
			update_reticule = true;
		}
	}

	if (mainReticule && update_reticule)
	{
		//Wait a tick for the counts to update
		const TICK_TIME = 100;
		queue("setMainReticule", TICK_TIME);
	}
}

function setupGame()
{
	//Use light fog for multiplayer
	setRevealStatus(true);

	if (tilesetType == "ARIZONA")
	{
		setCampaignNumber(1);
	}
	else if (tilesetType == "URBAN")
	{
		setCampaignNumber(2);
		replaceTexture("page-8-player-buildings-bases.png", "page-8-player-buildings-bases-urban.png");
		replaceTexture("page-9-player-buildings-bases.png", "page-9-player-buildings-bases-urban.png");
		replaceTexture("page-7-barbarians-arizona.png", "page-7-barbarians-urban.png");
	}
	else if (tilesetType == "ROCKIES")
	{
		setCampaignNumber(3);
		replaceTexture("page-8-player-buildings-bases.png", "page-8-player-buildings-bases-rockies.png");
		replaceTexture("page-9-player-buildings-bases.png", "page-9-player-buildings-bases-rockies.png");
		replaceTexture("page-7-barbarians-arizona.png", "page-7-barbarians-kevlar.png");
		// for some reason rockies will use arizona babas
	}
	if (tilesetType != "ARIZONA")
	{
		setSky("texpages/page-25-sky-urban.png", 0.5, 10000.0);
	}
	// Disabled by default
	setMiniMap(false);
	// Enable all templates
	setDesign(true);

	setMainReticule();
	showInterface();
	mainReticule = true;
	hackPlayIngameAudio();
}

function eventGameLoaded()
{
	setupGame();
}

function eventGameInit()
{
	setupGame();
	printGameSettings();

	// always at least one oil drum, and one more for every 64x64 tiles of map area
	//oilDrumData.maxOilDrums = (mapWidth * mapHeight) >> 12; // replace float division with shift for sync-safety
	oilDrumData.maxOilDrums = 0;
	for (var i = 0; i < oilDrumData.maxOilDrums; ++i)
	{
		queue("placeOilDrum", 10000 * i);
	}

	hackNetOff();
	makeComponentAvailable("B4body-sml-trike01", scavengerPlayer);
	makeComponentAvailable("B3body-sml-buggy01", scavengerPlayer);
	makeComponentAvailable("B2JeepBody", scavengerPlayer);
	makeComponentAvailable("BusBody", scavengerPlayer);
	makeComponentAvailable("FireBody", scavengerPlayer);
	makeComponentAvailable("B1BaBaPerson01", scavengerPlayer);
	makeComponentAvailable("BaBaProp", scavengerPlayer);
	makeComponentAvailable("BaBaLegs", scavengerPlayer);
	makeComponentAvailable("bTrikeMG", scavengerPlayer);
	makeComponentAvailable("BuggyMG", scavengerPlayer);
	makeComponentAvailable("BJeepMG", scavengerPlayer);
	makeComponentAvailable("BusCannon", scavengerPlayer);
	makeComponentAvailable("BabaFlame", scavengerPlayer);
	makeComponentAvailable("BaBaMG", scavengerPlayer);
	for (var playnum = 0; playnum < maxPlayers; playnum++)
	{
		if (powerType == 0)
		{
			setPowerModifier(85, playnum);
		}
		else if (powerType == 2)
		{
			setPowerModifier(125, playnum);
		}

		// insane difficulty is meant to be insane...
		if (playerData[playnum].difficulty == INSANE)
		{
			setPowerModifier(200 + 15 * powerType, playnum);
		}
		else if (playerData[playnum].difficulty == EASY)
		{
			setPowerModifier(70 + 5 * powerType, playnum);
		}

		setDroidLimit(playnum, 150, DROID_ANY);
		setDroidLimit(playnum, 10, DROID_COMMAND);
		setDroidLimit(playnum, 15, DROID_CONSTRUCT);

		enableStructure("A0CommandCentre", playnum);		// make structures available to build
		enableStructure("A0LightFactory", playnum);
		enableStructure("A0ResourceExtractor", playnum);
		enableStructure("A0PowerGenerator", playnum);
		enableStructure("A0ResearchFacility", playnum);

		setStructureLimits("A0LightFactory", 5, playnum);	// set structure limits
		setStructureLimits("A0PowerGenerator", 8, playnum);
		setStructureLimits("A0ResearchFacility", 5, playnum);
		setStructureLimits("A0CommandCentre", 1, playnum);
		setStructureLimits("A0ComDroidControl", 1, playnum);
		setStructureLimits("A0CyborgFactory", 5, playnum);
		setStructureLimits("A0VTolFactory1", 5, playnum);
	}
	applyLimitSet();	// set limit options

	const cleanTech = 1;
	const timeBaseTech = 4.5*60;	
	const timeAdvancedBaseTech = 7.9*60;
	const timeT2= 17*60;
	const timeT3= 25*60;

	for (var playnum = 0; playnum < maxPlayers; playnum++)
	{
		//addSpotter(128, 128, playnum, 1000000, 0, 60);
		//enableResearch("R-Fac-start", playnum);
		completeResearch("R-Fac-start", playnum);
		
		// enable cyborgs components that can't be enabled with research
		makeComponentAvailable("CyborgSpade", playnum);
		//makeComponentAvailable("CyborgLightBody");
		//makeComponentAvailable("CyborgLegs");

		// give bots the ability to produce some unused weapons
		if (playerData[playnum].isAI)
		{
			/*
			enableResearch("R-Sys-Sensor-Turret01", playnum);
			enableResearch("R-Wpn-MG1Mk1", playnum);
			enableResearch("R-Sys-Engineering01", playnum);
			makeComponentAvailable("PlasmaHeavy", playnum);
			makeComponentAvailable("MortarEMP", playnum);
			*/
		}
		completeResearchOnTime(cleanTech, playnum);
		if (baseType == CAMP_CLEAN)
		{
			setPower(1383, playnum);
			
			// Keep only some structures for insane AI
			var structs = enumStruct(playnum);
			for (var i = 0; i < structs.length; i++)
			{
				var s = structs[i];
				if (playerData[playnum].difficulty != INSANE
				    || (s.stattype != WALL && s.stattype != DEFENSE && s.stattype != GATE
				        && s.stattype != RESOURCE_EXTRACTOR))
				{
					removeObject(s, false);
				}
			}
		}
		else if (baseType == CAMP_BASE)
		{
			setPower(1000, playnum);
			//completeResearchOnTime(timeBaseTech, playnum);
			// Keep only some structures
			var structs = enumStruct(playnum);
			for (var i = 0; i < structs.length; i++)
			{
				var s = structs[i];
				if ((playerData[playnum].difficulty != INSANE && (s.stattype == WALL || s.stattype == DEFENSE))
				    || s.stattype == GATE || s.stattype == CYBORG_FACTORY || s.stattype == COMMAND_CONTROL)
				{
					removeObject(s, false);
				}
			}
		}
		else // CAMP_WALLS
		{
			setPower(500, playnum);
			//completeResearchOnTime(timeAdvancedBaseTech, playnum);
		}
		var techLevel = getMultiTechLevel();
		if (techLevel == 2)
		{
			completeResearchOnTime(timeT2, playnum);
		}
		else if (techLevel == 3)
		{
			completeResearchOnTime(timeT3, playnum);
		}
		else if (techLevel == 4)
		{
			completeResearchOnTime(Infinity, playnum);
		}
	}

	hackNetOn();

	//Structures might have been removed so we need to update the reticule button states again
	setMainReticule();

	setTimer("checkEndConditions", 3000);
	if (tilesetType === "URBAN" || tilesetType === "ROCKIES")
	{
		setTimer("weatherCycle", 45000);
	}
	setTimer("autoSave", 10*60*1000);
	//var prestige={0,0,0,0,0,0,0,0,0,0,0,0,0,0,0};
	setTimer("powerStuff", 20000);
	
}
// POWER STUFF
//
function powerStuff(){
	var interest=0.023696500687;
	var basePow=0;
	var cultPow=0;
	var totPow=0;
	var nprop=0;
	var nfor=0;
	var nbank=0;
	//var playnum0;
	//console("interest:"+ interest);
	for (var playnum = 0; playnum < maxPlayers; playnum++){
		nprop+=countStruct("Propaganda-nrs", playnum);
		nfor+=countStruct("Park-nrs", playnum)*250;
		nfor+=countStruct("Forest-nrs", playnum)*150;
		nfor+=countStruct("Tree-nrs", playnum)*50;
		nfor+=countStruct("BigForest-nrs", playnum)*200;
	}
	for (var playnum = 0; playnum < maxPlayers; playnum++){
		//console("1player:"+ playnum +"=="+ totPow +" house:"+ countStruct("Housing-nrs", playnum));
		totPow=playerPower(playnum);	
		basePow=(2-banks[playnum])*461;
		nbank=countStruct("MBank-nrs", playnum);
		//console("2player:"+ playnum +"=="+ totPow +" house:"+ countStruct("Housing-nrs", playnum));
		if(nbank>banks[playnum]){
			totPow+=(nbank-banks[playnum])*231;
			banks[playnum]=nbank;
			culture[playnum]*=.9;
		}
		//console("3player:"+ playnum +"=="+ totPow +" house:"+ countStruct("Housing-nrs", playnum));
		basePow+=culture[playnum];

		basePow+=countStruct("NuclearReactor", playnum)*250*1.1*1.1584;
		basePow+=countStruct("Housing-nrs", playnum)*250*1.1*1.3705;
		basePow+=countStruct("SolarPower-nrs", playnum)*250*1.1*1.7921;
		//basePow+=countStruct("Propaganda-nrs", playnum)*250*1.1*1.1399; Removing this makes the tower relevant only when ahead enough
		
		basePow+=countStruct("Park-nrs", playnum)*250*1.1*1.182238995861;
		basePow+=countStruct("Forest-nrs", playnum)*150*1.1*1.4316840285402;
		basePow+=countStruct("Tree-nrs", playnum)*50*1.1*1.7516371393179;
		basePow+=countStruct("BigForest-nrs", playnum)*200*1.1*2.4003617730169;		
		basePow-=nprop*250*1.1*1.1399*2;
		basePow-=nfor/10*countStruct("A0ResourceExtractor", playnum);
		cultPow+=nbank*231*1.1;
		
		
		setPower(totPow+(totPow+basePow)*interest, playnum);
		culture[playnum]+=cultPow*1.1*interest;
		//setPower(2000, playnum);
	}
}
// /////////////////////////////////////////////////////////////////
// END CONDITIONS
function checkEndConditions()
{
	var factories = countStruct("A0LightFactory") + countStruct("A0CyborgFactory");
	var droids = countDroid(DROID_ANY);

	// Losing Conditions
	if (droids == 0 && factories == 0)
	{
		var gameLost = true;

		/* If teams enabled check if all team members have lost  */
		if (alliancesType == ALLIANCES_TEAMS || alliancesType == ALLIANCES_UNSHARED)
		{
			for (var playnum = 0; playnum < maxPlayers; playnum++)
			{
				if (playnum != selectedPlayer && allianceExistsBetween(selectedPlayer, playnum))
				{
					factories = countStruct("A0LightFactory", playnum) + countStruct("A0CyborgFactory", playnum);
					droids = countDroid(DROID_ANY, playnum);
					if (droids > 0 || factories > 0)
					{
						gameLost = false;	// someone from our team still alive
						break;
					}
				}
			}
		}

		if (gameLost)
		{
			gameOverMessage(false);
			removeTimer("checkEndConditions");
			return;
		}
	}

	// Winning Conditions
	var gamewon = true;

	// check if all enemies defeated
	for (var playnum = 0; playnum < maxPlayers; playnum++)
	{
		if (playnum != selectedPlayer && !allianceExistsBetween(selectedPlayer, playnum))	// checking enemy player
		{
			factories = countStruct("A0LightFactory", playnum) + countStruct("A0CyborgFactory", playnum); // nope
			droids = countDroid(DROID_ANY, playnum);
			if (droids > 0 || factories > 0)
			{
				gamewon = false;	//one of the enemies still alive
				break;
			}
		}
	}

	if (gamewon)
	{
		gameOverMessage(true);
		removeTimer("checkEndConditions");
	}
}

// /////////////////////////////////////////////////////////////////
// WARNING MESSAGES
// Base Under Attack
function eventAttacked(victimObj, attackerObj)
{
	if (gameTime > lastHitTime + 5000 && victimObj.player == selectedPlayer)
	{
		lastHitTime = gameTime;
		if (victimObj.type == STRUCTURE)
		{
			playSound("pcv337.ogg", victimObj.x, victimObj.y, victimObj.z);	// show position if still alive
		}
		else
		{
			playSound("pcv399.ogg", victimObj.x, victimObj.y, victimObj.z);
		}
	}
}

function eventDroidBuilt(droid, structure)
{
	if (droid.player === selectedPlayer)
	{
		reticuleUpdate(droid, CREATE_LIKE_EVENT);
	}
}

function eventStructureBuilt(struct, droid)
{
	if (struct.player === selectedPlayer)
	{
		reticuleUpdate(struct, CREATE_LIKE_EVENT);
	}
}

function eventStructureDemolish(struct, droid)
{
	if (struct.player === selectedPlayer)
	{
		reticuleUpdate(struct, DESTROY_LIKE_EVENT);
	}
}

function eventDestroyed(victim)
{
	if (victim.player === selectedPlayer)
	{
		reticuleUpdate(victim, DESTROY_LIKE_EVENT);
	}
}

function eventObjectTransfer(obj, from)
{
	if (obj.player === selectedPlayer || from === selectedPlayer)
	{
		reticuleUpdate(obj, TRANSFER_LIKE_EVENT);
	}
}

function eventResearched(research, structure, player)
{
	//if (research.name == "") debug("RESEARCH : " + research.fullname + "(" + research.name + ") for " + player);
	// iterate over all results
	for (var i = 0; i < research.results.length; i++)
	{
		var v = research.results[i];
		//if (research.name == "") debug("    RESULT : class=" + v['class'] + " parameter=" + v['parameter'] + " value=" + v['value'] + " filter=" + v['filterParameter'] + " filterval=" + v['filterValue']);
		for (var cname in Upgrades[player][v['class']]) // iterate over all components of this type
		{
			var parameter = v['parameter'];
			parameter2=parameter;
			if(parameter=="HitpointPctOfBody"){
				parameter2="HitPointPctOfBody";
			}
			var ctype = v['class'];
			var filterparam = v['filterParameter'];
			if ('filterParameter' in v && Stats[ctype][cname][filterparam] != v['filterValue']) // more specific filter
			{
				//if (research.name == "") debug("    skipped param=" + parameter + " cname=" + cname);
				continue;
			}
			if (Stats[ctype][cname][parameter] instanceof Array)
			{

				var dst = Upgrades[player][ctype][cname][parameter2].slice();
				for (var x = 0; x < dst.length; x++)
				{
					dst[x] += Math.ceil(Stats[ctype][cname][parameter][x] * v['value'] / 100);
				}
				Upgrades[player][ctype][cname][parameter2] = dst;
				//debug("    upgraded to " + dst);
			}
			else if (Stats[ctype][cname][parameter] > 0) // only applies if stat has above zero value already
			{
				Upgrades[player][ctype][cname][parameter2] += Math.ceil(Stats[ctype][cname][parameter] * v['value'] / 100);
				//if (research.name == "") debug("      upgraded " + cname + " to " + Upgrades[player][ctype][cname][parameter] + " by " + Math.ceil(Stats[ctype][cname][parameter] * v['value'] / 100));
			}
			//else if (research.name == "") debug("    passed " + Stats[ctype][cname][parameter] + " param=" + parameter + " cname=" + cname);
		}
	}
}

function eventCheatMode(entered)
{
	cheatmode = entered; // remember this setting
}

function eventChat(from, to, message)
{
	if (message == "bettertogether" && cheatmode)
	{
		for (var i in Upgrades[from].Brain)
		{
			if (Upgrades[from].Brain[i].BaseCommandLimit > 0) // is commander
			{
				Upgrades[from].Brain[i].BaseCommandLimit += 4;
				Upgrades[from].Brain[i].CommandLimitByLevel += 2;
				// you must set the thresholds this way, as an array, because of the clunky
				// way that this is implemented behind the scenes
				Upgrades[from].Brain[i].RankThresholds = [ 0, 2, 4, 8, 16, 24, 32, 48, 64 ];
			}
		}
		console("Made player " + from + "'s commanders SUPERIOR!");
	}
	if (message == "makesuperior" && cheatmode)
	{
		for (var i in Upgrades[from].Body)
		{
			if (Upgrades[from].Body[i].bodyClass === 'Droids' || Upgrades[from].Body[i].bodyClass === 'Cyborgs')
			{
				Upgrades[from].Body[i].HitPoints += 500;
				Upgrades[from].Body[i].HitPointPct += 100;
				Upgrades[from].Body[i].Armour += 500;
				Upgrades[from].Body[i].Thermal += 500;
				Upgrades[from].Body[i].Power += 500;
			}
		}
		console("Made player " + from + "'s units SUPERIOR!");
	}
}

function placeOilDrum()
{
	var drums = enumFeature(-1, "OilDrum").length;
	if (drums >= oilDrumData.maxOilDrums)
	{
		return;
	}

	var x = syncRandom(mapWidth - 20) + 10;
	var y = syncRandom(mapHeight - 20) + 10;

	// Don't allow placement of structures onto a potential drum location if a truck
	// could suddenly built something near it.
	var nearbyTruck = false;
	const SCAN_RANGE_TRUCKS = 6;
	var nearbyObjects = enumRange(x, y, SCAN_RANGE_TRUCKS, ALL_PLAYERS, false);
	for (var i = 0, len = nearbyObjects.length; i < len; ++i)
	{
		var object = nearbyObjects[i];
		if (object.type === DROID && object.droidType === DROID_CONSTRUCT)
		{
			nearbyTruck = true;
			break;
		}
	}

	// scan about the same radius as the biggest game objects in the case a drum
	// wants to be placed near once. This way the scan should touch the center
	// tile of the object.
	const SCAN_RANGE_OCCUPIED = 3;
	// see if the random position is valid
	var occupied = (enumRange(x, y, SCAN_RANGE_OCCUPIED, ALL_PLAYERS, false).length > 0);
	var unreachable = true;
	for (var i = 0; i < maxPlayers; ++i)
	{
		if (propulsionCanReach("hover01", x, y, startPositions[i].x, startPositions[i].y))
		{
			unreachable = false;
			break;
		}
	}

	var terrain = terrainType(x, y);
	if (terrain == TER_WATER || terrain == TER_CLIFFFACE)
	{
		unreachable = true;
	}

	if (occupied || unreachable || nearbyTruck || (gameTime - oilDrumData.lastSpawn <= 200))
	{
		// try again in a different position after 1 second
		queue("placeOilDrum", 1000);
		return;
	}

	oilDrumData.lastSpawn = gameTime;
	addFeature("OilDrum", x, y);
}

function eventPickup(feature, droid)
{
	if (feature.stattype == OIL_DRUM)
	{
		var delay;
		// generate Geom(1/6) distribution for oil drum respawn delay
		for (delay = 0; ; ++delay)
		{
			if (syncRandom(6) == 0)
			{
				break;
			}
		}
		if (oilDrumData.delay > 120000)
		{
			oilDrumData.delay = 0;
		}
		oilDrumData.delay = oilDrumData.delay + 100;
		// amounts to 10 minutes average respawn time
		queue("placeOilDrum", (delay * 120000) + oilDrumData.delay);
	}
}
