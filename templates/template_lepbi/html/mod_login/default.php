<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" integrity="sha384-1dFfFvG8FfU1ejL2bf5rJRx57fiZJoHM8BdI62A8iU8Vk75M1gNmE3ykLQf1uIh" crossorigin="anonymous">-->
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" class="<?php echo htmlspecialchars($params->get('form_layout'), ENT_COMPAT, 'UTF-8'); ?>">
	<?php if ($params->get('pretext')) : ?>
		<div class="pretext">
			<p><?php echo $params->get('pretext'); ?></p>
		</div>
	<?php endif; ?>
	<fieldset class="userdata">
		<div class="" id="form-login-username" style="margin-bottom: -10px;">
			<!-- <label for="modlgn-username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?></label> -->
			<!-- <div class="input-append"> -->
				<input id="modlgn-username" type="text" name="username" class="inputbox form-control form-control-sm" placeholder="identifiant" />
				<!-- <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"><button class="btn " type="" id="button-reset-user"><i class="fas fa-question-circle"></i></button></a> -->
			<!-- </div> -->
		</div>
		<div class="" id="form-login-password" style="margin-bottom: -10px;">
			<!-- <label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label> -->
			<!-- <div class="input-append"> -->
				<input id="modlgn-passwd" type="password" name="password" class="inputbox form-control form-control-sm" placeholder="mots de passe" />
				<!-- <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"><button class="btn " type="button" id="button-reset-pass"><i class="fas fa-question-circle"></i></button></a> -->
			<!-- </div> -->
		</div>
		<?php if (count($twofactormethods) > 1) : ?>
			<div id="form-login-secretkey" class="control-group">
				<div class="controls">
					<?php if (!$params->get('usetext')) : ?>
						<div class="input-prepend input-append">
							<label for="modlgn-secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?></label>
							<input id="modlgn-secretkey" autocomplete="one-time-code" type="text" name="secretkey" class="input-small" tabindex="0" size="18" />
						</div>
					<?php else: ?>
						<label for="modlgn-secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY') ?></label>
						<input id="modlgn-secretkey" autocomplete="one-time-code" type="text" name="secretkey" class="input-small" tabindex="0" size="18" />
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<!-- <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
			<div id="form-login-remember">
				<label for="modlgn-remember"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
				<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes" />
		</div>
		<?php endif; ?>  										margin-bottom: 10px; -->
		<input type="submit" name="Submit" class="btn btn-primary" style="" value="<?php echo JText::_('JLOGIN') ?>" />
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
		<!-- <ul>
			<li>
				<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
					<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
			</li>
			<li>
				<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
					<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
			</li>
			<?php if (JComponentHelper::getParams('com_users')->get('allowUserRegistration')) : ?>
				<li>
					<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
						<?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a>
				</li>
			<?php endif; ?>
		</ul> -->
		<?php if ($params->get('posttext')) : ?>
			<div class="posttext">
				<p><?php echo $params->get('posttext'); ?></p>
			</div>
		<?php endif; ?>
	</fieldset>
</form>
<!-- <script>
	function login_vertical() {
		if(window.innerWidth <= 768){
			jQuery("#login-form").removeClass('horizontal');
			jQuery("#login-form").addClass('vertical');
		}
		else{
			exit;
		}
	}
	window.onload = login_vertical;
</script> -->