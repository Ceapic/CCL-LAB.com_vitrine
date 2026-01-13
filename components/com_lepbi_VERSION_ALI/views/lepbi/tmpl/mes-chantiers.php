<?php
defined('_JEXEC') or die('Restricted access');

$user = JFactory::getUser();
if ($user->type_client != 1) die('Restricted access');

$id_client = $user->client;
$type_client = $user->type_client;
$token = Gbmnetfront::CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));

$url = Gbmnetfront::getUrlBack() . "/index.php?option=" . $GLOBALS["CBV"] . "&task=ListeChantier&id_client=" . $id_client . "&token=" . $token . "&format=raw";

$Chantiers = json_decode(file_get_contents($url));

$sharingkey = Gbmnetfront::GetSharingKey();
$token_client = md5($id_client . $type_client . $sharingkey);

$user = JFactory::getUser();
$id_user = $user->id;

?>

<STYLE type="text/css">
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

	#table_chantier th {
		padding: 0px;
		padding-left: 5px;
	}

	.ui-widget-overlay.custom-overlay {
		background-color: black;
		background-image: none;
		opacity: 0.9;
		z-index: 1040;
	}


	#table_chantier tr:hover td {
		cursor: pointer;
		background-color: #30a8f4;
	}

	#table_chantier tr.selected_chantier td {
		background-color: #30a8f4;
	}

	.dataTables_filter {
		display: none;
	}

	.ceapicworld_button_radius {
		border: none;
		color: white;
		padding: 8px 8px;
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
		border: 1px solid #2664e8;
		background: linear-gradient(#77bcf1, #2694e8);
	}

	.ceapicworld_button_green {
		border: 1px solid #3be344;
		background: linear-gradient(#99ed84, #5ce33b);
	}

	.info-news-red {
		float: right;
		font-family: arial;
		font-weight: bold;
		color: red;
		font-size: 16px;
	}

	.info-news {
		float: right;
		font-family: arial;
		font-weight: bold;
		font-size: 16px;
	}

	.ceapicworld_button_shadow:hover {
		box-shadow: 0 5px 5px 0 rgba(0, 0, 0, 0.24), 0 10px 10px 0 rgba(0, 0, 0, 0.19);
	}

	i.fa-file-excel-o {
		color: green;
	}

	.table-responsive-dt {
		width: 100%;
		max-width: 100%;
	}

	#table_chantier {
		width: 100% !important;
		max-width: 100%;
		table-layout: fixed;
		/* 🔑 empêche l’explosion des colonnes */
	}
</STYLE>
<!--<table align="center" style="width: 98%; border-collapse: collapse; border: 1px solid;" border="0">
	<tr style="background: #85c1e9 ;"><td style="padding: 5px; width: 100%;">Réglementaire ambiance code de la santé publique (CSP)</td></tr>
	<tr style="background: #82e0aa ;"><td style="padding: 5px; width: 100%;">Réglementaire ambiance code du travail (CT)</td></tr>
	<tr style="background: #f7dc6f ;"><td style="padding: 5px; width: 100%;">Réglementaire opérateur code du travail (CT) : Mesures déclenchées suivant vos besoins</td></tr>
	<tr style="background: #c39bd3 ;"><td style="padding: 5px; width: 100%;">Hors stratégie d’échantillonnage</td></tr>
	<tr style="background: #d7dbdd ;"><td style="padding: 5px; width: 100%;">Mesures non réglementaire</td></tr>
</table>-->

<div id="alert_strategie" class="hide" style="background-color: #c3d2e5; color: #0055bb; border-top: 3px solid #84a7db; border-bottom: 3px solid #84a7db; padding-left: 1em; font-weight: bold;">
	<p>Il n’y a pas de stratégie pour ce chantier ou celle-ci n’est pas disponible </p>
</div>

<div id="tabs">
	<ul>
		<li><a href="#div_liste_chantier"><i class="liste_chantier"></i>Liste des chantiers</a></li>
		<li><a href="#div_suivi_chantier"><i class="suivi_strategie"></i>Suivi stratégie</a></li>
		<li><a href="#div_liste_rapport"><i class="liste_rapport"></i>Liste des rapports</a></li>
	</ul>
	<div id="div_liste_chantier" class="panel panel-primary table-responsive-dt" style="padding: unset;">
		<!-- <div id="div_liste_chantier" class="panel panel-primary "> -->
		<div class="panel-heading" style="display:flex;flex-direction:row;justify-content:space-between;align-items:center;">
			<div>
				<i class="fa fa-circle-o" aria-hidden="true"></i> : Chantier sans stratégie
			</div>
			<div>
				<i class="fa fa-dot-circle-o" aria-hidden="true"></i> : Chantier avec stratégie
			</div>
			<div>
				<i class="fa fa-file-excel-o"></i> : Extraction des résultats en Excel
			</div>
		</div>
		<table id="table_chantier" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th style='width:130px;'>Référence</th>
					<th>Adresse</th>
					<th style='width:150px;'>Ville</th>
					<th style='width:100px;'>Code postal</th>
					<th style='width:130px;'>Date 1<sup>ère</sup> mesure</th>
					<th style='width:30px;'></th>
				</tr>
				<tr>
					<th linkcolumn="1" class="filter">Référence</th>
					<th linkcolumn="2" class="filter">Adresse</th>
					<th linkcolumn="3" class="filter">Ville</th>
					<th linkcolumn="4" class="filter">Code postal</th>
					<th linkcolumn="5" class="filter">Date mesure</th>
					<th linkcolumn="6"></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($Chantiers as $oneChantier) {
					$token_chantier = md5($oneChantier->id_chantier . $type_client . $sharingkey);
					if ($oneChantier->date_pose_presta_echantillon == '') {
						$date_chantier = "-";
					} else {
						$date_chantier = date('d/m/Y', strtotime($oneChantier->date_pose_presta_echantillon));
					}
					// if ($oneChantier->id_strategie_chantier == '') {
					if ($oneChantier->id_strat == '') {
						$icon_strat = "<i class=\"fa fa-circle-o\" aria-hidden=\"true\"></i>";
					} else {
						$icon_strat = "<i class=\"fa fa-dot-circle-o\" aria-hidden=\"true\"></i>";
					}
					echo "<tr><td onClick=\"ClickChantier(this, " . $oneChantier->id_chantier . ")\"><span style=\"white-space: nowrap;\">" . $icon_strat . " " . $oneChantier->nom_chantier . "</span></td><td onClick=\"ClickChantier(this, " . $oneChantier->id_chantier . ")\">" . $oneChantier->adresse_chantier . "</td><td onClick=\"ClickChantier(this, " . $oneChantier->id_chantier . ")\">" . $oneChantier->ville_chantier . "</td><td onClick=\"ClickChantier(this, " . $oneChantier->id_chantier . ")\">" . $oneChantier->cp_chantier . "</td><td onClick=\"ClickChantier(this, " . $oneChantier->id_chantier . ")\">" . $date_chantier . "</td><td><i class=\"fa fa-file-excel-o\" onClick=\"Extraction(" . $oneChantier->id_chantier . ",'" . $token_chantier . "')\"></i></td></tr>";
				}
				?>
			</tbody>
		</table>
	</div>

	<div id="div_suivi_chantier" class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Suivi stratégie</h3>
		</div>
		<div id="suivi_chantier">
			<select size="1" id="sl_strategie_chantier" name="echantillon_strategie_chantier" onChange="ChangeStrategie()">
				<option value="0">Sélectionnez une stratégie</option>
			</select>

			<!-- <select size="1" id="revision_strategie_chantier" name="revision_strategie_chantier" style="width: 60px;"> -->
			<!-- </select> -->

			<button class="ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow" onClick="TelechargeStrategie()"><i class="fa fa-download"></i> Télécharger la stratégie</button>

			<button class="ceapicworld_button_radius ceapicworld_button_green ceapicworld_button_shadow" style="float: right;" onClick="Commander()"><i class="fa fa-calendar-check-o"></i> Planifier une intervention</button>

		</div>
		<div id="suivi_chantier_loader"></div>
		<div id="commande_chantier_loader" title="Réservation"></div>
	</div>

	<div id="div_liste_rapport" class="panel panel-primary">
		<div style="display: flex;">
			<div style="width: 75%; height: 37px; float: left;">
				<!-- <h3 class="panel-title">Liste des rapports</h3> -->
				<!-- <span class="info-news-red" style="  line-height: 37px; float: right;">Nouveauté : possibilité de télécharger tous les rapports d'un chantier en un seul clic <i class="fa fa-arrow-right" aria-hidden="true"></i></span> -->
			</div>
			<div style="width: 25%; height: 37px; float: right;">
				<button class="ceapicworld_button_radius ceapicworld_button_green ceapicworld_button_shadow" style="float: right;" onClick="DownloadAllRapport()"><i class="fa fa-download"></i> Télécharger tous les rapports</button>
			</div>
		</div>
		<div id="liste_rapport_loader" style="margin-top: 10px;"></div>
	</div>
</div>

<input type="text" id="id_chantier" name="id_chantier" value="" style="display: none;" />

<script language="javascript" type="text/javascript">
	var debutUrl = "<?php echo Gbmnetfront::GetUrlBack(); ?>/index.php?option=<?= $GLOBALS["CBV"] ?>";

	jQuery('#suivi_chantier_loader').on('click', '.show_rapport_echantillon', function() {
		var dataEch = jQuery(this).data("echantillon") || 0;
		var dataEchHash = jQuery(this).data("echantillon_hash") || 0;

		var dataMission = jQuery(this).data("mission") || 0;
		var dataMissionHash = jQuery(this).data("mission_hash") || 0;

		var page = debutUrl + " &task=AfficheRapportEchantillon&format=raw&ref=" + jQuery(this).find(".href").html().replace(" ", "-") + "&id_echantillon=" + dataEch + "&tokenEchantillon=" + dataEchHash + "&id_mission=" + dataMission + "&tokenMission=" + dataMissionHash + "&id_client=<?= $id_client ?>&type_client=<?= $type_client ?>&tokenClient=<?= $token_client ?>";
		window.open(page, '_blank');
	});

	jQuery('#liste_rapport_loader').on('click', '.show_rapport', function() {
		var page = debutUrl + "&task=AfficheRapport&format=raw&ref=" + jQuery(this).find(".href").html().replace(" ", "-") + "&id_echantillon=" + jQuery(this).attr("linkechantillon") + "&id_rapport=" + jQuery(this).attr("linkrapport") + "&tokenrapport=" + jQuery(this).attr("hash") + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		console.log(page);
		window.open(page, '_blank');
	});

	function DownloadAllRapport() {
		var ref_chantier = jQuery('#chantier_selected').text().split(':')[0].replace(/ /g, "").replace("/", "-");
		var page = debutUrl + "&task=DownloadAllRapportChantier&format=raw&id_chantier=" + jQuery('#id_chantier').val() + "&ref_chantier=" + ref_chantier + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		window.open(page, '_blank');
	}

	jQuery(document).ready(function() {
		jQuery("#mainbody").css("min-height", "");
		jQuery("#tabs").tabs();

		// Setup - add a text input to each footer cell
		jQuery('.filter').each(function(e) {
			var title = jQuery(this).text();
			var sizeinput = jQuery(this).attr("sizeinput");
			jQuery(this).html('<input type="text" placeholder="' + title + '" linkcolumn=' + e + ' style="width: 80%;max-width: 80%;margin:5px;"/>');
		});

		// Retourne une valeur pour trier par date
		jQuery.fn.dataTable.ext.type.order['date-type-pre'] = function(data) {
			var DateSplit = data.split("/");
			return DateSplit[2] + DateSplit[1] + DateSplit[0];
		};

		// DataTable
		var table = jQuery('#table_chantier').DataTable({
			"pageLength": 25,
			"order": [],
			"lengthChange": false,
			"info": false,
			"columnDefs": [{
				"type": "date-type",
				"targets": -2
			}, {
				"orderable": false,
				"targets": -1
			}],
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
			// "searching": false
		});

		// Active le tri sur la première ligne du thead uniquement
		var headerRow = jQuery('#table_chantier thead tr:eq(0) th');
		headerRow.addClass('sorting').css('cursor', 'pointer').on('click', function() {
			var idx = jQuery(this).index();
			// Respecte les colonnes non triables définies dans columnDefs
			if (table.settings()[0].aoColumns[idx].bSortable === false) {
				return;
			}

			var current = table.order();
			var dir = 'asc';
			if (current.length && current[0][0] === idx && current[0][1] === 'asc') {
				dir = 'desc';
			}

			table.order([idx, dir]).draw();

			// Miroir visuel des classes de tri sur la première ligne
			headerRow.removeClass('sorting sorting_asc sorting_desc').addClass('sorting');
			headerRow.eq(idx).addClass(dir === 'asc' ? 'sorting_asc' : 'sorting_desc');
		});

		// Empêche la ligne des filtres de déclencher un tri
		jQuery('#table_chantier thead tr:eq(1) th').removeClass('sorting sorting_asc sorting_desc').off('click');

		// Nettoie ces classes si DataTables les remet après un draw
		table.on('draw.dt', function() {
			jQuery('#table_chantier thead tr:eq(1) th').removeClass('sorting sorting_asc sorting_desc');
		});

		jQuery('.filter input').on('keyup', function() {
			var column = jQuery(this).attr("linkcolumn");
			table
				.columns(column)
				.search(this.value)
				.draw();
		});
	});

	function ClickChantier(object, id_chantier) {
		jQuery("body").css("cursor", "progress");
		jQuery(".suivi_strategie").removeClass("fa fa-exclamation-triangle fa-fw");
		jQuery(".suivi_strategie").addClass("fa fa-spinner fa-pulse fa-fw");
		jQuery(".liste_rapport").addClass("fa fa-spinner fa-pulse fa-fw");
		jQuery("#tabs").tabs("option", "disabled", [1, 2]);
		jQuery("#alert_strategie").hide();
		jQuery(".selected_chantier").removeClass("selected_chantier");

		jQuery(object).parent().addClass("selected_chantier");

		jQuery('html,body').animate({
			scrollTop: 0
		}, 700);

		jQuery("#suivi_chantier_loader").empty();
		jQuery("#liste_rapport_loader").empty();
		jQuery("#planning_loader").empty();

		jQuery('#id_chantier').val(id_chantier);
		jQuery('#chantier_selected').html(jQuery(object).parent().find("td:eq(0)").html() + " : " + jQuery(object).parent().find("td:eq(1)").html() + " " + jQuery(object).parent().find("td:eq(2)").html() + " " + jQuery(object).parent().find("td:eq(3)").html());

		jQuery.ajax({
			url: debutUrl + "&task=ListeStrategieChantier&format=raw&id_chantier=" + id_chantier + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>",
			dataType: 'JSON',
			// async: false, 
			success: function(data) {
				result = data;
				var select = jQuery('#sl_strategie_chantier');
				select.empty();

				for (var i = 0; i < result.length; i++) {
					var item = result[i];
					let option = "<option value='" + item.idStrat + "' data-typestrategie=" + item.type_strategie + " data-reference=" + item.reference + " data-idechantillon=" + item.id_echantillon + ">" + item.reference + "</option>";
					select.append(option);
				}

				if (result.length == 0) {
					jQuery(".suivi_strategie").removeClass("fa fa-spinner fa-pulse fa-fw");
					jQuery(".suivi_strategie").addClass("fa fa-exclamation-triangle fa-fw");
					jQuery("#alert_strategie").show();
				}

				if (result.length >= 1) {
					ChangeStrategie();
				}

				// if(result.length > 1)
				// ChangeStrategie();

			},
			error: function(data) {
				console.log(data);
			},
			error: function(data) {
				console.log(data);
			}
		});
		let temp = debutUrl + "&task=ListeRapportChantier&format=raw&id_chantier=" + id_chantier + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";

		jQuery.ajax({
			url: debutUrl + "&task=ListeRapportChantier&format=raw&id_chantier=" + id_chantier + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>",
			// async: false, 
			success: function(data) {
				jQuery("#liste_rapport_loader").empty(); // on met dans le div le résultat de la requête ajax
				jQuery("#liste_rapport_loader").append(data); // on met dans le div le résultat de la requête ajax
				jQuery("#tabs").tabs("enable", 2);
				jQuery("#tabs").tabs("refresh");
				jQuery(".liste_rapport").removeClass("fa fa-spinner fa-pulse fa-fw");
				jQuery("body").css("cursor", "default");
			}
		});
	}

	function ChangeStrategie() {
		var id_chantier = jQuery('#id_chantier').val();
		var id_echantillon = jQuery("#sl_strategie_chantier option:selected").data("idechantillon");
		var id_echantillon = jQuery("#sl_strategie_chantier option:selected").data("idechantillon");
		var ref_strategie = jQuery("#echantillon_strategie_chantier option:selected").text();

		let idStrategie = jQuery("#sl_strategie_chantier option:selected").val();
		let typeStrategie = jQuery("#sl_strategie_chantier option:selected").data("typestrategie");
		console.log('charge Strat :' + idStrategie);
		let url = debutUrl + "&task=SuiviStrategieLoader&id_strategie=" + idStrategie + "&id_echantillon=" + id_echantillon + "&id_chantier=" + id_chantier + "&ref_strategie=" + ref_strategie + "&format=raw&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";

		jQuery.ajax({
			url: debutUrl + "&task=SuiviStrategieLoader&id_strategie=" + idStrategie + "&id_echantillon=" + id_echantillon + "&id_chantier=" + id_chantier + "&ref_strategie=" + ref_strategie + "&format=raw&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>",
			success: function(data) {
				jQuery("#suivi_chantier_loader").empty();
				if (id_echantillon != 0) {
					jQuery("#suivi_chantier_loader").append(data); // on met dans le div le résultat de la requête ajax
				}

				jQuery(".suivi_strategie").removeClass("fa fa-spinner fa-pulse fa-fw");
				jQuery("#tabs").tabs("enable", 1);
				jQuery("#tabs").tabs("refresh");
				jQuery("#tabs").tabs("option", "active", 1);
			}
		});

		/*
		jQuery.ajax({
			url: "<?php echo JURI::root(); ?>index.php?option=com_lepbi&task=ListeRevisionStrategieChantier&format=raw&id_echantillon=" + id_echantillon + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>",
			dataType: 'JSON',
			success: function(data) {
				result = data;
				var select = document.getElementById('revision_strategie_chantier');
				select.options.length = 0; // clear out existing items
				for (var i = 0; i < result.length; i++) {
					var item = result[i];
					select.options.add(new Option('v' + item.revision_strategie_chantier, item.id_strategie_chantier));
				}
				jQuery('#revision_strategie_chantier').val(jQuery('#revision_strategie_chantier option:last').val());
			}
		});*/
	}

	function TelechargeStrategie() {
		let idStrategie = jQuery("#sl_strategie_chantier").val();
		let typeStrategie = jQuery("#sl_strategie_chantier option:selected").data("typestrategie");
		let reference = jQuery("#sl_strategie_chantier option:selected").data("reference");

		var page = debutUrl + "&task=AfficheStrategie&format=raw&ref=" + reference + "&id_strategie=" + idStrategie + "&type_strategie=" + typeStrategie + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		//depart
		window.open(page, '_blank');
	}

	function Commander() {
		jQuery("#destinataire").dialog('destroy');
		var current_scroll = jQuery(document).scrollTop();
		//var id_echantillon = jQuery("#echantillon_strategie_chantier").val();
		var id_echantillon = jQuery("#sl_strategie_chantier option:selected").data("idechantillon");
		console.log(id_echantillon);
		var monurl = debutUrl + "&task=Commander&format=raw&id_echantillon=" + id_echantillon + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";

		jQuery("#commande_chantier_loader").load(monurl, function() {
			jQuery(this).dialog({
				height: 'auto',
				width: jQuery("#mainbody").width(),
				modal: true,
				open: function() {
					jQuery('.ui-widget-overlay').addClass('custom-overlay');
					jQuery('html,body').animate({
						scrollTop: 0
					}, 700);
					jQuery('.ui-dialog').css('top', 0);
				},
				close: function() {
					jQuery('.ui-widget-overlay').removeClass('custom-overlay');
					jQuery('html,body').animate({
						scrollTop: current_scroll
					}, 700);
				}
			});
		});
	}

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

	function Extraction(id_chantier, tokenchantier) {
		var page = debutUrl + "&task=Extraction&format=raw&id_chantier=" + id_chantier + "&debut_extraction=&fin_extraction=&tokenchantier=" + tokenchantier + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		window.location = page;
	}

	function BonCommandExcel(id_strategie, token_strategie) {
		var page = debutUrl + "&task=BonCommande&format=raw&id_strategie=" + id_strategie + "&tokenstrategie=" + token_strategie + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		window.location = page;
	}
</script>