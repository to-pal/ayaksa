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
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div id="cpanel_wrapper" style="direction:ltr">
	<div class="cpanel-head">Template Settings</div>
    <div class="cpanel-theme-color">
    	<span class="theme-color-heading">Select color sample for all parameters</span>
        <div class="inner clearfix">
		<span title="Green" class="theme-color green<?php echo ($yt->getParam('sitestyle')=='green')?' active':'';?>">Green</span>
		<span title="Dark Green" class="theme-color dark_green<?php echo ($yt->getParam('sitestyle')=='dark_green')?' active':'';?>">Dark_Green</span>
		<span title="Oranges" class="theme-color oranges<?php echo ($yt->getParam('sitestyle')=='oranges')?' active':'';?>">Oranges</span>
		<span title="Yellow" class="theme-color yellow<?php echo ($yt->getParam('sitestyle')=='yellow')?' active':'';?>">Yellow</span>
			
        </div>
    </div>
    <div class="accordion" id="ytcpanel_accordion">
    	<!--Body-->
        <div class="accordion-group cpnel-body">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#ytcpanel_accordion" href="#ytitem_1">
                Body
                </a>
            </div>
            <div id="ytitem_1" class="accordion-body collapse in">
                <div class="accordion-inner clearfix">
                    <!-- Body backgroud color -->
                    <div class="cp-item body-backgroud-color">
                        <span>Background Color</span>
                        <div class="inner">
                        	<input type="text" value="<?php echo $yt->getParam('bgcolor');?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_bgcolor" maxlength="7">
                        </div>
                    </div>
                    <!-- Link color-->
                    <div class="cp-item link-color">
                        <span>Link Color</span>
                        <div class="inner">
                        	<input type="text" value="<?php echo $yt->getParam('linkcolor');?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_linkcolor" maxlength="7">
                        </div>
                    </div>
                    <!-- Text color-->
                    <div class="cp-item text-color">
                        <span>Text Color</span>
                        <div class="inner">
                        	<input type="text" value="<?php echo $yt->getParam('textcolor'); ?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_textcolor" maxlength="7">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Layouts -->
        <div class="accordion-group cpanel-layout">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#ytcpanel_accordion" href="#ytitem_6">
                Layouts
                </a>
            </div>
            <div id="ytitem_6" class="accordion-body collapse">
                <div class="accordion-inner clearfix">
                	<!-- Backgroud color -->
                    <div class="cp-item footer-backgroud-color">
                        <span>Select layouts</span>
                        <div class="inner">
                        	<select onchange="javascript: onCPApply();" name="ytcpanel_default_main_layout" class="cp_select">
                            	<option value="main-left-right.xml"<?php echo ($yt->getParam('default_main_layout')=='main-left-right.xml')?' selected="selected"':'';?>>main-left-right.xml</option>
                                <option value="left-right-main.xml"<?php echo ($yt->getParam('default_main_layout')=='left-right-main.xml')?' selected="selected"':'';?>>left-right-main.xml</option>
                                <option value="left-main-right.xml"<?php echo ($yt->getParam('default_main_layout')=='left-main-right.xml')?' selected="selected"':'';?>>left-main-right.xml</option>
                                <option value="main-right.xml"<?php echo ($yt->getParam('default_main_layout')=='main-right.xml')?' selected="selected"':'';?>>main-right.xml</option>
                                <option value="left-main.xml"<?php echo ($yt->getParam('default_main_layout')=='left-main.xml')?' selected="selected"':'';?>>left-main.xml</option>
                                <option value="main.xml"<?php echo ($yt->getParam('default_main_layout')=='main.xml')?' selected="selected"':'';?>>main.xml</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		<!-- Features -->
        <div class="accordion-group cpanel-features">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#ytcpanel_accordion" href="#ytitem_2">
                Menu Style
                </a>
            </div>
            <div id="ytitem_2" class="accordion-body collapse">
                <div class="accordion-inner clearfix">
                   
                    
                    <!-- Mainmenu -->
                    <div class="cp-item body-fontfamily">
                        <span>Select menu </span>
                        <div class="inner">
                            <select onchange="javascript: onCPApply();" name="ytcpanel_menustyle" class="cp_select">
                                <option value="mega"<?php echo ($yt->getParam('menustyle')=='mega')?' selected="selected"':'';?>>Mega Menu</option>
                                <option value="basic"<?php echo ($yt->getParam('menustyle')=='basic')?' selected="selected"':'';?>>CSS Menu</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
        <!-- Typography -->
        <div class="accordion-group cpanel-typography">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#ytcpanel_accordion" href="#ytitem_4">
                Typography
                </a>
            </div>
            <div id="ytitem_4" class="accordion-typo collapse">
                <div class="accordion-inner clearfix">
                	<!-- Google font -->
                    <div class="cp-item">
                        <span>Google Font</span>
                        <div class="inner">
                        	<?php 
							$googleFont = array(
										'None'=>'none',
										'Anton'=>'Anton',
										'Open Sans'=>'Open Sans',
										'BenchNine'=>'BenchNine',
										'Droid Sans'=>'Droid Sans',
										'Droid Serif'=>'Droid Serif',
										'PT Sans'=>'PT Sans',
										'Vollkorn'=>'Vollkorn',
										'Ubuntu'=>'Ubuntu',
										'Neucha'=>'Neucha',
										'Cuprum'=>'Cuprum'
							);
							?>
                            <select onchange="javascript: onCPApply();" name="ytcpanel_googleWebFont" class="cp_select">
							<?php foreach($googleFont as $k=>$v):?>
                                <option value="<?php echo $v; ?>"<?php echo ($yt->getParam('googleWebFont')==$v)?' selected="selected"':'';?>><?php echo $k; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Body font-size -->
                    <div class="cp-item">
                        <span>Body Font-size</span>
                        <div class="inner">
                            <?php 
							$fontfamily = array(
										 '10px'=>'10px',
										 '11px'=>'11px',
										 'Default'=>'12px',
										 '13px'=>'13px',
										 '14px'=>'14px',
										 '15px'=>'15px',
										 '16px'=>'16px',
										 '17px'=>'17px',
										 '18px'=>'18px'
							);
							?>
                            <select onchange="javascript: onCPApply();" name="ytcpanel_fontsize" class="cp_select">
							<?php foreach($fontfamily as $k=>$v):?>
                                <option value="<?php echo $v; ?>"<?php echo ($yt->getParam('fontsize')==$v)?' selected="selected"':'';?>><?php echo $k; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Body font-family -->
                    <div class="cp-item body-fontfamily">
                        <span>Body Font-family</span>
                        <div class="inner">
                        <?php 
						$fontfamily = array(
									 'Arial'=>'arial',
									 'Arial Black'=>'arial-black',
									 'Courier New'=>'courier',
									 'Georgia'=>'georgia',
									 'Impact'=>'impact',
									 'Lucida Console'=>'lucida-console',
									 'Lucida Grande'=>'lucida-grande',
									 'Palatino'=>'palatino',
									 'Tahoma'=>'tahoma',
									 'Times New Roman'=>'times',
									 'Trebuchet'=>'trebuchet',
									 'Verdana'=>'verdana'
						);
						?>
                            <select onchange="javascript: onCPApply();" name="ytcpanel_font_name" class="cp_select">
							<?php foreach($fontfamily as $k=>$v):?>
                                <option value="<?php echo $v; ?>"<?php echo ($yt->getParam('font_name')==$v)?' selected="selected"':'';?>><?php echo $k; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Direction -->
                    <div class="cp-item body-fontfamily">
                        <span>Direction</span>
                        <div class="inner">
                            <select onchange="javascript: onCPApply();" name="ytcpanel_direction" class="cp_select">
                                <option value="ltr"<?php echo ($yt->getParam('direction')=='ltr')?' selected="selected"':'';?>>LTR Language</option>
                                <option value="rtl"<?php echo ($yt->getParam('direction')=='rtl')?' selected="selected"':'';?>>RTL Language</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header-->
        <div class="accordion-group cpanel-header">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#ytcpanel_accordion" href="#ytitem_5">
                Header & Slideshow
                </a>
            </div>
            <div id="ytitem_5" class="accordion-body collapse">
                <div class="accordion-inner clearfix">
                    <!-- Backgroud color -->
                    <div class="cp-item header-backgroud-color">
                        <span>Background Color</span>
                        <div class="inner">
                            <input type="text" value="<?php echo $yt->getParam('header-bgcolor');?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_header-bgcolor" maxlength="7">
                        </div>
                    </div>
                    <!-- Backgroud image-->
                    <div class="cp-item header-backgroud-image">
                        <span>Background Image</span>
                        <div class="inner">
                            <input type="hidden" name="ytcpanel_header-bgimage" value="<?php echo $yt->getParam('header-bgimage'); ?>"/>
                            <a href="#yt_header" title="pattern_1" class="pattern pattern_1<?php echo ($yt->getParam('header-bgimage')=='pattern_1')?' active':''?>">pattern_1</a>
                            <a href="#yt_header" title="pattern_2" class="pattern pattern_2<?php echo ($yt->getParam('header-bgimage')=='pattern_2')?' active':''?>">pattern_2</a>
                            <a href="#yt_header" title="pattern_3" class="pattern pattern_3<?php echo ($yt->getParam('header-bgimage')=='pattern_3')?' active':''?>">pattern_3</a>
                            <a href="#yt_header" title="pattern_4" class="pattern pattern_4<?php echo ($yt->getParam('header-bgimage')=='pattern_4')?' active':''?>">pattern_4</a>
                            <a href="#yt_header" title="pattern_5" class="pattern pattern_5<?php echo ($yt->getParam('header-bgimage')=='pattern_5')?' active':''?>">pattern_5</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- Footer-->
        <div class="accordion-group cpanel-footer">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#ytcpanel_accordion" href="#ytitem_3">
                Footer & Spotlight5
                </a>
            </div>
            <div id="ytitem_3" class="accordion-body collapse">
                <div class="accordion-inner clearfix">
                	<!-- Backgroud color -->
                    <div class="cp-item spotlight5-backgroud-color">
                        <span>Background Color Spotlight5</span>
                        <div class="inner">
                        	 <input type="text" value="<?php echo $yt->getParam('spotlight5-bgcolor');?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_spotlight5-bgcolor" maxlength="7">
                        </div>
                    </div>
		    
		    <div class="cp-item footer-backgroud-color">
                        <span>Background Color Footer</span>
                        <div class="inner">
                        	 <input type="text" value="<?php echo $yt->getParam('footer-bgcolor');?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_footer-bgcolor" maxlength="7">
                        </div>
                    </div>
		    
                    <!-- Backgroud image-->
                    
		    <!--<div class="cp-item footer-backgroud-image">
                        <span>Background Image</span>
                        <div class="inner">
                        	<input type="hidden" value="<?php echo $yt->getParam('footer-bgimage');?>" name="ytcpanel_footer-bgimage" />
                            <a href="#yt_spotlight2" title="pattern_1" class="pattern pattern_1<?php echo ($yt->getParam('footer-bgimage')=='pattern_1')?' active':''?>">pattern_1</a>
                            <a href="#yt_spotlight2" title="pattern_2" class="pattern pattern_2<?php echo ($yt->getParam('footer-bgimage')=='pattern_2')?' active':''?>">pattern_2</a>
                            <a href="#yt_spotlight2" title="pattern_3" class="pattern pattern_3<?php echo ($yt->getParam('footer-bgimage')=='pattern_3')?' active':''?>">pattern_3</a>
                            <a href="#yt_spotlight2" title="pattern_4" class="pattern pattern_4<?php echo ($yt->getParam('footer-bgimage')=='pattern_4')?' active':''?>">pattern_4</a>
                            <a href="#yt_spotlight2" title="pattern_5" class="pattern pattern_5<?php echo ($yt->getParam('footer-bgimage')=='pattern_5')?' active':''?>">pattern_5</a>
                        </div>
                    </div>
		    -->
                </div>
            </div>
        </div>
	
	
    </div>
    <!-- Action button -->
    <div class="action">
    	<a class="btn btn-info reset" href="#" onclick="javascript: onCPResetDefault();" >Reset</a>
    </div>
    <div id="cpanel_btn" class="normal">
        <i class="icon-hand-left"></i>
    </div>
</div>