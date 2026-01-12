<?php
/*******************************************************************************************

@copyright	Copyright (C) 2018 JooThemes.net

http://joothemes.net

*******************************************************************************************/
defined('_JEXEC') or die;

include 'includes/params.php';

if ($params->get('compile_sass', '0') === '1')
{
	require_once "includes/sass.php";
}

?>
<!DOCTYPE html>
<html lang="en">
<?php
$app = JFactory::getApplication();
$menu = $app->getMenu();
$menuid			= $this->params->get('menuid');
 include 'includes/head.php'; ?>
<body class="default-layout <?php if ($menu->getActive()!== $menu->getDefault()) {echo 'no-homepage'; }else {}?>">
<?php
 if($layout=='boxed'){ ?>
<?php  $path= JURI::base().'templates/'.$this->template."/images/elements/pattern".$pattern.".png"; ?>
<style type="text/css">
 body {
    background: url("<?php  echo $path ; ?>") repeat fixed center top rgba(0, 0, 0, 0);
 }
</style>
<div class="layout-boxed">
  <?php  } ?>
<div id="wrap">
<!--Navigation-->
<header id="header" class="header header-fixed hide-from-print" role="banner">
<!--top-->
<div id="navigation">
<div class="navbar navbar-default" role="navigation">
<div class="container">
	<div class="top-header">
		<div class="row">

		<div id="brand" class="col-xs-8 col-sm-4">
			 <a href="<?php  echo $this->params->get('logo_link')   ?>">
						<img style="width:<?php  echo $this->params->get('logo_width')   ?>px; height:<?php  echo $this->params->get('logo_height')   ?>px; " src="<?php  echo $this->params->get('logo_file')   ?>" alt="<?php echo htmlspecialchars($app->getCfg('sitename')); ?>" />
			 </a>
		 </div>
		 <div class="collapse center_top">
		 <?php  if ($this->countModules('navigation')) : ?>
		                         <nav class="navigation <?php if (!(is_array($menuid) && !is_null($menu->getActive()) && in_array($menu->getActive()->id, $menuid, false) or ((in_array('1', $menuid)) && $menu->getActive()== $menu->getDefault())))  { ?> echo'navi-dark';	<?php }  ?>" role="navigation">
		                                 <jdoc:include type="modules" name="navigation" style="none" />
		                         </nav>
		                         <?php  endif; ?>
		 <?php if ($superfish == 'yes' ) : ?>
		 	<?php $doc->addStyleSheet('templates/' . $this->template . '/css/superfish.css');  ?>
		 	<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/hoverIntent.js"></script>
		     <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/superfish.js"></script>

		     <script type="text/javascript">
		 		jQuery(document).ready(function(){
		 			jQuery('#navigation .menu').superfish({
		 				animation: {height:'show'},	// slide-down effect without fade-in
		 				 speed:         'fast',
		 				delay:		 600			// 1.2 second delay on mouseout
		 			});
		 		});
		 	</script>
		 <?php endif; ?>
		 <?php  if($this->countModules('top-search')) : ?>
		 		<div  class="top-search">
		 							 <jdoc:include type="modules" name="top-search" style="block"/>
		 		</div>
		 <?php  endif; ?>
		 </div>

		 </div>
	</div>



</div>
</div>
</div>
</header>
<div class="clearfix"></div>
<!--Navigation-->
<section <?php if ($menu->getActive()!== $menu->getDefault()) {echo 'class="section_m"'; }else {}?> >


<?php if (is_array($menuid) && !is_null($menu->getActive()) && in_array($menu->getActive()->id, $menuid, false) or ((in_array('1', $menuid)) && $menu->getActive()== $menu->getDefault()))  { ?>
		<!--fullwidth-->
				<div class="fullwidth" id="fullwidth">
								<?php include "slideshow.php"; ?>
								<div id="particles"></div>
								<a id="slider-arrow" href="#">
									<span class="arrow arrow-first"></span>
									<span class="arrow arrow-second"></span>
								</a>
				</div>
	<!--fullwidth-->
	<?php }  ?>
<!--Breadcrum-->
<?php  if($this->countModules('breadcrumbs')) : ?>
<div id="breadcrumbs">
<jdoc:include type="modules" name="breadcrumbs" style="block" />
</div>
<!--Breadcrum-->
<?php  endif; ?>
<!--Feature-->
<?php  if($this->countModules('feature')) : ?>
<div id="feature">
<div class="container">
<div class="row">
	<div class="col-md-12">
<jdoc:include type="modules" name="feature" style="block" />
</div>
</div>
</div>
</div>
<?php  endif; ?>
<!--Feature-->
<!-- box -->
<?php  if($this->countModules('top_about')) : ?>
<div id="top_about">
    <div class="container">
    <div class="row">
				<div class="col-md-12">
							<jdoc:include type="modules" name="top_about" style="block" />
					</div>
				</div>
    </div>
</div>
<?php  endif; ?>
<!-- box-->

<!-- box -->
<?php	$boxcount1 = $this->countModules( 'box1 + box2 + box3 + box4' );
		switch ($boxcount1) {
		    case "1":
		       $boxclass='col-sm-12';
		        break;
		    case "2":
		        $boxclass='col-sm-6';
		        break;
		    case "3":
		        $boxclass='col-sm-4';
		        break;
				case "4":
				    $boxclass='col-sm-3';
				    break;
				default:
						$boxclass='col-sm-3';
		}
?>
<?php	$boxcount2 = $this->countModules( 'box5 + box6 + box7 + box8' );
		switch ($boxcount2) {
		    case "1":
		       $boxclass2='col-sm-12';
		        break;
		    case "2":
		        $boxclass2='col-sm-6';
		        break;
		    case "3":
		        $boxclass2='col-sm-4';
		        break;
				case "4":
				    $boxclass2='col-sm-3';
				    break;
				default:
						$boxclass2='col-sm-3';
		}
?>
<?php if ($this->countModules( 'box1 or box2 or box3 or box4 or box5 or box6 or box7 or box8' )) : ?>
<div id="top_box">
			<?php if ($this->countModules( 'box1 or box2 or box3 or box4' )) : ?>
			<div class="row">
					<?php if ($this->countModules( 'box1' )) : ?>
							<div class="box <?php echo $boxclass ?>">
    							<jdoc:include type="modules" name="box1" style="block" />
							</div>
					<?php  endif; ?>
					<?php if ($this->countModules( 'box2' )) : ?>
							<div class="box <?php echo $boxclass ?>">
    							<jdoc:include type="modules" name="box2" style="block" />
							</div>
					<?php  endif; ?>
					<?php if ($this->countModules( 'box3' )) : ?>
							<div class="box <?php echo $boxclass ?>">
    							<jdoc:include type="modules" name="box3" style="block" />
							</div>
					<?php  endif; ?>
					<?php if ($this->countModules( 'box4' )) : ?>
							<div class="box <?php echo $boxclass ?>">
    							<jdoc:include type="modules" name="box4" style="block" />
							</div>
					<?php  endif; ?>
			</div>
			<?php  endif; ?>
			<?php if ($this->countModules( 'box5 or box6 or box7 or box8' )) : ?>
				<div class="row last-border">
						<?php if ($this->countModules( 'box5' )) : ?>
								<div class="box <?php echo $boxclass2 ?>">
	    							<jdoc:include type="modules" name="box5" style="block" />
								</div>
						<?php  endif; ?>
						<?php if ($this->countModules( 'box6' )) : ?>
								<div class="box <?php echo $boxclass2 ?>">
	    							<jdoc:include type="modules" name="box6" style="block" />
								</div>
						<?php  endif; ?>
						<?php if ($this->countModules( 'box7' )) : ?>
								<div class="box <?php echo $boxclass2 ?>">
	    							<jdoc:include type="modules" name="box7" style="block" />
								</div>
						<?php  endif; ?>
						<?php if ($this->countModules( 'box8' )) : ?>
								<div class="box <?php echo $boxclass2 ?>">
	    							<jdoc:include type="modules" name="box8" style="block" />
								</div>
						<?php  endif; ?>
				</div>
				<?php  endif; ?>
</div>
<?php  endif; ?>
<!-- box-->
<!-- Content -->
<div class="container">
<div id="main" class="row show-grid">
<!-- Component -->
<div id="container" class="col-sm-<?php  echo (12-$leftcolgrid-$rightcolgrid); ?>">
<!-- Content-top Module Position -->
<?php  if($this->countModules('content-top')) : ?>
<div id="content-top">

<jdoc:include type="modules" name="content-top" style="block" />

</div>
<?php  endif; ?>
<!-- Front page show or hide -->
<?php
	$app = JFactory::getApplication();
	$menu = $app->getMenu();
	if ($frontpageshow){
		// show on all pages
		?>
<div id="main-box">
<jdoc:include type="message" />
<jdoc:include type="component" />
</div>
<?php
	} else {

		if ($menu->getActive() !== $menu->getDefault()) {
			// show on all pages but the default page
			?>
<div id="main-box">
<jdoc:include type="component" />
</div>
<?php
 }} ?>
<!-- Front page show or hide -->
<!-- Below Content Module Position -->
<?php  if($this->countModules('content-bottom')) : ?>
<div id="content-bottom">
		<jdoc:include type="modules" name="content-bottom" style="block" />
</div>
<?php  endif; ?>
</div>
<!-- Right -->
<?php  if($this->countModules('right')) : ?>
<div id="sidebar-2" class="col-sm-<?php  echo $rightcolgrid; ?>">
<jdoc:include type="modules" name="right" style="block" />
</div>
<?php  endif; ?>
</div>
</div>
<!-- Content -->

<?php  if($this->countModules('bottom_team')) : ?>
<!-- bottom_team -->
<div id="bottom_team">
	  <div class="container">
    		<jdoc:include type="modules" name="bottom_team" style="block" />
		</div>
</div>
<?php  endif; ?>
<?php  if($this->countModules('bottom_gallery')) : ?>
<!-- bottom_gallery -->
<div id="bottom_gallery">
	  <div class="container">
    		<jdoc:include type="modules" name="bottom_gallery" style="block" />
		</div>
</div>
<?php  endif; ?>
<?php  if($this->countModules('parallax')) : ?>
<!-- parallax -->
<div id="parallax">
	<div class="container">
			<div class="row">
				<div class="col-sm-12">
						<jdoc:include type="modules" name="parallax" style="block" />
				</div>
			</div>
	</div>
</div>
<?php  endif; ?>

<?php  if($this->countModules('bottom')) : ?>
<!-- bottom -->
<div id="bottom">
	<div class="container">
			<div class="row">
				<div class="col-sm-12">
						<jdoc:include type="modules" name="bottom" style="block" />
				</div>
			</div>
	</div>
</div>
<?php  endif; ?>

<?php  if($this->countModules('newsletter')) : ?>
<!-- newsletter -->
<div id="newsletter">
	<div class="container">
			<div class="row">
				<div class="col-sm-12">
						<jdoc:include type="modules" name="newsletter" style="block" />
				</div>
			</div>
	</div>
</div>
<?php  endif; ?>
<?php  if($this->countModules('footer-logo')) : ?>
<!-- Footer logo -->
<div id="footer-logo">
	<div class="container">
		<div class="row">
				<div class="col-md-12">
						<jdoc:include type="modules" name="footer-logo" style="block" />
				</div>
			</div>
	</div>
</div>
<?php  endif; ?>
<?php	$footer1 = $this->countModules( 'footer1 + footer2 + footer3' );
		switch ($footer1) {
		    case "1":
		       $footerclass1='col-md-12';
		        break;
		    case "2":
		       $footerclass1='col-md-6';
		        break;
		    case "3":
		       $footerclass1='col-md-4';
		        break;
				default:
					 $footerclass1='col-md-4';
		}
?>
<?php if ($this->countModules( 'footer1 or footer2 or footer3' )) : ?>
<!-- footer -->
	<div id="footer">
		<div class="container">
			  <div class="row">
					<?php  if($this->countModules('footer1')) : ?>
							<div class="<?php echo $footerclass1 ?>">
									<jdoc:include type="modules" name="footer1" style="html" />
						  </div>
					<?php  endif; ?>
					<?php  if($this->countModules('footer2')) : ?>
							<div class="<?php echo $footerclass1 ?>">
									<jdoc:include type="modules" name="footer2" style="html" />
							</div>
					<?php  endif; ?>
					<?php  if($this->countModules('footer3')) : ?>
							<div class="<?php echo $footerclass1 ?>">
									<jdoc:include type="modules" name="footer3" style="html" />
						  </div>
					<?php  endif; ?>

			  </div>
		</div>
	</div>
<?php  endif; ?>
<!-- footer -->
<div id="footer_social">
    <div class="container">
							<?php include "social.php"; ?>
		</div>
</div>


<div id="footer_copy">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            	<div class="custom"  >
	                <p class="pull-left">Copyright &copy; <?php echo (date("Y")); ?> <?php echo htmlspecialchars($app->getCfg('sitename')); ?></p>
					 <p class="pull-right">Design and theme by JooThemes.net <a href="http://joothemes.net/" target="_blank">IT Web Agency Free Joomla Templates</a>.</p>
				     <!--  The link / copyright text must not be removed or altered. License is available at www.JooThemes.net! -->
					 <!--  Der Link / Copyright Text darf nicht entfernt oder verändert werden. Lizenz erhalten sie unter www.JooThemes.net -->
				</div>
            </div>
        </div>
    </div>
</div>

<!-- copy -->
<!-- menu slide -->
<?php  if($this->countModules('panelnav')): ?>
<div id="panelnav">
    <jdoc:include type="modules" name="panelnav" style="none" />
</div><!-- end panelnav -->
<?php  endif;// end panelnav  ?>
<!-- menu slide -->
<a href="#" class="back-to-top iconn-arrow_up"></a>
<jdoc:include type="modules" name="debug" />

</section>
</div>
<!-- page -->
<!-- JS -->
<script type="text/javascript" src="<?php echo $tpath; ?>/js/jquery.flexisel.js"></script>
<script type="text/javascript" src="<?php echo $tpath; ?>/js/jquery.slicknav.min.js"></script>
<script type="text/javascript" src="<?php echo $tpath; ?>/js/image-scale.min.js"></script>
<script type="text/javascript" src="<?php echo $tpath; ?>/js/jquery.tinyTips.js"></script>
<script type="text/javascript" src="<?php echo $tpath; ?>/js/tools.js"></script>
<script type="text/javascript" src="<?php echo $tpath; ?>/js/jquery.matchHeight-min.js"></script>
<script type="text/javascript" src="<?php echo $tpath; ?>/js/jquery.corner.js"></script>
<script type="text/javascript" src="<?php echo $tpath; ?>/js/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="<?php echo $tpath; ?>/js/jquery.nicescroll.plus.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.flexslider-min.js"></script>

<?php if (is_array($menuid) && !is_null($menu->getActive()) && in_array($menu->getActive()->id, $menuid, false) or ((in_array('1', $menuid)) && $menu->getActive()== $menu->getDefault()))  { ?>
	<script type="text/javascript" src="<?php echo $tpath; ?>/js/particles.js"></script>
	<script type="text/javascript" src="<?php echo $tpath; ?>/js/app.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo $tpath; ?>/js/template.min.js"></script>


<!-- JS -->
</body>
</html>
