<?php
// require_once(JPATH_COMPONENT . '/models/StrategieChantierV1.php');
// require_once(JPATH_COMPONENT . '/models/Tools.php');
require_once(URL_MODELE . "StrategieChantierV1.php");
require_once(URL_MODELE . "Tools.php");
// die("test");

$stratV1 = $modelStrategie->getStrategieChantierV1FromEchantillon($id_echantillon);
// echo "1";
// var_dump($stratV1);

$Strategie = null;
$Chantier = null;
$DynamicTable = null;

$Strategie = $modelStrategie->AfficheLastStrategieChantier($id_echantillon);
// echo "2";
// var_dump($Strategie);

$Chantier = $modelStrategie->AfficheChantierEchantillon($id_echantillon);
// echo "3";
// var_dump($Chantier);

$typeStrategie = 2;

if ($stratV1 == null) {
	$typeStrategie = 1;
	$DynamicTable = $modelStrategie->ListeTableauDynamic($Strategie[0]->id_strategie_chantier);
	// echo "4";
	// var_dump($DynamicTable);
	// die();
	$id_strategie = $Strategie[0]->id_strategie_chantier;
	$token_strategie = md5($id_strategie . $model->GetSharingKey());
}

$modelStrategie->ListeContactChantier($Chantier[0]->id_chantier);

// $id_client = $id_client;
$type_client = 1;
$token_client = md5($id_client . $type_client . $model->GetSharingKey());
?>
<STYLE>
	.hide {
		display: none;
	}

	.table_gbmnet {
		margin-top: 15px;
	}

	#notaccordion {
		margin-top: 15px;
	}

	.table_gbmnet td {
		border: 1px solid;
		padding: 5px;
		text-align: center;
	}

	fieldset dt {
		clear: left;
		float: left;
		width: 75px;
		padding: 3px 0;
	}

	fieldset dd {
		float: left;
		padding: 3px 0;
	}

	.tableForm td,
	.tableForm table {
		border: none;
		padding: 5px;
	}
</STYLE>



<div id="notaccordion" class="contentTable">
	<?php

	$count_table = 0;
	$save_contexte = "";

	if ($DynamicTable != null) {

	?>
		<table align="center" style="width: 98%; border-collapse: collapse; border: 1px solid;" border="0">
			<tr style="background: #A9F5A9;">
				<td style="padding: 5px; width: 100%;">Réglementaire ambiance code de la santé publique (CSP)</td>
			</tr>
			<tr style="background: #A9D0F5;">
				<td style="padding: 5px; width: 100%;">Réglementaire ambiance code du travail (CT)</td>
			</tr>
			<tr style="background: #F5D0A9;">
				<td style="padding: 5px; width: 100%;">Réglementaire opérateur code du travail (CT) : Mesures déclenchées suivant vos besoins</td>
			</tr>
		</table>

		<?php
		if ($id_client == "1") {
			echo '<div style="width: 100%; margin-top: 10px; text-align: right"><button class="ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow" onclick="BonCommandExcel(' . $id_strategie . ', \'' . $token_strategie . '\')"><i class="fa fa-file-excel-o"></i> Liste des commandes</button></div>';
		}
		?>



	<?php

		foreach ($DynamicTable as $oneDynamicTable) {
			$count_table++;
			if ($oneDynamicTable->TYPE_TABLE == 2) {
				$Rows = $modelStrategie->ListeZoneTravailMultiRow($oneDynamicTable->ID);
				$ZoneTravail = $modelStrategie->AfficheZoneTravail($oneDynamicTable->SELECT);
				$Mesure = $modelStrategie->AfficheMesureStrategie($Rows[0]->type_mesure_zone_travail_multi_row);
				// if($ZoneTravail[0]->confinement_zone_travail == "0"){$zone_travail = nl2br($ZoneTravail[0]->nom_zone_travail ." - ". $ZoneTravail[0]->confinement_texte_zone_travail);}else{$zone_travail = nl2br($ZoneTravail[0]->nom_zone_travail ." - ". $ZoneTravail[0]->confinement_zone_travail);}	
				$zone_travail = $ZoneTravail[0]->nom_zone_travail;
				$titre = "";
				$separator = "";
				foreach ($modelStrategie->AfficheTypeMesureZoneTravailRow($oneDynamicTable->ID) as $oneTypeMesure) {
					if ($titre <> "") {
						$separator = "<br/>& ";
					}
					$titre .= $separator . $oneTypeMesure->nom_pdf_contexte_mesure_strategie;
				}
				$count_radio++;
				$contexte = $titre;
				if (($save_contexte <> $contexte) && ($count_table <> 1)) echo "</div>";
				if ($save_contexte <> $contexte) echo "<h3 class=\"level1\">" . $contexte . "</h3><div>";
				echo "
		<h3 class=\"level2\">" . $zone_travail . "</h3>
		<div>
			<table style=\"width: 98%;\" class=\"table_gbmnet\">
				<tr style=\"background: #F2F2F2;\">
					<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Type de mesure</span></td>
					<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Qté</span></td>
					<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Date souhaitée</span></td>
					<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Electricité dispo</span></td>
					<td style=\"text-align: center;\"><input type=\"checkbox\" onChange=\"CheckAll(this);\"></td>
				</tr>
				<tr>
					<td style=\"background: #" . $Mesure[0]->couleur_mesure_strategie . ";padding: 5px; text-align: center;\"><span style=\"font-size: 10pt; font-family: arial;\">" . str_replace("Exigence réglementaire", "<SUP>R</SUP>", $Mesure[0]->nom_type_mesure_strategie) . "</span></td>
					<td style=\"background: #" . $Mesure[0]->couleur_mesure_strategie . ";padding: 5px;text-align: center;\"><span style=\"font-size: 10pt; font-family: arial;\"><input style=\"width: 60px; text-align: center;\" name=\"quantite[]\" value=\"" . $Rows[0]->nbr_prelevement_zone_travail_multi_row . "\"/></span></td>
					<td style=\"text-align: center;\" rowspan=\"" . count($Rows) . "\"><span style=\"font-size: 10pt; font-family: arial;\"><input name=\"date\" class=\"date\"/></span><br/><br/><select style=\"width: 90px;\" class=\"horaire\"><option></option><option value=\"matin\">Matin</option><option value=\"après-midi\">Après-midi</option></select></td>
					<td style=\"text-align: center;\" rowspan=\"" . count($Rows) . "\"><select class=\"electricite\" style=\"width: 65px;\"><option></option><option>Oui</option><option>Non</option></select></td>
					<td style=\"text-align: center;\"><input type=\"checkbox\" name=\"checkbox\" class=\"add_reservation\"/></td>
				</tr>";

				for ($count = 1, $finish = count($Rows); $count < $finish; $count++) {
					$Mesure = $modelStrategie->AfficheMesureStrategie($Rows[$count]->type_mesure_zone_travail_multi_row);
					$count_radio++;
					echo "
					<tr style=\"background: #" . $Mesure[0]->couleur_mesure_strategie . ";\">
						<td style=\"text-align: center;\"><span style=\"font-size: 10pt; font-family: arial;\">" . str_replace("Exigence réglementaire", "<SUP>R</SUP>", $Mesure[0]->nom_type_mesure_strategie) . "</span></td>
						<td style=\"text-align: center;\"><span style=\"font-size: 10pt; font-family: arial;\"><input style=\"width: 60px; text-align: center;\" name=\"quantite[]\" value=\"" . $Rows[$count]->nbr_prelevement_zone_travail_multi_row . "\"/></span></td>
						<td style=\"text-align: center;\"><input type=\"checkbox\" name=\"checkbox\" class=\"add_reservation\"/></td>
					</tr>";
				}
				echo "
				<tr><td colspan=\"6\">Commentaires / Autres mesures :  <textarea rows=\"2\" cols=\"500\" class=\"commentaire_commande\" style=\"height:25px; width: 650px;\"></textarea></td></tr>
			</table>";

				$RefProcessus = $modelStrategie->ListeZoneTravailMultiRefProcessus($oneDynamicTable->ID);
				if (count($RefProcessus) <> 0) {
					echo "
				<table style=\"width: 98%;\" class=\"table_gbmnet table_command\">
					<tr style=\"background: #F2F2F2;\">
						<td style=\"width: 24%;\"><span style=\" font-size: 11pt; font-weight: bold; font-family: times;\">Ref processus client</span></td>
						<td style=\"width: 44%;\"><span style=\" font-size: 11pt; font-weight: bold; font-family: times;\">Processus</span></td>
						<td style=\"width: 9%;\"><span style=\" font-size: 11pt; font-weight: bold; font-family: times;\">Horaire vaccations</span></td>
						<td style=\"width: 9%;\"><span style=\" font-size: 11pt; font-weight: bold; font-family: times;\">Nbr d'opérateur processus</span></td>
						<td style=\"width: 9%;\"><span style=\" font-size: 11pt; font-weight: bold; font-family: times;\">Durée de travail au processus (Heures) </span></td>
					</tr>";
					foreach ($RefProcessus as $oneRefProcessus) {
						echo "
						<tr>
							<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-family: arial; color: #0070C0;\">" . $oneRefProcessus->ref_processus_zone_travail_multi_ref_processus . "</span></td>
							<td style=\"text-align: left;\"><span style=\" font-size: 10pt; font-family: arial;\">Materiau : </span><span style=\" font-size: 10pt; font-family: arial; color: #0070C0;\">" . $oneRefProcessus->materiau_zone_travail_multi_ref_processus . "</span><br/><span style=\" font-size: 10pt; font-family: arial;\">Technique de retrait : </span><span style=\" font-size: 10pt; font-family: arial; color: #0070C0;\">" . $oneRefProcessus->technique_retrait_zone_travail_multi_ref_processus . "</span><br/><span style=\" font-size: 10pt; font-family: arial;\">Protection collective : </span><span style=\" font-size: 10pt; font-family: arial; color: #0070C0;\">" . $oneRefProcessus->protection_collective_zone_travail_multi_ref_processus . "</span></td>
							<td style=\"text-align: center;\"><input style=\"width: 80px;\" /></td>
							<td style=\"text-align: center;\"><input style=\"width: 80px;\" /></td>
							<td style=\"text-align: center;\"><input style=\"width: 80px;\" /></td>
							<td style=\"text-align: center;\"><input type=\"checkbox\" name=\"checkbox\" class=\"add_processus\"/></td>
						</tr>";
					}
					echo "
					<tr><td colspan=\"6\">Commentaires / Autres mesures :  <textarea rows=\"3\" cols=\"124\" class=\"commentaire_processus\" style=\"height:25px; width: 650px;\"></textarea></td></tr>
				</table>";
				}
				echo "
		</div>";
				$save_contexte = $contexte;
			} elseif ($oneDynamicTable->TYPE_TABLE == 3) {

				$Rows = $modelStrategie->ListeZoneTravailMultiRow($oneDynamicTable->ID);
				$Mesure = $modelStrategie->AfficheMesureStrategie($oneDynamicTable->CONTEXTE);

				foreach ($modelStrategie->ListeObjectifStrategieRow($oneDynamicTable->ID) as $oneRow) {
					$ZoneHomogene = $modelStrategie->AfficheZoneHomogene($oneRow->zone_homogene_objectif_strategie_row);
					$ZoneTravail = "";
					$separator = "";
					foreach ($modelStrategie->ListeZoneTravail($oneRow->zone_homogene_objectif_strategie_row) as $oneZoneTravail) {
						if ($ZoneTravail <> "") {
							$separator = ", ";
						}
						$ZoneTravail .= $separator . $oneZoneTravail->nom_zone_travail;
					}

					$contexte = $Mesure[0]->nom_pdf_contexte_mesure_strategie;
					if (($save_contexte <> $contexte) && ($count_table <> 1)) echo "</div>";
					if ($save_contexte <> $contexte) echo "<h3 class=\"level1\">" . $contexte . "</h3><div>";
					// <h3 class=\"level2\">".$ZoneHomogene[0]->nom_zone_homogene."  <span style=\" font-size: 8pt; font-family: arial;\">(".$ZoneTravail.")</span></h3>
					echo "
			<h3 class=\"level2\">" . $ZoneHomogene[0]->nom_zone_homogene . "</h3>
			<div>
				<table style=\"width: 98%;\" class=\"table_gbmnet table_command\">
					<tr style=\"background: #F2F2F2;\">
						<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Type de mesure</span></td>
						<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Qté</span></td>
						<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Date souhaitée</span></td>
						<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Electricité dispo</span></td>
						<td style=\"text-align: center;\"><input type=\"checkbox\" onChange=\"CheckAll(this);\"></td>
					</tr>";
					// foreach($modelStrategie->ListeObjectifStrategieRow($oneDynamicTable->ID) as $oneRow){
					// if($oneRow->exterieur_objectif_strategie_row == 1){$Exterieur = " (En extérieur)";}else{$Exterieur = "";}
					// if($oneRow->simulation_humaine_objectif_strategie_row == 1){$simulation_humaine = "Simulation";}else{$simulation_humaine = "Sans simulation";}

					// $frequence_objectif_strategie_row = $oneRow->frequence_objectif_strategie_row;
					// if($oneRow->frequence_objectif_strategie_row == "Facultatif*") $frequence_objectif_strategie_row = "Facultatif<SUP>(1)</SUP>";
					// if($oneRow->frequence_objectif_strategie_row == "0") $frequence_objectif_strategie_row = $oneRow->frequence_texte_objectif_strategie_row;
					// if($oneRow->frequence_objectif_strategie_row == "999") $frequence_objectif_strategie_row = "";

					$count_radio++;
					echo "
						<tr style=\"background: #" . $Mesure[0]->couleur_mesure_strategie . ";\">
							<td style=\"text-align: center;\"><span style=\"font-size: 10pt; font-family: arial;\">" . str_replace("Exigence réglementaire", "<SUP>R</SUP>", $Mesure[0]->nom_type_mesure_strategie) . "</span></td>
							<td style=\"text-align: center;\"><span style=\"font-size: 10pt; font-family: arial;\"><input style=\"width: 60px; text-align: center;\" name=\"quantite[]\" value=\"" . $oneRow->nbr_prelevement_objectif_strategie_row . "\"/></span></td>
							<td style=\"text-align: center;\"><span style=\"font-size: 10pt; font-family: arial;\"><input name=\"date\" class=\"date\"/></span><br/><br/><select style=\"width: 90px;\" class=\"horaire\"><option></option><option value=\"matin\">Matin</option><option value=\"après-midi\">Après-midi</option></select></td>
							<td style=\"text-align: center;\"><select class=\"electricite\" style=\"width: 65px;\"><option></option><option>Oui</option><option>Non</option></select></td>
							<td style=\"text-align: center;\"><input type=\"checkbox\" name=\"checkbox\" class=\"add_reservation\"/></td>
						</tr>";
					// }
					echo "
					<tr><td colspan=\"6\">Commentaires / Autres mesures :  <textarea rows=\"3\" cols=\"124\" class=\"commentaire_commande\" style=\"height:25px; width: 650px;\"></textarea></td></tr>
				</table>
			</div>";
					$save_contexte = $contexte;
				}
			} elseif ($oneDynamicTable->TYPE_TABLE == 4) {

				$Mesure = $modelStrategie->AfficheMesureStrategie($oneDynamicTable->CONTEXTE);

				foreach ($modelStrategie->ListeZoneTravailMonoRow($oneDynamicTable->ID) as $oneRow) {
					// if($oneRow->confinement_zone_travail == "0"){$zone_travail = nl2br($oneRow->nom_zone_travail ." - ". $oneRow->confinement_texte_zone_travail);}else{$zone_travail = nl2br($oneRow->nom_zone_travail ." - ". $oneRow->confinement_zone_travail);}
					$zone_travail = $oneRow->nom_zone_travail;
				}
				$contexte = $Mesure[0]->nom_pdf_contexte_mesure_strategie;
				if (($save_contexte <> $contexte) && ($count_table <> 1)) echo "</div>";
				if ($save_contexte <> $contexte) echo "<h3 class=\"level1\">" . $contexte . "</h3><div>";
				// <h3 class=\"level2\">" . $zone_travail . "</h3>
				echo "
				<h3 class=\"level2\"><span class=\"zone_fin_chantier\">" . $zone_travail . "</span> &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp; <span class=\"mesure_fin_chantier\">" . str_replace("Exigence réglementaire", "<SUP>R</SUP>", $Mesure[0]->nom_type_mesure_strategie) . "</span></h3>
			<div>
			<table style=\"width: 98%;\" class=\"table_gbmnet table_command\">
				<tr style=\"background: #F2F2F2;\">
					<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Type de mesure</span></td>
					<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Qté</span></td>
					<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Date souhaitée</span></td>
					<td style=\"text-align: center;\"><span style=\" font-size: 10pt; font-weight: bold; font-family: arial;\">Electricité dispo</span></td>
					<td style=\"text-align: center;\"><input type=\"checkbox\" onChange=\"CheckAll(this);\"></td>
				</tr>";
				foreach ($modelStrategie->ListeZoneTravailMonoRow($oneDynamicTable->ID) as $oneRow) {
					if ($oneRow->confinement_zone_travail == "0") {
						$zone_travail = nl2br($oneRow->nom_zone_travail . " - " . $oneRow->confinement_texte_zone_travail);
					} else {
						$zone_travail = nl2br($oneRow->nom_zone_travail . " - " . $oneRow->confinement_zone_travail);
					}
					if ($oneRow->exterieur_zone_travail_mono_row == 1) {
						$Exterieur = " (En extérieur)";
					} else {
						$Exterieur = "";
					}
					if ($oneRow->simulation_humaine_zone_travail_mono_row == 1) {
						$simulation_humaine = "Simulation";
					} else {
						$simulation_humaine = "Sans simulation";
					}

					$frequence_zone_travail_mono_row = $oneRow->frequence_zone_travail_mono_row;
					if ($oneRow->frequence_zone_travail_mono_row == "Facultatif*") $frequence_zone_travail_mono_row = "Facultatif<SUP>(1)</SUP>";
					if ($oneRow->frequence_zone_travail_mono_row == "0") $frequence_zone_travail_mono_row = $oneRow->frequence_texte_zone_travail_mono_row;
					if ($oneRow->frequence_zone_travail_mono_row == "999") $frequence_zone_travail_mono_row = "";

					$count_radio++;
					echo "
					<tr style=\"background: #" . $Mesure[0]->couleur_mesure_strategie . ";\">
						<td style=\"text-align: center;\"><span style=\"font-size: 10pt; font-family: arial;\">" . str_replace("Exigence réglementaire", "<SUP>R</SUP>", $Mesure[0]->nom_type_mesure_strategie) . "</span></td>
						<td style=\"text-align: center;\"><span style=\"font-size: 10pt; font-family: arial;\"><input style=\"width: 60px; text-align: center;\" name=\"quantite[]\" value=\"" . $oneRow->nbr_prelevement_zone_travail_mono_row . "\"/></span></td>
						<td style=\"text-align: center;\"><span style=\"font-size: 10pt; font-family: arial;\"><input name=\"date\" class=\"date\"/></span><br/><br/><select style=\"width: 90px;\" class=\"horaire\"><option></option><option value=\"matin\">Matin</option><option value=\"après-midi\">Après-midi</option></select></td>
						<td style=\"text-align: center;\"><select class=\"electricite\" style=\"width: 65px;\"><option></option><option>Oui</option><option>Non</option></select></td>
						<td style=\"text-align: center;\"><input type=\"checkbox\" name=\"checkbox\" class=\"add_reservation\"/></td>
					</tr>";
				}
				echo "
				<tr><td colspan=\"6\">Commentaires / Autres mesures :  <textarea rows=\"3\" cols=\"124\" class=\"commentaire_commande\" style=\"height:25px; width: 650px;\"></textarea></td></tr>
			</table>
		</div>";
				$save_contexte = $contexte;
			}
		}
	} else {
		//AFFICHAGE NOUVEAU FORMAT STRATEGIE

		$id_strategie = $stratV1->id;
		class PI_ZC
		{
			private $id;
			private $id_entite;
			private $type;
			private $nom;
			private $idContexte;
			private $lastPose;
			private $qteMEST;
			private $qtePTA;

			private static $key = 0;
			private static $store = [];
			private static $storeManager = [];

			#region GETTER / SETTER
			public function getId()
			{
				return $this->id;
			}

			public function getIdEntite()
			{
				return $this->id_entite;
			}

			public function getType()
			{
				return $this->type;
			}

			public function getNom()
			{
				return $this->nom;
			}

			public function getLastPose()
			{
				return $this->lastPose;
			}

			public function setLastPose($lastPose)
			{
				$this->lastPose = $lastPose;
			}

			public function getQteMEST()
			{
				return $this->qteMEST;
			}

			public function setQteMEST($qteMEST)
			{
				$this->qteMEST = $qteMEST;
			}

			public function getQtePTA()
			{
				return $this->qtePTA;
			}

			public function setQtePTA($qtePTA)
			{
				$this->qtePTA = $qtePTA;
			}


			public function getContexte()
			{
				return $this->idContexte;
			}


			public function setContexte($contexte)
			{
				$this->idContexte = $contexte;

				return $this;
			}
			#endregion

			// Le constructeur est maintenant privé pour contrôler la création via une méthode statique
			private function __construct($id, $id_entite, $type, $nom, $idContexte)
			{
				$this->id = $id;
				$this->id_entite = $id_entite;
				$this->type = $type;
				$this->nom = $nom;
				$this->idContexte = $idContexte;
				$this->lastPose = "01/01/0001";
				$this->qteMEST = 0;
				$this->qtePTA = 0;
			}

			// Méthode pour créer une nouvelle instance de PI_ZC
			public static function createPI_ZC($id_entite, $type, $nom, $idContexte)
			{
				// Vérifie si l'entité existe déjà
				if (self::checkExist($id_entite, $type, $idContexte)) {
					return false;
				}

				// Incrémente la clé pour créer un nouvel identifiant unique
				self::$key++;

				// Crée une nouvelle instance de PI_ZC
				$pi_zc = new PI_ZC(self::$key, $id_entite, $type, $nom, $idContexte);

				// Enregistre l'objet dans les tableaux statiques
				self::$storeManager[$id_entite][$type][$idContexte] = self::$key;
				self::$store[self::$key] = $pi_zc;

				// Retourne l'identifiant unique de l'objet créé
				return self::$key;
			}

			// Vérifie si une entité existe déjà dans le gestionnaire
			private static function checkExist($id_entite, $type, $idContexte)
			{
				return isset(self::$storeManager[$id_entite][$type][$idContexte]);
			}

			// Récupère un objet PI_ZC par son identifiant unique
			public static function getPI_ZC($id)
			{
				return isset(self::$store[$id]) ? self::$store[$id] : null;
			}

			// Cherche un objet PI_ZC par son id_entite et type
			public static function searchPI_ZC($id_entite, $type, $idContexte)
			{
				$id = isset(self::$storeManager[$id_entite][$type][$idContexte]) ? self::$storeManager[$id_entite][$type][$idContexte] : null;
				return $id !== null ? self::getPI_ZC($id) : null;
			}

			public static function ListPI_ZC()
			{
				return self::$store;
			}

			// Affiche les détails de l'objet sous forme de chaîne
			public function __toString()
			{
				return "ID: {$this->id}, Nom: {$this->nom}, Contexte: {$this->idContexte}, Type: {$this->type}, ID Entité: {$this->id_entite}";
			}
		}


		function getDateMax($date1, $date2)
		{
			$dateTime1 = DateTime::createFromFormat('d/m/Y', $date1);
			$dateTime2 = DateTime::createFromFormat('d/m/Y', $date2);

			// Comparer les objets DateTime
			if ($dateTime1 > $dateTime2) {
				return $date1;
			} else {
				return $date2;
			}
		}

		// =============================== Bon de commande ===============================

		$modelStrat = new StrategieChantierV1();

		$processusClient = $modelStrat->getProcessusClient($id_client);


		$list_mesure_strategie = $modelStrat->listMesureStrategie($id_strategie);

		$array_mesure_strategie = [];
		foreach ($list_mesure_strategie as $mesure_strategie) {
			$contexte = new stdClass();
			$contexte->id = $mesure_strategie->id_contexte_mesure_strategie;
			$contexte->nom = $mesure_strategie->nom_contexte_mesure_strategie;
			$contextes[$contexte->id] = $contexte;

			$zse = new stdClass();
			$zse->id = $mesure_strategie->id_zse;
			$zse->nom = $mesure_strategie->nom_zse;
			$zse->nom_mesure = $mesure_strategie->nom_type_mesure_strategie;
			$zse->total_pompe = $mesure_strategie->total_pompe;
			$zses[$zse->id] = $zse;

			$PI_ZC = PI_ZC::createPI_ZC(
				$mesure_strategie->id_zone,
				$mesure_strategie->type_zone,
				$mesure_strategie->nom_zone,
				$mesure_strategie->id_contexte_mesure_strategie
			);

			/* EN TROP POUR MOI .... A VOIR
			if (!$PI_ZC) {
				$obj_PI_ZC = PI_ZC::searchPI_ZC(
					// $mesure_strategie->id_perimetre,
					// $type
					$mesure_strategie->id_zone,
					$mesure_strategie->type_zone
				);
				$PI_ZC = $obj_PI_ZC->getId();
			}*/
			$array_mesure_strategie[$mesure_strategie->id_contexte_mesure_strategie][$PI_ZC][] = $zse;
		}

		/*foreach (PI_ZC::ListPI_ZC() as $pi_zc) {
			var_dump($pi_zc);
		}*/
		//die();

		/*$list_mesure_echantillon = StrategieChantierV1::listStrategieEchantillonCommande($id_strategie);
		// var_dump($list_mesure_echantillon);
		//die();
		$array_mesure_echantillon = [];
		foreach ($list_mesure_echantillon as $mesure_echantillon) {
			$id_entite = $mesure_echantillon->id_zone;
			$type = $mesure_echantillon->type_zone;

			$PI_ZC = PI_ZC::searchPI_ZC($id_entite, $type);			
			$array_mesure_echantillon[$PI_ZC->getId()][] = $mesure_echantillon;
		}	

		$list_mesure_echantillon_deleted = StrategieChantierV1::listStrategieEchantillonCorbeille($id_strategie);
		$array_mesure_echantillon_deleted = [];
		if ($list_mesure_echantillon_deleted != null) {
			foreach ($list_mesure_echantillon_deleted as $mesure_echantillon_deleted) {
				$id_entite = $mesure_echantillon_deleted->id_zone;
				$type = $mesure_echantillon_deleted->type_zone;

				$PI_ZC = PI_ZC::searchPI_ZC($id_entite, $type);
				if ($PI_ZC != null) {
					$array_mesure_echantillon_deleted[$PI_ZC->getId()][] = $mesure_echantillon_deleted;
				}
			}
		}*/

		// $list_mesure_echantillon_non_commande = StrategieChantierV1::listStrategieEchantillonNonCommande($id_strategie);
		$list_mesure_echantillon_non_commande = StrategieChantierV1::listStrategieEchantillonRecap($id_strategie);
		$array_mesure_echantillon_non_commande = [];
		if ($list_mesure_echantillon_non_commande != null) {
			foreach ($list_mesure_echantillon_non_commande as $mesure_echantillon_non_commande) {
				$id_entite = $mesure_echantillon_non_commande->id_zone;
				$type = $mesure_echantillon_non_commande->type_zone;

				$PI_ZC = PI_ZC::searchPI_ZC($id_entite, $type, $mesure_echantillon_non_commande->id_contexte);
				if ($PI_ZC != null) {
					$array_mesure_echantillon_non_commande[$PI_ZC->getId()][] = $mesure_echantillon_non_commande;
				}
			}
		}

		$list_mesure_echantillon_non_commande_processus = StrategieChantierV1::listStrategieEchantillonRecapProcessus($id_strategie);
		// var_dump($list_mesure_echantillon_non_commande_processus);
		// die("sui");
		$array_mesure_echantillon_non_commande_processus = [];
		if ($list_mesure_echantillon_non_commande_processus != null) {
			foreach ($list_mesure_echantillon_non_commande_processus as $mesure_echantillon_non_commande_processus) {
				$id_entite = $mesure_echantillon_non_commande_processus->id_zone;
				$type = $mesure_echantillon_non_commande_processus->type_zone;

				$PI_ZC = PI_ZC::searchPI_ZC($id_entite, $type, $mesure_echantillon_non_commande_processus->id_contexte);
				if ($PI_ZC != null) {
					$array_mesure_echantillon_non_commande_processus[$PI_ZC->getId()][] = $mesure_echantillon_non_commande_processus;
				}
			}
		}


		$html = "";

		foreach ($array_mesure_strategie as $id_contexte => $oneContexte) {
			$html .= '<div class="accordion">';
			$html .= ' <div class="accordion-title h1"> ' . $contextes[$id_contexte]->nom . '</div><div>';

			foreach ($oneContexte as $id_PI_ZC => $ZSEs) {
				//var_dump($id_PI_ZC);
				//var_dump($ZSEs);

				$PI_ZC = PI_ZC::getPI_ZC($id_PI_ZC);
				// var_dump($PI_ZC);
				if ($PI_ZC != null) {

					$classColor = "";
					/*if (count($array_mesure_echantillon_non_commande[$id_PI_ZC]) > 0) {
						$classColor = "red_tab";
					}*/

					$html .= '<div class="accordion">';
					$html .= '<div class="accordion-title h1 ' . $classColor . '">' . $PI_ZC->getNom();
					if ($PI_ZC->getLastPose() != "01/01/0001") {
						$html .= '<span style="float:right;">Dernière Pose : ' . $PI_ZC->getLastPose() . ' </span>';
					}
					$html .= '</div>';

					$html .= '<div class="accordion-content">';

					//tableau des mesures préconisés mais non commandés 
					if (count($array_mesure_echantillon_non_commande[$id_PI_ZC]) > 0) {
						$html .= '<table class="table_gbmnet table_echantillon" style="width:85%;">';

						$html .= '<tr>';
						$html .= '<td> Zone </td>';
						$html .= '<td> Type de Mesure</td>';
						$html .= '<td> Qte Préconisé </td>';
						$html .= '<td> Qte Déjà Réalisé </td>';
						$html .= '<td> Qte à Commander : </td>';
						$html .= '</tr>';

						foreach ($array_mesure_echantillon_non_commande[$id_PI_ZC] as $echantillon) {

							$html .= '<tr id="td_' . $echantillon->id_echantillon . '" style="background:' . $echantillon->couleur_mesure . ';">';
							$html .= '<td> ' . $echantillon->nom_zse_zt . '</td>';
							$html .= '<td> ' . $echantillon->type_mesure . '</td>';
							$html .= '<td> ' . $echantillon->quantite_totale . '</td>';
							$html .= '<td> ' . $echantillon->quantite_realise . '</td>';
							/*$difference = $echantillon->quantite_totale - $echantillon->quantite_realise;
							if ($difference < 0) {
								$difference = 0;
							}*/
							$difference = 0;
							$html .= '<td> <input type="text" class="inQte" value="' . $difference . '" data-mesure="' . $echantillon->type_mesure . '" data-zone="' . $echantillon->nom_zse_zt . '" data-idpizc="' . $id_PI_ZC . '" data-contexte="' . $contextes[$id_contexte]->nom . '" data-zt="' . $PI_ZC->getNom() . '" /> </td>';
							$html .= '</tr>';
						}
						$html .= '</table>';

						$html .= '<table class="tableForm" style="width:85%;">';
						$html .= '<tr>';
						$html .= "<td><label>Date Souhaitée : </label></td>";
						$html .= "<td><input type='date' id='date_" . $id_PI_ZC . "' /></td>";
						$html .= '</tr>';

						$html .= '<tr>';
						$html .= "<td><label> Moment : </label></td>";
						$html .= "<td><select id='slMoment_" . $id_PI_ZC . "'><option value='empty'> - - - </option> <option value='Matin'>Matin</option> <option value='Après-midi'>Après-midi</option>  </select></td></tr>";

						$html .= '<tr>';
						$html .= '<td><label>Electricité Disponible :</label></td>';
						$html .= "<td><select id='slElec_" . $id_PI_ZC . "'> <option value='empty'> - - - </option> <option value='Oui'>Oui</option> <option value='Non'>Non</option>  </select></td>";
						$html .= '</tr>';

						$html .= '<tr>';
						$html .= '<td><label> Commentaires / Autres mesures : </label> </td>';
						$html .= '<td><textarea class="taComm" id="taComm_' . $id_PI_ZC . '" style="width:80%;height:80px;"></textarea></td>';
						$html .= '</tr>';
						$html .= '</table>';
					}

					//tableau des mesures préconisés processus mais non commandés 
					if (isset($array_mesure_echantillon_non_commande_processus[$id_PI_ZC]) && count($array_mesure_echantillon_non_commande_processus[$id_PI_ZC]) > 0) {
						$html .= '<table class="table_gbmnet table_echantillon" style="width:100%;">';

						$html .= '<tr>';
						$html .= '<td> Zone </td>';
						$html .= '<td> Type de Mesure</td>';
						$html .= '<td> Quantités </td>';
						$html .= '<td> Horaires Vaccations : </td>';
						$html .= '<td> Nbr Opérateurs : </td>';
						$html .= '<td> Durée de travail au processus (Heures): </td>';
						$html .= '</tr>';

						foreach ($array_mesure_echantillon_non_commande_processus[$id_PI_ZC] as $echantillon) {

							$html .= '<tr id="td_' . $echantillon->id_echantillon . '" style="background:' . $echantillon->couleur_mesure . ';" >';
							$html .= '<td> ' . $echantillon->nom_zse_zt . '</td>';
							$html .= '<td> ' . $echantillon->type_mesure . ' <button class="ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow" onClick="voirProcessus(' . $echantillon->id_processus . ')">Détails</button></td>';
							$html .= '<td><table>';

							$html .= '<tr>';
							$html .= '<td>Préconisé :</td>';
							$html .= '<td> ' . $echantillon->quantite_totale . '</td>';
							$html .= '</tr>';

							$html .= '<tr>';
							$html .= '<td>Réalisé :</td>';
							$html .= '<td> ' . $echantillon->quantite_realise . '</td>';
							$html .= '</tr>';

							$html .= '<tr>';
							$html .= '<td style="width:200px;">A Commander :</td>';
							$html .= '<td> <input type="text" style="width:35px;" maxlength="3" class="inQteProcessus" value="' . $difference . '" data-idmhs="' . $echantillon->id_mhs . '" data-mesure="' . $echantillon->type_mesure . '" data-zone="' . $echantillon->nom_zse_zt . '" data-idpizc="' . $id_PI_ZC . '" data-contexte="' . $contextes[$id_contexte]->nom . '" data-zt="' . $PI_ZC->getNom() . '" /> </td>';
							$html .= '</tr>';

							$html .= '</table></td>';

							$html .= '<td><input id="inHeureProc_' . $echantillon->id_mhs . '" type="text" style="width:100px;" /></td>';
							$html .= '<td><input id="inOperateurProc_' . $echantillon->id_mhs . '" type="text" style="width:35px;" maxlength="3"  /></td>';
							$html .= '<td><input id="inDureeProc_' . $echantillon->id_mhs . '" type="text" style="width:100px;"  /></td>';
							$html .= '</tr>';
						}
						$html .= '</table>';

						$html .= '<table class="tableForm" style="width:85%;">';
						$html .= '<tr>';
						$html .= '<td><label> Commentaires / Autres mesures : </label> </td>';
						$html .= '<td><textarea class="taComm" id="taCommProc_' . $id_PI_ZC . '" style="width:80%;height:80px;"></textarea></td>';
						$html .= '</tr>';
						$html .= '</table>';
					}


					$html .= '</div>';
					$html .= '</div>';
				}
			}

			$html .= '</div></div>';
		}
		echo $html;
	}


	echo '<input id="agence_chantier" value="' . $Chantier[0]->agence_chantier . '" style="display: none;">';

	?>
</div>

<div>
	<button class="ceapicworld_button_radius ceapicworld_button_green ceapicworld_button_shadow" style="float: right; margin-top: 10px;" onClick="ValiderReservation(<?= $typeStrategie ?>)"><i class="fa fa-envelope-o"></i> Envoyer</button>
</div>

<div id="infoProcessus" title="Informations Processus" class="hide">
	<table class="table_gbmnet">
		<thead>
			<tr>
				<td>Référence</td>
				<td>Informations</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<label id="proc_reference"></label>
				</td>
				<td style="text-align: left;">
					<span style=" font-size: 10pt; font-family: arial;">Materiau : </span>
					<span id="proc_materiau" style=" font-size: 10pt; font-family: arial; color: #0070C0;"></span><br>
					<span style=" font-size: 10pt; font-family: arial;">Technique de retrait : </span>
					<span id="proc_technique" style=" font-size: 10pt; font-family: arial; color: #0070C0;"></span><br>
					<span style=" font-size: 10pt; font-family: arial;">Protection : </span>
					<span id="proc_protection" style=" font-size: 10pt; font-family: arial; color: #0070C0;"></span><br>
					<span style=" font-size: 10pt; font-family: arial;">Captage : </span>
					<span id="proc_captage" style=" font-size: 10pt; font-family: arial; color: #0070C0;"></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div id="destinataire" title="Information nécessaire pour la réservation" class="hide">
	<fieldset>
		<legend>Qui êtes-vous?</legend>
		<select id="identite_reservation">
			<option value="0"></option>
			<option value="Autre"><b>Autre</b></option>
			<?php foreach ($modelStrategie->ListeContactChantier($Chantier[0]->id_chantier) as $oneContact) { ?>
				<option value="<?php echo $oneContact->nom_contact . ";" . $oneContact->prenom_contact . ";" . $oneContact->mobile_contact . ";" . $oneContact->mail_contact . ";" . $oneContact->mail2_contact; ?>"><?php echo $oneContact->nom_contact . " " . $oneContact->prenom_contact . " " . $oneContact->mobile_contact . " " . $oneContact->mail_contact; ?></option>
			<?php } ?>
		</select>
		<dl id="identite_form" class="hide">
			<dt>Nom</dt>
			<dd><input id="nom_reservation" /></dd>
			<dt>Prénom</dt>
			<dd><input id="prenom_reservation" /></dd>
			<dt>Telephone</dt>
			<dd><input id="telephone_reservation" /></dd>
			<dt>Mail</dt>
			<dd><input id="mail_reservation" /></dd>
		</dl>
	</fieldset>

	<fieldset>
		<legend>Destinataire en copie du mail de commande</legend>
		<?php
		$count_checkbox = 0;
		foreach ($modelStrategie->ListeContactChantier($Chantier[0]->id_chantier) as $oneContact) {
			$count_checkbox++;
		?>
			<input type="checkbox" id="contact_mail_<?php echo $count_checkbox; ?>" class="contact_mail" value="<?php echo $oneContact->mail_contact; ?>"> <label style="display: inline;" for="contact_mail_<?php echo $count_checkbox; ?>"><?php echo $oneContact->nom_contact . " " . $oneContact->prenom_contact . " " . $oneContact->mail_contact; ?></label><br />
		<?php } ?>

	</fieldset>

	<fieldset>
		<legend>Contact sur chantier</legend>

		<?php
		$count_checkbox = 0;
		foreach ($modelStrategie->ListeContactSite($Chantier[0]->id_chantier) as $oneContact) {
			$count_checkbox++;
		?>
			<input type="checkbox" id="contact_chantier_<?php echo $count_checkbox; ?>" class="contact_chantier" value="<?php echo $oneContact->nom_contact . ";" . $oneContact->prenom_contact . ";" . $oneContact->mobile_contact . ";" . $oneContact->mail_contact; ?>"> <label style="display: inline;" for="contact_chantier_<?php echo $count_checkbox; ?>"><?php echo $oneContact->nom_contact . " " . $oneContact->prenom_contact . " " . $oneContact->mobile_contact . " " . $oneContact->mail_contact; ?></label><br />
		<?php } ?>
		<input type="checkbox" id="autre_chantier" value="Autre"> <label style="display: inline;" for="autre_chantier">Autre</label><br />
		<dl id="contact_chantier_form" class="hide">
			<dt>Nom</dt>
			<dd><input id="nom_contact_chantier" /></dd>
			<dt>Prénom</dt>
			<dd><input id="prenom_contact_chantier" /></dd>
			<dt>Telephone</dt>
			<dd><input id="telephone_contact_chantier" /></dd>
			<dt>Mail</dt>
			<dd><input id="mail_contact_chantier" /></dd>
		</dl>
	</fieldset>
	<button class="ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow" style="float: right; margin-top: 10px;" onClick="ValiderDestinataire()"><i class="fa fa-check"></i> Valider</button>
</div>

<script language="javascript" type="text/javascript">
	var processusClients = <?php echo json_encode($processusClient); ?>;

	jQuery(document).ready(function() {
		initAccordeon();
	});

	function voirProcessus(idProcessus) {
		var processus = getProcessusClient(idProcessus);
		jQuery('#proc_reference').text(processus.reference_client);
		jQuery('#proc_materiau').text(processus.nomMateriaux);
		jQuery('#proc_technique').text(processus.nomTechniques);
		jQuery('#proc_protection').text(processus.protection);
		jQuery('#proc_captage').text(processus.captage);

		jQuery('#infoProcessus').dialog({
			autoOpen: true,
			modal: true,
			width: 1000,
			buttons: null
		});
	}

	function getProcessusClient(idProcessus) {
		var processus = processusClients.filter(function(processus) {
			return processus.id == idProcessus;
		});
		return processus[0];
	}

	function initAccordeon() {
		jQuery('.accordion').accordion({
			active: false, //all closed by default
			collapsible: true,
			heightStyle: "content"
		});
	}

	jQuery(function() {
		jQuery("#identite_reservation").on("change", function() {
			if (jQuery(this).val() == "Autre") {
				jQuery("#identite_form").show();
			} else {
				jQuery("#identite_form").hide();
			}
		});

		jQuery("#autre_chantier").on("change", function() {
			if (jQuery(this).is(':checked')) {
				jQuery("#contact_chantier_form").show();
			} else {
				jQuery("#contact_chantier_form").hide();
			}
		});

		jQuery("#destinataire").dialog({
			autoOpen: false,
			width: 'auto',
			modal: true
		});

		jQuery(".date").each(function() {
			jQuery(this).css('background-color', '#FFFFFF');
			jQuery(this).css('cursor', 'pointer');
			jQuery(this).css('width', '80px');
			jQuery(this).css('text-align', 'center');
			jQuery(this).attr('readonly', true);
			jQuery(this).datepicker({
				dateFormat: 'dd-mm-yy',
				showButtonPanel: true,
				showAnim: 'clip',
			});
		});

		// ==================================================
		// Mettre dans l'ordre et trier les TAB
		// ==================================================
		var structure = [];
		jQuery('.level1').each(function() {
			structure.push(jQuery(this).text());
		});

		structure.sort();
		var current = "";
		var new_strcture = [];
		for (i = 0; i < structure.length; i++) {
			if (current != structure[i])
				new_strcture.push(structure[i]);
			current = structure[i];
		}

		for (i = 0; i < new_strcture.length; i++) {
			var count = 0;
			jQuery('.level1').each(function() {
				if (jQuery(this).text() == new_strcture[i]) {
					count++;
					current_contexte = jQuery(this);
					if (count > 1) {
						current_contexte.next().find('h3.level2').each(function() {
							ref_contexte.next().append(jQuery(this), jQuery(this).next());
						});
						current_contexte.next().remove();
						current_contexte.remove();
					} else {
						ref_contexte = jQuery(this);
					}
				}
			});
		}
		// ==================================================

		// ==================================================
		// Affiche les red TAB
		// ==================================================
		jQuery("#notaccordion-done").find(".red_tab").each(function() {
			red_tab_contexte = jQuery(this).parent().prev('h3.h3_contexte').text();
			red_tab_zone = jQuery(this).closest('h3.h3_zone').text();
			// alert(red_tab_contexte+','+red_tab_zone);
			jQuery('.level2').each(function() {
				contexte = jQuery(this).parent().prev('h3.level1').text();
				zone = jQuery(this).closest('h3.level2').text();
				// alert(contexte+','+zone);
				if ((contexte == red_tab_contexte) && (zone == red_tab_zone))
					jQuery(this).removeClass("red_tab").addClass("red_tab");
			});
		});
		// ==================================================

		// ==================================================
		// Affiche les red TAB fin de chantier
		// ==================================================
		jQuery(".zone_fin_chantier").each(function() {
			var current_tab = jQuery(this).parent();
			var zone_fin_chantier = jQuery(this).text();
			var mesure_fin_chantier = jQuery(this).parent().find(".mesure_fin_chantier").text();
			jQuery("h3.h3_zone").find("span:eq(1)").each(function() {
				var current_zone = jQuery(this).text();
				if (zone_fin_chantier == current_zone) {
					jQuery(this).parent().next("div").find("table.to_command tr").each(function() {
						if (jQuery(this).find("td:eq(0)").text() == mesure_fin_chantier)
							current_tab.removeClass("red_tab").addClass("red_tab");
					});
				}
			});
		});
		// ==================================================

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
			});
		};

		jQuery("#notaccordion").togglepanels();
	});

	function ValiderReservation(typeStrategie) {

		if (typeStrategie == 1) {
			var count_table = 0;
			jQuery("#notaccordion").find('.level2').each(function() {
				if (jQuery(this).next().find('.add_reservation:checked').length > 0) count_table++;
			});

			if (count_table > 0) {
				jQuery("#destinataire").dialog("open");
			} else {
				alert("Veuillez cocher une mesure, pour pousuivre la réservation");
			}
		}

		if (typeStrategie == 2) {
			let qteMesure = 0;
			jQuery('.inQte').each(function() {
				if (jQuery(this).val() > 0) {
					qteMesure += parseInt(jQuery(this).val());
					//jQuery(this).closest('tr').removeClass('mesure_ko').addClass('mesure_ok');
				}
			});

			jQuery('.inQteProcessus').each(function() {
				if (jQuery(this).val() > 0) {
					qteMesure += parseInt(jQuery(this).val());
					//jQuery(this).closest('tr').removeClass('mesure_ko').addClass('mesure_ok');
				}
			});

			let qteLibre = false;
			jQuery('.taComm').each(function() {
				if (jQuery(this).val() != "") {
					qteLibre = true;
				}
			});

			if (qteMesure == 0 && qteLibre == false) {
				alert("Veuillez renseigner une quantité à commander");
			} else {
				jQuery("#destinataire").dialog("open");
			}
		}
	}

	function ValiderDestinataire() {
		var validation_destinataire = 0;
		var validation_contact_chantier = 0;
		var destinataire = "";
		if ((jQuery('#identite_reservation').val() != "0") && (jQuery('#identite_reservation').val() != "Autre")) {
			destinataire = jQuery('#identite_reservation').val();
			validation_destinataire = 1;
		}

		if (jQuery('#identite_reservation').val() == "Autre") {
			if ((jQuery('#nom_reservation').val() != "") && (jQuery('#prenom_reservation').val() != "") && (jQuery('#telephone_reservation').val() != "") && (jQuery('#mail_reservation').val() != "")) {
				destinataire = jQuery('#nom_reservation').val() + ";" + jQuery('#prenom_reservation').val() + ";" + jQuery('#telephone_reservation').val() + ";" + jQuery('#mail_reservation').val();
				validation_destinataire = 1;
			}
		}

		var contact_mail = "";
		var string_split = '';
		jQuery('.contact_mail:checked').each(function() {
			contact_mail = contact_mail + string_split + jQuery(this).val();
			string_split = '|';
		});

		var contact_chantier = "";
		var string_split = '';
		jQuery('.contact_chantier:checked').each(function() {
			contact_chantier = contact_chantier + string_split + jQuery(this).val();
			string_split = '|';
			validation_contact_chantier = 1;
		});

		if (jQuery('#autre_chantier').is(':checked')) {
			if ((jQuery('#nom_contact_chantier').val() != "") && (jQuery('#prenom_contact_chantier').val() != "") && (jQuery('#telephone_contact_chantier').val() != "") && (jQuery('#mail_contact_chantier').val() != "")) {
				contact_chantier = contact_chantier + string_split + jQuery('#nom_contact_chantier').val() + ";" + jQuery('#prenom_contact_chantier').val() + ";" + jQuery('#telephone_contact_chantier').val() + ";" + jQuery('#mail_contact_chantier').val();
				validation_contact_chantier = 1;
			}
		}

		if ((validation_destinataire == 1) && (validation_contact_chantier == 1)) {
			jQuery("#destinataire").dialog("close");

			var count_table = 0;
			jQuery("#div_message_commande").empty();
			var table = '<STYLE>table,table tr, table tr,td{border:solid 1px black;} .reservation{margin-top: 15px; border-collapse: collapse;} .reservation .tr_titre{background: #F2F2F2;} .reservation .span_titre{font-size: 12pt; color: #0070C0; font-family: arial; font-weight: bold;} .reservation TD{border:1px solid; padding: 5px; text-align: center;}</STYLE>';

			//OLD VERSION
			jQuery("#notaccordion").find('.level2').each(function() {
				var contexte = jQuery(this).parent().prev('h3.level1').text();
				var zone = jQuery(this).closest('h3.level2').text();
				var commentaire = jQuery(this).next().find('.commentaire_commande').val();
				var commentaire_processus = jQuery(this).next().find('.commentaire_processus').val();
				if (jQuery(this).next().find('.add_reservation:checked').length > 0) {
					count_table++;
					table += '<TABLE class="reservation"><TR class="tr_titre"><TD colspan="5"><span class="span_titre">' + contexte + ' : ' + zone + '</span></TD></TR>';
					table += '<TR><TD>Type de mesure</TD><TD>Qté</TD><TD>Date</TD><TD>Horaire</TD><TD>Electricité dispo</TD></TR>';

					jQuery(this).next().find('.add_reservation:checked').each(function() {
						// alert(contexte +' === '+ zone +' === '+ commentaire);
						var mesure = jQuery(this).closest('tr').find('td:eq(0)').text();
						var quantite = jQuery(this).closest('tr').find('td:eq(1) input').val();
						// var frequence = jQuery(this).closest('tr').find('td:eq(2)').text();
						var date = jQuery(this).closest('table').find('input.date').val();
						var horaire = jQuery(this).closest('table').find('select.horaire').val();
						var electricite = jQuery(this).closest('table').find('select.electricite').val();
						table += '<TR><TD>' + mesure + '</TD><TD>' + quantite + '</TD><TD>' + date + '</TD><TD>' + horaire + '</TD><TD>' + electricite + '</TD></TR>';
					});

					if (commentaire.length > 0) {
						table += '<TR class="tr_titre"><TD colspan="6"><span class="span_titre">Commentaire</span></TD></TR>';
						table += '<TR><TD colspan="6">' + nl2br(commentaire) + '</TD></TR>';
					}

					if (jQuery(this).next().find('.add_processus:checked').length > 0) {
						table += '<TR class="tr_titre"><TD colspan="6"><span class="span_titre">Processus</span></TD></TR>';
						table += '<TR><TD>Ref processus client</TD><TD>Processus</TD><TD>Horaire vaccations</TD><TD>Nbr d\'opérateur processus</TD><TD>Durée de travail au processus (Heures)</TD><TD></TD></TR>';

						jQuery(this).next().find('.add_processus:checked').each(function() {
							var ref_processus = jQuery(this).closest('tr').find('td:eq(0)').text();
							var processus = jQuery(this).closest('tr').find('td:eq(1)').html();
							var horaire = jQuery(this).closest('tr').find('td:eq(2) input').val();
							var nbr_processus = jQuery(this).closest('tr').find('td:eq(3) input').val();
							var duree_processus = jQuery(this).closest('tr').find('td:eq(4) input').val();
							table += '<TR><TD>' + ref_processus + '</TD><TD style="border:1px solid; padding: 5px; text-align: left;">' + processus + '</TD><TD>' + horaire + '</TD><TD>' + nbr_processus + '</TD><TD>' + duree_processus + '</TD><TD></TD></TR>';
						});
					}

					if ((typeof commentaire_processus !== 'undefined') && (commentaire_processus.length > 0)) {
						table += '<TR class="tr_titre"><TD colspan="6"><span class="span_titre">Commentaire processus</span></TD></TR>';
						table += '<TR><TD colspan="6">' + nl2br(commentaire_processus) + '</TD></TR>';
					}

					table += '</TABLE><BR/>';
				}
			});

			//NEW VERSION
			let datas = [];
			let datasProc = [];
			let idPI_ZCs = [];
			let contextes = [];
			let zts = [];
			let assocTab = [];

			jQuery('.inQte').each(function() {
				if (jQuery(this).val() > 0) {
					let idPI_ZC = jQuery(this).data('idpizc');
					if (!idPI_ZCs.includes(idPI_ZC)) {
						idPI_ZCs.push(idPI_ZC);
					}

					let contexte = jQuery(this).data('contexte');
					if (!contextes.includes(contexte)) {
						contextes.push(contexte);
					}

					let zt = jQuery(this).data('zt');
					if (!zts.includes(zt)) {
						zts.push(zt);
					}

					let assocTemp = {
						contexte: jQuery(this).data('contexte'),
						zt: jQuery(this).data('zt')
					}
					if (!assocTab.some(item => item.contexte === assocTemp.contexte && item.zt === assocTemp.zt)) {
						assocTab.push(assocTemp);
					}

					let objTemp = {
						contexte: jQuery(this).data('contexte'),
						zt: jQuery(this).data('zt'),
						idPI_ZC: idPI_ZC,
						qte: jQuery(this).val(),
						mesure: jQuery(this).data('mesure'),
						zone: jQuery(this).data('zone')
					};
					datas.push(objTemp);
				}
			});

			jQuery('.inQteProcessus').each(function() {
				if (jQuery(this).val() > 0) {
					let idPI_ZC = jQuery(this).data('idpizc');
					if (!idPI_ZCs.includes(idPI_ZC)) {
						idPI_ZCs.push(idPI_ZC);
					}

					let contexte = jQuery(this).data('contexte');
					if (!contextes.includes(contexte)) {
						contextes.push(contexte);
					}

					let zt = jQuery(this).data('zt');
					if (!zts.includes(zt)) {
						zts.push(zt);
					}

					let assocTemp = {
						contexte: jQuery(this).data('contexte'),
						zt: jQuery(this).data('zt')
					}
					if (!assocTab.some(item => item.contexte === assocTemp.contexte && item.zt === assocTemp.zt)) {
						assocTab.push(assocTemp);
					}

					let idMhs = jQuery(this).data('idmhs');

					let objTemp = {
						contexte: jQuery(this).data('contexte'),
						zt: jQuery(this).data('zt'),
						idPI_ZC: idPI_ZC,
						qte: jQuery(this).val(),
						mesure: jQuery(this).data('mesure'),
						zone: jQuery(this).data('zone'),
						horaire: jQuery('#inHeureProc_' + idMhs).val(),
						operateur: jQuery('#inOperateurProc_' + idMhs).val(),
						duree: jQuery('#inDureeProc_' + idMhs).val()
					};
					datasProc.push(objTemp);
				}
			});

			let html = "<h3>Mesures Commandées : </h3>";
			contextes.each(function(contexte) {
				html += "<div style='border:solid 1px blue;margin:10px;padding:10px;'><h2> Contexte: " + contexte + " </h2>";

				zts.each(function(zt) {
					//test si des datas dans cette zt
					if (assocTab.some(item => item.contexte === contexte && item.zt === zt)) {
						html += "<h3> Zone Chantier : " + zt + "</h3>";

						let htmlTable = "";
						htmlTable += '<table class="gbmnet_table">';
						htmlTable += '<tr>';
						htmlTable += '<td> Zone </td>';
						htmlTable += '<td> Type de Mesure</td>';
						htmlTable += '<td> Qte Commandé </td>';
						htmlTable += '</tr>';

						let idPI = 0;
						let hasLigne = false;
						datas.each(function(data) {
							if (data.contexte == contexte && data.zt == zt) {
								idPI = data.idPI_ZC;
								hasLigne = true;
								htmlTable += '<tr>';
								htmlTable += '<td> ' + data.zone + '</td>';
								htmlTable += '<td> ' + data.mesure + '</td>';
								htmlTable += '<td> ' + data.qte + '</td>';
								htmlTable += '</tr>';
							}
						});
						htmlTable += '</table>';

						if (hasLigne) {
							let date = jQuery('#date_' + idPI).val();
							let moment = jQuery('#slMoment_' + idPI).val();
							let elec = jQuery('#slElec_' + idPI).val();
							let commentaires = jQuery('#taComm_' + idPI).val();

							html += '<table class="tableForm" style="width:85%;">';
							html += '<tr><td style="width:150px;"><label> Date souhaitée : </td><td>' + date + ' </label></td></tr>';
							html += "<tr><td><label> Moment souhaitée : </td><td>" + moment + "</label></td></tr>";
							html += "<tr><td><label> Electricité Disponible : </td><td>" + elec + "</label></td></tr>";
							html += "<tr><td><label> Commentaires : </td><td>" + commentaires + "</label></td></tr></table></table>";
							html += htmlTable;
							html += "<br/>";
						}

						let htmlTableProcLignes = "";
						idPI = 0;
						datasProc.each(function(data) {
							if (data.contexte == contexte && data.zt == zt) {
								idPI = data.idPI_ZC;
								htmlTableProcLignes += '<tr>';
								htmlTableProcLignes += '<td> ' + data.zone + '</td>';
								htmlTableProcLignes += '<td> ' + data.mesure + '</td>';
								htmlTableProcLignes += '<td> ' + data.qte + '</td>';
								htmlTableProcLignes += '<td> ' + data.horaire + '</td>';
								htmlTableProcLignes += '<td> ' + data.operateur + '</td>';
								htmlTableProcLignes += '<td> ' + data.duree + '</td>';
								htmlTableProcLignes += '</tr>';
							}
						});
						if (htmlTableProcLignes != "") {
							let commentaires = jQuery('#taCommProc_' + idPI).val();

							html += '<table class="gbmnet_table" style="width:85%;">';
							html += '<tr>';
							html += '<td> Zone </td>';
							html += '<td> Type de Mesure</td>';
							html += '<td> Qte Commandé </td>';
							html += '<td> Horaire Vaccations</td>';
							html += '<td> Nbr Opérateurs</td>';
							html += '<td> Durée de travail au processus (Heures) </td>';
							html += '</tr>';
							html += htmlTableProcLignes;
							html += '</table>';
							html += '<table class="tableForm" style="width:85%;">';
							html += "<tr><td><label> Commentaires : </td><td>" + commentaires + "</label></td></tr></table></table>";

						}
					}
				});
				html += "</div>";
			});
			table += html;

			jQuery('#div_message_commande').append("<h1>Chantier : " + jQuery('#chantier_selected').text() + '[lt]br[gt][lt]br[gt]' + "</h1>");
			jQuery('#div_message_commande').append(table);
			var data_reservation = encodeURIComponent(jQuery('#div_message_commande').html().replace(/</g, '[lt]').replace(/>/g, '[gt]'));
			// let url = "index.php?option=com_ceapicworld&task=SendReservation&format=raw&agence=" + jQuery('#agence_chantier').val() + "&data_reservation=" + data_reservation + "&destinataire=" + encodeURIComponent(destinataire) + "&contact_mail=" + encodeURIComponent(contact_mail) + "&contact_chantier=" + encodeURIComponent(contact_chantier) + "&ville_chantier=" + encodeURIComponent("<?php echo $Chantier[0]->ville_chantier; ?>") + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
			// console.log(url);
			jQuery.ajax({
				url: "index.php?option=com_ceapicworld&task=SendReservation&format=raw&agence=" + jQuery('#agence_chantier').val() + "&data_reservation=" + data_reservation + "&destinataire=" + encodeURIComponent(destinataire) + "&contact_mail=" + encodeURIComponent(contact_mail) + "&contact_chantier=" + encodeURIComponent(contact_chantier) + "&ville_chantier=" + encodeURIComponent("<?php echo $Chantier[0]->ville_chantier; ?>") + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>",

				success: function(data) {
					alert("Message envoyé");

					/*if (data == "true") {
					} else {
						//console.log(data);
						alert("Attention, le message n'a pas été envoyé");
					}*/
					jQuery("#commande_chantier_loader").dialog("close");
				},
				error: function(data) {
					alert("Attention, le message n'a pas été envoyé");
					jQuery("#commande_chantier_loader").dialog("close");
				}
			});

		} else {
			if ((validation_destinataire == 0) && (validation_contact_chantier == 0)) {
				alert("Veuillez indiquer qui vous êtes et le contact sur site");
			} else {
				if (validation_destinataire == 0) alert("Veuillez indiquer qui vous êtes");
				if (validation_contact_chantier == 0) alert("Veuillez indiquer le contact sur site");
			}
		}
	}

	function nl2br(str, is_xhtml) {
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}

	function CheckAll(object) {
		if (jQuery(object).is(':checked')) {
			jQuery(object).parent().parent().parent().find(".add_reservation").prop("checked", true);
		} else {
			jQuery(object).parent().parent().parent().find(".add_reservation").prop("checked", false);
		}
	}

	function BonCommandExcel2() {
		var merge = [];
		var contexte = '';
		var zone = '';
		var mesure = '';
		var quantite = '';

		// var data = [["Contexte", "Zone", "Mesure", "Qté Préconisé", "Qté souhaité", "Date", "Horaire", "Elec dispo"]];
		// jQuery('.table_command').each(function(){
		// contexte = jQuery(this).parent().parent().prev('h3').text();
		// zone = jQuery(this).parent().prev('h3').text();
		// jQuery(this).find('tr').not(':FIRST').not(':LAST').each(function(){
		// mesure = jQuery(this).find('td:eq(0)').text();
		// quantite = jQuery(this).find('td:eq(1) input').val();

		// data.push([contexte, zone, mesure , quantite, "", "", "", ""]);
		// });
		// });

		var lvl1 = 1;
		var lvl2 = 1;
		var lvl3 = 1;
		var data = [
			["Contexte", "Zone", "Mesure", "Qté Préconisé", "Qté souhaité", "Date", "Horaire", "Elec dispo"]
		];
		// var data = [];
		jQuery('h3.level1').each(function() {
			var contexte = jQuery(this).text();

			jQuery(this).next('div').find('h3.level2').each(function() {
				var zone = jQuery(this).text();

				jQuery(this).next('div').find('tr').not(':FIRST').not(':LAST').each(function() {
					mesure = jQuery(this).find('td:eq(0)').text();
					qtePreco = jQuery(this).find('td:eq(1) input').val();

					data.push([contexte, zone, mesure, qtePreco, "", "", "", ""]);
					lvl3++;
				});

				var merge_obj = {
					s: {
						r: lvl2,
						c: 1
					},
					e: {
						r: (lvl3 - 1),
						c: 1
					}
				};

				merge.push(merge_obj);
				lvl2 = lvl3;
			});

			var merge_obj = {
				s: {
					r: lvl1,
					c: 0
				},
				e: {
					r: (lvl3 - 1),
					c: 0
				}
			};

			merge.push(merge_obj);
			lvl1 = lvl3;
		});

		// var wscols = [
		// {wch: 6}, // "characters"
		// {wpx: 50}, // "pixels"
		// ];


		// Init each col at 0
		var wcols = [];
		for (var nbCol = 0; nbCol < data[0].length; nbCol++) {
			wcols.push(0);
		}

		for (var row = 0; row < data.length; row++) {
			for (var col = 0; col < data[row].length; col++) {
				if (wcols[col] < data[row][col].length)
					wcols[col] = data[row][col].length;
			}
		}

		var wscols = [];
		wcols.forEach(
			wscol => wscols.push({
				wch: wscol
			})
		);

		const ws = XLSX.utils.aoa_to_sheet(data);
		ws["!merges"] = merge;
		ws["!cols"] = wscols;
		// Create a new book where to append the data.
		const wb = XLSX.utils.book_new();

		// Append the sheet (second param) to the book (first param)
		// with the specified name (third param)
		XLSX.utils.book_append_sheet(wb, ws, "Ceapic BdC");


		// This is the instruction that tells the browser to
		// "download" the file
		XLSX.writeFile(wb, 'CEAPIC BdC.xlsx');
	}
</script>