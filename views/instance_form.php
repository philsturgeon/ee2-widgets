<style type="text/css">
	#widget-options li { list-style: none; }
</style>

<?php echo form_open($form_action); ?>

	<h3><?php echo $widget->title; ?> in <?php echo $widget_area->title; ?></h3>

	<?php if(isset($widget->instance_id)): ?>
		<?php echo form_hidden('instance_id', $widget->instance_id); ?>
	<?php endif; ?>

	<?php echo form_hidden('widget_id', $widget->id); ?>

	<?php if(!isset($widget_areas)): ?>
			<?php echo form_hidden('widget_area_id', $widget_area->id); ?>
	<?php endif; ?>

	<?php if(!empty($error)): ?>
		<?php echo $error; ?>
	<?php endif; ?>

	<table class="mainTable" border="0" cellspacing="0" cellpadding="0">
		<tbody>

			<tr class="odd">
				<td style="text-align:right;"><label><?php echo lang('widgets_instance_title'); ?>:</label></td>
				<td><?php echo form_input('title', set_value('title', isset($widget->instance_title) ? $widget->instance_title : '')); ?></td>
			</tr>

			<tr class="even">
				<td style='text-align:right; width: 20%'><label for="widget_area_id"><?php echo lang('widgets_area'); ?>:</label></td>
				<td><?php echo form_dropdown('widget_area_id', $widget_area_options, $widget_area->id); ?></td>
			</tr>

		</tbody>
	</table>

	<?php
	$form = $this->widget->render_backend($widget->slug, isset($widget->options) ? $widget->options : array());
	if($form):
	?>

	<fieldset id="widget-options">
		<legend><?php echo lang('widgets_options'); ?></legend>

		<?php echo $form; ?>
	</fieldset>

	<?php endif; ?>

	<p class="centerSubmit">
		<input type="submit" name="submit" value="<?php echo lang('save')?>" class="submit" />
		<input type="submit" name="cancel" value="<?php echo lang('cancel')?>" class="submit" />
	</p>
	
<?php echo form_close(); ?>