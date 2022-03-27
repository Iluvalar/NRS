function droidLimit(player)	// inside hackNetOff()
{
	setDroidLimit(player, 1000, DROID_ANY);
	setDroidLimit(player, 10, DROID_COMMAND);
	setDroidLimit(player, 15, DROID_CONSTRUCT);
}
