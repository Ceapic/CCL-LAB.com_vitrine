<?php 
	$id_client = $id_client;
?>
<STYLE>
	
	
</STYLE>
<?php
	// $i = 0;
	$save_echantillon = "";
	
	$RapportsFinaux = $model->ListeRapportsFinauxClient($id_client);
	foreach($model->ListeRapportsFinauxClient($id_client) as $oneRapportFinal){
		
		if($save_echantillon <> $oneRapportFinal->ref_echantillon){
			echo "
			<tr>
				<td class=\"\">".$oneRapportFinal->nom_chantier."</td>
				<td class=\"\">".$oneRapportFinal->adresse_chantier."</td>
				<td class=\"\">".$oneRapportFinal->ville_chantier."</td>
				<td class=\"\">".$oneRapportFinal->cp_chantier."</td>
				<td class=\"\" style=\"text-align: center;\">
					<select class=\"rapport_final\" style=\"width: 165px;\">";
		}
		
						$hash = md5($oneRapportFinal->id_rapport_final.$model->GetSharingKey());
						echo "<option value=\"".$oneRapportFinal->id_rapport_final."\" hash=\"".$hash."\">".str_replace("VS-", "RF-", $oneRapportFinal->ref_echantillon)." v".$oneRapportFinal->revision_rapport_final."</option>";

					
		if($save_echantillon <> $oneRapportFinal->ref_echantillon){
					echo "
					</select>
					<button style=\"margin-left: 5px;\" class=\"ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow show_rapport_final\" linkechantillon=\"".$oneRapportFinal->id_echantillon."\"><i class=\"fa fa-download\"></i></button>
				</td>
			</tr>";
		}
		
		$save_echantillon = $oneRapportFinal->ref_echantillon;
	}
	
?>

<script language="javascript" type="text/javascript">
	
</script>