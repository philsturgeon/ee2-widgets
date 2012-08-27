<ul class="rss">
    <?php foreach($tweets as $tweet): ?>
	<li>
	    <?php echo $tweet['text']; ?>
	    <p class="date"><em><?php echo anchor($tweet['link'], $tweet['date'], 'target="_blank"'); ?></em></p>
	</li>
    <?php endforeach; ?>
</ul>