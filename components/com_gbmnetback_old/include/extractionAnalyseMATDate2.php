<?php
	
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
				->setCellValue("A1", "Donneur d'ordre")
				->setCellValue("G1", "CEAPIC")
				->setCellValue("L1", "Donées client")
				->setCellValue("R1", "Résultat CEAPIC");
	
	$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
	$objPHPExcel->getActiveSheet()->mergeCells('G1:K1');
	$objPHPExcel->getActiveSheet()->mergeCells('L1:Q1');
	$objPHPExcel->getActiveSheet()->mergeCells('R1:AA1');
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($style_border);
	$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($style_texte_center);
	
	$line++;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($Cell[$i++].$line, "Société")
				->setCellValue($Cell[$i++].$line, "Nom demandeur")
				->setCellValue($Cell[$i++].$line, "Adresse")
				->setCellValue($Cell[$i++].$line, "Date envoi")
				->setCellValue($Cell[$i++].$line, "Réf Affaire")
				->setCellValue($Cell[$i++].$line, "Réf Dossier")
				
				->setCellValue($Cell[$i++].$line, "Réf dossier")
				->setCellValue($Cell[$i++].$line, "Date réception")
				->setCellValue($Cell[$i++].$line, "Date prévisio rendu")
				->setCellValue($Cell[$i++].$line, "Date d'analyse")
				->setCellValue($Cell[$i++].$line, "Date envoi rapport")
				
				->setCellValue($Cell[$i++].$line, "Réf éch")
				->setCellValue($Cell[$i++].$line, "Type")
				->setCellValue($Cell[$i++].$line, "Aspect")
				->setCellValue($Cell[$i++].$line, "Localisation")
				->setCellValue($Cell[$i++].$line, "Nature produit dissémination fibres")
				->setCellValue($Cell[$i++].$line, "Suspission pollution surfacique")
				
				->setCellValue($Cell[$i++].$line, "Réf dossier")
				->setCellValue($Cell[$i++].$line, "Réf éch")
				->setCellValue($Cell[$i++].$line, "Couche")
				->setCellValue($Cell[$i++].$line, "Méthode")
				->setCellValue($Cell[$i++].$line, "Nb de support")
				->setCellValue($Cell[$i++].$line, "Type de prépa")
				->setCellValue($Cell[$i++].$line, "Nb de prépa")
				->setCellValue($Cell[$i++].$line, "Résultat")
				->setCellValue($Cell[$i++].$line, "Type de fibre")
				->setCellValue($Cell[$i++].$line, "Observation");
				
	$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->applyFromArray($filtre);

	foreach($model->ListeAnalyseMateriauV0Date($id_client, $date_debut, $date_fin) as $oneEchantillon){
		
		$date_envoi_analyse_dossier = date('d-m-Y',strtotime($oneEchantillon->date_envoi_analyse_dossier));
		if($date_envoi_analyse_dossier == '01-01-1970') $date_envoi_analyse_dossier = "NC";
		
		$date_analyse = "0";
		if (date("Ymd",strtotime($oneEchantillon->date_preparation_molp_analyse_materiau_v0)) > date("Ymd",strtotime($date_analyse)))
				$date_analyse = date("d-m-Y",strtotime($oneEchantillon->date_preparation_molp_analyse_materiau_v0));
		if (date("Ymd",strtotime($oneEchantillon->date_analyse_met_analyse_materiau_v0)) > date("Ymd",strtotime($date_analyse)))
			$date_analyse = date("d-m-Y",strtotime($oneEchantillon->date_analyse_met_analyse_materiau_v0));
		
		$commentaire_analyse_materiau_v0 = "/";
		if ($oneEchantillon->commentaire_analyse_materiau_v0 <> "")
			$commentaire_analyse_materiau_v0 = $oneEchantillon->commentaire_analyse_materiau_v0;
		
		$avis_analyse_materiau_v0 = "/";
		if ($oneEchantillon->avis_analyse_materiau_v0 <> "")
			$avis_analyse_materiau_v0 = $oneEchantillon->avis_analyse_materiau_v0;
			
		$interpretations_analyse_materiau_v0 = "/";
		if ($oneEchantillon->interpretations_analyse_materiau_v0 <> "")
			$interpretations_analyse_materiau_v0 = $oneEchantillon->interpretations_analyse_materiau_v0;
		
		$oneTechnicienMOLP = $model->AfficheTechnicienLabo($oneEchantillon->operateur_preparation_molp_analyse_materiau_v0);
		$oneTechnicienMET = $model->AfficheTechnicienLabo($oneEchantillon->operateur_analyse_met_analyse_materiau_v0);
		
		$descriptif_couche=[];
		$separator=[];
		foreach($model->ListeAnalyseMateriauV0Couche($oneEchantillon->id_analyse_materiau_v0) as $oneCouche){
			$num_couche = $oneCouche->num_couche_analyse_materiau_v0_couche;
			$descriptif_couche[$num_couche]="";
			$separator[$num_couche]= "";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->rvt_sol_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Rvt de sol";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->faux_plafond_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Faux-plafond";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->enduit_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Enduit";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->carrelage_faience_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Carrelage – Faïence";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->colle_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Colle";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->bitume_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Bitume";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->laine_flocage_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Laine – Flocage";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->fibre_ciment_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Fibre-ciment";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->ragreage_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Ragréage";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->tresse_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Tresse";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->joint_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Joint";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->peinure_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Peinture";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->mousse_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Mousse";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->calorifugeage_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Calorifugeage";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->autre_type_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche].$oneCouche->autre_type_text_analyse_materiau_v0_couche;
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->dur_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Dur";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->souple_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Souple";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->fibreux_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Fibreux";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->semi_dur_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Semi dur";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->poudreux_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Poudreux";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->friable_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Friable";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->bitumineux_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Bitumineux";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->platreux_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Plâtreux";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->elastique_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Elastique";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->autre_texture_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche].$oneCouche->autre_texture_text_analyse_materiau_v0_couche;
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->blanc_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Blanc";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->beige_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Beige";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->gris_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Gris";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->noir_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Noir";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->jaune_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Jaune";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->rouge_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Rouge";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->vert_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Vert";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->bleu_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Bleu";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->marron_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche]."Marron";
			if($descriptif_couche[$num_couche]<>"")$separator[$num_couche]= ", ";
			if($oneCouche->autre_couleur_analyse_materiau_v0_couche == "1") $descriptif_couche[$num_couche].=$separator[$num_couche].$oneCouche->autre_couleur_text_analyse_materiau_v0_couche;	
		}
		
		$rowspan = 0;
		$i=0;
		$nb_row = 0;
		$DataTable=[];
		$ListeAnalyseMateriauV0MolpCouche = $model->ListeAnalyseMateriauV0MolpCouche($oneEchantillon->id_analyse_materiau_v0);
		foreach($ListeAnalyseMateriauV0MolpCouche as $oneMolpCouche){
			
			$nb_prepa = 0;
			foreach($model->ListeAnalyseMateriauV0MolpPrepa($oneEchantillon->id_analyse_materiau_v0, $oneMolpCouche->num_couche_analyse_materiau_v0_molp_couche) as $oneMolpPrepa){
				if($oneMolpPrepa->refraction_analyse_materiau_v0_molp_prepa <> "") $nb_prepa++;
			}
			
			if($nb_prepa > 0){
				$resultat="";
				$fibre="";
				if($oneMolpCouche->resultat_analyse_materiau_v0_molp_couche == "Présence"){
					$separator_fibre="";
					if($fibre<>"")$separator_fibre= ", ";
					if($oneMolpCouche->fibre_ch_analyse_materiau_v0_molp_couche == "1") $fibre=$separator_fibre."Chrysotile";
					if($fibre<>"")$separator_fibre= ", ";
					if($oneMolpCouche->fibre_am_analyse_materiau_v0_molp_couche == "1") $fibre=$separator_fibre."Amosite";
					if($fibre<>"")$separator_fibre= ", ";
					if($oneMolpCouche->fibre_ant_analyse_materiau_v0_molp_couche == "1") $fibre=$separator_fibre."Anthophyllite";
					if($fibre<>"")$separator_fibre= ", ";
					if($oneMolpCouche->fibre_tr_analyse_materiau_v0_molp_couche == "1") $fibre=$separator_fibre."Tremolite";
					if($fibre<>"")$separator_fibre= ", ";
					if($oneMolpCouche->fibre_ac_analyse_materiau_v0_molp_couche == "1") $fibre=$separator_fibre."Actinolite";
					if($fibre<>"")$separator_fibre= ", ";
					if($oneMolpCouche->fibre_cr_analyse_materiau_v0_molp_couche == "1") $fibre=$separator_fibre."Crocidolite";
					$resultat="Présence";
				}else{
					$resultat="Absence";
				}
				
				if($fibre == "") $fibre = "/";
				
				$couches = explode("+", str_replace("C", "", $oneMolpCouche->titre_couche_analyse_materiau_v0_molp_couche));
				$separator_description="";
				foreach($couches as $CurrentCouche){
					$separator_description=""; if($DataTable[$i]['titre']<>"") $separator_description= "\n";
					$DataTable[$i]['titre'].= $separator_description.'C'.$CurrentCouche.' : '.$descriptif_couche[$CurrentCouche];
				}
				
				$couche_indisso = '';
				if(strpos($oneMolpCouche->titre_couche_analyse_materiau_v0_molp_couche, '+') !== false)
					$couche_indisso = "\nPrise d'essai ne permet pas de dissocier strictement les couches";
				
				$observation_analyse_materiau_v0_molp_couche = "";
				if(($oneMolpCouche->observation_analyse_materiau_v0_molp_couche <> "") && ($oneMolpCouche->observation_analyse_materiau_v0_molp_couche <> "/"))
					$observation_analyse_materiau_v0_molp_couche = '\n'.nl2br($oneMolpCouche->observation_analyse_materiau_v0_molp_couche);
			
				$DataTable[$i]['methode'] = "MOLP";
				$DataTable[$i]['nb_support'] = $oneMolpCouche->lames_analyse_materiau_v0_molp_couche;
				$DataTable[$i]['type_prepa'] = "Dépôt sur Lame avec indice de réfraction";
				$DataTable[$i]['nb_prepa'] = $nb_prepa;
				$DataTable[$i]['resultat']=$resultat;
				$DataTable[$i]['fibre']=$fibre;
				$DataTable[$i]['observation']='Analysé par: '.$oneTechnicienMOLP->initiale_technicien_labo.$couche_indisso.$observation_analyse_materiau_v0_molp_couche;
				$rowspan++;
				$i++;
			}
		}
		
		
		$ListeAnalyseMateriauV0MetCouche = $model->ListeAnalyseMateriauV0MetCouche($oneEchantillon->id_analyse_materiau_v0);
		foreach($ListeAnalyseMateriauV0MetCouche as $oneMetCouche){
			$fibre=[];
			$nb_prepa = 0;
			foreach($model->ListeAnalyseMateriauV0MetPrepa($oneEchantillon->id_analyse_materiau_v0, $oneMetCouche->num_couche_analyse_materiau_v0_met_couche) as $oneMetPrepa){
				if($oneMetPrepa->acceptation_analyse_materiau_v0_met_prepa <> "0")$nb_prepa++;

				if($oneMetPrepa->fibre_ch_analyse_materiau_v0_met_prepa == "1") $fibre[]="Chrysotile";
				if($oneMetPrepa->fibre_am_analyse_materiau_v0_met_prepa == "1") $fibre[]="Amosite";
				if($oneMetPrepa->fibre_ant_analyse_materiau_v0_met_prepa == "1") $fibre[]="Anthophyllite";
				if($oneMetPrepa->fibre_tr_analyse_materiau_v0_met_prepa == "1") $fibre[]="Tremolite";
				if($oneMetPrepa->fibre_ac_analyse_materiau_v0_met_prepa == "1") $fibre[]="Actinolite";
				if($oneMetPrepa->fibre_cr_analyse_materiau_v0_met_prepa == "1") $fibre[]="Crocidolite";
			}
			
				if($nb_prepa > 0){
				$fibre= array_unique($fibre);
				$resultat="";
				$separator_resultat="";
				$typefibre= "";
				foreach($fibre as $oneFibre){
					if($typefibre<>"") $separator_resultat= ", ";
					$typefibre.=$separator_resultat.$oneFibre;
				}
				
				if($typefibre == ""){
					$resultat="Absence";
				}else{
					$resultat="Présence";
				}
				
				if($typefibre == "") $typefibre = "/";
				
				
				
				$couches = explode("+", str_replace("C", "", $oneMetCouche->titre_analyse_materiau_v0_met_couche));
				$separator_description="";
				foreach($couches as $CurrentCouche){
					$separator_description=""; if($DataTable[$i]['titre']<>"") $separator_description= "\n";
					$DataTable[$i]['titre'].= $separator_description.'C'.$CurrentCouche.' : '.$descriptif_couche[$CurrentCouche];
				}
				
				$couche_indisso = '';
				if(strpos($oneMetCouche->titre_analyse_materiau_v0_met_couche, '+') !== false)
					$couche_indisso = "\nPrise d'essai ne permet pas de dissocier strictement les couches";
				
				$couche_equiv = "\nprise d'essai non équivalente des couches";
				if($oneMetCouche->quantite_equivalente_analyse_materiau_v0_met_couche == "Oui") 
					$couche_equiv = "\nprise d'éssai équivalente des couches";
				
				$observation_analyse_materiau_v0_met_couche = "";
				if(($oneMetCouche->observation_analyse_materiau_v0_met_couche <> "") && ($oneMetCouche->observation_analyse_materiau_v0_met_couche <> "/"))
					$observation_analyse_materiau_v0_met_couche = '\n'.nl2br($oneMetCouche->observation_analyse_materiau_v0_met_couche);
				
				$DataTable[$i]['methode'] = "MET";
				$DataTable[$i]['nb_support'] = $oneMetCouche->depot_analyse_materiau_v0_met_couche;
				$DataTable[$i]['type_prepa'] = "Broyage mécanique et attaque chimique";
				$DataTable[$i]['nb_prepa'] = $nb_prepa;
				$DataTable[$i]['resultat']=$resultat;
				$DataTable[$i]['fibre']=$typefibre;
				$DataTable[$i]['observation']='Analysé par: '.$oneTechnicienMET->initiale_technicien_labo.$couche_indisso.$observation_analyse_materiau_v0_met_couche;
				$rowspan++;
				$i++;
			}
		}
		
		$line++;
		$i = 0;
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($Cell[$i++].$line, $oneEchantillon->nom_client_analyse)
			->setCellValue($Cell[$i++].$line, $oneEchantillon->nom_demandeur_analyse_dossier)
			->setCellValue($Cell[$i++].$line, $oneEchantillon->adresse_analyse_dossier)
			->setCellValue($Cell[$i++].$line, $date_envoi_analyse_dossier)
			->setCellValue($Cell[$i++].$line, $oneEchantillon->ref_affaire_analyse_dossier)
			->setCellValue($Cell[$i++].$line, $oneEchantillon->chantier_analyse_dossier)
			
			->setCellValue($Cell[$i++].$line, $oneEchantillon->ref_dossier)
			->setCellValue($Cell[$i++].$line, date('d-m-Y', strtotime($oneEchantillon->date_reception_dossier)))
			->setCellValue($Cell[$i++].$line, date('d-m-Y', strtotime($oneEchantillon->date_previsionnelle_dossier)))
			->setCellValue($Cell[$i++].$line, $date_analyse)
			->setCellValue($Cell[$i++].$line, date("d-m-Y", strtotime($oneEchantillon->date_validation_analyse_materiau_v0)))
			
			->setCellValue($Cell[$i++].$line, $oneEchantillon->ref_client_echantillon_analyse)
			->setCellValue($Cell[$i++].$line, $oneEchantillon->nom_type_prelevement)
			->setCellValue($Cell[$i++].$line, $oneEchantillon->aspect_materiau_echantillon_analyse)
			->setCellValue($Cell[$i++].$line, $oneEchantillon->localisation_echantillon_analyse)
			->setCellValue($Cell[$i++].$line, $oneEchantillon->nature_produit_materiau_echantillon_analyse)
			->setCellValue($Cell[$i++].$line, $oneEchantillon->pollution_produit_materiau_echantillon_analyse)
			
			->setCellValue($Cell[$i++].$line, $oneEchantillon->ref_dossier)
			->setCellValue($Cell[$i++].$line, $oneEchantillon->ref_echantillon_analyse);
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->applyFromArray($style_border);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->applyFromArray($style_texte_center);
		
		//Rowspan
		
		if($rowspan == 0){
			$rowspan = 1;
			$commentaire = ""; if(($oneEchantillon->commentaire_analyse_materiau_v0 <> "") && ($oneEchantillon->commentaire_analyse_materiau_v0 <> "/"))
				$commentaire = "\n".$oneEchantillon->commentaire_analyse_materiau_v0;
			$DataTable[$i]['observation'] = "Non analysable".$commentaire;
		}
			
		for($Cell2Merge = 0; $Cell2Merge <= 18; $Cell2Merge++){
			$objPHPExcel->getActiveSheet()->mergeCells($Cell[$Cell2Merge].($line).':'.$Cell[$Cell2Merge].($line+$rowspan-1));
			$objPHPExcel->getActiveSheet()->getStyle($Cell[$Cell2Merge].($line).':'.$Cell[$Cell2Merge].($line+$rowspan-1))->applyFromArray($style_border);
		}
		
		$current_row=0;
		foreach($DataTable as $oneLine){
			$i = 19;
			$current_row++;
			if($current_row > 1) $line++;
				
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($Cell[$i++].$line, $oneLine['titre'])
				->setCellValue($Cell[$i++].$line, $oneLine['methode'])
				->setCellValue($Cell[$i++].$line, $oneLine['nb_support'])
				->setCellValue($Cell[$i++].$line, $oneLine['type_prepa'])
				->setCellValue($Cell[$i++].$line, $oneLine['nb_prepa'])
				->setCellValue($Cell[$i++].$line, $oneLine['resultat'])
				->setCellValue($Cell[$i++].$line, $oneLine['fibre'])
				->setCellValue($Cell[$i++].$line, $oneLine['observation']);
			
			$objPHPExcel->getActiveSheet()->getStyle($Cell[19].$line.':'.$Cell[$i-1].$line)->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle($Cell[19].$line.':'.$Cell[$i-1].$line)->applyFromArray($style_border);
			$objPHPExcel->getActiveSheet()->getStyle($Cell[19].$line.':'.$Cell[$i-1].$line)->applyFromArray($style_texte_center);
			
			
			if($oneLine['resultat'] == "Présence")
				$objPHPExcel->getActiveSheet()->getStyle($Cell[24].$line.':'.$Cell[25].$line)->applyFromArray($style_texte_alerte);
		}
	}
	
	foreach($Cell as $columnID) {
		$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}	
	
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('1');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F Page &P / &N');

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="extract-Materiaux-ext-'.date('Ymd-His').'.xlsx"');
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
