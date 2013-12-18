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

    <div id="myCarousel" class="carousel slide"><!-- Carousel items -->
	    <div class="carousel-inner">
		
	    <?php $i=0; foreach($list as $item){$i++;?>
		    <div class="<?php if($i==1){echo "active";}?> item  slide-<?php echo $i;?>">
		    	<img src="<?php echo modCarouselHelper::html_image($item->images, array('image_intro', 'image_fulltext'), false);?>" alt="<?php echo $item->title;?>" />
	    		<div class="carousel-caption">
				
				<h4><a  title="<?php echo $item->title?>"  href="<?php echo $item->link?>"><?php echo $item->title;?></a></h4>
		    		<div class="carousel-text">
					<?php echo $item->displayIntrotext;?>
					<a class="more" data-control="" title="<?php echo JText::_('COM_CONTENT_FEED_READMORE'); ?>"  href="<?php echo $item->link?>">
						<?php //echo JText::_('COM_CONTENT_FEED_READMORE'); ?>
					</a>
				</div>
				
	    		</div>
		    </div>
	    <?php }?>
	    </div><!-- Carousel nav -->
	    <a class="carousel-control left" href="#myCarousel" data-slide="prev"  data-control=""><span></span></a>
	    <a class="carousel-control right" href="#myCarousel" data-slide="next" data-control=""><span></span></a>
    </div>
		
<?php }else{ echo JText::_('Has no content to show!');}?>
