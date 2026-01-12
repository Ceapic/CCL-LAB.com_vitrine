<?php
defined('_JEXEC') or die;
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


<style>
    @media (max-width: 768px) {
        .grid {
            display: flex !important;
            flex-direction: column !important;
        }
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        /* 2 equal columns */
        gap: 20px;
        justify-content: center;
        align-items: stretch;
        /* Ensures all items stretch to the same height */
        padding: 20px;
    }

    .card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        /* Ensures content is spaced evenly */
        text-align: center;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* min-height: 50px; Ensures a consistent minimum height */
        /* height: 100%; Forces all cards to take the same height */
        transition: transform 0.3s ease;
    }

    /* .card:hover {
    transform: translateY(-5px);
} */

    .circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .title {
        font-size: 20px;
        margin: 10px 0;
        color: #333;
    }

    .content {
        font-size: 16px;
        line-height: 1.6;
        color: #666;
        flex-grow: 1;
        /* Ensures text fills space and cards align */
    }
</style>

<div class="body_template_class" data-body-class="body_societe">
    <!-- <div class="navbar">
      <div class="navbar-inner">
        <a class="brand" href="#">Title</a>
        <ul class="nav">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
        </ul>
      </div>
    </div> -->
    <!-- <form>
    <div class="row align-items-center">
        <div class="col-auto">
            <div class="input-group input-group-sm mb-2">
                <input type="text" class="form-control form-control-sm" placeholder="identifiant" aria-label="Example text with button addon" aria-describedby="button-addon1">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2"><i class="fas fa-question-circle"></i></button>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="input-group input-group-sm mb-2">
                <input type="password" class="form-control form-control-sm" placeholder="mots de pass" aria-label="Example text with button addon" aria-describedby="button-addon1">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="button-addon2"><i class="fas fa-question-circle"></i></button>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm mb-3">Submit</button>
        </div>
    </div>
</form> -->




    <h1>Société</h1>
    <p>
        Fondé en 2011, LEPBI Environnement c'est imposé progressivement comme un acteur privé de référence de l'analyse environnementale.
        Leader dans le domaine analytique de l'amiante de part de son expertise, son savoir faire et sa capacité à proposer des solutions
        adaptées aux besoins de ses clients; LEPBI Environnement est un partenaire reconnu et incontournable sur l'ensemble des problématiques
        environnementales.
    </p>
    <p>LEPBI Environnement est accrédité selon les critères fixés par le COFRAC sous le numéro 1-2350 et
        répond aux exigences de la norme NF EN ISO/CEI 17025.</p>

    <p>LEPBI Environnement dispose d'une plateforme dédiée, garni d'équipement de dernière technologie, de techniciens et
        d'ingénieurs compétents lui permettant ainsi, d'assurer efficacement ses missions.</p>

    <p>Fort de des nombreuses années d'expérience consacrées aux activités analytiques, LEPBI Environnement est en mesure d'offrir
        à ses client toute une panoplie de services dans le cadre d'un full service ou d'analyse spécifiques.</p>
    <div class="grid">
        <div class="card">
            <div class="circle">
                <img src="templates\template_lepbi\images\custom_img\Image1-modified.png" class="" alt="">
            </div>
            <h2 class="title">Notre expertise</h2>
            <div class="content">
                <p>Une offre flexible adaptée à vos besoins et un savoir faire à la hauteur de vos exigences</p>
            </div>
        </div>

        <div class="card">
            <div class="circle">
                <img src="templates\template_lepbi\images\custom_img\Image2-modified.png" alt="">
            </div>
            <h2 class="title">Notre organisation</h2>
            <div class="content">
                <p>Une culture de la performance poussée à son maximum grâce au déploiement de process éprouvés
                    et d'un outil informatique tourné vers le client</p>
            </div>
        </div>

        <div class="card">
            <div class="circle">
                <img src="templates\template_lepbi\images\custom_img\Image3-modified.png" class="" alt="">
            </div>
            <h2 class="title">Notre vision</h2>
            <div class="content">
                <p>Le Client au cœur de l'entreprise</p>
            </div>
        </div>

        <div class="card">
            <div class="circle">
                <img src="templates\template_lepbi\images\custom_img\Image4-modified.png" alt="">
            </div>
            <h2 class="title">Notre objectif</h2>
            <div class="content">
                <p>Créer de la valeur pour nos clients et agir en faveur de l'environnemet</p>
            </div>
        </div>
    </div>
</div>