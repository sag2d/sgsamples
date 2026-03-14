<h2>View Teams</h2>

<br>

<table border="1">
<tr>	
	<th>Team Name</th>
	<th>League</th>	
</tr>

<?php if(!empty($teams)) { ?>
	<?php foreach($teams as $team) { ?>
	<tr>		
		<td><a title="View Team Details" href="/teams/view/<?php echo $team->id; ?>"><?php echo $team->name; ?></a></td>
		<td><?php echo $leagues[$team->league_id]; ?></td>
	</tr>
	<?php }
	}
	else { ?>
		<tr><td colspan="2">There are no existing teams in the database.</td></tr>
	<?php } ?>	

</table>
