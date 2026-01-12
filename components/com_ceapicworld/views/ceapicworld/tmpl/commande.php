<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	JHtml::_('behavior.formvalidation');
	JHtml::_('behavior.calendar');
	
	JHtml::script("components/com_ceapicworld/js/jquery/jquery-1.12.4.min.js");
	JHtml::script("components/com_ceapicworld/js/jquery-ui-1.12.1/jquery-ui.min.js");
	
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
	
	$url = $model->GetRemoteToken()."/index.php?option=com_ceapicworld&task=ListeStrategieClient&id_client=".$id_client."&token=".$token."&format=raw";
	$Strategies = json_decode(file_get_contents($url));


	$sharingkey = $model->GetSharingKey();
	$token_client = md5($id_client.$type_client.$sharingkey);
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
	
	#table_strategie .colonne1{
		width: 10%;
	}
	
	#table_strategie .colonne2{
		width: 51%;
	}
	
	#table_strategie .colonne3{
		width: 15%;
	}
	
	#table_strategie .colonne4{
		width: 5%;
	}
	
	#table_strategie .colonne5{
		width: 19%;
	}
	
	.dataTables_filter{
		display: none;
	}
	
	.ceapicworld_button_radius{
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
	
	.ceapicworld_button_blue{
		border: 1px solid #2694e8;
		background: #3baae3 url("/Joomla4/images/ui-bg_glass_50_3baae3_1x400.png") 50% 50% repeat-x;
	}
	
	.ceapicworld_button_shadow:hover{
		box-shadow: 0 5px 5px 0 rgba(0,0,0,0.24), 0 10px 10px 0 rgba(0,0,0,0.19);
	}
</STYLE>

<div id="div_liste_strategie" class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Liste des stratégies</h3>
	</div>
	<table id="table_strategie" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th class="filter" sizeinput="70">Ref chantier</th>
				<th class="filter" sizeinput="200">Adresse</th>
				<th class="filter" sizeinput="100">Ville</th>
				<th class="filter" sizeinput="40">CP</th>
				<th class="filter" sizeinput="70">Ref stratégie</th>
			</tr>
			<tr>
				<th>Ref chantier</th>
				<th>Adresse</th>
				<th>Ville</th>
				<th>CP</th>
				<th>Ref stratégie</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$save_strategie = "";
			// foreach ($Strategies as $oneStrategie){
			for ($i = 0; $i <= (count($Strategies)-1); $i++){
				$oneStrategie = $Strategies[$i];
				// $hash = md5($oneStrategie->id_strategie_chantier.$model->GetSharingKey());
				if(($save_strategie <> $oneStrategie->ref_echantillon) && ($i <> 0))
				echo "</select><button style=\"margin-left: 5px;\" class=\"ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow\" onClick=\"AfficheStrategie(this)\"><i class=\"fa fa-download\"></i></button></td></tr>";
				
				if($save_strategie <> $oneStrategie->ref_echantillon){
					echo "
					<tr>
						<td class=\"colonne1\">".$oneStrategie->nom_chantier."</td>
						<td class=\"colonne2\">".$oneStrategie->adresse_chantier."</td>
						<td class=\"colonne3\">".$oneStrategie->ville_chantier."</td>
						<td class=\"colonne4\">".$oneStrategie->cp_chantier."</td>
						<td class=\"colonne5\">
							<select class=\"strategie_chantier\" style=\"width: 160px;\">";
				}
								echo "<option value=\"".$oneStrategie->id_strategie_chantier."\">".str_replace("VS-", "RS-", $oneStrategie->ref_echantillon)." v".$oneStrategie->revision_strategie_chantier."</option>";
				
				// <p class=\"show_strategie\" linkstrategie=".$oneStrategie->id_strategie_chantier."><span class=\"href\">".str_replace("VS-", "RS-", $oneStrategie->ref_echantillon)." v".$oneStrategie->revision_strategie_chantier."</span></p>
				$save_strategie = $oneStrategie->ref_echantillon;
			}
			echo "</select><button style=\"margin-left: 5px;\" class=\"ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow\" onClick=\"AfficheStrategie(this)\"><i class=\"fa fa-download\"></i></button></td></tr>";
			?>
		</tbody>
	</table>
</div>


<script language="javascript" type="text/javascript">
	
	// jQuery('#div_liste_strategie').on('click', '.show_strategie', function(){
	function AfficheStrategie(object){
		var page = "<?php echo JURI::root(); ?>index.php?option=com_ceapicworld&task=AfficheStrategie&format=raw&ref="+ jQuery(object).parent().find('.strategie_chantier option:selected').html().replace(" ", "-")+"&id_strategie="+ jQuery(object).parent().find('.strategie_chantier').val()+"&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
		// alert(page);
		window.open(page,'_blank' );
	}
	
	jQuery(document).ready(function(){
		// =============================================
		// Resize page
		// =============================================
		jQuery( "#mainbody" ).css("min-height", "");
		
		// =============================================
		// DataTable filter - Echantillon
		// =============================================
		
		 // Setup - add a text input to each footer cell
		jQuery('.filter').each( function (e) {
			var title = jQuery(this).text();
			var sizeinput = jQuery(this).attr("sizeinput");
			jQuery(this).html( '<input type="text" placeholder="'+title+'" linkcolumn='+e+' style="width:'+sizeinput+'px;"/>' );
		} );
	 
		// DataTable
		var table = jQuery('#table_strategie').DataTable({
			"pageLength": 25,
			"order": [],
			"lengthChange": false,
			"info": false,
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
		});
		
		jQuery('.filter input').on( 'keyup', function () {
			var column = jQuery(this).attr("linkcolumn");
			table
				.columns( column )
				.search( this.value )
				.draw();
		} );
		
		// =============================================
		// Change pour la dernière version de la stratégie
		// =============================================
		jQuery( ".strategie_chantier" ).each(function(){
			jQuery(this).val(jQuery(this).find('option:LAST').val());
		});
	});	
</script>