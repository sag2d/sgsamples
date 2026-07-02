<h2>Manage Teams</h2>

<?php if(session()->getFlashdata('error') || session()->getFlashdata('message')) { ?>
	<p class="<?php echo session()->getFlashdata('error') ? 'error' : 'message'; ?>"><?php echo session()->getFlashdata('error') ?: session()->getFlashdata('message'); ?></p>
<?php } ?>

<table border="1">
<tr>	
	<!--th>ID</th-->
	<th>Team Name</th>
	<th>League</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>

<?php if(!empty($teams)) { ?>
	<?php foreach($teams as $team) { ?>
	<tr>		
		<!--td><?php echo $team->id; ?></td-->
		<td><?php echo $team->name; ?></td>
		<td><?php echo $leagues[$team->league_id]; ?></td>
		<td class="table-actions"><a class="edit" href="/admin/team/edit/<?php echo $team->id; ?>">Edit</a></td>
		<td class="table-actions"><a class="delete" href="#" onClick="confirm_delete(<?php echo $team->id; ?>);">Delete</a></td>
	</tr>
	<?php }
	}
	else { ?>
		<tr><td colspan="5">There are no existing teams in the database.</td></tr>
	<?php } ?>	

</table>

<br>

<input type="button" name="add" value="Add New Team" onClick="document.location='/admin/team/edit'">

<script language="JavaScript">

	function confirm_delete(id)
	{
		var d = confirm("Are you sure you wish to permanently delete this record?");

		// if user confirms, delete record.
		if(d)
		{					
			document.location = "/admin/team/delete/" + id;
		}
		else
		{
			return false;
		}
	}

</script>
