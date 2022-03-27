function eventStructureBuilt(struct, droid)
{
	if (struct.player === selectedPlayer)
	{
		reticuleUpdate(struct, CREATE_LIKE_EVENT);

	}
	//console(struct.player +"built:"+ struct.name);
	if( struct.name=="road"){
	//	console("1built road !:"+ struct.name);
	}
}
