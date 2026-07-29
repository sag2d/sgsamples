<h2>Edit League</h2>

<p class="note">(Fields marked with <span class="required">*</span> are required.)</p>

<?php 
	echo form_open('/admin/league/save'); 
	echo form_hidden('id', !empty($league)?$league->id:'');
?>

<span class="error"><?php echo validation_errors(); ?></span>

<dl>
	<dt>Name<span class="note required"> *</span></dt>
	<dd><?php echo form_input('name', !empty($league)?$league->name:''); ?></dd>
</dl>

<?php 
	echo form_submit('save', 'Save');
	echo form_button('cancel', 'Cancel', "onClick='window.location=\"/admin/league\"'"); 
	echo form_close();
?>


