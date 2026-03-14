<h2>View Player Details</h2>

<dl>
	<dt>First Name:</dt>
	<dd><?php echo $player->first_name; ?></dd>
	
	<dt>Last Name:</dt>
	<dd><?php echo $player->last_name; ?></dd>
	
	<dt>Team:</dt>
	<dd><?php echo $team->name; ?></dd>
	
	<dt>Address:</dt>
	<dd><?php echo $player->address; ?></dd>
	
	<dt>City:</dt>
	<dd><?php echo $player->city; ?></dd>
	
	<dt>State:</dt>
	<dd><?php echo !empty($states[$player->state_id])?$states[$player->state_id]:''; ?></dd>
	
	<dt>Zip Code:</dt>
	<dd><?php echo $player->zip; ?></dd>
	
	<dt>Email:</dt>
	<dd><?php echo $player->email; ?></dd>
	
	<dt>Phone:</dt>
	<dd><?php echo $player->phone; ?></dd>
</dl>

<a href="/players/">Back to Player Index</a>
