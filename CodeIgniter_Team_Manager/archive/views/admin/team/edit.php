<h2>Edit Team</h2>

<p class="note">(Fields marked with <span class="required">*</span> are required.)</p>

<?php 
	echo form_open('/admin/team/save'); 
	echo form_hidden('id', !empty($team)?$team->id:'');
?>

<span class="error"><?php echo validation_errors(); ?></span>

<dl>
	<dt>Name<span class="note required"> *</span></dt>
	<dd><?php echo form_input('name', !empty($team)?$team->name:''); ?></dd>
	
	<dt>League<span class="note required"> *</span></dt>
	<dd><?php echo form_dropdown('league_id', $leagues, !empty($team)?$team->league_id:''); ?></dd>
	
	<dt>Mascot</dt>
	<dd><?php echo form_input('mascot', !empty($team)?$team->mascot:''); ?></dd>
</dl>

<?php 
	echo form_submit('save', 'Save');
	echo form_button('cancel', 'Cancel', "onClick='window.location=\"/admin/team\"'"); 
	echo form_close();
?>

