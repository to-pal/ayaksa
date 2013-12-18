<?php
defined('_JEXEC') or die;

JHtml::stylesheet('modules/mod_kwicks/assets/css/style.css');
if( !defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1" ){
	JHtml::script('modules/mod_kwicks/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/mod_kwicks/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}
JHtml::script('modules/mod_kwicks/assets/js/kwicks.js');

$options = $params->toObject();
$count = 0;
$uniqued ='container_slider_'.rand().time();
if(!empty($list)){?>
	<?php if(!empty($options->pretext)) { ?>
		<div class="pre-text"><?php echo $options->pretext; ?></div>
	<?php } ?>
    
	<div id="<?php echo $uniqued; ?>" class="container-kwicks">
			
		<ul class="kwicks kwicks-horizontal <?php echo $options->deviceclass_sfx; ?>">
		<?php foreach($list as $item){ 
		  $count++;
          $img = KwicksHelper::getImage($item, $params);
        ?>
				    						
    		<li><span class="shadow"></span>
    			<div class="thumb">    							
    				<div class="bg" style="background-image:url(<?php echo $img['src']?>); height: 305px;"></div>	
    			</div>
    			<div class="desc color-<?php echo $count?>">
    					<h2>
                            <a href="<?php echo $item->link;?>" target = "<?php echo $options->item_link_target;?>">
								<?php echo $item->title;?>
							</a>
                        </h2>					
                        <div class="excerpt">
                        <?php if( $options->show_introtext == 1 ){?>
    						<p><?php echo $item->displayIntrotext?></p>
                            <?php }?>
    					</div>
                        <?php if( $options->item_readmore_display == 1 ){?>
    					<a href="<?php echo $item->link;?>" class="kwick-button"><?php echo $options->item_readmore_text; ?></a>
                        <?php } ?>
    			</div>

				</li>
			<?php } ?>
			</ul>
    </div>
	<?php if(!empty($options->posttext)) {  ?>
		<div class="post-text"><?php echo $options->posttext; ?></div>
	<?php } ?>
<?php }else {echo JText::_('Не выбран контент!');}?>

<script type="text/javascript">
//<![CDATA[
    jQuery(document).ready(function($){
        $('#<?php echo $uniqued;?> .kwicks').kwicks({
            spacing : <?php echo $options->spacing;?>,
			event : 'mouseover',
			size : <?php echo $options->width/$count-2?>, 
            maxSize  : <?php echo $options->max_size;?>,       
            duration: <?php echo $options->duration;?>,
            behavior: 'menu',
        });
           
    });
    
//          //kwicks image hover
//			jQuery(".kwicks.horizontal li").hover(function(){
//				jQuery(this).find(".colorImage").fadeIn();
//			},function(){
//				jQuery(this).find(".colorImage").fadeOut();
//			});
//			
			//kwicks excerpt hover
			jQuery(".kwicks-horizontal li").hover(function(){
				jQuery(this).find(".excerpt").stop().animate({right:"75px"},"slow");
			},function(){
				jQuery(this).find(".excerpt").stop().animate({right:"-280px"},"medium");
			});
			
			//kwicks button hover
			jQuery(".kwicks-horizontal li").hover(function(){
				jQuery(this).find(".kwick-button").stop().animate({bottom:"10px"},"slow");
			},function(){
				jQuery(this).find(".kwick-button").stop().animate({bottom:"-60px"},"medium");
			});
//]]>
</script>



