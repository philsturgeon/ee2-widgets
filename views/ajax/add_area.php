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
				<tr>
					<td colspan="5"><?php echo lang('widgets_no_instances'); ?></td>
				</tr>
			</tbody>
		</table>

	</div>

</div>