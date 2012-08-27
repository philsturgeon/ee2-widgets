<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Installer for Widgets module
 *
 * @package		Widgets
 * @subpackage	Third-Party
 * @category	Modules
 * @author		Phil Sturgeon
 * @link		http://devot-ee.com/add-ons/widgets
 */
class Widgets_upd {

	public $module_name = "Widgets";
	public $version     = '1.3.0';

    public function Widgets_upd()
    {
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
    }

    /**
     * Installer for the Rating module
     */
    public function install()
	{
		$data = array(
			'module_name' 	 => $this->module_name,
			'module_version' => $this->version,
			'has_cp_backend' => 'y'
		);

		$this->EE->db->insert('modules', $data);

		$this->EE->db->query('CREATE TABLE '.$this->EE->db->dbprefix('widget_areas').' (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `slug` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `site_id` int(11) NOT NULL DEFAULT 0,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `unique_slug` (`slug`)
		)');

		$this->EE->db->query('CREATE TABLE '.$this->EE->db->dbprefix('widget_instances').' (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `widget_id` int(11) DEFAULT NULL,
		  `widget_area_id` int(11) DEFAULT NULL,
		  `options` text COLLATE utf8_unicode_ci NOT NULL,
		  `order` int(10) NOT NULL DEFAULT 0,
		  `created_on` int(11) NOT NULL DEFAULT 0,
		  `updated_on` int(11) NOT NULL DEFAULT 0,
		  `site_id` int(11) NOT NULL DEFAULT 0,
		  PRIMARY KEY (`id`)
		)');

		$this->EE->db->query('CREATE TABLE '.$this->EE->db->dbprefix('widgets').' (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT "",
		  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT "",
		  `description` text COLLATE utf8_unicode_ci NOT NULL,
		  `author` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT "",
		  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT "",
		  `version` int(3) NOT NULL DEFAULT 0,
		  `site_id` int(11) NOT NULL DEFAULT 0,
		  PRIMARY KEY (`id`)
		)');

		return TRUE;
	}


	/**
	 * Uninstall the Widgets module
	 */
	public function uninstall()
	{
		$this->EE->load->dbforge();

		$this->EE->db->select('module_id');
		$query = $this->EE->db->get_where('modules', array('module_name' => $this->module_name));

		$this->EE->db->where('module_id', $query->row('module_id'));
		$this->EE->db->delete('module_member_groups');

		$this->EE->db->where('module_name', $this->module_name);
		$this->EE->db->delete('modules');

		$this->EE->dbforge->drop_table('widget_areas');
		$this->EE->dbforge->drop_table('widget_instances');
		$this->EE->dbforge->drop_table('widgets');

		return TRUE;
	}

	/**
	 * Update the module
	 *
	 * @param $current current version number
	 * @return boolean indicating whether or not the module was updated
	 */

	public function update($current = '')
	{
		return FALSE;
	}

}

/* End of file upd.module_creator.php */
/* Location: ./system/expressionengine/third_party/rating/upd.module_creator.php */ 