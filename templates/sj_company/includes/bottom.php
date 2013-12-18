<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Add css config to <head>...</head>
$doc->addStyleDeclaration('
body{
	background-color:'.$yt->getParam('bgcolor').' ;
	color:'.$yt->getParam('textcolor').' ;
}

body a{
	color:'.$yt->getParam('linkcolor').' ;
}
#yt_header{background-color:'.$yt->getParam('header-bgcolor').' ;}

#yt_footer{background-color:'.$yt->getParam('footer-bgcolor').' ;}
#yt_spotlight5{background-color:'.$yt->getParam('spotlight5-bgcolor').' ;}

');
// Add class pattern to element wrap
?>
<script type="text/javascript">
	jQuery(document).ready(function($){  
		/* Begin: add class pattern for element */
		var headerbgimage = '<?php echo $yt->getParam('header-bgimage');?>';
		var footerbgimage = '<?php echo $yt->getParam('footer-bgimage');?>';
		if(headerbgimage){
			$('#yt_header').addClass(headerbgimage);
			$('#yt_slideshow').addClass(headerbgimage);
		}
		/*
		if(footerbgimage){
			$('#yt_footer').addClass(footerbgimage);
			$('#yt_spotlight2').addClass(footerbgimage);
		}
		*/
		/* End: add class pattern for element */
	});
</script>
<?php
// Include cpanel
if( $yt->getParam('showCpanel') ) {
	include_once (J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'cpanel.php');
	
	$doc->addStyleSheet($yt->templateurl().'css/cpanel.css','text/css');
	$doc->addStyleSheet($yt->templateurl().'asset/minicolors/jquery.miniColors.css','text/css');
	$doc->addScript($yt->templateurl().'js/ytcpanel.js');
	$doc->addScript($yt->templateurl().'asset/minicolors/jquery.miniColors.min.js');
?>
	<script type="text/javascript">
    jQuery(document).ready(function($){
        /* Begin: Enabling miniColors */
        //$('.color-picker').miniColors();
		$('.body-backgroud-color .color-picker').miniColors({
			change: function(hex, rgb) {
				$('body').css('background-color', hex); 
				createCookie(TMPL_NAME+'_'+($(this).attr('name').match(/^ytcpanel_(.*)$/))[1], hex, 365);
			}
		});
		$('.link-color .color-picker').miniColors({
			change: function(hex, rgb) {
				$('body a').css('color', hex);
				createCookie(TMPL_NAME+'_'+($(this).attr('name').match(/^ytcpanel_(.*)$/))[1], hex, 365);
			}
		});
		$('.text-color .color-picker').miniColors({
			change: function(hex, rgb) {
				$('body').css('color', hex);
				createCookie(TMPL_NAME+'_'+($(this).attr('name').match(/^ytcpanel_(.*)$/))[1], hex, 365);
			}
		});
		$('.header-backgroud-color .color-picker').miniColors({
			change: function(hex, rgb) {
				$('#yt_header').css('background-color', hex);
				$('#yt_slideshow').css('background-color', hex);
				createCookie(TMPL_NAME+'_'+($(this).attr('name').match(/^ytcpanel_(.*)$/))[1], hex, 365);
			}
		});
		
		$('.footer-backgroud-color .color-picker').miniColors({
			change: function(hex, rgb) {
				
				$('#yt_footer').css('background-color', hex);
				createCookie(TMPL_NAME+'_'+($(this).attr('name').match(/^ytcpanel_(.*)$/))[1], hex, 365);
			}
		});
		$('.spotlight5-backgroud-color .color-picker').miniColors({
			change: function(hex, rgb) {
				$('#yt_spotlight5').css('background-color', hex);
				createCookie(TMPL_NAME+'_'+($(this).attr('name').match(/^ytcpanel_(.*)$/))[1], hex, 365);
			}
		});
		
		/* End: Enabling miniColors */
		/* Begin: Set click pattern */
		function patternClick(el, paramCookie, assign){
			$(el).click(function(){
				oldvalue = $(this).parent().find('.active').html();
				$(el).removeClass('active');
				$(this).addClass('active');
				value = $(this).html();
				if(assign.length > 0){
					for($i=0; $i < assign.length; $i++){
						$(assign[$i]).removeClass(oldvalue);
						$(assign[$i]).addClass(value);
					}
				}
				if(paramCookie){
					$('input[name$="ytcpanel_'+paramCookie+'"]').attr('value', value);
					createCookie(TMPL_NAME+'_'+paramCookie, value, 365);
					
				}
			});
	
		}
        patternClick('.header-backgroud-image .pattern', 'header-bgimage', Array('#yt_header', '#yt_slideshow'));
        //patternClick('.footer-backgroud-image .pattern', 'footer-bgimage', Array('#yt_spotlight2', '#yt_footer'));
        /* End: Set click pattern */
		function templateSetting(array){
			if(array['0']){
				$('.body-backgroud-color input.miniColors').attr('value', array['0']);
				$('.body-backgroud-color a.miniColors-trigger').css('background-color', array['0']);
				$('input.ytcpanel_bgcolor').attr('value', array['0']);
			}
			if(array['1']){
				$('.link-color input.miniColors').attr('value', array['1']);
				$('.link-color a.miniColors-trigger').css('background-color', array['1']);
				$('input.ytcpanel_linkcolor').attr('value', array['1']);
			}
			if(array['2']){
				$('.text-color input.miniColors').attr('value', array['2']);
				$('.text-color a.miniColors-trigger').css('background-color', array['2']);
				$('input.ytcpanel_textcolor').attr('value', array['2']);
			}
			if(array['3']){
				$('.header-backgroud-color input.miniColors').attr('value', array['3']);
				$('.header-backgroud-color a.miniColors-trigger').css('background-color', array['3']);
				$('input.ytcpanel_header-bgcolor').attr('value', array['3']);
			}
			if(array['4']){
				$('.header-backgroud-image .pattern').removeClass('active');
				$('.header-backgroud-image .pattern.'+array['4']).addClass('active');
				$('input[name$="ytcpanel_header-bgimage"]').attr('value', array['4']);
			}
			if(array['5']){
				$('.spotlight5-backgroud-color input.miniColors').attr('value', array['5']);
				$('.spotlight5-backgroud-color a.miniColors-trigger').css('background-color', array['5']);
				$('input.ytcpanel_spotlight5-bgcolor').attr('value', array['5']);
			}
			if(array['6']){
				$('.footer-backgroud-color input.miniColors').attr('value', array['6']);
				$('.footer-backgroud-color a.miniColors-trigger').css('background-color', array['6']);
				$('input.ytcpanel_footer-bgcolor').attr('value', array['6']);
			}
			/*if(array['6']){
				$('.footer-backgroud-image .pattern').removeClass('active');
				$('.footer-backgroud-image .pattern.'+array['6']).addClass('active');
				$('input[name$="ytcpanel_footer-bgimage"]').attr('value', array['6']);
			}*/
		}
		var array 		= Array('bgcolor','linkcolor','textcolor','header-bgcolor','header-bgimage','footer-bgcolor','spotlight5-bgcolor');

		var array_green         = Array('#ffffff','#28ab00','#666666','#fff','pattern_3','#3e3e3e','#1a1a1a');
		var array_dark_green 	= Array('#ffffff','#850000','#333333','#fff','pattern_3','#3e3e3e','#1a1a1a');
		var array_oranges       = Array('#ffffff','#FF7E00','#666666','#fff','pattern_3','#3e3e3e','#1a1a1a');
		var array_yellow 	= Array('#ffffff','#edc800','#666666','#fff','pattern_3','#3e3e3e','#1a1a1a');

		
		$('.theme-color.green').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'sitestyle', $(this).html().toLowerCase(), 365);
			templateSetting(array_green);
			onCPApply();
		});
		$('.theme-color.dark_green').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'sitestyle', $(this).html().toLowerCase(), 365);
			templateSetting(array_dark_green);
			onCPApply();
		});
		$('.theme-color.oranges').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'sitestyle', $(this).html().toLowerCase(), 365);
			templateSetting(array_oranges);
			onCPApply();
		});
		$('.theme-color.yellow').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'sitestyle', $(this).html().toLowerCase(), 365);
			templateSetting(array_yellow);
			onCPApply();
		});
		
    });
    </script>
<?php
}
// Show back to top
if( $yt->getParam('showBacktotop') ) {
    include_once (J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'backtotop.php');
}
?>