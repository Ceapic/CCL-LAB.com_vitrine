<?php
$html = "";

// $model = $this->getModel('strategie'); // nom model
// $model2 = $this->getModel('synthese'); // nom model
require_once(URL_MODELE . "StrategieChantierV1.php");

// require_once(JPATH_COMPONENT . DS . 'models/StrategieChantierV1.php');

$contextes = [];
$zses = [];

class PI_ZC {
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
	public function getId() {
		return $this->id;
	}

	public function getIdEntite() {
		return $this->id_entite;
	}

	public function getType() {
		return $this->type;
	}

	public function getNom() {
		return $this->nom;
	}

	public function getLastPose() {
		return $this->lastPose;
	}

	public function setLastPose($lastPose) {
		$this->lastPose = $lastPose;
	}

	public function getQteMEST() {
		return $this->qteMEST;
	}

	public function setQteMEST($qteMEST) {
		$this->qteMEST = $qteMEST;
	}

	public function getQtePTA() {
		return $this->qtePTA;
	}

	public function setQtePTA($qtePTA) {
		$this->qtePTA = $qtePTA;
	}


	public function getContexte() {
		return $this->idContexte;
	}


	public function setContexte($contexte) {
		$this->idContexte = $contexte;

		return $this;
	}
	#endregion

	// Le constructeur est maintenant privé pour contrôler la création via une méthode statique
	private function __construct($id, $id_entite, $type, $nom, $idContexte) {
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
	public static function createPI_ZC($id_entite, $type, $nom, $idContexte) {
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
	private static function checkExist($id_entite, $type, $idContexte) {
		return isset(self::$storeManager[$id_entite][$type][$idContexte]);
	}

	// Récupère un objet PI_ZC par son identifiant unique
	public static function getPI_ZC($id) {
		return isset(self::$store[$id]) ? self::$store[$id] : null;
	}

	// Cherche un objet PI_ZC par son id_entite et type
	public static function searchPI_ZC($id_entite, $type, $idContexte) {
		$id = isset(self::$storeManager[$id_entite][$type][$idContexte]) ? self::$storeManager[$id_entite][$type][$idContexte] : null;
		return $id !== null ? self::getPI_ZC($id) : null;
	}

	public static function ListPI_ZC() {
		return self::$store;
	}

	// Affiche les détails de l'objet sous forme de chaîne
	public function __toString() {
		return "ID: {$this->id}, Nom: {$this->nom}, Contexte: {$this->idContexte}, Type: {$this->type}, ID Entité: {$this->id_entite}";
	}
}

function getDateMax($date1, $date2) {
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

$list_mesure_strategie = StrategieChantierV1::listMesureStrategie($id_strategie);

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
		$contexte->id
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
	$array_mesure_strategie[$contexte->id][$PI_ZC][] = $zse;
}

//die();

$list_mesure_echantillon = StrategieChantierV1::listStrategieEchantillon($id_strategie);

$array_mesure_echantillon = [];
foreach ($list_mesure_echantillon as $mesure_echantillon) {
	$id_entite = $mesure_echantillon->id_zone;
	$type = $mesure_echantillon->type_zone;

	$PI_ZC = PI_ZC::searchPI_ZC($id_entite, $type, $mesure_echantillon->id_contexte);

	if ($PI_ZC != null) {
		$PI_ZC->setLastPose(getDateMax($PI_ZC->getLastPose(), $mesure_echantillon->date_pose));
		if ($mesure_echantillon->type_mesure == 'MEST') {
			$PI_ZC->setQteMEST($PI_ZC->getQteMEST() + 1);
		}

		if ($mesure_echantillon->id_mesure == StrategieChantierV1::ID_MESURE_STRATEGIE_PTA) {
			$PI_ZC->setQtePTA($PI_ZC->getQtePTA() + 1);
		}

		$array_mesure_echantillon[$PI_ZC->getId()][] = $mesure_echantillon;
	}
}

//foreach (PI_ZC::ListPI_ZC() as $pi_zc) {
//var_dump($pi_zc);
//}

$listRFM = StrategieChantierV1::listeRFM($id_strategie);
$array_rfm = [];
if ($listRFM != null) {
	foreach ($listRFM as $rfm) {
		$id_entite = $rfm->id_zone;
		$type = $rfm->type_zone;

		$PI_ZC = PI_ZC::searchPI_ZC($id_entite, $type, $rfm->id_contexte);
		if ($PI_ZC != null) {
			$array_rfm[$PI_ZC->getId()][] = $rfm;
		}
	}
}

//init contexte
$list_mesure_echantillon_deleted = StrategieChantierV1::listStrategieEchantillonCorbeille($id_strategie);
$array_mesure_echantillon_deleted = [];
if ($list_mesure_echantillon_deleted != null) {
	foreach ($list_mesure_echantillon_deleted as $mesure_echantillon_deleted) {
		$id_entite = $mesure_echantillon_deleted->id_zone;
		$type = $mesure_echantillon_deleted->type_zone;

		$PI_ZC = PI_ZC::searchPI_ZC($id_entite, $type, $mesure_echantillon_deleted->id_contexte);
		if ($PI_ZC != null) {
			$array_mesure_echantillon_deleted[$PI_ZC->getId()][] = $mesure_echantillon_deleted;
		}
	}
}

$list_mesure_echantillon_non_commande = StrategieChantierV1::listStrategieEchantillonNonCommande($id_strategie);
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


// var_dump($list_mesure_echantillon_non_commande);
// die();
?>

<STYLE>
	/* CSS POUR ACCORDION */
	.accordion>.accordion-title.h1 {
		/*display: flex;*/
		color: white;
		/* background-color: #164863; */
		background-color:rgb(69, 83, 90);
	}

	.accordion>.accordion-title.h2 {
		background-color: #427D9D;
	}

	.accordion>.accordion-title.h3 {
		background-color: #9BBEC8;
	}

	.accordion>.accordion-title.h4 {
		background-color: #DDF2FD;
	}

	.accordion>.accordion-title.haha {
		background-color: #f9ab7c;
		background-image: linear-gradient(to bottom,
				rgba(0, 0, 0, 0) 0%,
				rgba(0, 0, 0, 0) 49%,
				rgba(0, 0, 0, 0.2) 50%,
				rgba(0, 0, 0, 0) 100%);
	}

	.accordion>.accordion-title {
		background-image: linear-gradient(to bottom,
				rgba(0, 0, 0, 0) 0%,
				rgba(0, 0, 0, 0) 49%,
				rgba(0, 0, 0, 0.2) 50%,
				rgba(0, 0, 0, 0) 100%);
	}

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

	/* .ui-icon,
	.ui-widget-content .ui-icon { */

	.ui-icon-triangle-1-e {
		background-image: url("/images/ui-icons_ffffff_256x240.png") !important;
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
		color: yellow !important;
		background-image: url("/images/ui-icons_cf7278_256x240.png") !important;
	}

	.red_tab:hover .ui-icon {
		background-image: url("/images/ui-icons_cf7278_256x240.png") !important;
		/* background-image: url("/images/ui-icons_e82633_256x240.png") !important; */
	}

	.rapport_final {
		background: #CCDEFF;
	}

	.mesure_ok {
		background: #E2EFD9;
	}

	.mesure_ko {
		background: #F2D7D5;
	}

	.mesure_corbeille {
		background: #FFF2CC;
	}
</STYLE>


<table align="center" style="width: 98%; border-collapse: collapse; border: 1px solid; margin-top: 10px;" border="0">
	<tr>
		<td class="rapport_final" style="padding: 5px; width: 50%; border: 1px solid;">Rapports Finaux</td>
		<td class="mesure_ok" style="padding: 5px; width: 50%; border: 1px solid;">Mesures réalisées</td>
	</tr>

	<tr>
		<td class="mesure_corbeille" style="padding: 5px; width: 50%; border: 1px solid;">Mesures commandées mais non réalisées</td>
		<td class="mesure_ko" style="padding: 5px; width: 50%; border: 1px solid;">Mesures préconisées par la stratégie mais non encore commandées</td>
	</tr>


</table>


<br>
<p>(*) Mesures sous accréditation cofrac : portée disponible sur www.cofrac.fr</p>

<?php

$html = "";


foreach ($array_mesure_strategie as $id_contexte => $oneContexte) {
	$html .= '<div class="accordion">';
	$html .= ' <div class="accordion-title h1"> ' . $contextes[$id_contexte]->nom . '</div>';
	$html .= '<div>';
	foreach ($oneContexte as $id_PI_ZC => $ZSEs) {
		$cptMESTFait = 0;
		$cptPTAFait = 0;

		$PI_ZC = PI_ZC::getPI_ZC($id_PI_ZC);

		if ($PI_ZC != null) {

			$affichageNonCommande = false;

			$classColor = "";
			if (isset($array_mesure_echantillon_non_commande[$id_PI_ZC]) && count($array_mesure_echantillon_non_commande[$id_PI_ZC]) > 0) {
				$qteMestNonFait = 0;
				$qtePtaNonFait = 0;
				foreach ($array_mesure_echantillon_non_commande[$id_PI_ZC] as $echantillon) {
					if ($echantillon->isMest == 1) {
						$qteMestNonCommande += $echantillon->quantite;
					} else {
						if ($echantillon->isPta == 1) {
							$qtePtaNonFait += $echantillon->quantite;
						} else {
							$affichageNonCommande = true;
						}
					}
				}
				if (!$affichageNonCommande && $qteMestNonFait > $PI_ZC->getQteMEST()) {
					$affichageNonCommande = true;
				}

				// if (!$affichageNonCommande && $qtePtaNonFait > $PI_ZC->getQtePTA()) {
				if ($PI_ZC->getQtePTA() > 0) {
					$affichageNonCommande = false;
				}
			}

			if ($affichageNonCommande == true) {
				$classColor = "red_tab";
			} else {
				$classColor = "";
			}


			$html .= '<div class="accordion">';
			$html .= '<div class="accordion-title h1 ' . $classColor . '">' . $PI_ZC->getNom();
			if ($PI_ZC->getLastPose() != "01/01/0001") {
				$html .= '<span style="float:right;">Dernière Pose : ' . $PI_ZC->getLastPose() . ' </span>';
			}
			$html .= '</div>';

			$html .= '<div class="accordion-content">';
			//affichage ECHANTILLON
			if(isset($array_mesure_echantillon[$id_PI_ZC])||isset($array_rfm[$id_PI_ZC])) {
				if (count($array_mesure_echantillon[$id_PI_ZC]) > 0 || count($array_rfm[$id_PI_ZC]) > 0) {
					$html .= '<table class="table_gbmnet table_echantillon">';
					$html .= '<tr>';
					$html .= '<td> Ref Echantillon</td>';
					$html .= '<td> Type de Mesure</td>';
					$html .= '<td> Date de Pose</td>';
					$html .= '<td> Resultat</td>';
					$html .= '<td> Rev Strat</td>';
					$html .= '</tr>';
	
					if (count($array_mesure_echantillon[$id_PI_ZC]) > 0) {
						foreach ($array_mesure_echantillon[$id_PI_ZC] as $echantillon) {
							$resultats = StrategieChantierV1::getResultatAndCofrac($echantillon->id_echantillon);
							$resultat = $resultats[0];
							$cofrac = $resultats[1];
	
							$classEch = 'mesure_ok';
	
							$html .= '<tr id="td_' . $echantillon->id_echantillon  . '" class="' . $classEch . '">';
							// $html .= '<td> ' . $echantillon->ref_echantillon . " " . $cofrac . " " . ' </td>';
							$show_class = "show_rapport_echantillon";
							$href = "href";
							$hash = md5($echantillon->id_echantillon . $model0->GetSharingKey());
	
							$html .= '<td> <p class="' . $show_class . '" link="' . $echantillon->id_echantillon . '" data-echantillon="' . $echantillon->id_echantillon . '" data-echantillon_hash="' . $hash . '"><span class="' . $href . '">' . $echantillon->ref_echantillon . $cofrac . ' </span></a></td>';
	
							$html .= '<td> ' . $echantillon->type_mesure . '</td>';
							//BEURKKKK
							if ($echantillon->type_mesure == 'MEST') {
								$cptMESTFait++;
							}
							if ($echantillon->id_mesure == StrategieChantierV1::ID_MESURE_STRATEGIE_PTA) {
								$cptPTAFait++;
							}
							$html .= '<td> ' . $echantillon->date_pose . '</td>';
							$html .= '<td> ' . $resultat . '</td>';
							$html .= '<td> ' . $echantillon->rev_strat . '</td>';
							$html .= '</tr>';
						}
					}
	
					if (isset($array_rfm[$id_PI_ZC]) && count($array_rfm[$id_PI_ZC]) > 0) {
						foreach ($array_rfm[$id_PI_ZC] as $rfm) {
							$html .= '<tr class="rapport_final">';
							//$html .= '<td> ' . $rfm->reference . '</td>';
							$missionHash = md5($rfm->id_mission . $model0->GetSharingKey());
							$html .= '<td><p class="show_rapport_echantillon" data-mission="' . $rfm->id_mission . '" data-mission_hash="' . $missionHash . '"><span class="href">' . $rfm->reference . '</span> </p></td>';
	
							$html .= '<td> ' . $rfm->type_mesure . '</td>';
							$html .= '<td> ' . $rfm->date_rapport . '</td>';
							$html .= '<td> / </td>';
							$html .= '<td> ' . $rfm->revision . '</td>';
							$html .= '</tr>';
						}
					}
	
					$html .= '</table>';
				}
			}


			//tableau des mesures commandés mais non réalisés
			if (isset($array_mesure_echantillon_deleted[$id_PI_ZC]) && count($array_mesure_echantillon_deleted[$id_PI_ZC]) > 0) {
				$html .= '<table class="table_gbmnet table_echantillon">';
				$html .= '<tr>';
				$html .= "<td colspan='4'> Mesures commandées mais non réalisées </td>";
				$html .= '</tr>';

				$html .= '<tr>';
				$html .= '<td> Type de Mesure</td>';
				$html .= '<td> Date de Mission </td>';
				$html .= '<td> Date de Suppression </td>';
				$html .= '<td> Commentaire </td>';
				$html .= '</tr>';

				foreach ($array_mesure_echantillon_deleted[$id_PI_ZC] as $echantillon) {
					$html .= '<tr id="td_' . $echantillon->id_echantillon . '" class="mesure_corbeille">';
					$html .= '<td> ' . $echantillon->type_mesure . '</td>';
					$html .= '<td> ' . $echantillon->date_mission . '</td>';
					$html .= '<td> ' . $echantillon->date_suppression . '</td>';
					$html .= '<td> ' . $echantillon->commentaire . '</td>';
					$html .= '</tr>';
				}
				$html .= '</table>';
			}

			//tableau des mesures préconisés mais non commandés 
			// if (count($array_mesure_echantillon_non_commande[$id_PI_ZC]) > 0) {
			if ($affichageNonCommande) {
				$html .= '<table class="table_gbmnet table_echantillon">';
				$html .= '<tr>';
				$html .= "<td colspan='4'> Mesures préconisées par la stratégie mais non encore commandées </td>";
				$html .= '</tr>';

				$html .= '<tr>';
				$html .= '<td> Type de Mesure</td>';
				$html .= '<td> Quantité </td>';
				$html .= '</tr>';

				foreach ($array_mesure_echantillon_non_commande[$id_PI_ZC] as $echantillon) {
					$quantite = $echantillon->quantite;
					if ($echantillon->isMest == 1) {
						$quantite = $echantillon->quantite - $PI_ZC->getQteMEST();
					}
					if ($echantillon->isPta == 1) {
						$quantite = $echantillon->quantite - $PI_ZC->getQtePTA();
					}

					if ($quantite > 0) {
						$html .= '<tr id="td_' . $echantillon->id_echantillon . '" class="mesure_ko">';
						$html .= '<td> ' . $echantillon->type_mesure . '</td>';
						$html .= '<td> ' . $quantite . '</td>';
						$html .= '</tr>';
					}
				}
				$html .= '</table>';
			}

			$html .= '</div>';
			$html .= '</div>';
		}
	}

	$html .= '</div></div>';
}
echo $html;



?>


<div id="div_message_commande" class="hide"></div>

<script language="javascript" type="text/javascript">
	jQuery(document).ready(function() {
		initAccordeon();
	});

	function initAccordeon() {
		jQuery('.accordion').accordion({
			active: false, //all closed by default
			collapsible: true,
			heightStyle: "content"
		});


	}
</script>