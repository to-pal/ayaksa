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

$relName = 'gb_imageset';

$stylesheets = array('gb_styles.css');
$stylesheetDeclarations = array();
$scripts = array('AJS.js','AJS_fx.js');
$scriptDeclarations = array('
	//<![CDATA[
	var GB_ROOT_DIR = "'.$popupPath.'/";
	//]]>
');

$legacyHeadIncludes = '<script type="text/javascript" src="'.$popupPath.'/gb_scripts.js"></script>';
