<h2>Manage Leagues</h2>

<?php if(session()->getFlashdata('error') || session()->getFlashdata('message')) { ?>
	<p class="<?php echo session()->getFlashdata('error') ? 'error' : 'message'; ?>"><?php echo session()->getFlashdata('error') ?: session()->getFlashdata('message'); ?></p>
<?php } ?>

<table border="1">
<tr>	
	<!--th>ID</th-->
	<th>Name</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>

<?php if(!empty($leagues)) { ?>
	<?php foreach($leagues as $league) { ?>
	<tr>		
		<!--td><?php echo $league->id; ?></td-->
		<td><?php echo $league->name; ?></td>
		<td class="table-actions"><a class="edit" href="/admin/league/edit/<?php echo $league->id; ?>">Edit</a></td>
<td class="table-actions"><a class="delete" href="#" data-id="<?php echo $league->id; ?>" data-delete-url="/admin/league/delete/">Delete</a></td>
	</tr>
	<?php }
	}
	else { ?>
		<tr><td colspan="5">There are no existing leagues in the database.</td></tr>
	<?php } ?>	

</table>

<br>

<input type="button" name="add" value="Add New League" data-url="/admin/league/edit">

<script src="/resources/js/admin-index-actions.js"></script>
