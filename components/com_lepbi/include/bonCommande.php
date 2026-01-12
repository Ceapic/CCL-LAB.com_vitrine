<?php 
	$DynamicTable = $model0->ListeTableauDynamic($id_strategie);
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	$DataRecorder = [];
	
	$filtre = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
				'size'  => 12,
				'name'  => 'Calibri'
		)
	);
	
	$style_texte_calibri_blue = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '0070C0'),
				'size'  => 12,
				'name'  => 'Calibri'
		)
	);
	
	$style_horizontal_center = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
	
	$style_texte_center = array(
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
	);
	
	$style_border = array(
		'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_MEDIUM
			)
		)
	);
	
	$style_background_grey = array(
		'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'BFBFBF')
        )
	);
	
	$Cell = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
				'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
	
	$i = 0;
	$line = 1;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($Cell[$i++].$line, "Contexte")
				->setCellValue($Cell[$i++].$line, "Zone")
				->setCellValue($Cell[$i++].$line, "Mesure")
				->setCellValue($Cell[$i++].$line, "Qté Préconisé")
				->setCellValue($Cell[$i++].$line, "Qté souhaité")
				->setCellValue($Cell[$i++].$line, "Date")
				->setCellValue($Cell[$i++].$line, "Horaire")
				->setCellValue($Cell[$i++].$line, "Elec dispo");
	$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->applyFromArray($filtre);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->applyFromArray($style_border);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->getAlignment()->setWrapText(true);
	
	function AddRow($objPHPExcel, $line, $contexte, $zone, $mesure, $quantite){
		$style_texte_calibri_blue = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '0070C0'),
					'size'  => 12,
					'name'  => 'Calibri'
			)
		);
		
		$style_texte_center = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);
		
		$style_border = array(
			'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_MEDIUM
				)
			)
		);
		
		$style_background_grey = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'BFBFBF')
			)
		);
	
		$Cell = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
				'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		
		$i=0;
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($Cell[$i++].$line, $contexte)
			->setCellValue($Cell[$i++].$line, $zone)
			->setCellValue($Cell[$i++].$line, $mesure)
			->setCellValue($Cell[$i++].$line, $quantite)
			->setCellValue($Cell[$i++].$line, "")
			->setCellValue($Cell[$i++].$line, "")
			->setCellValue($Cell[$i++].$line, "")
			->setCellValue($Cell[$i++].$line, "");
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->applyFromArray($style_border);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$line.':'.$Cell[$i-1].$line)->applyFromArray($style_texte_calibri_blue);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$line.':'.$Cell[$i-1].$line)->applyFromArray($style_background_grey);
	}
	
	foreach($DynamicTable as $oneDynamicTable){	
		$count_table++;
		
		if ($oneDynamicTable->TYPE_TABLE == 2){
			$Rows = $model0->ListeZoneTravailMultiRow($oneDynamicTable->ID);
			
			// CONTEXTE
			$contexte = "";
			$separator = "";
			if($count_table > 1){
				foreach($model0->AfficheTypeMesureZoneTravailRow($oneDynamicTable->ID) as $oneTypeMesure){	
					if ($contexte <> ""){$separator = " & ";}
					$contexte.= $separator . $oneTypeMesure->nom_pdf_contexte_mesure_strategie;
				}
			}
			
			// ZONE
			$ZoneTravail = $model0->AfficheZoneTravail($oneDynamicTable->SELECT);
			$zone = $ZoneTravail[0]->nom_zone_travail;
			
			foreach($Rows as $oneRow) {
				
				// MESURE
				$Mesure = $model0->AfficheMesureStrategie($oneRow->type_mesure_zone_travail_multi_row);
				$mesure = str_replace("Exigence réglementaire", "(R)", $Mesure[0]->nom_type_mesure_strategie);
				
				// QUANTITE
				$quantite = $oneRow->nbr_prelevement_zone_travail_multi_row;
				
				$line++;
				AddRow($objPHPExcel, $line, $contexte, $zone, $mesure, $quantite);
				$DataRecorder[] = [$line, $contexte, $zone];
			}
		}
		
		if ($oneDynamicTable->TYPE_TABLE == 3){
			$Rows = $model0->ListeZoneTravailMultiRow($oneDynamicTable->ID);
			$Mesure = $model0->AfficheMesureStrategie($oneDynamicTable->CONTEXTE);
			
			// CONTEXTE
			$contexte = $Mesure[0]->nom_pdf_contexte_mesure_strategie;
			
			foreach($model0->ListeObjectifStrategieRow($oneDynamicTable->ID) as $oneRow){
				// ZONE
				$ZoneHomogene = $model0->AfficheZoneHomogene($oneRow->zone_homogene_objectif_strategie_row);
				$zone = $ZoneHomogene[0]->nom_zone_homogene;
				
				// MESURE
				$mesure = str_replace("Exigence réglementaire", "(R)", $Mesure[0]->nom_type_mesure_strategie);
				
				// QUANTITE
				$quantite = $oneRow->nbr_prelevement_objectif_strategie_row;
				
				$line++;
				AddRow($objPHPExcel, $line, $contexte, $zone, $mesure, $quantite);
				$DataRecorder[] = [$line, $contexte, $zone];
			}
		}
		
		if($oneDynamicTable->TYPE_TABLE == 4){
			$Mesure = $model0->AfficheMesureStrategie($oneDynamicTable->CONTEXTE);
			
			// CONTEXTE
			$contexte = $Mesure[0]->nom_pdf_contexte_mesure_strategie;
			
			foreach($model0->ListeZoneTravailMonoRow($oneDynamicTable->ID) as $oneRow){
				
				// ZONE
				$zone = $oneRow->nom_zone_travail;
				
				// MESURE
				$mesure = str_replace("Exigence réglementaire", "(R)", $Mesure[0]->nom_type_mesure_strategie);
				
				// QUANTITE
				$quantite = $oneRow->nbr_prelevement_zone_travail_mono_row;
				
				$line++;
				AddRow($objPHPExcel, $line, $contexte, $zone, $mesure, $quantite);
				$DataRecorder[] = [$line, $contexte, $zone];
			}
		}
	}
	
	
	// Apply merge
	$i = 0;
	$mergeContexteStart = 1;
	$mergeZoneStart = 1;
	foreach($DataRecorder as $oneDataLine){
		if(($i == 0) || ($DataRecorder[$i-1][1] <> $oneDataLine[1])){
			$objPHPExcel->getActiveSheet()->mergeCells('A'. $mergeContexteStart .':A'. ($oneDataLine[0]-1));
			$mergeContexteStart = $oneDataLine[0];
		}
		
		if(($i == 0) || ($DataRecorder[$i-1][1] <> $oneDataLine[1]) || ($DataRecorder[$i-1][2] <> $oneDataLine[2])){
			$objPHPExcel->getActiveSheet()->mergeCells('B'. $mergeZoneStart .':B'. ($oneDataLine[0]-1));
			$mergeZoneStart = $oneDataLine[0];
		}
		$i++;
	}
	$lastLine = end($DataRecorder);
	$objPHPExcel->getActiveSheet()->mergeCells('A'. $mergeContexteStart .':A'. $lastLine[0]);
	$objPHPExcel->getActiveSheet()->mergeCells('B'. $mergeZoneStart .':B'. $lastLine[0]);
	
	// Horizonttal align for merge
	$objPHPExcel->getActiveSheet()->getStyle('A1:A'.$line)->applyFromArray($style_horizontal_center);
	$objPHPExcel->getActiveSheet()->getStyle('B1:B'.$line)->applyFromArray($style_horizontal_center);
	
	
	
	// Auto size by column A to D
	// foreach($Cell as $columnID) {
		// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	// }
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(100);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);	
	
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Ceapic BdC');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F Page &P / &N');

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="CEAPIC BdC.xlsx"');
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