<?php
// require_once(JPATH_COMPONENT . DS . 'models/MPCA.php');
// require_once(JPATH_COMPONENT . DS . 'models/Tools.php');
// require_once(JPATH_COMPONENT . DS . 'models/ProcessusClient.php');
// require_once(JPATH_COMPONENT . DS . 'models/ProcessusTechnique.php');
require_once(URL_MODELE . "MPCA.php");
require_once(URL_MODELE . "Tools.php");
require_once(URL_MODELE . "ProcessusClient.php");
require_once(URL_MODELE . "ProcessusTechnique.php");

$materiauxBase = MPCA::listMatriceMateriauMPCA(true);
$techniquesBase = ProcessusTechnique::listTechnique(null);

// $Strategie = $model0->AfficheLastStrategieChantier($id_echantillon);
// echo $id_echantillon;
// echo $Strategie[0]->id_strategie_chantier;
// $DynamicTable = $model0->ListeTableauDynamic($Strategie[0]->id_strategie_chantier);

?>
<STYLE>


</STYLE>
<?php
$i = 0;
$save_processus = "";
// var_dump($model->ListeEchantillonProcessusClient($id_client));
// die();
foreach ($model->ListeEchantillonProcessusClient($id_client) as $oneEchantillon) {
	// die('z');
	$i++;
	//AfficheRapportMETA269Echantillon
	$Processus = $model->AfficheRapportMETA269Echantillon($oneEchantillon->id_echantillon);
	if (count($Processus) <> 0) {
		$oneProcessus = $Processus[0];
		$hash = md5($oneProcessus->id_rapport_meta_269 . $model->GetSharingKey());
		$id_rapport = $oneProcessus->id_rapport_meta_269;
		$revision = $oneProcessus->revision_rapport_meta_269;
		$ref_processus = $oneProcessus->reference_processus_rapport_meta_269;
		$materiau_processus = $oneProcessus->materiau_rapport_meta_269;
		$technique_processus = $oneProcessus->technique_rapport_meta_269;

		$separator = "";
		$confinement = "";
		if ($confinement <> "") {
			$separator = ", ";
		}
		if ($oneRapport->aucune_confinement_rapport_meta_269 == 1) {
			$confinement .= $separator . "Aucune mesure d'isolement";
		}
		if ($confinement <> "") {
			$separator = ", ";
		}
		if ($oneRapport->isolement_confinement_rapport_meta_269 == 1) {
			$confinement .= $separator . "Isolement et calfeutrement simple";
		}
		if ($confinement <> "") {
			$separator = ", ";
		}
		if ($oneRapport->static_confinement_rapport_meta_269 == 1) {
			$confinement .= $separator . "Confinement statique et renouvellement d'air";
		}
		if ($confinement <> "") {
			$separator = ", ";
		}
		if ($oneRapport->static_confinement_sans_rapport_meta_269 == 1) {
			$confinement .= $separator . "Confinement statique sans renouvellement d'air";
		}
		if ($confinement <> "") {
			$separator = ", ";
		}
		if ($oneRapport->dynamic_confinement_rapport_meta_269 == 1) {
			$confinement .= $separator . "Confinement dynamique avec mise en dépression";
		}
		if ($confinement <> "") {
			$separator = ", ";
		}
		if ($oneRapport->sac_isolement_confinement_rapport_meta_269 == 1) {
			$confinement .= $separator . "Sac à manche";
		}
		if ($confinement <> "") {
			$separator = ", ";
		}
		if ($oneRapport->boite_isolement_confinement_rapport_meta_269 == 1) {
			$confinement .= $separator . "Boîte à gant";
		}

		$separator = "";
		$humidification = "";
		if ($humidification <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->aucune_humidification_rapport_meta_269 == 1) {
			$humidification .= $separator . "Aucune mesure de travail à l'humide";
		}
		if ($humidification <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->humidification_humidification_rapport_meta_269 == 1) {
			$humidification .= $separator . "Humidification du matériau par pulvérisation";
		}
		if ($humidification <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->mouillage_humidification_rapport_meta_269 == 1) {
			$humidification .= $separator . "Mouillage par inondation des matériaux";
		}
		if ($humidification <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->brumisation_impregnation_humidification_rapport_meta_269 == 1) {
			$humidification .= $separator . "Brumisation";
		}
		if ($humidification <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->nebulisation_impregnation_humidification_rapport_meta_269 == 1) {
			$humidification .= $separator . "Nébulisation";
		}
		if ($humidification <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->impregnation_humidification_rapport_meta_269 == 1) {
			$humidification .= $separator . "Imprégnation à cœur du matériau";
		}

		$separator = "";
		$captage = "";
		if ($captage <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->aucune_captage_rapport_meta_269 == 1) {
			$captage .= $separator . "Aucune mesure de captage des poussières à la source";
		}
		if ($captage <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->source_captage_rapport_meta_269 == 1) {
			$captage .= $separator . "Captage des poussières à la source";
		}
		if ($captage <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->aspiration_captage_rapport_meta_269 == 1) {
			$captage .= $separator . "Captage des poussières avec aspiration déportée";
		}
		if ($captage <> "") {
			$separator = ", ";
		}

		$separator = "";
		$epc_processus = "";
		if ($epc_processus <> "") {
			$separator = "<br/>";
		}
		if ($confinement <> "") $epc_processus .= $separator . "<b>Confinement :</b> " . $confinement;
		if ($epc_processus <> "") {
			$separator = "<br/>";
		}
		if ($humidification <> "") $epc_processus .= $separator . "<b>Humidification :</b> " . $humidification;
		if ($epc_processus <> "") {
			$separator = "<br/>";
		}
		if ($captage <> "") $epc_processus .= $separator . "<b>Captage :</b> " . $captage;
	}

	$Processus = $model->AfficheRapportMETA269V2Echantillon($oneEchantillon->id_echantillon);
	if (count($Processus) <> 0) {
		$oneProcessus = $Processus[0];
		$hash = md5($oneProcessus->id_rapport_meta_269_v2 . $model->GetSharingKey());
		$id_rapport = $oneProcessus->id_rapport_meta_269_v2;
		$revision = $oneProcessus->revision_rapport_meta_269_v2;

		if (($oneProcessus->ref_processus_texte_rapport_meta_269_v2 <> "") && ($oneProcessus->ref_processus_texte_rapport_meta_269_v2 <> "/")) {
			$ref_processus = $oneProcessus->ref_processus_texte_rapport_meta_269_v2;
		} else {
			$ref_processus = "NC";
		}

		// ==========================================================================================================
		// Matériau
		// ==========================================================================================================

		$separator = "";
		$materiau_processus = "";
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->flocage_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Flocage";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->calorifugeage_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Calorifugeage";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->faux_plafond_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Faux Plafond";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->dalle_sol_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Dalle de sol";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->carrelage_sol_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Carrelage au sol";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->faience_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Faïence";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->plinthe_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Plinthe";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->colle_dalle_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Colle de Dalle";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->colle_carrelage_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Colle de Carrelage";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->colle_faience_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Colle de Faïence";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->colle_plinthe_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Colle de Plinthe";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->fibrociment_conduit_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Fibrociment (conduit)";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->fibrociment_plaque_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Fibrociment (plaque)";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->ciment_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Ciment";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->enduit_peinture_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Enduit / Peinture";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->platre_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Plâtre";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->reagreage_chape_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Ragréage / Chape";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->mortier_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Mortier";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->joint_vitrage_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Joints vitrage";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->joint_bride_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Joints de bride";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->joint_mastique_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Mastic et autres joints";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->etancheite_bitumeux_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Revêtement / Etanchéité bitumineux ";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->enrobe_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Revêtement routier / Enrobés";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->element_friction_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Eléments de friction";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->clapet_coupe_feu_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Clapet coupe-feu";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->porte_coupe_feu_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Porte coupe-feu";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->panocell_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Panocell";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->panneau_sandwich_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Panneau sandwich";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->carton_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Cartons";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->feutre_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Feutres";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->textile_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Textiles";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->mousse_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Mousse";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->bourre_vrac_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . "Bourres en vrac";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->autre_materiau_rapport_meta_269_v2 == 1) {
			$materiau_processus .= $separator . $oneProcessus->autre_materiau_texte_rapport_meta_269_v2;
		}

		// ==========================================================================================================
		// Technique
		// ==========================================================================================================

		$separator = "";
		$technique_processus = "";
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->arrachage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Arrachage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->balayage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Balayage ";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->brossage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Brossage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->carottage_forage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Carottage / Forage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->cassage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Cassage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->burinage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Burinage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->piquage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Piquage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->demolition_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Démolition";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->recouvrement_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Doublage / Encoffrement / Recouvrement";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->decapage_lustrage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Décapage / Lustrage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->decollage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Décollage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->decoupage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Découpage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->percage_sciage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Tronçonnage / Perçage / Sciage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->deconstruction_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Désemboitage / Déconstruction";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->sablage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Grenaillage / Hydrogommage / Sablage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->nettoyage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Nettoyage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->ramassage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Ramassage / Manutention / Conditionnement";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->pelletage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Pelletage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->poncage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Ponçage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->procede_chimique_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Procédé chimique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->rabotage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Rabotage / Rectification / Fraisage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->raclage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Raclage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->technique_thp_uph_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Technique THP / UPH";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->vissage_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . "Visage / Tirage de câble / Réglage";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->autre_technique_rapport_meta_269_v2 == 1) {
			$technique_processus .= $separator . $oneProcessus->technique_texte_rapport_meta_269_v2;
		}

		if ($oneProcessus->type_technique_texte_rapport_meta_269_v2 <> "") {
			$technique_processus = $oneProcessus->type_technique_rapport_meta_269_v2 . " par " . $technique_processus . ". Outil(s) : " . $oneProcessus->type_technique_texte_rapport_meta_269_v2;
		} else {
			$technique_processus = $oneProcessus->type_technique_rapport_meta_269_v2 . " par " . $technique_processus;
		}

		// ==========================================================================================================
		// EPC
		// ==========================================================================================================

		$separator = "";
		$humidification = "";
		if ($oneProcessus->humidification_rapport_meta_269_v2 == 1) {
			if ($humidification <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->humidification_humidification_rapport_meta_269_v2 == 1) {
				$humidification .= $separator . "Humidification des matériaux par pulvérisation";
			}
			if ($humidification <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->mouillage_humidification_rapport_meta_269_v2 == 1) {
				$humidification .= $separator . "Mouillage par inondation des matériaux";
			}
			if ($humidification <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->impregnation_humidification_rapport_meta_269_v2 == 1) {
				$humidification .= $separator . "Imprégnation à cœur des matériaux";
			}
			if ($humidification <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->brumisation_impregnation_humidification_rapport_meta_269_v2 == 1) {
				$humidification .= $separator . "Brumisation dans la zone";
			}
			if ($humidification <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->nebulisation_impregnation_humidification_rapport_meta_269_v2 == 1) {
				$humidification .= $separator . "Nébulisation dans la zone";
			}
		}

		$separator = "";
		$captage = "";
		if ($oneProcessus->captage_rapport_meta_269_v2 == 1) {
			if ($captage <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->source_captage_rapport_meta_269_v2 == 1) {
				$captage .= $separator . "Captage des poussières à la source";
			}
			if ($captage <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->aspiration_captage_rapport_meta_269_v2 == 1) {
				$captage .= $separator . "Captage des poussières avec aspiration déportée";
			}
		}

		$separator = "";
		$epc_processus = "";
		if ($epc_processus <> "") {
			$separator = "<br/>";
		}
		if ($humidification <> "") {
			$epc_processus .= $separator . "<b>Humidification :</b> " . $humidification;
		} else {
			$epc_processus .= $separator . "<b>Humidification :</b> Absence d'humidification";
		}
		if ($epc_processus <> "") {
			$separator = "<br/>";
		}
		if ($captage <> "") {
			$epc_processus .= $separator . "<b>Captage :</b> " . $captage;
		} else {
			$epc_processus .= $separator . "<b>Captage :</b> Absence de captage";
		}
	}


	$Processus = $model->AfficheRapportMETA269V3Echantillon($oneEchantillon->id_echantillon);
	if (count($Processus) <> 0) {
		
		$oneProcessus = $Processus[0];
		$hash = md5($oneProcessus->id_rapport_meta_269_v3 . $model->GetSharingKey());
		$id_rapport = $oneProcessus->id_rapport_meta_269_v3;
		$revision = $oneProcessus->revision_rapport_meta_269_v3;
		
		if (($oneProcessus->ref_processus_texte_rapport_meta_269_v3 <> "") && ($oneProcessus->ref_processus_texte_rapport_meta_269_v3 <> "/")) {
			$ref_processus = $oneProcessus->ref_processus_texte_rapport_meta_269_v3;
		} else {
			
			$StrategieProcessus = $model->AfficheStrategieProcessusMesureJ($oneEchantillon->id_echantillon);
			$oneStrategieProcessus = $StrategieProcessus[0];

			// if ($rm269v3->id_strategie_rapport_meta_269_v3 != 0) {
			// 	$stratClient = ProcessusClient::getById($rm269v3->id_strategie_rapport_meta_269_v3);

			// 	/*if ($stratClient) {
			// 	$ref_strategie_processus = $stratClient->reference_client;
			// }*/
			// }

			if ($oneStrategieProcessus->type_processus_client_echantillon_strategie_processus = 2) {

				$stratClient = ProcessusClient::getById($oneStrategieProcessus->processus_client_echantillon_strategie_processus);

				$ref_processus = "Processus N° " . $stratClient->reference_client;

			} else {
				$ref_processus = "NC";
			}
		}

		// ==========================================================================================================
		// Matériau
		// ==========================================================================================================

		$separator = "";
		$materiau_processus = "";
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->flocage_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Flocage";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->calorifugeage_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Calorifugeage";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->faux_plafond_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Faux Plafond";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->frigorifuge_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Frigorifuge";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->dalle_sol_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Dalle de sol";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->lino_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Lino, moquette, lé";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->carrelage_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Carrelage au sol";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->faience_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Faïence";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->plinthe_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Plinthe";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->peinture_interieur_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Peinture intérieur";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->peinture_exterieur_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Peinture extérieur";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->peinture_metal_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Peinture sur support métallique";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->enduit_projete_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Enduit projeté (progypsol)";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->enduit_lissage_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Enduit de lissage";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->enduit_exterieur_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Enduit extérieur";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->enduit_metal_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Enduit sur support métallique";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->mortier_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Mortier";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->platre_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Plâtre";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->ciment_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Ciment";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->ragreage_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Ragréage / chape maigre";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->colle_bitumineuse_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Colle bitumineuse";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->colle_dalle_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Colle de dalle";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->colle_lino_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Colle de lino, moquette, lé";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->colle_plinthe_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Colle de Plinthe";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->colle_faience_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Colle de Faïence";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->canalisation_interieur_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Canalisation / Gaine Fibro intérieur";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->canalisation_exterieur_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Canalisation / Gaine Fibro extérieur";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->plaque_fibro_interieur_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Plaque Fibro intérieur";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->plaque_fibro_exterieur_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Plaque Fibro extérieur";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->tuiles_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Tuiles, Ardoises";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->toitures_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Toiture, bardage";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->etancheite_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Etanchéité bitumineuse";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->joint_vitrage_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Joints vitrage";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->joint_fenetre_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Joints cadre fenêtres";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->joint_bride_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Joints de bride";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->joint_installation_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Joints d’installation";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->mastic_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Mastic et autres joints";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->revetement_routier_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Revêtement routier/enrobés";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->friction_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Eléments de friction (freins)";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->clapet_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Clapet coupe-feu";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->porte_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Porte coupe-feu";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->tresse_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . "Tresse amiantée";
		}
		if ($materiau_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->autre_materiau_rapport_meta_269_v3 == "1") {
			$materiau_processus .= $separator . $oneProcessus->autre_materiau_texte_rapport_meta_269_v3;
		}

		if ($oneProcessus->materiau_rapport_meta_269_v3 != null) {
			$materiau_processus .= implode(', ', (array)json_decode($oneProcessus->materiau_rapport_meta_269_v3));
		}

		$materiau_proc = [];
		$MPCA_array = (array) json_decode($oneProcessus->id_materiau_rapport_meta_269_v3);

		foreach ($MPCA_array as $materiau) {
			foreach ($materiauxBase as $matBase) {
				if ($matBase->id_materiau == $materiau) {
					foreach (explode(',', $matBase->nom_materiau) as $oneMAT) {
						array_push($materiau_proc, $oneMAT);
					}
				}
			}
		}

		if (sizeof($materiau_proc) > 0) {
			$matTemp = implode(", ", $materiau_proc);
			$materiau_processus = $matTemp;
		}


		// ==========================================================================================================
		// Technique
		// ==========================================================================================================

		$separator = "";
		$technique_processus = "";

		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->arrachage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Arrachage manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->desemboitage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Désemboitage / Déconstruction manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->depose_dessous_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Dépose par le dessous manuelle";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->depose_dessus_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Dépose par le dessus manuelle";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->ramassage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Ramassage / Nettoyage manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->manutention_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Manutention / conditionnement manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->pelletage_manuelle_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Pelletage manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->burinage_manuelle_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Burinage / piquage / cassage manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->raclage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Raclage manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->grattage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Grattage manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->balayage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Balayage manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->brossage_manuelle_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Brossage manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->poncage_manuelle_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Ponçage manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->encoffrement_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Encoffrement / recouvrement manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->vissage_manuelle_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Vissage / Dévissage manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->decoupage_manuelle_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Découpage manuel";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->autre_technique_manuelle_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . $oneProcessus->technique_manuelle_texte_rapport_meta_269_v3 . " manuel";
		}

		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->poncage_mecanique_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Ponçage mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->rabotage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Rabotage / Rectification mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->burinage_mecanique_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Burinage mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->cassage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Cassage / piquage mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->tronconnage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Tronçonnage / Perçage mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->decoupage_mecanique_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Découpage / sciage mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->brossage_mecanique_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Brossage mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->pelletage_mecanique_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Pelletage mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->sablage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Sablage mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->carottage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Carottage / Forage mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->vissage_mecanique_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Vissage / Dévissage mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->demolition_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Démolition mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->decapage_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Décapage / Lustrage mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->thp_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Jet Très Haute Pression (THP) mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->chimique_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . "Procédé chimique mécanique";
		}
		if ($technique_processus <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->autre_technique_mecanique_rapport_meta_269_v3 == "1") {
			$technique_processus .= $separator . $oneProcessus->technique_mecanique_texte_rapport_meta_269_v3 . " mécanique";
		}

		if ($oneProcessus->technique_mecanique_rapport_meta_269_v3 != null) {
			$technique_processus .= implode(', ', (array)json_decode($oneProcessus->technique_mecanique_rapport_meta_269_v3));
		}

		if ($oneProcessus->technique_manuelle_rapport_meta_269_v3 != null) {
			$technique_processus .= implode(', ', (array)json_decode($oneProcessus->technique_manuelle_rapport_meta_269_v3));
		}


		$technique_proc = [];

		$tabIdTechnique = $oneProcessus->id_technique_rapport_meta_269_v3;

		if ($tabIdTechnique) {
			//PDF AFFICHAGE DES DONNEES 
			$tabTechnique =  explode(',', str_replace(array('[', ']'), '', $tabIdTechnique));

			if ($tabTechnique) {
				foreach ($tabTechnique as $technique) {
					foreach ($techniquesBase as $tecBase) {
						if ($tecBase->id == $technique) {
							array_push($technique_proc, $tecBase->nom);
						}
					}
				}
			}
		}

		if (sizeof($technique_proc) > 0) {
			$tecTemp = implode(", ", $technique_proc);
			$technique_processus = $tecTemp;
		}

		// ==========================================================================================================
		// EPC
		// ==========================================================================================================

		$separator = "";
		$humidification = "";
		if ($oneProcessus->humidification_rapport_meta_269_v3 == "1") {
			if ($humidification <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->humidification_humidification_rapport_meta_269_v3 == "1") {
				$humidification .= $separator . "Humidification des matériaux par pulvérisation";
			}
			if ($humidification <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->mouillage_humidification_rapport_meta_269_v3 == "1") {
				$humidification .= $separator . "Mouillage par inondation des matériaux";
			}
			if ($humidification <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->impregnation_humidification_rapport_meta_269_v3 == "1") {
				$humidification .= $separator . "Imprégnation à cœur des matériaux";
			}
			if ($humidification <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->brumisation_impregnation_humidification_rapport_meta_269_v3 == "1") {
				$humidification .= $separator . "Brumisation dans la zone";
			}
			if ($humidification <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->nebulisation_impregnation_humidification_rapport_meta_269_v3 == "1") {
				$humidification .= $separator . "Nébulisation dans la zone";
			}
		}

		$humis = $oneProcessus->humi_rapport_meta_269_v3;

		if ($humis != "[]" && $humis != null) {
			$tabTemp =  Tools::decodeCaracteres($humis);
			$tabHumiNew = json_decode($tabTemp);
			$humidification .= implode(", ", array_filter($tabHumiNew));
		}

		$separator = "";
		$captage = "";
		if ($oneProcessus->captage_rapport_meta_269_v3 == "1") {
			if ($captage <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->source_captage_rapport_meta_269_v3 == "1") {
				$captage .= $separator . "Captage des poussières à la source (aspi fixé à l'outil)";
			}
			if ($captage <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->aspiration_deporte_proche_captage_rapport_meta_269_v3 == "1") {
				$captage .= $separator . "Captage des poussières avec aspiration déportée au plus proche de l'outil";
			}
			if ($captage <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->aspiration_deporte_captage_rapport_meta_269_v3 == "1") {
				$captage .= $separator . "Captage des poussières avec aspiration déportée";
			}
			if ($captage <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->localise_captage_rapport_meta_269_v3 == "1") {
				$captage .= $separator . "Captage des poussières localisé enveloppant";
			}
		}

		$capts = $oneProcessus->capt_rapport_meta_269_v3;

		if ($capts != "[]" && $capts != null) {
			$tabTemp =  Tools::decodeCaracteres($capts);
			$tabCaptNew = json_decode($tabTemp);
			$captage .= implode(", ", array_filter($tabCaptNew));
		}

		$separator = "";
		$isolation = "";
		if ($oneProcessus->isolation_rapport_meta_269_v3 == "1") {
			if ($isolation <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->simple_peau_rapport_meta_269_v3 == "1") {
				$isolation .= $separator . "Protection simple peau sans calfeutrement";
			}
			if ($isolation <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->isolement_confinement_rapport_meta_269_v3 == "1") {
				$isolation .= $separator . "Isolement et calfeutrement simple";
			}
			if ($isolation <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->static_confinement_sans_rapport_meta_269_v3 == "1") {
				$isolation .= $separator . "Confinement statique sans renouvellement d’air";
			}
			if ($isolation <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->static_confinement_avec_rapport_meta_269_v3 == "1") {
				$isolation .= $separator . "Confinement statique avec renouvellement d’air";
			}
			if ($isolation <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->dynamic_10_6_10_confinement_rapport_meta_269_v3 == "1") {
				$isolation .= $separator . "Confinement dynamique, dépression -10P, renouv 6 à 10 V/h";
			}
			if ($isolation <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->dynamic_10_6_20_confinement_rapport_meta_269_v3 == "1") {
				$isolation .= $separator . "Confinement dynamique, dépression -10P, renouv 10 à 20 V/h";
			}
			if ($isolation <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->sac_isolement_confinement_rapport_meta_269_v3 == "1") {
				$isolation .= $separator . "Sac à manche";
			}
			if ($isolation <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->boite_isolement_confinement_rapport_meta_269_v3 == "1") {
				$isolation .= $separator . "Boîte à gant";
			}
			if ($isolation <> "") {
				$separator = ", ";
			}
			if ($oneProcessus->protection_simple_confinement_rapport_meta_269_v3 == "1") {
				$isolation .= $separator . "Protection simple peau sans calfeutrement";
			}
		}

		if (($oneProcessus->isolation_rapport_meta_269_v3 == 0) || ($isolation == ""))
			$isolation = "Absence";

		$separator = "";
		$installation_decontamination = "";
		if ($installation_decontamination <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->sas_3_rapport_meta_269_v3 == "1") {
			$installation_decontamination .= $separator . "SAS Personnel 3 compartiments";
		}
		if ($installation_decontamination <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->sas_5_rapport_meta_269_v3 == "1") {
			$installation_decontamination .= $separator . "SAS Personnel 5 compartiments";
		}
		if ($installation_decontamination <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->unite_mobile_rapport_meta_269_v3 == "1") {
			$installation_decontamination .= $separator . "Unité Mobile de Décontamination";
		}
		if ($installation_decontamination <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->espace_douche_rapport_meta_269_v3 == "1") {
			$installation_decontamination .= $separator . "Espace dédié sans douche";
		}
		if ($installation_decontamination <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->autre_installation_decontamination_rapport_meta_269_v3 == 1) {
			$installation_decontamination .= $separator . $oneProcessus->autre_installation_decontamination_texte_rapport_meta_269_v3;
		}

		if ($installation_decontamination == "")
			$installation_decontamination = "Aucune";


		$separator = "";
		$ventilation = "";
		if ($ventilation <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->absence_ventilation_rapport_meta_269_v3 == "1") {
			$ventilation .= $separator . "Absence";
		}
		if ($ventilation <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->captage_ventilation_rapport_meta_269_v3 == "1") {
			$ventilation .= $separator . "Absence avec captage d’air localisé";
		}
		if ($ventilation <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->fonctionnelle_ventilation_rapport_meta_269_v3 == "1") {
			$ventilation .= $separator . "Présence en fonctionnement";
		}
		if ($ventilation <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->non_fonctionnelle_ventilation_rapport_meta_269_v3 == "1") {
			$ventilation .= $separator . "Présence mais non fonctionnelle";
		}
		if ($ventilation <> "") {
			$separator = ", ";
		}
		if ($oneProcessus->sans_objet_ventilation_rapport_meta_269_v3 == "1") {
			$ventilation .= $separator . "Non communiqué \ Sans objet";
		}

		$separator = "";
		$epc_processus = "";
		if ($epc_processus <> "") {
			$separator = "<br/>";
		}
		if ($humidification <> "") $epc_processus .= $separator . "<b>Humidification :</b> " . $humidification;
		if ($epc_processus <> "") {
			$separator = "<br/>";
		}
		if ($captage <> "") $epc_processus .= $separator . "<b>Captage :</b> " . $captage;
	}


	// ==========================================================================================================
	// Analyse
	// ==========================================================================================================

	$SA = "";
	$resultat = "";
	$Analyse = $model->AfficheAnalyseMETA1Echantillon($oneEchantillon->id_echantillon);
	if (count($Analyse) <> 0) {
		$oneAnalyse = $Analyse[0];
		$SA = str_replace(".", ",", $oneAnalyse->sensibilite_analytique_analyse_meta_1);
		$resultat = $oneAnalyse->concentration_normalisee_analyse_meta_1;
	}

	$Analyse = $model->AfficheAnalyseMETAV0Echantillon($oneEchantillon->id_echantillon);
	if (count($Analyse) <> 0) {
		$oneAnalyse = $Analyse[0];
		$SA = number_format($oneAnalyse->sa_concentration_analyse_meta_v0, 2, ",", "");
		$nombre_fibre = str_replace(".", ",", $oneAnalyse->nombre_fibre_analyse_meta_v0);
		$resultat = number_format($oneAnalyse->concentration_normalise_concentration_analyse_meta_v0, 2, ",", "");
		if ($nombre_fibre < 4) $resultat = "&lt;" . $resultat;

		// Echantillon inanalysable
		$Prepa = $model->AfficheDernierePrepaMETAv0($oneAnalyse->id_analyse_meta_v0);
		$lastPrepa = $Prepa[0];
		if (($lastPrepa->decision_anomalie_grille_analyse_meta_v0_prepa == "Echantillon inanalysable") || ($oneAnalyse->decision_anomalie_reception_analyse_meta_v0 == "Echantillon inanalysable")) {
			$SA = "/";
			$resultat = "INA";
		}
	}

	$Analyse = $model->AfficheAnalyseMETAV1($oneEchantillon->id_echantillon);
	if (count($Analyse) != 0) {
		$oneAnalyse = $Analyse[0];
		$SA = number_format($oneAnalyse->sa_concentration, 2, ",", "");
		$nombre_fibre = str_replace(".", ",", $oneAnalyse->nbr_fibres);
		$resultat = number_format($oneAnalyse->concentration_normalise, 2, ",", "");
		if ($nombre_fibre < 4) $resultat = "&lt;" . $resultat;

		// Echantillon inanalysable
		/*$Prepa = $model->AfficheDernierePrepaMETAv0($oneAnalyse->id_analyse_meta_v0);
			$lastPrepa = $Prepa[0];
			if (($lastPrepa->decision_anomalie_grille_analyse_meta_v0_prepa == "Echantillon inanalysable") || ($oneAnalyse->decision_anomalie_reception_analyse_meta_v0 == "Echantillon inanalysable")){
				$SA = "/";
				$resultat = "INA";
			}*/
	}

	// ==========================================================================================================
	// TABLEAU
	// ==========================================================================================================

	echo "
		<tr>
			<td class=\"\">" . $oneEchantillon->nom_chantier . "</td>
			<td class=\"\">" . $oneEchantillon->adresse_chantier . "<br>" . $oneEchantillon->cp_chantier . " " . $oneEchantillon->ville_chantier . "</td>
			<td class=\"\">" . $ref_processus . "</td>
			<td class=\"\">" . $materiau_processus . "</td>
			<td class=\"\">" . $technique_processus . "</td>
			<td class=\"\">" . $epc_processus . "</td>
			<td class=\"\">" . $SA . "</td>
			<td class=\"resultat_processus\">" . $resultat . "</td>			
			<td class=\"\"><p class=\"show_processus\" linkechantillon=\"" . $oneEchantillon->id_echantillon . "\" linkrapport=\"" . $id_rapport . "\" hash=\"" . $hash . "\"><span class=\"href\">" . $oneEchantillon->ref_echantillon . " v" . $revision . "</span></p></td>
		</tr>";
}

?>

<script language="javascript" type="text/javascript">

</script>