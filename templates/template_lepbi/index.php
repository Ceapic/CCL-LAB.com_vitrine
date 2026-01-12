<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

JHtml::_('bootstrap.loadCss', true);

JLoader::import('joomla.filesystem.file');

// Check modules $this->countModules('position-3')
// $showTop		= ($this->countModules('top_banner');
$showRightColumn = ($this->countModules('position-3') or $this->countModules('position-6') or $this->countModules('position-8'));
$showbottom      = ($this->countModules('position-9') or $this->countModules('position-10') or $this->countModules('position-11'));
$showleft        = ($this->countModules('position-4') or $this->countModules('position-7') or $this->countModules('position-5'));

if ($showRightColumn === false && $showleft === false) {
	$showno = 0;
}

JHtml::_('bootstrap.framework');

JHtml::_('behavior.framework', true);

// Get params
$color          = $this->params->get('templatecolor');
$logo           = $this->params->get('logo');
$navposition    = $this->params->get('navposition');
$headerImage    = $this->params->get('headerImage');
$config         = JFactory::getConfig();
$bootstrap      = explode(',', $this->params->get('bootstrap'));
$option         = JFactory::getApplication()->input->getCmd('option', '');

// Output as HTML5
$this->setHtml5(true);

// Load optional rtl Bootstrap css and Bootstrap bugfixes
JHtml::_('bootstrap.loadCss', true, $this->direction);

// Add stylesheets
JHtml::_('stylesheet', 'templates/system/css/system.css', array('version' => 'auto'));
JHtml::_('stylesheet', 'position.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'layout.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'print.css', array('version' => 'auto', 'relative' => true), array('media' => 'print'));
JHtml::_('stylesheet', 'general.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', htmlspecialchars($color, ENT_COMPAT, 'UTF-8') . '.css', array('version' => 'auto', 'relative' => true));

if ($this->direction === 'rtl') {
	JHtml::_('stylesheet', 'template_rtl.css', array('version' => 'auto', 'relative' => true));
	JHtml::_('stylesheet', htmlspecialchars($color, ENT_COMPAT, 'UTF-8') . '_rtl.css', array('version' => 'auto', 'relative' => true));
}

// if ($color === 'image')
// {
// 	$this->addStyleDeclaration("
// 	.logoheader {
// 		background: url('" . $this->baseurl . "/" . htmlspecialchars($headerImage) . "') no-repeat right;
// 	}
// 	body {
// 		background: " . $this->params->get('backgroundcolor') . ";
// 	}");
// }

JHtml::_('stylesheet', 'ie7only.css', array('version' => 'auto', 'relative' => true, 'conditional' => 'IE 7'));

// Check for a custom CSS file
JHtml::_('stylesheet', 'user.css', array('version' => 'auto', 'relative' => true));

JHtml::_('bootstrap.framework');

// Add template scripts
JHtml::_('script', 'templates/' . $this->template . '/javascript/md_stylechanger.js', array('version' => 'auto'));
JHtml::_('script', 'templates/' . $this->template . '/javascript/hide.js', array('version' => 'auto'));
JHtml::_('script', 'templates/' . $this->template . '/javascript/respond.src.js', array('version' => 'auto'));
JHtml::_('script', 'templates/' . $this->template . '/javascript/template.js', array('version' => 'auto'));

// Check for a custom js file
JHtml::_('script', 'templates/' . $this->template . '/javascript/user.js', array('version' => 'auto'));

require __DIR__ . '/jsstrings.php';

// Add html5 shiv
JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));
?>

<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" integrity="sha384-1dFfFvG8FfU1ejL2bf5rJRx57fiZJoHM8BdI62A8iU8Vk75M1gNmE3ykLQf1uIh" crossorigin="anonymous"> -->

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
	<link rel="stylesheet" href="/templates/template_lepbi/css/owl.carousel.min.css">
	<link rel="stylesheet" href="/templates/template_lepbi/css/owl.theme.default.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes" />
	<meta name="HandheldFriendly" content="true" />
	<meta name="apple-mobile-web-app-capable" content="YES" />
	<jdoc:include type="head" />
</head>

<body id="shadow">
	<div id="all">
		<div id="top_banner">

			<div id="menu_mode_telephone">
				<jdoc:include type="modules" name="position-1" />

			</div>

			<div id="logo_position">
				<img src="/templates\template_lepbi\images\custom_img\image.png" alt="logo" id="logo">
				<jdoc:include type="modules" name="position-logo" />
			</div>

			<!-- cache en mode telephone -->
			<div id="login_position">
				<jdoc:include type="modules" name="position-login" />
			</div>
		</div>

		<div id="back">
			<div id="header-custom">
				<div id="menu_mode_pc" class="navbar">
					<div class="navbar-inner">
						<jdoc:include type="modules" name="position-1" />
					</div>
				</div>
				<!-- <ul class="skiplinks">
						<li><a href="#main" class="u2"><?php echo JText::_('TPL_BEEZ3_SKIP_TO_CONTENT'); ?></a></li>
						<li><a href="#nav" class="u2"><?php echo JText::_('TPL_BEEZ3_JUMP_TO_NAV'); ?></a></li>
						<?php if ($showRightColumn) : ?>
							<li><a href="#right" class="u2"><?php echo JText::_('TPL_BEEZ3_JUMP_TO_INFO'); ?></a></li>
						<?php endif; ?>
					</ul> -->
				<!-- <h2 class="unseen"><?php echo JText::_('TPL_BEEZ3_NAV_VIEW_SEARCH'); ?></h2>
					<h3 class="unseen"><?php echo JText::_('TPL_BEEZ3_NAVIGATION'); ?></h3> -->

				<!-- <div id="line">
						<div id="fontsize"></div>
						<h3 class="unseen"><?php echo JText::_('TPL_BEEZ3_SEARCH'); ?></h3>

						<jdoc:include type="modules" name="position-0" />
					</div> -->
			</div>
			<div id="<?php echo $showRightColumn ? 'contentarea2' : 'contentarea'; ?>">
				<div id="breadcrumbs">
					<jdoc:include type="modules" name="position-2" />
				</div>

				<?php if ($navposition === 'left' and $showleft) : ?>
					<nav class="left1 <?php if ($showRightColumn == null) {
											echo 'leftbigger';
										} ?>" id="nav">
						<jdoc:include type="modules" name="position-7" style="beezDivision" headerLevel="3" />
						<jdoc:include type="modules" name="position-4" style="beezHide" headerLevel="3" state="0 " />
						<jdoc:include type="modules" name="position-5" style="beezTabs" headerLevel="2" id="3" />
					</nav><!-- end navi -->
				<?php endif; ?>

				<div id="<?php echo $showRightColumn ? 'wrapper' : 'wrapper2'; ?>" <?php if (isset($showno)) {
																						echo 'class="shownocolumns"';
																					} ?>>
					<div id="main">

						<?php if ($this->countModules('position-12')) : ?>
							<div id="top">
								<jdoc:include type="modules" name="position-12" />
							</div>
						<?php endif; ?>

						<jdoc:include type="message" />
						<jdoc:include type="component" />

					</div><!-- end main -->
				</div><!-- end wrapper -->

				<?php if ($showRightColumn) : ?>
					<div id="close">
						<a href="#" onclick="auf('right')">
							<span id="bild">
								<?php echo JText::_('TPL_BEEZ3_TEXTRIGHTCLOSE'); ?>
							</span>
						</a>
					</div>

					<aside id="right">
						<h2 class="unseen"><?php echo JText::_('TPL_BEEZ3_ADDITIONAL_INFORMATION'); ?></h2>
						<jdoc:include type="modules" name="position-6" style="beezDivision" headerLevel="3" />
						<jdoc:include type="modules" name="position-8" style="beezDivision" headerLevel="3" />
						<jdoc:include type="modules" name="position-3" style="beezDivision" headerLevel="3" />
					</aside><!-- end right -->
				<?php endif; ?>

				<?php if ($navposition === 'center' and $showleft) : ?>
					<nav class="left <?php if ($showRightColumn == null) {
											echo 'leftbigger';
										} ?>" id="nav">

						<jdoc:include type="modules" name="position-7" style="beezDivision" headerLevel="3" />
						<jdoc:include type="modules" name="position-4" style="beezHide" headerLevel="3" state="0 " />
						<jdoc:include type="modules" name="position-5" style="beezTabs" headerLevel="2" id="3" />

					</nav><!-- end navi -->
				<?php endif; ?>

				<div class="wrap"></div>
			</div> <!-- end contentarea -->
		</div><!-- back -->
	</div><!-- all -->

	<div id="footer-outer">
		<?php if ($showbottom) : ?>
			<div id="footer-inner">

				<div id="bottom">
					<div class="box box1">
						<jdoc:include type="modules" name="position-9" style="beezDivision" headerlevel="3" />
					</div>
					<div class="box box2">
						<jdoc:include type="modules" name="position-10" style="beezDivision" headerlevel="3" />
					</div>
					<div class="box box3">
						<jdoc:include type="modules" name="position-11" style="beezDivision" headerlevel="3" />
					</div>
				</div>

			</div>
		<?php endif; ?>

		<div id="footer-sub">
			<footer id="footer">
				<jdoc:include type="modules" name="position-14" />
			</footer><!-- end footer -->
		</div>
	</div>
	<jdoc:include type="modules" name="debug" />

	<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-KsvqjC0sN5wHnL9K+6W93Sy5g5JH2nS0KeKbnF+o6F9FgF1w5P+FEK2ZR1G6tW9Z" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js" integrity="sha384-6K2f9t9zK3c5pS9G02yNUDAI2j2Ap3N2pk+9U8BLf/sJm5GfD/dZr9KxA7X29u5z" crossorigin="anonymous"></script> -->
	<script src="templates\template_lepbi\javascript\owl.carousel.min.js"></script>

	<script>
		/* Set the width of the side navigation to 250px */
		function openNav() {
			document.getElementById("mySidenav").style.width = "250px";
		}

		/* Set the width of the side navigation to 0 */
		function closeNav() {
			document.getElementById("mySidenav").style.width = "0";
		}


		function login_vertical(){

		}
		window.onload = login_vertical;
	</script>

</body>

</html>