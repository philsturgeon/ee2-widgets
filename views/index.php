<style type="text/css">
	#available-widgets li.widget {
		float:left;
		width:17%;
		background-color:#ABB7C3;
		padding:1em;
		margin:5px;
		-moz-border-radius:5px;
		-webkit-border-radius:5px;
	}

	#available-widgets li.widget p {
		padding: 1em 0;
	}

	.widget-area {
		padding: 1em 0;
	}

</style>

<fieldset id="add-area-box" style="display:none">

	<legend><?php echo lang('widgets_add_area'); ?></legend>

	<form action="#">

		<ul>
			<li>
				<label for="title"><?php echo lang('widgets_area_title'); ?></label>
				<?php echo form_input('title'); ?>
			</li>

			<li class="even">
				<label for="slug"><?php echo lang('widgets_area_slug'); ?></label>
				<?php echo form_input('slug', '', 'style="width: 20%"'); ?>
			</li>

		</ul>

		<button type="submit" class="submit">
			<span><?php echo lang('save'); ?></span>
		</button>

		<button id="widget-area-cancel" class="submit">
			<span><?php echo lang('cancel'); ?></span>
		</button>

	</form>
</fieldset>

<div id="available-widgets" style="<?php echo empty($widget_areas) ? 'display:none;' : ''; ?>">
	<?php if($available_widgets): ?>
		<ul>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>" class="widget">

				<h4><?php echo $widget->title; ?></h4>

				<p><?php echo $widget->description; ?></p>

				<div class="button" style="float:left">
					<a class="submit" style="color: white" href="<?php echo WIDGET_URL.AMP.'method=add_instance'.AMP.'widget_id='. $widget->id; ?>">
						<?php echo lang('widgets_instance_add'); ?>
					</a>
				</div>

				<div class="button" style="float:right">
					<a style="color: white;" href="<?php echo WIDGET_URL.AMP.'method=details'.AMP.'widget_id='. $widget->id; ?>">
						<?php echo lang('widgets_details'); ?>
					</a>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<br style="clear:both" />
</div>

<div class="widget-wrapper">

	<?php if (!empty($widget_areas)): ?>

		<?php foreach ($widget_areas as $widget_area): ?>

			<div id="area-<?php echo $widget_area->slug; ?>" class="widget-area" style="clear:both;">

				<h3 style="float:left;"><?php echo $widget_area->title; ?></h3>

				<div class="button" style="float:right; margin: 6px 0;">
					<a class="submit" style="color: white;" href="<?php echo WIDGET_URL.AMP.'method=delete_area'.AMP.'area_id='.$widget_area->id; ?>">
						<?php echo lang('widgets_delete_area'); ?>
					</a>
				</div>

				<div style="float:right;margin: 6px">
					<?php echo form_input('', sprintf('{exp:widgets:area name="%s"}', $widget_area->slug), 'readonly="readonly" style="width:230px"');?>
				</div>

				<div class="widget-list">

					<table class="mainTable" border="0" cellspacing="0" cellpadding="0" style="clear:both">
						<thead>
							<tr>
								<th style="width:2%">#</th>
								<th style="width:40%"><?php echo lang('widgets_instance_title'); ?></th>
								<th style="width:27%"><?php echo lang('widget'); ?></th>
								<th style="width:15%"><?php echo lang('widgets_tag_title'); ?></th>
								<th style="width:8%">&nbsp;</th>
							</tr>
							</thead>
						<tbody>

						<?php if(!empty($widget_area->widgets)): ?>

							<?php foreach($widget_area->widgets as $widget): ?>

								<tr id="instance-<?php echo $widget->instance_id; ?>">
									<td><?php echo $widget->instance_id;?></td>
									<td>
										<a href="<?php echo WIDGET_URL.AMP.'method=edit_instance'.AMP.'instance_id='.$widget->instance_id; ?>">
											<?php echo $widget->instance_title;?>
										</a>
									</td>
									<td><?php echo $widget->title;?></td>
									<td><?php echo form_input('', sprintf('{exp:widgets:instance id="%s"}', $widget->instance_id), 'readonly="readonly" style="width:95%"');?></td>
									<td style="font-size:11px">
										<a href="<?php echo WIDGET_URL.AMP.'method=edit_instance'.AMP.'instance_id='.$widget->instance_id; ?>">
											<?php echo lang('edit'); ?>
										</a> |
										<a href="<?php echo WIDGET_URL.AMP.'method=delete_instance'.AMP.'instance_id='.$widget->instance_id; ?>">
											<?php echo lang('delete'); ?>
										</a>|
										<a href="<?php echo WIDGET_URL.AMP.'method=copy_instance'.AMP.'instance_id='.$widget->instance_id; ?>">
											<?php echo lang('Copy'); ?>
										</a>
									</td>
								</tr>

							<?php endforeach; ?>

						<?php else: ?>
								<tr>
									<td colspan="5"><?php echo lang('widgets_no_instances'); ?></td>
								</tr>
						<?php endif; ?>

						</tbody>
					</table>
				</div>

			</div>

		<?php endforeach; ?>

	<?php else: ?>
		<p id="no-areas"><?php echo lang('widgets_no_areas');?></p>
	<?php endif; ?>

</div>
