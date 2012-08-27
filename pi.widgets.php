<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Widgets Add-on
 *
 * @package		ExpressionEngine 2
 * @subpackage	Third Party
 * @category	Modules
 * @author		Phil Sturgeon
 * @link		http://getsparkplugs.com/rest
 */

include_once PATH_THIRD.'widgets/libraries/Widget'.EXT;

class Widgets extends Widget
{
	public $return_data	= '';

	private $_rendered_areas = array();

	private $_default_wrapper = '
		<div class="widget {slug}">
			<h3>{instance_title}</h3>

			<div class="widget-body">
			{body}
			</div>
		</div>';

	// --------------------------------------------------------------------

	/**
	 * __construct()
	 *
	 * Called by {exp:widgets} the construct is the center of all logic for this plugin
	 *
	 * @access	private
	 * @param	int
	 * @return	bool
	 */
	public function Widgets()
    {
		parent::__construct();

		$this->load->library('widget');
	}

	function widget()
	{
		$slug = $this->TMPL->fetch_param('name');

		return $this->widget->render($slug, $options);
	}

	function area()
	{
		$area = $this->TMPL->fetch_param('name');
		$wrapper_html = $this->TMPL->tagdata ? $this->TMPL->tagdata : $this->_default_wrapper;

		if (isset($this->_rendered_areas[$area]))
		{
			return $this->_rendered_areas[$area];
		}

		$widgets = $this->widgets_m->get_by_area($area);

		$output = '';

		foreach ($widgets as &$widget)
		{
			$widget->options = $this->widget->_unserialize_options($widget->options);
			$widget->body = $this->widget->render($widget->slug, $widget->options);

			$widget = (array) $widget;
		}

		$return = $this->TMPL->parse_variables(
			'{widgets}'.$wrapper_html.'{/widgets}',
			array(array('widgets' => $widgets))
		);

		return $this->_rendered_areas[$area] = $return;
	}

	function instance()
	{
		$id = $this->TMPL->fetch_param('id');
		
		$widget = $this->widget->get_instance($id, TRUE);

		return $widget ? $this->widget->render($widget->slug, $widget->options) : '';
	}
}
// END Widgets Class

/* Location: ./application/libraries/Widgets.php */