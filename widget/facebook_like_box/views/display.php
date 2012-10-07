<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like-box"
  data-href="<?php echo $options['url']; ?>"
  data-width="<?php echo $options['width']; ?>"
  data-height="<?php echo $options['height']; ?>"
  data-show-faces="<?php echo $options['show_faces']; ?>"
  data-border-color="<?php echo $options['border_color']; ?>"
  data-stream="<?php echo $options['stream']; ?>"
  data-color-scheme="<?php echo $options['color_scheme']; ?>"
  data-header="<?php echo $options['header']; ?>">
</div>
