<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.calendar');

JHtml::script("components/com_lepbiworld/js/jquery/jquery-1.12.4.min.js");
JHtml::script("components/com_lepbiworld/js/jquery-ui-1.12.1/jquery-ui.min.js");
JHtml::script("components/com_lepbiworld/js/jquery-ui-1.12.1/jquery.ui.datepicker-fr.js");
JHtml::script("components/com_lepbiworld/js/select2/select2.full.min.js");

JHtml::stylesheet("components/com_lepbiworld/js/jquery-ui-1.12.1/jquery-ui.min.css");
JHtml::stylesheet("components/com_lepbiworld/css/font-awesome/css/font-awesome.min.css");
JHtml::stylesheet("components/com_lepbiworld/js/select2/select2.css");

// JHtml::script('components/com_lepbiworld/js/DataTables/media/js/jquery.dataTables.min.js');
// JHtml::stylesheet('components/com_lepbiworld/js/DataTables/media/css/jquery.dataTables.min.css');

$model = $this->getModel('lepbiworld'); // nom model

$user = JFactory::getUser();
if ($user->type_client <> 1) die('Restricted access');

$id_client = $user->client;
$type_client = $user->type_client;
$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));

$url = $model->GetRemoteToken() . "/index.php?option=com_lepbiworld&task=ListeChantier&id_client=" . $id_client . "&token=" . $token . "&format=raw";
$Chantiers = json_decode(file_get_contents($url));


$sharingkey = $model->GetSharingKey();
$token_client = md5($id_client . $type_client . $sharingkey);

$token_chantier = md5("0" . $type_client . $sharingkey);

?>


<STYLE type="text/css">
	input.select2-search__field {
		height: 30px;
	}

	.ui-datepicker-trigger {
		border: none;
		background: none;
	}

	input.date {
		width: unset;
	}

	.lepbiworld_button_radius {
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

	.lepbiworld_button_blue {
		border: 1px solid #2664e8;
		background: linear-gradient(#77bcf1, #2694e8);
	}

	.lepbiworld_button_shadow:hover {
		box-shadow: 0 5px 5px 0 rgba(0, 0, 0, 0.24), 0 10px 10px 0 rgba(0, 0, 0, 0.19);
	}
</STYLE>

<h3 class="panel-title">Extraction</h3>

<select id="chantier_extraction">
	<option value="0" tokenchantier="<?php echo $token_chantier; ?>">Tous</option>
	<?php
	foreach ($Chantiers as $oneChantier) {
		$token_chantier = md5($oneChantier->id_chantier . $type_client . $sharingkey);
		echo "<option value=\"" . $oneChantier->id_chantier . "\" tokenchantier=\"" . $token_chantier . "\">" . $oneChantier->nom_chantier . " " . $oneChantier->ref_client_chantier . " " . $oneChantier->adresse_chantier . " " . $oneChantier->cp_chantier . " " . $oneChantier->ville_chantier . "</option>";
	}
	?>
</select>

du <input id="debut_extraction" class="date" value="01<?php echo date('-m-Y'); ?>" />
au <input id="fin_extraction" class="date" value="<?php echo date('d-m-Y'); ?>" />
<button class="lepbiworld_button_radius lepbiworld_button_blue lepbiworld_button_shadow" onClick="Extraction()"><i class="fa fa-download"></i> Extraction</button>



<script language="javascript" type="text/javascript">
	jQuery(document).ready(function() {
		// =============================================
		// Resize page
		// =============================================
		jQuery("#mainbody").css("min-height", "");

		// =============================================
		// Select menu
		// =============================================
		jQuery('#chantier_extraction').select2({
			width: '500px'
		});

		// =============================================
		// Date calendrier
		// =============================================
		jQuery(".date").each(function() {
			jQuery(this).attr('size', 10);
			jQuery(this).attr('readonly', true);
			jQuery(this).css('text-align', 'center');
			jQuery(this).datepicker({
				dateFormat: 'dd-mm-yy',
				showOn: "both",
				showButtonPanel: true,
				buttonText: '<i class="fa fa-calendar fa-lg"></i>'
			});
		});

		jQuery.datepicker._gotoToday = function(id) {
			jQuery(id).datepicker('setDate', new Date()).datepicker('hide').blur();
		};
	});

	function Extraction() {
		var debut = jQuery("#debut_extraction").val();
		var fin = jQuery("#fin_extraction").val();

		var dt1 = new Date(debut.split('-')[2], debut.split('-')[1], debut.split('-')[0]);
		var dt2 = new Date(fin.split('-')[2], fin.split('-')[1], fin.split('-')[0]);

		var diff = (dt2.getTime() - dt1.getTime()) / 1000;
		diff /= (60 * 60 * 24);

		if (diff / 365.25 > 1) {
			alert("Veuillez sélectionner une fourchette de date inférieur ou égale à 1an");
		} else {
			var page = "<?php echo JURI::root(); ?>index.php?option=com_lepbiworld&task=Extraction&format=raw&id_chantier=" + jQuery('#chantier_extraction').val() + "&debut_extraction=" + jQuery('#debut_extraction').val() + "&fin_extraction=" + jQuery('#fin_extraction').val() + "&tokenchantier=" + jQuery('#chantier_extraction').find('option:selected').attr('tokenchantier') + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
			window.location = page;
			// alert(page);
		}
	}
</script>