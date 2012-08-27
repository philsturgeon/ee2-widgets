<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		ExpressionEngine 2: Widgets
 * @subpackage 		RSS Feed Widget
 * @author			Phil Sturgeon - PyroCMS Development Team
 * 
 * Show RSS feeds in your site
 */

class Widget_Rss_feed extends Widgets
{
	public $title = 'RSS Feed';
	public $description = 'Display parsed RSS feeds on your websites.';
	public $author = 'Phil Sturgeon';
	public $website = 'http://philsturgeon.co.uk/';
	public $version = '1.0';
	
	public $fields = array(
		array(
			'field'   => 'feed_url',
			'label'   => 'Feed URL',
			'rules'   => 'required'
		),
		array(
			'field'   => 'date_format',
			'label'   => 'Date format',
			'rules'   => 'trim'
		),
		array(
			'field'   => 'number',
			'label'   => 'Number of items',
			'rules'   => 'numeric'
		)
	);

	public function run($options)
	{
		$this->load->helper('url');

		!empty($options['number']) || $options['number'] = 5;
		!empty($options['date_format']) || $options['date_format'] = 'd-m-Y h:m';
		
		$doc = new DOMDocument();
		$doc->load($options['feed_url']);
		$items = array();

		foreach ($doc->getElementsByTagName('item') as $node)
		{
			array_push($items, array(
				'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
				'description' => $node->getElementsByTagName('description')->item(0)->nodeValue,
				'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
				'date' => date($options['date_format'], strtotime($node->getElementsByTagName('pubDate')->item(0)->nodeValue))
			));

			if(count($items) == $options['number'])
			{
				break;
			}
		}
		
		// Store the feed items
		return array(
			'rss_items' => $items
		);
	}
	
	public function form($options)
	{
		empty($options['number']) AND $options['number'] = 5;
		empty($options['date_format']) AND $options['date_format'] = 'd-m-Y h:m';

		return array('options' => $options); // $test = thing in form.php
	}
	
	public function save($options)
	{
		$this->load->helper('url');
		
		$options['feed_url'] = prep_url($options['feed_url']);
		
		return $options;
	}
}
