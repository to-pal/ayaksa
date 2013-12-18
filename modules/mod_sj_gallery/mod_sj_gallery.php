<?php
/**
 * @package Sj Gallery
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 * 
 */
defined('_JEXEC') or die;
require_once __DIR__ . '/core/helper.php';

/* JHtml::stylesheet('modules/mod_sj_gallery/assets/css/gallery.css');
JHtml::stylesheet('modules/mod_sj_gallery/assets/css/jquery.fancybox-1.3.4.css');
if( !defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1" ){
	JHtml::script('modules/mod_sj_gallery/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/mod_sj_gallery/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}
JHtml::script('modules/mod_sj_gallery/assets/js/jsmart.easing.1.3.js');
JHtml::script('modules/mod_sj_gallery/assets/js/jquery.fancybox-1.3.4.pack.js');
JHtml::script('modules/mod_sj_gallery/assets/js/jquery.cycle.all.2.72.js'); */

$cacheparams = new stdClass;
$cacheparams->cachemode = 'id';
// Class call from cache
$cacheparams->class = 'SjGalleryReader';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$items = SjGalleryReader::getList($params);
require JModuleHelper::getLayoutPath('mod_sj_gallery', $params->get('layout', 'default'));

?>