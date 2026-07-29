<h2>Manage Leagues</h2>

<p class="<?php echo $this->session->flashdata('error')?'error':'message';?>"><?php echo $this->session->flashdata('error')?$this->session->flashdata('error'):$this->session->flashdata('message'); ?></p>

<table border="1">
<tr>	
	<th>ID</th>
	<th>Name</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>

<?php if(!empty($leagues)) { ?>
	<?php foreach($leagues as $league) { ?>
	<tr>		
		<td><?php echo $league->id; ?></td>
		<td><?php echo $league->name; ?></td>
		<td><a href="/admin/league/edit/<?php echo $league->id; ?>">Edit</a></td>
		<td><a href="#" onClick="confirm_delete(<?php echo $league->id; ?>);">Delete</a></td>
	</tr>
	<?php }
	}
	else { ?>
		<tr><td colspan="5">There are no existing leagues in the database.</td></tr>
	<?php } ?>	

</table>

<br>

<input type="button" name="add" value="Add New League" onClick="document.location='/admin/league/edit'">

<script language="JavaScript">

	function confirm_delete(id)
	{
		var d = confirm("Are you sure you wish to permanently delete this record?");

		// if user confirms, delete record.
		if(d)
		{					
			document.location = "/admin/league/delete/" + id;
		}
		else
		{
			return false;
		}
	}

</script>