<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package 		ExpressionEngine 2: Widgets
 * @subpackage 		Twitter Feed Widget
 * @author			Phil Sturgeon - MizuCMS Development Team
 * 
 * Show Twitter streams in your site
 */

class Widget_Twitter_feed extends Widgets
{
	public $title = 'Twitter Feed';
	public $description = 'Display Twitter feeds on your websites.';
	public $author = 'Phil Sturgeon';
    public $website = 'http://philsturgeon.co.uk/';
	public $version = '1.0';
	
	public $fields = array(
		array(
			'field'   => 'username',
			'label'   => 'Username',
			'rules'   => 'required'
		),
		array(
			'field'   => 'date_format',
			'label'   => 'Date format',
			'rules'   => 'required|trim'
		),
		array(
			'field'   => 'number',
			'label'   => 'Number of tweets',
			'rules'   => 'numeric'
		)
	);

	public function run($options)
	{
		$this->load->helper('url');
		
		// If no number provided, just get 5
		isset($options['number']) || $options['number'] = 5;
		isset($options['date_format']) || $options['date_format'] = 'd-m-Y h:m';

		$patterns = array(
			// Detect URL's
			'|([a-z]{3,9}://[a-z0-9-_./?&+]*)|i'     => '<a href="$0" target="_blank">$0</a>',

			// Detect Email
			'|[a-z0-9._%+-]+@[a-z0-9.-]+.[a-z]{2,6}|i' => '<a href="mailto:$0">$0</a>',

			// Detect Twitter @usernames
			'|@([a-z0-9-_]+)|i'     => '<a href="http://twitter.com/$1" target="_blank">$0</a>',

			// Detect Twitter #tags
			'|#([a-z0-9-_]+)|i'     => '<a href="http://twitter.com/search?q=%23$1" target="_blank">$0</a>'
		);

		$doc = new DOMDocument();
		$doc->load('http://twitter.com/statuses/user_timeline/'.$options['username'].'.rss');
		$tweets = array();

		foreach ($doc->getElementsByTagName('item') as $node)
		{
			$tweet = $node->getElementsByTagName('description')->item(0)->nodeValue;
			$tweet = str_replace($options['username'].': ', '', $tweet);
			$tweet = preg_replace(array_keys($patterns), array_values($patterns), $tweet);
			
			array_push($tweets, array(
				'text' => $tweet,
				'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
				'date' => date($options['date_format'], strtotime($node->getElementsByTagName('pubDate')->item(0)->nodeValue))
			));

			if(count($tweets) == $options['number'])
			{
				break;
			}
		}

		// Store the feed items
		return array(
			'tweets' => $tweets
		);
	}

	public function form($options)
	{
		empty($options['number']) AND $options['number'] = 5;
		empty($options['date_format']) AND $options['date_format'] = 'd-m-Y h:m';

		return array('options' => $options); 
	}
}
