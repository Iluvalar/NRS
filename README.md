# NRS
```
Next Research System for Warzone2100

NRS is a whole remake of the techtree which gives you access to all component you'd want from the start. There is no branch to the tree other then the most obvious (DMG and ROF upgrades only after discovering the weapon...). Do not worry ! All weapons go trough the same weapon analyzer and are balanced using the same well tested formula. So rail guns while available from 2 minutes in the game won't be a game ending research.

New in NRS!!
*Humans. Squishy little bag of meat. Play as the helpless little humans fighting against giant mech !
*Nuclear plant, housing and solar panel (power generation)
*park, forest and tree (more power generation that take more space)
*Quark cannon line (from 2120)
*Med laser line (from 2120)
*Heavy rocket line (from 2120)
*Plenty of Extra weapons from 2120 in existing line
*Extra bodies
*propulsion upgrades
*Interest rate. Which stop you to have to rush to click stuff all the time and allows for actual thinking.
*Improved balance ! I'm committed to make the most competitive version of WZ ever.
And more new things coming...
```
## Install
```
Simply download the last version of the file NRSXXX.wz and drop it in your /mods/4.3.3/autoload folder.
Edit: (NRS+) We are now at NRSpXXX.wz The current one as I write this is NRSp404.wz
```
## You can do it!
```
This mod is noob friendly.
Just get a weapon, design and build!
You'll be plesantly surprised to see how well a mg viper on wheel rush can go.
DO NOT RESEARCH funny things.
Just explore, 1 or 2 new things every game. And keep the game plan SIMPLE. 
Just a few line of research every games IS WHAT YOU NEED!
Focus on your current crazy plan and do not be overwhelmed by the amount of option for other crazy plans.
```
## Become a pro!
```
Circle of weight : Light >outnumber> Medium >outnumber> Heavy >Can't feel> Light
Circle of propulsion : Structure, Track, wheel, legs(personnal), Structure... 
weapon modifier AS,AT,AW,AP each is weak against it opposite in the circle.

The progression speed encourage players to commit to their research lines. IE. DMG#2 is slightly preferable to ROF#1. Try to specialize in whatever research you commit a the start. This cause each game to be unique and fun.

All research line are designed to be balanced, you are encouraged to explore wacky combos. As long as they fit together. IE. Researching 2 different propulsion upgrade will put you behind, unless you really need to quit the original one because of an opponent weapon choice.

Propulsion upgrade ARE OP. It's intentional so players commit to their propulsion of choice. So enemy players are forced to adapt or bite the dust.

Make sure you have enough units before upgrading things !! You need about 5 minutes worth of power production in your army (~230000). Giving a 12% dmg boost to no units at all won't make you any stronger.
A rush is definitively possible and spending power in 4 labs at start while you have no units is the first cause of defeat in NRS. It's a war game ! Don't let the solar panel convince you otherwise.

The power level now control the demand for oil and other resources. If you play high oil, the oil derrick will have the most focus in the game, if you play low oil, everyone should play sim city to produce power.

The tech level will affect the starting power allowing you to research more things. However be careful ! The economical aid for all player will also be reduced. Higher tech level will be for more advanced player who want full control on their research.
```
## Economy
```
There is 3 lines of economy building. Eco1,eco2,eco3
They all behave identically and they are randomly generated in each pack!
Each of those buildings have different stats.
Basically, they are all producing power, they are all good for power. 
And unless you play at the highest level of competition, they are all optional!

There are 8 "ressources" in game : 
'W','S','E',	'P','Hi','$'	,'Env','war','food','cash'
'Work','Service','Electric','Population','density','luxury','environement' and cash

Each buildings create those "ressources" by using others. 
In other word : build a bit of everything! you should do just fine.
```
### Propaganda
```
The propaganda reduce the total power in the map. 
It is what make the difference between a low oil and an high oil game.
It increase with work and population and it reduce with electricity.
IF you prefer high oil games, focus on building power plants.
Everyone gets to vote in essence for the power level.
```
### Special buildings 
```
3x lab: yes it goes 3x faster, but it's expensive!
banks: They give you power! and a debt.
honor hall: Honor makes you win MORE! wow! You can win twice in the same game. It's designed as a taunt between players. It also make AIs much stronger. In single player FFA, it makes the late game much more fun.
Financial center: I don't know. Does it reduce propaganda ?
```
### Economy data
```
this is only for the cazies amongst you who want to review the data
I made it TOO complex to refrain anyone to memorize it.
So don't file complains about this being too complex. That's the POINT!
$structureData = [
		'A0ResourceExtractor'=>	[0,1,3, -1,0,1, -2,0,0,0,0],
		'Aerodynamicslab'=>		[2,0,-2, 0,0,0, 1,1,0,0,0],
		'Heavywepslab'=>		[2,0,-1, 0,0,0, 1,3,0,0,0],
		'Advmaterialslab'=>		[3,0,-1, 0,0,0, 0,0,0,0,0],
		'Rotarywepslab'=>		[1,0,-1, 0,0,0, -1,2,0,0,0],
		'Powlab'=>				[0,1,2, 0,1,0, -1,-2,0,0,0],
		'SolarPower'=>			[-1,0,2, 0,-1,0, 1,0,0,0,0],
		'NuclearReactor'=>		[-1,0,2, 0,1,0, 1,-2,0,0,0],
		'CoolingTower'=>		[-1,1,1, 0,0,0, 0,-2,0,0,0],
		'Propaganda'=>		[0,1,-1, 0,-1,-1, 0,2,0,0,0],
		'Pickup'=>			[0,2,0, 1,-1,-1, -1,0,0,0,0],
		'road'=>			[0,3,0, 0,-1,1, -1,0,0,0,0],
		'BarbWarehouse2'=>	[1,2,0, -1,1,0, -1,0,0,0,0],
		'BarbWarehouse1'=>	[2,2,-1, -1,0,0, 0,0,0,0,0],
		'BarbWarehouse3'=>	[1,2,0, -1,0,1, -1,0,0,0,0],
		'OilTower'=>		[1,1,-2, 0,0,1, -1,-2,0,0,0],
		'WaterTower'=>		[0,1,0, -1,0,0, 1,0,0,0,0],
		'AirTrafficControl'=>[0,1,-2, -2,0,1, -1,1,0,0,0],
		'Ruin1'=>				[-2,0,0, 2,-1,-1, 0,0,0,0,0],
		'BarbHUT'=>			[-1,-1,0, 2,-1,-1, 0,0,0,0,0],
		'cabin'=>			[0,-2,0, 2,-1,1, 0,0,0,0,0],
		'LogCabin3'=>		[-1,-1,0, 1,0,2, 0,0,0,0,0],
		'building3'=>		[-2,-2,0, 2,0,-1, 0,0,0,0,0],
		'building2'=>		[-1,-1,0, 2,1,1, 0,0,0,0,0],
		'building11'=>		[-2,-2,0, 3,2,-1, 0,0,0,0,0],
		'building12'=>		[-1,-1,0, 2,2,1, -1,0,0,0,0],
		'building10'=>		[-1,-2,0, 2,2,1, 0,0,0,0,0],
		'Park'=>			[0,-1,0, -2,0,1, 2,0,0,0,0],
		'Forest'=>			[0,0,0, -1,-1,0, 2,0,0,0,0],
		'BigForest'=>		[0,0,0, 0,-2,0, 2,0,0,0,0],
		'Tree'=>			[0,0,0, 0,1,0, 2,-1,0,0,0],
		'Boulder3'=>		[0,0,0, 0,1,0, 2,0,-1,0,0],
		'Boulder2'=>		[0,0,0, 0,0,0, 2,0,-1,0,0],
		'Boulder1'=>		[0,0,0, 0,1,0, 2,0,-1,0,0],
		'arizonabush3'=>	[0,1,0, -1,0,0, 2,-1,0,0,0],
		'Tree'=>			[0,0,0, 0,1,0, 2,-1,0,0,0],

The scripts are not executable as they are now in the git. There is a lot of missing parts.
```
## design
### Why ?
Adding new content to a tech tree increase the value of the parts leading to it. And by shockwave effect increase the value of anything that those branches lead to. We can try to predict some of the outcome of our changes. but if, for example, Synaptic Link Data Analysis Mk3 become the 27th research in your research path instead of 26th, EVERYTHING that need the sensor to be researched will REQUIRE a rebalance. The only way I know to rebalance that is a 2 months community test trial followed by an hopeful balance patch that will only address half of the problems at best. In other words, we are constantly in test trial for the latest changes and those changes must come in a snail paces. Which segway nicely to the next part: