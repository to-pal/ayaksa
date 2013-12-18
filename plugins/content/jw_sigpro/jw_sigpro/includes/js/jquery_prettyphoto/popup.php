<?php
/**
 * @version		2.6.0
 * @package		Simple Image Gallery Pro
 * @author		JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		http://www.joomlaworks.net/license
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$relName = 'prettyPhoto';

$stylesheets = array('css/prettyPhoto.css');
$stylesheetDeclarations = array();
$scripts = array(
	'js/jquery.prettyPhoto.js'
);
$scriptDeclarations = array('
	//<![CDATA[
	jQuery.noConflict();
	jQuery(function($) {
		$("a[rel^=\'prettyPhoto\']").prettyPhoto({
			animation_speed:\'fast\',
			slideshow:5000,
			autoplay_slideshow:false,
			opacity:0.80,
			show_title:false,
			allow_resize:true,
			default_width:500,
			default_height:344,
			counter_separator_label:\'/\',
			theme:\'pp_default\',
			horizontal_padding:20,
			hideflash:false,
			wmode:\'opaque\',
			autoplay:true,
			modal:false,
			deeplinking:true,
			overlay_gallery:true,
			keyboard_shortcuts:true,
			ie6_fallback:true,
			custom_markup:\'\',
			social_tools:\'\'
		});
	});
	//]]>
');
