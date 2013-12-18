<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');

$joomlaVersion = new JVersion(); 
$currentVersion = $joomlaVersion->getShortVersion(); 
$versionParts = explode('.', $currentVersion); 
$jversion = implode('', array_slice($versionParts, 0, 1));
define('J_VERSION', $jversion);
if(J_VERSION=='3'){
	define('J_SEPARATOR', '/');
}elseif(J_VERSION=='2'){
	define('J_SEPARATOR', DS);
}

class plgSystemYt extends JPlugin {
	function plgSystemYt(&$subject, $pluginconfig) {
		/*global $app;*/
		define('YT_FRAMEWORK', 1);
		parent::__construct($subject, $pluginconfig);
		
	}
	function onAfterInitialise() {
		include_once dirname(__FILE__).J_SEPARATOR.'includes'.J_SEPARATOR.'libs'.J_SEPARATOR.'resize'.J_SEPARATOR.'tool.php';
	}
	function onContentPrepareForm($form, $data){
		if($form->getName()=='com_menus.item'){
			JForm::addFormPath(JPATH_SITE.J_SEPARATOR.'plugins'.J_SEPARATOR.'system'.J_SEPARATOR.'yt'.J_SEPARATOR.'includes'.J_SEPARATOR.'libs'.J_SEPARATOR.'menu'.J_SEPARATOR.'params');
			$form->loadFile('params', false);
		}
	}
	function onAfterRender() {
		global $app;		 //var_dump($app); die();
		$document = JFactory::getDocument();
		$option   = JRequest::getVar('option', '');
		$task	  = JRequest::getVar('task', '');
		
		if($app->isSite() && $document->_type == 'html' && !$app->getCfg('offline') && (!($option == 'com_content' && $task =='edit'))){
			require_once('includes'.J_SEPARATOR.'libs'.J_SEPARATOR.'yt-minify.php');
			$yt_mini = new YT_Minify;
			
			if($app->getTemplate(true)->params->get('optimizeCSS', 0)) $yt_mini->optimizecss();
			if($app->getTemplate(true)->params->get('optimizeJS', 0)) $yt_mini->optimizejs();
			if($app->getTemplate(true)->params->get('optimizeHTML', 0)) $yt_mini->optimizehtml();
			
			$type	= JRequest::getVar('type');
			$action = JRequest::getVar('action');
			if($type == 'plugin' && $action == 'clearCache')
				$yt_mini->clearCache();
				
		}else{
			$uri 	= str_replace(J_SEPARATOR, "/", str_replace(JPATH_SITE, JURI::base(), dirname(__FILE__)));
			$uri 	= str_replace(DIRECTORY_SEPARATOR , '/', str_replace("/administrator/", "", $uri));
			$html   = "";
			if(J_VERSION=='2'){
				$html 	.= '<script language="javascript" type="text/javascript" src="'.$uri.'/includes/assets/jquery.min.js"></script>';
				$html 	.= '<script language="javascript" type="text/javascript" src="'.$uri.'/includes/assets/jquery-noconflict.js"></script>';
			}
			$html 	.= '<script language="javascript" type="text/javascript" src="'.$uri.'/includes/assets/clearcache.js"></script>';
			if($this->params->get('show_sjhelp', 0)==1){
				require_once('includes'.J_SEPARATOR.'assets'.J_SEPARATOR.'menu-sjhelp.php');	
			}
			$buffer = JResponse::getBody ();
			$buffer = preg_replace('/<\/head>/', $html . "\n</head>", $buffer);
			JResponse::setBody($buffer);							
		}

	}
}