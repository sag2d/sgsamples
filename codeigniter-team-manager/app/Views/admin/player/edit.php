<h2>Edit Player</h2>

<p class="note">(Fields marked with <span class="required">*</span> are required.)</p>

<?php 
	echo form_open('/admin/player/save'); 
	echo form_hidden('id', !empty($player) ? $player->id : '');
?>

<?= view('admin/errors', ['errors' => $errors ?? []]) ?>

<dl>
	<dt>First Name<span class="note required"> *</span></dt>
	<dd><?php echo form_input('first_name', !empty($player) ? $player->first_name : ''); ?></dd>
	
	<dt>Last Name<span class="note required"> *</span></dt>
	<dd><?php echo form_input('last_name', !empty($player) ? $player->last_name : ''); ?></dd>
	
	<dt>Team<span class="note required"> *</span></dt>
	<dd><?php echo form_dropdown('team_id', $teams, !empty($player) ? $player->team_id : ''); ?></dd>
	
	<dt>Email<span class="note required"> *</span></dt>
	<dd><?php echo form_input('email', !empty($player) ? $player->email : ''); ?></dd>

	<dt>Phone</dt>
	<dd><?php echo form_input('phone', !empty($player) ? $player->phone : ''); ?></dd>

	<dt>Address</dt>
	<dd><?php echo form_input('address', !empty($player) ? $player->address : ''); ?></dd>
	
	<dt>City</dt>
	<dd><?php echo form_input('city', !empty($player) ? $player->city : ''); ?></dd>
	
	<dt>State<span class="note required"> *</span></dt>
	<dd><?php echo form_dropdown('state_id', $states, !empty($player) ? $player->state_id : ''); ?></dd>
	
	<dt>Zip Code</dt>
	<dd><?php echo form_input('zip', !empty($player) ? $player->zip : ''); ?></dd>
</dl>

<?php 
	echo form_submit('save', 'Save');
	echo form_button('cancel', 'Cancel', "onClick='window.location=\"/admin/player\"'"); 
	echo form_close();
?>

