<h2>View Team Details</h2>

<dl>
	<dt>Team Name:</dt>
	<dd><?php echo $team->name; ?></dd>
	
	<dt>League:</dt>
	<dd><?php echo $league->name; ?></dd>
	
	<?php if (!empty($team->mascot)) { ?>
		<dt>Mascot:</dt>
		<dd><?php echo $team->mascot; ?></dd>
	<?php } ?>
</dl>

<a href="/teams/">&laquo; Back to Team Index</a>
