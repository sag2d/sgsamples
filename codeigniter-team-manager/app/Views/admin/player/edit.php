<h2>Edit Player</h2>

<p class="note">(Fields marked with <span class="required">*</span> are required.)</p>

<?php 
	echo form_open('/admin/player/save'); 
	echo form_hidden('id', $player->id ?? '');
?>

<?= view('admin/errors', ['errors' => $errors ?? []]) ?>

<dl>
	<dt>First Name<span class="note required"> *</span></dt>
	<dd><?php echo form_input('first_name', $player->first_name ?? ''); ?></dd>
	
	<dt>Last Name<span class="note required"> *</span></dt>
	<dd><?php echo form_input('last_name', $player->last_name ?? ''); ?></dd>
	
	<dt>Team<span class="note required"> *</span></dt>
	<dd><?php echo form_dropdown('team_id', $teams, $player->team_id ?? ''); ?></dd>
	
	<dt>Email<span class="note required"> *</span></dt>
	<dd><?php echo form_input('email', $player->email ?? ''); ?></dd>

	<dt>Phone</dt>
	<dd><?php echo form_input('phone', $player->phone ?? ''); ?></dd>

	<dt>Address</dt>
	<dd><?php echo form_input('address', $player->address ?? ''); ?></dd>
	
	<dt>City</dt>
	<dd><?php echo form_input('city', $player->city ?? ''); ?></dd>
	
	<dt>State<span class="note required"> *</span></dt>
	<dd><?php echo form_dropdown('state_id', $states, $player->state_id ?? ''); ?></dd>
	
	<dt>Zip Code</dt>
	<dd><?php echo form_input('zip', $player->zip ?? ''); ?></dd>
</dl>

<?php 
	echo form_submit('save', 'Save');
	echo form_button('cancel', 'Cancel', "onClick='window.location=\"/admin/player\"'"); 
	echo form_close();
?>
