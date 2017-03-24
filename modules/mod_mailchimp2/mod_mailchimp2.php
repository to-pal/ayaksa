<?php
/**
* @Copyright Copyright (C) 2017 3by400, Inc.
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted Access');
define('DEFAULT_FIELD_SIZE', 25);
define('MIN_FIELD_SIZE', 10);

$css_class_label = "modmc2_label";

// Pass params to session.
// AJAX call will retrieve params from session if it can't read the module params

$session = JFactory::getSession();
$session->set('params', $params, "mod_mailchimp2");


// AJAX	Type
//
// Determines which of two mutually-exclusive AJAX calls to run
//
// MC_AJAX_TYPE_SELF = Call another copy of itself
// Incompatible with some frameworks
//
// MC_AJAX_TYPE_DIRECT = Call send_to_mc.php directly
// Incompatible with security frameworks that prevent direct access
// add to your site's whitelist if necessary
//

$ajaxtype = $params->get('mc_ajax_type', 'MC_AJAX_TYPE_SELF');
?>


	<?php
	/* NEW:
	The page the user is facing will call another copy of itself
	to allow a dedicated AJAX call but still avoid having to install and maintain a component.
	This copy will be called with the mode=send query parameter.
	
	Send a new header and echo a plain HTML response.
	*/
	$mode = JRequest::getCmd('mode');
	if($mode == "send") {
		header( "Content-Type: text/html; charset=utf-8" );
		include ('send_to_mc.php');
		exit();
	}
	?>

	

<div class="inner-module" >
	<script type="text/javascript" src="<?php echo JURI::base(); ?>modules/mod_mailchimp2/url.js"> </script>
	<script type="text/javascript" src="<?php echo JURI::base(); ?>modules/mod_mailchimp2/ajax.js"> </script>


	<script type="text/javascript">
	//<![CDATA[

	// Global Ajax request
	var MCajaxReq = new MCAjaxRequest();

	// Add a new email address on the server using Ajax

	function addEmailAddress() {


	
		var lang_error_invalid_email = '<?php echo modMC2_escapeJavaScriptText(JText::_('MOD_MAILCHIMP2_ERROR_INVALID_EMAIL'));?>';
		var lang_message_adding = '<?php echo modMC2_escapeJavaScriptText(JText::_('MOD_MAILCHIMP2_MESSAGE_ADDING'));?>';

		<?php if($params->get('mc_checkemailaddress')): ?>
		// check email address for validity.
		// disabled by default.
		var regex = /^[\w\.\-_\+]+@[\w-]+(\.\w{2,6})+$/;

		if(!regex.test(document.getElementById("mc2_email").value)){
			// document.getElementById("status").innerHTML = "Invalid email address";
			document.getElementById("mc2_status").innerHTML = lang_error_invalid_email;
			return;
		}
		<?php endif; ?>


		// Disable the Add button and set the status to busy
		document.getElementById("mc2_add").disabled = true;
		document.getElementById("mc2_status").innerHTML = lang_message_adding;

		// Send the new email entry and our module id data as an Ajax request
		postvars = "ajax=true" + "&mid=<?php echo $module->id;?>" + "&email=" + document.getElementById("mc2_email").value;
		var mergeVarInputs = document.getElementById('mcmergevars');
		mvinputs = mergeVarInputs.getElementsByTagName('input'); //does not get selects.  

		maxj = mvinputs.length;
		for(j=0; j < maxj; j++){
			if(mvinputs[j].getAttribute("type") == "radio") { //don't automatically add all radio inputs
				
				if (mvinputs[j].checked && mvinputs[j].value) { 
					postvars = postvars + "&" + mvinputs[j].getAttribute('name') + 
						"=" + mvinputs[j].value;
				}
				
			} else if(mvinputs[j].value){ //input but not radiobutton
				postvars = postvars + "&" + mvinputs[j].getAttribute('name') + 
					"=" + mvinputs[j].value;
			}

		}
		
		
		mvselects = mergeVarInputs.getElementsByTagName('select');
		
		maxj = mvselects.length;
		for(j=0; j < maxj; j++){
			if(mvselects[j].value){
				postvars = postvars + "&" + mvselects[j].getAttribute('name') + 
					"=" + mvselects[j].value;
			}

		}

		
		//SEND

		<?php
		switch($ajaxtype) {

			case 'MC_AJAX_TYPE_DIRECT':
		?>
				//Add ajax parameter to send_to_mc call
				
				MCajaxReq.send("POST", "<?php echo JURI::base(); ?>modules/mod_mailchimp2/send_to_mc.php?ajax=1", handleRequest, "application/x-www-form-urlencoded; charset=UTF-8", postvars);
		<?php
			break;
			

			case 'MC_AJAX_TYPE_SELF':
			default:
		?>
				<?php
				$thisUrl = JURI::getInstance();
				$thisUrl->delVar('mode');
				$thisUrl->setVar('mode', 'send');
				?>
				
				//Add ajax parameter to send_to_mc call
				MCajaxReq.send("POST", "<?php echo JURI::base(); ?>modules/mod_mailchimp2/send_to_mc.php?ajax=1", handleRequest, "application/x-www-form-urlencoded; charset=UTF-8", postvars);	
				
			
		<?php
			break;
		}
		?>


	}	// end of addEmailAddress

	// Handle the Ajax request
	function handleRequest() {
		if (MCajaxReq.getReadyState() == 4 && MCajaxReq.getStatus() == 200) {
			// Confirm the addition of the email entry
			document.getElementById("mc2_status").innerHTML = MCajaxReq.getResponseText();
			document.getElementById("mc2_add").disabled = false;
			document.getElementById("mc2_email").value = "";
			
			var mvinputs = document.getElementById('mcmergevars');	// clear mergevars
			if(mvinputs.getElementsByTagName('input').length){
				var inputs = mvinputs.getElementsByTagName('input');
				if(inputs){
					for (var i=0; i < inputs.length; i++) {	
						inputs[i].value = '';		
					}
				}
			}
			/* clear checkboxes and radios */
			var iginputs = document.getElementById('mciginputs');
			ig_values = "";
			if(iginputs){
				if(iginputs.getElementsByTagName('input').length){
					var inputs = iginputs.getElementsByTagName('input'); 	// radio or checkbox
				} else {
					var inputs = iginputs.getElementsByTagName('option'); 	// select list
				}
				if(inputs){
					for (var i=0; i < inputs.length; i++) {
	 					// checked for radio or checkbox, selected for select list
						if (inputs[i].checked || inputs[i].selected) { 
							inputs[i].checked = false;
		      				}
					}
				}
			}
		}
	}
	//]]>
	</script>
<?php

 
	require_once('MailChimp.php');  //location?

	try {
		$api = new DrewM\MailChimp\MailChimp($params->get('mc_api_key'));
	} catch (Exception $e) {
		$msg = $e->getMessage();
		echo ( JText::_('MOD_MAILCHIMP2_ERROR_NO_LIST') );
		if ($params->get('show_errors')) {
			
			echo "<div>" . $msg . "</div>";
		}
		return null;
	}
	
	$api->verify_ssl = $params->get('mc_verify_ssl', true);


	$list_id = ($params->get('mc_unique_id'));
	
	if (empty($list_id)){
		echo ( JText::_('MOD_MAILCHIMP2_ERROR_NO_ID') );
		return null;
	}
	
	$list_return = $api->get("lists/$list_id");
	
	if(!$api->success()){
		echo ( JText::_('MOD_MAILCHIMP2_ERROR_NO_LIST') );
		
		if ($params->get('show_errors')) {
			echo "<div>" . $list_return['detail'] . "</div>";
		}

		return null;
	}
	
	if($params->get('showlist')){
		echo $list_return['name'];
		echo '<br />';
	}
	

	$textsize = DEFAULT_FIELD_SIZE;
	if(is_numeric($params->get('textsize'))){
		$textsize = $params->get('textsize');
	}
	if($textsize < MIN_FIELD_SIZE){
		$textsize = MIN_FIELD_SIZE;
	}
		
?>

	<div id="mc2_status"></div>
		
	
	<div class="sj-email">
	<form name="mailchimp2" action="">
	<span class="<?php echo $css_class_label;?>"><?php echo JText::_('MOD_MAILCHIMP2_LABEL_EMAIL_ADDRESS'); ?></span><br />
	<input type="text" id="mc2_email" class="input-box" placeholder="<?php echo $params->get('mc_placeholder'); ?>" name="email" value="" size="<?php echo $textsize;?>"/>
	<?php if($params->get('askname')){ 
		$showname = "inline";
	} else {
		$showname = "none";
	} ?>
	<div id="mcmergevars" style="display: <?php echo $showname;?>">
	<?php   
	
		
		$mergevars = $api->get("lists/$list_id/merge-fields");


		// show extra signup fields
		// returns name req tag


		foreach($mergevars['merge_fields'] as $mergevar){
		if ( $mergevar['tag'] == 'FNAME'  || $mergevar['tag'] == "LNAME") {

				/** Special cases for Mailchimp-provided fields.
				Use translations for first and last name.
				*/
				
				$mergeVarLabel = $mergevar['name'];
				
				
				// TODO: make this a user-editable list in the module options.
				// For now, we hardcode the 'default' MailChimp fields,
				// First Name and Last Name
				
				$translatedFieldNameList = array( "First Name" => 'MOD_MAILCHIMP2_LABEL_FIRST_NAME', 
												 "Last Name" => 'MOD_MAILCHIMP2_LABEL_LAST_NAME' );
				foreach ( $translatedFieldNameList as $translatedFieldName => $fieldTranslation ) {
					if ( $mergevar['name'] == $translatedFieldName ) {
						$mergeVarLabel = JText::_($fieldTranslation);
					}
				}
			
			
				// prompt
				$css_class_required="notreq";
				if($mergevar['required']){
					$css_class_required="req";
				}
				
					echo '<span class="' . $css_class_label . ' ' . $css_class_required . '">' . $mergeVarLabel . ": </span><br />\n"; //was $mergevar['name']
					echo '<input class="mergevars" type="text" name="' . $mergevar['tag'] . '" ';
					echo 'size="' . $textsize . '"';
					echo "/><br />\n";
				}
			}


	?>

	</div>


	<?php
	/*
	Default form submit action is empty.  Instead, trigger the addEmailAddress action which sends to the MC API.
	*/
	?>
	<input type="submit" class="btn btn-primary hasTooltip  finder" id="mc2_add" value="<?php echo JText::_('MOD_MAILCHIMP2_LABEL_SUBMIT_BUTTON'); ?>" onclick="addEmailAddress(); return false;" /></form>
	</div>
</div>

<?php
// Micah Wittman, wittman.org
function modMC2_escapeJavaScriptText($string) { 
	return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\"))); 
} 


function var_dump_pre($txt) {
	echo "<pre>\n";
	var_dump($txt);
	echo "</pre>";
	
}


//EOF