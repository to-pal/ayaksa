<?php
/**
 * @package Sj Gallery
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;

JHtml::stylesheet('templates/' . JFactory::getApplication()->getTemplate().'/html/mod_sj_gallery/gallery.css');
JHtml::stylesheet('templates/' . JFactory::getApplication()->getTemplate().'/html/mod_sj_gallery/jquery.fancybox-1.3.4.css');
if( !defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1" ){
	JHtml::script('modules/mod_sj_gallery/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/mod_sj_gallery/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}
JHtml::script('modules/mod_sj_gallery/assets/js/jsmart.easing.1.3.js');
JHtml::script('modules/mod_sj_gallery/assets/js/jquery.fancybox-1.3.4.pack.js');
JHtml::script('modules/mod_sj_gallery/assets/js/jquery.cycle.all.2.72.js');

ImageHelper::setDefault($params);
//var_dump($items);die("abcbc");
if (count($items)>0){
	$titleposition			= $params->get("titleposition", 'over');
	$transition				= $params->get("transition", 'none');
	$thumb_height 					= $params->get('imgcfg_height', "300");
	$thumb_width 					= $params->get('imgcfg_width',  "200");
	$colofgallery					= $params->get('colofgallery', '3');
	$rowofgallery					= $params->get('rowofgallery', '3');
	$show_nextprev					= $params->get('show_nextprev', 1);
	$auto_play						= $params->get('auto_play', 1);
	$effect							= $params->get('effect', 1);
	$slideshow_speed				= $params->get('slideshow_speed', 1);
	$timer_speed					= $params->get('timer_speed', 1);
	
	if($colofgallery > 1){
		$width_mod = $colofgallery * $thumb_width + $colofgallery*(16+1);
	}else{
		$width_mod = $colofgallery * $thumb_width + $colofgallery*16;
	}

	$total_image_pag = $colofgallery  * $rowofgallery;
	$pags = ceil(count($items) / $total_image_pag);
	?>

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function($) {
	$('#sj_gallery_<?php echo $module->id;?> .sj-content div.sj-items').cyclegallery({
        fx:     '<?php echo $effect;?>',
        speed:   <?php echo $slideshow_speed;?>,
        timeout: <?php echo $auto_play ? $timer_speed : 0;?>,
        pager:  '#sj_nav_<?php echo $module->id;?>',
		prev:   '#sj_prev_<?php echo $module->id;?>',
    	next:   '#sj_next_<?php echo $module->id;?>',
        before: function() { if (window.console) console.log(this.src); }
    });
	//Update elements
	var col<?php echo $module->id;?> = <?php echo $colofgallery?>;
	var yt_item_width<?php echo $module->id;?> = $('#yt-gallery-<?php echo $module->id;?> .yt-content').width();
	var i_width<?php echo $module->id;?> = parseInt(yt_item_width<?php echo $module->id;?> / col<?php echo $module->id;?>);
	$('#yt-gallery-<?php echo $module->id;?> .yt-item ul').css('width', yt_item_width<?php echo $module->id;?>);
	$('#yt-gallery-<?php echo $module->id;?> .yt-items').css('width', yt_item_width<?php echo $module->id;?>);
	
	
	$("a[rel=sj_gallery_image_<?php echo $module->id;?>]").fancybox({
		'transitionIn'	: '<?php echo $transition; ?>',
		'transitionOut'	: '<?php echo $transition; ?>',
		'titlePosition' : '<?php echo $titleposition; ?>',
		'titleFormat'	: function(title, currentArray, currentIndex, currentOpts) {
			return  (title.length ?  title : '') + ' (' + (currentIndex + 1) + ' / ' + currentArray.length + ')' ;
		},
		easingIn: 'easeInOutQuad',
		easingOut: 'easeInOutQuad'
	});
});
//]]>
</script>
<div class="sj-gallery">
	<div id="sj_gallery_<?php echo $module->id;?>">
		<div class="sj-content" style="width:100%;">
			
			<div class="sj-items">
				<?php
				for($i=0; $i<$pags; $i++){ ?>
				<div class="sj-item">
					<ul>
					<?php
					$j = 0;
					$start = $i * $total_image_pag;
					$end   = ($i + 1) * $total_image_pag;
					foreach ($items as $key => $item):
						if ($key >= $start && $key < $end) {
							if ($key != 0 && ($key % $colofgallery == 0)) {
								$j = 0;
							}
							$item_class = 'img-col col' . $j;
							if ($j== 0) {
								$item_class = 'img-col col' . $j . '  first';
							} else if ($j + 1 == $colofgallery) {
								$item_class = 'img-col col' . $j . '  last';
							}
							$j++;
							?>
						<li  class="<?php echo $item_class?>">
							<a  rel="sj_gallery_image_<?php echo $module->id;?>" href="<?php echo $item['url']; ?>" title="<?php echo $item['title'] ;?>">
							 <?php echo SjGalleryReader::imageTag($item['image']);?>
							</a>
						</li>
					<?php
						}
					endforeach; ?>
					</ul>
				</div>
			<?php
				}
				?>
			</div>
			
			<div class="sj-navigation clearfix" style="width:100%">
				<?php if(sizeof($items) > $colofgallery*$rowofgallery){?>
				<div class="sj-buttons">
					<ul>
						<?php if($show_nextprev==1){ ?>
						<li class="sj-prev" id="sj_prev_<?php echo $module->id;?>"><span>Previous</span>
						</li>
						<?php } ?>
						<li class="sj-nav" id="sj_nav_<?php echo $module->id;?>"></li>
						<?php if($show_nextprev==1){ ?>
						<li class="sj-next" id="sj_next_<?php echo $module->id;?>"><span>Next</span>
						</li>
						<?php } ?>
					</ul>
				</div>
				<?php } ?>
			</div>
			
		</div>
	</div>
</div>
<?php
} else{
	echo JText::_('There are no image inside folder: ') . $params->get('folder');
}