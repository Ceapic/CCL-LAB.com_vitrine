<?php
$html = "";

$model = $this->getModel('strategie'); // nom model
$model2 = $this->getModel('synthese'); // nom model

$description_revision_rapport_final = "";
$commentaire_debut_rapport_final = "";
$commentaire_fin_rapport_final = "";
$revision_rapport_final = 0;
$validation_rapport_final = 0;


$return = $model->AfficheLastStrategieChantier($id_echantillon);
$oneStrategie = $return[0];

// $ref_strategie = str_replace("VS-", "RS-", $oneStrategie->ref_echantillon);

// $return = $model->AfficheEchantillon($oneStrategie->echantillon_strategie_chantier);
// $oneEchantillon = $return[0];

// =============================== Bon de commande ===============================


?>

<STYLE>
	.table_gbmnet {
		margin-top: 15px;
	}

	.table_gbmnet td {
		border: 1px solid;
		padding: 5px;
		text-align: center;
	}

	.titre_contexte span {
		width: 100%;
		text-align: left;
		font-size: 12pt;
		font-weight: bold;
		font-family: arial;
		color: #0070C0;
	}

	.echantillon_deleted span {
		font-size: 10pt;
		font-weight: bold;
		font-family: arial;
		color: red;
	}

	/* .block {
		width:100%;
		display: block;
		overflow: auto;
	} */

	.hide {
		display: none;
	}

	.color-commentaire {
		color: green;
	}

	.tooltiplink:hover {
		cursor: pointer;
	}

	#tooltip_1 {
		width: 500px;
		margin: 0px;
		padding: 5px;
		font-size: 11px;
		color: #666;
		background: none repeat scroll 0% 0% #FFF;
		border: 5px solid #CCC;
	}

	.white_tab {
		border: 1px solid #aab7b8 !important;
		background: #f8fcff url("/images/ui-bg_glass_80_f8fcff_1x400.png") 50% 50% repeat-x !important;
		font-weight: bold !important;
		color: #4d5656 !important;
	}

	.white_tab:hover {
		border: 1px solid #4d5656 !important;
		background: #f8fcff url("/images/ui-bg_glass_80_f8fcff_1x400.png") 50% 50% repeat-x !important;
		font-weight: bold !important;
		color: #4d5656 !important;
	}

	.white_tab .ui-icon {
		background-image: url("/images/ui-icons_4d5656_256x240.png") !important;
	}

	.white_tab:hover .ui-icon {
		background-image: url("/images/ui-icons_4d5656_256x240.png") !important;
	}

	.yellow_tab {
		border: 1px solid #f1d2a0 !important;
		background: #fcf3cf url("/images/ui-bg_glass_80_fcf3cf_1x400.png") 50% 50% repeat-x !important;
		font-weight: bold !important;
		color: #dfa10f !important;
	}

	.yellow_tab:hover {
		border: 1px solid #e1ac59 !important;
		background: #fdf9e5 url("/images/ui-bg_glass_80_fdf9e5_1x400.png") 50% 50% repeat-x !important;
		font-weight: bold !important;
		color: #dfa10f !important;
	}

	.yellow_tab .ui-icon {
		background-image: url("/images/ui-icons_dfa10f_256x240.png") !important;
	}

	.yellow_tab:hover .ui-icon {
		background-image: url("/images/ui-icons_dfa10f_256x240.png") !important;
	}

	.red_tab {
		border: 1px solid #EAAEB2 !important;
		background: #f9d7da url("/images/ui-bg_glass_80_f9d7da_1x400.png") 50% 50% repeat-x !important;
		font-weight: bold !important;
		color: #aa2738 !important;
	}

	.red_tab:hover {
		border: 1px solid #e2747b !important;
		background: #f9d7da url("/images/ui-bg_glass_80_fbe4e6_1x400.png") 50% 50% repeat-x !important;
		font-weight: bold !important;
		color: #a3001e !important;
	}

	.red_tab .ui-icon {
		background-image: url("/images/ui-icons_cf7278_256x240.png") !important;
	}

	.red_tab:hover .ui-icon {
		background-image: url("/images/ui-icons_e82633_256x240.png") !important;
	}
</STYLE>


<table align="center" style="width: 98%; border-collapse: collapse; border: 1px solid; margin-top: 10px;" border="0">
	<tr style="background: #E2EFD9;">
		<td style="padding: 5px; width: 100%; border: 1px solid;">Mesures réalisées</td>
	</tr>
	<tr style="background: #FFF2CC;">
		<td style="padding: 5px; width: 100%; border: 1px solid;">Mesures commandées mais non réalisées</td>
	</tr>
	<tr style="background: #F2D7D5;">
		<td style="padding: 5px; width: 100%; border: 1px solid;">Mesures préconisées par la stratégie mais non encore commandées</td>
	</tr>
</table>

<?php
$i = 0;
$liste_table[] = array();
$liste_echantillon[] = array();
$save_contexte = "";
$save_zone = "";
$count_table = 0;
$CountEchantillonCorbeille = 0;

echo "<br><p>(*) Mesures sous accréditation cofrac : portée disponible sur www.cofrac.fr</p>";

echo "<div id=\"notaccordion-done\">";

foreach ($model->ListeEchantillonStrategieChantier($id_echantillon) as $oneEchantillon) {
	$i++;
	if (($save_contexte <> $oneEchantillon->nom_pdf_contexte_mesure_strategie) || ($save_zone <> $oneEchantillon->zone)) {
		$count_table++;

		if ($i <> 1) {
			echo "</table>";

			if (count($liste_echantillon_corbeille) <> 0) {
				echo "<table class=\"table_gbmnet\">";
				echo "<tr><td colspan='6' class='titre_contexte'><span>Mesures commandées mais non réalisées</span></td></tr>";
				echo "<tr><td>Zone</td><td>Type</td><td>Date mission</td><td>Date supression</td><td>Commentaire</td></tr>";
				foreach ($liste_echantillon_corbeille as $oneEchantillonCorbeille) {
					$color = "gbmnet_button_green";
					$affichage = 1;
					$title = "Cacher cet élément du rapport final";
					$commentaire = $oneEchantillonCorbeille['commentaire'];

					foreach ($CommentaireRapportFinal as $oneCommentaireRapportFinal) {
						if (($oneCommentaireRapportFinal->type_commentaire_rapport_final == 3) && ($oneCommentaireRapportFinal->link_commentaire_rapport_final == $oneEchantillonCorbeille['id_corbeille'])) {
							$affichage = $oneCommentaireRapportFinal->affiche_commentaire_rapport_final;
							if ($oneCommentaireRapportFinal->affiche_commentaire_rapport_final == 0) {
								$color = "gbmnet_button_red";
								$title = "Afficher cet élément du rapport final";
							}
							$commentaire = $oneCommentaireRapportFinal->commentaire_rapport_final;
						}
					}

					echo "<tr style=\"background: #FFF2CC;\">";
					echo "<td>" . $oneEchantillonCorbeille['zone'] . "</td>";
					echo "<td>" . str_replace("Exigence réglementaire", "<SUP>R</SUP>", $oneEchantillonCorbeille['type_mesure']) . "</td>";
					echo "<td>" . date("d/m/Y", strtotime($oneEchantillonCorbeille['date_mission'])) . "</td>";
					echo "<td>" . date("d/m/Y", strtotime($oneEchantillonCorbeille['date_creation'])) . "</td>";
					echo "<td>" . $commentaire . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			unset($liste_echantillon_corbeille);
			echo "</div>";
		}

		$contexte = $titre;
		if (($save_contexte <> $oneEchantillon->nom_pdf_contexte_mesure_strategie) && ($count_table <> 1)) echo "</div>";
		if ($save_contexte <> $oneEchantillon->nom_pdf_contexte_mesure_strategie) echo "<h3 class=\"h3_contexte\" id_contexte=\"" . $oneEchantillon->id_contexte_mesure_strategie . "\">" . $oneEchantillon->nom_pdf_contexte_mesure_strategie . "</h3><div>";

		$count_echantillon = 0;
?>
		<h3 class="h3_zone"><?php echo $oneEchantillon->zone; ?></h3>
		<div>
			<table class="table_gbmnet table_echantillon">
				<!--<tr style="background: #F2D7D5;">
				<td colspan="5" class="titre_contexte"><span><?php echo $oneEchantillon->nom_pdf_contexte_mesure_strategie . " : " . $oneEchantillon->zone; ?></span></td>
			</tr>-->
				<tr>
					<td style="width: 19%">Ref échantillon</td>
					<td style="width: 19%">Type de mesure</td>
					<td style="width: 19%">Date de pose</td>
					<td style="width: 19%">Résultat</td>
					<td style="width: 4%">Rev Strat</td>
				</tr>
			<?php
		}

		if ($oneEchantillon->ref_echantillon <> "0") {
			$resultat = "";
			$oneRapport = $model->AfficheTypeRapport($oneEchantillon->id_echantillon);
			if ($oneRapport->type == "MEST") {
				$AfficheRapport = $model2->AfficheRapportEchantillonMEST($oneEchantillon->id_echantillon);
				$resultat = $AfficheRapport[0]->ph_rapport_mest;
				$Concentration = round((((str_replace(",", ".", $AfficheRapport[0]->masse_filtre_pese_finale_rapport_mest) - str_replace(",", ".", $AfficheRapport[0]->masse_filtre_pese_initiale_rapport_mest)) * 1000) / str_replace(",", ".", $AfficheRapport[0]->volume_liquide_filtration_rapport_mest)), 1);
				if ($Concentration <= 5) {
					$Concentration = "&lt; 5";
				} else {
					$Concentration = number_format($Concentration, 1, ".", "");
				}
				$resultat = "pH " . $resultat . " - C: " . $Concentration . "mg/L";
				$revision = $AfficheRapport[0]->revision_rapport_mest;
			}

			$cofrac = "";

			if ($oneRapport->type == "META1") {
				$AfficheRapport = $model2->AfficheRapportEchantillonMETA11($oneEchantillon->id_echantillon);
				if ($oneRapport->analyse_echantillon == 2) {
					$resultat = $AfficheRapport[0]->resultat_concentration_rapport_meta_1;
					if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_1 == 1)
						$resultat = "&lt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_1;
					if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_1 == 2)
						$resultat = "&gt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_1;
				} else {
					$Analyses = $model2->AfficheAnalyseEchantillonMETA1($oneEchantillon->id_echantillon, 1);
					$oneAnalyse = $Analyses[0];
					if ($oneAnalyse->nombre_fibre_analyse_meta_1 > 3) {
						$resultat = number_format($model2->concentration_normalisee($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1), 1, ',', '') . "f/L";
					} else {
						$resultat = "&lt;" . number_format($model2->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $model2->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 1, ',', '') . "f/L";
					}
				}
				if ($AfficheRapport[0]->cofrac_rapport_meta_1 == 1) $cofrac = "*";
				$revision = $AfficheRapport[0]->revision_rapport_meta_1;
			}

			if ($oneRapport->type == "META050") {
				$AfficheRapport = $model2->AfficheRapportEchantillonMETA050($oneEchantillon->id_echantillon);
				if ($oneRapport->analyse_echantillon == 2) {
					$resultat = $AfficheRapport[0]->resultat_concentration_rapport_meta_050;
					if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_050 == 1)
						$resultat = "&lt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_050;
					if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_050 == 2)
						$resultat = "&gt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_050;
				} else {
					$Analyses = $model2->AfficheAnalyseEchantillonMETA1($oneEchantillon->id_echantillon, 1);
					if (count($Analyses) <> 0) {
						$oneAnalyse = $Analyses[0];
						if ($oneAnalyse->nombre_fibre_analyse_meta_1 > 3) {
							$resultat = number_format($model2->concentration_normalisee($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1), 1, ',', '') . "f/L";
						} else {
							$resultat = "&lt;" . number_format($model2->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $model2->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 1, ',', '') . "f/L";
						}
					}

					$Analyses = $model2->AfficheAnalyseEchantillonMETAv0($oneEchantillon->id_echantillon, 1);
					if (count($Analyses) <> 0) {
						$oneAnalyse = $Analyses[0];
						$nombre_fibre = str_replace(".", ",", $oneAnalyse->nombre_fibre_analyse_meta_v0);
						$resultat = number_format($oneAnalyse->concentration_normalise_concentration_analyse_meta_v0, 1, ",", "");
						if ($nombre_fibre < 4) $resultat = "&lt;" . $resultat;

						// Echantillon inanalysable
						$Prepa = $model2->AfficheDernierePrepaMETAv0($oneAnalyse->id_analyse_meta_v0);
						$lastPrepa = $Prepa[0];
						if (($lastPrepa->decision_anomalie_grille_analyse_meta_v0_prepa == "Echantillon inanalysable") || ($oneAnalyse->decision_anomalie_reception_analyse_meta_v0 == "Echantillon inanalysable")) {
							$SA = "/";
							$resultat = "INA";
						}
					}

					$Analyses = $model2->getAnalysesEchantillonMETAv1($oneEchantillon->id_echantillon, 1);
					if (count($Analyses) <> 0) {
						$oneAnalyse = $Analyses[0];
						$nombre_fibre = str_replace(".", ",", $oneAnalyse->nbr_fibres);
						$resultat = number_format($oneAnalyse->concentration_normalise, 1, ",", "");
						if ($nombre_fibre < 4) $resultat = "&lt;" . $resultat;

						// Echantillon inanalysable
						if ($oneAnalyse->decision_grille == "Inanalysable") {
							$SA = "/";
							$resultat = "INA";
						}
					}
				}
				if ($AfficheRapport[0]->cofrac_rapport_meta_050 == 1) $cofrac = "*";
				$revision = $AfficheRapport[0]->revision_rapport_meta_050;
			}

			if ($oneRapport->type == "META269") {
				$AfficheRapport = $model2->AfficheRapportEchantillonMETA269($oneEchantillon->id_echantillon);
				if ($oneRapport->analyse_echantillon == 2) {
					$resultat = $AfficheRapport[0]->resultat_concentration_rapport_meta_269;
					if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269 == 1)
						$resultat = "&lt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269;
					if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269 == 2)
						$resultat = "&gt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269;
				} else {
					$Analyses = $model2->AfficheAnalyseEchantillonMETA1($oneEchantillon->id_echantillon, 1);
					$oneAnalyse = $Analyses[0];
					if ($oneAnalyse->nombre_fibre_analyse_meta_1 > 3) {
						$resultat = number_format($model2->concentration_normalisee($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1), 1, ',', '') . "f/L";
					} else {
						$resultat = "&lt;" . number_format($model2->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $model2->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 1, ',', '') . "f/L";
					}
				}
				if ($AfficheRapport[0]->cofrac_rapport_meta_269 == 1) $cofrac = "*";
				$revision = $AfficheRapport[0]->revision_rapport_meta_269;
			}

			if ($oneRapport->type == "META269v2") {
				$AfficheRapport = $model2->AfficheRapportEchantillonMETA269v2($oneEchantillon->id_echantillon);
				if ($oneRapport->analyse_echantillon == 2) {
					$resultat = $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v2;
					if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269_v2 == 1)
						$resultat = "&lt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v2;
					if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269_v2 == 2)
						$resultat = "&gt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v2;
				} else {
					$Analyses = $model2->AfficheAnalyseEchantillonMETA1($oneEchantillon->id_echantillon, 1);
					if (count($Analyses) <> 0) {
						$oneAnalyse = $Analyses[0];
						if ($oneAnalyse->nombre_fibre_analyse_meta_1 > 3) {
							$resultat = number_format($model2->concentration_normalisee($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1), 1, ',', '') . "f/L";
						} else {
							$resultat = "&lt;" . number_format($model2->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $model2->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 1, ',', '') . "f/L";
						}
					}

					$Analyses = $model2->AfficheAnalyseEchantillonMETAv0($oneEchantillon->id_echantillon, 1);
					if (count($Analyses) <> 0) {
						$oneAnalyse = $Analyses[0];
						$nombre_fibre = str_replace(".", ",", $oneAnalyse->nombre_fibre_analyse_meta_v0);
						$resultat = number_format($oneAnalyse->concentration_normalise_concentration_analyse_meta_v0, 1, ",", "");
						if ($nombre_fibre < 4) $resultat = "&lt;" . $resultat;

						// Echantillon inanalysable
						$Prepa = $model2->AfficheDernierePrepaMETAv0($oneAnalyse->id_analyse_meta_v0);
						$lastPrepa = $Prepa[0];
						if (($lastPrepa->decision_anomalie_grille_analyse_meta_v0_prepa == "Echantillon inanalysable") || ($oneAnalyse->decision_anomalie_reception_analyse_meta_v0 == "Echantillon inanalysable")) {
							$SA = "/";
							$resultat = "INA";
						}
					}
				}
				if ($AfficheRapport[0]->cofrac_rapport_meta_269_v2 == 1) $cofrac = "*";
				$revision = $AfficheRapport[0]->revision_rapport_meta_269_v2;
			}

			if ($oneRapport->type == "META269v3") {
				$AfficheRapport = $model2->AfficheRapportEchantillonMETA269v3($oneEchantillon->id_echantillon);
				if ($oneRapport->analyse_echantillon == 2) {
					$resultat = $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v3;
					if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269_v3 == 1)
						$resultat = "&lt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v3;
					if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269_v3 == 2)
						$resultat = "&gt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v3;
				} else {
					$Analyses = $model2->AfficheAnalyseEchantillonMETA1($oneEchantillon->id_echantillon, 1);
					if (count($Analyses) <> 0) {
						$oneAnalyse = $Analyses[0];
						if ($oneAnalyse->nombre_fibre_analyse_meta_1 > 3) {
							$resultat = number_format($model2->concentration_normalisee($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1), 1, ',', '') . "f/L";
						} else {
							$resultat = "&lt;" . number_format($model2->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $model2->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 1, ',', '') . "f/L";
						}
					}

					$Analyses = $model2->AfficheAnalyseEchantillonMETAv0($oneEchantillon->id_echantillon, 1);
					if (count($Analyses) <> 0) {
						$oneAnalyse = $Analyses[0];
						$nombre_fibre = str_replace(".", ",", $oneAnalyse->nombre_fibre_analyse_meta_v0);
						$resultat = number_format($oneAnalyse->concentration_normalise_concentration_analyse_meta_v0, 1, ",", "");
						if ($nombre_fibre < 4) $resultat = "&lt;" . $resultat;

						// Echantillon inanalysable
						$Prepa = $model2->AfficheDernierePrepaMETAv0($oneAnalyse->id_analyse_meta_v0);
						$lastPrepa = $Prepa[0];
						if (($lastPrepa->decision_anomalie_grille_analyse_meta_v0_prepa == "Echantillon inanalysable") || ($oneAnalyse->decision_anomalie_reception_analyse_meta_v0 == "Echantillon inanalysable")) {
							$SA = "/";
							$resultat = "INA";
						}
					}

					$Analyses = $model2->getAnalysesEchantillonMETAv1($oneEchantillon->id_echantillon, 1);
					if (count($Analyses) <> 0) {
						$oneAnalyse = $Analyses[0];
						$nombre_fibre = str_replace(".", ",", $oneAnalyse->nbr_fibres);
						$resultat = number_format($oneAnalyse->concentration_normalise, 1, ",", "");
						if ($nombre_fibre < 4) $resultat = "&lt;" . $resultat;

						// Echantillon inanalysable
						if ($oneAnalyse->decision_grille == "Inanalysable") {
							$SA = "/";
							$resultat = "INA";
						}
					}
				}
				if ($AfficheRapport[0]->cofrac_rapport_meta_269_v3 == 1) $cofrac = "*";
				$revision = $AfficheRapport[0]->revision_rapport_meta_269_v3;
			}

			$type_mesure_echantillon = $oneEchantillon->nom_type_mesure_strategie;
			if (($oneEchantillon->nom_type_mesure_strategie == "Validation processus") || ($oneEchantillon->nom_type_mesure_strategie == "Evaluation initiale processus")) {
				$type_mesure_echantillon = "Stratégie caractérisation processus";
				$resultat = "/";
			}

			// $nom_qualifaction = str_replace('é','e',$oneEchantillon->nom_qualification); 
			// if(($oneEchantillon->nom_methode_prelevement == "NF X 43-050") || ($oneEchantillon->nom_methode_prelevement == "XP X 43-269")){
			// $nom_qualifaction = str_replace('é','e',$oneEchantillon->nom_qualification)." ".$oneEchantillon->nom_methode_prelevement; 
			// }

			// $pdf = "CEAPIC/Rapport/".$oneEchantillon->nom_client."/".str_replace("/", "-",$oneEchantillon->nom_chantier)."/".$nom_qualifaction."/".$oneEchantillon->ref_echantillon."-v".$revision.".pdf";
			$hash = md5($oneEchantillon->id_echantillon . $model0->GetSharingKey());

			$show_class = "show_rapport_echantillon";
			$href = "href";
			if (preg_match("/^VS-/", $oneEchantillon->ref_echantillon)) {
				$show_class = "";
				$href = "";
			}
			?>
				<tr style="background: #E2EFD9;" class="row_echantillon">
					<td style="width: 19%">
						<p class="<?php echo $show_class; ?>" link="<?php echo $oneEchantillon->id_echantillon; ?>" hash="<?php echo $hash; ?>"><span class="<?php echo $href; ?>"><?php echo $oneEchantillon->ref_echantillon . $cofrac; ?></span></a>
					</td>
					<td style="width: 19%"><?php echo str_replace("Exigence réglementaire", "<SUP>R</SUP>", $type_mesure_echantillon); ?></td>
					<td style="width: 19%" class="date_pose"><?php echo date("d-m-Y", strtotime($oneEchantillon->date_pose_presta_echantillon)); ?></td>
					<td style="width: 19%"><?php echo $resultat; ?></td>
					<td style="width: 4%"><?php echo $oneEchantillon->revision_strategie_chantier; ?></td>
				</tr>

		<?php
			$liste_table[] = array('contexte_mesure' => $oneEchantillon->nom_pdf_contexte_mesure_strategie, 'zone' => $oneEchantillon->zone);
			$liste_echantillon[] = array('contexte_mesure' => $oneEchantillon->nom_pdf_contexte_mesure_strategie, 'zone' => $oneEchantillon->zone, 'mesure' => $type_mesure_echantillon);
		} else {
			$type_mesure_echantillon = $oneEchantillon->nom_type_mesure_strategie;
			if (($oneEchantillon->nom_type_mesure_strategie == "Validation processus") || ($oneEchantillon->nom_type_mesure_strategie == "Evaluation initiale processus"))
				$type_mesure_echantillon = "Stratégie caractérisation processus";

			if (($oneEchantillon->commentaire_corbeille_echantillon <> "Erreur de saisie") && ($oneEchantillon->commentaire_corbeille_echantillon <> "Reporté"))
				$liste_echantillon_corbeille[] = array('zone' => $oneEchantillon->zone, 'type_mesure' => $type_mesure_echantillon, 'date_mission' => $oneEchantillon->date_mission, 'date_creation' => $oneEchantillon->date_creation, 'commentaire' => $oneEchantillon->commentaire_corbeille_echantillon, 'id_corbeille' => $oneEchantillon->id_corbeille_echantillon);
		}

		$save_contexte = $oneEchantillon->nom_pdf_contexte_mesure_strategie;
		$save_zone = $oneEchantillon->zone;
	}
		?>

		<?php
		echo "</table>";

		// Commentaire échantillon
		echo "<table class=\"table_gbmnet commentaire_echantillon commentaire_echantillon_" . ($count_table) . "\">";
		echo "</table>";

		if (count($liste_echantillon_corbeille) <> 0) {
			echo "<table class=\"table_gbmnet\">";
			echo "<tr><td colspan='6' class='titre_contexte'><span>Mesures commandées mais non réalisées</span></td></tr>";
			echo "<tr><td>Zone</td><td>Type</td><td>Date mission</td><td>Date supression</td><td>Commentaire</td></tr>";
			foreach ($liste_echantillon_corbeille as $oneEchantillonCorbeille) {
				$commentaire = $oneEchantillonCorbeille['commentaire'];
				echo "<tr style=\"background: #FFF2CC;\">";
				echo "<td>" . $oneEchantillonCorbeille['zone'] . "</td>";
				echo "<td>" . str_replace("Exigence réglementaire", "<SUP>R</SUP>", $oneEchantillonCorbeille['type_mesure']) . "</td>";
				echo "<td>" . date("d/m/Y", strtotime($oneEchantillonCorbeille['date_mission'])) . "</td>";
				echo "<td>" . date("d/m/Y", strtotime($oneEchantillonCorbeille['date_creation'])) . "</td>";
				echo "<td>" . $commentaire . "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		unset($liste_echantillon_corbeille);
		echo "</div>";
		echo "</div>";


		$PhaseZone = "";
		// foreach($model->ListeSynthetiqueTableStrategieChantier($oneStrategie->id_strategie_chantier) as $onePhaseZone){
		foreach ($model->ListeSynthetiqueStrategieChantier($oneStrategie->id_strategie_chantier) as $onePhaseZone) {
			$detect_phase_zone = 0;
			// foreach($liste_table as $oneTable){
			foreach ($liste_echantillon as $oneEchantillon) {
				if (($onePhaseZone->nom_pdf_contexte_mesure_strategie == $oneEchantillon['contexte_mesure']) && ($onePhaseZone->zone == $oneEchantillon['zone']) && ($onePhaseZone->mesure == $oneEchantillon['mesure']))
					$detect_phase_zone = 1;
			}
			if ($detect_phase_zone == 0) {
				$mesure = str_replace("Exigence réglementaire", "<SUP>R</SUP>", $onePhaseZone->mesure);
				if (($mesure == "Validation processus") || ($mesure == "Evaluation initiale processus"))
					$mesure = "Stratégie caractérisation processus";

				$PhaseZone .=  '<tr style="background: #F2D7D5;" class="mesure_to_command">';
				$PhaseZone .= '<td><input value="' . $onePhaseZone->id_contexte_mesure_strategie . '" class="hide id_contexte" />' . $onePhaseZone->nom_pdf_contexte_mesure_strategie . '</td>';
				$PhaseZone .= '<td>' . $onePhaseZone->zone . '</td>';
				$PhaseZone .= '<td>' . $mesure . '</td>';
				$PhaseZone .= '<td>' . $onePhaseZone->frequence . '</td>';
				$PhaseZone .= '<td>' . $onePhaseZone->nbr_mesure . '</td>';
				$PhaseZone .= '</tr>';
			}
		}

		if ($PhaseZone <> "") {
			echo '<table class="table_gbmnet" id="table_to_command">';
			echo '<tr style="background: #F2D7D5;"><td colspan="5" class="titre_contexte"><span>Mesures préconisées par la stratégie mais non encore commandées</span></td></tr>';
			echo '<tr><td>Contexte</td><td>Zone</td><td>Mesure</td><td>Frequence</td><td>Nbr prlvt</td></tr>';
			echo $PhaseZone;
			echo '</table>';
		}
		?>

		<div id="div_message_commande" class="hide"></div>

		<script language="javascript" type="text/javascript">
			jQuery(function() {
				jQuery('.table_echantillon').each(function() {
					if (jQuery(this).find('.row_echantillon').length == 0) jQuery(this).remove();
				});

				jQuery('.h3_zone').each(function() {
					if (jQuery(this).next().find('.table_gbmnet').length == 0) {
						jQuery(this).next().remove();
						jQuery(this).remove();
					}
				});
				jQuery('.h3_zone').each(function() {
					zone = jQuery(this);
					var bigger = [0, ""];
					zone.next().find('.date_pose').each(function() {
						res = jQuery(this).text().split("-");
						date = res[2] + res[1] + res[0];
						if (date > bigger[0]) {
							bigger[0] = date;
							bigger[1] = jQuery(this).text();
						}
					});

					if (bigger[0] > 0) {
						// zone.text(zone.text() + ' - Dernière pose : ' + bigger[1]);
						zone.html('<span>' + zone.text() + '</span><span style="float: right;"> Dernière pose : ' + bigger[1] + '</span>');
					}
				});

				jQuery('.mesure_to_command').each(function() {
					var detect_presence = 0;
					var row = jQuery(this);
					var detect_contexte = 0;
					var facultatif = "row_obligatoire";
					var facultatif_texte = "";
					if (row.find('td:eq(3)').text() == 'Facultatif*') {
						facultatif = "row_facultatif";
						facultatif_texte = " (facultatif)";
					}
					jQuery('.h3_contexte').each(function() {
						var contexte = jQuery(this);
						if (contexte.text() == row.find('td:eq(0)').text()) {
							jQuery(contexte).next().find('.h3_zone').each(function() {
								var zone = jQuery(this);
								if (zone.find('span:eq(0)').text() == row.find('td:eq(1)').text()) {
									detect_presence = 1;
									if (jQuery(zone).next().find('.to_command').length == 0) {
										jQuery(zone).next().append('<table class="table_gbmnet to_command"><tr><td colspan="2" class="titre_contexte"><span>Mesures préconisées par la stratégie mais non encore commandées</span></td></tr><tr><td>Mesure</td><td>Quantité</td></tr><tr class="' + facultatif + '" style="background: #F2D7D5;"><td style="text-align: left;">' + row.find('td:eq(2)').text() + facultatif_texte + '</td><td>' + row.find('td:eq(4)').text() + '</td></tr></table>');
									} else {
										jQuery(zone).next().find('.to_command').append('<tr class="' + facultatif + '" style="background: #F2D7D5;"><td style="text-align: left;">' + row.find('td:eq(2)').text() + facultatif_texte + '</td><td>' + row.find('td:eq(4)').text() + '</td></tr>');
									}

									row.remove();
								}
							});

							if (detect_presence == 0) {
								jQuery(contexte).next().append('<h3 class="h3_zone"><span>' + row.find('td:eq(1)').text() + '</span></h3><div><table class="table_gbmnet to_command"><tr><td colspan="2" class="titre_contexte"><span>Mesures préconisées par la stratégie mais non encore commandées</span></td></tr><tr><td>Mesure</td><td>Quantité</td></tr><tr class="' + facultatif + '" style="background: #F2D7D5;"><td style="text-align: left;">' + row.find('td:eq(2)').text() + facultatif_texte + '</td><td>' + row.find('td:eq(4)').text() + '</td></tr></table></div>');
								row.remove();
							}
							detect_contexte = 1;
						}
					});

					// Si aucun contexte, on le créer ============================================================================================
					if (detect_contexte == 0) {
						// Range le contexte au bon endroit ============================================================================================
						var added = 0;
						jQuery('.h3_contexte').each(function() {
							if (added == 0) {
								if (jQuery(this).attr("id_contexte") > row.find('.id_contexte').val()) {
									jQuery(this).before('<h3 class="h3_contexte" id_contexte="' + row.find('.id_contexte').val() + '">' + row.find('td:eq(0)').text() + '</h3><div><h3 class="h3_zone">' + row.find('td:eq(1)').text() + '</h3><div><table class="table_gbmnet to_command"><tr><td colspan="2" class="titre_contexte">Mesures préconisées par la stratégie mais non encore commandées</td></tr><tr><td>Mesure</td><td>Quantité</td></tr><tr class="' + facultatif + '" style="background: #F2D7D5;"><td style="text-align: left;">' + row.find('td:eq(2)').text() + facultatif_texte + '</td><td>' + row.find('td:eq(4)').text() + '</td></tr></table></div></div>');
									added = 1;
									row.remove();
								}
							}
						});

						// Si c'est le dernier contexte ============================================================================================
						if (added == 0) {
							jQuery('.h3_contexte:LAST').next().after('<h3 class="h3_contexte" id_contexte="' + row.find('.id_contexte').val() + '">' + row.find('td:eq(0)').text() + '</h3><div><h3 class="h3_zone">' + row.find('td:eq(1)').text() + '</h3><div><table class="table_gbmnet to_command"><tr><td colspan="2" class="titre_contexte">Mesures préconisées par la stratégie mais non encore commandées</td></tr><tr><td>Mesure</td><td>Quantité</td></tr><tr class="' + facultatif + '" style="background: #F2D7D5;"><td style="text-align: left;">' + row.find('td:eq(2)').text() + facultatif_texte + '</td><td>' + row.find('td:eq(4)').text() + '</td></tr></table></div></div>');
							row.remove();
						}

						// Si aucun contexte il le créer ============================================================================================
						if (jQuery('.h3_contexte').length == 0) {
							jQuery('#notaccordion-done').append('<h3 class="h3_contexte" id_contexte="' + row.find('.id_contexte').val() + '">' + row.find('td:eq(0)').text() + '</h3><div><h3 class="h3_zone">' + row.find('td:eq(1)').text() + '</h3><div><table class="table_gbmnet to_command"><tr><td colspan="2" class="titre_contexte">Mesures préconisées par la stratégie mais non encore commandées</td></tr><tr><td>Mesure</td><td>Quantité</td></tr><tr class="' + facultatif + '" style="background: #F2D7D5;"><td style="text-align: left;">' + row.find('td:eq(2)').text() + facultatif_texte + '</td><td>' + row.find('td:eq(4)').text() + '</td></tr></table></div></div>');
							row.remove();
						}
					}
				});

				jQuery('#table_to_command').remove();
				// jQuery('#table_to_command').hide();

				jQuery.fn.togglepanels = function() {
					return this.each(function() {
						jQuery(this).addClass("ui-accordion ui-accordion-icons ui-widget ui-helper-reset")
							.find("h3")
							.addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-corner-bottom")
							.hover(function() {
								$(this).toggleClass("ui-state-hover");
							})
							.prepend('<span class="ui-icon ui-icon-triangle-1-e"></span>')
							.click(function() {
								if (jQuery(this).next().find('.add_reservation:checked').length > 0) {
									if (jQuery(this).next().find('.add_reservation:checked').length == 1)
										alert('Veuillez décocher la mesure pour fermer cette section');
									if (jQuery(this).next().find('.add_reservation:checked').length > 1)
										alert('Veuillez décocher les mesures pour fermer cette section');
								} else {
									jQuery(this)
										.toggleClass("ui-accordion-header-active ui-state-active ui-state-default ui-corner-bottom")
										.find("> .ui-icon").toggleClass("ui-icon-triangle-1-e ui-icon-triangle-1-s").end()
										.next().slideToggle();
									return false;
								}
							})
							.next()
							.addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom")
							.hide();

						jQuery(this).find('.red_tab').removeClass("red_tab").addClass("red_tab");
					});
				};

				jQuery("#notaccordion-done").find(".h3_zone").each(function() {
					if (jQuery(this).next().find('.row_obligatoire').length > 0) jQuery(this).removeClass("white_tab").removeClass("red_tab").addClass("red_tab");
					if ((jQuery(this).next().find('.row_facultatif').length > 0) && (jQuery(this).next().find('.row_obligatoire').length == 0)) jQuery(this).removeClass("white_tab").removeClass("red_tab").addClass("white_tab");
				});

				jQuery("#notaccordion-done").togglepanels();
			});
		</script>