<h2>Manage Players</h2>

<p class="<?php echo $this->session->flashdata('error')?'error':'message';?>"><?php echo $this->session->flashdata('error')?$this->session->flashdata('error'):$this->session->flashdata('message'); ?></p>

<table border="1">
<tr>	
	<th>ID</th>
	<th>Player Name</th>
	<th>Team</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>

<?php if(!empty($players)) { ?>
	<?php foreach($players as $player) { ?>
	<tr>		
		<td><?php echo $player->id; ?></td>
		<td><?php echo $player->first_name . " " . $player->last_name; ?></td>
		<td><?php echo $teams[$player->team_id]; ?></td>
		<td><a href="/admin/player/edit/<?php echo $player->id; ?>">Edit</a></td>
		<td><a href="#" onClick="confirm_delete(<?php echo $player->id; ?>);">Delete</a></td>
	</tr>
	<?php }
	}
	else { ?>
		<tr><td colspan="5">There are no existing players in the database.</td></tr>
	<?php } ?>	

</table>

<br>

<input type="button" name="add" value="Add New Player" onClick="document.location='/admin/player/edit'">

<script language="JavaScript">

	function confirm_delete(id)
	{
		var d = confirm("Are you sure you wish to permanently delete this record?");

		// if user confirms, delete record.
		if(d)
		{					
			document.location = "/admin/player/delete/" + id;
		}
		else
		{
			return false;
		}
	}

</script>