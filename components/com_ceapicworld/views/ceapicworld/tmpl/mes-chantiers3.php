<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	JHtml::_('behavior.formvalidation');
	JHtml::_('behavior.calendar');
	
	JHtml::script("components/com_ceapicworld/js/jquery/jquery-1.12.4.min.js");
	JHtml::script("components/com_ceapicworld/js/jquery-ui-1.12.1/jquery-ui.min.js");
	JHtml::script("components/com_ceapicworld/js/jquery-ui-1.12.1/jquery.ui.datepicker-fr.js");
	JHtml::script("components/com_ceapicworld/js/sheetJS/xlsx.full.min.js");
	
	JHtml::stylesheet("components/com_ceapicworld/js/jquery-ui-1.12.1/jquery-ui.min.css");
	JHtml::stylesheet("components/com_ceapicworld/css/font-awesome/css/font-awesome.min.css");
	
	JHtml::script('components/com_ceapicworld/js/DataTables/media/js/jquery.dataTables.min.js');
	JHtml::stylesheet('components/com_ceapicworld/js/DataTables/media/css/jquery.dataTables.min.css');
	
	$model = $this->getModel('ceapicworld'); // nom model
	
	$user = JFactory::getUser();
	if ($user->type_client <> 1) die('Restricted access');
	
	$id_client = $user->client;
	$type_client = $user->type_client;
	$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
	
	$url = $model->GetRemoteToken()."/index.php?option=com_ceapicworld&task=ListeChantier&id_client=".$id_client."&token=".$token."&format=raw";
	$Chantiers = json_decode(file_get_contents($url));


	$sharingkey = $model->GetSharingKey();
	$token_client = md5($id_client.$type_client.$sharingkey);
	
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
	
	#table_chantier th{
		padding: 0px;
	}
	
	.ui-widget-overlay.custom-overlay{
		background-color: black;
		background-image: none;
		opacity: 0.9;
		z-index: 1040;    
	}
	
	#table_chantier .colonne1{
		width: 10%;
	}
	
	#table_chantier .colonne2{
		width: 50%;
	}
	
	#table_chantier .colonne3{
		width: 20%;
	}
	
	#table_chantier .colonne4{
		width: 10%;
	}
	
	#table_chantier .colonne5{
		width: 9%;
	}
	
	#table_chantier .colonne6{
		width: 1%;
	}
	
	#table_chantier tr:hover td{
		cursor: pointer;
		background-color: #30a8f4;
	}
	
	#table_chantier tr.selected_chantier td{
		background-color: #30a8f4;
	}
	
	.dataTables_filter{
		display: none;
	}
	
	.ceapicworld_button_radius{
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
	
	.ceapicworld_button_blue{
		border: 1px solid #2664e8;
		background: linear-gradient(#77bcf1, #2694e8);
	}
	
	.ceapicworld_button_green{
		border: 1px solid #3be344;
		background: linear-gradient(#99ed84, #5ce33b);
	}
	.info-news-red{
		float: right; 
		font-family: arial; 
		font-weight: bold;
		color: red;
		font-size: 16px;
	}
	.info-news{
		float: right; 
		font-family: arial; 
		font-weight: bold;
		font-size: 16px;
	}
	
	.ceapicworld_button_shadow:hover{
		box-shadow: 0 5px 5px 0 rgba(0,0,0,0.24), 0 10px 10px 0 rgba(0,0,0,0.19);
	}
	
	i.fa-file-excel-o{
		color: green;
	}
</STYLE>
<!--<table align="center" style="width: 98%; border-collapse: collapse; border: 1px solid;" border="0">
	<tr style="background: #85c1e9 ;"><td style="padding: 5px; width: 100%;">Réglementaire ambiance code de la santé publique (CSP)</td></tr>
	<tr style="background: #82e0aa ;"><td style="padding: 5px; width: 100%;">Réglementaire ambiance code du travail (CT)</td></tr>
	<tr style="background: #f7dc6f ;"><td style="padding: 5px; width: 100%;">Réglementaire opérateur code du travail (CT) : Mesures déclenchées suivant vos besoins</td></tr>
	<tr style="background: #c39bd3 ;"><td style="padding: 5px; width: 100%;">Hors stratégie d’échantillonnage</td></tr>
	<tr style="background: #d7dbdd ;"><td style="padding: 5px; width: 100%;">Mesures non réglementaire</td></tr>
</table>-->

<div id="alert_strategie" class="hide" style="background-color: #c3d2e5; color: #0055bb; border-top: 3px solid #84a7db; border-bottom: 3px solid #84a7db; padding-left: 1em; font-weight: bold;"><p>Il n’y a pas de stratégie pour ce chantier ou celle-ci n’est pas disponible </p></div>

<h3 class="panel-title" id="chantier_selected">Veuillez sélectionner un chantier</h3>

<div id="tabs">
	<ul>
		<li><a href="#div_liste_chantier"><i class="liste_chantier"></i>Liste des chantiers</a></li>
		<li><a href="#div_suivi_chantier"><i class="suivi_strategie"></i>Suivi stratégie</a></li>
		<li><a href="#div_liste_rapport"><i class="liste_rapport"></i>Liste des rapports</a></li>
	</ul>
	<div id="div_liste_chantier" class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Liste des chantiers<span class="info-news">Extraction des données via Excel <i class="fa fa-file-excel-o"></i></span></h3>
		</div>
		<table id="table_chantier" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="filter" sizeinput="100">Référence</th>
					<th class="filter" sizeinput="300">Adresse</th>
					<th class="filter" sizeinput="160">Ville</th>
					<th class="filter" sizeinput="100">Code postal</th>
					<th class="filter" sizeinput="100">Date mesure</th>
					<th></th>
				</tr>
				<tr>
					<th>Référence</th>
					<th>Adresse</th>
					<th>Ville</th>
					<th>Code postal</th>
					<th>Date 1<sup>ère</sup> mesure</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($Chantiers as $oneChantier){
					$token_chantier = md5($oneChantier->id_chantier.$type_client.$sharingkey);
					if($oneChantier->date_pose_presta_echantillon == ''){$date_chantier = "-";}else{$date_chantier = date('d/m/Y',strtotime($oneChantier->date_pose_presta_echantillon));}
					if($oneChantier->id_strategie_chantier == ''){ $icon_strat = "<i class=\"fa fa-circle-o\" aria-hidden=\"true\"></i>"; }else{ $icon_strat = "<i class=\"fa fa-dot-circle-o\" aria-hidden=\"true\"></i>"; }
					echo "<tr><td class=\"colonne1\" onClick=\"ClickChantier(this, ".$oneChantier->id_chantier.")\"><span style=\"white-space: nowrap;\">".$icon_strat ." ". $oneChantier->nom_chantier."</span></td><td class=\"colonne2\" onClick=\"ClickChantier(this, ".$oneChantier->id_chantier.")\">".$oneChantier->adresse_chantier."</td><td class=\"colonne3\" onClick=\"ClickChantier(this, ".$oneChantier->id_chantier.")\">".$oneChantier->ville_chantier."</td><td class=\"colonne4\" onClick=\"ClickChantier(this, ".$oneChantier->id_chantier.")\">".$oneChantier->cp_chantier."</td><td class=\"colonne5\" onClick=\"ClickChantier(this, ".$oneChantier->id_chantier.")\">".$date_chantier."</td><td class=\"colonne6\"><i class=\"fa fa-file-excel-o\" onClick=\"Extraction(".$oneChantier->id_chantier.",'".$token_chantier."')\"></i></td></tr>";
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
			<select size="1" id="echantillon_strategie_chantier" name="echantillon_strategie_chantier" onChange="ChangeStrategie()">
				<option value="0"></option>
			</select>
			
			<select size="1" id="revision_strategie_chantier" name="revision_strategie_chantier" style="width: 60px;">
			</select>
			
			<button class="ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow" onClick="TelechargeStrategie()"><i class="fa fa-download"></i> Télécharger la stratégie</button>
			
			<button class="ceapicworld_button_radius ceapicworld_button_green ceapicworld_button_shadow" style="float: right;" onClick="Commander()"><i class="fa fa-calendar-check-o"></i> Planifier une intervention</button>
			
		</div>
		<div id="suivi_chantier_loader"></div>
		<div id="commande_chantier_loader" title="Réservation"></div>
	</div>
	
	<div id="div_liste_rapport" class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Liste des rapports</h3>
		</div>
		<div style="display: flex;">
			<div style="width: 75%; height: 37px; float: left;">
				<span class="info-news-red" style="  line-height: 37px; float: right;">Nouveauté : possibilité de télécharger tous les rapports d'un chantier en un seul clic <i class="fa fa-arrow-right" aria-hidden="true"></i></span>
			</div>
			<div style="width: 25%; height: 37px; float: right;">
				<button class="ceapicworld_button_radius ceapicworld_button_green ceapicworld_button_shadow" style="float: right;" onClick="DownloadAllRapport()"><i class="fa fa-download"></i> Télécharger tous les rapports</button>
			</div>
		</div>
		<div id="liste_rapport_loader" style="margin-top: 10px;"></div>
	</div>
</div>

<input type="text" id="id_chantier" name="id_chantier" value="" style="display: none;"/>

<script language="javascript" type="text/javascript">
	
	jQuery('#suivi_chantier_loader').on('click', '.show_rapport_echantillon', function(){
		var page = "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=AfficheRapportEchantillon&format=raw&ref="+ jQuery(this).find(".href").html().replace(" ", "-")+"&id_echantillon="+ jQuery(this).attr("link")+"&tokenechantillon="+ jQuery(this).attr("hash")+"&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		window.open(page,'_blank' );
	});
	
	jQuery('#liste_rapport_loader').on('click', '.show_rapport', function(){
		var page = "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=AfficheRapport&format=raw&ref="+ jQuery(this).find(".href").html().replace(" ", "-")+"&id_echantillon="+ jQuery(this).attr("linkechantillon")+"&id_rapport="+ jQuery(this).attr("linkrapport")+"&tokenrapport="+ jQuery(this).attr("hash")+"&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		window.open(page,'_blank' );
	});
	
	function DownloadAllRapport(){
		var ref_chantier = jQuery('#chantier_selected').text().split(':')[0].replace(/ /g, "").replace("/", "-");
		var page = "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=DownloadAllRapportChantier&format=raw&id_chantier="+ jQuery('#id_chantier').val() +"&ref_chantier="+ ref_chantier +"&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		window.open(page,'_blank' );
	}
	
	jQuery(document).ready(function(){
		// =============================================
		// Resize page
		// =============================================
		jQuery( "#mainbody" ).css("min-height", "");
		
		// =============================================
		// Tabs
		// =============================================
		jQuery( "#tabs" ).tabs();
		jQuery( "#tabs" ).tabs("option", "disabled", [1, 2]);
		
		// =============================================
		// DataTable filter - Chantier
		// =============================================
		
		 // Setup - add a text input to each footer cell
		jQuery('.filter').each( function (e) {
			var title = jQuery(this).text();
			var sizeinput = jQuery(this).attr("sizeinput");
			jQuery(this).html( '<input type="text" placeholder="'+title+'" linkcolumn='+e+' style="width:'+sizeinput+'px;"/>' );
		} );
	 
		// Retourne une valeur pour trier par date
		jQuery.fn.dataTable.ext.type.order['date-type-pre'] = function ( data ) {
			var DateSplit = data.split("/");
			return DateSplit[2] + DateSplit[1] + DateSplit[0];
		};
		
		// DataTable
		var table = jQuery('#table_chantier').DataTable({
			"pageLength": 25,
			"order": [],
			"lengthChange": false,
			"info": false,
			"columnDefs": [ 
				{
					"type": "date-type",
					"targets": -2
				},{
					"orderable": false,
					"targets": -1
				}
			],
			 "language": {
				"paginate": {
					"first":      "Première",
					"last":       "Dernière",
					"next":       "Suivant",
					"previous":   "Précédent"
				},
				"zeroRecords": "Aucun résultat",
				"info": "_PAGE_ / _PAGES_",
				"infoEmpty": "Aucun résultat",
				"infoFiltered": "(filtered from _MAX_ total records)"
			}
			// "searching": false
		});
		
		jQuery('.filter input').on( 'keyup', function () {
			var column = jQuery(this).attr("linkcolumn");
			table
				.columns( column )
				.search( this.value )
				.draw();
		} );
	});
	
	function ClickChantier(object, id_chantier) {
		jQuery("body").css("cursor", "progress");
		jQuery(".suivi_strategie").removeClass("fa fa-exclamation-triangle fa-fw");
		jQuery(".suivi_strategie").addClass("fa fa-spinner fa-pulse fa-fw");
		jQuery(".liste_rapport").addClass("fa fa-spinner fa-pulse fa-fw");
		jQuery( "#tabs" ).tabs("option", "disabled", [1, 2]);
		jQuery("#alert_strategie").hide();
		jQuery(".selected_chantier").removeClass("selected_chantier");
		
		jQuery(object).parent().addClass("selected_chantier");
		
		jQuery('html,body').animate({scrollTop: 0}, 700);
		
		jQuery("#suivi_chantier_loader").empty();
		jQuery("#liste_rapport_loader").empty();
		jQuery("#planning_loader").empty();
		
		jQuery('#id_chantier').val(id_chantier);
		jQuery('#chantier_selected').html(jQuery(object).parent().find("td:eq(0)").html()+ " : " + jQuery(object).parent().find("td:eq(1)").html()+ " " + jQuery(object).parent().find("td:eq(2)").html()+ " " + jQuery(object).parent().find("td:eq(3)").html());
		
		jQuery.ajax({
			url: "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=ListeStrategieChantier&format=raw&id_chantier="+ id_chantier+"&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>",
			dataType: 'JSON',
			// async: false, 
			success: function(data) {
				result = data;
				var select = document.getElementById('echantillon_strategie_chantier');
				select.options.length = 0; // clear out existing items
				if(result.length > 1)
					select.options.add(new Option('', 0))
				for (var i = 0; i < result.length; i++) {
					var item = result[i];
					select.options.add(new Option(item.ref_echantillon.replace("VS-", "RS-"), item.id_echantillon))
				}
				
				if(result.length == 0){
					jQuery(".suivi_strategie").removeClass("fa fa-spinner fa-pulse fa-fw");
					jQuery(".suivi_strategie").addClass("fa fa-exclamation-triangle fa-fw");
					jQuery("#alert_strategie").show();
				}
				
				if(result.length >= 1){
					ChangeStrategie()
				}
				
				// if(result.length > 1)
					// ChangeStrategie();
				
			}
		});
		
		jQuery.ajax({
			url: "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=ListeRapportChantier&format=raw&id_chantier="+ id_chantier+"&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>",
			// async: false, 
			success: function(data) {
				jQuery("#liste_rapport_loader").empty(); // on met dans le div le résultat de la requête ajax
				jQuery("#liste_rapport_loader").append(data); // on met dans le div le résultat de la requête ajax
				jQuery("#tabs").tabs("enable", 2);
				jQuery(".liste_rapport").removeClass("fa fa-spinner fa-pulse fa-fw");
				jQuery("body").css("cursor", "default");
			}
		});
	}
	
	function ChangeStrategie() {
		var id_chantier = jQuery('#id_chantier').val();
		var id_echantillon = jQuery("#echantillon_strategie_chantier").val();
		var ref_strategie = jQuery("#echantillon_strategie_chantier option:selected").text();
		jQuery.ajax({
			url: "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=SuiviStrategieLoader&id_echantillon="+id_echantillon+"&id_chantier="+id_chantier+"&ref_strategie="+ref_strategie+"&format=raw&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>",
			success: function(data) {
				jQuery("#suivi_chantier_loader").empty(); // on met dans le div le résultat de la requête ajax
				if (id_echantillon != 0) jQuery("#suivi_chantier_loader").append(data); // on met dans le div le résultat de la requête ajax
				
				jQuery(".suivi_strategie").removeClass("fa fa-spinner fa-pulse fa-fw");
				jQuery( "#tabs" ).tabs("enable", 1);
				jQuery("#tabs").tabs("option", "active", 1);
			}
		});
		
		jQuery.ajax({
			url: "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=ListeRevisionStrategieChantier&format=raw&id_echantillon="+ id_echantillon+"&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>",
			dataType: 'JSON',
			success: function(data) {
				result = data;
				var select = document.getElementById('revision_strategie_chantier');
				select.options.length = 0; // clear out existing items
				for (var i = 0; i < result.length; i++) {
					var item = result[i];
					select.options.add(new Option('v'+item.revision_strategie_chantier, item.id_strategie_chantier));
				}
				jQuery('#revision_strategie_chantier').val(jQuery('#revision_strategie_chantier option:last').val());
			}
		});
	}
	
	function TelechargeStrategie(){
		var page = "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=AfficheStrategie&format=raw&ref="+ jQuery('#echantillon_strategie_chantier option:selected').html() +"-"+ jQuery('#revision_strategie_chantier option:selected').html() +"&id_strategie="+ jQuery('#revision_strategie_chantier').val() +"&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		window.open(page,'_blank' );
	}
	
	function Commander(){
		jQuery("#destinataire").dialog('destroy');
		var current_scroll = jQuery(document).scrollTop();
		var id_echantillon = jQuery("#echantillon_strategie_chantier").val();
		var monurl = "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=Commander&format=raw&id_echantillon="+ id_echantillon+"&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		jQuery("#commande_chantier_loader").load(monurl, function() {
			jQuery(this).dialog({
				height: 'auto',
				width:jQuery("#mainbody").width(),
				modal: true,
				open: function() {
					jQuery('.ui-widget-overlay').addClass('custom-overlay');
					jQuery('html,body').animate({scrollTop: 0}, 700);
					jQuery('.ui-dialog').css('top', 0);
				},
				close: function() {
					jQuery('.ui-widget-overlay').removeClass('custom-overlay');
					jQuery('html,body').animate({scrollTop: current_scroll}, 700);
				}  
			});		
		});
	}
	
	function Extraction(id_chantier, tokenchantier){
		var page = "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=Extraction&format=raw&id_chantier="+id_chantier+"&debut_extraction=&fin_extraction=&tokenchantier="+tokenchantier+"&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		window.location = page;
	}
	
	function BonCommandExcel(id_strategie, token_strategie){
		var page = "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=BonCommande&format=raw&id_strategie="+id_strategie+"&tokenstrategie="+token_strategie+"&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		window.location = page;
	}
	
</script>