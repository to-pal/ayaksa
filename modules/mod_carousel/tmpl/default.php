<?php
/**
 * @package Sj Carousel
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 * 
 */
defined('_JEXEC') or die;

if(!empty($list)){?>
    <div id="yt_carousel" class="yt-carousel carousel slide"><!-- Carousel items -->
	    <div class="carousel-inner">
	    <?php $i=0; foreach($list as $item){$i++;?>
		    <div class="<?php if($i==1){echo "active";}?> item">
            	<img src="<?php echo modCarouselHelper::html_image($item->images, array('image_intro', 'image_fulltext'), false);?>" alt="<?php echo $item->title;?>" style="height:405px;" />
	    		<div class="carousel-caption">
		    		<h4><?php echo $item->title;?></h4>
		    		<p><?php echo $item->displayIntrotext;?></p>
	    		</div>
		    </div>
	    <?php }?>
	    </div><!-- Carousel nav -->
	    <a class="carousel-control left" href="#yt_carousel" data-slide="prev">&lsaquo;</a>
	    <a class="carousel-control right" href="#yt_carousel" data-slide="next">&rsaquo;</a>
    </div>
<?php }else{ echo JText::_('Has no content to show!');}?>
