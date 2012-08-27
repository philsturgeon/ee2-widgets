<?php if(!empty($error)): ?>
	<p><?php echo $error; ?></p>
<?php endif; ?>

<?php echo form_open($form_action, ''); ?>

	<?php echo form_hidden('instance_id', $widget_instance->instance_id); ?>

	<p><?php echo sprintf(lang('widgets_confirm_instance_message'), $widget_instance->title, $widget_instance->instance_id); ?></p>

	<p class="centerSubmit">
		<input name="confirm" type="submit" value="<?php echo lang('delete')?>" class="submit" />
		<input name="cancel" type="submit" value="<?php echo lang('cancel')?>" class="submit" />
	</p>

<?php echo form_close(); ?>