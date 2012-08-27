<ul>
<?php foreach($rss_items as $item): ?>
	<li>
		<?php echo anchor($item['link'], $item['title'], 'target="_blank"'); ?>
		<p class="date"><em><?php echo $item['date']; ?></em></p>
	</li>
<?php endforeach; ?>
</ul>