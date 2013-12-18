<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form1" c class="form-inline">
	<?php if ($params->get('pretext')): ?>
		<div class="pretext">
		<p><?php echo $params->get('pretext'); ?></p>
		</div>
	<?php endif; ?>
	<div class="userdata">
		<div id="form-login-username" class="control-group">
			<div class="controls">
				<div class="input-prepend input-append">
					
                    <input id="modlgn-username" type="text" name="username" class="input-small" tabindex="1" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
				</div>
			</div>
		</div>
		<div id="form-login-password" class="control-group">
			<div class="controls">
				<div class="input-prepend input-append">
					
                    <input id="modlgn-passwd" type="password" name="password" class="input-small" tabindex="2" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
				</div>
			</div>
		</div>
		
		<div id="form-login-submit" class="control-group">
            <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
            <div id="form-login-remember" class="checkbox">
                <label for="modlgn-remember" class="control-label"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label> <input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
            </div>
            <?php endif; ?>
			<div class="controls">
				<button type="submit" tabindex="3" name="Submit" class="btn"><?php echo JText::_('JLOGIN') ?></button>
			</div>
		</div>
		<?php
			$usersConfig = JComponentHelper::getParams('com_users');
			if ($usersConfig->get('allowUserRegistration')) : ?>
			<ul class="unstyled">
				 <li>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"  title="<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?>">
                        <?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
                    </a>
                </li>
                <li>
					<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
					<?php echo JText::_('MOD_LOGIN_REGISTER2'); ?></a>
				</li>
               
			</ul>
		<?php endif; ?>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	<?php if ($params->get('posttext')): ?>
		<div class="posttext">
		<p><?php echo $params->get('posttext'); ?></p>
		</div>
	<?php endif; ?>
</form>
