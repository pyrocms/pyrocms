<?php
/**
 * @package 		PyroCMS
 * @subpackage 		Latest news Widget
 * @author			Erik Berman
 *
 * Show Latest news in your site with a widget. Intended for use on cms pages
 *
 * Usage : on a CMS page add {widget_area('name_of_area')}
 * where 'name_of_area' is the name of the widget area you created in the admin control panel
 */

class Widget_Latest_news extends Widgets
{
	public $title = 'Latest news';
	public $description = 'Display latest news articles with a widget.';
	public $author = 'Erik Berman';
	public $website = 'http://www.nukleo.fr';
	public $version = '1.0';

	// build form fields for the backend
	// MUST match the field name declared in the form.php file
	public $fields = array(
		array(
			'field'   => 'limit',
			'label'   => 'Number of articles',
		)
	);

	public function form($options)
	{
		!empty($options['limit']) OR $options['limit'] = 5;

		return array(
			'options' => $options
		);
	}

	public function run($options)
	{
		// load the news module's model
		class_exists('News_m') OR $this->load->model('news/news_m');

		// sets default number of articles to be shown
		empty($options['limit']) AND $options['limit'] = 5;

		// retrieve the records using the news module's model
		$news_widget = $this->news_m->limit($options['limit'])->get_many_by(array('status' => 'live'));

		// returns the variables to be used within the widget's view
		return array('news_widget' => $news_widget);
	}
}