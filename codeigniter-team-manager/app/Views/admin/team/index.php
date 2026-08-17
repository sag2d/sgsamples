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
<td class="table-actions"><a class="delete" href="#" data-id="<?php echo $team->id; ?>" data-delete-url="/admin/team/delete/">Delete</a></td>
	</tr>
	<?php }
	}
	else { ?>
		<tr><td colspan="5">There are no existing teams in the database.</td></tr>
	<?php } ?>	

</table>

<br>

<input type="button" name="add" value="Add New Team" data-url="/admin/team/edit">

<script type="module" src="/resources/js/dist/admin-index-actions.js"></script>
<!--script src="/resources/js/admin-index-actions.js"></script-->