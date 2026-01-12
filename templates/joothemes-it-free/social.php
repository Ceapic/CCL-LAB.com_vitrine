<?php
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Images
$SocialLink[]= $this->params->get( '!', "" );
$SocialTitle = array ("","Follow us on Facebook","Follow us on Twitter","Follow us on Google Plus","Follow us on Youtube","Follow us on Vimeo","Linkedin","Instagram");
for ($j=1; $j<=9; $j++){
	$SocialLink[$j]		= $this->params->get ("SocialLink".$j,"" );

}; ?>

    <ul class="social">
            <?php for ($i=1; $i<=8; $i++){ if ($SocialLink[$i] != null) { ?>
                <li class="fa social_<?php echo $i ?>"><a href="<?php echo $SocialLink[$i] ?>" target="_blank" rel="nofollow"  title="<?php echo $SocialTitle[$i] ?>"><?php echo $SocialTitle[$i] ?></a></li>
            <?php }};  ?>
    </ul>
