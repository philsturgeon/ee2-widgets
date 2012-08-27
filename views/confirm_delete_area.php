<?php if(!empty($error)): ?>
	<p><?php echo $error; ?></p>
<?php endif; ?>

<?php echo form_open($form_action, ''); ?>

	<?php echo form_hidden('area_id', $widget_area->id); ?>

	<p><?php echo sprintf(lang('widgets_confirm_area_message'), $widget_area->title); ?></p>

<p class="centerSubmit">
	<input name="confirm" type="submit" value="<?php echo lang('delete')?>" class="submit" />
	<input name="cancel" type="submit" value="<?php echo lang('cancel')?>" class="submit" />
</p>

<?php echo form_close(); ?>