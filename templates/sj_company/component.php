<?php
/*
 * ------------------------------------------------------------------------
 * Yt FrameWork for Joomla 3.0
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2012 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/

defined('_JEXEC') or die;
if(J_VERSION=='3'){
	define('J_TEMPLATEDIR', __DIR__);
}elseif(J_VERSION=='2'){
	define('J_TEMPLATEDIR', dirname(__FILE__));
}
// Include class YtTemplate
include_once (J_TEMPLATEDIR.'/includes/yt_template.class.php');
// Include file: frame_inc.php
include_once (J_TEMPLATEDIR.'/includes/frame_inc.php');
// Check RTL or LTF direction
$dir = ($ytrtl == 'rtl') ? ' dir="rtl"' : '';

$app   = JFactory::getApplication();
$doc   = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="head" />
    <?php 
    include_once (J_TEMPLATEDIR.'/includes/head.php');
    ?>
</head>
<body class="contentpane">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</body>
</html>




