<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$cparams = JComponentHelper::getParams ('com_media');
?>
<div class="contact<?php echo $this->pageclass_sfx?>">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>
	
	<?php if ($this->params->get('show_contact_category') == 'show_no_link') : ?>
		<h3>
			<span class="contact-category"><?php echo $this->contact->category_title; ?></span>
		</h3>
        <div class="cat_descr"> <?php echo $this->contact->category_description; ?> </div>
	<?php endif; ?>
	<?php if ($this->params->get('show_contact_category') == 'show_with_link') : ?>
		<?php $contactLink = ContactHelperRoute::getCategoryRoute($this->contact->catid);?>
		<h3>
			<span class="contact-category"><a href="<?php echo $contactLink; ?>">
				<?php echo $this->escape($this->contact->category_title); ?></a>
			</span>
		</h3>
	<?php endif; ?>
    
    
    <div class="tabbable" id="allcontacts">
        <ul class="nav nav-tabs">
        <?php foreach ($this->contacts as $i => $item) :?>
            <li <?php if ($i == 0) echo 'class="active"';?>>
            	<a href="#tab<?php echo $i?>" data-toggle="tab"> <?php echo $item->name; ?></a></li>
         <?php endforeach; ?>  
        </ul> 
        <div class="tab-content"> 
    	<?php foreach ($this->contacts as $i => $item) :
            $tmp = $this->contact;    
            $this->contact = $item;?>
            <div id="tab<?php echo$i?>" class="tab-pane <?php if ($i == 0) echo 'active'; ?>">
                    		
            	<?php if ($this->contact->image && $this->params->get('show_image')) : ?>
            		<div class="contact-image">
            			<?php echo JHtml::_('image', $this->contact->image, JText::_('COM_CONTACT_IMAGE_DETAILS'), array('align' => 'middle')); ?>
            			
            		</div>
            	<?php endif; ?>
            
            	<?php if ($this->contact->con_position && $this->params->get('show_position')) : ?>
            		<p class="contact-position"><?php echo $this->contact->con_position; ?></p>
            	<?php endif; ?>
            
            	<?php echo $this->loadTemplate('address'); ?>
            
            	<?php if ($this->params->get('allow_vcard')) :	?>
            		<?php echo JText::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS');?>
            			<a href="<?php echo JRoute::_('index.php?option=com_contact&amp;view=contact&amp;id='.$this->contact->id . '&amp;format=vcf'); ?>">
            			<?php echo JText::_('COM_CONTACT_VCARD');?></a>
            	<?php endif; ?>
                
                <?php if ($this->contact->params->get('map_link') && $this->contact->params->get('show_map')) : ?>
                    <div class="map">
                        <iframe width="<?php echo $this->contact->params->get('map_width'); ?>" height="<?php echo $this->contact->params->get('map_height'); ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $this->contact->params->get('map_link'); ?>"></iframe>
                	</div>
                <?php endif; ?>
                <?php if ($this->contact->misc) :	?>
                
            		<div class="contact-miscinfo">
            			<i class="icon-info-sign"></i>
            			<span class="contact-misc">
            				<?php echo $this->contact->misc; ?>
            			</span>
            		</div>
                <?php endif; ?>
            </div>
        <?php endforeach; $this->contact = $tmp; unset($tmp);  ?>
        </div>  
    </div>
	
	<div class="panel-form">
	<?php if ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) : ?>

		<?php if ($this->params->get('presentation_style')!='plain'):?>
			<?php  echo JHtml::_($this->params->get('presentation_style').'.panel', JText::_('COM_CONTACT_EMAIL_FORM'), 'display-form');  ?>
		<?php endif; ?>
		<?php if ($this->params->get('presentation_style')=='plain'):?>
			<?php  echo '<h4>'. JText::_('COM_CONTACT_EMAIL_FORM').'</h4>';  ?>
		<?php endif; ?>
		<?php  echo $this->loadTemplate('form');  ?>
	<?php endif; ?>
	<?php if ($this->params->get('show_links')) : ?>
		<?php echo $this->loadTemplate('links'); ?>
	<?php endif; ?>
	</div>
	
    
    
    
	<?php if ($this->params->get('show_articles') && $this->contact->user_id && $this->contact->articles) : ?>
		<?php if ($this->params->get('presentation_style')!='plain'):?>
			<?php echo JHtml::_($this->params->get('presentation_style').'.panel', JText::_('JGLOBAL_ARTICLES'), 'display-articles'); ?>
			<?php endif; ?>
			<?php if  ($this->params->get('presentation_style')=='plain'):?>
			<?php echo '<h3>'. JText::_('JGLOBAL_ARTICLES').'</h3>'; ?>
			<?php endif; ?>
			<?php echo $this->loadTemplate('articles'); ?>
	<?php endif; ?>
	
	
	<?php if ($this->params->get('show_profile') && $this->contact->user_id && JPluginHelper::isEnabled('user', 'profile')) : ?>
		<?php if ($this->params->get('presentation_style')!='plain'):?>
			<?php echo JHtml::_($this->params->get('presentation_style').'.panel', JText::_('COM_CONTACT_PROFILE'), 'display-profile'); ?>
		<?php endif; ?>
		<?php if ($this->params->get('presentation_style')=='plain'):?>
			<?php echo '<h3>'. JText::_('COM_CONTACT_PROFILE').'</h3>'; ?>
		<?php endif; ?>
		<?php echo $this->loadTemplate('profile'); ?>
	<?php endif; ?>
	<?php if ($this->contact->misc && $this->params->get('show_misc')) : ?>
		<?php if ($this->params->get('presentation_style')!='plain'){?>
			<?php echo JHtml::_($this->params->get('presentation_style').'.panel', JText::_('COM_CONTACT_OTHER_INFORMATION'), 'display-misc');} ?>
		
				
	<?php endif; ?>
	<?php if ($this->params->get('presentation_style')!='plain'){?>
			<?php echo JHtml::_($this->params->get('presentation_style').'.end');} ?>
</div>
