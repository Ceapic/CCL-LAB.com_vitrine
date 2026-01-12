<?php

require_once '/libraries/phpexcel/PHPExcel/IOFactory.php';
// $model = $this->getModel('management'); // nom model

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Cell Style
$style_titre = array(
	'font'  => array(
		'bold'  => true,
		'color' => array('rgb' => '000000'),
		'size'  => 12,
		'name'  => 'Calibri'
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	),
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_MEDIUM
		)
	)
);

$style_default = array(
	'font'  => array(
		'bold'  => true,
		'color' => array('rgb' => '000000'),
		'size'  => 8,
		'name'  => 'arial'
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	)
);

$style_border = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THICK
		),
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('k')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getStyle('A1:Y2')->applyFromArray($style_titre);

$objPHPExcel->getDefaultStyle()->applyFromArray($style_default);

$objPHPExcel->setActiveSheetIndex(0)
	->mergeCells('B1:G1')
	->mergeCells('H1:K1')
	->mergeCells('N1:Y1');

$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('B1', "Dossier")
	->setCellValue('H1', "Info client")
	->setCellValue('N1', "Info labo");

$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', "Client")
	->setCellValue('B2', "Dossier")
	->setCellValue('C2', "Dossier client")
	->setCellValue('D2', "Date reception")
	->setCellValue('E2', "Date enregistrement")
	->setCellValue('F2', "Date analyse")
	->setCellValue('G2', "Date prévisionnelle")
	->setCellValue('H2', "Ref éch")
	->setCellValue('I2', "Objectif")
	->setCellValue('J2', "Descriptif")
	->setCellValue('K2', "Localisation")
	->setCellValue('L2', "Volume")
	->setCellValue('M2', "Incertitude")
	->setCellValue('N2', "Ref éch")
	->setCellValue('O2', "Fraction filtre")
	->setCellValue('P2', "Nbr d'ouvertures")
	->setCellValue('Q2', "Nbr de fibres")
	->setCellValue('R2', "Variété d'amiante")
	->setCellValue('S2', "SA(F/L)")
	->setCellValue('T2', "Surface grille (mm²)")
	->setCellValue('U2', "Surface filtration (mm²)")
	->setCellValue('V2', "Conc Calculée(F/L)")
	->setCellValue('W2', "Conc Norma(F/L)")
	->setCellValue('X2', "Borne inf(F/L)")
	->setCellValue('Y2', "Borne sup(F/L)");

$rowcount = 2;

foreach ($model->ListeAnalyseMETAv0Client($id_client, $date_debut, $date_fin) as $oneEchantillon) {
	$rowcount++;

	$fraction_filtre = str_replace(".", ",", $oneEchantillon->fraction_filtre_analyse_meta_v0);
	$nombre_champ = str_replace(".", ",", $oneEchantillon->nombre_champ_analyse_meta_v0);
	$nombre_fibre = str_replace(".", ",", $oneEchantillon->nombre_fibre_analyse_meta_v0);
	$type_fibre = $oneEchantillon->type_fibre_analyse_meta_v0;

	$surface_grille = str_replace(".", ",", $oneEchantillon->surface_grille_analyse_meta_v0);
	$surface_filtration = str_replace(".", ",", $oneEchantillon->surface_filtration_analyse_meta_v0);
	$total_filtre = str_replace(".", ",", $oneEchantillon->total_filtre_analyse_meta_v0);
	$nombre_grille = $onePrepa->nombre_grille_analyse_meta_v0_prepa;

	$SA_filtre = $oneEchantillon->sa_densite_filtre_analyse_meta_v0;
	$densite_filtre = $oneEchantillon->concentration_normalise_densite_filtre_analyse_meta_v0;
	$densite_normalisee = $oneEchantillon->cinf_densite_filtre_analyse_meta_v0;
	$intervalle_confiance_filtre = $oneEchantillon->cinf_densite_filtre_analyse_meta_v0 . " < D < " . $oneEchantillon->csup_densite_filtre_analyse_meta_v0;

	$SA_litre = number_format($oneEchantillon->sa_concentration_analyse_meta_v0, 2, ",", "");
	$concentration_calculee = number_format($oneEchantillon->concentration_calcule_concentration_analyse_meta_v0, 2, ",", "");
	$concentration_normalisee = number_format($oneEchantillon->concentration_normalise_concentration_analyse_meta_v0, 2, ",", "");
	if ($nombre_fibre < 4) $concentration_normalisee = "<" . $concentration_normalisee;
	$intervalle_confiance_litre = "/ < C < " . number_format($oneEchantillon->csup_concentration_analyse_meta_v0, 2, ",", "");
	if ($nombre_fibre >= 4) $intervalle_confiance_litre = number_format($oneEchantillon->cinf_concentration_analyse_meta_v0, 2, ",", "") . " < C < " . number_format($oneEchantillon->csup_concentration_analyse_meta_v0, 2, ",", "");

	if (($oneEchantillon->decision_anomalie_reception_analyse_meta_v0 == "Echantillon inanalysable") || ($oneEchantillon->decision_anomalie_grille_analyse_meta_v0_prepa == "Echantillon inanalysable")) {
		$fraction_filtre = $oneEchantillon->fraction_filtre_analyse_meta_v0;
		$nombre_champ = "/";
		$nombre_fibre = "/";
		$type_fibre = "/";

		$SA_filtre = "/";
		$densite_filtre_calculee = "/";
		$densite_filtre_normalisee = "/";
		$intervalle_confiance_filtre = "/";

		$SA_litre = "/";
		$concentration_calculee = "/";
		$concentration_normalisee = "/";
		$intervalle_confiance_litre = "/";
	}

	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $rowcount, $oneEchantillon->nom_client_analyse)
		->setCellValue('B' . $rowcount, $oneEchantillon->ref_dossier)
		->setCellValue('C' . $rowcount, $oneEchantillon->chantier_analyse_dossier)
		->setCellValue('D' . $rowcount, date("d-m-Y", strtotime($oneEchantillon->date_reception_dossier)))
		->setCellValue('E' . $rowcount, date("d-m-Y", strtotime($oneEchantillon->date_enregistrement_dossier)))
		->setCellValue('F' . $rowcount, date("d-m-Y", strtotime($oneEchantillon->date_analyse_analyse_meta_v0_prepa)))
		->setCellValue('G' . $rowcount, date("d-m-Y", strtotime($oneEchantillon->date_previsionnelle_dossier)))
		->setCellValue('H' . $rowcount, $oneEchantillon->ref_client_echantillon_analyse)
		->setCellValue('I' . $rowcount, $oneEchantillon->nom_type_prelevement)
		->setCellValue('J' . $rowcount, $oneEchantillon->description_echantillon_analyse)
		->setCellValue('K' . $rowcount, $oneEchantillon->localisation_echantillon_analyse)
		->setCellValue('L' . $rowcount, $oneEchantillon->volume_analyse_meta_v0)
		->setCellValue('M' . $rowcount, $oneEchantillon->incertitude_volume_analyse_meta_v0)
		->setCellValue('N' . $rowcount, $oneEchantillon->ref_echantillon_analyse)
		->setCellValue('O' . $rowcount, $fraction_filtre)
		->setCellValue('P' . $rowcount, $nombre_champ)
		->setCellValue('Q' . $rowcount, $nombre_fibre)
		->setCellValue('R' . $rowcount, $type_fibre)
		->setCellValue('S' . $rowcount, $SA_litre)
		->setCellValue('T' . $rowcount, $surface_grille)
		->setCellValue('U' . $rowcount, $surface_filtration)
		->setCellValue('V' . $rowcount, $concentration_calculee)
		->setCellValue('W' . $rowcount, $concentration_normalisee)
		->setCellValue('X' . $rowcount, $oneEchantillon->cinf_concentration_analyse_meta_v0)
		->setCellValue('Y' . $rowcount, $oneEchantillon->csup_concentration_analyse_meta_v0);
}

foreach ($model->getAnalysesMetaV1Client($id_client, $date_debut, $date_fin) as $oneEchantillon) {
	$rowcount++;

	$fraction_filtre = str_replace(".", ",", $oneEchantillon->fraction_moyenne);
	$nombre_champ = str_replace(".", ",", $oneEchantillon->nbr_champs);
	$nombre_fibre = str_replace(".", ",", $oneEchantillon->nbr_fibres);
	$type_fibre = $oneEchantillon->type_fibres;

	$surface_grille = str_replace(".", ",", $oneEchantillon->surface_ouverture);
	$surface_filtration = str_replace(".", ",", $oneEchantillon->surface_filtration);
	$total_filtre = str_replace(".", ",", $oneEchantillon->nbr_filtres);
	$nombre_grille = $onePrepa->nbr_grilles;

	$SA_filtre = $oneEchantillon->sa_densite_filtre;
	$densite_filtre = $oneEchantillon->concentration_normalise;
	$densite_normalisee = $oneEchantillon->cinf_densite_filtre;
	$intervalle_confiance_filtre = $oneEchantillon->cinf_densite_filtre . " < D < " . $oneEchantillon->csup_densite_filtre;

	$SA_litre = number_format($oneEchantillon->sa_concentration, 2, ",", "");
	$concentration_calculee = number_format($oneEchantillon->concentration_calcule, 2, ",", "");
	$concentration_normalisee = number_format($oneEchantillon->concentration_normalise, 2, ",", "");
	if ($nombre_fibre < 4) $concentration_normalisee = "<" . $concentration_normalisee;
	$intervalle_confiance_litre = "/ < C < " . number_format($oneEchantillon->csup_concentration, 2, ",", "");
	if ($nombre_fibre >= 4) $intervalle_confiance_litre = number_format($oneEchantillon->cinf_concentration, 2, ",", "") . " < C < " . number_format($oneEchantillon->csup_concentration, 2, ",", "");

	if (($oneEchantillon->decision_decoupe == "Inanalysable") || ($oneEchantillon->decision_grille == "Inanalysable")) {
		$fraction_filtre = $oneEchantillon->fraction_filtre;
		$nombre_champ = "/";
		$nombre_fibre = "/";
		$type_fibre = "/";

		$SA_filtre = "/";
		$densite_filtre_calculee = "/";
		$densite_filtre_normalisee = "/";
		$intervalle_confiance_filtre = "/";

		$SA_litre = "/";
		$concentration_calculee = "/";
		$concentration_normalisee = "/";
		$intervalle_confiance_litre = "/";
	}

	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $rowcount, $oneEchantillon->nom_client_analyse)
		->setCellValue('B' . $rowcount, $oneEchantillon->ref_dossier)
		->setCellValue('C' . $rowcount, $oneEchantillon->chantier_analyse_dossier)
		->setCellValue('D' . $rowcount, date("d-m-Y", strtotime($oneEchantillon->date_reception_dossier)))
		->setCellValue('E' . $rowcount, date("d-m-Y", strtotime($oneEchantillon->date_enregistrement_dossier)))
		->setCellValue('F' . $rowcount, date("d-m-Y", strtotime($oneEchantillon->date_analyse)))
		->setCellValue('G' . $rowcount, date("d-m-Y", strtotime($oneEchantillon->date_previsionnelle_dossier)))
		->setCellValue('H' . $rowcount, $oneEchantillon->ref_client_echantillon_analyse)
		->setCellValue('I' . $rowcount, $oneEchantillon->nom_type_prelevement)
		->setCellValue('J' . $rowcount, $oneEchantillon->description_echantillon_analyse)
		->setCellValue('K' . $rowcount, $oneEchantillon->localisation_echantillon_analyse)
		->setCellValue('L' . $rowcount, $oneEchantillon->volume)
		->setCellValue('M' . $rowcount, $oneEchantillon->incertitude_volume)
		->setCellValue('N' . $rowcount, $oneEchantillon->ref_echantillon_analyse)
		->setCellValue('O' . $rowcount, $fraction_filtre)
		->setCellValue('P' . $rowcount, $nombre_champ)
		->setCellValue('Q' . $rowcount, $nombre_fibre)
		->setCellValue('R' . $rowcount, $type_fibre)
		->setCellValue('S' . $rowcount, $SA_litre)
		->setCellValue('T' . $rowcount, $surface_grille)
		->setCellValue('U' . $rowcount, $surface_filtration)
		->setCellValue('V' . $rowcount, $concentration_calculee)
		->setCellValue('W' . $rowcount, $concentration_normalisee)
		->setCellValue('X' . $rowcount, $oneEchantillon->cinf_concentration)
		->setCellValue('Y' . $rowcount, $oneEchantillon->csup_concentration);
}


$objPHPExcel->getActiveSheet()->getStyle('A3:Y' . $rowcount)->applyFromArray($style_border);

/*foreach ($Cell as $columnID) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}*/

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('1');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F Page &P / &N');

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="extract-Materiaux-ext-' . date('Ymd-His') . '.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
