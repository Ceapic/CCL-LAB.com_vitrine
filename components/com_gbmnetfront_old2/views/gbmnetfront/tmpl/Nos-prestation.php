<?php
defined('_JEXEC') or die;
?>
<style>
    .parent1 {
        border-radius: 10px;
        padding: 20px;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .img1 {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .img2 {
            width: 100px;
            height: 150px;
            object-fit: cover;
        }
    }

    @media (min-width: 768px) {
        .img1 {
            width: 150px;
            height: 130px;
            object-fit: cover;
        }

        .img2 {
            width: 150px;
            height: 190px;
            object-fit: cover;
        }
    }

    /* .img1 {
        width: 150px;
        height: 130px;
        object-fit: cover;
    }

    .img2 {
        width: 150px;
        height: 200px;
        object-fit: cover;
    } */
</style>
<h1><strong>Nos Prestations</strong></h1>
<div class="parent1">
    <h3 class="text-info lead"><strong>Etude de stratégie d'échantillonage</strong></h3>
    <div class="image-container">
        <img class="img1 img-rounded" src="templates\template_lepbi\images\custom_img\Image6.jpg" alt="">
        <img class="img1 img-rounded" src="templates\template_lepbi\images\custom_img\Image7.jpg" alt="">
        <img class="img1 img-rounded" src="templates\template_lepbi\images\custom_img\Image8.jpg" alt="">
    </div>
    <br>
    <p>
        Une équipe chargée d'établir les stratégies d'échantillonnage vous accompagne sur l'ensemble de
        vos problématiques et vous apporte des solutions adaptées conformes aux exigences réglementaires et normatives notamment :
    </p>
    <ul>
        <li>NF EN ISO 16000-7</li>
        <li>Guide d'application GA X47-033</li>
    </ul>
</div>

<div class="parent1">
    <h3 class="text-info lead"><strong>Mesurage d'air</strong></h3>
    <div class="image-container">
        <img class="img2 img-rounded" src="templates\template_lepbi\images\custom_img\Image12.jpg" alt="">
        <img class="img2 img-rounded" src="templates\template_lepbi\images\custom_img\Image14.jpg" alt="">
        <img class="img2 img-rounded" src="templates\template_lepbi\images\custom_img\Image13.jpg" alt="">
    </div>
    <br>
    <p>
        Nos techniciens sont à votre disposition afin d'assurer des prestations
        de mesurages conformément aux stratégies d'échantillonnage et aux cahiers des charges définis:
    </p>
    <ul>
        <li>Prélèvement sur poste fixe conformément à la norme XP X43-050</li>
        <li>Prélèvement individuel sur opérateur conformément à la norme XP X43-269</li>
    </ul>
    <p>
        Nous disposons d'un parc matériel comportant de plus de 200 pompes de prélèvement dont près de la moitié est autonome,
        ainsi nous somme en mesure de répondre aux spécificités de toutes vos demandes en matière de prélèvement.
    </p>
</div>

<div class="parent1">
    <h3 class="text-info lead"><strong>Prestations Analytiques</strong></h3>
    <div class="image-container">
        <img class="img1 img-rounded" src="templates\template_lepbi\images\custom_img\Image9.jpg" alt="">
        <img class="img1 img-rounded" src="templates\template_lepbi\images\custom_img\Image10.jpg" alt="">
        <img class="img1 img-rounded" src="templates\template_lepbi\images\custom_img\Image11.jpg" alt="">
    </div>
    <br>
    <p>
        Nous disposons d'une plateforme analytique équipée dont les prestations en cycle continu.
    </p>
    <p>
        Notre savoir faire technique et organisationnel nous permet de répondre aux exigences de notre clientèle et de traiter dans des
        délais extrémement court les présentations suivantes :
    </p>
</div>

<div class="parent1">
    <h3 class="text-info lead"><strong>Analyse Matériaux</strong></h3>
    <p>
        détection et identification des fibre d'amiante dans les matériaux de construction et de l'industrie par :
    </p>
    <ul>
        <li>MOLP : Guide HSG 248</li>
        <li>META : Norme NF X43-050</li>
    </ul>
</div>

<div class="parent1">
    <h3 class="text-info lead"><strong>Analyse Des Filtres Air</strong></h3>
    <p>
        Comptage des fibres d'amiante afin de déterminer la concentration en fibre d'amiantes par litre d'air prélevé :
    </p>
    <ul>
        <li>META : Norme NF X43-050</li>
    </ul>
</div>

<div class="parent1">
    <h3 class="text-info lead"><strong>Autre Presentations</strong></h3>
    <ul>
        <li>Plomb : Prélèvement et/ou analyse(air,lingette,écaille,lixiviation)</li>
        <li>Fibres céramiques réfractaires : Prélèvement et/ou analyse(air, lingette, écaille, lixiviation)</li>
        <li>Amiante : Prélèvement et/ou analyse(lingette, solution liquide, roche, sol, enrobés routiers)</li>
        <li>MEST : Prélèvement et/ou analyse(matière en suspension totale)</li>
        <li>ACR : Mesure de la qualité de l'air respirable issu d'une centrale de production d'air (CO, CO2, Vapeur d'eau, brouillard d'huile)</li>
        <li>HAP : Détermination de la concentration en hydrocarbures aromatiques polycycliques dans les enrobés routiers</li>
    </ul>
</div>