<?php
// Body Font family
$doc->addStyleDeclaration('body.'.$yt->template.'{font-size:'.$fontsize.'}');

// Google Font & Element use

if ($googleWebFont != "" && $googleWebFont != " " && strtolower($googleWebFont)!="none") {
	$doc->addStyleSheet('http://fonts.googleapis.com/css?family='.str_replace(" ","+",$googleWebFont).'&subset=latin,cyrillic');
	$googleWebFontFamily = strpos($googleWebFont, ':')?substr($googleWebFont, 0, strpos($googleWebFont, ':')):$googleWebFont;
	if(trim($googleWebFontTargets)!="")
		$doc->addStyleDeclaration('  '.$googleWebFontTargets.'{font-family:'.$googleWebFontFamily.', sans-serif !important}');
}
?>
	
	<link rel="stylesheet" href="<?php echo $yt->templateurl().'asset/bootstrap/css/bootstrap.min.css';?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo $yt->templateurl().'asset/bootstrap/css/bootstrap-responsive.min.css';?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo $yt->templateurl().'css/fonts.css';?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo $yt->templateurl().'css/animations.css';?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo $yt->templateurl().'css/template.css';?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo $yt->templateurl().'css/typography.css';?>" type="text/css" />
<?php    
if(isset($yt_render->arr_TH['stylesheet'])){
	foreach($yt_render->arr_TH['stylesheet'] as $tagStyle){
	?>
	<link rel="stylesheet" href="<?php echo $yt->templateurl().'css/'.$tagStyle;?>" type="text/css" />
    <?php 
	}
}
if ($yt->isIE()){ 
	if($yt->ieversion()==8){
		$doc->addStyleSheet($yt->templateurl().'css/template-ie8.css','text/css');
	}
	if($yt->ieversion()==9){
		$doc->addStyleSheet($yt->templateurl().'css/template-ie9.css','text/css');
	}
}
if($ytrtl == 'rtl'){
	?>
	<link rel="stylesheet" href="<?php echo $yt->templateurl().'css/typography_rtl.css';?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo $yt->templateurl().'css/template_rtl.css';?>" type="text/css" />
	
    <?php
}
?>
	<link rel="stylesheet" href="<?php echo $yt->templateurl().'css/yt-bootstrap-responsive.css';?>" type="text/css" />
	<script src="<?php echo $yt->templateurl().'js/prettify.js' ?>" type="text/javascript"></script>
    <!--<script src="<?php //echo $yt->templateurl().'asset/bootstrap/js/less-1.3.0.min.js'?>" type="text/javascript"></script>-->
<?php if(J_VERSION=='2'){?>
<script src="<?php echo $yt->templateurl().'asset/bootstrap/js/bootstrap.min.js' ?>" type="text/javascript"></script>
<?php } ?>
<?php
if ($yt->isIE()){ 
	if($yt->ieversion()<=8){
?>
	<!--Support html5-->
	<script src="<?php echo $yt->templateurl().'js/modernizr.min.js' ?>" type="text/javascript"></script>	
	<!--Support Media Query-->
	<!--<script src="<?php echo $yt->templateurl().'js/respond.min.js' ?>" type="text/javascript"></script>-->
<?php
	}
}
?>
	<script src="<?php echo $yt->templateurl().'js/yt-extend.js' ?>" type="text/javascript"></script>	
<?php
$doc->addCustomTag('
<script type="text/javascript">
	function MobileRedirectUrl(){
	  window.location.href = document.getElementById("yt-mobilemenu").value;
	}
	
</script>
');

if($yt->getParam('enableGoogleAnalytics')=='1' && $yt->getParam('googleAnalyticsTrackingID')!='' ){
?>  
	<!--For param enableGoogleAnalytics-->
	<script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(["_setAccount", "'.$yt->getParam('googleAnalyticsTrackingID').'"]);
        _gaq.push(["_trackPageview"]);
        (function() {
        var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
        ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
        var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>		
<?php
}
?>
	<script type="text/javascript">
        var TMPL_NAME = '<?php echo $yt->template; ?>';
    </script>	
    <!--[ if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"> </ script>
    <[endif] -->
