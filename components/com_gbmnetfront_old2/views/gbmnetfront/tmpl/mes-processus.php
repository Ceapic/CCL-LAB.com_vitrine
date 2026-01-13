<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.calendar');

JHtml::script("components/com_gbmnetfront/js/jquery/jquery-1.12.4.min.js");
JHtml::script("components/com_gbmnetfront/js/jquery-ui-1.12.1/jquery-ui.min.js");
JHtml::script("components/com_gbmnetfront/js/jquery-ui-1.12.1/jquery.ui.datepicker-fr.js");
// JHtml::script("components/com_ceapicworld/js/Canvas/canvasjs.min.js");
// JHtml::script("components/com_gbmnetfront/js/Chart/Chart.min.js");

JHtml::stylesheet("components/com_gbmnetfront/js/jquery-ui-1.12.1/jquery-ui.min.css");
JHtml::stylesheet("components/com_gbmnetfront/css/font-awesome/css/font-awesome.min.css");

JHtml::script('components/com_gbmnetfront/js/jquery.dataTables.min.js');
JHtml::stylesheet('components/com_gbmnetfront/css/jquery.dataTables.min.css');

// $model = $this->getModel('ceapicworld');  nom model
require_once(URL_MODELE . "gbmnetFrontModel.php");
$model = new gbmnetFrontModel;

$user = JFactory::getUser();
if ($user->type_client <> 1) die('Restricted access');

$id_client = $user->client;
$type_client = $user->type_client;
$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));

$url = $model->GetRemoteToken() . "&task=ListeProcessusClient&id_client=" . $id_client . "&token=" . $token . "&format=raw";
// var_dump($url);
$Processus_data = file_get_contents($url);


$sharingkey = $model->GetSharingKey();
$token_client = md5($id_client . $type_client . $sharingkey);
?>


<STYLE type="text/css">
	#div_liste_strategie {
		border: none;
	}

	#main #div_liste_strategie .panel-heading h3 {
		font-weight: 300;
		font-size: 24px;
		line-height: 40px;
	}

	.filterable {
		margin-top: 15px;
	}

	.filterable .panel-heading .pull-right {
		margin-top: -20px;
	}

	.filterable .filters input[disabled] {
		background-color: transparent;
		border: none;
		cursor: auto;
		box-shadow: none;
		padding: 0;
		height: auto;
	}

	.filterable .filters input[disabled]::-webkit-input-placeholder {
		color: #333;
	}

	.filterable .filters input[disabled]::-moz-placeholder {
		color: #333;
	}

	.filterable .filters input[disabled]:-ms-input-placeholder {
		color: #333;
	}

	.dataTables_filter {
		display: none;
	}

	.ceapicworld_button_radius {
		border: none;
		color: white;
		padding: 5px 5px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 14px;
		border-radius: 12px;
		cursor: pointer;
		-webkit-transition-duration: 0.4s;
		transition-duration: 0.4s;
	}

	.ceapicworld_button_blue {
		border: 1px solid #2694e8;
		background: #3baae3 url("/images/ui-bg_glass_50_3baae3_1x400.png") 50% 50% repeat-x;
	}

	.ceapicworld_button_shadow:hover {
		box-shadow: 0 5px 5px 0 rgba(0, 0, 0, 0.24), 0 10px 10px 0 rgba(0, 0, 0, 0.19);
	}

	.show_processus {
		white-space: nowrap;
	}
</STYLE>

<div id="div_liste_strategie" class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Liste des processus</h3>
	</div>
	<!-- <canvas id="myChart" width="400px" height="100px"></canvas> -->
	<table id="table_processus" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th class="filter" sizeinput="70">Ref chantier</th>
				<th class="filter" sizeinput="70">Adresse</th>
				<th class="filter" sizeinput="70">Ref processus</th>
				<th class="filter" sizeinput="70">Matériaux</th>
				<th class="filter" sizeinput="70">Technique</th>
				<th class="filter" sizeinput="70">Protection Co</th>
				<th class="filter" sizeinput="40">SA</th>
				<th class="filter" sizeinput="40">Résultat</th>
				<!-- <th class="filter" sizeinput="40">Date</th> -->
				<th class="filter" sizeinput="70">Ref rapport</th>
			</tr>
			<tr>
				<th>Ref chantier</th>
				<th>Adresse</th>
				<th>Ref processus</th>
				<th>Matériaux</th>
				<th>Technique</th>
				<th>Protection Co</th>
				<th>SA (F/L)</th>
				<th>Résultat (F/L)</th>
				<!-- <th>Date</th> -->
				<th>Ref rapport</th>
			</tr>
		</thead>
		<tbody>
			<?php

			echo $Processus_data;
			?>
		</tbody>
	</table>
</div>


<script language="javascript" type="text/javascript">
	jQuery('#table_processus').on('click', '.show_processus', function() {
		var page = "<?php echo JURI::root(); ?>index.php?option=gmbnetworldFront&task=AfficheRapportFront&format=raw&ref=" + jQuery(this).find(".href").html().replace(" ", "-") + "&id_echantillon=" + jQuery(this).attr("linkechantillon") + "&id_rapport=" + jQuery(this).attr("linkrapport") + "&tokenrapport=" + jQuery(this).attr("hash") + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		// alert(page);
		window.open(page, '_blank');
	});

	jQuery(document).ready(function() {
		// =============================================
		// Resize page
		// =============================================
		jQuery("#mainbody").css("min-height", "");

		// =============================================
		// DataTable filter - Echantillon
		// =============================================

		// Setup - add a text input to each footer cell
		jQuery('.filter').each(function(e) {
			var title = jQuery(this).text();
			var sizeinput = jQuery(this).attr("sizeinput");
			jQuery(this).html('<input type="text" placeholder="' + title + '" linkcolumn=' + e + ' style="width:' + sizeinput + 'px;"/>');
		});

		// Retourne une valeur pour trier par date
		jQuery.fn.dataTable.ext.type.order['date-type-pre'] = function(data) {
			var DateSplit = data.split("/");
			return DateSplit[2] + DateSplit[1] + DateSplit[0];
		};

		// DataTable
		var table = jQuery('#table_processus').DataTable({
			"pageLength": 25,
			"order": [],
			"lengthChange": false,
			"info": false,
			// "columnDefs": [{
			// 	"type": "date-type",
			// 	"targets": -2
			// }],
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

		jQuery('.filter input').on('keyup', function() {
			var column = jQuery(this).attr("linkcolumn");
			table
				.columns(column)
				.search(this.value)
				.draw();
		});

		// ================================================
		// Change pour la dernière version de la stratégie
		// ================================================
		jQuery(".strategie_chantier").each(function() {
			jQuery(this).val(jQuery(this).find('option:LAST').val());
		});

		// =============================================
		// Graph
		// =============================================
		var niveau1 = 0; // < 100
		var niveau2 = 0; // 100 - 6000
		var niveau3 = 0; // 6000 - 25000
		var niveau0 = 0; // > 250000
		var inanalysable = 0; // Inanalysable
		var count_processus = jQuery(".resultat_processus").length;

		jQuery(".resultat_processus").each(function() {
			var resultat_processus = jQuery(this).text().replace('<', '').replace('>', '').replace(',', '.');
			if (resultat_processus < 100) niveau1++;
			if ((resultat_processus >= 100) && (resultat_processus < 6000)) niveau2++;
			if ((resultat_processus >= 6000) && (resultat_processus < 25000)) niveau3++;
			if (resultat_processus >= 25000) niveau0++;
			if (resultat_processus == "INA") inanalysable++;
		});

		// var ctx = document.getElementById("myChart");
		// var myChart = new Chart(ctx, {
		// 	type: 'doughnut',
		// 	data: {
		// 		labels: ["Niveau 1 : <100 f/L : " + niveau1 + " mesures - " + Math.round(niveau1 * 100 / count_processus) + "%", "Niveau 2 : 100 à 6000 f/L : " + niveau2 + " mesures - " + Math.round(niveau2 * 100 / count_processus) + "%", "Niveau 3 : 6000 à 25000 F/L : " + niveau3 + " mesures - " + Math.round(niveau3 * 100 / count_processus) + "%", "Hors niveau : > 25000 F/L : " + niveau0 + " mesures - " + Math.round(niveau0 * 100 / count_processus) + "%", "Inanalysable - " + Math.round(inanalysable * 100 / count_processus) + "%"],
		// 		datasets: [{
		// 			label: 'Statistique des processus',
		// 			data: [niveau1, niveau2, niveau3, niveau0, inanalysable],
		// 			"backgroundColor": ["rgb(54, 162, 235)", "rgb(255, 205, 86)", "rgb(255, 99, 132)", "rgb(0, 0, 0)", "rgb(229, 229, 229)"]
		// 		}]
		// 	}
		// });
	});
</script>