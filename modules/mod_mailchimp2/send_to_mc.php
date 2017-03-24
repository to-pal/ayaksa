<?php
    define( '_JEXEC', 1 );
    define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../' ));  
    require_once ( JPATH_BASE .'/includes/defines.php' );
    require_once ( JPATH_BASE .'/includes/framework.php' );

    $mainframe = JFactory::getApplication('site');


/**
* @Copyright Copyright (C) 2017 3by400, Inc.
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// the work's all done here, getting the info and making the call to the MailChimp API
function send_to_mc(){

	
	$session = JFactory::getSession();
	
	$timeoutMin = 10; //seconds to wait for API call
	$timeoutDefault = 15;
	$timeoutMax = 500; 
	

	$email = isset($_POST['email'])?$_POST['email']:'';
	$mid =  isset($_POST['mid'])?$_POST['mid']:'';
	$first =  isset($_POST['first'])?$_POST['first']:'';
	$last =  isset($_POST['last'])?$_POST['last']:'';
	
	if(isset($_POST['ig'])) {
		$ig_struct = make_ig($_POST['ig']);
	}


	defined('_JEXEC') or define( '_JEXEC', 1 );
	defined ('JPATH_BASE') or define('JPATH_BASE', $_SERVER['DOCUMENT_ROOT'] );
	defined('DS') or define( 'DS', DIRECTORY_SEPARATOR );

	require_once (JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once (JPATH_BASE .DS.'includes'.DS.'framework.php' );

	$mainframe = JFactory::getApplication('site'); //was by reference
	$mainframe->initialise();
	
	//language substitution
	$lang = JFactory::getLanguage(); //was by reference
	$lang->load('mod_mailchimp2',JPATH_ROOT);
	
	global $mainframe;

	$db = JFactory::getDBO(); //was by reference


	// Validation
	// MOD_MAILCHIMP2_NO_EMAIL_PROVIDED would also work
	if(!$email){
		$retval = JText::_('MOD_MAILCHIMP2_ERROR_INVALID_EMAIL');
		return $retval;
	} 

	$subscriber_hash = md5(strtolower($email));
	
	//
	// Try to read the module parameters directly
	//
	
	jimport( 'joomla.application.module.helper' );
	$module = JModuleHelper::getModule( 'mod_mailchimp2' ); //FIXME: should choose module title to get the right module

		
	//
	// If we can't read module params, grab the params object from the session
	//
	
	if ( !isset($module->params) || empty($module->params) ) {

		$session = JFactory::getSession();
		$sessionParams = $session->get('params', "", "mod_mailchimp2");	
		$paramsCatcher = json_decode($sessionParams);

	} else {
	
		$paramsCatcher = json_decode($module->params);
	}
	
	$apikey = $paramsCatcher->mc_api_key;

	if(!$apikey){
	$retval = JText::_('MOD_MAILCHIMP2_ERROR_NO_API_KEY');
		return($retval);
	}
	
	// Timeout sanity check
	$timeout = $timeoutDefault;
	if(property_exists($paramsCatcher, "mc_timeout")) {
		if (is_numeric($paramsCatcher->mc_timeout) && $paramsCatcher->mc_timeout >= $timeoutMin && $paramsCatcher->mc_timeout <= $timeoutMax) {
			$timeout = $paramsCatcher->mc_timeout;
		}
	}
	

	// pull in the MailChimp API
	require_once('MailChimp.php');
	$api = new DrewM\MailChimp\MailChimp($apikey);
	
	$api->verify_ssl = true;
	if(isset($paramsCatcher->mc_verify_ssl)) {
		$api->verify_ssl = $paramsCatcher->mc_verify_ssl;
	}


	$member = $api->get("/lists/" . $paramsCatcher->mc_unique_id . "/members/$subscriber_hash");
	
	
	if($api->success()){
		$old_interests = $member['interests'];
		foreach ($old_interests as $index => $entry) {
			$old_interests[$index] = false;
		}
	}
	
	
	$list = $api->get("lists/" . $paramsCatcher->mc_unique_id);
	
	if(!$api->success()){
		$retval = JText::_('MOD_MAILCHIMP2_ERROR_NO_LIST');
		return $retval;
	}
	

	//Available merge vars retrieved from the list
	$mergevars_list = $api->get("lists/" . $paramsCatcher->mc_unique_id . "/merge-fields");
	

	// finally! the Subscribe
	$subscribe_args = array("email_address" => $email, "status" => "pending", "status_if_new" => "pending", );

	foreach($mergevars_list['merge_fields'] as $mergevar){
		$tag = $mergevar['tag'];
		if($tag == 'EMAIL') {
			continue;
		} else {
			if(  isset($_POST[$tag])  ){
				$subscribe_args['merge_fields'][$tag]=$_POST[$tag];
			}
		}
	}	

	
	// Subscribe the user
	
	$result = $api->put("/lists/" . $paramsCatcher->mc_unique_id . "/members/" . $subscriber_hash, $subscribe_args);
	
	
	if ($api->success()) {
		
		// It worked!
		if($paramsCatcher->lang_override_success) {
			$retval = $paramsCatcher->lang_override_success  . " ";
		} else {
			$retval = JText::_('MOD_MAILCHIMP2_MESSAGE_SUCCESS');
		}
		return $retval;
		
	} else {
		
		if($paramsCatcher->lang_override_failure) {
			$retval = $paramsCatcher->lang_override_failure . " ";
		} else {
			$retval = JText::_('MOD_MAILCHIMP2_ERROR_SUBSCRIBE');
		}
		

		$retval .= $result['detail'];
		$retval .= "<br /> " . $result['instance'];
		
		// validation problems
		
		if(isset($result['errors'])) {
			
			foreach( $result['errors'] as $errorfield) {
				
				$retval .= "<div>";
				$retval .= $errorfield['field'] . ": " . $errorfield['message'] . "<br />";
				$retval .= "</div>";
				
			}
		}

		return $retval;

	}
	
}

function make_ig($submitted_igs){

	/*
	Format POST data for API 3.0 Interests into Interests array
	*/
	$interests_list = array();
	$parts = ( array_filter ( explode(",", $submitted_igs) ) ); //strips "empty" values
	
	foreach($parts as $part){
		//discard group idate
		if(preg_match('/^mcig_/', $part)) {
			continue;
		} else {
			$interests_list[$part] = true;
		}
		
	}
	
	$ret = Array( "interests" => $interests_list );
		
	return($ret);
}	// end of make_ig 

// If being called via ajax, autorun the function with email address and module id
//if($_POST['ajax']){ echo send_to_mc(); }
if($_REQUEST['ajax']){ echo send_to_mc(); }


//EOF