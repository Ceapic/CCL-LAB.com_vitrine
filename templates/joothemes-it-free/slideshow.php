<?php
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Images
$Caption[]= $this->params->get( '!', "" );

for ($j=1; $j<=30; $j++){
	$Caption[$j]	= $this->params->get ("Caption".$j , "" );
} ?>
<div class="flexslider" id="flexslider">
	<ul class="slides">
		<?php for ($i=1; $i<=30; $i++){ if ($Caption[$i] != null) { ?>
        <li>
					<div class="slider-txt">
					<?php if ($Caption[$i] != null) {?><div class="flex-caption"><?php echo $Caption[$i] ?></div><?php };?>
					</div>


        </li>
        <?php }};  ?>
	</ul>
</div>
