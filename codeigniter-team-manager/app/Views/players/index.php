<h2>View Players</h2>

<br>

<table border="1">
<tr>	
	<th>Player Name</th>
	<th>Team</th>	
</tr>

<?php if(!empty($players)) { ?>
	<?php foreach($players as $player) { ?>
	<tr>		
		<td><a title="View Player Details" href="/players/view/<?php echo $player->id; ?>"><?php echo $player->first_name . " " . $player->last_name; ?></a></td>
		<td><?php echo $teams[$player->team_id]; ?></td>
	</tr>
	<?php }
	}
	else { ?>
		<tr><td colspan="2">There are no existing players in the database.</td></tr>
	<?php } ?>	

</table>