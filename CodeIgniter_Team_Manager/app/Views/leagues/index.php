<h2>View Leagues</h2>

<br>

<table border="1">
<tr>	
	<th>League Name</th>	
</tr>

<?php if(!empty($leagues)) { ?>
	<?php foreach($leagues as $league) { ?>
	<tr>	
		<td><?php echo $league->name; ?></td>		
	</tr>
	<?php }
	}
	else { ?>
		<tr><td>There are no existing leagues in the database.</td></tr>
	<?php } ?>	

</table>