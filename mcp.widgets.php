<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * WIDGET Add-on
 *
 * @package		ExpressionEngine 2
 * @subpackage	Third Party
 * @category	Modules
 * @author		Phil Sturgeon
 * @link		http://devot-ee.com/add-ons/widgets
 */

include_once PATH_THIRD.'widgets/libraries/Widget'.EXT;

// done so widgets can extend from Widgets not Widget (PyroCMS compatibility)
class Widgets extends Widget {}

class Widgets_mcp
{
	public $module_name;

	// --------------------------------------------------------------------

	/**
	 * __construct()
	 *
	 * Set's form validation and properties to be used on each page
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
		$this->module_name = strtolower(str_replace('_mcp', '', get_class($this)));

		define('WIDGET_PARAMS', 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.$this->module_name);
		define('WIDGET_URL', BASE.AMP.WIDGET_PARAMS);

		$this->EE->javascript->output('WIDGET_URL = "'.html_entity_decode(WIDGET_URL).'";');
		$this->EE->javascript->compile();

		$this->data->base = WIDGET_URL;

		$this->EE->load->library('widget');
	}

	// --------------------------------------------------------------------

	/**
	 * Index
	 *
	 * See a list of all widget instances.
	 *
	 * @return	string
	 */
	public function index()
	{
		$this->EE->cp->set_right_nav(array(
			'widgets_add_area' => '#add-area'
		));
		
		$this->EE->cp->load_package_js('widgets');

		// Show the current page to be WIDGET
		$this->EE->cp->set_variable('cp_page_title', lang('widgets_module_name'));

		// Firstly, install any uninstalled widgets
		$uninstalled_widgets = $this->EE->widget->list_uninstalled_widgets();
		foreach($uninstalled_widgets as $widget)
		{
			$this->EE->widget->add_widget((array)$widget);
		}

		$available_widgets = $this->EE->widget->list_available_widgets();

		$widget_dropdown = array();
		foreach($available_widgets as &$widget)
		{
			$widget_dropdown[$widget->id] = $widget->title;
		}

		$widget_areas = $this->EE->widget->list_areas();
		foreach($widget_areas as &$area)
		{
			$area->widgets = $this->EE->widget->list_area_instances($area->slug);
		}

		$this->EE->load->vars(array(
			'available_widgets' => &$available_widgets,
			'widget_areas' => &$widget_areas,
			'widget_dropdown' => &$widget_dropdown,
			'widget_area_dropdown' => &$widget_area_dropdown
		));

		return $this->EE->load->view('index', $this->data, TRUE);
	}

	// AJAX
	public function add_area()
	{
		$data->widget_area->title 	= $this->EE->input->get('area_title');
		$data->widget_area->slug 	= $this->EE->input->get('area_slug');

		$data->widget_area->id = $this->EE->widget->add_area($data->widget_area);

		return $this->EE->load->view('ajax/add_area', $data, TRUE);
	}

	public function update_order()
	{
		$ids = explode(',', $this->EE->input->get('order'));
		
		$i = 1;
		foreach($ids as $id)
		{
			$this->EE->widget->update_instance_order($id, $i++);
		}
	}

	// Direct
	public function add_instance()
	{
		$this->EE->cp->set_breadcrumb(WIDGET_URL, lang('widgets_module_name'));
		$this->EE->cp->set_variable('cp_page_title', lang('widgets_add_instance'));
		
		$this->EE->input->post('cancel') and $this->EE->functions->redirect(WIDGET_URL);

		// Capture posted back data
		$title 			= $this->EE->input->post('title');
		$widget_id 		= $this->EE->input->get_post('widget_id');
		$widget_area_id = $this->EE->input->post('widget_area_id');

		$options 		= $_POST;
		unset($options['title'], $options['widget_id'], $options['widget_area_id']);

		// Run what we have, see if it goes
		if($_POST)
		{
			$result = $this->EE->widget->add_instance($title, $widget_id, $widget_area_id, $options);

			if($result['status'] == 'success')
			{
				$this->EE->session->set_flashdata('message_success', sprintf(lang('widgets_saved_message'), $this->EE->input->post('title')));
				$this->EE->functions->redirect(WIDGET_URL);
			}

			else
			{
				$this->data->error = lang('widgets_save_failed_message');
			}
		}

		// Nevermind, find out whats going on
		$widget = $this->EE->widget->get_widget($widget_id);
		$widget_area = $this->EE->widget->get_area($widget_area_id);

		$widget_areas = $this->EE->widget->list_areas();

		$widget_area_options = array();
		foreach($widget_areas as $area)
		{
			$widget_area_options[$area->id] = $area->title;
		}

		// Set the form action
		$this->data->form_action = WIDGET_PARAMS.AMP.'method=add_instance';
		$this->data->widget =& $widget;
		$this->data->widget_area =& $widget_area;
		$this->data->widget_area_options =& $widget_area_options;

		return $this->EE->load->view('instance_form', $this->data, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Edit
	 *
	 * Form to edit a saved WIDGET request
	 *
	 * @return	string
	 */
	public function edit_instance()
	{
		$this->EE->cp->set_breadcrumb(WIDGET_URL, lang('widgets_module_name'));
		$this->EE->cp->set_variable('cp_page_title', lang('widgets_edit_instance'));

		// Capture posted back data
		$title 			= $this->EE->input->post('title');
		$widget_area_id = $this->EE->input->post('widget_area_id');
		$instance_id	= $this->EE->input->get_post('instance_id');

		$options 		= $_POST;
		unset($options['title'], $options['instance_id'], $options['widget_area_id']);

		// Run what we have, see if it goes
		if($_POST)
		{
			$result = $this->EE->widget->edit_instance($instance_id, $title, $widget_area_id, $options);

			if($result['status'] == 'success')
			{
				$this->EE->session->set_flashdata('message_success', sprintf(lang('widgets_saved_message'), $this->EE->input->post('title')));
				$this->EE->functions->redirect(WIDGET_URL);
			}

			else
			{
				$this->data->error = lang('widgets_save_failed_message');
			}
		}

		// Nevermind, find out whats going on
		$widget = $this->EE->widget->get_instance($instance_id);
		$widget_area = $this->EE->widget->get_area($widget_area_id);

		$widget_areas = $this->EE->widget->list_areas();

		$widget_area_options = array();
		foreach($widget_areas as $area)
		{
			$widget_area_options[$area->id] = $area->title;
		}

		// Set the form action
		$this->data->form_action = WIDGET_PARAMS.AMP.'method=edit_instance';
		$this->data->widget =& $widget;
		$this->data->widget_area =& $widget_area;
		$this->data->widget_area_options =& $widget_area_options;

		return $this->EE->load->view('instance_form', $this->data, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Delete a widget instance
	 *
	 * @return void
	 */
	public function delete_instance()
	{
		$this->EE->cp->set_breadcrumb(WIDGET_URL, lang('widgets_module_name'));
		$this->EE->cp->set_variable('cp_page_title', lang('widgets_delete_instance'));

		$id = $this->EE->input->get_post('instance_id');

		// Get the request from DB
		$this->data->widget_instance = $widget_instance = $this->EE->widget->get_instance($id);

		// Not here, must be an old link
		$widget_instance or $this->EE->functions->redirect(WIDGET_URL);

		// They hit cancel: Back to base!
		$this->EE->input->post('cancel') and $this->EE->functions->redirect(WIDGET_URL);

		// If the form matches validation
		if ($this->EE->input->post('confirm') )
		{
			if ($this->EE->widget->delete_instance($id))
			{
				$this->EE->session->set_flashdata('message_success', sprintf(lang('widgets_deleted_instance_message'), $widget_instance->instance_id));
				$this->EE->functions->redirect(WIDGET_URL);
			}

			else
			{
				$this->data->error = sprintf(lang('widgets_delete_instance_failed_message'), $widget_area->instance_id);
			}


		}

		// Set the form action
		$this->data->form_action = WIDGET_PARAMS.AMP.'method=delete_instance';

		return $this->EE->load->view('confirm_delete_instance', $this->data, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Delete area
	 *
	 * Remove a saved Widget area
	 *
	 * @return	string
	 */
	public function delete_area()
	{
		$this->EE->cp->set_breadcrumb(WIDGET_URL, lang('widgets_module_name'));
		$this->EE->cp->set_variable('cp_page_title', lang('widgets_delete_area'));

		$id = $this->EE->input->get_post('area_id');

		// Get the request from DB
		$this->data->widget_area = $widget_area = $this->EE->widget->get_area($id);

		// Not here, must be an old link
		$widget_area or $this->EE->functions->redirect(WIDGET_URL);

		// They hit cancel: Back to base!
		$this->EE->input->post('cancel') and $this->EE->functions->redirect(WIDGET_URL);

		// If the form matches validation
		if ($this->EE->input->post('confirm') )
		{
			if ($this->EE->widget->delete_area($id))
			{
				$this->EE->session->set_flashdata('message_success', sprintf(lang('widgets_deleted_area_message'), $widget_area->title));
				$this->EE->functions->redirect(WIDGET_URL);
			}

			else
			{
				$this->data->error = sprintf(lang('widgets_delete_area_failed_message'), $widget_area->title);
			}
		}

		// Set the form action
		$this->data->form_action = WIDGET_PARAMS.AMP.'method=delete_area';

		return $this->EE->load->view('confirm_delete_area', $this->data, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Edit
	 *
	 * Form to edit a saved WIDGET request
	 *
	 * @return	string
	 */
	public function details()
	{
		$this->EE->cp->set_breadcrumb(WIDGET_URL, lang('widgets_module_name'));

		$this->EE->cp->set_right_nav(array(
			'widgets_back_to_list' => WIDGET_URL
		));

		$id = $this->EE->input->get('widget_id');

		// Nevermind, find out whats going on
		$widget = $this->EE->widget->get_widget($id);
		
		// WTF you talkin 'bout?
		$widget or $this->EE->functions->redirect(WIDGET_URL);
		
		$this->EE->cp->set_variable('cp_page_title', $widget->title);

		$this->data->widget =& $widget;
		
		return $this->EE->load->view('details', $this->data, true);
	}
}

/* End of file mcp.rest.php */
/* Location: ./system/expressionengine/third_party/rest/mcp.rest.php */