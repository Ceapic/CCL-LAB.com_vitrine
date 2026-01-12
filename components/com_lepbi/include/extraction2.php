<?php
	$model = $this->getModel('management'); // nom model
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	$filtre = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
				'size'  => 11,
				'name'  => 'Calibri'
		),
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,	
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,			
        ),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THICK
			)
		)
	);
	
	$style_texte_alerte = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FF0000'),
				'size'  => 11,
				'name'  => 'Calibri'
		)
	);
	
	$style_texte_center = array(
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
	);
	
	$style_border = array(
		'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_MEDIUM
			)
		)
	);
	
	$Cell = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
				'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
	
	$i = 0;
	$line = 1;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($Cell[$i++].$line, "Ref chantier")
				->setCellValue($Cell[$i++].$line, "Ref chantier CEAPIC")
				->setCellValue($Cell[$i++].$line, "Date de pose")
				->setCellValue($Cell[$i++].$line, "Ref échantillon")
				->setCellValue($Cell[$i++].$line, "Issu de stratégie")
				->setCellValue($Cell[$i++].$line, "Adresse")			
				->setCellValue($Cell[$i++].$line, "Code postal")	
				->setCellValue($Cell[$i++].$line, "Ville")
				->setCellValue($Cell[$i++].$line, "Type")
				->setCellValue($Cell[$i++].$line, "Objectif")	
				->setCellValue($Cell[$i++].$line, "Zone de prélèvement")	
				->setCellValue($Cell[$i++].$line, "Activité")
				->setCellValue($Cell[$i++].$line, "Lieu de travail")
				->setCellValue($Cell[$i++].$line, "Ref processus")	
				->setCellValue($Cell[$i++].$line, "Matériaux")	
				->setCellValue($Cell[$i++].$line, "Technique")	
				->setCellValue($Cell[$i++].$line, "MPC")	
				->setCellValue($Cell[$i++].$line, "Isolation")
				->setCellValue($Cell[$i++].$line, "Débit moyen (L/min)")
				->setCellValue($Cell[$i++].$line, "Durée du prélèvement (min)")
				->setCellValue($Cell[$i++].$line, "Volume (L)")
				->setCellValue($Cell[$i++].$line, "Date analyse")
				->setCellValue($Cell[$i++].$line, "Fraction")
				->setCellValue($Cell[$i++].$line, "Nb carrée")
				->setCellValue($Cell[$i++].$line, "Nb fibres")
				->setCellValue($Cell[$i++].$line, "Type amiante")
				->setCellValue($Cell[$i++].$line, "Nb filtres")
				->setCellValue($Cell[$i++].$line, "SA (f/L)")
				->setCellValue($Cell[$i++].$line, "Concentration (f/L)")
				->setCellValue($Cell[$i++].$line, "Résultat")
				->setCellValue($Cell[$i++].$line, "Limite inférieur")
				->setCellValue($Cell[$i++].$line, "Limite supérieur");
	$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->applyFromArray($filtre);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->getAlignment()->setWrapText(true);
	
	$ListeEchantillonDate = $model->ListeEchantillonDate($id_client, $id_chantier, date('Y-m-d', strtotime($date_debut))." 00:00:00", date('Y-m-d', strtotime($date_fin))." 23:59:59");
	foreach($ListeEchantillonDate as $oneEchantillon){
		$i = 0;
		$detect_line = 0;
		$detect_meta = 0;
		$detect_fibre = 0;
		
		$issu_strategie = "/";
		$zone_prelevement = "/";
		$activite = "/";
		$lieu_travail = "/";
		$ref_processus = "/";
		$materiaux = "/";
		$technique = "/";
		$mpc = "/";
		$isolation = "/";
		$debit_moyen = "/";
		$duree_prelevement = "/";
		$volume = "/";
		$date_analyse = "/";
		$fraction_filtre = "/";
		$nombre_champ = "/";
		$nombre_fibre = "/";
		$type_fibre = "/";
		$total_filtre = "/";
		$SA_litre = "/";
		$concentration_calculee = "/";
		$resultat = "/";
		$cinf = "/";
		$csup = "/";
		
		$Rapports = $model->AfficheRapportMateriau($oneEchantillon->id_echantillon);
		if(count($Rapports) <> 0){
			$oneRapport = $Rapports[0];
			
			$detect_line = 1;
			
			$issu_strategie = "/";
			$lieu_travail = "/";
			
			$fibre1 ="";
			$fibre2 ="";
			$fibre3 ="";
			
			if ($oneEchantillon->analyse_echantillon == 2){
				$zone_prelevement = $oneRapport->localisation_prelevement_rapport_materiau." - ".$oneRapport->etage_rapport_materiau;
				$date_analyse =  date('d/m/Y', strtotime($oneRapport->date_analyse_rapport_materiau));
				
				if ($oneRapport->nombre_couche_rapport_materiau == 1){
					$TypeFibre1 = "";
					$ResultatAnalyse1 = "";
					if ($oneRapport->resultat_analyse_1_rapport_materiau == 1) $ResultatAnalyse1 = "Présence :"; if ($oneRapport->resultat_analyse_1_rapport_materiau == 2) $ResultatAnalyse1 = "Absence";if ($oneRapport->resultat_analyse_1_rapport_materiau == 3) $ResultatAnalyse1 = "Trace :";
					foreach($model->ListeRapportTypeFibre($oneRapport->id_rapport_materiau, 1) as $oneTypeFibre){
						if ($TypeFibre1 == ""){$separateur = "";}else{$separateur = " - ";}	
						$TypeFibre1 = $TypeFibre1."".$separateur."".$oneTypeFibre->nom_type_fibre;
					}
					if (empty($oneTypeFibre)) $TypeFibre1 = "-";
					$resultat = "P1 ".$ResultatAnalyse1." ".$TypeFibre1;
				}
				if ($oneRapport->nombre_couche_rapport_materiau == 2){
					$TypeFibre1 = "";
					$ResultatAnalyse1 = "";
					if ($oneRapport->resultat_analyse_1_rapport_materiau == 1) $ResultatAnalyse1 = "Présence :"; if ($oneRapport->resultat_analyse_1_rapport_materiau == 2) $ResultatAnalyse1 = "Absence";if ($oneRapport->resultat_analyse_1_rapport_materiau == 3) $ResultatAnalyse1 = "Trace :";
					foreach($model->ListeRapportTypeFibre($oneRapport->id_rapport_materiau, 1) as $oneTypeFibre){
						if ($TypeFibre1 == ""){$separateur = "";}else{$separateur = " - ";}	
						$TypeFibre1 = $TypeFibre1."".$separateur."".$oneTypeFibre->nom_type_fibre;
					}
					if (empty($oneTypeFibre)) $TypeFibre1 = "-";
					$TypeFibre2 = "";
					$ResultatAnalyse2 = "";
					if ($oneRapport->resultat_analyse_2_rapport_materiau == 1) $ResultatAnalyse2 = "Présence :"; if ($oneRapport->resultat_analyse_2_rapport_materiau == 2) $ResultatAnalyse2 = "Absence";if ($oneRapport->resultat_analyse_2_rapport_materiau == 3) $ResultatAnalyse2 = "Trace :";
					foreach($model->ListeRapportTypeFibre($oneRapport->id_rapport_materiau, 2) as $oneTypeFibre){
						if ($TypeFibre2 == ""){$separateur = "";}else{$separateur = " - ";}	
						$TypeFibre2 = $TypeFibre2."".$separateur."".$oneTypeFibre->nom_type_fibre;
					}
					if (empty($oneTypeFibre)) $TypeFibre2 = "-";
					$resultat = "P1 ".$ResultatAnalyse1." ".$TypeFibre1."\nP2 ".$ResultatAnalyse2." ".$TypeFibre2;
				}
				if ($oneRapport->nombre_couche_rapport_materiau == 3){
					$TypeFibre1 = "";
					$ResultatAnalyse1 = "";
					if ($oneRapport->resultat_analyse_1_rapport_materiau == 1) $ResultatAnalyse1 = "Présence :"; if ($oneRapport->resultat_analyse_1_rapport_materiau == 2) $ResultatAnalyse1 = "Absence";if ($oneRapport->resultat_analyse_1_rapport_materiau == 3) $ResultatAnalyse1 = "Trace :";
					foreach($model->ListeRapportTypeFibre($oneRapport->id_rapport_materiau, 1) as $oneTypeFibre){
						if ($TypeFibre1 == ""){$separateur = "";}else{$separateur = " - ";}	
						$TypeFibre1 = $TypeFibre1."".$separateur."".$oneTypeFibre->nom_type_fibre;
					}
					if (empty($oneTypeFibre)) $TypeFibre1 = "-";
					$TypeFibre2 = "";
					$ResultatAnalyse2 = "";
					if ($oneRapport->resultat_analyse_2_rapport_materiau == 1) $ResultatAnalyse2 = "Présence :"; if ($oneRapport->resultat_analyse_2_rapport_materiau == 2) $ResultatAnalyse2 = "Absence";if ($oneRapport->resultat_analyse_2_rapport_materiau == 3) $ResultatAnalyse2 = "Trace :";
					foreach($model->ListeRapportTypeFibre($oneRapport->id_rapport_materiau, 2) as $oneTypeFibre){
						if ($TypeFibre2 == ""){$separateur = "";}else{$separateur = " - ";}	
						$TypeFibre2 = $TypeFibre2."".$separateur."".$oneTypeFibre->nom_type_fibre;
					}
					if (empty($oneTypeFibre)) $TypeFibre2 = "-";
					$TypeFibre3 = "";
					$ResultatAnalyse3 = "";
					if ($oneRapport->resultat_analyse_3_rapport_materiau == 1) $ResultatAnalyse3 = "Présence :"; if ($oneRapport->resultat_analyse_3_rapport_materiau == 2) $ResultatAnalyse3 = "Absence";if ($oneRapport->resultat_analyse_3_rapport_materiau == 3) $ResultatAnalyse3 = "Trace :";
					foreach($model->ListeRapportTypeFibre($oneRapport->id_rapport_materiau, 3) as $oneTypeFibre){
						if ($TypeFibre3 == ""){$separateur = "";}else{$separateur = " - ";}
						$TypeFibre3 = $TypeFibre3."".$separateur."".$oneTypeFibre->nom_type_fibre;
					}
					if (empty($oneTypeFibre)) $TypeFibre3 = "";
					$resultat = "P1 ".$ResultatAnalyse1." ".$TypeFibre1."\nP2 ".$ResultatAnalyse2." ".$TypeFibre2."\nP3 ".$ResultatAnalyse3." ".$TypeFibre3;
				}
				
			}else{
				$Analyses = $model->AfficheAnalyseEchantillonMATERIAU($oneEchantillon->id_echantillon, 1);
				$oneAnalyse = $Analyses[0];
				$zone_prelevement = $oneEchantillon->localisation_echantillon;
				$date_analyse =  date('d/m/Y', strtotime($oneAnalyse->date_analyse_analyse_materiau));
				
				// Couche 1 =======================================
				
				$resultat_analyse1 = "";
				if ($oneAnalyse->conclusion_1_analyse_materiau == 0){
					$resultat_analyse1 = "P1 absence \n";
				}else{
					foreach($model->ListeAnalyseTypeFibreMateriau($oneAnalyse->id_analyse_materiau, 11) as $oneTypeFibre){
						if ($fibre1 == ""){
							$fibre1 = $oneTypeFibre->nom_type_fibre;
						}else{
							$fibre1 = $fibre1." - ".$oneTypeFibre->nom_type_fibre;
						}
					}
					
					foreach($model->ListeAnalyseTypeFibreMateriau($oneAnalyse->id_analyse_materiau, 12) as $oneTypeFibre){
						$checkdoublon = 0;
						$splits = explode("; ", $fibre1);
						foreach ($splits as $oneSplit) {
							if ($oneTypeFibre->nom_type_fibre == $oneSplit)
								$checkdoublon = 1;
						}
						if ($checkdoublon == 0){
							if ($fibre1 == ""){
								$fibre1 = $oneTypeFibre->nom_type_fibre;
							}else{
								$fibre1 = $fibre1." - ".$oneTypeFibre->nom_type_fibre;
							}
						}
					}
					
					foreach($model->ListeAnalyseTypeFibreMateriau($oneAnalyse->id_analyse_materiau, 13) as $oneTypeFibre){
						$checkdoublon = 0;
						$splits = explode("; ", $fibre1);
						foreach ($splits as $oneSplit) {
							if ($oneTypeFibre->nom_type_fibre == $oneSplit)
								$checkdoublon = 1;
						}
						if ($checkdoublon == 0){
							if ($fibre1 == ""){
								$fibre1 = $oneTypeFibre->nom_type_fibre;
							}else{
								$fibre1 = $fibre1." - ".$oneTypeFibre->nom_type_fibre;
							}
						}
					}

					$resultat_analyse1 = "P1 Présence: ".$fibre1."\n";
					$detect_fibre = 1;
				}
				
				// Couche 2 =======================================
				
				$resultat_analyse2 = "";
				if ($oneAnalyse->conclusion_2_analyse_materiau == 0){
					if ($nbrprepa2 <> 0) $resultat_analyse2 = "P2 absence \n";
				}else{
					foreach($model->ListeAnalyseTypeFibreMateriau($oneAnalyse->id_analyse_materiau, 21) as $oneTypeFibre){
						if ($fibre2 == ""){
							$fibre2 = $oneTypeFibre->nom_type_fibre;
						}else{
							$fibre2 = $fibre2." - ".$oneTypeFibre->nom_type_fibre;
						}
					}
					
					foreach($model->ListeAnalyseTypeFibreMateriau($oneAnalyse->id_analyse_materiau, 22) as $oneTypeFibre){
						$checkdoublon = 0;
						$splits = explode("; ", $fibre2);
						foreach ($splits as $oneSplit) {
							if ($oneTypeFibre->nom_type_fibre == $oneSplit)
								$checkdoublon = 1;
						}
						if ($checkdoublon == 0){
							if ($fibre2 == ""){
								$fibre2 = $oneTypeFibre->nom_type_fibre;
							}else{
								$fibre2 = $fibre2." - ".$oneTypeFibre->nom_type_fibre;
							}
						}
					}
					
					foreach($model->ListeAnalyseTypeFibreMateriau($oneAnalyse->id_analyse_materiau, 23) as $oneTypeFibre){
						$checkdoublon = 0;
						$splits = explode("; ", $fibre2);
						foreach ($splits as $oneSplit) {
							if ($oneTypeFibre->nom_type_fibre == $oneSplit)
								$checkdoublon = 1;
						}
						if ($checkdoublon == 0){
							if ($fibre2 == ""){
								$fibre2 = $oneTypeFibre->nom_type_fibre;
							}else{
								$fibre2 = $fibre2." - ".$oneTypeFibre->nom_type_fibre;
							}
						}
					}

					$resultat_analyse2 = "P2 Présence: ".$fibre2."\n";
					$detect_fibre = 1;
				}	
				
				// Couche 3 =======================================
				
				$resultat_analyse3 = "";
				if ($oneAnalyse->conclusion_3_analyse_materiau == 0){
					if ($nbrprepa3 <> 0) $resultat_analyse3 = "P3 absence \n";
				}else{
					foreach($model->ListeAnalyseTypeFibreMateriau($oneAnalyse->id_analyse_materiau, 31) as $oneTypeFibre){
						if ($fibre3 == ""){
							$fibre3 = $oneTypeFibre->nom_type_fibre;
						}else{
							$fibre3 = $fibre3." - ".$oneTypeFibre->nom_type_fibre;
						}
					}
					
					foreach($model->ListeAnalyseTypeFibreMateriau($oneAnalyse->id_analyse_materiau, 32) as $oneTypeFibre){
						$checkdoublon = 0;
						$splits = explode("; ", $fibre3);
						foreach ($splits as $oneSplit) {
							if ($oneTypeFibre->nom_type_fibre == $oneSplit)
								$checkdoublon = 1;
						}
						if ($checkdoublon == 0){
							if ($fibre3 == ""){
								$fibre3 = $oneTypeFibre->nom_type_fibre;
							}else{
								$fibre3 = $fibre3." - ".$oneTypeFibre->nom_type_fibre;
							}
						}
					}
					
					foreach($model->ListeAnalyseTypeFibreMateriau($oneAnalyse->id_analyse_materiau, 33) as $oneTypeFibre){
						$checkdoublon = 0;
						$splits = explode("; ", $fibre3);
						foreach ($splits as $oneSplit) {
							if ($oneTypeFibre->nom_type_fibre == $oneSplit)
								$checkdoublon = 1;
						}
						if ($checkdoublon == 0){
							if ($fibre3 == ""){
								$fibre3 = $oneTypeFibre->nom_type_fibre;
							}else{
								$fibre3 = $fibre3." - ".$oneTypeFibre->nom_type_fibre;
							}
						}
					}

					$resultat_analyse3 = "P3 Présence: ".$fibre3."\n";
					$detect_fibre = 1;
				}
				$resultat = $resultat_analyse1.$resultat_analyse2.$resultat_analyse3;
			}

			// $resultat = "PH : ".$ph." - Conc : ".$Concentration." mg/L";
		}
		
		$Rapports = $model->AfficheRapportMEST($oneEchantillon->id_echantillon);
		if(count($Rapports) <> 0){
			$oneRapport = $Rapports[0];
			
			$detect_line = 1;
			
			$issu_strategie = "/";
			$zone_prelevement = $oneRapport->batiment_rapport_mest." - ".$oneRapport->etage_rapport_mest." - ".$oneRapport->designation_rapport_mest;
			$lieu_travail = "/";
			if ($oneRapport->localisation_prelevement_rapport_mest == 1)
				$lieu_travail = "Rejet eau de sas personnel";
			if ($oneRapport->localisation_prelevement_rapport_mest == 2)
				$lieu_travail = "Rejet eau de sas matériel";
			if ($oneRapport->localisation_prelevement_rapport_mest == 0)
				$lieu_travail = $oneRapport->localisation_prelevement_texte_rapport_mest;
				
			if ($oneRapport->remarque_prelevement_rapport_mest == 1)
				$lieu_travail = $lieu_travail." - "."Après douche de décontamination";
			if ($oneRapport->remarque_prelevement_rapport_mest == 2)
				$lieu_travail = $lieu_travail." - "."Avant douche de décontamination";
			if ($oneRapport->remarque_prelevement_rapport_mest == 0)
				$lieu_travail = $lieu_travail." - ".$oneRapport->remarque_prelevement_texte_rapport_mest;
			
			if ($oneEchantillon->analyse_echantillon == 2){
				$date_analyse =  date('d/m/Y', strtotime($oneRapport->date_analyse_rapport_mest));
				$ph = $oneRapport->ph_rapport_mest;
				$Concentration = round((((str_replace(",", ".", $oneRapport->masse_filtre_pese_finale_rapport_mest) - str_replace(",", ".", $oneRapport->masse_filtre_pese_initiale_rapport_mest)) * 1000) / str_replace(",", ".", $oneRapport->volume_liquide_filtration_rapport_mest)), 1);
				if ($Concentration <= 2){
					$Concentration = "< 2";
				}else{
					$Concentration = number_format($Concentration, 1, ".", "");
				}
			}else{
				$Analyses = $model->AfficheAnalyseEchantillonMEST($oneEchantillon->id_echantillon, 1);
				$oneAnalyse = $Analyses[0];
				
				$date_analyse =  date('d/m/Y', strtotime($oneAnalyse->date_analyse_analyse_mest));
				$ph_rapport_mest = $oneAnalyse->ph_analyse_mest;
				
				$Concentration = round((((str_replace(",", ".", $oneAnalyse->masse_filtre_pese_finale_analyse_mest) - str_replace(",", ".", $oneAnalyse->masse_filtre_pese_initiale_analyse_mest)) * 1000) / str_replace(",", ".", $oneAnalyse->volume_liquide_filtration_analyse_mest)), 1);
				if ($Concentration <= 2){
					$Concentration = "< 2";
				}else{
					$Concentration = number_format($Concentration, 1, ".", "");
				}
			}

			$resultat = "PH : ".$ph." - Conc : ".$Concentration." mg/L";
		}
		
		$Rapports = $model->AfficheRapportACR($oneEchantillon->id_echantillon);
		if(count($Rapports) <> 0){
			$oneRapport = $Rapports[0];
			
			$detect_line = 1;
			
			$issu_strategie = "/";
			$zone_prelevement = $oneRapport->localisation_mesure_rapport_acr;
			$lieu_travail = "/";
			
			$date_analyse = date('d/m/Y', strtotime($oneRapport->date_mesure_rapport_acr));
			
			$o2_resultat_mesure_rapport_acr = $oneRapport->o2_resultat_mesure_rapport_acr;
			$o2_resultat_mesure_rapport_acr = str_replace("&lt;","<",$o2_resultat_mesure_rapport_acr);
			$o2_resultat_mesure_rapport_acr = str_replace("&gt;",">",$o2_resultat_mesure_rapport_acr);
			
			$co_resultat_mesure_rapport_acr = $oneRapport->co_resultat_mesure_rapport_acr;
			$co_resultat_mesure_rapport_acr = str_replace("&lt;","<",$co_resultat_mesure_rapport_acr);
			$co_resultat_mesure_rapport_acr = str_replace("&gt;",">",$co_resultat_mesure_rapport_acr);
			
			$co2_resultat_mesure_rapport_acr = $oneRapport->co2_resultat_mesure_rapport_acr;
			$co2_resultat_mesure_rapport_acr = str_replace("&lt;","<",$co2_resultat_mesure_rapport_acr);
			$co2_resultat_mesure_rapport_acr = str_replace("&gt;",">",$co2_resultat_mesure_rapport_acr);
			
			$eau_liquide_resultat_mesure_rapport_acr = $oneRapport->eau_liquide_resultat_mesure_rapport_acr;
			$eau_liquide_resultat_mesure_rapport_acr = str_replace("&lt;","<",$eau_liquide_resultat_mesure_rapport_acr);
			$eau_liquide_resultat_mesure_rapport_acr = str_replace("&gt;",">",$eau_liquide_resultat_mesure_rapport_acr);
			
			$vapeur_eau_resultat_mesure_rapport_acr = $oneRapport->vapeur_eau_resultat_mesure_rapport_acr;
			$vapeur_eau_resultat_mesure_rapport_acr = str_replace("&lt;","<",$vapeur_eau_resultat_mesure_rapport_acr);
			$vapeur_eau_resultat_mesure_rapport_acr = str_replace("&gt;",">",$vapeur_eau_resultat_mesure_rapport_acr);
			
			$lubrifiant_resultat_mesure_rapport_acr = $oneRapport->lubrifiant_resultat_mesure_rapport_acr;
			$lubrifiant_resultat_mesure_rapport_acr = str_replace("&lt;","<",$lubrifiant_resultat_mesure_rapport_acr);
			$lubrifiant_resultat_mesure_rapport_acr = str_replace("&gt;",">",$lubrifiant_resultat_mesure_rapport_acr);
			
			$odeur_gout_resultat_mesure_rapport_acr = $oneRapport->odeur_gout_resultat_mesure_rapport_acr;
			$odeur_gout_resultat_mesure_rapport_acr = str_replace("&lt;","<",$odeur_gout_resultat_mesure_rapport_acr);
			$odeur_gout_resultat_mesure_rapport_acr = str_replace("&gt;",">",$odeur_gout_resultat_mesure_rapport_acr);
			$resultat = "O2 : ".$o2_resultat_mesure_rapport_acr."\nCO : ".$co_resultat_mesure_rapport_acr."\nCO2 : ".$co2_resultat_mesure_rapport_acr."\nEau liquide : ".$eau_liquide_resultat_mesure_rapport_acr."\nVapeur d'eau : ".$vapeur_eau_resultat_mesure_rapport_acr."\nLubrifiant : ".$lubrifiant_resultat_mesure_rapport_acr."\nOdeur et goût : ".$odeur_gout_resultat_mesure_rapport_acr;
		}
		
		$Rapports = $model->AfficheRapportLingettePlomb($oneEchantillon->id_echantillon);
		if(count($Rapports) <> 0){
			$oneRapport = $Rapports[0];
			
			$detect_line = 1;
			
			$issu_strategie = "/";
			$zone_prelevement = $oneRapport->etage_rapport_lingette_plomb ." - ".$oneRapport->local_rapport_lingette_plomb." - ".$oneRapport->localisation_prelevement_rapport_lingette_plomb;
			$lieu_travail = "/";
			$materiaux = $oneRapport->revetement_sol_rapport_lingette_plomb;
			
			$date_analyse = date('d/m/Y', strtotime($oneRapport->date_analyse_rapport_lingette_plomb));
			$resultat = str_replace("&gt;", ">", str_replace("&lt;", "<", $oneRapport->concentration_surfacique_rapport_lingette_plomb)). " µg/m²";
			if(str_replace("<", "", str_replace(",", ".", $oneRapport->concentration_surfacique_rapport_lingette_plomb)) > 1000)
				$detect_fibre = 1;
		}
		
		$Rapports = $model->AfficheRapportMETA12($oneEchantillon->id_echantillon);
		if(count($Rapports) <> 0){
			$oneRapport = $Rapports[0];
			
			$detect_line = 1;
			$detect_meta = 1;
			
			$activite = "/";
			
			$lieu_travail = "";
			if ($oneRapport->environnement_rapport_meta_1_2 == 1)
				$lieu_travail = "Milieu intérieure";
			if ($oneRapport->environnement_rapport_meta_1_2 == 2)
				$lieu_travail = "Plein air urbain";
			if ($oneRapport->environnement_rapport_meta_1_2 == 3)
				$lieu_travail = "Plein air campagne";
			if ($oneRapport->environnement_rapport_meta_1_2 == 0)
				$lieu_travail = $oneRapport->environnement_texte_rapport_meta_1_2;
			
			$ref_processus = "/";
			$materiaux = $oneRapport->materiau_rapport_meta_1_2;
			$technique = $oneRapport->technique_rapport_meta_1_2;
			$mpc = "/";
			
			$separator = "";
			$humidification = "";
			if ($humidification <> ""){$separator = ", ";}
			if ($oneRapport->humidification_humidification_rapport_meta_1_2 == 1){$humidification.= $separator . "Humidification du matériau par pulvérisation";}
			if ($humidification <> ""){$separator = ", ";}
			if ($oneRapport->mouillage_humidification_rapport_meta_1_2 == 1){$humidification.= $separator . "Mouillage par inondation des matériaux";}
			if ($humidification <> ""){$separator = ", ";}
			if ($oneRapport->brumisation_humidification_rapport_meta_1_2 == 1){$humidification.= $separator . "Brumisation";}
			if ($humidification <> ""){$separator = ", ";}
			if ($oneRapport->impregnation_humidification_rapport_meta_1_2 == 1){$humidification.= $separator . "Imprégnation à cœur du matériau";}
			
			$separator = "";
			$captage = "";
			if ($captage <> ""){$separator = ", ";}
			if (($oneRapport->aspiration_captage_rapport_meta_1_2 == 1) || ($oneRapport->aspirateur_the_aspiration_captage_rapport_meta_1_2 == 1)){$captage.= $separator . "Captage des poussières à la source";}
			if ($captage <> ""){$separator = ", ";}
			if (($oneRapport->aspirateur_the_depoirte_aspiration_captage_rapport_meta_1_2 == 1) || ($oneRapport->outil_the_depoirte_aspiration_captage_rapport_meta_1_2 == 1)){$captage.= $separator . "Captage des poussières avec aspiration déportée";}
			if ($captage <> ""){$separator = ", ";}
			$isolation = "/";
			
			$mpc = "";
			if($humidification <> ""){
				$mpc = "Humidification : ".$humidification."\n";
			}else{
				$mpc = "Humidification : Absence d'humidification\n";
			}
			
			if($captage <> ""){
				$mpc.= "Captage des poussières : ".$captage;
			}else{
				$mpc.= "Captage des poussières : Absence de captage des poussières";
			}
			
			// ==========================================================================================================
			// Isolation
			// ==========================================================================================================
				
			$separator = "";
			$isolation = "";
			if ($isolation <> ""){$separator = "\n";}
			if ($oneRapport->isolement_confinement_rapport_meta_1_2 == 1){$isolation.= $separator . "Isolement et calfeutrement simple";}
			if ($isolation <> ""){$separator = "\n";}
			if ($oneRapport->static_confinement_rapport_meta_1_2 == 1){$isolation.= $separator . "Confinement statique";}
			if ($isolation <> ""){$separator = "\n";}
			if ($oneRapport->dynamic_confinement_rapport_meta_1_2 == 1){$isolation.= $separator . "Confinement dynamique";}
			
			if(($isolation == "")) $isolation = "Absence";
			
			if ($oneRapport->strategie_prelevement_rapport_meta_1_2 == 1){
				$issu_strategie = $oneRapport->strategie_prelevement_texte_rapport_meta_1_2;
			}else{
				$issu_strategie = "non";
			}
			
			$zone_prelevement = $oneRapport->batiment_rapport_meta_1_2." - ".$oneRapport->designation_local_rapport_meta_1_2." - ".$oneRapport->etage_rapport_meta_1_2;
			$duree_prelevement = $oneRapport->duree_essai_rapport_meta_1_2;
			$debit_moyen = round(str_replace(",", ".",(str_replace(",", ".",$oneRapport->volume_essai_rapport_meta_1_2) / $oneRapport->duree_essai_rapport_meta_1_2)), 1);
			$volume = str_replace(".", ",",$oneRapport->volume_essai_rapport_meta_1_2);
			
			$date_analyse = date('d/m/Y', strtotime($oneRapport->date_analyse_rapport_meta_1_2));
			$fraction_filtre = $oneRapport->fraction_fibre_rapport_meta_1_2;
			$nombre_champ = $oneRapport->nb_grille_rapport_meta_1_2;
			$nombre_fibre = $oneRapport->nb_fibre_rapport_meta_1_2;
			$type_fibre = $oneRapport->type_amiante_labo_rapport_meta_1_2;
			$total_filtre = "/";
			$SA_litre = $oneRapport->sensibilite_analytique_rapport_meta_1_2;
			$concentration_calculee = $oneRapport->nb_fibre_rapport_meta_1_2 * $oneRapport->sensibilite_analytique_rapport_meta_1_2;
			$resultat = $oneRapport->empoussierement_rapport_meta_1_2;
			if ($oneRapport->signe_empoussierement_rapport_meta_1_2 == 1) $resultat = "< ".$oneRapport->empoussierement_rapport_meta_1_2;
			if ($oneRapport->signe_empoussierement_rapport_meta_1_2 == 2) $resultat = "> ".$oneRapport->empoussierement_rapport_meta_1_2;
			$cinf = $oneRapport->incertitude_mini_elargie_rapport_meta_1_2;
			$csup = $oneRapport->incertitude_max_elargie_rapport_meta_1_2;
		}
		
		$Rapports = $model->AfficheRapportMETA269($oneEchantillon->id_echantillon);
		if(count($Rapports) <> 0){
			$oneRapport = $Rapports[0];
			
			$detect_line = 1;
			$detect_meta = 1;
			
			$activite = "/";
			
			$lieu_travail = "";
			if ($oneRapport->environnement_rapport_meta_269 == 1)
				$lieu_travail = "Milieu intérieure";
			if ($oneRapport->environnement_rapport_meta_269 == 2)
				$lieu_travail = "Plein air urbain";
			if ($oneRapport->environnement_rapport_meta_269 == 3)
				$lieu_travail = "Plein air campagne";
			if ($oneRapport->environnement_rapport_meta_269 == 0)
				$lieu_travail = $oneRapport->environnement_texte_rapport_meta_269;
			
			$ref_processus = $oneRapport->reference_processus_rapport_meta_269;
			$materiaux = $oneRapport->materiau_rapport_meta_269;
			$technique = $oneRapport->technique_rapport_meta_269;
			$mpc = "/";
			
			$separator = "";
			$humidification = "";
			if ($humidification <> ""){$separator = ", ";}
			if ($oneRapport->aucune_humidification_rapport_meta_269 == 1){$humidification.= $separator . "Absence d'humidification";}
			if ($humidification <> ""){$separator = ", ";}
			if ($oneRapport->humidification_humidification_rapport_meta_269 == 1){$humidification.= $separator . "Humidification du matériau par pulvérisation";}
			if ($humidification <> ""){$separator = ", ";}
			if ($oneRapport->mouillage_humidification_rapport_meta_269 == 1){$humidification.= $separator . "Mouillage par inondation des matériaux";}
			if ($humidification <> ""){$separator = ", ";}
			if ($oneRapport->brumisation_impregnation_humidification_rapport_meta_269 == 1){$humidification.= $separator . "Brumisation";}
			if ($humidification <> ""){$separator = ", ";}
			if ($oneRapport->nebulisation_impregnation_humidification_rapport_meta_269 == 1){$humidification.= $separator . "Nébulisation";}
			if ($humidification <> ""){$separator = ", ";}
			if ($oneRapport->impregnation_humidification_rapport_meta_269 == 1){$humidification.= $separator . "Imprégnation à cœur du matériau";}
			
			$separator = "";
			$captage = "";
			if ($captage <> ""){$separator = ", ";}
			if ($oneRapport->aucune_captage_rapport_meta_269 == 1){$captage.= $separator . "Absence de captage des poussières";}
			if ($captage <> ""){$separator = ", ";}
			if ($oneRapport->source_captage_rapport_meta_269 == 1){$captage.= $separator . "Captage des poussières à la source";}
			if ($captage <> ""){$separator = ", ";}
			if ($oneRapport->aspiration_captage_rapport_meta_269 == 1){$captage.= $separator . "Captage des poussières avec aspiration déportée";}
			if ($captage <> ""){$separator = ", ";}
			$isolation = "/";
			
			$mpc = "";
			if($humidification <> ""){
				$mpc = "Humidification : ".$humidification."\n";
			}else{
				$mpc = "Humidification : Absence d'humidification\n";
			}
			
			if($captage <> ""){
				$mpc.= "Captage des poussières : ".$captage;
			}else{
				$mpc.= "Captage des poussières : Absence de captage des poussières";
			}
			
			// ==========================================================================================================
			// Isolation
			// ==========================================================================================================
			
			$separator = "";
			$isolation = "";
			if ($isolation <> ""){$separator = "\n";}
			if ($oneRapport->aucune_confinement_rapport_meta_269 == 1){$isolation.= $separator . "Absence";}
			if ($isolation <> ""){$separator = "\n";}
			if ($oneRapport->isolement_confinement_rapport_meta_269 == 1){$isolation.= $separator . "Isolement et calfeutrement simple";}
			if ($isolation <> ""){$separator = "\n";}
			if ($oneRapport->static_confinement_rapport_meta_269 == 1){$isolation.= $separator . "Confinement statique et renouvellement d'air";}
			if ($isolation <> ""){$separator = "\n";}
			if ($oneRapport->static_confinement_sans_rapport_meta_269 == 1){$isolation.= $separator . "Confinement statique sans renouvellement d'air";}
			if ($isolation <> ""){$separator = "\n";}
			if ($oneRapport->dynamic_confinement_rapport_meta_269 == 1){$isolation.= $separator . "Confinement dynamique avec mise en dépression";}
			if ($isolation <> ""){$separator = "\n";}
			if ($oneRapport->sac_isolement_confinement_rapport_meta_269 == 1){$isolation.= $separator . "Sac à manche";}
			if ($isolation <> ""){$separator = "\n";}
			if ($oneRapport->boite_isolement_confinement_rapport_meta_269 == 1){$isolation.= $separator . "Boîte à gant";}
			
			if(($isolation == "")) $isolation = "Absence";
			
			if ($oneRapport->strategie_prelevement_rapport_meta_269 == 1){
				$issu_strategie = $oneRapport->strategie_prelevement_texte_rapport_meta_269;
			}else{
				$issu_strategie = "non";
			}
			
			$zone_prelevement = $oneRapport->batiment_rapport_meta_269." - ".$oneRapport->designation_local_rapport_meta_269." - ".$oneRapport->etage_rapport_meta_269	;
			$duree_prelevement = $oneRapport->duree_essai_rapport_meta_269;
			$debit_moyen = round(str_replace(",", ".",(str_replace(",", ".",$oneRapport->volume_essai_rapport_meta_269) / $oneRapport->duree_essai_rapport_meta_269)), 1);
			$volume = str_replace(".", ",",$oneRapport->volume_essai_rapport_meta_269);
		}
		
		$Rapports = $model->AfficheRapportMETA1($oneEchantillon->id_echantillon);
		if(count($Rapports) <> 0){
			$oneRapport = $Rapports[0];
			
			$detect_line = 1;
			$detect_meta = 1;
			
			$activite = "/";
			$lieu_travail = "/";
			
			$ref_processus = "/";
			$materiaux = "/";
			$technique = "/";
			$mpc = "/";
			$isolation = "/";
			
			if ($oneRapport->strategie_prelevement_rapport_meta_1 == 1){
				$issu_strategie = $oneRapport->strategie_prelevement_texte_rapport_meta_1;
			}else{
				$issu_strategie = "non";
			}
			
			$zone_prelevement = $oneRapport->designation_local_rapport_meta_1." - ".$oneRapport->etage_rapport_meta_1." - ".$oneRapport->emplacement_pompe_rapport_meta_1;
			$duree_prelevement = $oneRapport->duree_rapport_meta_1;
			$debit_moyen = round(str_replace(",", ".",$oneRapport->debit_rapport_meta_1), 1);
			$volume = str_replace(".", ",",$oneRapport->volume_rapport_meta_1);
		
			$date_analyse = date('d/m/Y', strtotime($oneRapport->date_analyse_rapport_meta_1));
			$fraction_filtre = $oneRapport->fraction_fibre_rapport_meta_1;
			$nombre_champ = $oneRapport->nb_grille_rapport_meta_1;
			$nombre_fibre = $oneRapport->nb_fibre_rapport_meta_1;
			$type_fibre = $oneRapport->type_amiante_labo_rapport_meta_1;
			$total_filtre = "/";
			$SA_litre = $oneRapport->sensibilite_analytique_rapport_meta_1;
			$concentration_calculee = $oneRapport->nb_fibre_rapport_meta_1 * $oneRapport->sensibilite_analytique_rapport_meta_1;
			$resultat = $oneRapport->resultat_concentration_rapport_meta_1;
			if ($oneRapport->signe_resultat_concentration_rapport_meta_1 == 1) $resultat_concentration = "< ".$oneRapport->resultat_concentration_rapport_meta_1;
			if ($oneRapport->signe_resultat_concentration_rapport_meta_1 == 2) $resultat_concentration = "> ".$oneRapport->resultat_concentration_rapport_meta_1;
			$cinf = $oneRapport->incertitude_mini_elargie_rapport_meta_1;
			$csup = $oneRapport->incertitude_max_elargie_rapport_meta_1;
		}
		
		$Rapports = $model->AfficheRapportMETA269V2($oneEchantillon->id_echantillon);
		if(count($Rapports) <> 0){
			$oneRapport = $Rapports[0];
			
			$detect_line = 1;
			$detect_meta = 1;
			// ==========================================================================================================
			// Issu stratégie
			// ==========================================================================================================
			if ($oneRapport->strategie_prelevement_rapport_meta_269_v2 == 1){
				$issu_strategie = $oneRapport->strategie_prelevement_texte_rapport_meta_269_v2;
			}else{
				$issu_strategie = "Non";
			}
			
			$zone_prelevement = $oneRapport->info_strategie_texte_rapport_meta_269_v2;
			
			// ==========================================================================================================
			// Activité
			// ==========================================================================================================
			
			$activite = "/";
			if($oneRapport->activite_rapport_meta_269_v2 == "Sous-section 3"){
				$activite = "Sous-section 3: ".	$oneRapport->sous_section_3_rapport_meta_269_v2;
			}
			
			if($oneRapport->activite_rapport_meta_269_v2 == "Sous-section 4"){
				
				$activite = "Sous-section 4: intervention de ".$oneRapport->description_sous_section_4_rapport_meta_269_v2;
			}
			
			if($oneRapport->activite_rapport_meta_269_v2 == "Autre"){
				$activite = $oneRapport->activite_texte_rapport_meta_269_v2;
			}
			
			// ==========================================================================================================
			// Type de lieu de travail
			// ==========================================================================================================
			
			$lieu_travail = "/";
			if($oneRapport->type_lieu_travail_rapport_meta_269_v2 == "Milieu intérieur"){
				if($oneRapport->milieu_interieur_rapport_meta_269_v2 == "0"){
					$lieu_travail = "En milieu intérieur: " . $oneRapport->milieu_interieur_texte_rapport_meta_269_v2;
				}else{
					$lieu_travail = "En milieu intérieur: " . $oneRapport->milieu_interieur_rapport_meta_269_v2;
				}
				if($oneRapport->milieu_interieur_rapport_meta_269_v2 == "999")
					$lieu_travail = "En milieu intérieur";
			}
			
			if($oneRapport->type_lieu_travail_rapport_meta_269_v2 == "Plein air"){
				if($oneRapport->plein_air_rapport_meta_269_v2 == "0"){
					$lieu_travail = "En plein air: ".$oneRapport->plein_air_texte_rapport_meta_269_v2;
				}else{
					$lieu_travail = "En plein air: ".$oneRapport->plein_air_rapport_meta_269_v2;
				}
				if($oneRapport->plein_air_rapport_meta_269_v2 == "999")
					$lieu_travail = "En plein air";
				
				if($oneRapport->pluie_rapport_meta_269_v2 == "1"){
					$lieu_travail.= ", avec pluie";
				}else{
					$lieu_travail.= ", sans pluie";
				}
				
				$lieu_travail.= " et vent à ".$oneRapport->vent_rapport_meta_269_v2." km/h";

			}
			
			// ==========================================================================================================
			// Processus
			// ==========================================================================================================
			if(($oneRapport->ref_processus_texte_rapport_meta_269_v2 <> "") && ($oneRapport->ref_processus_texte_rapport_meta_269_v2 <> "/")){
				$ref_processus = $oneRapport->ref_processus_texte_rapport_meta_269_v2;
			}else{
				$ref_processus = "Non communiqué";
			}
			
			$separator = "";
			$materiaux = "";
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->flocage_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Flocage";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->calorifugeage_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Calorifugeage";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->faux_plafond_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Faux Plafond";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->dalle_sol_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Dalle de sol";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->carrelage_sol_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Carrelage au sol";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->faience_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Faïence";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->plinthe_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Plinthe";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->colle_dalle_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Colle de Dalle";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->colle_carrelage_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Colle de Carrelage";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->colle_faience_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Colle de Faïence";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->colle_plinthe_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Colle de Plinthe";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->fibrociment_conduit_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Fibrociment (conduit)";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->fibrociment_plaque_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Fibrociment (plaque)";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->ciment_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Ciment";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->enduit_peinture_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Enduit / Peinture";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->platre_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Plâtre";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->reagreage_chape_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Ragréage / Chape";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->mortier_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Mortier";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->joint_vitrage_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Joints vitrage";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->joint_bride_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Joints de bride";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->joint_mastique_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Mastic et autres joints";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->etancheite_bitumeux_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Revêtement / Etanchéité bitumineux ";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->enrobe_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Revêtement routier / Enrobés";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->element_friction_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Eléments de friction";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->clapet_coupe_feu_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Clapet coupe-feu";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->porte_coupe_feu_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Porte coupe-feu";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->panocell_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Panocell";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->panneau_sandwich_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Panneau sandwich";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->carton_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Cartons";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->feutre_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Feutres";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->textile_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Textiles";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->mousse_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Mousse";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->bourre_vrac_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . "Bourres en vrac";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->autre_materiau_rapport_meta_269_v2 == 1){$materiaux.= $separator . $oneRapport->autre_materiau_texte_rapport_meta_269_v2 ;}
			
			// ==========================================================================================================
			// Technique
			// ==========================================================================================================
			
			$separator = "";
			$technique = "";
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->arrachage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Arrachage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->balayage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Balayage ";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->brossage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Brossage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->carottage_forage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Carottage / Forage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->cassage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Cassage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->burinage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Burinage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->piquage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Piquage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->demolition_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Démolition";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->recouvrement_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Doublage / Encoffrement / Recouvrement";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->decapage_lustrage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Décapage / Lustrage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->decollage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Décollage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->decoupage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Découpage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->percage_sciage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Tronçonnage / Perçage / Sciage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->deconstruction_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Désemboitage / Déconstruction";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->sablage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Grenaillage / Hydrogommage / Sablage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->nettoyage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Nettoyage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->ramassage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Ramassage / Manutention / Conditionnement";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->pelletage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Pelletage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->poncage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Ponçage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->procede_chimique_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Procédé chimique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->rabotage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Rabotage / Rectification / Fraisage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->raclage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Raclage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->technique_thp_uph_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Technique THP / UPH";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->vissage_technique_rapport_meta_269_v2 == 1){$technique.= $separator . "Visage / Tirage de câble / Réglage";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->autre_technique_rapport_meta_269_v2 == 1){$technique.= $separator . $oneRapport->technique_texte_rapport_meta_269_v2 ;}
			
			
			if ($oneRapport->type_technique_texte_rapport_meta_269_v2 <> ""){
				$technique = $oneRapport->type_technique_rapport_meta_269_v2." par ".$technique .".\nOutil(s) : ".$oneRapport->type_technique_texte_rapport_meta_269_v2;
			}else{
				$technique = $oneRapport->type_technique_rapport_meta_269_v2." par ".$technique;
			}
			
			// ==========================================================================================================
			// MPC
			// ==========================================================================================================

			$mpc = "";
			if($humidification <> ""){
				$mpc = "Humidification : ".$humidification."\n";
			}else{
				$mpc = "Humidification : Absence d'humidification\n";
			}
			
			if($captage <> ""){
				$mpc.= "Captage des poussières : ".$captage;
			}else{
				$mpc.= "Captage des poussières : Absence de captage des poussières";
			}
			
			// ==========================================================================================================
			// Isolation
			// ==========================================================================================================
			
			$separator = "";
			$isolation = "";
			if($oneRapport->isolation_rapport_meta_269_v2 == 1){
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->isolement_confinement_rapport_meta_269_v2 == 1){$isolation.= $separator . "Isolement et calfeutrement simple";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->static_confinement_sans_rapport_meta_269_v2 == 1){$isolation.= $separator . "Confinement statique sans renouvellement d’air";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->static_confinement_avec_rapport_meta_269_v2 == 1){$isolation.= $separator . "Confinement statique avec renouvellement d’air";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->dynamic_10_6_10_confinement_rapport_meta_269_v2 == 1){$isolation.= $separator . "Confinement dynamique, dépression -10P, renouv 6 à 10 V/h";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->dynamic_10_6_20_confinement_rapport_meta_269_v2 == 1){$isolation.= $separator . "Confinement dynamique, dépression -10P, renouv 10 à 20 V/h";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->sac_isolement_confinement_rapport_meta_269_v2 == 1){$isolation.= $separator . "Sac à manche";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->boite_isolement_confinement_rapport_meta_269_v2 == 1){$isolation.= $separator . "Boîte à gant";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->protection_simple_confinement_rapport_meta_269_v2 == 1){$isolation.= $separator . "Protection simple peau sans calfeutrement";}
			}
			
			if(($oneRapport->isolation_rapport_meta_269_v2 == 0) || ($isolation == ""))
				$isolation = "Absence";
			
			
			$debit_moyen = number_format((str_replace( ",", ".", $oneRapport->volume_essai_rapport_meta_269_v2) / str_replace( ",", ".", $oneRapport->duree_essai_rapport_meta_269_v2)), 2, ',', '');
			$duree_prelevement = number_format(str_replace( ",", ".", $oneRapport->duree_essai_rapport_meta_269_v2), 2, ',', '');
			$volume = number_format(str_replace( ",", ".", $oneRapport->volume_essai_rapport_meta_269_v2), 2, ',', '');
			
		}
		
		$Rapports = $model->AfficheRapport($oneEchantillon->id_echantillon, "rapport_meta_269_v3");
		if(count($Rapports) <> 0){
			$oneRapport = $Rapports[0];
			
			$detect_line = 1;
			$detect_meta = 1;
			// ==========================================================================================================
			// Issu stratégie
			// ==========================================================================================================
			if ($oneRapport->strategie_prelevement_rapport_meta_269_v3 == 1){
				$issu_strategie = $oneRapport->strategie_prelevement_texte_rapport_meta_269_v3;
			}else{
				$issu_strategie = "Non";
			}
			
			$zone_prelevement = $oneRapport->info_strategie_texte_rapport_meta_269_v3;
			
			// ==========================================================================================================
			// Activité
			// ==========================================================================================================
			
			$activite = "/";
			if($oneRapport->activite_rapport_meta_269_v3 == "Sous-section 3"){
				$activite = "Sous-section 3: ".	$oneRapport->sous_section_3_rapport_meta_269_v3;
			}
			
			if($oneRapport->activite_rapport_meta_269_v3 == "Sous-section 4"){
				
				$activite = "Sous-section 4: intervention de ".$oneRapport->description_sous_section_4_rapport_meta_269_v3;
			}
			
			if($oneRapport->activite_rapport_meta_269_v3 == "Autre"){
				$activite = $oneRapport->activite_texte_rapport_meta_269_v3;
			}
			
			// ==========================================================================================================
			// Type de lieu de travail
			// ==========================================================================================================
			
			$lieu_travail = "/";
			if($oneRapport->type_lieu_travail_rapport_meta_269_v3 == "Milieu intérieur"){
				if($oneRapport->milieu_interieur_rapport_meta_269_v3 == "0"){
					$lieu_travail = "En milieu intérieur: " . $oneRapport->milieu_interieur_texte_rapport_meta_269_v3;
				}else{
					$lieu_travail = "En milieu intérieur: " . $oneRapport->milieu_interieur_rapport_meta_269_v3;
				}
				if($oneRapport->milieu_interieur_rapport_meta_269_v3 == "999")
					$lieu_travail = "En milieu intérieur";
			}
			
			if($oneRapport->type_lieu_travail_rapport_meta_269_v3 == "Plein air"){
				if($oneRapport->plein_air_rapport_meta_269_v3 == "0"){
					$lieu_travail = "En plein air: ".$oneRapport->plein_air_texte_rapport_meta_269_v3;
				}else{
					$lieu_travail = "En plein air: ".$oneRapport->plein_air_rapport_meta_269_v3;
				}
				if($oneRapport->plein_air_rapport_meta_269_v3 == "999")
					$lieu_travail = "En plein air";
				
				// if($oneRapport->pluie_rapport_meta_269_v3 == "1"){
					// $lieu_travail.= ", avec pluie";
				// }else{
					// $lieu_travail.= ", sans pluie";
				// }
				
				// $lieu_travail.= " et vent à ".$oneRapport->vent_rapport_meta_269_v3." km/h";

			}
			
			// ==========================================================================================================
			// Processus
			// ==========================================================================================================
			if(($oneRapport->ref_processus_texte_rapport_meta_269_v3 <> "") && ($oneRapport->ref_processus_texte_rapport_meta_269_v3 <> "/")){
				$ref_processus = $oneRapport->ref_processus_texte_rapport_meta_269_v3;
			}else{
				$ref_processus = "Non communiqué";
			}
			
			$separator = "";
			$materiaux = "";
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->flocage_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Flocage";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->calorifugeage_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Calorifugeage";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->faux_plafond_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Faux Plafond";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->frigorifuge_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Frigorifuge";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->dalle_sol_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Dalle de sol";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->lino_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Lino, moquette, lé";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->carrelage_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Carrelage au sol";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->faience_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Faïence";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->plinthe_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Plinthe";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->peinture_interieur_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Peinture intérieur";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->peinture_exterieur_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Peinture extérieur";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->peinture_metal_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Peinture sur support métallique";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->enduit_projete_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Enduit projeté (progypsol)";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->enduit_lissage_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Enduit de lissage";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->enduit_exterieur_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Enduit extérieur";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->enduit_metal_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Enduit sur support métallique";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->mortier_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Mortier";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->platre_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Plâtre";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->ciment_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Ciment";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->ragreage_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Ragréage / chape maigre";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->colle_bitumineuse_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Colle bitumineuse";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->colle_dalle_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Colle de dalle";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->colle_lino_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Colle de lino, moquette, lé";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->colle_plinthe_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Colle de Plinthe";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->colle_faience_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Colle de Faïence";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->canalisation_interieur_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Canalisation / Gaine Fibro intérieur";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->canalisation_exterieur_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Canalisation / Gaine Fibro extérieur";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->plaque_fibro_interieur_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Plaque Fibro intérieur";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->plaque_fibro_exterieur_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Plaque Fibro extérieur";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->tuiles_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Tuiles, Ardoises";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->toitures_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Toiture, bardage";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->etancheite_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Etanchéité bitumineuse";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->joint_vitrage_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Joints vitrage";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->joint_fenetre_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Joints cadre fenêtres";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->joint_bride_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Joints de bride";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->joint_installation_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Joints d’installation";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->mastic_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Mastic et autres joints";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->revetement_routier_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Revêtement routier/enrobés";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->friction_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Eléments de friction (freins)";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->clapet_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Clapet coupe-feu";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->porte_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Porte coupe-feu";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->tresse_rapport_meta_269_v3 == "1"){$materiaux.= $separator . "Tresse amiantée";}
			if ($materiaux <> ""){$separator = ", ";}
			if ($oneRapport->autre_materiau_rapport_meta_269_v3 == "1"){$materiaux.= $separator . $oneRapport->autre_materiau_texte_rapport_meta_269_v3 ;}
			
			// ==========================================================================================================
			// Technique
			// ==========================================================================================================
			
			$separator = "";
			$technique = "";
			
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->arrachage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Arrachage manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->desemboitage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Désemboitage / Déconstruction manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->depose_dessous_rapport_meta_269_v3 == "1"){$technique.= $separator . "Dépose par le dessous manuelle";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->depose_dessus_rapport_meta_269_v3 == "1"){$technique.= $separator . "Dépose par le dessus manuelle";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->ramassage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Ramassage / Nettoyage manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->manutention_rapport_meta_269_v3 == "1"){$technique.= $separator . "Manutention / conditionnement manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->pelletage_manuelle_rapport_meta_269_v3 == "1"){$technique.= $separator . "Pelletage manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->burinage_manuelle_rapport_meta_269_v3 == "1"){$technique.= $separator . "Burinage / piquage / cassage manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->raclage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Raclage manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->grattage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Grattage manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->balayage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Balayage manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->brossage_manuelle_rapport_meta_269_v3 == "1"){$technique.= $separator . "Brossage manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->poncage_manuelle_rapport_meta_269_v3 == "1"){$technique.= $separator . "Ponçage manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->encoffrement_rapport_meta_269_v3 == "1"){$technique.= $separator . "Encoffrement / recouvrement manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->vissage_manuelle_rapport_meta_269_v3 == "1"){$technique.= $separator . "Vissage / Dévissage manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->decoupage_manuelle_rapport_meta_269_v3 == "1"){$technique.= $separator . "Découpage manuel";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->autre_technique_manuelle_rapport_meta_269_v3 == "1"){$technique.= $separator . $oneRapport->technique_manuelle_texte_rapport_meta_269_v3." manuel";}
			
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->poncage_mecanique_rapport_meta_269_v3 == "1"){$technique.= $separator . "Ponçage mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->rabotage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Rabotage / Rectification mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->burinage_mecanique_rapport_meta_269_v3 == "1"){$technique.= $separator . "Burinage mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->cassage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Cassage / piquage mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->tronconnage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Tronçonnage / Perçage mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->decoupage_mecanique_rapport_meta_269_v3 == "1"){$technique.= $separator . "Découpage / sciage mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->brossage_mecanique_rapport_meta_269_v3 == "1"){$technique.= $separator . "Brossage mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->pelletage_mecanique_rapport_meta_269_v3 == "1"){$technique.= $separator . "Pelletage mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->sablage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Sablage mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->carottage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Carottage / Forage mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->vissage_mecanique_rapport_meta_269_v3 == "1"){$technique.= $separator . "Vissage / Dévissage mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->demolition_rapport_meta_269_v3 == "1"){$technique.= $separator . "Démolition mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->decapage_rapport_meta_269_v3 == "1"){$technique.= $separator . "Décapage / Lustrage mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->thp_rapport_meta_269_v3 == "1"){$technique.= $separator . "Jet Très Haute Pression (THP) mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->chimique_rapport_meta_269_v3 == "1"){$technique.= $separator . "Procédé chimique mécanique";}
			if ($technique <> ""){$separator = ", ";}
			if ($oneRapport->autre_technique_mecanique_rapport_meta_269_v3 == "1"){$technique.= $separator . $oneRapport->technique_mecanique_texte_rapport_meta_269_v3. " mécanique";}
			
			if ($oneRapport->type_technique_texte_rapport_meta_269_v3 <> ""){
				$technique = $oneRapport->type_technique_rapport_meta_269_v3." par ".$technique .".\nOutil(s) : ".$oneRapport->type_technique_texte_rapport_meta_269_v3;
			}else{
				$technique = $oneRapport->type_technique_rapport_meta_269_v3." par ".$technique;
			}
			
			// ==========================================================================================================
			// MPC
			// ==========================================================================================================
			$separator = "";
			$humidification = "";
			if($oneRapport->humidification_rapport_meta_269_v3 == "1"){
				if ($humidification <> ""){$separator = ", ";}
				if ($oneRapport->humidification_humidification_rapport_meta_269_v3 == "1"){$humidification.= $separator . "Humidification des matériaux par pulvérisation";}
				if ($humidification <> ""){$separator = ", ";}
				if ($oneRapport->mouillage_humidification_rapport_meta_269_v3 == "1"){$humidification.= $separator . "Mouillage par inondation des matériaux";}
				if ($humidification <> ""){$separator = ", ";}
				if ($oneRapport->impregnation_humidification_rapport_meta_269_v3 == "1"){$humidification.= $separator . "Imprégnation à cœur des matériaux";}
				if ($humidification <> ""){$separator = ", ";}
				if ($oneRapport->brumisation_impregnation_humidification_rapport_meta_269_v3 == "1"){$humidification.= $separator . "Brumisation dans la zone";}
				if ($humidification <> ""){$separator = ", ";}
				if ($oneRapport->nebulisation_impregnation_humidification_rapport_meta_269_v3 == "1"){$humidification.= $separator . "Nébulisation dans la zone";}
			}
			
			$separator = "";
			$captage = "";
			if($oneRapport->captage_rapport_meta_269_v3 == "1"){
				if ($captage <> ""){$separator = ", ";}
				if ($oneRapport->source_captage_rapport_meta_269_v3 == "1"){$captage.= $separator . "Captage des poussières à la source (aspi fixé à l'outil)";}
				if ($captage <> ""){$separator = ", ";}
				if ($oneRapport->aspiration_deporte_proche_captage_rapport_meta_269_v3 == "1"){$captage.= $separator . "Captage des poussières avec aspiration déportée au plus proche de l'outil";}
				if ($captage <> ""){$separator = ", ";}
				if ($oneRapport->aspiration_deporte_captage_rapport_meta_269_v3 == "1"){$captage.= $separator . "Captage des poussières avec aspiration déportée";}
				if ($captage <> ""){$separator = ", ";}
				if ($oneRapport->localise_captage_rapport_meta_269_v3 == "1"){$captage.= $separator . "Captage des poussières localisé enveloppant";}
			}
			
			$mpc = "";
			if($humidification <> ""){
				$mpc = "Humidification : ".$humidification."\n";
			}else{
				$mpc = "Humidification : Absence d'humidification\n";
			}
			
			if($captage <> ""){
				$mpc.= "Captage des poussières : ".$captage;
			}else{
				$mpc.= "Captage des poussières : Absence de captage des poussières";
			}
			
			// ==========================================================================================================
			// Isolation
			// ==========================================================================================================
			
			$separator = "";
			$isolation = "";
			if($oneRapport->isolation_rapport_meta_269_v3 == "1"){
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->simple_peau_rapport_meta_269_v3 == "1"){$isolation.= $separator . "Protection simple peau sans calfeutrement";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->isolement_confinement_rapport_meta_269_v3 == "1"){$isolation.= $separator . "Isolement et calfeutrement simple";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->static_confinement_sans_rapport_meta_269_v3 == "1"){$isolation.= $separator . "Confinement statique sans renouvellement d’air";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->static_confinement_avec_rapport_meta_269_v3 == "1"){$isolation.= $separator . "Confinement statique avec renouvellement d’air";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->dynamic_10_6_10_confinement_rapport_meta_269_v3 == "1"){$isolation.= $separator . "Confinement dynamique, dépression -10P, renouv 6 à 10 V/h";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->dynamic_10_6_20_confinement_rapport_meta_269_v3 == "1"){$isolation.= $separator . "Confinement dynamique, dépression -10P, renouv 10 à 20 V/h";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->sac_isolement_confinement_rapport_meta_269_v3 == "1"){$isolation.= $separator . "Sac à manche";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->boite_isolement_confinement_rapport_meta_269_v3 == "1"){$isolation.= $separator . "Boîte à gant";}
				if ($isolation <> ""){$separator = ", ";}
				if ($oneRapport->protection_simple_confinement_rapport_meta_269_v3 == "1"){$isolation.= $separator . "Protection simple peau sans calfeutrement";}
			}
			
			if(($oneRapport->isolation_rapport_meta_269_v3 == 0) || ($isolation == ""))
				$isolation = "Absence";
			
			
			$debit_moyen = number_format((str_replace( ",", ".", $oneRapport->volume_essai_rapport_meta_269_v3) / str_replace( ",", ".", $oneRapport->duree_essai_rapport_meta_269_v3)), 2, ',', '');
			$duree_prelevement = number_format(str_replace( ",", ".", $oneRapport->duree_essai_rapport_meta_269_v3), 2, ',', '');
			$volume = number_format(str_replace( ",", ".", $oneRapport->volume_essai_rapport_meta_269_v3), 2, ',', '');
			
		}
		
		// ========================================
		// ========================================
		// 050
		// ========================================
		// ========================================
		
		$Rapports = $model->AfficheRapportMETA050($oneEchantillon->id_echantillon);
		if(count($Rapports) <> 0){
			$oneRapport = $Rapports[0];
			
			$detect_line = 1;
			$detect_meta = 1;
			
			// ==========================================================================================================
			// Issu stratégie
			// ==========================================================================================================
			if ($oneRapport->strategie_prelevement_rapport_meta_050 == 1){
				$issu_strategie = $oneRapport->strategie_prelevement_texte_rapport_meta_050;
			}else{
				$issu_strategie = "Non";
			}
			
			$zone_prelevement = $oneRapport->info_strategie_texte_rapport_meta_050;
			$activite = "/";
			
			// ==========================================================================================================
			// Lieu de travail
			// ==========================================================================================================
			$lieu_travail = "";
			if($oneRapport->type_lieu_travail_rapport_meta_050 == "Intérieur"){
				if($oneRapport->circulation_rapport_meta_050 == "1"){
					$lieu_travail.= "En intérieur avec passage et circulation durant les mesurages";
				}else{
					$lieu_travail.= "En intérieur sans passage et circulation durant les mesurages";
				}
			}
			
			if($oneRapport->type_lieu_travail_rapport_meta_050 == "Extérieur"){
				$lieu_travail.= "En extérieur";
				if($oneRapport->pluie_rapport_meta_050 == "1"){
					$lieu_travail.= ", avec pluie";
				}else{
					$lieu_travail.= ", sans pluie";
				}
				$lieu_travail.= ", vent à ".$oneRapport->vitesse_vent_rapport_meta_050." km/h et taux d'humidité : ".$oneRapport->taux_humidite_rapport_meta_050."%";
			}
			
			$ref_processus = "/";
			$materiaux = "/";
			$technique = "/";
			$mpc = "/";
			$isolation = "/";
			
			$debit_moyen = number_format(str_replace( ",", ".", $oneRapport->debit_rapport_meta_050), 2, ',', '');
			$duree_prelevement = $oneRapport->duree_total_rapport_meta_050;
			$volume = str_replace( ",", ".", $oneRapport->volume_total_rapport_meta_050) * 1000;
		}
		
		if($detect_meta == 1){
			$Analyses = $model->AfficheAnalyseEchantillonMETA1($oneEchantillon->id_echantillon, 1);
			$oneAnalyse = $Analyses[0];
			
			$ref_echantillon_labo = $oneEchantillon->ref_echantillon;
			
			if(count($Analyses) <> 0){
				// ==========================================================================================================
				// Données Labo
				// ==========================================================================================================

				$date_analyse = date("d/m/Y",strtotime($oneAnalyse->date_analyse_analyse_meta_1));



				$fraction_filtre = number_format($oneAnalyse->fraction_filtre_analyse_meta_1, 2, ',', '');
				$nombre_champ = $oneAnalyse->nombre_carres_analyse_meta_1;
				$nombre_fibre = $oneAnalyse->nombre_fibre_analyse_meta_1;
				$type_fibre = $oneAnalyse->type_fibre_analyse_meta_1;


				$surface_grille = str_replace(".", ",", $oneAnalyse->surface_grille_analyse_meta_1);
				$surface_filtration = str_replace(".", ",", $oneAnalyse->surface_filtration_analyse_meta_1);
				$total_filtre = $oneAnalyse->fraction_filtre_1_analyse_meta_1 + $oneAnalyse->fraction_filtre_075_analyse_meta_1 + $oneAnalyse->fraction_filtre_05_analyse_meta_1 + $oneAnalyse->fraction_filtre_025_analyse_meta_1 + $oneAnalyse->fraction_filtre_0125_analyse_meta_1 + $oneAnalyse->fraction_filtre_00625_analyse_meta_1;
				$nombre_grille = $oneAnalyse->nombre_grille_analyse_meta_1;
				
				$nombre_prepa = $oneAnalyse->nb_prepa_analyse_meta_1;
				
				// ==========================================================================================================
				// Résultat
				// ==========================================================================================================
				
				$SA = $model->calcul_sa($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1);
				$SA_litre = number_format($SA, 2, ',', '');
				
				if ($oneAnalyse->nombre_fibre_analyse_meta_1 < 4){
					$resultat = "<".number_format($model->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $model->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 2, ',', '');
					$concentration_minimum = "/";
				}else{
					$resultat = number_format($model->concentration_normalisee($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1), 2, ',', '');
					$concentration_minimum = number_format($model->concentration_minimum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $model->loi_poisson_Ni($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 2, ',', '');
				}
				$concentration_maximum = number_format($model->concentration_maximum($oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->volume_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $oneAnalyse->diametre_filtre_analyse_meta_1, $oneAnalyse->incertitude_analyse_meta_1, $model->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $ED, $EPC, $ELPC, $D, $CC, $ECC, $EMIC, $ELMIC), 2, ',', '');
				
				if ($oneAnalyse->inanalysable_analyse_meta_1 == 1){
					$fraction_filtre_analyse_meta_1 = number_format(str_replace( ",", ".", $oneAnalyse->fraction_filtre_analyse_meta_1), 2, ',', '');
					$nombre_carres_analyse_meta_1 = "/";
					$nombre_fibre_analyse_meta_1 = "/";
					$type_fibre_analyse_meta_1 = "/";
					$SA_litre = "/";
		
					$SA_filtre = "/";
					$densite_filtre_normalisee = "/";
					$densite_filtre_calculee = "/";
					$intervalle_confiance_filtre = "/";
					
					$concentration_calculee = "/";
					$resultat = "/";
					$intervalle_confiance_litre = "/";
					
					$cinf = "/";
					$csup = "/";
					
					$resultat_resume = "Inanalysable";
					$SA_litre_resume = "Inanalysable";
					
				}else{
					$total_filtre = $oneAnalyse->fraction_filtre_1_analyse_meta_1 + $oneAnalyse->fraction_filtre_075_analyse_meta_1 + $oneAnalyse->fraction_filtre_05_analyse_meta_1 + $oneAnalyse->fraction_filtre_025_analyse_meta_1 + $oneAnalyse->fraction_filtre_0125_analyse_meta_1 + $oneAnalyse->fraction_filtre_00625_analyse_meta_1;
					$fraction_filtre = number_format($oneAnalyse->fraction_filtre_analyse_meta_1, 2, ',', '');
					$nombre_champ = $oneAnalyse->nombre_carres_analyse_meta_1;
					$nombre_fibre = $oneAnalyse->nombre_fibre_analyse_meta_1;
					$type_fibre = $oneAnalyse->type_fibre_analyse_meta_1;
					
					$surface_grille = str_replace(".", ",", $oneAnalyse->surface_grille_analyse_meta_1);
					$surface_filtration = str_replace(".", ",", $oneAnalyse->surface_filtration_analyse_meta_1);
					
					$densite_filtre_calculee = round($model->calcul_densite($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $total_filtre), 0);
					$densite_inferieur = $model->calcul_densite_inferieur($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $model->loi_poisson_Ni($oneAnalyse->nombre_fibre_analyse_meta_1), $total_filtre);
					$densite_superieur = $model->calcul_densite_superieur($oneAnalyse->nombre_fibre_analyse_meta_1, $oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $model->loi_poisson_Ns($oneAnalyse->nombre_fibre_analyse_meta_1), $total_filtre);
					$intervalle_confiance_filtre = round($densite_inferieur, 0)." < D < ".round($densite_superieur, 0);
					
					$SA_filtre = round($model->calcul_sa_filtre($oneAnalyse->surface_filtration_analyse_meta_1, $oneAnalyse->nombre_carres_analyse_meta_1, $oneAnalyse->surface_grille_analyse_meta_1, $oneAnalyse->fraction_filtre_analyse_meta_1, $total_filtre), 0);
					if ($oneAnalyse->nombre_fibre_analyse_meta_1 < 4){	
						$densite_filtre_normalisee = "<".round($densite_superieur, 0);
					}else{
						$densite_filtre_normalisee = round($densite_filtre_calculee, 0);
					}
						
					$concentration_calculee = number_format(($SA * $oneAnalyse->nombre_fibre_analyse_meta_1), 2, ',', '');
					$intervalle_confiance_litre = $concentration_minimum." < C < ".$concentration_maximum;
					
					$resultat_resume = $resultat;
					$SA_litre_resume = $SA_litre;
					
					$cinf = $concentration_minimum;
					$csup = $concentration_maximum;
				}
			}
			
			$Analyses = $model->AfficheAnalyseEchantillonMETAv0($oneEchantillon->id_echantillon, 1);
			$oneAnalyse = $Analyses[0];
			
			if(count($Analyses) <> 0){
				$id_analyse = $oneAnalyse->id_analyse_meta_v0;
				
				// ==========================================================================================================
				// Data dernière prépa
				// ==========================================================================================================
				$Prepa = $model->AfficheDernierePrepaMETAv0($id_analyse);
				$lastPrepa = $Prepa[0];
				
				// ==========================================================================================================
				// Liste et compte prépa
				// ==========================================================================================================
				$Prepa = $model->ListePrepaMETAv0($id_analyse);
				$nombre_prepa = count($Prepa);
				
				// ==========================================================================================================
				// Données Labo
				// ==========================================================================================================

				$date_analyse = date("d/m/Y",strtotime($lastPrepa->date_analyse_analyse_meta_v0_prepa));



				$fraction_filtre = str_replace(".", ",", $oneAnalyse->fraction_filtre_analyse_meta_v0);
				$nombre_champ = str_replace(".", ",", $oneAnalyse->nombre_champ_analyse_meta_v0);
				$nombre_fibre = str_replace(".", ",", $oneAnalyse->nombre_fibre_analyse_meta_v0);
				$type_fibre = $oneAnalyse->type_fibre_analyse_meta_v0;


				$surface_grille = str_replace(".", ",", $oneAnalyse->surface_grille_analyse_meta_v0);
				$surface_filtration = str_replace(".", ",", $oneAnalyse->surface_filtration_analyse_meta_v0);
				$total_filtre = str_replace(".", ",", $oneAnalyse->total_filtre_analyse_meta_v0);
				$nombre_grille = $lastPrepa->nombre_grille_analyse_meta_v0_prepa;
				
				$incertitude_labo = $oneAnalyse->incertitude_labo_analyse_meta_v0;
				
				// ==========================================================================================================
				// Résultat
				// ==========================================================================================================
				$SA_filtre = $oneAnalyse->sa_densite_filtre_analyse_meta_v0;
				$densite_filtre_calculee =  number_format($oneAnalyse->concentration_calcule_densite_filtre_analyse_meta_v0, 0, ",", "");
				$densite_filtre_normalisee = $oneAnalyse->concentration_normalise_densite_filtre_analyse_meta_v0;
				if($nombre_fibre < 4) $densite_filtre_normalisee = "<".$densite_filtre_normalisee;
				$intervalle_confiance_filtre = $oneAnalyse->cinf_densite_filtre_analyse_meta_v0." < D < ".$oneAnalyse->csup_densite_filtre_analyse_meta_v0;
				
				$SA_litre = number_format($oneAnalyse->sa_concentration_analyse_meta_v0, 2, ",", "");
				$concentration_calculee = number_format($oneAnalyse->concentration_calcule_concentration_analyse_meta_v0, 2, ",", "");
				$resultat = number_format($oneAnalyse->concentration_normalise_concentration_analyse_meta_v0, 2, ",", "");
				if($nombre_fibre < 4) $resultat = "<".$resultat;
				$intervalle_confiance_litre = "/ < C < ".number_format($oneAnalyse->csup_concentration_analyse_meta_v0, 2, ",", "");
				if($nombre_fibre >= 4) $intervalle_confiance_litre = number_format($oneAnalyse->cinf_concentration_analyse_meta_v0, 2, ",", "")." < C < ".number_format($oneAnalyse->csup_concentration_analyse_meta_v0, 2, ",", "");
				
				$cinf = "/";
				if($nombre_fibre >= 4) $cinf = number_format($oneAnalyse->cinf_concentration_analyse_meta_v0, 2, ",", "");
				$csup = number_format($oneAnalyse->csup_concentration_analyse_meta_v0, 2, ",", "");
				
				$resultat_resume = $resultat;
				$SA_litre_resume = $SA_litre;
				
				// ==========================================================================================================
				// Inanalysable réception
				// ==========================================================================================================
				$inanalysable_texte_reception = "";
				if ($oneAnalyse->decision_anomalie_reception_analyse_meta_v0 == "Echantillon inanalysable"){
					$nombre_prepa = "/";
					$attaque_acide = "/";
					$nombre_grille = "/";
					
					$fraction_filtre = "/";
					$nombre_champ = "/";
					$nombre_fibre = "/";
					$type_fibre = "/";
		
					$SA_filtre = "/";
					$densite_filtre_calculee = "/";
					$densite_filtre_normalisee = "/";
					$intervalle_confiance_filtre = "/";
					
					$SA_litre = "/";
					$concentration_calculee = "/";
					$resultat = "/";
					$intervalle_confiance_litre = "/";
					
					$resultat_resume = "<b>Inanalysable</b>";
					$SA_litre_resume = "<b>Inanalysable</b>";
				}	
				
				// ==========================================================================================================
				// Inanalysable préparation
				// ==========================================================================================================
				$inanalysable_texte_preparation = "";
				if ($lastPrepa->decision_anomalie_grille_analyse_meta_v0_prepa == "Echantillon inanalysable"){
					$fraction_filtre = $oneAnalyse->fraction_filtre_analyse_meta_v0;
					$nombre_champ = "/";
					$nombre_fibre = "/";
					$type_fibre = "/";
		
					$SA_filtre = "/";
					$densite_filtre_calculee = "/";
					$densite_filtre_normalisee = "/";
					$intervalle_confiance_filtre = "/";
					
					$SA_litre = "/";
					$concentration_calculee = "/";
					$resultat = "/";
					$intervalle_confiance_litre = "/";
					
					$resultat_resume = "<b>Inanalysable</b>";
					$SA_litre_resume = "<b>Inanalysable</b>";
					
					$fraction_filtre_prepa = "";
					if($lastPrepa->fraction_filtre_1_analyse_meta_v0_prepa <> 0) $fraction_filtre_prepa = "1";
					if($lastPrepa->fraction_filtre_075_analyse_meta_v0_prepa <> 0) $fraction_filtre_prepa = "0,75";
					if($lastPrepa->fraction_filtre_05_analyse_meta_v0_prepa <> 0) $fraction_filtre_prepa = "0,5";
					if($lastPrepa->fraction_filtre_025_analyse_meta_v0_prepa <> 0) $fraction_filtre_prepa = "0,25";
					if($lastPrepa->fraction_filtre_0125_analyse_meta_v0_prepa <> 0) $fraction_filtre_prepa = "0,125";
				}
				
				// ==========================================================================================================
				// Commentaire Préparation
				// ==========================================================================================================
				$preparation_texte = "";
				$separator = "";
				foreach($Prepa as $onePrepa){				
					if ($onePrepa->demande_conformite_analyse_meta_v0_prepa == "Demande de re-préparation"){
						$fraction_filtre_prepa = "";
						if($onePrepa->fraction_filtre_1_analyse_meta_v0_prepa <> 0) $fraction_filtre_prepa = "1";
						if($onePrepa->fraction_filtre_075_analyse_meta_v0_prepa <> 0) $fraction_filtre_prepa = "0,75";
						if($onePrepa->fraction_filtre_05_analyse_meta_v0_prepa <> 0) $fraction_filtre_prepa = "0,5";
						if($onePrepa->fraction_filtre_025_analyse_meta_v0_prepa <> 0) $fraction_filtre_prepa = "0,25";
						if($onePrepa->fraction_filtre_0125_analyse_meta_v0_prepa <> 0) $fraction_filtre_prepa = "0,125";
					}
				}
			}
		}
		
		if($detect_line == 1){
			$line = $line + 1;
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($Cell[$i++].$line, $oneEchantillon->ref_client_chantier)
				->setCellValue($Cell[$i++].$line, $oneEchantillon->nom_chantier)
				->setCellValue($Cell[$i++].$line, date('d/m/Y', strtotime($oneEchantillon->date_pose_presta_echantillon)))
				->setCellValue($Cell[$i++].$line, $oneEchantillon->ref_echantillon)
				->setCellValue($Cell[$i++].$line, $issu_strategie)
				->setCellValue($Cell[$i++].$line, $oneEchantillon->adresse_chantier)
				->setCellValue($Cell[$i++].$line, $oneEchantillon->cp_chantier)
				->setCellValue($Cell[$i++].$line, $oneEchantillon->ville_chantier)
				->setCellValue($Cell[$i++].$line, $oneEchantillon->nom_qualification)
				->setCellValue($Cell[$i++].$line, $oneEchantillon->affichage_rapport_detail_type_presta)
				->setCellValue($Cell[$i++].$line, $zone_prelevement)
				->setCellValue($Cell[$i++].$line, $activite)
				->setCellValue($Cell[$i++].$line, $lieu_travail)
				->setCellValue($Cell[$i++].$line, $ref_processus)
				->setCellValue($Cell[$i++].$line, $materiaux)
				->setCellValue($Cell[$i++].$line, $technique)
				->setCellValue($Cell[$i++].$line, $mpc)
				->setCellValue($Cell[$i++].$line, $isolation)
				->setCellValue($Cell[$i++].$line, $debit_moyen)
				->setCellValue($Cell[$i++].$line, $duree_prelevement)
				->setCellValue($Cell[$i++].$line, $volume)
				->setCellValue($Cell[$i++].$line, $date_analyse)
				->setCellValue($Cell[$i++].$line, $fraction_filtre)
				->setCellValue($Cell[$i++].$line, $nombre_champ)
				->setCellValue($Cell[$i++].$line, $nombre_fibre)
				->setCellValue($Cell[$i++].$line, $type_fibre)
				->setCellValue($Cell[$i++].$line, $total_filtre)
				->setCellValue($Cell[$i++].$line, $SA_litre)
				->setCellValue($Cell[$i++].$line, $concentration_calculee)
				->setCellValue($Cell[$i++].$line, $resultat)
				->setCellValue($Cell[$i++].$line, $cinf)
				->setCellValue($Cell[$i++].$line, $csup);
				
			$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->applyFromArray($style_border);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->applyFromArray($style_texte_center);
			if((($nombre_fibre <> "0") && ($nombre_fibre <> "/")) || ($detect_fibre == 1)) $objPHPExcel->getActiveSheet()->getStyle('Y'.$line.':Z'.$line)->applyFromArray($style_texte_alerte);
			if((($nombre_fibre <> "0") && ($nombre_fibre <> "/")) || ($detect_fibre == 1)) $objPHPExcel->getActiveSheet()->getStyle('D'.$line)->applyFromArray($style_texte_alerte);
			if((($nombre_fibre <> "0") && ($nombre_fibre <> "/")) || ($detect_fibre == 1)) $objPHPExcel->getActiveSheet()->getStyle('AD'.$line)->applyFromArray($style_texte_alerte);
		}
	}
	
	foreach($Cell as $columnID) {
		$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}	
	
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Simple');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F Page &P / &N');

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="01simple.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
?>
