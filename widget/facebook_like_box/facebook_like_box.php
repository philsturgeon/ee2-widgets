<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package       ExpressionEngine 2: Widgets
 * @subpackage    Facebook Like Box Widget
 * @author        Jordan Andree
 * @modified      2012.10.06
 *
 * Display a Facebook Like Box
 */

class Widget_Facebook_like_box extends Widgets
{
  public $title = 'Facebook Like Box';
  public $description = 'Display a Facebook Like Box';
  public $author = 'Jordan Andree';
  public $website = 'http://jordanandree.com';
  public $version = '1.0';

  public $fields = array(
    array(
      'field' => 'url',
      'label' => 'URL',
      'rules' => 'required'
    ),
    array(
      'field' => 'width',
      'label' => 'Width',
      'rules' => 'required'
    ),
    array(
      'field' => 'height',
      'label' => 'Height'
    ),
    array(
      'field' => 'color_scheme',
      'label' => 'Color Scheme',
      'rules' => ''
    ),
    array(
      'field' => 'show_faces',
      'label' => 'Show Faces',
      'rules' => ''
    ),
    array(
      'field' => 'border_color',
      'label' => 'Border Color'
    ),
    array(
      'field' => 'stream',
      'label' => 'Stream',
      'rules' => ''
    ),
    array(
      'field' => 'header',
      'label' => 'Header',
      'rules' => ''
    )
  );

  public function form($options)
  {
    if(empty($options['url']))
      $options['url'] = 'http://facebook.com/platform';

    return array('options' => $options);
  }

  public function save($options)
  {
    $this->load->helper('url');
    $options['url'] = prep_url($options['url']);

    return $options;
  }

}
