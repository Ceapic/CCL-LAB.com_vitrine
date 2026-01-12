<?php
?>
<STYLE>
	.hide {
		display: none;
	}

	#table_rapport .colonne1,
	#table_rapport .colonne3 {
		width: 10%;
	}

	#table_rapport .colonne4 {
		width: 25%;
	}

	#table_rapport .colonne2 {
		width: 55%;
	}

	#ref_ech {
		cursor: pointer;
		color: #0093FF;
	}

	#ref_ech:hover {
		cursor: pointer;
		color: #0000FF;
	}
</STYLE>


<div>
	<table id="table_rapport" class="table table-striped table-bordered" style="width: 100%;">
		<thead>
			<tr>
				<th class="filter2" sizeinput="130" type="input">Ref échantillon</th>
				<th class="filter2" sizeinput="400" type="select">Type de mesure</th>
				<th class="filter2" sizeinput="100" type="input">Date de pose</th>
				<th class="filter2" sizeinput="100" type="input">Résultat</th>
			</tr>
			<tr>
				<th>Ref échantillon</th>
				<th>Type de mesure</th>
				<th>Date de pose</th>
				<th>Résultat</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$Rapports = $model0->ListeRapportChantier($id_chantier);

			foreach ($Rapports as $i => $oneRapport) {
				$resultat = "";
				if ($Rapports[$i + 1]->id_echantillon <> $oneRapport->id_echantillon) {
					$hash = md5($oneRapport->rapport . $model0->GetSharingKey());

					$type_mesure_echantillon = $oneRapport->affichage_rapport_detail_type_presta;
					if (($oneRapport->affichage_rapport_detail_type_presta == "Validation processus") || ($oneRapport->affichage_rapport_detail_type_presta == "Evaluation initiale processus")) {
						$type_mesure_echantillon = "Stratégie caractérisation processus";
						$resultat = "/";
					}

					$resultat = "";
					$oneRapport2 = $modelStrategie->AfficheTypeRapport($oneRapport->id_echantillon);
					// var_dump($oneRapport->id_echantillon);
					if ($oneRapport2->type == "MEST") {

						$Analyses = $modelSynthese->AfficheAnalyseEchantillonMEST($oneRapport->id_echantillon, 1);
						$resultat = $Analyses[0]->ph_analyse_mest;
						if (count($Analyses) != 0) {
							if (
								isset($Analyses[0]->masse_filtre_pese_finale_analyse_mest)
								&& isset($Analyses[0]->masse_filtre_pese_initiale_analyse_mest)
								&& isset($Analyses[0]->volume_liquide_filtration_analyse_mest)
							) {
								$Concentration = round((((str_replace(",", ".", $Analyses[0]->masse_filtre_pese_finale_analyse_mest) - str_replace(",", ".", $AfficheRapport[0]->masse_filtre_pese_initiale_rapport_mest)) * 1000) / str_replace(",", ".", $AfficheRapport[0]->volume_liquide_filtration_rapport_mest)), 1);
								if ($Concentration <= 5) {
									$Concentration = "&lt; 5";
								} else {
									$Concentration = number_format($Concentration, 1, ".", "");
								}
								$resultat = "pH " . $resultat . " - C: " . $Concentration . " mg/L";
								$revision = $Analyses[0]->revision_analyse_mest;
							} else {
								echo "manque de donner";
							}
						} else {
							$AfficheRapport = $modelSynthese->AfficheRapportEchantillonMEST($oneRapport->id_echantillon);
							$resultat = $AfficheRapport[0]->ph_rapport_mest;

							if (
								isset($AfficheRapport[0]->masse_filtre_pese_finale_rapport_mest)
								&& isset($AfficheRapport[0]->masse_filtre_pese_initiale_rapport_mest)
								&& isset($AfficheRapport[0]->volume_liquide_filtration_rapport_mest)
							) {
								$Concentration = round((((str_replace(",", ".", $AfficheRapport[0]->masse_filtre_pese_finale_rapport_mest) - str_replace(",", ".", $AfficheRapport[0]->masse_filtre_pese_initiale_rapport_mest)) * 1000) / str_replace(",", ".", $AfficheRapport[0]->volume_liquide_filtration_rapport_mest)), 1);
								if ($Concentration <= 5) {
									$Concentration = "&lt; 5";
								} else {
									$Concentration = number_format($Concentration, 1, ".", "");
								}
								$resultat = "pH " . $resultat . " - C: " . $Concentration . " mg/L";
								$revision = $AfficheRapport[0]->revision_rapport_mest;
							} else {
								// die("no data found");
								echo "manque de donner";
							}
						}
					}

					$cofrac = "";

					if ($oneRapport2->type == "META1") {

						$AfficheRapport = $modelSynthese->AfficheRapportEchantillonMETA11($oneRapport->id_echantillon);
						if ($oneRapport2->analyse_echantillon == 2) {
							$resultat = $AfficheRapport[0]->resultat_concentration_rapport_meta_1;
							if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_1 == 1)
								$resultat = "&lt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_1;
							if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_1 == 2)
								$resultat = "&gt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_1;
						} else {
							$Analyses = $modelSynthese->AfficheAnalyseEchantillonMETA1($oneRapport->id_echantillon, 1);
							$oneAnalyse = $Analyses[0];
							if ($oneAnalyse->nombre_fibre_analyse_meta_1 > 3) {
								$resultat = number_format($modelSynthese->concentration_normalisee($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1), 2, ',', '') . " f/L";
							} else {
								$resultat = "&lt;" . number_format($modelSynthese->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $modelSynthese->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 2, ',', '') . " f/L";
							}
						}
						if ($AfficheRapport[0]->cofrac_rapport_meta_1 == 1) $cofrac = "*";
						$revision = $AfficheRapport[0]->revision_rapport_meta_1;
					}

					if ($oneRapport2->type == "META050") {

						$AfficheRapport = $modelSynthese->AfficheRapportEchantillonMETA050($oneRapport->id_echantillon);

						if ($oneRapport2->analyse_echantillon == 2) {
							$resultat = $AfficheRapport[0]->resultat_concentration_rapport_meta_050;
							if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_050 == 1)
								$resultat = "&lt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_050;
							if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_050 == 2)
								$resultat = "&gt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_050;
						} else {
							$Analyses = $modelSynthese->AfficheAnalyseEchantillonMETA1($oneRapport->id_echantillon, 1);
							if (count($Analyses) <> 0) {
								$oneAnalyse = $Analyses[0];
								if ($oneAnalyse->nombre_fibre_analyse_meta_1 > 3) {
									$resultat = number_format($modelSynthese->concentration_normalisee($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1), 2, ',', '') . " f/L";
								} else {
									$resultat = "&lt;" . number_format($modelSynthese->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $modelSynthese->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 2, ',', '') . " f/L";
								}
							}

							$Analyses = $modelSynthese->getAnalysesEchantillonMETAv1($oneRapport->id_echantillon, 1);

							if (count($Analyses) != 0) {
								$oneAnalyse = $Analyses[0];
								$resultat = number_format($oneAnalyse->concentration_normalise, 1, ",", "");
								$nombre_fibre = str_replace(".", ",", $oneAnalyse->nbr_fibres);
								if ($nombre_fibre < 4) {
									$resultat = "&lt;" . $resultat;
								}
								if ($oneAnalyse->cofrac == 1) {
									$cofrac = "*";
								}
							}

							$Analyses = $modelSynthese->AfficheAnalyseEchantillonMETAv0($oneRapport->id_echantillon, 1);

							if (count($Analyses) <> 0) {
								$oneAnalyse = $Analyses[0];
								$nombre_fibre = str_replace(".", ",", $oneAnalyse->nombre_fibre_analyse_meta_v0);
								$resultat = number_format($oneAnalyse->concentration_normalise_concentration_analyse_meta_v0, 1, ",", "");
								if ($nombre_fibre < 4) $resultat = "&lt;" . $resultat;

								// Echantillon inanalysable
								$Prepa = $modelSynthese->AfficheDernierePrepaMETAv0($oneAnalyse->id_analyse_meta_v0);
								$lastPrepa = $Prepa[0];
								if (($lastPrepa->decision_anomalie_grille_analyse_meta_v0_prepa == "Echantillon inanalysable") || ($oneAnalyse->decision_anomalie_reception_analyse_meta_v0 == "Echantillon inanalysable")) {
									$resultat = "INA";
								}
							}
						}
						if ($AfficheRapport[0]->cofrac_rapport_meta_050 == 1) $cofrac = "*";
						$revision = $AfficheRapport[0]->revision_rapport_meta_050;
					}

					if ($oneRapport2->type == "META269") {
						$AfficheRapport = $modelSynthese->AfficheRapportEchantillonMETA269($oneRapport->id_echantillon);
						if ($oneRapport2->analyse_echantillon == 2) {
							$resultat = $AfficheRapport[0]->resultat_concentration_rapport_meta_269;
							if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269 == 1)
								$resultat = "&lt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269;
							if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269 == 2)
								$resultat = "&gt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269;
						} else {
							$Analyses = $modelSynthese->AfficheAnalyseEchantillonMETA1($oneRapport->id_echantillon, 1);
							$oneAnalyse = $Analyses[0];
							if ($oneAnalyse->nombre_fibre_analyse_meta_1 > 3) {
								$resultat = number_format($modelSynthese->concentration_normalisee($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1), 2, ',', '') . " f/L";
							} else {
								$resultat = "&lt;" . number_format($modelSynthese->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $modelSynthese->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 2, ',', '') . " f/L";
							}
						}
						if ($AfficheRapport[0]->cofrac_rapport_meta_269 == 1) $cofrac = "*";
						$revision = $AfficheRapport[0]->revision_rapport_meta_269;
					}

					if ($oneRapport2->type == "META269v2") {
						$AfficheRapport = $modelSynthese->AfficheRapportEchantillonMETA269v2($oneRapport->id_echantillon);
						if ($oneRapport2->analyse_echantillon == 2) {
							$resultat = $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v2;
							if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269_v2 == 1)
								$resultat = "&lt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v2;
							if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269_v2 == 2)
								$resultat = "&gt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v2;
						} else {
							$Analyses = $modelSynthese->AfficheAnalyseEchantillonMETA1($oneRapport->id_echantillon, 1);
							if (count($Analyses) <> 0) {
								$oneAnalyse = $Analyses[0];
								if ($oneAnalyse->nombre_fibre_analyse_meta_1 > 3) {
									$resultat = number_format($modelSynthese->concentration_normalisee($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1), 2, ',', '') . " f/L";
								} else {
									$resultat = "&lt;" . number_format($modelSynthese->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $modelSynthese->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 2, ',', '') . " f/L";
								}
							}

							$Analyses = $modelSynthese->AfficheAnalyseEchantillonMETAv0($oneRapport->id_echantillon, 1);
							if (count($Analyses) <> 0) {
								$oneAnalyse = $Analyses[0];
								$nombre_fibre = str_replace(".", ",", $oneAnalyse->nombre_fibre_analyse_meta_v0);
								$resultat = number_format($oneAnalyse->concentration_normalise_concentration_analyse_meta_v0, 1, ",", "");
								if ($nombre_fibre < 4) $resultat = "&lt;" . $resultat;

								// Echantillon inanalysable
								$Prepa = $modelSynthese->AfficheDernierePrepaMETAv0($oneAnalyse->id_analyse_meta_v0);
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

					if ($oneRapport2->type == "META269v3") {

						$AfficheRapport = $modelSynthese->AfficheRapportEchantillonMETA269v3($oneRapport->id_echantillon);

						if ($oneRapport2->analyse_echantillon == 2) {
							echo "test meta269v3";
							$resultat = $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v3;
							if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269_v3 == 1)
								$resultat = "&lt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v3;
							if ($AfficheRapport[0]->signe_resultat_concentration_rapport_meta_269_v3 == 2)
								$resultat = "&gt; " . $AfficheRapport[0]->resultat_concentration_rapport_meta_269_v3;
						} else {
							$Analyses = $modelSynthese->AfficheAnalyseEchantillonMETA1($oneRapport->id_echantillon, 1);

							if (count($Analyses) <> 0) {
								$oneAnalyse = $Analyses[0];
								if ($oneAnalyse->nombre_fibre_analyse_meta_1 > 3) {
									$resultat = number_format($modelSynthese->concentration_normalisee($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1), 2, ',', '') . " f/L";
								} else {
									$resultat = "&lt;" . number_format($modelSynthese->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $modelSynthese->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 2, ',', '') . " f/L";
								}
							}

							$Analyses = $modelSynthese->AfficheAnalyseEchantillonMETAv0($oneRapport->id_echantillon, 1);

							if (count($Analyses) <> 0) {
								$oneAnalyse = $Analyses[0];
								$nombre_fibre = str_replace(".", ",", $oneAnalyse->nombre_fibre_analyse_meta_v0);
								$resultat = number_format($oneAnalyse->concentration_normalise_concentration_analyse_meta_v0, 1, ",", "");
								if ($nombre_fibre < 4) $resultat = "&lt;" . $resultat;

								// Echantillon inanalysable
								$Prepa = $modelSynthese->AfficheDernierePrepaMETAv0($oneAnalyse->id_analyse_meta_v0);
								$lastPrepa = $Prepa[0];
								if (($lastPrepa->decision_anomalie_grille_analyse_meta_v0_prepa == "Echantillon inanalysable") || ($oneAnalyse->decision_anomalie_reception_analyse_meta_v0 == "Echantillon inanalysable")) {
									$SA = "/";
									$resultat = "INA";
								}
							}

							$Analyses = $modelSynthese->getAnalysesEchantillonMETAv1($oneRapport->id_echantillon, 1);

							if (count($Analyses) != 0) {
								$oneAnalyse = $Analyses[0];
								$resultat = number_format($oneAnalyse->concentration_normalise, 1, ",", "");
								$nombre_fibre = str_replace(".", ",", $oneAnalyse->nbr_fibres);
								if ($nombre_fibre < 4) {
									$resultat = "&lt;" . $resultat;
								}
								if ($oneAnalyse->cofrac == 1) {
									$cofrac = "*";
								}
							}
						}
						if ($AfficheRapport[0]->cofrac_rapport_meta_269_v3 == 1) $cofrac = "*";
						$revision = $AfficheRapport[0]->revision_rapport_meta_269_v3;
					}

					if ($oneRapport->type == "LIXIVIATION") {
						$AfficheRapport = $modelSynthese->AfficheRapportEchantillonLixiviation($oneRapport->id_echantillon);
						$resultat = str_replace(">", "&gt;", str_replace("<", "&lt;", str_replace(".", ",", $AfficheRapport[0]->quantite_rapport_lixiviation))) . " mg/kg";
					}

					if ($oneRapport->type == "ECAILLE_PEINTURE") {
						$AfficheRapport = $modelSynthese->AfficheRapportEchantillonEcaillePeinture($oneRapport->id_echantillon);
						$resultat = str_replace(">", "&gt;", str_replace("<", "&lt;", str_replace(".", ",", $AfficheRapport[0]->concentration_rapport_ecaille_peinture))) . " mg/g";
					}

					if ($oneRapport->type == "AIR_PLOMB") {
						$AfficheRapport = $modelSynthese->AfficheRapportEchantillonAirPlomb($oneRapport->id_echantillon);
						$resultat = "CPb : " . str_replace(">", "&gt;", str_replace("<", "&lt;", str_replace(".", ",", $AfficheRapport[0]->concentration_rapport_air_plomb))) . " / Cx : " . str_replace(">", "&gt;", str_replace("<", "&lt;", str_replace(".", ",", $AfficheRapport[0]->concentration_mesuree_rapport_air_plomb)));
					}

					if ($oneRapport->type == "LINGETTE_PLOMB") {
						$AfficheRapport = $modelSynthese->AfficheRapportEchantillonLingettePlomb($oneRapport->id_echantillon);
						$resultat = $AfficheRapport[0]->concentration_surfacique_rapport_lingette_plomb;
					}

					if ($oneRapport->type == "ACR") {
						$AfficheRapport = $modelSynthese->AfficheRapportEchantillonACR($oneRapport->id_echantillon);
						$o2_resultat_mesure_rapport_acr = $AfficheRapport[0]->o2_resultat_mesure_rapport_acr;
						$o2_resultat_mesure_rapport_acr = str_replace("&lt;", "<", $o2_resultat_mesure_rapport_acr);
						$o2_resultat_mesure_rapport_acr = str_replace("&gt;", ">", $o2_resultat_mesure_rapport_acr);

						$co_resultat_mesure_rapport_acr = $AfficheRapport[0]->co_resultat_mesure_rapport_acr;
						$co_resultat_mesure_rapport_acr = str_replace("&lt;", "<", $co_resultat_mesure_rapport_acr);
						$co_resultat_mesure_rapport_acr = str_replace("&gt;", ">", $co_resultat_mesure_rapport_acr);

						$co2_resultat_mesure_rapport_acr = $AfficheRapport[0]->co2_resultat_mesure_rapport_acr;
						$co2_resultat_mesure_rapport_acr = str_replace("&lt;", "<", $co2_resultat_mesure_rapport_acr);
						$co2_resultat_mesure_rapport_acr = str_replace("&gt;", ">", $co2_resultat_mesure_rapport_acr);

						$eau_liquide_resultat_mesure_rapport_acr = $AfficheRapport[0]->eau_liquide_resultat_mesure_rapport_acr;
						$eau_liquide_resultat_mesure_rapport_acr = str_replace("&lt;", "<", $eau_liquide_resultat_mesure_rapport_acr);
						$eau_liquide_resultat_mesure_rapport_acr = str_replace("&gt;", ">", $eau_liquide_resultat_mesure_rapport_acr);

						$vapeur_eau_resultat_mesure_rapport_acr = $AfficheRapport[0]->vapeur_eau_resultat_mesure_rapport_acr;
						$vapeur_eau_resultat_mesure_rapport_acr = str_replace("&lt;", "<", $vapeur_eau_resultat_mesure_rapport_acr);
						$vapeur_eau_resultat_mesure_rapport_acr = str_replace("&gt;", ">", $vapeur_eau_resultat_mesure_rapport_acr);

						$lubrifiant_resultat_mesure_rapport_acr = $AfficheRapport[0]->lubrifiant_resultat_mesure_rapport_acr;
						$lubrifiant_resultat_mesure_rapport_acr = str_replace("&lt;", "<", $lubrifiant_resultat_mesure_rapport_acr);
						$lubrifiant_resultat_mesure_rapport_acr = str_replace("&gt;", ">", $lubrifiant_resultat_mesure_rapport_acr);

						$odeur_gout_resultat_mesure_rapport_acr = $AfficheRapport[0]->odeur_gout_resultat_mesure_rapport_acr;
						$odeur_gout_resultat_mesure_rapport_acr = str_replace("&lt;", "<", $odeur_gout_resultat_mesure_rapport_acr);
						$odeur_gout_resultat_mesure_rapport_acr = str_replace("&gt;", ">", $odeur_gout_resultat_mesure_rapport_acr);
						$resultat = "O2 : " . $o2_resultat_mesure_rapport_acr . "<br>CO : " . $co_resultat_mesure_rapport_acr . "<br>CO2 : " . $co2_resultat_mesure_rapport_acr . "<br>Eau liquide : " . $eau_liquide_resultat_mesure_rapport_acr . "<br>Vapeur d'eau : " . $vapeur_eau_resultat_mesure_rapport_acr . "<br>Lubrifiant : " . $lubrifiant_resultat_mesure_rapport_acr . "<br>Odeur et goût : " . $odeur_gout_resultat_mesure_rapport_acr;
					}

					// if($oneRapport->type == "LINGETTE"){
					// $AfficheRapport = $modelSynthese->AfficheRapportEchantillonLingettePlomb($oneRapport->id_echantillon);
					// $resultat = $AfficheRapport[0]->concentration_surfacique_rapport_lingette_plomb;
					// }

					echo '
				<tr>
					<td class="colonne1"><p class="show_rapport" linkechantillon="' . $oneRapport->id_echantillon . '" linkrapport="' . $oneRapport->rapport . '" hash="' . $hash . '"><span id ="ref_ech" class="href">' . $oneRapport->ref_echantillon . ' v' . $oneRapport->revision . '</span></p></td>
					<td class="colonne2">' . str_replace("Exigence réglementaire", "<SUP>R</SUP>", $type_mesure_echantillon) . '</td>
					<td class="colonne3">' . date("d-m-Y", strtotime($oneRapport->date_pose_presta_echantillon)) . '</td>
					<td class="colonne4">' . $resultat . '</td>
				</tr>';
				}
			}
			?>
		</tbody>
	</table>
</div>

<script language="javascript" type="text/javascript">
	// =============================================
	// Chantiers filter
	// =============================================

	// Setup - add a text input to each footer cell
	jQuery('.filter2').each(function(e) {
		var title = jQuery(this).text();
		var sizeinput = jQuery(this).attr("sizeinput");
		var type = jQuery(this).attr("type");

		if (type == "input")
			jQuery(this).html('<input type="text" placeholder="' + title + '" linkcolumn=' + e + ' style="width:' + sizeinput + 'px;"/>');

		if (type == "select")
			jQuery(this).html('<select linkcolumn=' + e + ' style="width:' + sizeinput + 'px;"><option value=""></option></select>');
	});

	// DataTable
	var table2 = jQuery('#table_rapport').DataTable({
		"pageLength": 25,
		"order": [],
		"lengthChange": false,
		"info": false,
		"language": {
			"paginate": {
				"first": "Première",
				"last": "Dernière",
				"next": "Suivant",
				"previous": "Précédent"
			},
			"zeroRecords": "Aucun résultat",
			"info": "_PAGE_ / _PAGES_",
			"infoEmpty": "Aucun résultat",
			"infoFiltered": "(filtered from _MAX_ total records)"
		}
	});

	jQuery('.filter2 select').each(function() {
		var column = jQuery(this).attr("linkcolumn");
		var select = jQuery(this);
		table2.column(column).data().unique().sort().each(function(d, j) {
			select.append('<option value="' + d + '">' + d + '</option>')
		});
	});

	jQuery('.filter2 input').on('keyup', function() {
		var column = jQuery(this).attr("linkcolumn");
		table2
			.columns(column)
			.search(this.value)
			.draw();
	});

	jQuery('.filter2 select').on('change', function() {
		var column = jQuery(this).attr("linkcolumn");
		table2
			.columns(column)
			.search(this.value)
			.draw();
	});
</script>