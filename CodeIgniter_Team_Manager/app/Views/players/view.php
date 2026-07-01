<h2>View Player Details</h2>

<dl>
	<dt>First Name:</dt>
	<dd><?php echo $player->first_name; ?></dd>
	
	<dt>Last Name:</dt>
	<dd><?php echo $player->last_name; ?></dd>
	
	<dt>Team:</dt>
	<dd><?php echo $team->name; ?></dd>

	<dt>Email:</dt>
	<dd><?php echo safe_mailto($player->email); ?></dd>
	
	<?php if (!empty($player->phone)) { ?>
		<dt>Phone:</dt>
		<dd><?php echo $player->phone; ?></dd>
	<?php } ?>

	<?php if (!empty($player->address)) { ?>
		<dt>Address:</dt>
		<dd><?php echo $player->address; ?></dd>
	<?php } ?>

	<?php if (!empty($player->city)) { ?>
		<dt>City:</dt>
		<dd><?php echo $player->city; ?></dd>
	<?php } ?>

	<?php if (!empty($player->state_id)) { ?>
		<dt>State:</dt>
		<dd><?php echo !empty($states[$player->state_id]) ? $states[$player->state_id] : ''; ?></dd>
	<?php } ?>

	<?php if (!empty($player->zip)) { ?>
		<dt>Zip Code:</dt>
		<dd><?php echo $player->zip; ?></dd>
	<?php } ?>
</dl>

<a href="/players/">&laquo; Back to Player Index</a>
