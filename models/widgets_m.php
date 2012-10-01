<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		Widgets module
 * @author			Phil Sturgeon - PyroCMS Development Team
 *
 * Model to handle widgets
 */
class Widgets_m extends CI_Model
{
	protected $site_id;

	public function __construct()
	{
		parent::__construct();
		$this->site_id = config_item('site_id');
	}

	function get_widgets()
	{
		return $this->db
			->get('widgets')
			->result();
	}

	function get_instances()
	{
		$this->db->select('w.id, w.slug, wi.id as instance_id, wi.title as instance_title, w.title, wi.widget_area_id, wa.slug as widget_area_slug, wi.options')
			->from('widget_areas wa')
			->join('widget_instances wi', 'wa.id = wi.widget_area_id')
			->join('widgets w', 'wi.widget_id = w.id')
			->where('wi.site_id', $this->site_id);

		return $this->db->get()->row();
	}

	function get_instance($id)
	{
		$this->db->select('w.id, w.slug, wi.id as instance_id, wi.title as instance_title, w.title, wi.widget_area_id, wa.slug as widget_area_slug, wi.options')
			->from('widget_areas wa')
			->join('widget_instances wi', 'wa.id = wi.widget_area_id')
			->join('widgets w', 'wi.widget_id = w.id')
			->where('wi.site_id', $this->site_id)
			->where('wi.id', $id);

		return $this->db->get()->row();
	}

	function get_by_area($slug)
	{
		$this->db->select('wi.id, w.slug, wi.id as instance_id, wi.title as instance_title, w.title, wi.widget_area_id, wa.slug as widget_area_slug, wi.options')
			->from('widget_areas wa')
			->join('widget_instances wi', 'wa.id = wi.widget_area_id')
			->join('widgets w', 'wi.widget_id = w.id')
			->where('wa.slug', $slug)
			->where('wi.site_id', $this->site_id)
			->order_by('wi.order');

		/*
		 * Patch by Jordan Andree - 09/20/2012
		 * Returns widget_area_count with results
		 */
		$q = $this->db->get();
		$results = $q->result();
		foreach($results as $key => $r)
		{
			$results[$key]->widget_area_count = $q->num_rows();
		}

		return $results;
	}

	public function get_areas()
	{
		return $this->db
			->where('site_id', $this->site_id)
			->get('widget_areas')
			->result();
	}

	public function get_area_by($field, $id)
	{
		return $this->db
			->where('site_id', $this->site_id)
			->where($field, $id)
			->get('widget_areas')
			->row();
	}

	public function get_widget_by($field, $id)
	{
		return $this->db
			->where($field, $id)
			->get('widgets')
			->row();
	}

	public function insert_widget($input)
	{
		$this->db->insert('widgets', array(
			'title' 		=> $input['title'],
			'slug' 			=> $input['slug'],
			'description' 	=> $input['description'],
			'author' 		=> $input['author'],
			'website' 		=> $input['website'],
			'version' 		=> $input['version']
		));

		return $this->db->insert_id();
	}

	public function insert_area($input)
	{
		$this->db->insert('widget_areas', array(
			'title' => $input['title'],
			'slug' 	=> $input['slug'],
			'site_id' => $this->site_id
		));

		return $this->db->insert_id();
	}

	public function insert_instance($input)
	{
		$this->load->helper('date');

		$last_widget = $this->db->select('`order`')
			->order_by('`order`', 'desc')
			->limit(1)
			->get_where('widget_instances', array('widget_area_id' => $input['widget_area_id']))
			->row();

		$order = isset($last_widget->order) ? $last_widget->order + 1 : 1;

		$this->db->insert('widget_instances', array(
			'title' => $input['title'],
			'widget_id' => $input['widget_id'],
			'widget_area_id' => $input['widget_area_id'],
			'options' => $input['options'],
			'`order`' => $order,
			'created_on' => now(),
			'updated_on' => now(),
			'site_id' => $this->site_id
		));

		return $this->db->insert_id();
	}

	public function update_instance($instance_id, $input)
	{
		$this->db->where('id', $instance_id);
		$this->db->where('site_id', $this->site_id);

		return $this->db->update('widget_instances', array(
        	'title' => $input['title'],
			'widget_area_id' => $input['widget_area_id'],
			'options' => $input['options']
		));
	}

	function update_instance_order($id, $order)
	{
		$this->db->where('id', $id);
		$this->db->where('site_id', $this->site_id);

		return $this->db->update('widget_instances', array(
        	'`order`' => (int) $order
		));
	}

	function delete_widget($slug)
	{
		$widget = $this->db->select('id')->get_where('widgets', array('slug' => $slug))->row();

		if(isset($widget->id))
		{
			$this->db->delete('widget_instances', array('widget_id' => $widget->id));
		}

		return $this->db->delete('widgets', array('slug' => $slug));
	}

	public function delete_area($id)
	{
		// Delete widgets in that area
		$this->db->delete('widget_instances', array('widget_area_id' => $id));

		// Delete this area
		return $this->db->delete('widget_areas', array('id' => $id));
	}

	function delete_instance($id)
	{
		return $this->db->delete('widget_instances', array('id' => $id));
	}
}
