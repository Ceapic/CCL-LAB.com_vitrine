<?php
defined('_JEXEC') or die;
?>
<style>
  /* Make sure the carousel container is positioned relatively */
  .owl-carousel {
    position: relative;
  }

  /* Reset Owl's default nav styles if needed */
  .owl-theme .owl-nav [class*='owl-'] {
    margin: 0;
    padding: 0;
  }

  /* Re-enable the default arrow text (‹ and ›) */
  .owl-nav button.owl-prev span,
  .owl-nav button.owl-next span {
    display: inline-block !important;
    font-size: 24px;
    /* Adjust to increase/decrease arrow size */
    line-height: 1;
    color: #fff;
    /* Set arrow text color; adjust as needed */
  }

  /* --- NAVIGATION ARROWS --- */
  .owl-nav button.owl-prev,
  .owl-nav button.owl-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    /* Adjust width for your needs */
    height: 40px;
    /* Adjust height for your needs */
    background: none;
    border: none;
    outline: none;
    cursor: pointer;
    pointer-events: auto;

    /* Flex centering for the arrow text */
    display: flex;
    align-items: center;
    justify-content: center;

    /* Initially invisible */
    opacity: 0;
    transition: opacity 0.3s ease, background-color 0.3s ease;
  }

  /* When hovering over the carousel, show the arrows as subtle shadows */
  .owl-carousel:hover .owl-nav button.owl-prev,
  .owl-carousel:hover .owl-nav button.owl-next {
    opacity: 1;
    background: rgba(0, 0, 0, 0.3);
    /* Shadow-like effect */
    border-radius: 50%;
  }

  /* Position the left arrow at the left edge, right arrow at the right edge */
  .owl-nav button.owl-prev {
    left: 10px;
    /* Adjust spacing from the left edge */
  }

  .owl-nav button.owl-next {
    right: 10px;
    /* Adjust spacing from the right edge */
  }

  /* --- PAGINATION DOTS --- */
  .owl-dots {
    position: absolute;
    bottom: 10px;
    width: 100%;
    text-align: center;
    left: 0;
  }

  .owl-dots .owl-dot span {
    width: 12px;
    height: 12px;
    background: #ccc;
    display: inline-block;
    border-radius: 50%;
    margin: 0 5px;
    cursor: pointer;
  }

  .owl-dots .owl-dot.active span {
    background: #666;
  }


  #image-carousel {  
    width: 100%;
    overflow: hidden;
    position: relative;
  }

  .carousel-wrapper {
    white-space: nowrap;
    transition: transform 1s ease;
    /* smooth slide transition */
  }

  .carousel-wrapper img {
    display: inline-block;
    height: 200px;
    /* adjust as needed */
    /* Optionally, set width or let it adjust automatically */
  }

  /* SLIDE */
  #image-carousel {
    overflow: hidden; /* Cache tout ce qui déborde du conteneur */
    width: 100%;
  }

  .carousel-wrapper {
    display: flex;
    animation: scroll-logos 30s linear infinite; /* Ajustez la durée selon vos besoins */
  }

  .carousel-wrapper img {
    flex: 0 0 auto; /* Assurez que les images ne s'étirent pas */
    height: 50px;
  }


  @keyframes scroll-logos {
    0% {
      transform: translateX(0);
    }
    100% {
      transform: translateX(-100%); /* Défile jusqu'à la moitié pour boucler sur les images originales */
    }
  }

</style>
<!-- <img src="" alt=""> -->

<div style="display: flex; flex-direction:column ; align-items:center; justify-content:center;">
  <div>
    <h3 class="text-info lead"><strong>Ils nous ont fait confiance</strong></h3>
  </div>
  <div>
    <div id="image-carousel">
      <div class="carousel-wrapper">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_0_0.png" alt="Image 1">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_0_1.png" alt="Image 2">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_0_2.png" alt="Image 3">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_1_0.png" alt="Image 4">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_1_1.png" alt="Image 5">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_1_2.png" alt="Image 6">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_2_0.png" alt="Image 7">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_2_1.png" alt="Image 8">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_2_2.png" alt="Image 9">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_3_0.png" alt="Image 10">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_3_1.png" alt="Image 11">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_3_2.png" alt="Image 12">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_4_0.png" alt="Image 13">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_4_1.png" alt="Image 14">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_4_2.png" alt="Image 15">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_5_0.png" alt="Image 16">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_5_1.png" alt="Image 17">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_5_2.png" alt="Image 18">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_6_0.png" alt="Image 19">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_6_1.png" alt="Image 20">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_6_2.png" alt="Image 21">
        

        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_0_0.png" alt="Image 1">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_0_1.png" alt="Image 2">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_0_2.png" alt="Image 3">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_1_0.png" alt="Image 4">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_1_1.png" alt="Image 5">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_1_2.png" alt="Image 6">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_2_0.png" alt="Image 7">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_2_1.png" alt="Image 8">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_2_2.png" alt="Image 9">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_3_0.png" alt="Image 10">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_3_1.png" alt="Image 11">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_3_2.png" alt="Image 12">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_4_0.png" alt="Image 13">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_4_1.png" alt="Image 14">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_4_2.png" alt="Image 15">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_5_0.png" alt="Image 16">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_5_1.png" alt="Image 17">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_5_2.png" alt="Image 18">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_6_0.png" alt="Image 19">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_6_1.png" alt="Image 20">
        <img src="templates\template_lepbi\images\custom_img\bottom-scroll\logo_6_2.png" alt="Image 21">
      </div>
    </div>
  </div>
</div>

<!-- <div class="owl-carousel owl-theme">
  
  <h1>Accueil</h1>
  <div class="item">
    <img src="templates\template_lepbi\images\custom_img\image-test-1.jpg" alt="Image 1">
  </div>
  <div class="item">
    <img src="templates\template_lepbi\images\custom_img\image-test-2.jpg" alt="Image 2">
  </div>
  <div class="item">
    <img src="templates\template_lepbi\images\custom_img\image-test-3.jpg" alt="Image 3">
  </div>

</div>-->





<script>
  jQuery(document).ready(function($) {
    $('.owl-carousel').owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      items: 1,
      autoplay: true,
      autoplayTimeout: 2000,
      autoplayHoverPause: true
    });
  });



  // jQuery(document).ready(function($) {
  //   var currentIndex = 0;
  //   var images = $('#image-carousel .carousel-wrapper img');
  //   var totalImages = images.length;
  //   var imageWidth = images.first().outerWidth(true);

  //   setInterval(function() {
  //     currentIndex = (currentIndex + 1) % totalImages;
  //     $('#image-carousel .carousel-wrapper').css('transform', 'translateX(-' + (imageWidth * currentIndex) + 'px)');
  //   }, 3000); // change image every 3 seconds
  // });
</script>

<!-- <script>
  jQuery(document).ready(function($) {
    $('#myCarousel').carousel({
      interval: 2000,  // Change l'image toutes les 5 secondes
      pause: 'hover'   // Pause quand on passe la souris dessus
    });
  });
</script> -->