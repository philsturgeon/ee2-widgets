<table class="mainTable" border="0" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th class="header"><?php echo lang('widgets_details'); ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<tr class="even">
		<td><?php echo lang('widget'); ?></td>
		<td><?php echo $widget->title; ?></td>
	</tr>
	<tr class="odd">
		<td><?php echo lang('widgets_version'); ?></td>
		<td><?php echo $widget->version; ?></td>
	</tr>
	<tr class="even">
		<td><?php echo lang('widgets_author'); ?></td>
		<td><?php echo $widget->author; ?></td>
	</tr>
	<tr class="odd">
		<td><?php echo lang('widgets_website'); ?></td>
		<td><?php echo anchor($widget->website, NULL, 'taget="_blank"'); ?></td>
	</tr>
	<tr class="even">
		<td><?php echo lang('widgets_description'); ?></td>
		<td><?php echo $widget->description; ?></td>
	</tr>
	<tr class="odd">
	</tr>
	</tbody>
</table>