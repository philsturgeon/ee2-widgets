<ol>
  <li class="even">
    <label>URL</label>
    <?php echo form_input('url', $options['url'], 'style="width:300px"'); ?>
  </li>
  <li class="odd">
    <label>Width</label>
    <?php echo form_input('width', ($options['width'] != '' ? $options['width'] : '292'), 'style="width:100px"'); ?>
  </li>
  <li class="even">
    <label>Height</label>
    <?php echo form_input('height', $options['height'], 'style="width:100px"'); ?>
  </li>
  <li class="odd">
    <label>Color Scheme</label>
    <?php echo form_dropdown('color_scheme', array('light'=>'Light', 'dark' => 'Dark'), $options['color_scheme']); ?>
  </li>
  <li class="even">
    <label>Show Faces</label>
    <?php echo form_dropdown('show_faces', array('true'=>'Yes', 'false' => 'No'), $options['show_faces']); ?>
  </li>
  <li class="odd">
    <label>Border Color (e.g. #FFFFFF)</label>
    <?php echo form_input('border_color', $options['border_color'], 'style="width:100px"'); ?>
  </li>
  <li class="even">
    <label>Show Stream</label>
    <?php echo form_dropdown('stream', array('true'=>'Yes', 'false' => 'No'), $options['stream']); ?>
  </li>
  <li class="even">
    <label>Show Header</label>
    <?php echo form_dropdown('header', array('true'=>'Yes', 'false' => 'No'), $options['header']); ?>
  </li>
</ol>
<style type="text/css">
#widget-options label {
  width:200px;
  float:left
}
#widget-options li {
  clear:both;
  margin:10px 0
}
</style>
