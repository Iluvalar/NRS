
/*
 * This file lists all timers used by the AI.
 *
 */

(function(_global) {
////////////////////////////////////////////////////////////////////////////////////////////

// slightly shift all timers so that not to get too many of them on the same game frame,
// especially when multiple AI instances are running
function rnd() {
	return random(101);
}

_global.setTimers = function() {
	setTimer("spendMoney", 20 + 3 * rnd());
	setTimer("checkConstruction", 30 + 8 * rnd());
	setTimer("checkAttack", 100);
	setTimer("adaptCycle", 1000);
	setTimer("rebalanceGroups", 1000 + 20 * rnd());
	//if (difficulty === EASY){}
		//setTimer("goEasy", 30000);
}

////////////////////////////////////////////////////////////////////////////////////////////
})(this);
