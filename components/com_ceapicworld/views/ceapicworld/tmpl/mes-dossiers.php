<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.calendar');


JHtml::script("components/com_ceapicworld/js/jquery/jquery-1.12.4.min.js");
JHtml::script("components/com_ceapicworld/js/jquery-ui-1.12.1/jquery-ui.min.js");
JHtml::script("components/com_ceapicworld/js/jquery-ui-1.12.1/jquery.ui.datepicker-fr.js");

JHtml::stylesheet("components/com_ceapicworld/js/jquery-ui-1.12.1/jquery-ui.min.css");
JHtml::stylesheet("components/com_ceapicworld/css/font-awesome/css/font-awesome.min.css");

JHtml::script('components/com_ceapicworld/js/DataTables/media/js/jquery.dataTables.min.js');
JHtml::stylesheet('components/com_ceapicworld/js/DataTables/media/css/jquery.dataTables.min.css');

$model = $this->getModel('ceapicworld'); // nom model

$user = JFactory::getUser();
if ($user->type_client <> 2) die('Restricted access');

$id_client = $user->client;
$type_client = $user->type_client;
$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));

$date_debut = date("Y-m-01", strtotime("-4 month"));
if (isset($_POST['date_debut'])) $date_debut = date("Y-m-d", strtotime($_POST['date_debut']));
$date_fin = date("Y-m-t");
if (isset($_POST['date_fin'])) $date_fin = date("Y-m-d", strtotime($_POST['date_fin']));
/*
$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=ListeEchantillonAnalyse&date_debut=" . $date_debut . "&date_fin=" . $date_fin . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";
$Echantillons = json_decode(file_get_contents($url));
*/

$urlDossier = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=ListeDossierExterne&date_debut=" . $date_debut . "&date_fin=" . $date_fin . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";
//echo $urlDossier;
$dossiers = json_decode(file_get_contents($urlDossier));
//var_dump($dossiers);
//die();

$sharingkey = $model->GetSharingKey();
$token_client = md5($id_client . $type_client . $sharingkey);

// $date_debut_meta = date("01-m-Y");
// if (isset($_POST['date_debut_meta'])) $date_debut_meta = $_POST['date_debut_meta'];
// $date_fin_meta = date("t-m-Y");
// if (isset($_POST['date_fin_meta'])) $date_fin_meta = $_POST['date_fin_meta'];

// $date_debut_materiau = date("01-m-Y");
// if (isset($_POST['date_debut_materiau'])) $date_debut_materiau = $_POST['date_debut_materiau'];
// $date_fin_materiau = date("t-m-Y");
// if (isset($_POST['date_fin_materiau'])) $date_fin_materiau = $_POST['date_fin_materiau'];

$date_debut = date("01-m-Y", strtotime("-4 month"));
if (isset($_POST['date_debut'])) $date_debut = $_POST['date_debut'];
$date_fin = date("t-m-Y");
if (isset($_POST['date_fin'])) $date_fin = $_POST['date_fin'];


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

  #table_analyse>tbody>tr:hover {
		cursor: pointer;
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

	.ceapicworld_button_green {
		border: 1px solid #3be344;
		background: linear-gradient(#99ed84, #5ce33b);
	}

	.ui-datepicker-trigger {
		border: none;
		background: none;
	}

	#display_loading {
		display: none;
		position: fixed;
		z-index: 1000;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		background: rgba(255, 255, 255, .8);
	}

	#loading_content {
		position: absolute;
		top: 50%;
		left: 50%;
		text-align: center;
	}

	.ceapicworld_button_blue {
		border: 1px solid #2664e8;
		background: linear-gradient(#77bcf1, #2694e8);
	}
</STYLE>

<div id="div_liste_echantillon" class="panel panel-primary">
	<div class="panel-heading">
	</div>


	<!--<div class="row">
			<div class="col-sm" style="text-align: right;">
				<b>Export des analyses de META :</b>   du <input type="text" class="date" name="date_debut_meta" id="date_debut_meta" value="<?php echo $date_debut_meta; ?>" style="width: 80px; text-align: center;" readonly/>
				au <input type="text" class="date" name="date_fin_meta" id="date_fin_meta" value="<?php echo $date_fin_meta ?>" style="width: 80px; text-align: center;" readonly/>
				<button type="button" class="ceapicworld_button_radius ceapicworld_button_green ceapicworld_button_shadow" style="margin-left:10px; margin-bottom:10px;" onClick="ExtractionAnalyseDate('META')"><i class="fa fa-file-excel-o"></i> Export excel</button>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm"  style="text-align: right;">
				<b>Export des analyses de matériaux :</b>   du <input type="text" class="date" name="date_debut_materiau" id="date_debut_materiau" value="<?php echo $date_debut_materiau ?>" style="width: 80px; text-align: center;" readonly/>
				au <input type="text" class="date" name="date_fin_materiau" id="date_fin_materiau" value="<?php echo $date_fin_materiau ?>" style="width: 80px; text-align: center;" readonly/>
				<button type="button" class="ceapicworld_button_radius ceapicworld_button_green ceapicworld_button_shadow" style="margin-left:10px; margin-bottom:10px;" onClick="ExtractionAnalyseDate('MAT')"><i class="fa fa-file-excel-o"></i> Export excel</button>
			</div>
		</div>-->
	<div>

		<!-- <div class="row">
			<div class="col-md" style="text-align: right;">
				<!-- Du <input type="text" class="date" name="date_debut_meta" id="date_debut_meta" value="<?php echo $date_debut_meta; ?>" style="width: 80px; text-align: center;" readonly /> -->
		<!-- au <input type="text" class="date" name="date_fin_meta" id="date_fin_meta" value="<?php echo $date_fin_meta ?>" style="width: 80px; text-align: center;" readonly /> -->
		<!-- <button type="button" class="ceapicworld_button_radius ceapicworld_button_green ceapicworld_button_shadow" style="margin-left:10px; margin-bottom:10px;" onClick="ExtractionAnalyseDate('META')"><i class="fa fa-file-excel-o"></i> Export excel META</button>				 -->
		<!-- </div> -->
		<!-- </div> -->

		<!-- <div class="row"> -->
		<!-- <div class="col-md" style="text-align: right;"> -->
		<!-- Du <input type="text" class="date" name="date_debut_materiau" id="date_debut_materiau" value="<?php echo $date_debut_materiau ?>" style="width: 80px; text-align: center;" readonly /> -->
		<!-- au <input type="text" class="date" name="date_fin_materiau" id="date_fin_materiau" value="<?php echo $date_fin_materiau ?>" style="width: 80px; text-align: center;" readonly /> -->
		<!-- <button type="button" class="ceapicworld_button_radius ceapicworld_button_green ceapicworld_button_shadow" style="margin-left:10px; margin-bottom:10px;" onClick="ExtractionAnalyseDate('MAT')"><i class="fa fa-file-excel-o"></i> Export excel Matériau</button> -->
		<!-- </div> -->
		<!-- </div> -->
	</div>

	<form action="#" method="post" name="myForm">
		<div class="row">
			<div class="col-sm" style="text-align: center;">
				Du <input type="text" class="date" name="date_debut" id="date_debut" value="<?php echo $date_debut ?>" style="width: 80px; text-align: center;" readonly />
				au <input type="text" class="date" name="date_fin" id="date_fin" value="<?php echo $date_fin ?>" style="width: 80px; text-align: center;" readonly />
				<button type="button" class="ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow" style="margin-left:10px; margin-bottom:10px;" onClick="Refresh()"><i class="fa fa-refresh"></i> Actualiser </button>
				<button type="button" class="ceapicworld_button_radius ceapicworld_button_green ceapicworld_button_shadow" style="margin-left:10px; margin-bottom:10px;" onClick="ExtractionAnalyseDate('META')"><i class="fa fa-file-excel-o"></i> Exportation Excel META</button>
				<button type="button" class="ceapicworld_button_radius ceapicworld_button_green ceapicworld_button_shadow" style="margin-left:10px; margin-bottom:10px;" onClick="ExtractionAnalyseDate('MAT')"><i class="fa fa-file-excel-o"></i> Exportation Excel Matériau</button>
			</div>
		</div>
	</form>

	<!--  -->
	<table id="table_analyse" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<td></td>
				<td linkcolumn="1">Référence Client</td>
				<td linkcolumn="2">Référence Laboratoire</td>
				<td linkcolumn="3">Date Enregistrement </td>
				<td linkcolumn="4">Nb Ech</td>
				<td linkcolumn="5">Actions</td>
				<td linkcolumn="6" style="display:none;">Actions</td>


				<!-- <td>Ref ech ceapic</td> -->
				<!-- <td>Ref ech client</td> -->
			</tr>
			<tr>
				<td></td>
				<td linkcolumn="1" class="filter" sizeinput="200">Ref Client</td>
				<td linkcolumn="2" class="filter" sizeinput="200">Ref Ceapic</td>
				<td linkcolumn="3" class="filter" sizeinput="200"></td>
				<td linkcolumn="4" class="filter" sizeinput="80"></td>
				<td linkcolumn="5" class=""></td>
				<td linkcolumn="6" class="" style="display:none;"></td>

			</tr>

		</thead>
		<tbody>
			<?php
			/*foreach ($Echantillons as $oneEchantillon) {
				$hashEchantillon = md5($oneEchantillon->id_echantillon_analyse . $model->GetSharingKey());
				$hashDossier = md5($oneEchantillon->id_dossier . $model->GetSharingKey());
				$colonne_ref_echantillon = $oneEchantillon->ref_echantillon_analyse;

				if ($oneEchantillon->validation == "1")
					$colonne_ref_echantillon = "<p class=\"show_analyse\" linkechantillon=" . $oneEchantillon->id_echantillon_analyse . " hash=" . $hashEchantillon . "><span class=\"href\">" . $oneEchantillon->ref_echantillon_analyse . "</span></p>";

				echo "<tr>
					<td class=\"colonne1\">" . $oneEchantillon->chantier_analyse_dossier . "</td>
					<td class=\"colonne2\">" . $oneEchantillon->ref_client_echantillon_analyse . "</td>
					<td class=\"colonne3\"><p class=\"show_dossier\" linkdossier=" . $oneEchantillon->id_dossier . " hash=" . $hashDossier . ">" . $oneEchantillon->ref_dossier . "</td>
					<td class=\"colonne4\">" . $colonne_ref_echantillon . "</td>
				</tr>";
			}*/

			foreach ($dossiers as $dossier) {
        
				if ($dossier->nb_ech > 0) {
         
					$hashDossier = md5($dossier->id_dossier . $sharingkey);
					// $adresse= "window.open(index.php?option=com_ceapicworld&task=ListeEchantillonAnalyse&date_debut=" . $date_debut . "&date_fin=" . $date_fin . "&id_dossier=" . $dossier->id_dossier . "&token=" . $token . "&format=raw', '_blank')";
					// onClick="'.$adresse.'">

					$btnExoMulti = "";
					if ($dossier->is_multi == "true") {
						$btnExoMulti = '<button type="button" 
							class="show_analyse ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow" 
							data-refechantillon="' . $dossier->ref_dossier . '"
							data-typeanalyse="multi"
							hash="' . md5($dossier->id_dossier . $sharingkey) . '"
							linkechantillon="' . $dossier->id_dossier . '" 
							style="margin-left:10px; margin-bottom:10px;">							
							<i class="fa fa-file-excel-o"></i> 							
						</button>';
					}

					echo '<tr>
					<td>  
						<span type="button" class="gbmnet_button_circle gbmnet_button_blue gbmnet_button_shadow"><i class="fa fa-angle-down toggle-row" style="margin: 0px 1px;"></i></span>
					</td>
					<td class="colonne1">' . $dossier->ref_dossier_client . '</td>
					<td class="colonne2"><p class="show_dossier" linkdossier="' . $dossier->id_dossier . '" hash="' . $hashDossier . '">' . $dossier->ref_dossier . '</td>
										<td class="colonne3">' . $dossier->date_dossier . '</td>
					<td class="colonne4">' . $dossier->nb_ech . '</td>
					<td class="colonne5">' . $btnExoMulti . '</td>
					<td class="data" style="display:none;">' . json_encode($dossier->echantillons) . '</td>

				</tr>';
				}
			}

			?>
		</tbody>
	</table>
</div>

<div id="display_loading">
	<div id="loading_content"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>
		<div><b>Extraction en cours</b></div>
	</div>
</div>

<script language="javascript" type="text/javascript">
	jQuery('#div_liste_echantillon').on('click', '.show_analyse', function() {
		// jQuery(this).find(".href").html().replace(" ", "-")
		let ref_echantillon = jQuery(this).data("refechantillon");
		let typeAnalyse = jQuery(this).data("typeanalyse");
		var page = "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=AfficheAnalyseEchantillon&format=raw&ref=" + ref_echantillon + "&typeAnalyse=" + typeAnalyse + "&id=" + jQuery(this).attr("linkechantillon") + "&tokenechantillon=" + jQuery(this).attr("hash") + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		    window.open(page, '_blank');
	});

	jQuery(document).ready(function() {
		jQuery(function() {
			jQuery(".date").datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd-mm-yy',
				showOn: 'both',
				buttonText: '<i class="fa fa-calendar fa-lg"></i>'
			});
		});

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
			let colonne = parseInt(e) + 1;
			jQuery(this).html('<input type="text" placeholder="' + title + '" linkcolumn=' + colonne + ' style="width:' + sizeinput + 'px;"/>');
		});

		// DataTable
		var table = jQuery('#table_analyse').DataTable({
			"pageLength": 25,
			"order": [],
			"lengthChange": false,
			"info": false,
			"searching": true,
      "autoWidth": true,
			"language": {
				sSearch: "Rechercher :",
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

		// Add event listener for opening and closing details
		jQuery('#table_analyse tbody').on('click', 'tr td:not(:last-child)', function() {
			var tr = jQuery(this).parent();
			var row = table.row(tr);

			if (row.data() != undefined) {
				if (row.child.isShown()) {
					// This row is already open - close it
					row.child.hide();
					tr.removeClass('shown');
					jQuery(tr).find('i.toggle-row').removeClass('fa-angle-up');
					jQuery(tr).find('i.toggle-row').addClass('fa-angle-down');
				} else {
					// Open this row
					row.child(Data2Table(row)).show();
					tr.addClass('shown');
					jQuery(tr).find('i.toggle-row').removeClass('fa-angle-down');
					jQuery(tr).find('i.toggle-row').addClass('fa-angle-up');
				}
			}
		});

		function Data2Table(Trow) {
			var echantillons = JSON.parse(Trow.data()[6]);
			let rows = "";

			if (echantillons) {
				echantillons.forEach(ech => {
					rows += "<tr>";

					rows += "<td>" + ech.ref_client_echantillon_analyse + "</td>";
					rows += "<td>" + ech.ref_echantillon_analyse + "</td>";

					hashEchantillon = ech.tokenEchantillon;
					rows += "<td>" + ech.nom_qualification_analyse + "</td>";
					rows += "<td>";
					if (ech.has_mono == "1") {
						rows += '<button class="show_analyse ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow" data-typeanalyse="mono" data-refechantillon="' + ech.ref_echantillon_analyse + '" linkechantillon="' + ech.id_echantillon_analyse + '" hash="' + hashEchantillon + '"><i class="fa fa-file-pdf-o"></i> </button>';
					}
					rows += "</td>";


					rows += "</tr>";
				});
			}

			return `<table cellpadding="5" cellspacing="0" border="0" style="width:100%;padding-left:50px;">
                        <thead>
						<tr>
						<td colspan="4">
							Echantillons
						</td>
						</tr>
						<tr>
                            <td>Réf Client</td>
                            <td>Réf Ceapic</td>                            
                            <td>Type Analyse </td>                                                        
                            <td>Actions</td>
                        </tr>
						</thead>
						<tbody>
                        ${rows}
						</tbody>
                    </table>`;
		}

	});




	function ExtractionAnalyseDate(type_extract) {

		jQuery('#display_loading').show();

		var split_date_debut = jQuery('#date_debut').val().split('-');
		var date_debut = split_date_debut[2] + '-' + split_date_debut[1] + '-' + split_date_debut[0];

		var split_date_fin = jQuery('#date_fin').val().split('-');
		var date_fin = split_date_fin[2] + '-' + split_date_fin[1] + '-' + split_date_fin[0];

		var page = "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=ExtractionAnalyseDate&date_debut=" + date_debut + "&date_fin=" + date_fin + "&type_extract=" + type_extract + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>&format=raw";
		
		jQuery.ajax({
			url: page,
			success: function(data) {
				jQuery('#display_loading').hide();
				window.location = page;
			}
		});
	}

	function Refresh() {
		var split_date_debut = jQuery('#date_debut').val().split('-');
		var date_debut = new Date(split_date_debut[2], split_date_debut[1], split_date_debut[0]);

		var split_date_fin = jQuery('#date_fin').val().split('-');
		var date_fin = new Date(split_date_fin[2], split_date_fin[1], split_date_fin[0]);

		if (date_debut <= date_fin) {
			if (MonthDiff(date_debut, date_fin) <= 12) {
				jQuery("form").submit();
			} else {
				alert("Vous ne pouvez excéder 1an d'affichage");
			}
		} else {
			alert("La date de début ne peut pas être supérieur à la date de fin");
		}
	}

	function MonthDiff(dateFrom, dateTo) {
		return dateTo.getMonth() - dateFrom.getMonth() + (12 * (dateTo.getFullYear() - dateFrom.getFullYear()));
	}
</script>