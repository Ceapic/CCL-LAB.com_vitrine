<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.calendar');

JHtml::script("components/com_gbmnetfront/js/jquery/jquery-1.12.4.min.js");
JHtml::script("components/com_gbmnetfront/js/jquery-ui-1.12.1/jquery-ui.min.js");
JHtml::script("components/com_gbmnetfront/js/jquery-ui-1.12.1/jquery.ui.datepicker-fr.js");
JHtml::script("components/com_gbmnetfront/js/Chart/Chart.min.js");

JHtml::stylesheet("components/com_gbmnetfront/js/jquery-ui-1.12.1/jquery-ui.min.css");
JHtml::stylesheet("components/com_gbmnetfront/css/font-awesome/css/font-awesome.min.css");

JHtml::script('components/com_gbmnetfront/js/jquery.dataTables.min.js');
JHtml::stylesheet('components/com_gbmnetfront/css/jquery.dataTables.min.css');


require_once(URL_MODELE . "gbmnetFrontModel.php");
$model = new gbmnetFrontModel;

$user = JFactory::getUser();
if ($user->type_client <> 1) die('Restricted access');

$id_client = $user->client;
$type_client = $user->type_client;
$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
// die();
$url = $model->GetRemoteToken() . "&task=ListeRapportsFinaux&id_client=" . $id_client . "&token=" . $token . "&format=raw";
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
</STYLE>

<div id="div_liste_strategie" class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Liste des rapports finaux</h3>
	</div>
	<table id="table_rapports_finaux" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th class="filter" sizeinput="70">Ref chantier</th>
				<th class="filter" sizeinput="140">Adresse</th>
				<th class="filter" sizeinput="80">Ville</th>
				<th class="filter" sizeinput="70">CP</th>
				<th class="filter" sizeinput="100">Ref rapport final</th>
			</tr>
			<tr>
				<th>Ref chantier</th>
				<th>Adresse</th>
				<th>Ville</th>
				<th>CP</th>
				<th>Ref</th>
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
	jQuery('#table_rapports_finaux').on('click', '.show_rapport_final', function() {
		var page = "<?php echo JURI::root(); ?>index.php?option=com_gbmnetfront&task=AfficheRapportFinalFront&format=raw&ref=" + jQuery(this).parent().find(".rapport_final option:selected").html().replace(" ", "-") + "&id_echantillon=" + jQuery(this).attr("linkechantillon") + "&id_rapport=" + jQuery(this).parent().find(".rapport_final").val() + "&tokenrapport=" + jQuery(this).parent().find(".rapport_final option:selected").attr("hash") + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
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

		// DataTable
		var table = jQuery('#table_rapports_finaux').DataTable({
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

		jQuery('.filter input').on('keyup', function() {
			var column = jQuery(this).attr("linkcolumn");
			table
				.columns(column)
				.search(this.value)
				.draw();
		});

		// =============================================
		// Change pour la dernière version de la stratégie
		// =============================================
		jQuery(".strategie_chantier").each(function() {
			jQuery(this).val(jQuery(this).find('option:LAST').val());
		});
	});
</script>