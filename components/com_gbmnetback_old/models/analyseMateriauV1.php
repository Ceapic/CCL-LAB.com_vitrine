<?php
// no direct access
defined('_JEXEC') or die('Acces interdit');

jimport('joomla.application.component.model');

class AnalyseMateriauV1 {

	/* ============= CONSTANTS DEFINITION ============= */

	// META constants
	public static $META_ANALYSE_NO_NEED = 0;
	public static $META_PREPA_WAITING = 1;
	public static $META_PREPA_REDO = 2;
	public static $META_PREPA_DONE = 3;
	public static $META_DEPOT_REDO = 4;
	public static $META_DEPOT_DONE = 5;
	public static $META_RANGEMENT_DONE = 6;
	public static $META_ANALYSE_WAITING = 7;
	public static $META_PRE_VALIDATION = 8;
	public static $META_ANALYSE_DONE = 9;

	// MOLP constants
	public static $MOLP_ANALYSE_NO_NEED = 0;
	public static $MOLP_ANALYSE_WAITING = 1;
	public static $MOLP_VALIDATION_TECHIQUE = 2;
	public static $MOLP_ANALYSE_DONE = 3;

	/* ============= METHOD DEFINITION ============= */

	function addAnalyseMateriauV1($echantillon_analyse_materiau_v1, $type_dossier_analyse_materiau_v1, $revision_analyse_materiau_v1, $description_revision_analyse_materiau_v1, $cofrac_analyse_materiau_v1, $commentaire_validation_analyse_materiau_v1) {
		$data = new stdClass();
		$data->id_analyse_materiau_v1 = null;
		$data->echantillon_analyse_materiau_v1 = $echantillon_analyse_materiau_v1;
		$data->type_dossier_analyse_materiau_v1 = $type_dossier_analyse_materiau_v1;
		$data->date_analyse_materiau_v1 = date('Y-m-d H:i:s');
		$data->validation_analyse_materiau_v1 = 2;
		$data->valideur_analyse_materiau_v1 = 0;
		$data->date_validation_analyse_materiau_v1 = $date_validation_analyse_materiau_v1;
		$data->revision_analyse_materiau_v1 = $revision_analyse_materiau_v1;
		$data->description_revision_analyse_materiau_v1 = $description_revision_analyse_materiau_v1;
		$data->cofrac_analyse_materiau_v1 = $cofrac_analyse_materiau_v1;
		$data->commentaire_validation_analyse_materiau_v1 = $commentaire_validation_analyse_materiau_v1;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('analyse_materiau_v1', $data, 'id_analyse_materiau_v1');
		return $db->insertid();
	}

	function addAnalyseMateriauV1_1_ExamPrea($analyse_materiau_v1_exam_prea, $date_analyse_materiau_v1_exam_prea, $operateur_analyse_materiau_v1_exam_prea, $stagiaire_analyse_materiau_v1_exam_prea, $hotte_analyse_materiau_v1_exam_prea, $loupe_analyse_materiau_v1_exam_prea, $commentaire_interne_analyse_materiau_v1_exam_prea, $commentaire_rapport_analyse_materiau_v1_exam_prea) {
		$data = new stdClass();
		$data->id_analyse_materiau_v1_exam_prea  = null;
		$data->analyse_materiau_v1_exam_prea = $analyse_materiau_v1_exam_prea;
		$data->date_analyse_materiau_v1_exam_prea = date('Y-m-d', strtotime($date_analyse_materiau_v1_exam_prea));
		$data->operateur_analyse_materiau_v1_exam_prea = $operateur_analyse_materiau_v1_exam_prea;
		$data->stagiaire_analyse_materiau_v1_exam_prea = $stagiaire_analyse_materiau_v1_exam_prea;
		$data->hotte_analyse_materiau_v1_exam_prea = $hotte_analyse_materiau_v1_exam_prea;
		$data->loupe_analyse_materiau_v1_exam_prea = $loupe_analyse_materiau_v1_exam_prea;
		$data->commentaire_interne_analyse_materiau_v1_exam_prea = $commentaire_interne_analyse_materiau_v1_exam_prea;
		$data->commentaire_rapport_analyse_materiau_v1_exam_prea = $commentaire_rapport_analyse_materiau_v1_exam_prea;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('analyse_materiau_v1_exam_prea', $data, 'id_analyse_materiau_v1_exam_prea');
		return $db->insertid();
	}

	function addAnalyseMateriauV1_Couche($analyse_materiau_v1_couche, $confirmation_presta_analyse_materiau_v1_couche, $data_couche_analyse_materiau_v1_couche, $meta_analyse_materiau_v1_couche, $molp_analyse_materiau_v1_couche, $remarque_rapport_analyse_materiau_v1_couche, $remarque_interne_analyse_materiau_v1_couche) {
		$data = new stdClass();
		$data->id_analyse_materiau_v1_couche  = null;
		$data->analyse_materiau_v1_couche = $analyse_materiau_v1_couche;
		$data->date_analyse_materiau_v1_couche = date('Y-m-d H:i:s');
		$data->confirmation_presta_analyse_materiau_v1_couche = $confirmation_presta_analyse_materiau_v1_couche;
		$data->data_couche_analyse_materiau_v1_couche = $data_couche_analyse_materiau_v1_couche;
		$data->meta_analyse_materiau_v1_couche = $meta_analyse_materiau_v1_couche;
		$data->molp_analyse_materiau_v1_couche = $molp_analyse_materiau_v1_couche;
		$data->remarque_rapport_analyse_materiau_v1_couche = $remarque_rapport_analyse_materiau_v1_couche;
		$data->remarque_interne_analyse_materiau_v1_couche = $remarque_interne_analyse_materiau_v1_couche;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('analyse_materiau_v1_couche', $data, 'id_analyse_materiau_v1_couche');
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->insertid();
	}

	function getTypeMateriau() {

		return array(
			// array("title"=>"Dalle", "miniTitle"=>"Dalle"),
			// array("title"=>"Colle beige", "miniTitle"=>"Colle beige"),
			// array("title"=>"Colle noire", "miniTitle"=>"Colle noire"),
			// array("title"=>"Plaque", "miniTitle"=>"Plaque"),
			// array("title"=>"Matériau dur", "miniTitle"=>"Matériau dur"),
			// array("title"=>"Matériau polymère", "miniTitle"=>"Matériau polymère"),
			// array("title"=>"Matériau bitumineu", "miniTitle"=>"Matériau bitumineu"),
			// array("title"=>"Toile", "miniTitle"=>"Toile"),
			// array("title"=>"Mousse", "miniTitle"=>"Mousse"),
			// array("title"=>"C.Ciment", "miniTitle"=>"C.Ciment"),
			// array("title"=>"Peinture", "miniTitle"=>"Peinture"),
			// array("title"=>"Enrobé Liant", "miniTitle"=>"Enrobé Liant"),
			// array("title"=>"Témoin", "miniTitle"=>"Témoin"),
			array("title" => "Matériau", "miniTitle" => "Matériau"),
			array("title" => "Enduit peint", "miniTitle" => "Enduit peint"),
			array("title" => "Plaque", "miniTitle" => "Plaque"),
			array("title" => "Mastic", " miniTitle" => "Mastic"),
			array("title" => "Peinture", "miniTitle" => "Peinture"),
			array("title" => "Mousse", "miniTitle" => "Mousse"),
			array("title" => "Tresse", "miniTitle" => "Tresse"),
			array("title" => "Dalle", "miniTitle" => "Dalle"),
			array("title" => "Colle", "miniTitle" => "Colle"),
			array("title" => "Ragréage", "miniTitle" => "Ragréage"),
			array("title" => "Particules", "miniTitle" => "Particules"),
			array("title" => "Polystyrène (no prép)", "miniTitle" => "Polystyrène (no prép)"),
			array("title" => "Carrelage/Faïence (no prép)", "miniTitle" => "Carrelage/Faïence (no prép)"),


		);
	}


	function getTextureMateriau() {

		return array(
			// array("title"=>"Dur(e) massif", "miniTitle"=>"Dur(e) massif"),
			// array("title"=>"Dur(e) fibreux", "miniTitle"=>"Dur(e) fibreux"),
			// array("title"=>"Souple massif", "miniTitle"=>"Souple massif"),
			// array("title"=>"Souple fibreux", "miniTitle"=>"Souple fibreux"),
			// array("title"=>"Tressé(e)", "miniTitle"=>"Tressé(e)"),
			// array("title"=>"Pâteux(se)", "miniTitle"=>"Pâteux(se)"),
			// array("title"=>"Bitumeux(se)", "miniTitle"=>"Bitumeux(se)"),
			// array("title"=>"Bitumeux tressé", "miniTitle"=>"Bitumeux tressé"),
			// array("title"=>"Cimenteux(se)", "miniTitle"=>"Cimenteux(se)"),
			// array("title"=>"Plâtreux(se)", "miniTitle"=>"Plâtreux(se)"),
			// array("title"=>"Effritable", "miniTitle"=>"Effritable"),
			// array("title"=>"Fibreux(se)", "miniTitle"=>"Fibreux(se)"),
			array("title" => "Thermoplastique", "miniTitle" => "Thermoplastique"),
			array("title" => "Dur", "miniTitle" => "Dur"),
			array("title" => "Souple", "miniTitle" => "Souple"),
			array("title" => "Pâteux", "miniTitle" => "Pâteux"),
			array("title" => "Peint", "miniTitle" => "Peint"),
			array("title" => "Plâtreux", "miniTitle" => "Plâtreux"),
			array("title" => "Cimenteux", "miniTitle" => "Cimenteux"),
			array("title" => "Bitumineux", "miniTitle" => "Bitumineux"),
			array("title" => "Poudreux", "miniTitle" => "Poudreux"),
			array("title" => "Fibreux", "miniTitle" => "Fibreux"),
			array("title" => "Effritable", "miniTitle" => "Effritable"),
		);
	}

	function getCouleurMateriau() {

		return array(
			// array("title"=>"Blanc", "miniTitle"=>"Blanc"),
			// array("title"=>"Beige", "miniTitle"=>"Beige"),
			// array("title"=>"Jaune", "miniTitle"=>"Jaune"),
			// array("title"=>"Vert(e)", "miniTitle"=>"Vert(e)"),
			// array("title"=>"Orange", "miniTitle"=>"Orange"),
			// array("title"=>"Rouge", "miniTitle"=>"Rouge"),
			// array("title"=>"Translucide", "miniTitle"=>"Translucide"),
			// array("title"=>"Bleu(e)", "miniTitle"=>"Bleu(e)"),
			// array("title"=>"Translucide", "miniTitle"=>"Translucide"),
			// array("title"=>"Marron", "miniTitle"=>"Marron"),
			// array("title"=>"Gris", "miniTitle"=>"Gris"),
			// array("title"=>"Kaki", "miniTitle"=>"Kaki"),
			// array("title"=>"Noir(e)", "miniTitle"=>"Noir(e)"),
			array("title" => "Blanc", "miniTitle" => "Blanc"),
			array("title" => "Beige", "miniTitle" => "Beige"),
			array("title" => "Jaune", "miniTitle" => "Jaune"),
			array("title" => "Vert", "miniTitle" => "Vert"),
			array("title" => "Orange", "miniTitle" => "Orange"),
			array("title" => "Rouge", "miniTitle" => "Rouge"),
			array("title" => "Rose", "miniTitle" => "Rose"),
			array("title" => "Mauve", "miniTitle" => "Mauve"),
			array("title" => "Saumon", "miniTitle" => "Saumon"),
			array("title" => "Bleu(e)", "miniTitle" => "Bleu(e)"),
			array("title" => "Marron", "miniTitle" => "Marron"),
			array("title" => "Gris clair", "miniTitle" => "Gris clair"),
			array("title" => "Gris foncé", "miniTitle" => "Gris foncé"),
			array("title" => "Kaki", "miniTitle" => "Kaki"),
			array("title" => "Noir", "miniTitle" => "Noir"),
			array("title" => "Translucide", "miniTitle" => "Translucide"),

		);
	}

	function getTypeFibre() {

		return array(
			array("title" => "CH", "miniTitle" => "CH"),
			array("title" => "AMO", "miniTitle" => "AMO"),
			array("title" => "CRO", "miniTitle" => "CRO"),
			array("title" => "AC/TR/AN", "miniTitle" => "AC/TR/AN"),
			array("title" => "FMS", "miniTitle" => "FMS"),
			array("title" => "FO", "miniTitle" => "FO"),
		);
	}

	function ListeEchantillonAnalyseDossierExamPreaOld($dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
	 			FROM dossier
	 			JOIN client_analyse ON id_client_analyse = client_dossier
	 			JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
	 			JOIN type_prelevement ON id_type_prelevement = detail_echantillon_analyse
	 			JOIN qualification_analyse ON id_qualification_analyse = qualification_analyse_type_prelevement
	 			LEFT JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
	 			LEFT JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
				where id_dossier = " . $dossier . "
				order by id_echantillon_analyse ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeEchantillonAnalyseDossierExamPrea($dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT analyse_materiau_v1.*, analyse_materiau_v1_couche.*, code_article_dossier, methode_analytique_dossier, presta_labo_dossier,
					conformite_reception,
					ref_client_echantillon_analyse,
					methode_analytique_client_analyse,
					prestation_analyse_externe_prestation_delais,
					presta_labo_client_analyse,
					presta_labo_facture_analyse_affaire,
					couche_echantillon_analyse as couche_echantillon,
					id_client_analyse as id_client, 
					id_echantillon_analyse as id_echantillon,  
					ref_echantillon_analyse as ref_echantillon,  
					localisation_echantillon_analyse as localisation_echantillon, 
					fiche_analyse_echantillon_analyse as  fiche_analyse_echantillon
	 			FROM dossier
	 			JOIN client_analyse ON id_client_analyse = client_dossier
	 			JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
	 			LEFT JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = presta_labo_dossier
	 			LEFT JOIN facture_analyse_affaire ON id_facture_analyse_affaire = dossier.facture_analyse_affaire
	 			LEFT JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
	 			LEFT JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
				WHERE id_dossier = {$dossier}
				AND type_dossier = 2
				
				UNION

				SELECT analyse_materiau_v1.*, analyse_materiau_v1_couche.*, code_article_dossier, methode_analytique_dossier, presta_labo_dossier,
					conformite_reception_echantillon as conformite_reception, 
					ref_echantillon as ref_client_echantillon,
					'' as methode_analytique_client_analyse,
					prestation_analyse_externe_prestation_delais,
					'' as presta_labo_client_analyse,
					'' as presta_labo_facture_analyse_affaire,
					couche_echantillon,
					id_client, 
					id_echantillon,  
					ref_echantillon, 
					localisation_echantillon, 
					fiche_analyse_echantillon
	 			FROM dossier
	 			JOIN client ON id_client = client_dossier
	 			JOIN echantillon ON dossier_echantillon = id_dossier
	 			LEFT JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = presta_labo_dossier
	 			LEFT JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon
	 			LEFT JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
				WHERE id_dossier = {$dossier}
				AND type_dossier = 1
				order by id_echantillon ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function listEchantillonMateriauAttenteExamen($select) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT id_echantillon_analyse as id_echantillon, dossier.*, COUNT(id_echantillon_analyse) as nbr_echantillon
				FROM echantillon_analyse
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN analyse_externe_prestation_delais ON presta_labo_dossier = id_analyse_externe_prestation_delais
				WHERE prestation_analyse_externe_prestation_delais = 1
				AND echantillon_analyse.fiche_analyse_echantillon_analyse = 0
				AND type_analyse_dossier = 1
				GROUP BY id_dossier

				UNION
				
				SELECT id_echantillon, dossier.*, COUNT(id_echantillon) as nbr_echantillon
				FROM echantillon
				JOIN dossier ON dossier_echantillon = id_dossier
				JOIN presta ON pose_presta_echantillon = id_presta
				JOIN analyse_externe_prestation_delais ON presta_labo_dossier = id_analyse_externe_prestation_delais
				WHERE prestation_analyse_externe_prestation_delais = 1
				AND  echantillon.fiche_analyse_echantillon = 0
				AND type_analyse_dossier = 1
				GROUP BY id_dossier
				
				ORDER BY date_previsionnelle_dossier";

		// $query = "SELECT id_echantillon_analyse as id_echantillon, dossier.*, COUNT(id_echantillon_analyse) as nbr_echantillon
		// FROM echantillon_analyse
		// JOIN dossier ON dossier_echantillon_analyse = id_dossier
		// WHERE (echantillon_analyse.detail_echantillon_analyse = 23 OR echantillon_analyse.detail_echantillon_analyse = 35 OR echantillon_analyse.detail_echantillon_analyse = 37)
		// AND  echantillon_analyse.fiche_analyse_echantillon_analyse = 0
		// AND type_analyse_dossier = 1
		// GROUP BY id_dossier

		// UNION

		// SELECT id_echantillon, dossier.*, COUNT(id_echantillon) as nbr_echantillon
		// FROM echantillon
		// JOIN dossier ON dossier_echantillon = id_dossier
		// JOIN presta ON pose_presta_echantillon = id_presta
		// WHERE (type_presta = 25 OR type_presta = 71 OR type_presta = 26)
		// AND  echantillon.fiche_analyse_echantillon = 0
		// AND type_analyse_dossier = 1
		// GROUP BY id_dossier

		// ORDER BY date_previsionnelle_dossier"; 
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeEchantillonMateriauxDate($date_debut, $date_fin) {

		$db = JFactory::getDBOGBMNet();
		$MATv1 = "SELECT  /* echantillon externe */
					ref_client_echantillon_analyse AS ref_client_echantillon, ref_echantillon_analyse AS ref_echantillon, id_echantillon_analyse AS id_echantillon, fiche_analyse_echantillon_analyse AS fiche_analyse_echantillon,
					nom_client_analyse AS nom_client,
					ref_dossier as path_pdf,
					nom_qualification_analyse as nom_qualification,
					nom_qualification_analyse as detail_mesure,
					dossier.*,
					id_max_mono, 
					rev_max_mono,
					rev_max_multi,
					validation_analyse_materiau_v1 AS validation_analyse, revision_analyse_materiau_v1 AS revision_analyse,
					'MATERIAUv1' AS type
	   
				FROM echantillon_analyse 
	
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN client_analyse ON client_dossier = id_client_analyse
				
				LEFT JOIN analyse_externe_prestation_objectif ON objectif_echantillon_analyse = id_analyse_externe_prestation_objectif
				JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
						
				JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
				JOIN analyse_externe_polluant ON id_analyse_externe_polluant = polluant_analyse_externe_prestation
				JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse
				
				/* JOIN type_prelevement ON detail_echantillon_analyse = id_type_prelevement */
				/* JOIN qualification_analyse ON qualification_analyse_type_prelevement = id_qualification_analyse */
	
				/* id max pour modification */
				JOIN (
					SELECT id_max_mono, analyse_materiau_v1.echantillon_analyse_materiau_v1, analyse_materiau_v1.type_dossier_analyse_materiau_v1
					FROM analyse_materiau_v1
				
					JOIN (
						SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_mono
						FROM analyse_materiau_v1
						GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
					) last_id ON analyse_materiau_v1.id_analyse_materiau_v1 = id_max_mono
					
				) id_max_mono_table ON id_max_mono_table.echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier = id_max_mono_table.type_dossier_analyse_materiau_v1
				JOIN analyse_materiau_v1 ON id_analyse_materiau_v1 = id_max_mono
				/* rev max MONO pour affichage PDF */
				LEFT JOIN (
					SELECT rev_max_mono, analyse_materiau_v1.echantillon_analyse_materiau_v1, analyse_materiau_v1.type_dossier_analyse_materiau_v1
					FROM analyse_materiau_v1
				
					JOIN (
						SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(revision_analyse_materiau_v1) as rev_max_mono
						FROM analyse_materiau_v1
						WHERE validation_analyse_materiau_v1 = 1
						GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
					) last_revision ON analyse_materiau_v1.revision_analyse_materiau_v1 = rev_max_mono AND last_revision.echantillon_analyse_materiau_v1 = analyse_materiau_v1.echantillon_analyse_materiau_v1
					
				) rev_max_mono_table ON rev_max_mono_table.echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier = rev_max_mono_table.type_dossier_analyse_materiau_v1
					
				/* rev max MULTI pour affichage PDF */
				LEFT JOIN (
					SELECT analyse_materiau_v1_multi.dossier_analyse_materiau_v1_multi, rev_max_multi
					FROM analyse_materiau_v1_multi
				
					JOIN (
						SELECT dossier_analyse_materiau_v1_multi, max(revision_analyse_materiau_v1_multi) as rev_max_multi
						FROM analyse_materiau_v1_multi
						WHERE validation_analyse_materiau_v1_multi = 1
						GROUP BY dossier_analyse_materiau_v1_multi
					) last_rev_multi ON rev_max_multi = analyse_materiau_v1_multi.revision_analyse_materiau_v1_multi AND last_rev_multi.dossier_analyse_materiau_v1_multi = analyse_materiau_v1_multi.dossier_analyse_materiau_v1_multi
				) rev_max_multi_table ON id_dossier = dossier_analyse_materiau_v1_multi
					
				WHERE type_dossier = 2
					AND type_analyse_dossier = 1
					AND date_creation_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'

				UNION

				SELECT /* echantillon interne */
					'' AS ref_client_echantillon, ref_echantillon, id_echantillon, fiche_analyse_echantillon,
					nom_client,
					ref_dossier as path_pdf,
					nom_qualification,
					nom_detail_type_presta as detail_mesure,
					dossier.*,
					id_max_mono, 
					rev_max_mono,
					rev_max_multi,
					validation_analyse_materiau_v1 AS validation_analyse, revision_analyse_materiau_v1 AS revision_analyse,
					'MATERIAUv1' AS type
	   
				FROM echantillon
	
				JOIN dossier ON dossier_echantillon = id_dossier
				JOIN client ON client_dossier = id_client
				JOIN presta ON pose_presta_echantillon = id_presta
				JOIN type_presta ON type_presta = id_type_presta
				JOIN detail_type_presta ON detail_type_presta = id_detail_type_presta
				JOIN qualification ON qualification_type_presta = id_qualification 
	
				/* id max pour modification */
				JOIN (
					SELECT id_max_mono, analyse_materiau_v1.echantillon_analyse_materiau_v1, analyse_materiau_v1.type_dossier_analyse_materiau_v1
					FROM analyse_materiau_v1
				
					JOIN (
						SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_mono
						FROM analyse_materiau_v1
						GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
					) last_id ON analyse_materiau_v1.id_analyse_materiau_v1 = id_max_mono
					
				) id_max_mono_table ON id_max_mono_table.echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier = id_max_mono_table.type_dossier_analyse_materiau_v1
				JOIN analyse_materiau_v1 ON id_analyse_materiau_v1 = id_max_mono
				/* rev max MONO pour affichage PDF */
				LEFT JOIN (
					SELECT rev_max_mono, analyse_materiau_v1.echantillon_analyse_materiau_v1, analyse_materiau_v1.type_dossier_analyse_materiau_v1
					FROM analyse_materiau_v1
				
					JOIN (
						SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(revision_analyse_materiau_v1) as rev_max_mono
						FROM analyse_materiau_v1
						WHERE validation_analyse_materiau_v1 = 1
						GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
					) last_revision ON analyse_materiau_v1.revision_analyse_materiau_v1 = rev_max_mono AND last_revision.echantillon_analyse_materiau_v1 = analyse_materiau_v1.echantillon_analyse_materiau_v1
					
					
				) rev_max_mono_table ON rev_max_mono_table.echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier = rev_max_mono_table.type_dossier_analyse_materiau_v1
					
				/* rev max MULTI pour affichage PDF */
				LEFT JOIN (
					SELECT analyse_materiau_v1_multi.dossier_analyse_materiau_v1_multi, rev_max_multi
					FROM analyse_materiau_v1_multi
				
					JOIN (
						SELECT dossier_analyse_materiau_v1_multi, max(revision_analyse_materiau_v1_multi) as rev_max_multi
						FROM analyse_materiau_v1_multi
						WHERE validation_analyse_materiau_v1_multi = 1
						GROUP BY dossier_analyse_materiau_v1_multi
					) last_rev_multi ON rev_max_multi = analyse_materiau_v1_multi.revision_analyse_materiau_v1_multi AND last_rev_multi.dossier_analyse_materiau_v1_multi = analyse_materiau_v1_multi.dossier_analyse_materiau_v1_multi
					
				) rev_max_multi_table ON id_dossier = dossier_analyse_materiau_v1_multi
					
				WHERE type_dossier = 1
					AND type_analyse_dossier = 1
					AND date_creation_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'";

		$MATv0 = "SELECT  /* echantillon externe */
					ref_client_echantillon_analyse AS ref_client_echantillon, ref_echantillon_analyse AS ref_echantillon, id_echantillon_analyse AS id_echantillon, fiche_analyse_echantillon_analyse AS fiche_analyse_echantillon,
					nom_client_analyse AS nom_client,
					ref_dossier as path_pdf,
					nom_qualification_analyse as nom_qualification,
					nom_type_prelevement as detail_mesure,
					dossier.*,
					id_max_mono, 
					rev_max_mono,
					rev_max_multi,
					validation_analyse_materiau_v0 AS validation_analyse, revision_analyse_materiau_v0 AS revision_analyse,
					'MATERIAUv0' AS type
	   
				FROM echantillon_analyse 
	
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN client_analyse ON client_dossier = id_client_analyse
				JOIN type_prelevement ON detail_echantillon_analyse = id_type_prelevement
				JOIN qualification_analyse ON qualification_analyse_type_prelevement = id_qualification_analyse
	
				/* id max pour modification */
				JOIN (
					SELECT id_max_mono, analyse_materiau_v0.echantillon_analyse_materiau_v0, analyse_materiau_v0.type_dossier_analyse_materiau_v0
					FROM analyse_materiau_v0
				
					JOIN (
						SELECT echantillon_analyse_materiau_v0, type_dossier_analyse_materiau_v0, max(id_analyse_materiau_v0) as id_max_mono
						FROM analyse_materiau_v0
						GROUP BY echantillon_analyse_materiau_v0, type_dossier_analyse_materiau_v0
					) last_id ON analyse_materiau_v0.id_analyse_materiau_v0 = id_max_mono
					
				) id_max_mono_table ON id_max_mono_table.echantillon_analyse_materiau_v0 = id_echantillon_analyse AND type_dossier = id_max_mono_table.type_dossier_analyse_materiau_v0
				JOIN analyse_materiau_v0 ON id_analyse_materiau_v0 = id_max_mono
				/* rev max MONO pour affichage PDF */
				LEFT JOIN (
					SELECT rev_max_mono, analyse_materiau_v0.echantillon_analyse_materiau_v0, analyse_materiau_v0.type_dossier_analyse_materiau_v0
					FROM analyse_materiau_v0
				
					JOIN (
						SELECT echantillon_analyse_materiau_v0, type_dossier_analyse_materiau_v0, max(revision_analyse_materiau_v0) as rev_max_mono
						FROM analyse_materiau_v0
						WHERE validation_analyse_materiau_v0 = 1
						GROUP BY echantillon_analyse_materiau_v0, type_dossier_analyse_materiau_v0
					) last_revision ON analyse_materiau_v0.revision_analyse_materiau_v0 = rev_max_mono AND last_revision.echantillon_analyse_materiau_v0 = analyse_materiau_v0.echantillon_analyse_materiau_v0
					
				) rev_max_mono_table ON rev_max_mono_table.echantillon_analyse_materiau_v0 = id_echantillon_analyse AND type_dossier = rev_max_mono_table.type_dossier_analyse_materiau_v0
					
				/* rev max MULTI pour affichage PDF */
				LEFT JOIN (
					SELECT analyse_materiau_v0_multi.dossier_analyse_materiau_v0_multi, rev_max_multi
					FROM analyse_materiau_v0_multi
				
					JOIN (
						SELECT dossier_analyse_materiau_v0_multi, max(revision_analyse_materiau_v0_multi) as rev_max_multi
						FROM analyse_materiau_v0_multi
						WHERE validation_analyse_materiau_v0_multi = 1
						GROUP BY dossier_analyse_materiau_v0_multi
					) last_rev_multi ON rev_max_multi = analyse_materiau_v0_multi.revision_analyse_materiau_v0_multi AND last_rev_multi.dossier_analyse_materiau_v0_multi = analyse_materiau_v0_multi.dossier_analyse_materiau_v0_multi
					
				) rev_max_multi_table ON id_dossier = dossier_analyse_materiau_v0_multi
					
				WHERE type_dossier = 2
					AND date_creation_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'

				UNION

				SELECT /* echantillon interne */
					'' AS ref_client_echantillon, ref_echantillon, id_echantillon, fiche_analyse_echantillon,
					nom_client,
					nom_chantier as path_pdf,
					nom_qualification,
					nom_detail_type_presta as detail_mesure,
					dossier.*,
					id_max_mono, 
					rev_max_mono,
					rev_max_multi,
					validation_analyse_materiau_v0 AS validation_analyse, revision_analyse_materiau_v0 AS revision_analyse,
					'MATERIAUv0' AS type
	   
				FROM echantillon
	
				JOIN dossier ON dossier_echantillon = id_dossier
				JOIN client ON client_dossier = id_client
				JOIN chantier ON chantier_dossier = id_chantier
				JOIN presta ON pose_presta_echantillon = id_presta
				JOIN type_presta ON type_presta = id_type_presta
				JOIN detail_type_presta ON detail_type_presta = id_detail_type_presta
				JOIN qualification ON qualification_type_presta = id_qualification 
	
				/* id max pour modification */
				JOIN (
					SELECT id_max_mono, analyse_materiau_v0.echantillon_analyse_materiau_v0, analyse_materiau_v0.type_dossier_analyse_materiau_v0
					FROM analyse_materiau_v0
				
					JOIN (
						SELECT echantillon_analyse_materiau_v0, type_dossier_analyse_materiau_v0, max(id_analyse_materiau_v0) as id_max_mono
						FROM analyse_materiau_v0
						GROUP BY echantillon_analyse_materiau_v0, type_dossier_analyse_materiau_v0
					) last_id ON analyse_materiau_v0.id_analyse_materiau_v0 = id_max_mono
					
				) id_max_mono_table ON id_max_mono_table.echantillon_analyse_materiau_v0 = id_echantillon AND type_dossier = id_max_mono_table.type_dossier_analyse_materiau_v0
				JOIN analyse_materiau_v0 ON id_analyse_materiau_v0 = id_max_mono
				/* rev max MONO pour affichage PDF */
				LEFT JOIN (
					SELECT rev_max_mono, analyse_materiau_v0.echantillon_analyse_materiau_v0, analyse_materiau_v0.type_dossier_analyse_materiau_v0
					FROM analyse_materiau_v0
				
					JOIN (
						SELECT echantillon_analyse_materiau_v0, type_dossier_analyse_materiau_v0, max(revision_analyse_materiau_v0) as rev_max_mono
						FROM analyse_materiau_v0
						WHERE validation_analyse_materiau_v0 = 1
						GROUP BY echantillon_analyse_materiau_v0, type_dossier_analyse_materiau_v0
					) last_revision ON analyse_materiau_v0.revision_analyse_materiau_v0 = rev_max_mono AND last_revision.echantillon_analyse_materiau_v0 = analyse_materiau_v0.echantillon_analyse_materiau_v0
					
					
				) rev_max_mono_table ON rev_max_mono_table.echantillon_analyse_materiau_v0 = id_echantillon AND type_dossier = rev_max_mono_table.type_dossier_analyse_materiau_v0
					
				/* rev max MULTI pour affichage PDF */
				LEFT JOIN (
					SELECT analyse_materiau_v0_multi.dossier_analyse_materiau_v0_multi, rev_max_multi
					FROM analyse_materiau_v0_multi
				
					JOIN (
						SELECT dossier_analyse_materiau_v0_multi, max(revision_analyse_materiau_v0_multi) as rev_max_multi
						FROM analyse_materiau_v0_multi
						WHERE validation_analyse_materiau_v0_multi = 1
						GROUP BY dossier_analyse_materiau_v0_multi
					) last_rev_multi ON rev_max_multi = analyse_materiau_v0_multi.revision_analyse_materiau_v0_multi AND last_rev_multi.dossier_analyse_materiau_v0_multi = analyse_materiau_v0_multi.dossier_analyse_materiau_v0_multi
					
				) rev_max_multi_table ON id_dossier = dossier_analyse_materiau_v0_multi
					
				WHERE type_dossier = 1
					AND date_creation_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'";
		$MATERIAU = "SELECT  /* echantillon externe */
					ref_client_echantillon_analyse AS ref_client_echantillon, ref_echantillon_analyse AS ref_echantillon, id_echantillon_analyse AS id_echantillon, fiche_analyse_echantillon_analyse AS fiche_analyse_echantillon,
					nom_client_analyse AS nom_client,
					ref_dossier as path_pdf,
					nom_qualification_analyse as nom_qualification,
					nom_type_prelevement as detail_mesure,
					dossier.*,
					id_max_mono, 
					rev_max_mono,
					rev_max_multi,
					validation_analyse_materiau AS validation_analyse, revision_analyse_materiau AS revision_analyse,
					'MATERIAU' AS type
	   
				FROM echantillon_analyse 
	
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN client_analyse ON client_dossier = id_client_analyse
				JOIN type_prelevement ON detail_echantillon_analyse = id_type_prelevement
				JOIN qualification_analyse ON qualification_analyse_type_prelevement = id_qualification_analyse
	
				/* id max pour modification */
				JOIN (
					SELECT id_max_mono, analyse_materiau.echantillon_analyse_materiau, analyse_materiau.type_dossier_analyse_materiau
					FROM analyse_materiau
				
					JOIN (
						SELECT echantillon_analyse_materiau, type_dossier_analyse_materiau, max(id_analyse_materiau) as id_max_mono
						FROM analyse_materiau
						GROUP BY echantillon_analyse_materiau, type_dossier_analyse_materiau
					) last_id ON analyse_materiau.id_analyse_materiau = id_max_mono
					
				) id_max_mono_table ON id_max_mono_table.echantillon_analyse_materiau = id_echantillon_analyse AND type_dossier = id_max_mono_table.type_dossier_analyse_materiau
				JOIN analyse_materiau ON id_analyse_materiau = id_max_mono
				/* rev max MONO pour affichage PDF */
				LEFT JOIN (
					SELECT rev_max_mono, analyse_materiau.echantillon_analyse_materiau, analyse_materiau.type_dossier_analyse_materiau
					FROM analyse_materiau
				
					JOIN (
						SELECT echantillon_analyse_materiau, type_dossier_analyse_materiau, max(revision_analyse_materiau) as rev_max_mono
						FROM analyse_materiau
						WHERE validation_analyse_materiau = 1
						GROUP BY echantillon_analyse_materiau, type_dossier_analyse_materiau
					) last_revision ON analyse_materiau.revision_analyse_materiau = rev_max_mono AND last_revision.echantillon_analyse_materiau = analyse_materiau.echantillon_analyse_materiau
					
				) rev_max_mono_table ON rev_max_mono_table.echantillon_analyse_materiau = id_echantillon_analyse AND type_dossier = rev_max_mono_table.type_dossier_analyse_materiau
					
				/* rev max MULTI pour affichage PDF */
				LEFT JOIN (
					SELECT rapport_materiau_multi.dossier_rapport_materiau_multi, rev_max_multi
					FROM rapport_materiau_multi
				
					JOIN (
						SELECT dossier_rapport_materiau_multi, max(revision_rapport_materiau_multi) as rev_max_multi
						FROM rapport_materiau_multi
						WHERE validation_rapport_materiau_multi = 1
						GROUP BY dossier_rapport_materiau_multi
					) last_rev_multi ON rev_max_multi = rapport_materiau_multi.revision_rapport_materiau_multi AND last_rev_multi.dossier_rapport_materiau_multi = rapport_materiau_multi.dossier_rapport_materiau_multi
					
				) rev_max_multi_table ON id_dossier = dossier_rapport_materiau_multi
					
				WHERE type_dossier = 2
					AND date_creation_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'

				UNION

				SELECT /* echantillon interne */
					'' AS ref_client_echantillon, ref_echantillon, id_echantillon, fiche_analyse_echantillon,
					nom_client,
					nom_chantier as path_pdf,
					nom_qualification,
					nom_detail_type_presta as detail_mesure,
					dossier.*,
					id_max_mono, 
					rev_max_mono,
					rev_max_multi,
					validation_analyse_materiau AS validation_analyse, revision_analyse_materiau AS revision_analyse,
					'MATERIAU' AS type
	   
				FROM echantillon
	
				JOIN dossier ON dossier_echantillon = id_dossier
				JOIN client ON client_dossier = id_client
				JOIN chantier ON chantier_dossier = id_chantier
				JOIN presta ON pose_presta_echantillon = id_presta
				JOIN type_presta ON type_presta = id_type_presta
				JOIN detail_type_presta ON detail_type_presta = id_detail_type_presta
				JOIN qualification ON qualification_type_presta = id_qualification 
	
				/* id max pour modification */
				JOIN (
					SELECT id_max_mono, analyse_materiau.echantillon_analyse_materiau, analyse_materiau.type_dossier_analyse_materiau
					FROM analyse_materiau
				
					JOIN (
						SELECT echantillon_analyse_materiau, type_dossier_analyse_materiau, max(id_analyse_materiau) as id_max_mono
						FROM analyse_materiau
						GROUP BY echantillon_analyse_materiau, type_dossier_analyse_materiau
					) last_id ON analyse_materiau.id_analyse_materiau = id_max_mono
					
				) id_max_mono_table ON id_max_mono_table.echantillon_analyse_materiau = id_echantillon AND type_dossier = id_max_mono_table.type_dossier_analyse_materiau
				JOIN analyse_materiau ON id_analyse_materiau = id_max_mono
				/* rev max MONO pour affichage PDF */
				LEFT JOIN (
					SELECT rev_max_mono, analyse_materiau.echantillon_analyse_materiau, analyse_materiau.type_dossier_analyse_materiau
					FROM analyse_materiau
				
					JOIN (
						SELECT echantillon_analyse_materiau, type_dossier_analyse_materiau, max(revision_analyse_materiau) as rev_max_mono
						FROM analyse_materiau
						WHERE validation_analyse_materiau = 1
						GROUP BY echantillon_analyse_materiau, type_dossier_analyse_materiau
					) last_revision ON analyse_materiau.revision_analyse_materiau = rev_max_mono AND last_revision.echantillon_analyse_materiau = analyse_materiau.echantillon_analyse_materiau
					
					
				) rev_max_mono_table ON rev_max_mono_table.echantillon_analyse_materiau = id_echantillon AND type_dossier = rev_max_mono_table.type_dossier_analyse_materiau
					
				/* rev max MULTI pour affichage PDF */
				LEFT JOIN (
					SELECT rapport_materiau_multi.dossier_rapport_materiau_multi, rev_max_multi
					FROM rapport_materiau_multi
				
					JOIN (
						SELECT dossier_rapport_materiau_multi, max(revision_rapport_materiau_multi) as rev_max_multi
						FROM rapport_materiau_multi
						WHERE validation_rapport_materiau_multi = 1
						GROUP BY dossier_rapport_materiau_multi
					) last_rev_multi ON rev_max_multi = rapport_materiau_multi.revision_rapport_materiau_multi AND last_rev_multi.dossier_rapport_materiau_multi = rapport_materiau_multi.dossier_rapport_materiau_multi
					
				) rev_max_multi_table ON id_dossier = dossier_rapport_materiau_multi
					
				WHERE type_dossier = 1
					AND date_creation_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'";

		$HAP = "SELECT  /* echantillon externe */
					ref_client_echantillon_analyse AS ref_client_echantillon, ref_echantillon_analyse AS ref_echantillon, id_echantillon_analyse AS id_echantillon, fiche_analyse_echantillon_analyse AS fiche_analyse_echantillon,
					nom_client_analyse AS nom_client,
					ref_dossier as path_pdf,
					nom_qualification_analyse as nom_qualification,
					nom_analyse_externe_prestation as detail_mesure,
					dossier.*,
					id_max_mono, 
					rev_max_mono,
					'' AS rev_max_multi,
					validation_analyse_hap AS validation_analyse, revision_analyse_hap AS revision_analyse,
					'HAP' AS type
				
				FROM echantillon_analyse 
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN client_analyse ON client_dossier = id_client_analyse
				LEFT JOIN analyse_externe_prestation_objectif ON objectif_echantillon_analyse = id_analyse_externe_prestation_objectif
				JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
						
				JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
				JOIN analyse_externe_polluant ON id_analyse_externe_polluant = polluant_analyse_externe_prestation
				JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse
				/* JOIN type_prelevement ON detail_echantillon_analyse = id_type_prelevement */
				/* JOIN qualification_analyse ON qualification_analyse_type_prelevement = id_qualification_analyse */

				/* id max pour modification */
				JOIN (
					SELECT id_max_mono, analyse_hap.echantillon_analyse_hap, analyse_hap.type_dossier_analyse_hap
					FROM analyse_hap
				
					JOIN (
						SELECT echantillon_analyse_hap, type_dossier_analyse_hap, max(id_analyse_hap) as id_max_mono
						FROM analyse_hap
						GROUP BY echantillon_analyse_hap, type_dossier_analyse_hap
					) last_id ON analyse_hap.id_analyse_hap = id_max_mono
					
				) id_max_mono_table ON id_max_mono_table.echantillon_analyse_hap = id_echantillon_analyse AND type_dossier = id_max_mono_table.type_dossier_analyse_hap
				JOIN analyse_hap ON id_analyse_hap = id_max_mono
				/* rev max MONO pour affichage PDF */
				LEFT JOIN (
					SELECT rev_max_mono, analyse_hap.echantillon_analyse_hap, analyse_hap.type_dossier_analyse_hap
					FROM analyse_hap
				
					JOIN (
						SELECT echantillon_analyse_hap, type_dossier_analyse_hap, max(revision_analyse_hap) as rev_max_mono
						FROM analyse_hap
						WHERE validation_analyse_hap = 1
						GROUP BY echantillon_analyse_hap, type_dossier_analyse_hap
					) last_revision ON analyse_hap.revision_analyse_hap = rev_max_mono AND last_revision.echantillon_analyse_hap = analyse_hap.echantillon_analyse_hap
					
				) rev_max_mono_table ON rev_max_mono_table.echantillon_analyse_hap = id_echantillon_analyse AND type_dossier = rev_max_mono_table.type_dossier_analyse_hap

				WHERE type_dossier = 2
					AND date_creation_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'
				
				UNION 

				SELECT  /* echantillon interne */
					'' AS ref_client_echantillon, ref_echantillon, id_echantillon, fiche_analyse_echantillon,
					nom_client,
					nom_chantier as path_pdf,
					nom_qualification,
					nom_detail_type_presta as detail_mesure,
					dossier.*,
					id_max_mono, 
					rev_max_mono,
					'' AS rev_max_multi,
					validation_analyse_hap AS validation_analyse, revision_analyse_hap AS revision_analyse,
					'HAP' AS type

				FROM echantillon

				JOIN dossier ON dossier_echantillon = id_dossier
				JOIN client ON client_dossier = id_client
				JOIN chantier ON chantier_dossier = id_chantier
				JOIN presta ON pose_presta_echantillon = id_presta
				JOIN type_presta ON type_presta = id_type_presta
				JOIN detail_type_presta ON detail_type_presta = id_detail_type_presta
				JOIN qualification ON qualification_type_presta = id_qualification 

				/* id max pour modification */
				LEFT JOIN (
					SELECT id_max_mono, analyse_hap.echantillon_analyse_hap, analyse_hap.type_dossier_analyse_hap
					FROM analyse_hap
				
					JOIN (
						SELECT echantillon_analyse_hap, type_dossier_analyse_hap, max(id_analyse_hap) as id_max_mono
						FROM analyse_hap
						GROUP BY echantillon_analyse_hap, type_dossier_analyse_hap
					) last_id ON analyse_hap.id_analyse_hap = id_max_mono
					
				) id_max_mono_table ON id_max_mono_table.echantillon_analyse_hap = id_echantillon AND type_dossier = id_max_mono_table.type_dossier_analyse_hap
				JOIN analyse_hap ON id_analyse_hap = id_max_mono
				/* rev max MONO pour affichage PDF */
				LEFT JOIN (
					SELECT rev_max_mono, analyse_hap.echantillon_analyse_hap, analyse_hap.type_dossier_analyse_hap
					FROM analyse_hap
				
					JOIN (
						SELECT echantillon_analyse_hap, type_dossier_analyse_hap, max(revision_analyse_hap) as rev_max_mono
						FROM analyse_hap
						WHERE validation_analyse_hap = 1
						GROUP BY echantillon_analyse_hap, type_dossier_analyse_hap
					) last_revision ON analyse_hap.revision_analyse_hap = rev_max_mono AND last_revision.echantillon_analyse_hap = analyse_hap.echantillon_analyse_hap
					
				) rev_max_mono_table ON rev_max_mono_table.echantillon_analyse_hap = id_echantillon AND type_dossier = rev_max_mono_table.type_dossier_analyse_hap

				WHERE type_dossier = 1
					AND date_creation_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'
					";
		$NON_SAISIES = "SELECT  /* echantillon externe */
					ref_client_echantillon_analyse AS ref_client_echantillon, ref_echantillon_analyse AS ref_echantillon, id_echantillon_analyse AS id_echantillon, fiche_analyse_echantillon_analyse AS fiche_analyse_echantillon,
					nom_client_analyse AS nom_client,
					'' as path_pdf,
					nom_analyse_externe_prestation as nom_qualification,
					nom_analyse_externe_prestation as detail_mesure,
					dossier.*,
					'' AS id_max_mono, 
					'' AS rev_max_mono,
					'' AS rev_max_multi,
					'' AS validation_analyse, '' AS revision_analyse,
					'' AS type
				
				FROM echantillon_analyse 
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN client_analyse ON client_dossier = id_client_analyse
				/* JOIN type_prelevement ON detail_echantillon_analyse = id_type_prelevement */
				/* JOIN qualification_analyse ON qualification_analyse_type_prelevement = id_qualification_analyse */
				JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
				JOIN analyse_externe_prestation ON prestation_analyse_externe_prestation_delais = id_analyse_externe_prestation	
				JOIN analyse_externe_polluant ON polluant_analyse_externe_prestation = id_analyse_externe_polluant	

				WHERE type_dossier = 2
					AND fiche_analyse_echantillon_analyse = 0
					/* AND qualification_analyse_externe_prestation = 3 */
					AND matrice_analyse_externe_polluant = 1
					/* AND (id_type_prelevement = 23 OR id_type_prelevement = 37 OR id_type_prelevement = 35 OR id_type_prelevement = 36) */  /* Matériaux, Materiaux temoin, Materiaux enrobe, HAP */
					AND date_creation_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'
				
				UNION 

				SELECT  /* echantillon interne */
					'' AS ref_client_echantillon, ref_echantillon, id_echantillon, fiche_analyse_echantillon,
					nom_client,
					nom_qualification,
					'' as path_pdf,
					nom_detail_type_presta as detail_mesure,
					dossier.*,
					'' AS id_max_mono, 
					'' AS rev_max_mono,
					'' AS rev_max_multi,
					'' AS validation_analyse, '' AS revision_analyse,
					'' AS type

				FROM echantillon

				JOIN dossier ON dossier_echantillon = id_dossier
				JOIN client ON client_dossier = id_client
				JOIN presta ON pose_presta_echantillon = id_presta
				JOIN type_presta ON type_presta = id_type_presta
				JOIN detail_type_presta ON detail_type_presta = id_detail_type_presta
				JOIN qualification ON qualification_type_presta = id_qualification

				WHERE type_dossier = 1
					AND fiche_analyse_echantillon = 0
					AND (id_qualification = 5 OR id_qualification = 6 OR id_qualification = 31 OR id_qualification = 32) /*Matériaux, Lingette amaiante, Materiaux enrobe, HAP */
					AND date_creation_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'
					";

		$query = "
			{$MATv0} 
			UNION
			{$MATv1} 
			UNION
			{$MATERIAU} 
			UNION
			{$HAP} 
			UNION
			{$NON_SAISIES}
		
			ORDER BY annee_dossier DESC, numero_ref_dossier DESC";

		// $query = "
		// 	{$MATv1} 
		// 	ORDER BY annee_dossier DESC, numero_ref_dossier DESC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeEchantillonAnalyseDossier($dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT ref_echantillon_analyse AS ref_echantillon, 
					ref_client_echantillon_analyse AS ref_client_echantillon, 
					localisation_echantillon_analyse AS localisation_echantillon, 
					id_echantillon_analyse AS id_echantillon, 
					mois_ref_echantillon_analyse AS mois_ref_echantillon, 
					fiche_analyse_echantillon_analyse AS fiche_analyse_echantillon 
				FROM echantillon_analyse
				WHERE dossier_echantillon_analyse = " . $dossier . " 

				UNION

				SELECT ref_echantillon, 
					'' AS ref_client_echantillon, 
					localisation_echantillon, 
					id_echantillon, 
					mois_ref_echantillon, 
					fiche_analyse_echantillon
				FROM echantillon
				WHERE dossier_echantillon = " . $dossier . "

				ORDER BY mois_ref_echantillon ASC";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function listEchantillonMateriauAttenteMolp() {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT ref_dossier, ref_affaire_analyse_dossier, nbr_couche_molp, date_previsionnelle_dossier, chantier_analyse_dossier, id_echantillon_analyse as id_echantillon, dossier.id_dossier
					FROM echantillon_analyse
						JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier_analyse_materiau_v1 = 2
						JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
						JOIN dossier ON dossier_echantillon_analyse = id_dossier
						JOIN (
							SELECT id_dossier, COUNT(id_analyse_materiau_v1_couche) AS nbr_couche_molp 
								FROM echantillon_analyse
									JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
									JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
									JOIN dossier ON dossier_echantillon_analyse = id_dossier 
								WHERE (molp_analyse_materiau_v1_couche = {$this::$MOLP_ANALYSE_WAITING} OR molp_analyse_materiau_v1_couche = {$this::$MOLP_VALIDATION_TECHIQUE})
								GROUP BY id_dossier
						) AS count_couche ON count_couche.id_dossier = dossier.id_dossier
					WHERE (molp_analyse_materiau_v1_couche = {$this::$MOLP_ANALYSE_WAITING} OR molp_analyse_materiau_v1_couche = {$this::$MOLP_VALIDATION_TECHIQUE})
					GROUP BY dossier.id_dossier
					UNION 
					SELECT ref_dossier, ref_affaire_analyse_dossier, nbr_couche_molp, date_previsionnelle_dossier, chantier_analyse_dossier, id_echantillon, dossier.id_dossier
					FROM echantillon
						JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier_analyse_materiau_v1 = 1
						JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
						JOIN dossier ON dossier_echantillon = id_dossier
						JOIN (
							SELECT id_dossier, COUNT(id_analyse_materiau_v1_couche) AS nbr_couche_molp 
								FROM echantillon
									JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon
									JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
									JOIN dossier ON dossier_echantillon = id_dossier 
								WHERE (molp_analyse_materiau_v1_couche = {$this::$MOLP_ANALYSE_WAITING} OR molp_analyse_materiau_v1_couche = {$this::$MOLP_VALIDATION_TECHIQUE})
								GROUP BY id_dossier
						) AS count_couche ON count_couche.id_dossier = dossier.id_dossier
					WHERE (molp_analyse_materiau_v1_couche = {$this::$MOLP_ANALYSE_WAITING} OR molp_analyse_materiau_v1_couche = {$this::$MOLP_VALIDATION_TECHIQUE})
					GROUP BY dossier.id_dossier";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function listEchantillonMateriauAttenteValidationTechMolp($select) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT dossier.*, nbr_couche_molp, id_echantillon_analyse as id_echantillon
					FROM echantillon_analyse
						JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse  AND type_dossier_analyse_materiau_v1 = 2
						JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
						JOIN dossier ON dossier_echantillon_analyse = id_dossier
						JOIN (
							SELECT id_dossier, COUNT(id_analyse_materiau_v1_couche) AS nbr_couche_molp 
								FROM echantillon_analyse
									JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
									JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
									JOIN dossier ON dossier_echantillon_analyse = id_dossier 
								WHERE molp_analyse_materiau_v1_couche = {$this::$MOLP_VALIDATION_TECHIQUE}
								GROUP BY id_dossier
						) AS count_couche ON count_couche.id_dossier = dossier.id_dossier
					WHERE molp_analyse_materiau_v1_couche = {$this::$MOLP_VALIDATION_TECHIQUE}

					UNION

					SELECT dossier.*, nbr_couche_molp, id_echantillon
					FROM echantillon
						JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier_analyse_materiau_v1 = 1
						JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
						JOIN dossier ON dossier_echantillon = id_dossier
						JOIN (
							SELECT id_dossier, COUNT(id_analyse_materiau_v1_couche) AS nbr_couche_molp 
								FROM echantillon
									JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon
									JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
									JOIN dossier ON dossier_echantillon = id_dossier 
								WHERE molp_analyse_materiau_v1_couche = {$this::$MOLP_VALIDATION_TECHIQUE}
								GROUP BY id_dossier
						) AS count_couche ON count_couche.id_dossier = dossier.id_dossier
					WHERE molp_analyse_materiau_v1_couche = {$this::$MOLP_VALIDATION_TECHIQUE}

					GROUP BY dossier.id_dossier";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function listEchantillonMateriauAttenteMeta($select) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT dossier.*, id_echantillon_analyse as id_echantillon, nbr_couche_meta, COUNT(id_echantillon_analyse) AS nb_echantillons, MAX(meta_analyse_materiau_v1_couche) AS max_prepa_status, MAX(molp_analyse_materiau_v1_couche) AS max_molp_status, date_premiere_prepa, statut_retour_analyse_analyse_materiau_v1_couche
				FROM echantillon_analyse
					JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier_analyse_materiau_v1 = 2
					JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche.analyse_materiau_v1_couche
					LEFT JOIN analyse_materiau_v1_couche_meta_prepa ON  id_analyse_materiau_v1_couche_meta_prepa =  analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche
					JOIN dossier ON dossier_echantillon_analyse = id_dossier
					JOIN (
						SELECT id_dossier, COUNT(id_analyse_materiau_v1_couche) AS nbr_couche_meta
							FROM echantillon_analyse
								JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier_analyse_materiau_v1 = 2
								JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
								JOIN dossier ON dossier_echantillon_analyse = id_dossier 
								WHERE meta_analyse_materiau_v1_couche >= {$this::$META_PREPA_WAITING}
							GROUP BY id_dossier
					) AS count_couche ON count_couche.id_dossier = dossier.id_dossier
					LEFT JOIN (
                    	SELECT id_dossier, MIN(date_analyse_materiau_v1_couche_meta_prepa) AS date_premiere_prepa
                        FROM analyse_materiau_v1_couche_meta_prepa
                        JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
                        JOIN analyse_materiau_v1 ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
                        JOIN echantillon_analyse ON id_echantillon_analyse = echantillon_analyse_materiau_v1
                        JOIN dossier ON dossier_echantillon_analyse = id_dossier
                        GROUP BY id_dossier
                    ) AS premiere_prepa ON premiere_prepa.id_dossier = dossier.id_dossier
					WHERE meta_analyse_materiau_v1_couche = {$this::$META_PREPA_WAITING} OR meta_analyse_materiau_v1_couche = {$this::$META_PREPA_REDO}
					GROUP BY dossier.id_dossier
				UNION

				SELECT dossier.*, id_echantillon, nbr_couche_meta, COUNT(id_echantillon) AS nb_echantillons, MAX(meta_analyse_materiau_v1_couche) AS max_prepa_status, MAX(molp_analyse_materiau_v1_couche) AS max_molp_status, date_premiere_prepa, statut_retour_analyse_analyse_materiau_v1_couche
				FROM echantillon
					JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier_analyse_materiau_v1 = 1
					JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche.analyse_materiau_v1_couche
					-- JOIN analyse_materiau_v1_couche_meta_prepa ON  id_analyse_materiau_v1_couche_meta_prepa =  analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche
					JOIN dossier ON dossier_echantillon = id_dossier
					JOIN (
						SELECT id_dossier, COUNT(id_analyse_materiau_v1_couche) AS nbr_couche_meta
							FROM echantillon
								JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier_analyse_materiau_v1 = 1
								JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
								JOIN dossier ON dossier_echantillon = id_dossier 
								WHERE meta_analyse_materiau_v1_couche >= {$this::$META_PREPA_WAITING}
							GROUP BY id_dossier
					) AS count_couche ON count_couche.id_dossier = dossier.id_dossier
					LEFT JOIN (
                    	SELECT id_dossier, MIN(date_analyse_materiau_v1_couche_meta_prepa) AS date_premiere_prepa
                        FROM analyse_materiau_v1_couche_meta_prepa
                        JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
                        JOIN analyse_materiau_v1 ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
                        JOIN echantillon ON id_echantillon = echantillon_analyse_materiau_v1
                        JOIN dossier ON dossier_echantillon = id_dossier
                        GROUP BY id_dossier
                    ) AS premiere_prepa ON premiere_prepa.id_dossier = dossier.id_dossier
					WHERE meta_analyse_materiau_v1_couche = {$this::$META_PREPA_WAITING} OR meta_analyse_materiau_v1_couche = {$this::$META_PREPA_REDO}
					GROUP BY dossier.id_dossier";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	/**
	 * Get the Echantillon with a Depot waiting Couche.
	 * 
	 * @param {String} $select - All fields to select.
	 * @return {[Object]} List of Object, mapped from relational table to PHP Object (ORM).
	 */
	function listEchantillonMateriauAttenteDepotMeta($select) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT {$select}
					FROM echantillon_analyse
						JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
						JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
                		JOIN dossier ON dossier_echantillon_analyse = id_dossier
					WHERE meta_analyse_materiau_v1_couche = {$this::$META_PREPA_DONE} OR meta_analyse_materiau_v1_couche = {$this::$META_DEPOT_REDO}
					GROUP BY id_echantillon_analyse";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * Get the Echantillon with a Ragement waiting Couche.
	 * 
	 * @param {String} $select - All fields to select.
	 * @return {[Object]} List of Object, mapped from relational table to PHP Object (ORM).
	 */
	function listEchantillonMateriauAttenteRangementMeta($select) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT {$select}
					FROM echantillon_analyse
						JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
						JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
                		JOIN dossier ON dossier_echantillon_analyse = id_dossier
					WHERE meta_analyse_materiau_v1_couche = {$this::$META_DEPOT_DONE}
					GROUP BY id_echantillon_analyse";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function listDossierMateriauAttenteAnalyseMeta($select) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT ref_dossier, ref_affaire_analyse_dossier, chantier_analyse_dossier, nbr_echantillon_meta, date_previsionnelle_dossier, id_dossier, type_dossier,
				COUNT(id_analyse_materiau_v1_couche_meta_depot) as nbr_couche_meta, 
				GROUP_CONCAT(DISTINCT ref_consommable) as GROUP_ref_consommable, MAX(statut_retour_analyse_analyse_materiau_v1_couche) AS statut_retour_analyse_analyse_materiau_v1_couche, MAX(molp_analyse_materiau_v1_couche) AS max_molp_status
			FROM dossier
			JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
			JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier = type_dossier_analyse_materiau_v1
			JOIN analyse_materiau_v1_couche ON id_analyse_materiau_v1 = analyse_materiau_v1_couche
			JOIN analyse_materiau_v1_couche_meta_depot ON  id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche
			JOIN consommable ON boite_archive_analyse_materiau_v1_couche_meta_depot = id_consommable
			JOIN (
				SELECT dossier_echantillon_analyse, COUNT(DISTINCT id_echantillon_analyse) as nbr_echantillon_meta 
				FROM echantillon_analyse
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier_analyse_materiau_v1 = 2
				JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
				WHERE meta_analyse_materiau_v1_couche > 0
				GROUP BY dossier_echantillon_analyse
			) AS countEchantillon ON countEchantillon.dossier_echantillon_analyse = id_dossier
			WHERE is_archived_materiau_v1_couche_meta_depot = 1
			AND is_active_analyse_materiau_v1_couche_meta_depot = 1
			AND meta_analyse_materiau_v1_couche < 8
			GROUP BY dossier.id_dossier
			
			UNION

			SELECT ref_dossier, ref_affaire_analyse_dossier, chantier_analyse_dossier, nbr_echantillon_meta, date_previsionnelle_dossier, id_dossier, type_dossier,
				COUNT(id_analyse_materiau_v1_couche_meta_depot) as nbr_couche_meta, 
				GROUP_CONCAT(DISTINCT ref_consommable) as GROUP_ref_consommable, MAX(statut_retour_analyse_analyse_materiau_v1_couche) AS statut_retour_analyse_analyse_materiau_v1_couche, MAX(molp_analyse_materiau_v1_couche) AS max_molp_status
			FROM dossier
			JOIN echantillon ON dossier_echantillon = id_dossier
			JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier = type_dossier_analyse_materiau_v1
			JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 = analyse_materiau_v1_couche
			JOIN analyse_materiau_v1_couche_meta_depot ON  id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche
			JOIN consommable ON boite_archive_analyse_materiau_v1_couche_meta_depot = id_consommable
			JOIN (
				SELECT dossier_echantillon, COUNT(DISTINCT id_echantillon) as nbr_echantillon_meta 
				FROM echantillon
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier_analyse_materiau_v1 = 1
				JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
				WHERE meta_analyse_materiau_v1_couche > 0
				GROUP BY dossier_echantillon
			) AS countEchantillon ON countEchantillon.dossier_echantillon = id_dossier
			WHERE is_archived_materiau_v1_couche_meta_depot = 1
			AND is_active_analyse_materiau_v1_couche_meta_depot = 1
			AND meta_analyse_materiau_v1_couche < 8
			GROUP BY id_dossier
		";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function listDossierMateriauAttentePreValidationMeta($select) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT analyse_materiau_v1.*, analyse_materiau_v1_couche.*, analyse_materiau_v1_couche_meta_depot.*, consommable.*, dossier.*, nbr_echantillon_meta,
				COUNT(id_analyse_materiau_v1_couche_meta_depot) as nbr_couche_meta, 
				GROUP_CONCAT(DISTINCT ref_consommable) as GROUP_ref_consommable,
				CONCAT(nbr_echantillon_meta_pre_valid, ' / ', nbr_echantillon_meta) as nbr_echantillon
			FROM dossier
			JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
			JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier = type_dossier_analyse_materiau_v1
			JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
			JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
			JOIN analyse_materiau_v1_couche_meta_depot ON  id_analyse_materiau_v1_couche =  analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche
			JOIN consommable ON  boite_archive_analyse_materiau_v1_couche_meta_depot = id_consommable
			JOIN (
				SELECT  dossier_echantillon_analyse, COUNT(DISTINCT id_echantillon_analyse) as nbr_echantillon_meta 
				FROM echantillon_analyse
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier_analyse_materiau_v1 = 2
				JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
				WHERE meta_analyse_materiau_v1_couche > 0
				GROUP BY dossier_echantillon_analyse
			) AS countEchantillon ON countEchantillon.dossier_echantillon_analyse = id_dossier
			JOIN (
				SELECT  dossier_echantillon_analyse, COUNT(DISTINCT id_echantillon_analyse) as nbr_echantillon_meta_pre_valid
				FROM echantillon_analyse
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier_analyse_materiau_v1 = 2
				JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
				WHERE meta_analyse_materiau_v1_couche = 8
				GROUP BY dossier_echantillon_analyse
			) AS countEchantillonPreValid ON countEchantillonPreValid.dossier_echantillon_analyse = id_dossier
			WHERE is_archived_materiau_v1_couche_meta_depot = 1
			AND is_active_analyse_materiau_v1_couche_meta_depot = 1
			AND meta_analyse_materiau_v1_couche = 8
			GROUP BY id_dossier

			UNION

			SELECT analyse_materiau_v1.*, analyse_materiau_v1_couche.*, analyse_materiau_v1_couche_meta_depot.*, consommable.*, dossier.*, nbr_echantillon_meta, 
				COUNT(id_analyse_materiau_v1_couche_meta_depot) as nbr_couche_meta, 
				GROUP_CONCAT(DISTINCT ref_consommable) as GROUP_ref_consommable,
				CONCAT(nbr_echantillon_meta_pre_valid, ' / ', nbr_echantillon_meta) as nbr_echantillon
			FROM dossier
			JOIN echantillon ON dossier_echantillon = id_dossier
			JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier = type_dossier_analyse_materiau_v1
			JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
			JOIN analyse_materiau_v1_couche ON id_analyse_materiau_v1 = analyse_materiau_v1_couche
			JOIN analyse_materiau_v1_couche_meta_depot ON id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche
			JOIN consommable ON boite_archive_analyse_materiau_v1_couche_meta_depot = id_consommable
			JOIN (
				SELECT  dossier_echantillon, COUNT(DISTINCT id_echantillon) as nbr_echantillon_meta 
				FROM echantillon
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier_analyse_materiau_v1 = 1
				JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 = analyse_materiau_v1_couche
				WHERE meta_analyse_materiau_v1_couche > 0
				GROUP BY dossier_echantillon
			) AS countEchantillon ON countEchantillon.dossier_echantillon = id_dossier
			JOIN (
				SELECT  dossier_echantillon, COUNT(DISTINCT id_echantillon) as nbr_echantillon_meta_pre_valid 
				FROM echantillon
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier_analyse_materiau_v1 = 1
				JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
				WHERE meta_analyse_materiau_v1_couche = 8
				GROUP BY dossier_echantillon
			) AS countEchantillonPreValid ON countEchantillonPreValid.dossier_echantillon = id_dossier
			WHERE is_archived_materiau_v1_couche_meta_depot = 1
			AND is_active_analyse_materiau_v1_couche_meta_depot = 1
			AND meta_analyse_materiau_v1_couche = 8
			AND validation_analyse_materiau_v1 = 2
			GROUP BY id_dossier
		";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	function listEchantillonMateriauAttenteAnalyseMeta($select) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT {$select}
					FROM echantillon_analyse
						JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
						JOIN analyse_materiau_v1_couche ON  id_analyse_materiau_v1 =  analyse_materiau_v1_couche
						JOIN analyse_materiau_v1_couche_meta_depot ON  id_analyse_materiau_v1_couche =  analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche
                		JOIN dossier ON dossier_echantillon_analyse = id_dossier
                		JOIN analyse_materiau_v1_portoir ON id_analyse_materiau_v1_portoir = analyse_materiau_v1_couche_meta_depot.portoir_analyse_materiau_v1_couche_meta_depot
					WHERE is_archived_materiau_v1_couche_meta_depot = 1 
					AND is_active_analyse_materiau_v1_couche_meta_depot = 1
					AND is_analyse_analyse_materiau_v1_couche_meta_depot = 0
					GROUP BY id_echantillon_analyse";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	function listAnalyseCoucheMolpEchantillon($idechantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
					FROM analyse_materiau_v1_couche
						JOIN analyse_materiau_v1 ON analyse_materiau_v1_couche = id_analyse_materiau_v1
					WHERE echantillon_analyse_materiau_v1 = {$idechantillon}
						AND molp_analyse_materiau_v1_couche = {$this::$MOLP_ANALYSE_WAITING}";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}


	function listAnalyseCoucheMolp($idechantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
					FROM analyse_materiau_v1_couche
						JOIN analyse_materiau_v1 ON analyse_materiau_v1_couche = id_analyse_materiau_v1
					WHERE echantillon_analyse_materiau_v1 = {$idechantillon}
						AND (molp_analyse_materiau_v1_couche = {$this::$MOLP_ANALYSE_WAITING} OR molp_analyse_materiau_v1_couche = 2)";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function listAnalyseCoucheMolpDossier($id_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT dossier.*, analyse_materiau_v1_couche.*, ref_echantillon_analyse as ref_echantillon, ref_client_echantillon_analyse AS ref_client_echantillon, localisation_echantillon_analyse AS localisation_echantillon, '0' as id_echantillon
				FROM dossier
				JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier = type_dossier_analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
				WHERE id_dossier = {$id_dossier} 
				AND (molp_analyse_materiau_v1_couche = {$this::$MOLP_ANALYSE_WAITING} OR molp_analyse_materiau_v1_couche = 2)

				UNION

				SELECT dossier.*, analyse_materiau_v1_couche.*, ref_echantillon, '' as ref_client_echantillon, localisation_echantillon, '0' as id_echantillon
				FROM dossier
				JOIN echantillon ON dossier_echantillon = id_dossier
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier = type_dossier_analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
				WHERE id_dossier = {$id_dossier} 
				AND (molp_analyse_materiau_v1_couche = {$this::$MOLP_ANALYSE_WAITING} OR molp_analyse_materiau_v1_couche = 2)
				";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function listAnalyseCoucheValidationTechMolp($id_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT dossier.*, analyse_materiau_v1.*, analyse_materiau_v1_molp_couche.*, analyse_materiau_v1_couche.*, ref_echantillon_analyse as ref_echantillon, ref_client_echantillon_analyse AS ref_client_echantillon, localisation_echantillon_analyse AS localisation_echantillon, '0' as id_echantillon
		FROM dossier
		JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
		JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier = type_dossier_analyse_materiau_v1
		JOIN (
			SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
			FROM analyse_materiau_v1
			GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
		) last_revision ON id_max_rev = id_analyse_materiau_v1
		JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
		JOIN analyse_materiau_v1_molp_couche ON analyse_materiau_v1_molp_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
		WHERE id_dossier = {$id_dossier} 
		AND molp_analyse_materiau_v1_couche = 2

		UNION

		SELECT dossier.*, analyse_materiau_v1.*, analyse_materiau_v1_molp_couche.*, analyse_materiau_v1_couche.*, ref_echantillon, '' as ref_client_echantillon, localisation_echantillon, '0' as id_echantillon
		FROM dossier
		JOIN echantillon ON dossier_echantillon = id_dossier
		JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier = type_dossier_analyse_materiau_v1
		JOIN (
			SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
			FROM analyse_materiau_v1
			GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
		) last_revision ON id_max_rev = id_analyse_materiau_v1
		JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
		JOIN analyse_materiau_v1_molp_couche ON analyse_materiau_v1_molp_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
		WHERE id_dossier = {$id_dossier} 
		AND molp_analyse_materiau_v1_couche =  2
		";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function listAnalyseCoucheMetaEchantillonPrepa($id_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT dossier.*, analyse_materiau_v1_couche.*, ref_echantillon_analyse as ref_echantillon, ref_client_echantillon_analyse AS ref_client_echantillon, localisation_echantillon_analyse AS localisation_echantillon, '0' as id_echantillon
				FROM dossier
				JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier = type_dossier_analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
				WHERE id_dossier = {$id_dossier} 
				AND (meta_analyse_materiau_v1_couche = {$this::$META_PREPA_WAITING} OR meta_analyse_materiau_v1_couche = {$this::$META_PREPA_REDO})

				UNION

				SELECT dossier.*, analyse_materiau_v1_couche.*, ref_echantillon, '' as ref_client_echantillon, localisation_echantillon, '0' as id_echantillon
				FROM dossier
				JOIN echantillon ON dossier_echantillon = id_dossier
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier = type_dossier_analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
				WHERE id_dossier = {$id_dossier} 
				AND (meta_analyse_materiau_v1_couche = {$this::$META_PREPA_WAITING} OR meta_analyse_materiau_v1_couche = {$this::$META_PREPA_REDO})";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 */
	function listAnalyseCoucheEchantillon($idechantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
		FROM analyse_materiau_v1
			JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
			LEFT JOIN (
				SELECT analyse_materiau_v1_couche, max(id_analyse_materiau_v1_couche_meta_prepa) as id_prepa_max
				FROM analyse_materiau_v1_couche_meta_prepa
				group by analyse_materiau_v1_couche
			) as max_prep ON id_analyse_materiau_v1_couche = max_prep.analyse_materiau_v1_couche
			LEFT JOIN analyse_materiau_v1_couche_meta_prepa ON id_prepa_max = id_analyse_materiau_v1_couche_meta_prepa
			LEFT JOIN (
				SELECT analyse_materiau_v1_couche, max(id_analyse_materiau_v1_couche_meta_depot) as id_depot_max
				FROM analyse_materiau_v1_couche_meta_depot
				group by analyse_materiau_v1_couche
			) as max_depot ON id_analyse_materiau_v1_couche = max_depot.analyse_materiau_v1_couche
			LEFT JOIN analyse_materiau_v1_couche_meta_depot ON id_depot_max = id_analyse_materiau_v1_couche_meta_depot
		WHERE echantillon_analyse_materiau_v1 = {$idechantillon}
						AND (meta_analyse_materiau_v1_couche > {$this::$META_DEPOT_DONE} OR molp_analyse_materiau_v1_couche > {$this::$MOLP_ANALYSE_NO_NEED})";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function showAnalysePrepaMETA($id_analyse_META) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT analyse_materiau_v1_couche_meta_prepa.*
		FROM analyse_materiau_v1_couche_meta_analyse
		JOIN analyse_materiau_v1_couche_meta_depot ON id_analyse_materiau_v1_couche_meta_depot = analyse_materiau_v1_couche_meta_depot
		JOIN analyse_materiau_v1_couche_meta_prepa ON id_analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa
		WHERE id_analyse_materiau_v1_couche_meta_analyse = {$id_analyse_META}";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function lastAnalyseMETACouche($id_couche) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
		FROM analyse_materiau_v1_couche_meta_analyse
		WHERE analyse_materiau_v1_couche = {$id_couche}
		ORDER BY id_analyse_materiau_v1_couche_meta_analyse desc
		LIMIT 1";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}
	/**
	 * 
	 */
	function listAnalyseCoucheMetaPrepaEchantillon($idechantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
					FROM analyse_materiau_v1
						JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
						JOIN (
								SELECT analyse_materiau_v1_couche, max(id_analyse_materiau_v1_couche_meta_prepa) AS id_max
								FROM analyse_materiau_v1_couche_meta_prepa
								GROUP BY analyse_materiau_v1_couche
							) AS max_prep ON id_analyse_materiau_v1_couche = max_prep.analyse_materiau_v1_couche
						JOIN analyse_materiau_v1_couche_meta_prepa ON id_max = id_analyse_materiau_v1_couche_meta_prepa
						WHERE echantillon_analyse_materiau_v1 = {$idechantillon}";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 */
	function listAnalyseCoucheMetaDepotEchantillon($id_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT dossier.*, analyse_materiau_v1_couche.*, ref_echantillon_analyse as ref_echantillon, ref_client_echantillon_analyse AS ref_client_echantillon, localisation_echantillon_analyse AS localisation_echantillon, '0' as id_echantillon
				FROM dossier
				JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier = type_dossier_analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
				JOIN (
						SELECT analyse_materiau_v1_couche, max(id_analyse_materiau_v1_couche_meta_prepa) AS id_max
						FROM analyse_materiau_v1_couche_meta_prepa
						GROUP BY analyse_materiau_v1_couche
					) AS max_prep ON id_analyse_materiau_v1_couche = max_prep.analyse_materiau_v1_couche
				JOIN analyse_materiau_v1_couche_meta_prepa ON id_max = id_analyse_materiau_v1_couche_meta_prepa
				WHERE id_dossier = {$id_dossier} 
				AND meta_analyse_materiau_v1_couche > 2

				UNION

				SELECT dossier.*, analyse_materiau_v1_couche.*, ref_echantillon, '' as ref_client_echantillon, localisation_echantillon, '0' as id_echantillon
				FROM dossier
				JOIN echantillon ON dossier_echantillon = id_dossier
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier = type_dossier_analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
				JOIN (
						SELECT analyse_materiau_v1_couche, max(id_analyse_materiau_v1_couche_meta_prepa) AS id_max
						FROM analyse_materiau_v1_couche_meta_prepa
						GROUP BY analyse_materiau_v1_couche
					) AS max_prep ON id_analyse_materiau_v1_couche = max_prep.analyse_materiau_v1_couche
				JOIN analyse_materiau_v1_couche_meta_prepa ON id_max = id_analyse_materiau_v1_couche_meta_prepa
				WHERE id_dossier = {$id_dossier} 
				AND meta_analyse_materiau_v1_couche > 2";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 *
	 */

	function listAnalyseCoucheMetaRangementEchantillon($id_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT dossier.*, analyse_materiau_v1_couche.*, ref_echantillon_analyse as ref_echantillon, ref_client_echantillon_analyse AS ref_client_echantillon, localisation_echantillon_analyse AS localisation_echantillon, nbr_prepa, nbr_depot
				FROM dossier
				JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse AND type_dossier = type_dossier_analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
				
				JOIN (
						SELECT analyse_materiau_v1_couche, max(id_analyse_materiau_v1_couche_meta_prepa) AS id_max
						FROM analyse_materiau_v1_couche_meta_prepa
						GROUP BY analyse_materiau_v1_couche
					) AS max_prep ON id_analyse_materiau_v1_couche = max_prep.analyse_materiau_v1_couche
				JOIN analyse_materiau_v1_couche_meta_prepa ON id_max = id_analyse_materiau_v1_couche_meta_prepa
				
				JOIN (
						SELECT analyse_materiau_v1_couche, max(id_analyse_materiau_v1_couche_meta_depot) as id_depot_max
						FROM analyse_materiau_v1_couche_meta_depot
						group by analyse_materiau_v1_couche
					) as max_depot ON id_analyse_materiau_v1_couche = max_depot.analyse_materiau_v1_couche
				JOIN analyse_materiau_v1_couche_meta_depot ON id_depot_max = id_analyse_materiau_v1_couche_meta_depot

				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_prepa) as nbr_prepa
					FROM analyse_materiau_v1_couche_meta_prepa
					WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 0
					GROUP BY analyse_materiau_v1_couche
				) as countPrepa ON id_analyse_materiau_v1_couche = countPrepa.analyse_materiau_v1_couche
				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_depot) as nbr_depot
					FROM analyse_materiau_v1_couche_meta_depot
					WHERE is_active_analyse_materiau_v1_couche_meta_depot = 0
					GROUP BY analyse_materiau_v1_couche
				) as countDepot ON id_analyse_materiau_v1_couche = countDepot.analyse_materiau_v1_couche
			
				WHERE id_dossier = {$id_dossier} 
				AND meta_analyse_materiau_v1_couche > 4

				UNION

				SELECT dossier.*, analyse_materiau_v1_couche.*, ref_echantillon, '' AS ref_client_echantillon, localisation_echantillon, nbr_prepa, nbr_depot
				FROM dossier
				JOIN echantillon ON dossier_echantillon_analyse = id_dossier
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon AND type_dossier = type_dossier_analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche = id_analyse_materiau_v1
				
				JOIN (
						SELECT analyse_materiau_v1_couche, max(id_analyse_materiau_v1_couche_meta_prepa) AS id_max
						FROM analyse_materiau_v1_couche_meta_prepa
						GROUP BY analyse_materiau_v1_couche
					) AS max_prep ON id_analyse_materiau_v1_couche = max_prep.analyse_materiau_v1_couche
				JOIN analyse_materiau_v1_couche_meta_prepa ON id_max = id_analyse_materiau_v1_couche_meta_prepa
				
				JOIN (
						SELECT analyse_materiau_v1_couche, max(id_analyse_materiau_v1_couche_meta_depot) as id_depot_max
						FROM analyse_materiau_v1_couche_meta_depot
						group by analyse_materiau_v1_couche
					) as max_depot ON id_analyse_materiau_v1_couche = max_depot.analyse_materiau_v1_couche
				JOIN analyse_materiau_v1_couche_meta_depot ON id_depot_max = id_analyse_materiau_v1_couche_meta_depot

				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_prepa) as nbr_prepa
					FROM analyse_materiau_v1_couche_meta_prepa
					WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 0
					GROUP BY analyse_materiau_v1_couche
				) as countPrepa ON id_analyse_materiau_v1_couche = countPrepa.analyse_materiau_v1_couche
				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_depot) as nbr_depot
					FROM analyse_materiau_v1_couche_meta_depot
					WHERE is_active_analyse_materiau_v1_couche_meta_depot = 0
					GROUP BY analyse_materiau_v1_couche
				) as countDepot ON id_analyse_materiau_v1_couche = countDepot.analyse_materiau_v1_couche
			
				WHERE id_dossier = {$id_dossier} 
				AND meta_analyse_materiau_v1_couche > 4";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function addAnalyseMateriauV1_MolpCouche($nb_lames_analyse_materiau_v1_molp_couche, $type_fibres_analyse_materiau_v1_molp_couche, $observations_interne_analyse_materiau_v1_molp_couche, $observations_rapport_analyse_materiau_v1_molp_couche, $preparation_analyse_materiau_v1_molp_couche, $analyse_materiau_v1_couche, $date_analyse_materiau_v1_molp_couche, $operateur_analyse_materiau_v1_molp_couche, $stagiaire_analyse_materiau_v1_molp_couche, $ref_molp_analyse_materiau_v1_molp_couche, $hotte_analyse_materiau_v1_molp_couche, $loupe_analyse_materiau_v1_molp_couche, $consommable_indice_refraction_analyse_materiau_v1_molp_couche) {
		$data = new stdClass();
		$data->id_analyse_materiau_v1_molp_couche  = null;
		$data->nb_lames_analyse_materiau_v1_molp_couche  = $nb_lames_analyse_materiau_v1_molp_couche;

		$data->type_fibres_analyse_materiau_v1_molp_couche  = $type_fibres_analyse_materiau_v1_molp_couche;
		$data->observations_interne_analyse_materiau_v1_molp_couche = $observations_interne_analyse_materiau_v1_molp_couche;
		$data->observations_rapport_analyse_materiau_v1_molp_couche = $observations_rapport_analyse_materiau_v1_molp_couche;
		$data->preparation_analyse_materiau_v1_molp_couche  = $preparation_analyse_materiau_v1_molp_couche;

		$data->analyse_materiau_v1_couche = $analyse_materiau_v1_couche;
		$data->date_analyse_materiau_v1_molp_couche = $date_analyse_materiau_v1_molp_couche;
		$data->operateur_analyse_materiau_v1_molp_couche  = $operateur_analyse_materiau_v1_molp_couche;
		$data->stagiaire_analyse_materiau_v1_molp_couche  = $stagiaire_analyse_materiau_v1_molp_couche;
		$data->ref_molp_analyse_materiau_v1_molp_couche  = $ref_molp_analyse_materiau_v1_molp_couche;

		$data->hotte_analyse_materiau_v1_molp_couche  = $hotte_analyse_materiau_v1_molp_couche;
		$data->loupe_analyse_materiau_v1_molp_couche  = $loupe_analyse_materiau_v1_molp_couche;
		$data->consommable_indice_refraction_analyse_materiau_v1_molp_couche  = $consommable_indice_refraction_analyse_materiau_v1_molp_couche;

		$db = JFactory::getDBOGBMNet();
		return $db->insertObject('analyse_materiau_v1_molp_couche', $data, 'id_analyse_materiau_v1_molp_couche');
	}

	function getIdAnalyseMatriauxCouche($idEchantillon) {
		$db = JFactory::getDBOGBMNet();
		// Get the id of analyse_mateirau_v1_couche to update.
		$query = "SELECT `id_analyse_materiau_v1_couche` 
			FROM `analyse_materiau_v1_couche` 
				JOIN `analyse_materiau_v1` ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
			WHERE echantillon_analyse_materiau_v1 = {$idEchantillon}";
		$db->setQuery($query);
		$idCouches = $db->loadObjectList();
		return $idCouches;
	}

	function updateMolpAnalyseCouche($id_analyse_materiau_v1_couche) {
		$couche = new stdClass();

		$couche->id_analyse_materiau_v1_couche = $id_analyse_materiau_v1_couche;
		$couche->molp_analyse_materiau_v1_couche = $this::$MOLP_VALIDATION_TECHIQUE;

		$db = JFactory::getDBOGBMNet();
		$db->updateObject('analyse_materiau_v1_couche', $couche, 'id_analyse_materiau_v1_couche');
	}
	/**
	 * Update the META status for the couche.
	 * Change the 'meta_analyse_materiau_v1_couche' field from the 'analyse_materiau_v1_couche table'.
	 * Code status : 
	 * 		- 0 : No Need.
	 * 		- 1 : prepa waiting.
	 * 		- 2 : prepa done.
	 * 		- 3 : depot waiting.
	 * 		- 4 : depot done.
	 * 		- 5 : rangement waiting.
	 * 		- 6 : rangement done.
	 * 		- 7 : analyse waiting.
	 * 		- 8 : analyse done.
	 * 
	 * Throw an exception when the status code is wrong.
	 * 
	 * @param {int} $id_analyse_materiau_v1_couche - Id the couche to update.
	 * @param {int} $newStatus - Code of the new staut.
	 * @return {Boolean} True if ok, false otherwise.
	 */
	function updateStatusMetaAnalyseCouche($id_analyse_materiau_v1_couche, $newStatus) {
		// IF $newStatus is not numeric and, if ¬ $newStatus ϵ [0,8] (not 0 ≤ $newStatus ≤ 8), throw an exception.
		if ((!is_numeric($newStatus)) || ($newStatus < $this::$META_ANALYSE_NO_NEED || $newStatus > $this::$META_ANALYSE_DONE)) {
			throw new Exception("Mauvais code statut d'analyse META pour la couche {$id_analyse_materiau_v1_couche} - Code statut reçu : {$newStatus}");
		}

		$couche = new stdClass();
		$couche->id_analyse_materiau_v1_couche = $id_analyse_materiau_v1_couche;
		$couche->meta_analyse_materiau_v1_couche = $newStatus;

		$db = JFactory::getDBOGBMNet();
		return $db->updateObject('analyse_materiau_v1_couche', $couche, 'id_analyse_materiau_v1_couche');
	}
	/**
	 * Add a preparation to the table "analyse_materiau_v1_couche_meta_prepa"
	 * 
	 * @param {"decomposed" Object} All the fields corresponding to a Preparation object.
	 * @return {Boolean} True if ok, false otherwise.
	 */
	function addAnalyseMateriauV1_MetaPrepa($analyse_materiau_v1_couche, $date_analyse_materiau_v1_couche_meta_prepa, $operateur_analyse_materiau_v1_couche_meta_prepa, $stagiaire_analyse_materiau_v1_couche_meta_prepa, $hotte_materiel_analyse_materiau_v1_couche_meta_prepa, $eau_consommable_analyse_materiau_v1_couche_meta_prepa, $acetone_consommable_analyse_materiau_v1_couche_meta_prepa, $chloroforme_consommable_analyse_materiau_v1_couche_meta_prepa, $acide_consommable_analyse_materiau_v1_couche_meta_prepa, $qte_matiere_analyse_materiau_v1_couche_meta_prepa, $qte_equivalente_analyse_materiau_v1_couche_meta_prepa, $broyage_analyse_materiau_v1_couche_meta_prepa, $eau_analyse_materiau_v1_couche_meta_prepa, $acetone_analyse_materiau_v1_couche_meta_prepa, $chloroforme_analyse_materiau_v1_couche_meta_prepa, $hcl_analyse_materiau_v1_couche_meta_prepa, $nb_grilles_analyse_materiau_v1_couche_meta_prepa, $commentaires_analyse_materiau_v1_couche_meta_prepa, $remarque_rapport_analyse_materiau_v1_couche_meta_prepa, $num_prepa_couche_analyse_materiau_v1_couche_meta_prepa, $portoir_analyse_materiau_v1_couche_meta_prepa) {
		$newPreparation = new stdClass();
		$newPreparation->id_analyse_materiau_v1_couche_meta_prepa  = null;
		$newPreparation->analyse_materiau_v1_couche  = $analyse_materiau_v1_couche;

		$newPreparation->date_analyse_materiau_v1_couche_meta_prepa  = $date_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->operateur_analyse_materiau_v1_couche_meta_prepa  = $operateur_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->stagiaire_analyse_materiau_v1_couche_meta_prepa  = $stagiaire_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->hotte_materiel_analyse_materiau_v1_couche_meta_prepa  = $hotte_materiel_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->eau_consommable_analyse_materiau_v1_couche_meta_prepa  = $eau_consommable_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->acetone_consommable_analyse_materiau_v1_couche_meta_prepa  = $acetone_consommable_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->chloroforme_consommable_analyse_materiau_v1_couche_meta_prepa  = $chloroforme_consommable_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->acide_consommable_analyse_materiau_v1_couche_meta_prepa  = $acide_consommable_analyse_materiau_v1_couche_meta_prepa;

		$newPreparation->qte_matiere_analyse_materiau_v1_couche_meta_prepa  = $qte_matiere_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->qte_equivalente_analyse_materiau_v1_couche_meta_prepa   = $qte_equivalente_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->broyage_analyse_materiau_v1_couche_meta_prepa  = $broyage_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->eau_analyse_materiau_v1_couche_meta_prepa  = $eau_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->acetone_analyse_materiau_v1_couche_meta_prepa  = $acetone_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->chloroforme_analyse_materiau_v1_couche_meta_prepa  = $chloroforme_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->hcl_analyse_materiau_v1_couche_meta_prepa  = $hcl_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->nb_grilles_analyse_materiau_v1_couche_meta_prepa  = $nb_grilles_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->commentaires_analyse_materiau_v1_couche_meta_prepa  = $commentaires_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->remarque_rapport_analyse_materiau_v1_couche_meta_prepa  = $remarque_rapport_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->num_prepa_couche_analyse_materiau_v1_couche_meta_prepa  = $num_prepa_couche_analyse_materiau_v1_couche_meta_prepa;
		$newPreparation->portoir_analyse_materiau_v1_couche_meta_prepa  = $portoir_analyse_materiau_v1_couche_meta_prepa;

		$newPreparation->is_active_analyse_materiau_v1_couche_meta_prepa  = 1;

		$db = JFactory::getDBOGBMNet();
		return  $db->insertObject('analyse_materiau_v1_couche_meta_prepa', $newPreparation, 'id_analyse_materiau_v1_couche_meta_prepa');
	}
	/**
	 * Add new depot to the "analyse_materiau_v1_couche_meta_depot" table.
	 * Set only the "deposit" fields, leave the "archiving" fields blank.
	 * 
	 * @param {Object} All the fields corresponding to a Depot object.
	 * @return {Boolean} True if ok, false otherwise. 
	 */
	function addAnalyseMateriauV1_MetaDepot($newDepot) {
		$db = JFactory::getDBOGBMNet();
		return $db->insertObject('analyse_materiau_v1_couche_meta_depot', $newDepot, 'id_analyse_materiau_v1_couche_meta_depot');
	}
	/**
	 * Archived the depot updating an instance of the "analyse_materiau_v1_couche_meta_depot" table.
	 * 
	 * @param {Object} $depot.
	 * @return {Boolean} True if ok, false otherwise. 
	 */
	function archivedCoucheMetaDepot($depotToArchived) {
		$db = JFactory::getDBOGBMNet();
		return $db->updateObject('analyse_materiau_v1_couche_meta_depot', $depotToArchived, 'id_analyse_materiau_v1_couche_meta_depot');
	}
	/**
	 * 
	 */
	function ListeEchantillonAnalyseMetaDossier($dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
			FROM echantillon_analyse, type_prelevement, qualification_analyse
				WHERE dossier_echantillon_analyse = {$dossier}
					AND detail_echantillon_analyse = id_type_prelevement
					AND qualification_analyse_type_prelevement = id_qualification_analyse
				ORDER BY mois_ref_echantillon_analyse ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * Add an Analysis to the table "analyse_materiau_v1_couche_meta_analyse"
	 * 
	 * @param {Analyse Object}.
	 * @return {Boolean} True if ok, false otherwise.
	 */
	function addAnalyseMateriauV1_MetaAnalyse($newAnalyse) {
		$db = JFactory::getDBOGBMNet();
		return  $db->insertObject('analyse_materiau_v1_couche_meta_analyse', $newAnalyse, 'id_analyse_materiau_v1_couche_meta_analyse');
	}
	/**
	 *  
	 */
	function setActiveMetaPrepa($id_analyse_materiau_v1_couche_meta_prepa, $active_analyse_materiau_v1_couche_meta_prepa) {
		$couche = new stdClass();
		$couche->id_analyse_materiau_v1_couche_meta_prepa = $id_analyse_materiau_v1_couche_meta_prepa;
		$couche->active_analyse_materiau_v1_couche_meta_prepa = $active_analyse_materiau_v1_couche_meta_prepa;

		$db = JFactory::getDBOGBMNet();
		return $db->updateObject('analyse_materiau_v1_couche_meta_prepa', $couche, 'id_analyse_materiau_v1_couche_meta_prepa');
	}
	/**
	 *  
	 */
	function setActiveMetaDepot($id_analyse_materiau_v1_couche_meta_depot, $active_analyse_materiau_v1_couche_meta_depot) {
		$couche = new stdClass();
		$couche->id_analyse_materiau_v1_couche_meta_depot = $id_analyse_materiau_v1_couche_meta_depot;
		$couche->active_analyse_materiau_v1_couche_meta_depot = $active_analyse_materiau_v1_couche_meta_depot;

		$db = JFactory::getDBOGBMNet();
		return $db->updateObject('analyse_materiau_v1_couche_meta_depot', $couche, 'id_analyse_materiau_v1_couche_meta_depot');
	}
	/**
	 * 
	 */
	function ListeEchantillonMetaAnalyseDossier($dossier) {
		$db = JFactory::getDBOGBMNet();

		$query = "SELECT *
					FROM echantillon_analyse, type_prelevement, qualification_analyse
        			JOIN (SELECT * FROM analyse_materiau_v1
    						JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
    						WHERE analyse_materiau_v1_couche.meta_analyse_materiau_v1_couche > 0
    						GROUP BY id_analyse_materiau_v1
        				) AS analyse_meta_whithout_molp
					WHERE echantillon_analyse.dossier_echantillon_analyse = {$dossier}
					AND echantillon_analyse.detail_echantillon_analyse = id_type_prelevement
					AND qualification_analyse_type_prelevement = id_qualification_analyse
        			AND analyse_meta_whithout_molp.echantillon_analyse_materiau_v1 = echantillon_analyse.id_echantillon_analyse
					ORDER BY echantillon_analyse.mois_ref_echantillon_analyse ASC";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function listeEchantillonsByBoiteArchive($id_boite) {
		$db = JFactory::getDBOGBMNet();
		$query = "
			SELECT ref_echantillon_analyse as ref_echantillon , emplacement_grille_analyse_materiau_v1_couche_meta_depot, data_couche_analyse_materiau_v1_couche, id_analyse_materiau_v1_couche_meta_prepa, analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa, analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche, id_analyse_materiau_v1_couche, analyse_materiau_v1_couche.analyse_materiau_v1_couche, id_analyse_materiau_v1, echantillon_analyse_materiau_v1, id_echantillon_analyse

			FROM analyse_materiau_v1_couche_meta_depot

			JOIN analyse_materiau_v1_couche_meta_prepa 
				ON id_analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa
			JOIN analyse_materiau_v1_couche 
				ON analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
			JOIN analyse_materiau_v1 
				ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1

			JOIN echantillon_analyse 
				ON echantillon_analyse_materiau_v1 = id_echantillon_analyse

			WHERE boite_archive_analyse_materiau_v1_couche_meta_depot = {$id_boite}
				AND type_dossier_analyse_materiau_v1= 2 

			UNION
			
			SELECT ref_echantillon , emplacement_grille_analyse_materiau_v1_couche_meta_depot, data_couche_analyse_materiau_v1_couche, id_analyse_materiau_v1_couche_meta_prepa, analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa, analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche, id_analyse_materiau_v1_couche, analyse_materiau_v1_couche.analyse_materiau_v1_couche, id_analyse_materiau_v1, echantillon_analyse_materiau_v1, id_echantillon

			FROM analyse_materiau_v1_couche_meta_depot

			JOIN analyse_materiau_v1_couche_meta_prepa 
				ON id_analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa
			JOIN analyse_materiau_v1_couche 
				ON analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
			JOIN analyse_materiau_v1 
				ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
			JOIN echantillon
				ON echantillon_analyse_materiau_v1 = id_echantillon

			WHERE boite_archive_analyse_materiau_v1_couche_meta_depot = {$id_boite}
				AND type_dossier_analyse_materiau_v1= 1";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	/**
	 * 
	 */
	function getEchantillonCoucheDossierPreValidMeta($dossier) {
		$db = JFactory::getDBOGBMNet();

		$query = "SELECT nbr_prepa, nbr_depot, consommable.*, analyse_materiau_v1_couche_meta_prepa.*, analyse_materiau_v1_couche_meta_depot.*, analyse_materiau_v1_couche.*, ref_echantillon_analyse as ref_echantillon, ref_client_echantillon_analyse AS ref_client_echantillon, localisation_echantillon_analyse AS localisation_echantillon, fiche_analyse_echantillon_analyse AS fiche_analyse_echantillon
		 		FROM analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1

				JOIN echantillon_analyse ON id_echantillon_analyse = analyse_materiau_v1.echantillon_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1                
				LEFT JOIN analyse_materiau_v1_couche_meta_depot ON analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
				LEFT JOIN consommable ON boite_archive_analyse_materiau_v1_couche_meta_depot = id_consommable
				LEFT JOIN analyse_materiau_v1_couche_meta_prepa ON id_analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa
				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_prepa) as nbr_prepa
					FROM analyse_materiau_v1_couche_meta_prepa
					WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 0
					GROUP BY analyse_materiau_v1_couche
				) as countPrepa ON id_analyse_materiau_v1_couche = countPrepa.analyse_materiau_v1_couche
				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_depot) as nbr_depot
					FROM analyse_materiau_v1_couche_meta_depot
					WHERE is_active_analyse_materiau_v1_couche_meta_depot = 0
					GROUP BY analyse_materiau_v1_couche
				) as countDepot ON id_analyse_materiau_v1_couche = countDepot.analyse_materiau_v1_couche
				WHERE dossier_echantillon_analyse = {$dossier}
				AND meta_analyse_materiau_v1_couche > 0

				UNION

				SELECT nbr_prepa, nbr_depot, consommable.*, analyse_materiau_v1_couche_meta_prepa.*, analyse_materiau_v1_couche_meta_depot.*, analyse_materiau_v1_couche.*, ref_echantillon, '' AS ref_client_echantillon, localisation_echantillon, fiche_analyse_echantillon
				FROM analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
				
				JOIN echantillon ON id_echantillon = analyse_materiau_v1.echantillon_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1                
				LEFT JOIN analyse_materiau_v1_couche_meta_depot ON analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
				LEFT JOIN consommable ON boite_archive_analyse_materiau_v1_couche_meta_depot = id_consommable
				LEFT JOIN analyse_materiau_v1_couche_meta_prepa ON id_analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa
				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_prepa) as nbr_prepa
					FROM analyse_materiau_v1_couche_meta_prepa
					WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 0
					GROUP BY analyse_materiau_v1_couche
				) as countPrepa ON id_analyse_materiau_v1_couche = countPrepa.analyse_materiau_v1_couche
				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_depot) as nbr_depot
					FROM analyse_materiau_v1_couche_meta_depot
					WHERE is_active_analyse_materiau_v1_couche_meta_depot = 0
					GROUP BY analyse_materiau_v1_couche
				) as countDepot ON id_analyse_materiau_v1_couche = countDepot.analyse_materiau_v1_couche
				WHERE dossier_echantillon = {$dossier}
				AND meta_analyse_materiau_v1_couche > 0";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	/**
	 * 
	 */
	function listEchantillonCoucheAnalyseDossier($dossier) {
		$db = JFactory::getDBOGBMNet();

		$query = "SELECT nbr_prepa, nbr_depot, consommable.*, analyse_materiau_v1_couche_meta_prepa.*, analyse_materiau_v1_couche_meta_depot.*, analyse_materiau_v1_couche.*, ref_echantillon_analyse as ref_echantillon, ref_client_echantillon_analyse AS ref_client_echantillon, localisation_echantillon_analyse AS localisation_echantillon, fiche_analyse_echantillon_analyse AS fiche_analyse_echantillon
		 		FROM analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1

				JOIN echantillon_analyse ON id_echantillon_analyse = analyse_materiau_v1.echantillon_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1                
				JOIN analyse_materiau_v1_couche_meta_depot ON analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
				JOIN consommable ON boite_archive_analyse_materiau_v1_couche_meta_depot = id_consommable
				JOIN analyse_materiau_v1_couche_meta_prepa ON id_analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa
				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_prepa) as nbr_prepa
					FROM analyse_materiau_v1_couche_meta_prepa
					WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 0
					GROUP BY analyse_materiau_v1_couche
				) as countPrepa ON id_analyse_materiau_v1_couche = countPrepa.analyse_materiau_v1_couche
				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_depot) as nbr_depot
					FROM analyse_materiau_v1_couche_meta_depot
					WHERE is_active_analyse_materiau_v1_couche_meta_depot = 0
					GROUP BY analyse_materiau_v1_couche
				) as countDepot ON id_analyse_materiau_v1_couche = countDepot.analyse_materiau_v1_couche
				WHERE dossier_echantillon_analyse = {$dossier}
				AND is_active_analyse_materiau_v1_couche_meta_depot = 1                    
				AND is_archived_materiau_v1_couche_meta_depot = 1

				UNION

				SELECT nbr_prepa, nbr_depot, consommable.*, analyse_materiau_v1_couche_meta_prepa.*, analyse_materiau_v1_couche_meta_depot.*, analyse_materiau_v1_couche.*, ref_echantillon, '' AS ref_client_echantillon, localisation_echantillon, fiche_analyse_echantillon
				FROM analyse_materiau_v1
				JOIN (
					SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, max(id_analyse_materiau_v1) as id_max_rev
					FROM analyse_materiau_v1
					GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
				) last_revision ON id_max_rev = id_analyse_materiau_v1
				
				JOIN echantillon ON id_echantillon = analyse_materiau_v1.echantillon_analyse_materiau_v1
				JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1                
				JOIN analyse_materiau_v1_couche_meta_depot ON analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
				JOIN consommable ON boite_archive_analyse_materiau_v1_couche_meta_depot = id_consommable
				JOIN analyse_materiau_v1_couche_meta_prepa ON id_analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa
				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_prepa) as nbr_prepa
					FROM analyse_materiau_v1_couche_meta_prepa
					WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 0
					GROUP BY analyse_materiau_v1_couche
				) as countPrepa ON id_analyse_materiau_v1_couche = countPrepa.analyse_materiau_v1_couche
				LEFT JOIN (
					SELECT analyse_materiau_v1_couche, count(id_analyse_materiau_v1_couche_meta_depot) as nbr_depot
					FROM analyse_materiau_v1_couche_meta_depot
					WHERE is_active_analyse_materiau_v1_couche_meta_depot = 0
					GROUP BY analyse_materiau_v1_couche
				) as countDepot ON id_analyse_materiau_v1_couche = countDepot.analyse_materiau_v1_couche
				WHERE dossier_echantillon = {$dossier}
				AND is_active_analyse_materiau_v1_couche_meta_depot = 1                    
				AND is_archived_materiau_v1_couche_meta_depot = 1";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * Get the list of a Couche Preparations.
	 * 
	 * @param {int} $id_couche
	 * @return {[{Preparation}]} 
	 */
	function listCouchePrepa($id_couche) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1_couche_meta_prepa
					WHERE analyse_materiau_v1_couche = {$id_couche}
					ORDER BY num_prepa_couche_analyse_materiau_v1_couche_meta_prepa";
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * .
	 * 
	 * @param {int} $id_couche
	 * @return {[{Preparation}]} 
	 */
	function listHistoriqueCouche($id_couche) {
		$db = JFactory::getDBOGBMNet();
		$query =
			"SELECT date_analyse_materiau_v1_couche_meta_prepa AS date_historique_couche, 
				commentaires_analyse_materiau_v1_couche_meta_prepa AS commentaire_historique_couche,
				remarque_rapport_analyse_materiau_v1_couche_meta_prepa as commentaire_rapport, 
				'' AS justificatif_historique_couche, 
				'Préparation' AS type_historique_couche,
				num_prepa_couche_analyse_materiau_v1_couche_meta_prepa AS num_historique_couche
			FROM analyse_materiau_v1_couche_meta_prepa 
			WHERE analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche = {$id_couche}
		UNION
		SELECT date_depot_analyse_materiau_v1_couche_meta_depot AS date_historique_couche, 
				commentaire_analyse_materiau_v1_couche_meta_depot AS commentaire_historique_couche, 
				'' AS commentaire_rapport, 
				redepot_justificatif_analyse_materiau_v1_couche_meta_depot AS justificatif_historique_couche, 
				'Dépot' as type_historique_couche,
				num_depot_preparation_analyse_materiau_v1_couche_meta_depot AS num_historique_couche
			FROM analyse_materiau_v1_couche_meta_depot
			WHERE analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche = {$id_couche}
		UNION
		SELECT date_analyse_materiau_v1_couche_meta_analyse AS date_historique_couche, 
				commentaires_analyse_materiau_v1_couche_meta_analyse AS commentaire_historique_couche, 
				observation_rapport_analyse_materiau_v1_couche_meta_analyse AS commentaire_rapport, 
				'' AS justificatif_historique_couche, 
				'Analyse' AS type_historique_couche,
				num_analyse_depot_analyse_materiau_v1_couche_meta_analyse AS num_historique_couche 
		FROM analyse_materiau_v1_couche_meta_analyse
		WHERE analyse_materiau_v1_couche_meta_analyse.analyse_materiau_v1_couche = {$id_couche}
        UNION
        SELECT date_analyse_materiau_v1_molp_couche AS date_historique_couche, 
				observations_interne_analyse_materiau_v1_molp_couche AS commentaire_historique_couche, 
				observations_rapport_analyse_materiau_v1_molp_couche AS commentaire_rapport, 
				resultat_molp_analyse_materiau_v1_molp_couche AS justificatif_historique_couche, 
				'Analyse MOLP' AS type_historique_couche,
				'' AS num_historique_couche 
			FROM analyse_materiau_v1_molp_couche
			WHERE analyse_materiau_v1_molp_couche.analyse_materiau_v1_couche = {$id_couche}
		
		UNION
		SELECT date_creation_dossier AS date_historique_couche, 
				remarque_interne_dossier AS commentaire_historique_couche, 
				'' AS commentaire_rapport, 
				'' AS justificatif_historique_couche, 
				'Enregistrement dossier' AS type_historique_couche,
				'' AS num_historique_couche 
			FROM dossier
			JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
			JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
			JOIN analyse_materiau_v1_couche ON id_analyse_materiau_v1 = analyse_materiau_v1_couche.analyse_materiau_v1_couche
			WHERE id_analyse_materiau_v1_couche = {$id_couche}
		UNION
		SELECT date_donne_client_dossier AS date_historique_couche, 
				remarque_interne_donne_client_dossier AS commentaire_historique_couche, 
				'' AS commentaire_rapport, 
				'' AS justificatif_historique_couche, 
				'Enregistrement données client' AS type_historique_couche,
				'' AS num_historique_couche 
			FROM dossier
			JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
			JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
			JOIN analyse_materiau_v1_couche ON id_analyse_materiau_v1 = analyse_materiau_v1_couche.analyse_materiau_v1_couche
			WHERE id_analyse_materiau_v1_couche = {$id_couche}
		UNION
		SELECT date_analyse_materiau_v1_couche AS date_historique_couche, 
				remarque_interne_analyse_materiau_v1_couche AS commentaire_historique_couche, 
				remarque_rapport_analyse_materiau_v1_couche AS commentaire_rapport, 
				'' AS justificatif_historique_couche, 
				'Examen préalable' AS type_historique_couche,
				'' AS num_historique_couche 
			FROM analyse_materiau_v1_exam_prea
			JOIN analyse_materiau_v1 ON id_analyse_materiau_v1 = analyse_materiau_v1_exam_prea
			JOIN analyse_materiau_v1_couche ON id_analyse_materiau_v1 = analyse_materiau_v1_couche.analyse_materiau_v1_couche
			WHERE id_analyse_materiau_v1_couche = {$id_couche}

		ORDER BY date_historique_couche ASC";
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * Get the list of a Couche Depots.
	 * 
	 * @param {int} $id_couche
	 * @return {[{Depot}]} 
	 */
	function listCoucheDepot($id_couche) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1_couche_meta_depot
					WHERE analyse_materiau_v1_couche = {$id_couche}
					ORDER BY num_depot_preparation_analyse_materiau_v1_couche_meta_depot";
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * Get the list of a Couche Depots for a prep.
	 * 
	 * @param {int} $id_couche
	 * @return {[{Depot}]} 
	 */
	function listCoucheDepotPreparation($id_prepa) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1_couche_meta_depot
					WHERE analyse_materiau_v1_couche_meta_prepa = {$id_prepa}
					ORDER BY num_depot_preparation_analyse_materiau_v1_couche_meta_depot";
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * Get the list of a Couche Analyses.
	 * 
	 * @param {int} $id_couche
	 * @return {[{Analyse}]} 
	 */
	function listCoucheMetaAnalyses($id_couche) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1_couche_meta_analyse
					WHERE analyse_materiau_v1_couche = {$id_couche}
					ORDER BY id_analyse_materiau_v1_couche_meta_analyse DESC";
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	function listCoucheMetaAnalysesPreValid($id_couche) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1_couche_meta_analyse
					WHERE analyse_materiau_v1_couche = {$id_couche}";
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * Get the list of a Couche Analyses.
	 * 
	 * @param {int} $id_couche
	 * @return {[{Analyse}]} 
	 */
	function listCoucheMeta($id_couche) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1_couche_meta_analyse
					WHERE analyse_materiau_v1_couche = {$id_couche}";
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * Get the list of a Couche Analyses.
	 * 
	 * @param {int} $id_couche
	 * @return {{Analyse}}
	 */
	function listCoucheMolpAnalyses($id_couche) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1_molp_couche
					WHERE analyse_materiau_v1_couche = {$id_couche}";
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}
	/**
	 * Get the Depot preparation.
	 * 
	 * @param {int} $id_depot
	 * @return {Preparation}
	 */
	function getDepotPreparation($id_depot) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1_couche_meta_prepa
					JOIN `analyse_materiau_v1_couche_meta_depot` ON analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_prepa.id_analyse_materiau_v1_couche_meta_prepa
					WHERE analyse_materiau_v1_couche_meta_depot.id_analyse_materiau_v1_couche_meta_depot = {$id_depot}";
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}
	/**
	 * Update the Depot
	 * 
	 * @param {Object} $depotUpdated
	 * @return {Boolean}
	 */
	function updateDepot($depotUpdated) {
		$db = JFactory::getDBOGBMNet();
		return $db->updateObject('analyse_materiau_v1_couche_meta_depot', $depotUpdated, 'id_analyse_materiau_v1_couche_meta_depot');
	}
	/**
	 *
	 */
	function getMetaPreparationCorrespondance() {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
					FROM analyse_materiau_v1_preparation_correspondance";
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * List all waiting validation Materiau's Analyses from a Dossier (type : Dossier Analyse, 2).
	 * Version 1.
	 * 
	 * @param {int} $id_dossier - Id of the Dossier.
	 * @return {[Object]} List of all analysis of a specifi file, wich aren't validate yet.
	 */
	function ListeAnalyseDossierAnalyseAttenteValidationMateriauV1($id_dossier) {
		$db = JFactory::getDBOGBMNet();
		// $query = "Select 
		// ref_echantillon_analyse AS ref_echantillon, couche_echantillon_analyse AS couche_echantillon, ref_client_echantillon_analyse AS ref_client_echantillon, localisation_echantillon_analyse AS localisation_echantillon, aspect_materiau_echantillon_analyse as aspect_materiau_echantillon,
		// nom_client_analyse AS nom_client, adresse_client_analyse AS adresse_client, cp_client_analyse AS cp_client, ville_client_analyse AS ville_client,
		// ref_qualification_analyse as ref_qualification, nom_qualification_analyse as nom_qualification,
		// chantier_analyse_dossier as ref_affaire,
		// analyse_materiau_v1.*, dossier.*, id_api_prelevement_echantillon_analyse
		// from echantillon_analyse, type_prelevement, qualification_analyse, analyse_materiau_v1, client_analyse, dossier
		// where `echantillon_analyse`.`dossier_echantillon_analyse` = ".$id_dossier."
		// and dossier_echantillon_analyse = id_dossier
		// and echantillon_analyse_materiau_v1 = `echantillon_analyse`.`id_echantillon_analyse`
		// and type_dossier = type_dossier_analyse_materiau_v1
		// and validation_analyse_materiau_v1 = 0 
		// and detail_echantillon_analyse = id_type_prelevement
		// and qualification_analyse_type_prelevement = id_qualification_analyse
		// and `dossier`.`client_dossier` = client_analyse.id_client_analyse
		// order by `echantillon_analyse`.mois_ref_echantillon_analyse ASC";

		$query = "Select 
					ref_echantillon_analyse AS ref_echantillon, couche_echantillon_analyse AS couche_echantillon, ref_client_echantillon_analyse AS ref_client_echantillon, localisation_echantillon_analyse AS localisation_echantillon, aspect_materiau_echantillon_analyse as aspect_materiau_echantillon,
					nom_client_analyse AS nom_client, adresse_client_analyse AS adresse_client, cp_client_analyse AS cp_client, ville_client_analyse AS ville_client,
					ref_qualification_analyse as ref_qualification, nom_qualification_analyse as nom_qualification,
					chantier_analyse_dossier as ref_affaire,
					analyse_materiau_v1.*, dossier.*, id_api_prelevement_echantillon_analyse
				FROM echantillon_analyse

				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse and type_dossier = type_dossier_analyse_materiau_v1

				LEFT JOIN analyse_externe_prestation_objectif ON objectif_echantillon_analyse = id_analyse_externe_prestation_objectif
				JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
				
				JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
				JOIN analyse_externe_polluant ON id_analyse_externe_polluant = polluant_analyse_externe_prestation
				JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse
				
				JOIN client_analyse ON client_dossier = id_client_analyse

				where `echantillon_analyse`.`dossier_echantillon_analyse` = " . $id_dossier . "
				and validation_analyse_materiau_v1 = 0 
				order by `echantillon_analyse`.ref_client_echantillon_analyse ASC";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * List all waiting validation Materiau's Analyses from a Dossier (type : Dossier Analyse, 2).
	 * Version 1.
	 * 
	 * @param {int} $id_dossier - Id of the Dossier.
	 * @return {[Object]} List of all analysis of a specifi file, wich aren't validate yet.
	 */
	function ListeAnalyseDossierAttenteValidationMateriauV1($id_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *, ref_client_chantier as ref_affaire, ref_echantillon as ref_client_echantillon, '' as aspect_materiau_echantillon
				from echantillon, presta, detail_type_presta, type_presta, qualification, mission, analyse_materiau_v1, client, dossier, chantier
				where `echantillon`.`dossier_echantillon` = " . $id_dossier . "

				and dossier_echantillon = id_dossier
				and echantillon_analyse_materiau_v1 = `echantillon`.`id_echantillon`
				and type_dossier = type_dossier_analyse_materiau_v1

				and pose_presta_echantillon = id_presta
				and detail_type_presta = id_detail_type_presta
				and type_presta_detail_type_presta = id_type_presta
				and qualification_type_presta = id_qualification 

				and mission_presta = id_mission
				and client_mission = id_client 
				and chantier_mission = id_chantier
				
				and validation_analyse_materiau_v1 = 0
				
				order by `echantillon`.mois_ref_echantillon ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 * @return {Object}.
	 */
	function getAnalyseDossierAnalyseValideMateriauV1($id_analyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select 
					ref_echantillon_analyse AS ref_echantillon, couche_echantillon_analyse AS couche_echantillon, ref_client_echantillon_analyse AS ref_client_echantillon, localisation_echantillon_analyse AS localisation_echantillon, aspect_materiau_echantillon_analyse as aspect_materiau_echantillon,
					nom_client_analyse AS nom_client, adresse_client_analyse AS adresse_client, cp_client_analyse AS cp_client, ville_client_analyse AS ville_client,
					ref_qualification_analyse as ref_qualification, nom_qualification_analyse as nom_qualification,
					chantier_analyse_dossier as ref_affaire,
					analyse_materiau_v1.*, dossier.*
				from analyse_materiau_v1
				
				
				JOIN echantillon_analyse ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				
				LEFT JOIN analyse_externe_prestation_objectif ON objectif_echantillon_analyse = id_analyse_externe_prestation_objectif
				JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
						
				JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
				JOIN analyse_externe_polluant ON id_analyse_externe_polluant = polluant_analyse_externe_prestation
				JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse
				
				JOIN client_analyse ON client_dossier = id_client_analyse
				
				where id_analyse_materiau_v1 = " . $id_analyse . "
				and validation_analyse_materiau_v1 = 1";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}
	/**
	 * 
	 * @return {Object}.
	 */
	function getAnalyseDossierValideMateriauV1($id_analyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *, ref_client_chantier as ref_affaire, ref_echantillon as ref_client_echantillon, '' as aspect_materiau_echantillon

				from echantillon, presta, detail_type_presta, type_presta, qualification, mission, analyse_materiau_v1, client, dossier, chantier

				where id_analyse_materiau_v1 = " . $id_analyse . "

				and dossier_echantillon = id_dossier
				and echantillon_analyse_materiau_v1 = `echantillon`.`id_echantillon`
				and type_dossier = type_dossier_analyse_materiau_v1

				and pose_presta_echantillon = id_presta
				and detail_type_presta = id_detail_type_presta
				and type_presta_detail_type_presta = id_type_presta
				and qualification_type_presta = id_qualification 

				and mission_presta = id_mission
				and client_mission = id_client 
				and chantier_mission = id_chantier

				and validation_analyse_materiau_v1 = 1";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}
	/**
	 * List all waiting validation or already validate Materiau's Analyses from a Dossier (type : Dossier Analyse, 2).
	 * Version 1.
	 * 
	 * @param {int} $id_dossier - Id of the Dossier.
	 * @return {[Object]} List of all analysis of a specifi file, wich aren't validate yet.
	 */
	function listeRapportMateriauExterneV1DossierAnalyse($id_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
		FROM dossier
		JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
		JOIN analyse_materiau_v1 ON 
			(echantillon_analyse_materiau_v1 =  id_echantillon_analyse 
			AND type_dossier = type_dossier_analyse_materiau_v1)
		JOIN (
			SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, MAX(id_analyse_materiau_v1) as current_rev
			  FROM analyse_materiau_v1
			 WHERE (validation_analyse_materiau_v1 = 1 OR validation_analyse_materiau_v1 = 0)
			 GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
		) last_validated ON id_analyse_materiau_v1 = current_rev
		
		LEFT JOIN analyse_externe_prestation_objectif ON objectif_echantillon_analyse = id_analyse_externe_prestation_objectif
		JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
				
		JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
		JOIN analyse_externe_polluant ON id_analyse_externe_polluant = polluant_analyse_externe_prestation
		JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse
				
		JOIN client_analyse ON client_dossier = id_client_analyse
		
		WHERE id_dossier = {$id_dossier}
		ORDER BY `echantillon_analyse`.mois_ref_echantillon_analyse ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * List all Dossier validate Materiau's Analyses from a Dossier (type : Dossier Analyse, 2).
	 * Version 1.
	 * 
	 * @param {int} $id_dossier - Id of the Dossier.
	 * @return {[Object]} List of all analysis of a specifi file, wich aren't validate yet.
	 */
	function listeRapportMateriauExterneV1DossierAnalyseValide($id_dossier) {
		$db = JFactory::getDBOGBMNet();

		$query = "SELECT *
				FROM echantillon_analyse, type_prelevement, qualification_analyse, analyse_materiau_v1, client_analyse, dossier
				WHERE `echantillon_analyse`.`dossier_echantillon_analyse` = {$id_dossier}
				AND echantillon_analyse_materiau_v1 = `echantillon_analyse`.`id_echantillon_analyse`
				AND validation_analyse_materiau_v1 = 1
				AND detail_echantillon_analyse = id_type_prelevement
				AND qualification_analyse_type_prelevement = id_qualification_analyse
				AND dossier_echantillon_analyse = id_dossier
				AND type_dossier = type_dossier_analyse_materiau_v1
				AND `dossier`.`client_dossier` = client_analyse.id_client_analyse
				ORDER BY `echantillon_analyse`.mois_ref_echantillon_analyse DESC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function listeRapportMateriauExterneV1DossierLastAnalyseValide($id_dossier) {
		$db = JFactory::getDBOGBMNet();

		$query = "SELECT *, id_echantillon_analyse, id_analyse_materiau_v1
		FROM dossier
		JOIN echantillon_analyse ON dossier_echantillon_analyse = id_dossier
		JOIN analyse_materiau_v1 ON 
			(echantillon_analyse_materiau_v1 =  id_echantillon_analyse 
			AND type_dossier = type_dossier_analyse_materiau_v1)
		JOIN (
			SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, MAX(id_analyse_materiau_v1) as current_rev
			  FROM analyse_materiau_v1
			 WHERE validation_analyse_materiau_v1 = 1
			 GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
		) last_validated ON id_analyse_materiau_v1 = current_rev
		
		LEFT JOIN analyse_externe_prestation_objectif ON objectif_echantillon_analyse = id_analyse_externe_prestation_objectif
		JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
		
		JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
		JOIN analyse_externe_polluant ON id_analyse_externe_polluant = polluant_analyse_externe_prestation
		JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse
				
		-- JOIN type_prelevement ON detail_echantillon_analyse = id_type_prelevement
		-- JOIN qualification_analyse ON qualification_analyse_type_prelevement = id_qualification_analyse
		
		JOIN client_analyse ON client_dossier = id_client_analyse
		
		WHERE validation_analyse_materiau_v1 = 1
		AND id_dossier = {$id_dossier}

		ORDER BY `echantillon_analyse`.mois_ref_echantillon_analyse ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}


	/**
	 * List all waiting validation Materiau's Analyses from a Dossier (type : Dossier Analyse, 2).
	 * Version 1.
	 * 
	 * @param {int} $id_dossier - Id of the Dossier.
	 * @return {[Object]} List of all analysis of a specifi file, wich aren't validate yet.
	 */
	function ListeAnalyseDossierAnalyseValidationMateriauV1($id_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from echantillon_analyse, type_prelevement, qualification_analyse, analyse_materiau_v1, client_analyse, dossier
				where `echantillon_analyse`.`dossier_echantillon_analyse` = " . $id_dossier . "
				and echantillon_analyse_materiau_v1 = `echantillon_analyse`.`id_echantillon_analyse`
				and validation_analyse_materiau_v1 = 1 
				and detail_echantillon_analyse = id_type_prelevement
				and qualification_analyse_type_prelevement = id_qualification_analyse
				and dossier_echantillon_analyse = id_dossier
				and type_dossier = type_dossier_analyse_materiau_v1
				and `dossier`.`client_dossier` = client_analyse.id_client_analyse
				order by `echantillon_analyse`.mois_ref_echantillon_analyse ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	/**
	 * Get the analyse_materiau_v1 which id passed in param.
	 * 
	 * @param {int} $id_analyse
	 * @return {[Object]}
	 */
	function AfficheAnalyseMateriauV1($id_analyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from analyse_materiau_v1
				where id_analyse_materiau_v1 = " . $id_analyse;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 * 
	 * @param {int} $echantillon - Id of an Echantillon.
	 * @param {int} $type_dossier - Type of dossier :
	 * 		- 1 : Dossier Interne
	 * 		- 2 : Dossier Externe
	 * @return {[Object]}
	 */
	function ListeRevisionAnalyseMateriauV1($echantillon, $type_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT id_analyse_materiau_v1, revision_analyse_materiau_v1, description_revision_analyse_materiau_v1, date_validation_analyse_materiau_v1, validation_analyse_materiau_v1, valideur_analyse_materiau_v1
				FROM analyse_materiau_v1
				WHERE echantillon_analyse_materiau_v1 = {$echantillon}
				AND type_dossier_analyse_materiau_v1 = {$type_dossier}
				ORDER BY revision_analyse_materiau_v1 ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * Get the Analyse relatives Couche.
	 * 
	 * @param {int} $id_analyse
	 * @return {[Object]}
	 */
	function ListeAnalyseMateriauV1Couche($id_analyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
			FROM 
				analyse_materiau_v1_couche
			WHERE 
				analyse_materiau_v1_couche = {$id_analyse}
			ORDER BY 
				id_analyse_materiau_v1_couche";
		// echo $query;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * Get the analyse molp couche relative to an aanalyse.
	 * 
	 * @param {int} $id_analyse
	 * @return {[Object]}
	 */
	function ListeAnalyseMateriauV1MolpCouche($id_analyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
			from analyse_materiau_v1_molp_couche
			where analyse_materiau_v1_molp_couche = " . $id_analyse;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * Get the id of the analyse_materiau_v1 relatives to a Couche.
	 * 
	 * @param {int} $id_couche
	 * @return {Object}
	 */
	function getCoucheAnalyse_materiau_v1($id_couche) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select analyse_materiau_v1_couche.analyse_materiau_v1_couche
			from analyse_materiau_v1_couche
			where id_analyse_materiau_v1_couche = " . $id_couche;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}
	/**
	 * Get the id of the analyse_materiau_v1 relatives to a Couche.
	 * 
	 * @param {int} $id_couche
	 * @return {Object}
	 */
	function getCouche($id_couche) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
			from analyse_materiau_v1_couche
			where id_analyse_materiau_v1_couche = " . $id_couche;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}
	/**
	 * Set the echanillon to validation waiting, by updatng the validation flag.
	 * 		- 0 : validation waiting
	 * 		- 1 : validation done
	 * 		- 2 : analysis uncomplete yet.
	 * 
	 * @param {int} $id_analyse_materiau_v1.
	 */
	function echantillonWaitingValidation($id_analyse_materiau_v1) {
		$analyse = new stdClass();

		$analyse->id_analyse_materiau_v1 = $id_analyse_materiau_v1;
		$analyse->validation_analyse_materiau_v1 = 0;

		$db = JFactory::getDBOGBMNet();
		return $db->updateObject('analyse_materiau_v1', $analyse, 'id_analyse_materiau_v1');
	}
	/**
	 * Get the Portoir analyse materiau, for the Element Materiel corresponding.
	 * 
	 * @param {int} $id_element_materiel
	 * @return {Portoir}
	 */
	function getPortoirAnalyseMateriau($id_element_materiel) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1_portoir
					WHERE element_materiel_analyse_materiau_v1_portoir = {$id_element_materiel}
					AND disponible_analyse_materiau_v1_portoir = 1";
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}
	/**
	 * Create a new Portoire Analyse.
	 */
	function addPortoirAnalyseMateriau($element_materiel_analyse_materiau_v1_portoir, $ref_portoir_analyse_materiau_v1_portoir, $positions_analyse_materiau_v1_portoir, $colonnes_analyse_materiau_v1_portoir, $lignes_analyse_materiau_v1_portoir) {

		$data = new stdClass();
		$data->id_analyse_materiau_v1_portoir = null;
		$data->element_materiel_analyse_materiau_v1_portoir = $element_materiel_analyse_materiau_v1_portoir;
		$data->ref_portoir_analyse_materiau_v1_portoir = $ref_portoir_analyse_materiau_v1_portoir;
		$data->positions_analyse_materiau_v1_portoir = $positions_analyse_materiau_v1_portoir;
		$data->colonnes_analyse_materiau_v1_portoir = $colonnes_analyse_materiau_v1_portoir;
		$data->lignes_analyse_materiau_v1_portoir = $lignes_analyse_materiau_v1_portoir;
		$data->couleur_analyse_materiau_v1_portoir = "";
		$data->disponible_analyse_materiau_v1_portoir = 1;
		$data->occupation_analyse_materiau_v1_portoir = "[]";

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('analyse_materiau_v1_portoir', $data, 'id_analyse_materiau_v1_portoir');
		return $db->insertid();
	}
	/**
	 * 
	 */
	function updatePortoirAnalyseMateriau($id_analyse_materiau_v1_portoir, $couleur_analyse_materiau_v1_portoir, $occupation_analyse_materiau_v1_portoir) {
		$portoir = new stdClass();

		$portoir->id_analyse_materiau_v1_portoir = $id_analyse_materiau_v1_portoir;
		$portoir->couleur_analyse_materiau_v1_portoir = $couleur_analyse_materiau_v1_portoir;
		$portoir->occupation_analyse_materiau_v1_portoir = $occupation_analyse_materiau_v1_portoir;

		$db = JFactory::getDBOGBMNet();
		return $db->updateObject('analyse_materiau_v1_portoir', $portoir, 'id_analyse_materiau_v1_portoir');
	}

	function getPortoirAnalyseMetaWaiting($fieldsToSelect) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT ref_portoir_analyse_materiau_v1_portoir, couleur_analyse_materiau_v1_portoir, count_prep, id_analyse_materiau_v1_portoir, MAX(meta_analyse_materiau_v1_couche) AS meta_status, re_depot.hotte_depot_analyse_materiau_v1_couche_meta_depot AS re_depot_hotte, statut_retour_analyse_analyse_materiau_v1_couche
					FROM analyse_materiau_v1_portoir
						JOIN `analyse_materiau_v1_couche_meta_prepa` ON id_analyse_materiau_v1_portoir = analyse_materiau_v1_couche_meta_prepa.portoir_analyse_materiau_v1_couche_meta_prepa
						JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
						JOIN (
							SELECT count(id_analyse_materiau_v1_couche_meta_prepa) AS count_prep, portoir_analyse_materiau_v1_couche_meta_prepa
								FROM analyse_materiau_v1_couche_meta_prepa
								WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 1
								GROUP BY portoir_analyse_materiau_v1_couche_meta_prepa
						) AS count_prep_portoir ON count_prep_portoir.portoir_analyse_materiau_v1_couche_meta_prepa = id_analyse_materiau_v1_portoir
						LEFT JOIN (
                    		SELECT id_analyse_materiau_v1_couche, hotte_depot_analyse_materiau_v1_couche_meta_depot
                    		FROM analyse_materiau_v1_couche_meta_depot
                    		JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
							WHERE meta_analyse_materiau_v1_couche = 4
                    		GROUP BY id_analyse_materiau_v1_couche
                    	) AS re_depot ON re_depot.id_analyse_materiau_v1_couche = analyse_materiau_v1_couche.id_analyse_materiau_v1_couche
					WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 1
					AND is_depot_analyse_materiau_v1_couche_meta_prepa = 0
					GROUP BY analyse_materiau_v1_couche_meta_prepa.portoir_analyse_materiau_v1_couche_meta_prepa";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function getPortoirRangementAnalyse($fieldsToSelect) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT {$fieldsToSelect}
					FROM analyse_materiau_v1_portoir
					JOIN `analyse_materiau_v1_couche_meta_depot` ON id_analyse_materiau_v1_portoir = analyse_materiau_v1_couche_meta_depot.portoir_analyse_materiau_v1_couche_meta_depot
					JOIN `analyse_materiau_v1_couche` ON id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche
        			JOIN (
        				SELECT sum(nb_grilles_analyse_materiau_v1_couche_meta_depot) AS nbr_grilles_portoir, portoir_analyse_materiau_v1_couche_meta_depot 
							FROM analyse_materiau_v1_couche_meta_depot
							GROUP BY portoir_analyse_materiau_v1_couche_meta_depot   
        				) AS  sum_grilles_portoir ON sum_grilles_portoir.portoir_analyse_materiau_v1_couche_meta_depot = id_analyse_materiau_v1_portoir
					WHERE is_active_analyse_materiau_v1_couche_meta_depot = 1
					AND is_archived_materiau_v1_couche_meta_depot = 0
					GROUP BY analyse_materiau_v1_couche_meta_depot.portoir_analyse_materiau_v1_couche_meta_depot";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function getCouchesPortoiranalyse($id_portoir) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT analyse_materiau_v1_couche_meta_prepa.*, analyse_materiau_v1_couche.*, analyse_materiau_v1.*, analyse_materiau_v1_exam_prea.*, ref_echantillon_analyse AS ref_echantillon
		 FROM analyse_materiau_v1_couche_meta_prepa
					JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche
					JOIN analyse_materiau_v1 ON (analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1 AND type_dossier_analyse_materiau_v1 = 2)
					JOIN analyse_materiau_v1_exam_prea ON analyse_materiau_v1_exam_prea.analyse_materiau_v1_exam_prea = analyse_materiau_v1.id_analyse_materiau_v1
					JOIN echantillon_analyse ON analyse_materiau_v1.echantillon_analyse_materiau_v1 = id_echantillon_analyse
				WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 1
				AND portoir_analyse_materiau_v1_couche_meta_prepa = {$id_portoir}
				
				UNION
				
				SELECT analyse_materiau_v1_couche_meta_prepa.*, analyse_materiau_v1_couche.*, analyse_materiau_v1.*, analyse_materiau_v1_exam_prea.*, ref_echantillon
				FROM analyse_materiau_v1_couche_meta_prepa
					JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche
					JOIN analyse_materiau_v1 ON (analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1 AND type_dossier_analyse_materiau_v1 = 1)
					JOIN analyse_materiau_v1_exam_prea ON analyse_materiau_v1_exam_prea.analyse_materiau_v1_exam_prea = analyse_materiau_v1.id_analyse_materiau_v1
					JOIN echantillon ON analyse_materiau_v1.echantillon_analyse_materiau_v1 = id_echantillon
				WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 1
				AND portoir_analyse_materiau_v1_couche_meta_prepa = {$id_portoir}

				ORDER BY date_analyse_materiau_v1_couche_meta_prepa ASC ";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function getDepotPortoiranalyse($id_portoir) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT analyse_materiau_v1_couche_meta_depot.*, analyse_materiau_v1_couche_meta_prepa.*, analyse_materiau_v1_couche.*, analyse_materiau_v1.*, analyse_materiau_v1_exam_prea.*, ref_echantillon_analyse AS ref_echantillon, ref_consommable, prepa_last_disabled_prepa, prepa_last_disabled_depot
		 FROM analyse_materiau_v1_couche_meta_depot
					JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche
					JOIN analyse_materiau_v1 ON (analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1 AND type_dossier_analyse_materiau_v1 = 2)
					JOIN analyse_materiau_v1_exam_prea ON analyse_materiau_v1_exam_prea.analyse_materiau_v1_exam_prea = analyse_materiau_v1.id_analyse_materiau_v1
					JOIN analyse_materiau_v1_couche_meta_prepa ON analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_prepa.id_analyse_materiau_v1_couche_meta_prepa
					JOIN echantillon_analyse ON analyse_materiau_v1.echantillon_analyse_materiau_v1 = id_echantillon_analyse
					LEFT JOIN consommable ON boite_archive_analyse_materiau_v1_couche_meta_depot = id_consommable
					LEFT JOIN (
						SELECT MAX(id_analyse_materiau_v1_couche_meta_prepa) AS prepa_last_disabled_prepa, MAX(num_prepa_couche_analyse_materiau_v1_couche_meta_prepa), analyse_materiau_v1_couche 
						FROM analyse_materiau_v1_couche_meta_prepa
						WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 0
						GROUP BY analyse_materiau_v1_couche
					) as last_disabled_prepa ON id_analyse_materiau_v1_couche = last_disabled_prepa.analyse_materiau_v1_couche
					LEFT JOIN (
						SELECT MAX(analyse_materiau_v1_couche_meta_prepa) AS prepa_last_disabled_depot, MAX(num_depot_preparation_analyse_materiau_v1_couche_meta_depot), analyse_materiau_v1_couche
						FROM analyse_materiau_v1_couche_meta_depot
						WHERE is_active_analyse_materiau_v1_couche_meta_depot = 0
						GROUP BY analyse_materiau_v1_couche
					) as last_disabled_depot ON id_analyse_materiau_v1_couche = last_disabled_depot.analyse_materiau_v1_couche

				WHERE portoir_analyse_materiau_v1_couche_meta_depot = {$id_portoir}
				AND is_active_analyse_materiau_v1_couche_meta_depot = 1
				
				UNION
				
				SELECT analyse_materiau_v1_couche_meta_depot.*, analyse_materiau_v1_couche_meta_prepa.*, analyse_materiau_v1_couche.*, analyse_materiau_v1.*, analyse_materiau_v1_exam_prea.*, ref_echantillon, ref_consommable, prepa_last_disabled_prepa, prepa_last_disabled_depot
				FROM analyse_materiau_v1_couche_meta_depot
					JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche
					JOIN analyse_materiau_v1 ON (analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1 AND type_dossier_analyse_materiau_v1 = 1)
					JOIN analyse_materiau_v1_exam_prea ON analyse_materiau_v1_exam_prea.analyse_materiau_v1_exam_prea = analyse_materiau_v1.id_analyse_materiau_v1
					JOIN analyse_materiau_v1_couche_meta_prepa ON analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_prepa.id_analyse_materiau_v1_couche_meta_prepa
					JOIN echantillon ON analyse_materiau_v1.echantillon_analyse_materiau_v1 = id_echantillon
					LEFT JOIN consommable ON boite_archive_analyse_materiau_v1_couche_meta_depot = id_consommable
					LEFT JOIN (
						SELECT analyse_materiau_v1_couche_meta_prepa AS prepa_last_disabled_prepa, MAX(num_prepa_couche_analyse_materiau_v1_couche_meta_prepa), analyse_materiau_v1_couche 
						FROM analyse_materiau_v1_couche_meta_prepa
						WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 0
					) as last_disabled_prepa ON id_analyse_materiau_v1_couche = last_disabled_prepa.analyse_materiau_v1_couche
					LEFT JOIN (
						SELECT analyse_materiau_v1_couche_meta_prepa AS prepa_last_disabled_depot, MAX(num_depot_preparation_analyse_materiau_v1_couche_meta_depot), analyse_materiau_v1_couche
						FROM analyse_materiau_v1_couche_meta_depot
						WHERE is_active_analyse_materiau_v1_couche_meta_depot = 0
					) as last_disabled_depot ON id_analyse_materiau_v1_couche = last_disabled_depot.analyse_materiau_v1_couche
					
				WHERE portoir_analyse_materiau_v1_couche_meta_depot = {$id_portoir}
				AND is_active_analyse_materiau_v1_couche_meta_depot = 1

				ORDER BY date_analyse_materiau_v1_couche_meta_prepa ASC ";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function deposePrepa($id_analyse_materiau_v1_couche_meta_prepa, $value) {
		$prepa = new stdClass();

		$prepa->id_analyse_materiau_v1_couche_meta_prepa = $id_analyse_materiau_v1_couche_meta_prepa;
		$prepa->is_depot_analyse_materiau_v1_couche_meta_prepa = $value;

		$db = JFactory::getDBOGBMNet();
		return $db->updateObject('analyse_materiau_v1_couche_meta_prepa', $prepa, 'id_analyse_materiau_v1_couche_meta_prepa');
	}

	/**
	 * 
	 */
	function updateNbGrillesPrepaMeta($id_analyse_materiau_v1_couche_meta_prepa, $nb_grilles_analyse_materiau_v1_couche_meta_prepa) {
		$prepa = new stdClass();
		$prepa->id_analyse_materiau_v1_couche_meta_prepa = $id_analyse_materiau_v1_couche_meta_prepa;
		$prepa->nb_grilles_analyse_materiau_v1_couche_meta_prepa = $nb_grilles_analyse_materiau_v1_couche_meta_prepa;

		$db = JFactory::getDBOGBMNet();
		return $db->updateObject('analyse_materiau_v1_couche_meta_prepa', $prepa, 'id_analyse_materiau_v1_couche_meta_prepa');
	}
	/**
	 * 
	 */
	function disablePortoirAnalyseMeta($id_analyse_materiau_v1_portoir, $disponible_analyse_materiau_v1_portoir) {

		$portoir = new stdClass();
		$portoir->id_analyse_materiau_v1_portoir = $id_analyse_materiau_v1_portoir;
		// $portoir->disponible_analyse_materiau_v1_portoir = $disponible_analyse_materiau_v1_portoir;
		$portoir->disponible_analyse_materiau_v1_portoir = false;

		$db = JFactory::getDBOGBMNet();
		$db->updateObject('analyse_materiau_v1_portoir', $portoir, 'id_analyse_materiau_v1_portoir');
		return $db->updateObject('analyse_materiau_v1_portoir', $portoir, 'id_analyse_materiau_v1_portoir');
	}

	function disabledPrepaPortoire($id_portoire) {
		$db = JFactory::getDBOGBMNet();
		$query = "UPDATE `analyse_materiau_v1_couche_meta_prepa`
		SET `is_active_analyse_materiau_v1_couche_meta_prepa` = 0
		WHERE `portoir_analyse_materiau_v1_couche_meta_prepa` = {$id_portoire}";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function disabledDepotPortoire($id_portoire) {
		$db = JFactory::getDBOGBMNet();
		$query = "UPDATE `analyse_materiau_v1_couche_meta_depot`
		SET `is_active_analyse_materiau_v1_couche_meta_depot` = 0
		WHERE `portoir_analyse_materiau_v1_couche_meta_depot` = {$id_portoire}";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheAnalyseEchantillonMATERIAUV1($echantillon, $typeDossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
                FROM analyse_materiau_v1
                WHERE echantillon_analyse_materiau_v1 = {$echantillon}
                AND type_dossier_analyse_materiau_v1 = {$typeDossier}
                AND validation_analyse_materiau_v1 = 1
                ORDER BY revision_analyse_materiau_v1 DESC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeRapportMateriauMultiV1Dossier($dossier_rapport_materiau_multi) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from analyse_materiau_v1_multi
				where dossier_analyse_materiau_v1_multi = " . $dossier_rapport_materiau_multi . "
				order by num_ref_analyse_materiau_v1_multi desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function NouveauAnalyseMateriauMultiV1($dossier_analyse_materiau_v1_multi, $num_ref_analyse_materiau_v1_multi, $ref_analyse_materiau_v1_multi, $revision_analyse_materiau_v1_multi, $description_revision_analyse_materiau_v1_multi, $cofrac_analyse_materiau_v1_multi, $validation_analyse_materiau_v1_multi, $valideur_analyse_materiau_v1_multi) {
		$data = new stdClass();
		$data->id_analyse_materiau_v1_multi = null;
		$data->dossier_analyse_materiau_v1_multi = $dossier_analyse_materiau_v1_multi;
		$data->num_ref_analyse_materiau_v1_multi = $num_ref_analyse_materiau_v1_multi;
		$data->ref_analyse_materiau_v1_multi = $ref_analyse_materiau_v1_multi;
		$data->date_analyse_materiau_v1_multi = date("Y-m-d H:i:s");
		$data->revision_analyse_materiau_v1_multi = $revision_analyse_materiau_v1_multi;
		$data->description_revision_analyse_materiau_v1_multi = $description_revision_analyse_materiau_v1_multi;
		$data->cofrac_analyse_materiau_v1_multi = $cofrac_analyse_materiau_v1_multi;
		$data->validation_analyse_materiau_v1_multi = $validation_analyse_materiau_v1_multi;
		$data->valideur_analyse_materiau_v1_multi = $valideur_analyse_materiau_v1_multi;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('analyse_materiau_v1_multi', $data, 'id_analyse_materiau_v1_multi');
		return $db->insertid();
	}
	/**
	 * 
	 * @return {Object}.
	 */
	function getClientAnalyseDossier($id_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from client_analyse, dossier
				where id_dossier = " . $id_dossier . "
				and `dossier`.`client_dossier` = client_analyse.id_client_analyse";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}

	/**
	 * 
	 */
	function listeMateriauxAnalyseV1() {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT nom_client_analyse AS nom_client, ref_affaire_analyse_dossier AS nom_chantier, ref_echantillon_analyse AS ref_echantillon,
			 analyse_materiau_v1.*, dossier.*, revision_max
		FROM analyse_materiau_v1
        JOIN echantillon_analyse ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
        JOIN dossier ON (dossier_echantillon_analyse = id_dossier AND type_dossier = type_dossier_analyse_materiau_v1)
        JOIN client_analyse ON client_dossier = id_client_analyse
        LEFT JOIN chantier ON chantier_dossier = id_chantier
        JOIN (
            SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, MAX(revision_analyse_materiau_v1) as revision_max
            FROM analyse_materiau_v1
            GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
        ) revision ON revision.echantillon_analyse_materiau_v1 = analyse_materiau_v1.echantillon_analyse_materiau_v1 AND revision.type_dossier_analyse_materiau_v1 = analyse_materiau_v1.type_dossier_analyse_materiau_v1
		UNION
		SELECT nom_client, nom_chantier, ref_echantillon,
			analyse_materiau_v1.*, dossier.*, revision_max
		FROM analyse_materiau_v1
        JOIN echantillon ON echantillon_analyse_materiau_v1 = id_echantillon
        JOIN dossier ON (dossier_echantillon = id_dossier AND type_dossier = type_dossier_analyse_materiau_v1)
        JOIN client ON client_dossier = id_client
        JOIN chantier ON chantier_dossier = id_chantier
        JOIN (
            SELECT echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1, MAX(revision_analyse_materiau_v1) as revision_max
            FROM analyse_materiau_v1
            GROUP BY echantillon_analyse_materiau_v1, type_dossier_analyse_materiau_v1
        ) revision ON revision.echantillon_analyse_materiau_v1 = analyse_materiau_v1.echantillon_analyse_materiau_v1 AND revision.type_dossier_analyse_materiau_v1 = analyse_materiau_v1.type_dossier_analyse_materiau_v1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 */
	function getMateriauxAnalyseV1($idAnalyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1
		JOIN echantillon_analyse ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
		JOIN dossier ON dossier_echantillon_analyse = id_dossier
		JOIN client_analyse ON client_dossier = id_client_analyse
		JOIN chantier ON chantier_dossier = id_chantier
		WHERE id_analyse_materiau_v1 = {$idAnalyse}";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}
	/**
	 * 
	 */
	function listeTemoinsMatV1($date_debut, $date_fin) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
		FROM echantillon_analyse
		JOIN dossier ON dossier_echantillon_analyse = id_dossier
		JOIN type_prelevement ON id_type_prelevement = detail_echantillon_analyse
		JOIN qualification_analyse ON id_qualification_analyse = qualification_analyse_type_prelevement
		LEFT JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
		LEFT JOIN analyse_materiau_v1_exam_prea ON analyse_materiau_v1_exam_prea = id_analyse_materiau_v1
		LEFT JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
		LEFT JOIN analyse_materiau_v1_molp_couche ON analyse_materiau_v1_molp_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
		LEFT JOIN (
			SELECT GROUP_CONCAT(conclusion_analyse_materiau_v1_couche_meta_analyse SEPARATOR ';') AS resultat_meta_resultat, analyse_materiau_v1_couche 
			FROM `analyse_materiau_v1_couche_meta_analyse`
			GROUP BY analyse_materiau_v1_couche
		) AS meta_resultat ON meta_resultat.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
	   	WHERE id_type_prelevement = 37
		AND date_analyse_materiau_v1_exam_prea BETWEEN '{$date_debut}' AND '{$date_fin}'
	   	ORDER BY id_echantillon_analyse ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	function listeMatTemoinsMatV1() {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT echantillon_analyse.ref_echantillon_analyse, dossier.ref_dossier, nom_chantier, nom_client_analyse, data_couche_analyse_materiau_v1_couche, temoin.operateur_analyse_materiau_v1_exam_prea, temoin.date_analyse_materiau_v1_exam_prea, temoin.hotte_analyse_materiau_v1_exam_prea, temoin.ref_echantillon_analyse as ref_temoin, temoin.ref_dossier as temoin_dossier, 'META' as type_analyse, temoin.id_echantillon_analyse as id_temoin, resultat_meta_resultat
			FROM analyse_materiau_v1_couche_meta_prepa
        	JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
        	JOIN analyse_materiau_v1_couche_meta_depot ON analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa = id_analyse_materiau_v1_couche_meta_prepa
        	JOIN analyse_materiau_v1 ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
        	LEFT JOIN (
				SELECT GROUP_CONCAT(conclusion_analyse_materiau_v1_couche_meta_analyse SEPARATOR ';') AS resultat_meta_resultat, analyse_materiau_v1_couche_meta_depot  
				FROM `analyse_materiau_v1_couche_meta_analyse`
				GROUP BY analyse_materiau_v1_couche_meta_depot 
			) AS meta_resultat ON meta_resultat.analyse_materiau_v1_couche_meta_depot  = id_analyse_materiau_v1_couche_meta_depot 
        	JOIN echantillon_analyse ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
        	JOIN dossier ON dossier_echantillon_analyse = id_dossier
        	JOIN type_prelevement ON id_type_prelevement = detail_echantillon_analyse
        	JOIN qualification_analyse ON id_qualification_analyse = qualification_analyse_type_prelevement
			JOIN client_analyse ON client_dossier = id_client_analyse
			JOIN chantier ON chantier_dossier = id_chantier
        	JOIN (
        		SELECT *
				FROM echantillon_analyse
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN type_prelevement ON id_type_prelevement = detail_echantillon_analyse
				JOIN qualification_analyse ON id_qualification_analyse = qualification_analyse_type_prelevement
				LEFT JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
				LEFT JOIN analyse_materiau_v1_exam_prea ON analyse_materiau_v1_exam_prea = id_analyse_materiau_v1
	   			WHERE id_type_prelevement = 37
        	) AS temoin ON temoin.operateur_analyse_materiau_v1_exam_prea = analyse_materiau_v1_couche_meta_prepa.operateur_analyse_materiau_v1_couche_meta_prepa
			AND temoin.hotte_analyse_materiau_v1_exam_prea = hotte_materiel_analyse_materiau_v1_couche_meta_prepa
			AND temoin.date_analyse_materiau_v1_exam_prea = CAST(date_analyse_materiau_v1_couche_meta_prepa AS DATE)
			WHERE type_prelevement.id_type_prelevement != 37
		UNION
		SELECT echantillon_analyse.ref_echantillon_analyse, dossier.ref_dossier, nom_chantier, nom_client_analyse, data_couche_analyse_materiau_v1_couche, temoin.operateur_analyse_materiau_v1_exam_prea, temoin.date_analyse_materiau_v1_exam_prea, temoin.hotte_analyse_materiau_v1_exam_prea, temoin.ref_echantillon_analyse as ref_temoin, temoin.ref_dossier as temoin_dossier, 'MOLP' as type_analyse, temoin.id_echantillon_analyse as id_temoin, resultat_meta_resultat
			FROM analyse_materiau_v1_molp_couche
        	JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_molp_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
        	JOIN analyse_materiau_v1 ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
			LEFT JOIN (
				SELECT GROUP_CONCAT(conclusion_analyse_materiau_v1_couche_meta_analyse SEPARATOR ';') AS resultat_meta_resultat, analyse_materiau_v1_couche 
				FROM `analyse_materiau_v1_couche_meta_analyse`
				GROUP BY analyse_materiau_v1_couche
			) AS meta_resultat ON meta_resultat.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
        	JOIN echantillon_analyse ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
        	JOIN dossier ON dossier_echantillon_analyse = id_dossier
        	JOIN type_prelevement ON id_type_prelevement = detail_echantillon_analyse
        	JOIN qualification_analyse ON id_qualification_analyse = qualification_analyse_type_prelevement
			JOIN client_analyse ON client_dossier = id_client_analyse
			JOIN chantier ON chantier_dossier = id_chantier
        	JOIN (
        		SELECT *
				FROM echantillon_analyse
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN type_prelevement ON id_type_prelevement = detail_echantillon_analyse
				JOIN qualification_analyse ON id_qualification_analyse = qualification_analyse_type_prelevement
				LEFT JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
				LEFT JOIN analyse_materiau_v1_exam_prea ON analyse_materiau_v1_exam_prea = id_analyse_materiau_v1
	   			WHERE id_type_prelevement = 37
        	) AS temoin ON temoin.operateur_analyse_materiau_v1_exam_prea = analyse_materiau_v1_molp_couche.operateur_analyse_materiau_v1_molp_couche
			AND temoin.hotte_analyse_materiau_v1_exam_prea = hotte_analyse_materiau_v1_molp_couche
			AND temoin.date_analyse_materiau_v1_exam_prea = CAST(date_analyse_materiau_v1_molp_couche AS DATE)
			WHERE type_prelevement.id_type_prelevement != 37";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 */
	function listeMatV1() {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT *
		FROM echantillon_analyse
		JOIN dossier ON dossier_echantillon_analyse = id_dossier
		JOIN type_prelevement ON id_type_prelevement = detail_echantillon_analyse
		JOIN qualification_analyse ON id_qualification_analyse = qualification_analyse_type_prelevement
		JOIN client_analyse ON client_dossier = id_client_analyse
		JOIN chantier ON chantier_dossier = id_chantier
	   	ORDER BY id_echantillon_analyse ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 */
	function getEchantillonAnalyseMatV1($idAnalyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1
        JOIN analyse_materiau_v1_couche ON id_analyse_materiau_v1 = analyse_materiau_v1_couche.analyse_materiau_v1_couche
        JOIN analyse_materiau_v1_exam_prea ON id_analyse_materiau_v1 = analyse_materiau_v1_exam_prea.analyse_materiau_v1_exam_prea
        LEFT JOIN (
            SELECT * FROM analyse_materiau_v1_couche_meta_prepa
            -- WHERE is_active_analyse_materiau_v1_couche_meta_prepa = 1
        ) AS prepa ON id_analyse_materiau_v1_couche = prepa.analyse_materiau_v1_couche
        LEFT JOIN (
            SELECT * FROM analyse_materiau_v1_couche_meta_depot
            -- WHERE is_active_analyse_materiau_v1_couche_meta_depot = 1
        ) AS depot ON id_analyse_materiau_v1_couche = depot.analyse_materiau_v1_couche
            AND prepa.id_analyse_materiau_v1_couche_meta_prepa = depot.analyse_materiau_v1_couche_meta_prepa
        LEFT JOIN analyse_materiau_v1_couche_meta_analyse ON id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_analyse.analyse_materiau_v1_couche 
            AND analyse_materiau_v1_couche_meta_analyse.analyse_materiau_v1_couche_meta_depot = depot.id_analyse_materiau_v1_couche_meta_depot
        LEFT JOIN analyse_materiau_v1_molp_couche ON id_analyse_materiau_v1_couche = analyse_materiau_v1_molp_couche.analyse_materiau_v1_couche
        LEFT JOIN analyse_materiau_v1_portoir ON prepa.portoir_analyse_materiau_v1_couche_meta_prepa = id_analyse_materiau_v1_portoir
        WHERE id_analyse_materiau_v1 = {$idAnalyse}
		ORDER BY id_analyse_materiau_v1_couche";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 */
	function getEchantillonAnalyseMatV1_molp($idAnalyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1
        JOIN analyse_materiau_v1_couche ON id_analyse_materiau_v1 = analyse_materiau_v1_couche.analyse_materiau_v1_couche
        JOIN analyse_materiau_v1_exam_prea ON id_analyse_materiau_v1 = analyse_materiau_v1_exam_prea.analyse_materiau_v1_exam_prea
        JOIN analyse_materiau_v1_molp_couche ON id_analyse_materiau_v1_couche = analyse_materiau_v1_molp_couche.analyse_materiau_v1_couche
        WHERE id_analyse_materiau_v1 = {$idAnalyse}
		ORDER BY id_analyse_materiau_v1_couche";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 */
	function getEchantillonAnalyseMatV1_metaPrepa($idAnalyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1
        JOIN analyse_materiau_v1_couche ON id_analyse_materiau_v1 = analyse_materiau_v1_couche.analyse_materiau_v1_couche
        JOIN analyse_materiau_v1_exam_prea ON id_analyse_materiau_v1 = analyse_materiau_v1_exam_prea.analyse_materiau_v1_exam_prea
        JOIN analyse_materiau_v1_couche_meta_prepa ON id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_prepa.analyse_materiau_v1_couche
        WHERE id_analyse_materiau_v1 = {$idAnalyse}
		ORDER BY id_analyse_materiau_v1_couche";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 */
	function getEchantillonAnalyseMatV1_metaDepot($idAnalyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1
        JOIN analyse_materiau_v1_couche ON id_analyse_materiau_v1 = analyse_materiau_v1_couche.analyse_materiau_v1_couche
        JOIN analyse_materiau_v1_couche_meta_depot ON id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche
        JOIN analyse_materiau_v1_couche_meta_prepa ON id_analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa
        WHERE id_analyse_materiau_v1 = {$idAnalyse}
		ORDER BY id_analyse_materiau_v1_couche";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function getPrestaLabo($id_analyse_externe_prestation_delais) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_externe_prestation_delais
        JOIN analyse_externe_prestation ON prestation_analyse_externe_prestation_delais = id_analyse_externe_prestation
        WHERE id_analyse_externe_prestation_delais = {$id_analyse_externe_prestation_delais}";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}

	/**
	 * 
	 */
	function getEchantillonAnalyseMatV1_metaAnalyse($idAnalyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1
        JOIN analyse_materiau_v1_couche ON id_analyse_materiau_v1 = analyse_materiau_v1_couche.analyse_materiau_v1_couche
		JOIN analyse_materiau_v1_couche_meta_analyse ON id_analyse_materiau_v1_couche = analyse_materiau_v1_couche_meta_analyse.analyse_materiau_v1_couche
        JOIN analyse_materiau_v1_couche_meta_depot ON id_analyse_materiau_v1_couche_meta_depot = analyse_materiau_v1_couche_meta_analyse.analyse_materiau_v1_couche_meta_depot
        JOIN analyse_materiau_v1_couche_meta_prepa ON id_analyse_materiau_v1_couche_meta_prepa = analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche_meta_prepa
        WHERE id_analyse_materiau_v1 = {$idAnalyse}
		ORDER BY id_analyse_materiau_v1_couche";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 */
	function getCodeArticleMethodAnalFromDossierClientAnalyse($idEchantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT client_analyse.methode_analytique_client_analyse, dossier.code_article_dossier, dossier.methode_analytique_dossier FROM echantillon_analyse
		JOIN dossier ON dossier_echantillon_analyse = id_dossier
		JOIN client_analyse ON client_dossier = id_client_analyse
		WHERE id_echantillon_analyse = {$idEchantillon}";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	/**
	 * 
	 */
	function getEmplacementBoiteArchive($id_boite_archive) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT ref_echantillon_analyse as ref_echantillon, emplacement_grille_analyse_materiau_v1_couche_meta_depot
                FROM analyse_materiau_v1_couche_meta_depot
                JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
                JOIN analyse_materiau_v1 ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
                JOIN echantillon_analyse ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
                WHERE boite_archive_analyse_materiau_v1_couche_meta_depot = {$id_boite_archive}
                AND type_dossier_analyse_materiau_v1 = 2
                UNION
                SELECT ref_echantillon, emplacement_grille_analyse_materiau_v1_couche_meta_depot
                FROM analyse_materiau_v1_couche_meta_depot
                JOIN analyse_materiau_v1_couche ON analyse_materiau_v1_couche_meta_depot.analyse_materiau_v1_couche = id_analyse_materiau_v1_couche
                JOIN analyse_materiau_v1 ON analyse_materiau_v1_couche.analyse_materiau_v1_couche = id_analyse_materiau_v1
                JOIN echantillon ON echantillon_analyse_materiau_v1 = id_echantillon
                WHERE boite_archive_analyse_materiau_v1_couche_meta_depot = {$id_boite_archive}
                AND type_dossier_analyse_materiau_v1 = 1
        ";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function getResultatAnalyse($id_analyse_materiau_v1) {

		$couches = $this->ListeAnalyseMateriauv1Couche($id_analyse_materiau_v1);
		//-----------------------------------------------------
		// Loop through Couches. 
		//-----------------------------------------------------
		$dataCouches = [];
		$remarques = [];

		foreach ($couches as $index => $oneCouche) {
			unset($setCoucheDataMETA);
			unset($setCoucheDataMOLP);

			// Get couche data.
			$data_couche = json_decode($oneCouche->data_couche_analyse_materiau_v1_couche);
			$num_couche = $data_couche->num_couche;
			$nom_couche = [];

			// Set couche description.
			$nom_couche[] = "C{$num_couche}";

			$descriptif_couche = [];

			$type_mat = implode(", ", $data_couche->type_mat);
			$texture_mat = implode(", ", $data_couche->texture_mat);
			$couleur_mat = implode(", ", $data_couche->couleur_mat);

			$descriptif_couche[] = "C" . $num_couche . " : " . implode(" ", [$type_mat, $texture_mat, $couleur_mat]);

			// Add indisso to couche description.
			if (property_exists($data_couche, "desc_indisso")) {
				foreach ($data_couche->desc_indisso as $coucheIndisso) {
					$nom_couche[] = "C{$coucheIndisso->num_couche}";

					$type_mat_indisso = implode(", ", $coucheIndisso->type_mat);
					$texture_mat_indisso = implode(", ", $coucheIndisso->texture_mat);
					$couleur_mat_indisso = implode(", ", $coucheIndisso->couleur_mat);

					$descriptif_couche[] = "C" . $coucheIndisso->num_couche . " : " . implode(", ", [$type_mat_indisso, $texture_mat_indisso, $couleur_mat_indisso]);
				}
			}

			// Remarque rapport par couche
			foreach ($this->listHistoriqueCouche($oneCouche->id_analyse_materiau_v1_couche) as $oneRemarque) {
				if ($oneRemarque->commentaire_rapport <> "")
					$remarques[] = implode(' + ', $nom_couche) . ', ' . $oneRemarque->type_historique_couche . ' : ' . $oneRemarque->commentaire_rapport;
			}


			// Analyse META.
			if ($data_couche->meta <> null) {
				// Get le last META analysis.
				$lastAnalyseCouche = $this->listCoucheMetaAnalyses($oneCouche->id_analyse_materiau_v1_couche)[0]; // fist in array is last.
				$prepaMETA = $this->showAnalysePrepaMETA($lastAnalyseCouche->id_analyse_materiau_v1_couche_meta_analyse)[0];

				// set resultat analyse
				$resultat_analyse = 0;
				$fibresAnalyse = json_decode($lastAnalyseCouche->fibres_analyse_materiau_v1_couche_meta_analyse);
				if ($lastAnalyseCouche->conclusion_analyse_materiau_v1_couche_meta_analyse == "presence") { // si presence
					if ($fibresAnalyse->{"FMS<3"} <> 0 || $fibresAnalyse->{"FMS>3"} <> 0 || $fibresAnalyse->{"FO"} <> 0) {
					} else {
						$type_fibre = [];
						$nomFibres = ["ac" => "Actinolite", "am" => "Amosite", "ch" => "Chrysotile", "cr" => "Crocidolite", "tr" => "Tremolite", "ant" => "Anthophyllite"];
						foreach ($fibresAnalyse as $fibre => $value) {
							if ($fibre <> "abs" && $value <> 0) {
								$type_fibre[] = $nomFibres[$fibre];
							}
						}
						$resultat_analyse = 1;
					}
				}

				$traitement = [];
				if ($prepaMETA->eau_analyse_materiau_v1_couche_meta_prepa == "1")
					$traitement[] = "Broyage à l’humide";
				if ($prepaMETA->acetone_analyse_materiau_v1_couche_meta_prepa == "1")
					$traitement[] = "Broyage au solvant";
				if ($prepaMETA->chloroforme_analyse_materiau_v1_couche_meta_prepa == "1")
					$traitement[] = "Broyage au solvant";
				if ($prepaMETA->hcl_analyse_materiau_v1_couche_meta_prepa == "1")
					$traitement[] = "Attaque chimique";
				$traitement = implode(", ", array_unique($traitement));

				// Set nb essais.
				$nbPrepa = count($this->listCouchePrepa($oneCouche->id_analyse_materiau_v1_couche));
				// Set nb support.
				$depots = $this->listCoucheDepot($oneCouche->id_analyse_materiau_v1_couche);
				$countGrilles = 0;
				foreach ($depots as $depot) {
					$countGrilles += $depot->nb_grilles_analyse_materiau_v1_couche_meta_depot;
				}

				// Couche data.
				$setCoucheDataMETA = new StdClass();
				$setCoucheDataMETA->methode_analyse = "META";
				$setCoucheDataMETA->nbEssai = $nbPrepa;
				$setCoucheDataMETA->nbSupport = $countGrilles;
				$setCoucheDataMETA->resultat_analyse = $resultat_analyse;
				$setCoucheDataMETA->type_fibre = array_unique($type_fibre);
				$setCoucheDataMETA->traitement = $traitement;

				$date_analyse = date("d-m-Y", strtotime($lastAnalyseCouche->date_analyse_materiau_v1_couche_meta_analyse));
			}
			// Analyse MOLP.
			else if ($data_couche->molp <> null) {

				// Get last MOLP analysis.
				$lastAnalyseCouche = $this->listCoucheMolpAnalyses($oneCouche->id_analyse_materiau_v1_couche);

				// Set resultat analyse.
				$resultat_analyse = 0;
				$type_fibre = [];
				$fibresAnalyse = json_decode($lastAnalyseCouche->type_fibres_analyse_materiau_v1_molp_couche);
				$nomFibres = ["Ac" => "Actinolite", "Am" => "Amosite", "Ch" => "Chrysotile", "Cr" => "Crocidolite", "Tr" => "Tremolite", "Ant" => "Anthophyllite"];
				foreach ($fibresAnalyse as $fibre => $value) {
					switch ($fibre) {
						case "NC":
							break;
						case "Abs":
							break;
						case "FMS<3":
							break;
						case "FMS>3":
							break;
						case "FO":
							break;
						default:
							$type_fibre[] = $nomFibres[$fibre];
							$resultat_analyse = 1;
					}
				}

				$nbPrepa = count(json_decode($lastAnalyseCouche->preparation_analyse_materiau_v1_molp_couche));

				// Couche data.
				$setCoucheDataMOLP = new StdClass();
				$setCoucheDataMOLP->methode_analyse = "MOLP";
				$setCoucheDataMOLP->nbEssai = $nbPrepa;
				$setCoucheDataMOLP->nbSupport = $lastAnalyseCouche->nb_lames_analyse_materiau_v1_molp_couche;
				$setCoucheDataMOLP->resultat_analyse = $resultat_analyse;
				$setCoucheDataMOLP->type_fibre = array_unique($type_fibre);

				$date_analyse = date("d-m-Y", strtotime($lastAnalyseCouche->date_analyse_materiau_v1_molp_couche));
			}

			if (isset($setCoucheDataMETA) || isset($setCoucheDataMOLP)) {
				$dataCouches[$index]['nom_couche'] = implode(' + ', $nom_couche);
				$dataCouches[$index]['description'] = $descriptif_couche;

				$dataCouchesAnalyse;
				if (isset($setCoucheDataMETA))
					$dataCouchesAnalyse = $setCoucheDataMETA;
				if (isset($setCoucheDataMOLP))
					$dataCouchesAnalyse = $setCoucheDataMOLP;

				$dataCouches[$index]['analyse'] = $dataCouchesAnalyse;
			} else {
				if ($data_couche->non_prepare == "1" || $data_couche->non_analysable == "1" || $data_couche->non_interet == "1") {
					$dataCouchesAnalyse = new StdClass();
					$dataCouchesAnalyse->methode_analyse = "/";
					$dataCouchesAnalyse->nbEssai = "/";
					$dataCouchesAnalyse->nbSupport = "/";
					$dataCouchesAnalyse->resultat_analyse = "/";
					$dataCouchesAnalyse->type_fibre = "/";
					$dataCouchesAnalyse->traitement = "/";

					$dataCouches[$index]['nom_couche'] = implode(' + ', $nom_couche);
					$dataCouches[$index]['description'] = $descriptif_couche;
					$dataCouches[$index]['analyse'] = $dataCouchesAnalyse;
				}
			}
		}
		$dataEchantillon = new StdClass();
		$dataEchantillon->date_analyse = $date_analyse;
		$dataEchantillon->dataCouches = $dataCouches;
		$dataEchantillon->remarques = $remarques;

		return $dataEchantillon;
	}

	/*
	* Retourne les noms de fibres en fonction du type de couche.
	*/
	static public function getAnalysesMateriaux($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * 
				FROM 
					analyse_materiau_v1 
				WHERE 
					echantillon_analyse_materiau_v1 = {$id_echantillon}
					AND validation_analyse_materiau_v1 = 1
				ORDER BY 
					revision_analyse_materiau_v1";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}



	/*
	* Retourne les noms de fibres en fonction du type de couche.
	*/
	static public function getNomsFibres($type_couche) {
		if ($type_couche == "meta") {
			return [
				"ac"  => "Actinolite",
				"am"  => "Amosite",
				"ch"  => "Chrysotile",
				"cr"  => "Crocidolite",
				"tr"  => "Tremolite",
				"ant" => "Anthophyllite",
			];
		} else if ($type_couche == "molp") {
			return [
				"Ac"  => "Actinolite",
				"Am"  => "Amosite",
				"Ch"  => "Chrysotile",
				"Cr"  => "Crocidolite",
				"Tr"  => "Tremolite",
				"Ant" => "Anthophyllite"
			];
		}
		return [];
	}

	/*
	* Retourne toutes les couches d'une analyse
	*/
	static public function getAllCouches($id_analyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM analyse_materiau_v1_couche WHERE analyse_materiau_v1_couche = {$id_analyse}";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	/*
	* Retourne si l'une des couches de l'analyse a des fibres
	*/
	static public function isFibreAnalyse($id_analyse) {
		$model 		  = new CEAPICWorldModelAnalyseMateriauV1();
		$couches 	  = self::getAllCouches($id_analyse);
		$last_analyse = null;
		$is_fibre     = false;
		if ($couches != null) {
			foreach ($couches as $couche) {
				if ($couche->meta_analyse_materiau_v1_couche == $model::$META_ANALYSE_DONE) {
					$last_analyse = $model->listCoucheMetaAnalyses($couche->id_analyse_materiau_v1_couche)[0];
					$fibres_analyse = json_decode($last_analyse->fibres_analyse_materiau_v1_couche_meta_analyse, true);
					foreach (self::getNomsFibres("meta") as $key => $fibre) {
						if (!is_null($fibres_analyse) && $fibres_analyse[$key] == "1") {
							$is_fibre = true;
							break;
						}
					}
				} elseif ($couche->molp_analyse_materiau_v1_couche == $model::$MOLP_ANALYSE_DONE) {
					$last_analyse = $model->listCoucheMolpAnalyses($couche->id_analyse_materiau_v1_couche);
					$fibres_analyse = json_decode($last_analyse->type_fibres_analyse_materiau_v1_molp_couche, true);
					foreach (self::getNomsFibres("molp") as $key => $fibre) {
						if (!is_null($fibres_analyse) && $fibres_analyse[$key] == "1") {
							$is_fibre = true;
							break;
						}
					}
				}
			}
			return $is_fibre;
		} else {
			throw new Exception("Aucune analyse pour l'id " . $id_analyse);
		}
	}
}
