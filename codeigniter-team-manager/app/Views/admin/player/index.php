<h2>Manage Players</h2>

<?php if(session()->getFlashdata('error') || session()->getFlashdata('message')) { ?>
	<p class="<?php echo session()->getFlashdata('error') ? 'error' : 'message'; ?>"><?php echo session()->getFlashdata('error') ?: session()->getFlashdata('message'); ?></p>
<?php } ?>

<table border="1">
<tr>	
	<!--th>ID</th-->
	<th>Player Name</th>
	<th>Team</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>

<?php if(!empty($players)) { ?>
	<?php foreach($players as $player) { ?>
	<tr>		
		<!--td><?php echo $player->id; ?></td-->
		<td><?php echo $player->first_name . " " . $player->last_name; ?></td>
		<td><?php echo $teams[$player->team_id]; ?></td>
		<td class="table-actions"><a class="edit" href="/admin/player/edit/<?php echo $player->id; ?>">Edit</a></td>
<td class="table-actions"><a class="delete" href="#" data-id="<?php echo $player->id; ?>" data-delete-url="/admin/player/delete/">Delete</a></td>
	</tr>
	<?php }
	}
	else { ?>
		<tr><td colspan="5">There are no existing players in the database.</td></tr>
	<?php } ?>	

</table>

<br>

<input type="button" name="add" value="Add New Player" data-url="/admin/player/edit">

<script src="/resources/js/admin-index-actions.js"></script>
