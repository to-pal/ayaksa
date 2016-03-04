<?php
/**
 * @package Kwicks for joomla
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 Alex Palesika .
 * @author Alex Palesika
 * 
 */
defined('_JEXEC') or die;

$com_path = JPATH_SITE.'/components/com_content/';
require_once $com_path.'router.php';
require_once $com_path.'helpers/route.php';

JModelLegacy::addIncludePath($com_path . '/models', 'ContentModel');
abstract class KwicksHelper
{
	public static function getList(&$params)
	{
		$db = JFactory::getDbo();
		// Get an instance of the generic articles model
		$articles = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		// Set application parameters in model
		
		$articles->setState(
				'list.select',
				'a.id, a.title, a.alias, a.introtext, a.fulltext, ' .
				'a.checked_out, a.checked_out_time, ' .
				'a.catid, a.created, a.created_by, a.created_by_alias, ' .
				// use created if modified is 0
				'CASE WHEN a.modified = ' . $db->q($db->getNullDate()) . ' THEN a.created ELSE a.modified END as modified, ' .
				'a.modified_by, uam.name as modified_by_name,' .
				// use created if publish_up is 0
				'CASE WHEN a.publish_up = ' . $db->q($db->getNullDate()) . ' THEN a.created ELSE a.publish_up END as publish_up,' .
				'a.publish_down, a.images, a.urls, a.attribs, a.metadata, a.metakey, a.metadesc, a.access, ' .
				'a.hits, a.xreference, a.featured'
		);
				
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		
		$articles->setState('params', $appParams);
		// Set the filters based on the module params
		$articles->setState('list.start', 0);
		$articles->setState('list.limit', (int) $params->get('count', 0));
		$articles->setState('filter.published', 1);

		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$articles->setState('filter.access', $access);
		
		// Category filter
		$catids = $params->get('catid');
		if ($catids != null) {
			if ($params->get('show_child_category_articles', 0) && (int) $params->get('levels', 0) > 0) {
				// Get an instance of the generic categories model
				$categories = JModelLegacy::getInstance('Categories', 'ContentModel', array('ignore_request' => true));
				$categories->setState('params', $appParams);
				$levels = $params->get('levels', 1) ? $params->get('levels', 1) : 9999;
				$categories->setState('filter.get_children', $levels);
				$categories->setState('filter.published', 1);
				$categories->setState('filter.access', $access);
				$additional_catids = array();
			
				foreach($catids as $catid)
				{
					$categories->setState('filter.parentId', $catid);
					$recursive = true;
					$items = $categories->getItems($recursive);
			
					if ($items)
					{
						foreach($items as $category)
						{
							$condition = (($category->level - $categories->getParent()->level) <= $levels);
							if ($condition) {
								$additional_catids[] = $category->id;
							}
			
						}
					}
				}
			
				$catids = array_unique(array_merge($catids, $additional_catids));
			}
			$articles->setState('filter.category_id', $catids);
		
		// Ordering
		$articles->setState('list.ordering', $params->get('article_ordering', 'a.ordering'));
		$articles->setState('list.direction', $params->get('article_ordering_direction', 'ASC'));

// 		// New Parameters
		$articles->setState('filter.featured', $params->get('show_front', 'show'));

		// Filter by language
		$articles->setState('filter.language', $app->getLanguageFilter());

		$items = $articles->getItems();
		//var_dump($items); die("ancnc");
		$show_introtext = $params->get('show_introtext', 0);
		$introtext_limit = $params->get('introtext_limit', 100);
		$title_limit = $params->get('item_title_max_characs', 20);

		// Find current Article ID if on an article page
		$option = $app->input->get('option');
		$view = $app->input->get('view');

		if ($option === 'com_content' && $view === 'article') {
			$active_article_id = $app->input->getInt('id');
		}
		else {
			$active_article_id = 0;
		}

		// Prepare data for display using display options
		foreach ($items as &$item)
		{
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid ? $item->catid .':'.$item->category_alias : $item->catid;

			if ($access || in_array($item->access, $authorised))
			{
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			}
			else
			{
				$app  = JFactory::getApplication();
				$menu = $app->getMenu();
				$menuitems = $menu->getItems('link', 'index.php?option=com_users&view=login');
				if (isset($menuitems[0]))
				{
					$Itemid = $menuitems[0]->id;
				}
				elseif ($app->input->getInt('Itemid') > 0)
				{
					// Use Itemid from requesting page only if there is no existing menu
					$Itemid = $app->input->getInt('Itemid');
				}
				$item->link = JRoute::_('index.php?option=com_users&view=login&Itemid='.$Itemid);
			}

			// Used for styling the active article
			$item->active = $item->id == $active_article_id ? 'active' : '';
			if ($show_introtext) {
				$item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_kwicks.content');
				self::getImages($item, $params);
				$item->introtext = self::_cleanIntrotext($item->introtext);
			} else {
				$item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_kwicks.content');
				self::getImages($item, $params);
			}
			$item->displayIntrotext = $show_introtext ? self::truncate($item->introtext, $introtext_limit) : '';
			$item->displayReadmore = $item->alternative_readmore;
		}//var_dump($items); die("ancnnc");
		return $items;
		}
	}


	public static $image_cache = array();
	
	public static function getImage($item, $params, $ctype='article'){
		$images = self::getImages($item, $params, $ctype);
		return is_array($images) && count($images) ? $images[0] : null;
	}
	
	public static function getImages($item, $params, $ctype='article'){
		$hash = md5( serialize(array($params, $ctype)) );
		if ( !isset(self::$image_cache[$hash][$item->id]) ){
			// self::$image_cache[$type][$item->id] = array();
				
			$defaults = array(
					'external'	=> 1,
					'image_intro'		=> 1,
					'inline_introtext'	=> 1,
					'image_fulltext'	=> 1,
					'inline_fulltext'	=> 1
			);
				
			$images_path = array();
	
			$priority = preg_split('/[\s|,|;]/', $params->get('imgcfg_order', 'external, imagE_intro,inline_introtext,image_fulltext,inline_fulltext'), -1, PREG_SPLIT_NO_EMPTY);
			if ( count($priority) > 0 ){
				// $priority = array_map('trim', $priority);
				$priority = array_map('strtolower', $priority);
				$mark = array();
	
				for($i=0; $i<count($priority); $i++){
					$type = $priority[$i];
					if ( array_key_exists($type, $defaults) )
						unset($defaults[ $type ]);
					if ( $params->get('imgcfg_from_'.$type, 1) )
						$mark[ $type ] = 1;
				}
			}
			foreach($defaults as $type => $val){
				if ( $params->get('imgcfg_from_'.$type, 1) )
					$mark[ $type ] = 1;
			}
			//var_dump($mark);
			if ( count($mark) > 0 ){
				// prepare data.
				$images_data = null;
				if (array_key_exists('image_intro', $mark) || array_key_exists('image_fulltext', $mark)){
					$images_data = json_decode($item->images, true);
				}
	
				foreach($mark as $type => $true){
					switch ($type){
						case 'image_intro':
						case 'image_fulltext':
							if ( isset($images_data) && isset($images_data[$type]) && !empty($images_data[$type])){
								$image = array(
										'src' => $images_data[$type]
								);
								if (array_key_exists($type.'_alt', $images_data)){
									$image['alt'] = $images_data[$type.'_alt'];
								}
								if (array_key_exists($type.'_caption', $images_data)){
									/* $image['class'] = 'caption'; */
									$image['title'] = $images_data[$type.'_caption'];
								}
								array_push($images_path, $image);
							}
							break;
						case 'inline_introtext':
							$text = $item->introtext;
						case 'inline_fulltext':
							if ($type == 'inline_fulltext'){
								$text = $item->fulltext;
							}
							$inline_images = self::getInlineImages($text);
							for ($i=0; $i<count($inline_images); $i++){
								array_push($images_path, $inline_images[$i]);
							}
							break;
	
						case 'external':
							$exf = $params->get('imgcfg_external_url', '/images');
							preg_match_all('/{([a-zA-Z0-9_]+)}/', $exf, $m);
							if ( count($m)==2 && count($m[0])>0 ){
								$compat = 1;
								foreach ($m[1] as $property){
									!property_exists($item, $property) && ($compat=0);
								}
								if ($compat){
									$replace = array();
									foreach ($m[1] as $property){
										$replace[] = is_null($item->$property) ? '' : $item->$property;
									}
									$exf = str_replace($m[0], $replace, $exf);
								}
							}
							$files = self::getExternalImages($exf);
							for ($i=0; $i<count($files); $i++){
								array_push($images_path, array('src'=>$files[$i]));
							}
							break;
						default:
							break;
					}
				}
			}
			
			if ( count($images_path) == 0 && $params->get('imgcfg_placeholder', 1)==1){
				$images_path[] = array('src'=> $params->get('imgcfg_placeholder_path', 'modules/mod_kwicks/assets/images/nophoto.png'), 'class'=>'placeholder');
			}
				
			self::$image_cache[$hash][$item->id] = $images_path;
		}
		return self::$image_cache[$hash][$item->id];
	}
	
	public static function getInlineImages($text){
		$images = array();
		$searchTags = array(
				'img'	=> '/<img[^>]+>/i',
				'input'	=> '/<input[^>]+type\s?=\s?"image"[^>]+>/i'
		);
		foreach ($searchTags as $tag => $regex){
			preg_match_all($regex, $text, $m);
			if ( is_array($m) && isset($m[0]) && count($m[0])){
				foreach ($m[0] as $htmltag){
					$tmp = JUtility::parseAttributes($htmltag);
					if ( isset($tmp['src']) ){
						if ($tag == 'input'){
							array_push( $images, array('src' => $tmp['src']) );
						} else {
							array_push( $images, $tmp );
						}
					}
				}
			}
		}
		return $images;
	}
	
	public static function getExternalImages($path){
		$files = array();
		$ps = JString::parse_url($path);
		if ( array_key_exists('path', $ps) && !empty($ps['path']) ){
			$isHttp = isset($ps['scheme']) && in_array($ps['scheme'], array('http', 'https'));
			if (!$isHttp || JURI::isInternal($path)){
				// image on server
				$path = $ps['path'];
			} else {
				$files[] = array( 'src' => $path );
				return $files;
			}
		}
	
		if (is_file($path)){
			$files[] = $path;
		} else if (is_dir($path)){
			$files = JFolder::files($path, '.jpg|.png|.gif', false, true);
		} else {
			$ext = substr($path, -4);
			$search = substr($path, 0, -4);
			$lext = strtolower($ext);
			if ( is_dir($search) && in_array($lext, array('.jpg', '.png', '.gif')) ){
				$files = JFolder::files($search, $ext, false, true);
			}
		}
		return $files;
	}
	
	
	public static function _cleanIntrotext($introtext)
	{
		$introtext = str_replace('<p>', ' ', $introtext);
		$introtext = str_replace('</p>', ' ', $introtext);
		$introtext = strip_tags($introtext, '<a><em><strong>');
	
		$introtext = trim($introtext);
	
		return $introtext;
	}
	
	/**
	 * Method to truncate introtext
	 *
	 * The goal is to get the proper length plain text string with as much of
	 * the html intact as possible with all tags properly closed.
	 *
	 * @param string   $html       The content of the introtext to be truncated
	 * @param integer  $maxLength  The maximum number of charactes to render
	 *
	 * @return  string  The truncated string
	 */
	public static function truncate($html, $maxLength = 0)
	{
		$baseLength = strlen($html);
		$diffLength = 0;
	
		// First get the plain text string. This is the rendered text we want to end up with.
		$ptString = JHtml::_('string.truncate', $html, $maxLength, $noSplit = true, $allowHtml = false);
	
		for ($maxLength; $maxLength < $baseLength;)
		{
			// Now get the string if we allow html.
			$htmlString = JHtml::_('string.truncate', $html, $maxLength, $noSplit = true, $allowHtml = true);
	
			// Now get the plain text from the html string.
			$htmlStringToPtString = JHtml::_('string.truncate', $htmlString, $maxLength, $noSplit = true, $allowHtml = false);
	
			// If the new plain text string matches the original plain text string we are done.
			if ($ptString == $htmlStringToPtString)
			{
				return $htmlString;
			}
			// Get the number of html tag characters in the first $maxlength characters
			$diffLength = strlen($ptString) - strlen($htmlStringToPtString);
	
			// Set new $maxlength that adjusts for the html tags
			$maxLength += $diffLength;
			if ($baseLength <= $maxLength || $diffLength <= 0)
			{
				return $htmlString;
			}
		}
		return $html;
	}
	
	public static function groupBy($list, $fieldName, $article_grouping_direction, $fieldNameToKeep = null)
	{
		$grouped = array();
	
		if (!is_array($list)) {
			if ($list == '') {
				return $grouped;
			}
	
			$list = array($list);
		}
	
		foreach($list as $key => $item)
		{
			if (!isset($grouped[$item->$fieldName])) {
				$grouped[$item->$fieldName] = array();
			}
	
			if (is_null($fieldNameToKeep)) {
				$grouped[$item->$fieldName][$key] = $item;
			}
			else {
				$grouped[$item->$fieldName][$key] = $item->$fieldNameToKeep;
			}
	
			unset($list[$key]);
		}
	
		$article_grouping_direction($grouped);
	
		return $grouped;
	}
	
	public static function groupByDate($list, $type = 'year', $article_grouping_direction, $month_year_format = 'F Y')
	{
		$grouped = array();
	
		if (!is_array($list)) {
			if ($list == '') {
				return $grouped;
			}
	
			$list = array($list);
		}
	
		foreach($list as $key => $item)
		{
			switch($type)
			{
				case 'month_year':
					$month_year = JString::substr($item->created, 0, 7);
	
					if (!isset($grouped[$month_year])) {
						$grouped[$month_year] = array();
					}
	
					$grouped[$month_year][$key] = $item;
					break;
	
				case 'year':
				default:
					$year = JString::substr($item->created, 0, 4);
	
					if (!isset($grouped[$year])) {
						$grouped[$year] = array();
					}
	
					$grouped[$year][$key] = $item;
					break;
			}
	
			unset($list[$key]);
		}
	
		$article_grouping_direction($grouped);
	
		if ($type === 'month_year') {
			foreach($grouped as $group => $items)
			{
				$date = new JDate($group);
				$formatted_group = $date->format($month_year_format);
				$grouped[$formatted_group] = $items;
				unset($grouped[$group]);
			}
		}
	
		return $grouped;
	}
}
