<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// $model = $this->getModel('ceapicworld'); // nom model

$model = new Gbmnetfront();

$user = JFactory::getUser();
if ($user->type_client != 1) die('Restricted access');

$id_client = $user->client;
$type_client = $user->type_client;
$token = Gbmnetfront::CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));

$url = Gbmnetfront::getUrlBack() . "/index.php?option=" . $GLOBALS["CBV"] . "&task=ListeStrategieClient&id_client=" . $id_client . "&token=" . $token . "&format=raw";
$Strategies = json_decode(file_get_contents($url));


$chantiers = [];

foreach ($Strategies as $strategie) {
    if (isset($chantiers[$strategie->id_echantillon])) {
        $chantier = $chantiers[$strategie->id_echantillon];
        $revisions = $chantier->revisions;
        $revisions[] = $strategie->revision_strategie_chantier;
        $chantier->revisions = $revisions;

        $idStrats = $chantier->id_strats;
        $idStrats[] = $strategie->id_strategie_chantier;
        $chantier->id_strats = $idStrats;

        $chantiers[$strategie->id_echantillon] = $chantier;
    } else {
        $chantier = new stdClass();
        $chantier = $strategie;
        $chantier->revisions = [$strategie->revision_strategie_chantier];
        $chantier->id_strats = [$strategie->id_strategie_chantier];
        $chantiers[$strategie->id_echantillon] = $chantier;
    }
}

// var_dump($chantiers);
// die();

$sharingkey = Gbmnetfront::GetSharingKey();
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
        background: #3baae3 url("/Joomla4/images/ui-bg_glass_50_3baae3_1x400.png") 50% 50% repeat-x;
    }

    .ceapicworld_button_shadow:hover {
        box-shadow: 0 5px 5px 0 rgba(0, 0, 0, 0.24), 0 10px 10px 0 rgba(0, 0, 0, 0.19);
    }

    .table-responsive-dt {
        width: 100%;
        max-width: 100%;
    }

    #table_strategie {
        width: 100% !important;
        max-width: 100%;
        table-layout: fixed;
        /* 🔑 empêche l’explosion des colonnes */
    }
</STYLE>

<div id="div_liste_strategie" class="panel panel-primary table-responsive-dt" style="padding: unset;">
    <div class="panel-heading">
    </div>
    <table id="table_strategie" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:70px;">Ref chantier</th>
                <th style="width:200px;">Adresse</th>
                <th style="width:100px;">Ville</th>
                <th style="width:40px;">CP</th>
                <th style="width:70px;">Ref stratégie</th>
            </tr>
            <tr>
                <th linkcolumn="1" class="filter">Ref chantier</th>
                <th linkcolumn="2" class="filter">Adresse</th>
                <th linkcolumn="3" class="filter">Ville</th>
                <th linkcolumn="4" class="filter">CP</th>
                <th linkcolumn="5" class="filter">Ref stratégie</th>
            </tr>

        </thead>
        <tbody>
            <?php
            foreach ($chantiers as $chantier) {
                echo "
					<tr>
						<td>" . $chantier->nom_chantier . "</td>
						<td>" . $chantier->adresse_chantier . "</td>
						<td>" . $chantier->ville_chantier . "</td>
						<td>" . $chantier->cp_chantier . "</td>
						<td>
                            <div style='display: flex;justify-content: space-evenly;align-items: center;'>
                            <input type=\"hidden\" class=\"typeStrategie\" value=\"" . $chantier->type_strategie . "\" />
							<select id=\"sl_" . $chantier->id_echantillon . "\" class=\"strategie_chantier\" style=\"margin-bottom:unset;width: 160px;\">";

                $cpt = 0;
                foreach ($chantier->revisions as $revision) {
                    echo '<option value="' . $chantier->id_strats[$cpt] . '">' . str_replace("VS-", "RS-", $chantier->ref_echantillon) . " v" . $revision . "</option>";
                    $cpt++;
                }
                echo "</select>";

                echo '<button style="margin-left: 5px;" class="ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow" onClick="AfficheStrategie(' . $chantier->id_echantillon . ', \'' . $chantier->type_strategie . '\')"> ';
                echo '<i class="fa fa-download"></i>';
                echo '</button>';
                echo '</div>';
                echo '</td></tr>';
            }

            /*
            $save_strategie = "";
            // foreach ($Strategies as $oneStrategie){
            for ($i = 0; $i <= (count($Strategies) - 1); $i++) {
                $oneStrategie = $Strategies[$i];
                $typestrategie = $oneStrategie->type_strategie;

                if (($save_strategie != $oneStrategie->ref_echantillon) && ($i != 0)) {
                    echo "</select>";
                    echo "<button style=\"margin-left: 5px;\" class=\"ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow\" onClick=\"AfficheStrategie(this)\"><i class=\"fa fa-download\"></i></button>";
                    echo "</td></tr>";
                }

                // Ouvrir un nouveau select pour la nouvelle stratégie
                if ($save_strategie != $oneStrategie->ref_echantillon) {
                    echo "
					<tr>
						<td>" . $oneStrategie->nom_chantier . "</td>
						<td>" . $oneStrategie->adresse_chantier . "</td>
						<td>" . $oneStrategie->ville_chantier . "</td>
						<td>" . $oneStrategie->cp_chantier . "</td>
						<td>
							<select class=\"strategie_chantier\" style=\"width: 160px;\">";
                }

                echo "<option value=\"" . $oneStrategie->id_strategie_chantier . "\">" . str_replace("VS-", "RS-", $oneStrategie->ref_echantillon) . " v" . $oneStrategie->revision_strategie_chantier . "</option>";
                echo '<input type="hidden" '
                    .     'class="typeStrategie" '
                    .     'value="' . htmlspecialchars($typestrategie, ENT_QUOTES) . '"'
                    . '>';
                // <p class=\"show_strategie\" linkstrategie=".$oneStrategie->id_strategie_chantier."><span class=\"href\">".str_replace("VS-", "RS-", $oneStrategie->ref_echantillon)." v".$oneStrategie->revision_strategie_chantier."</span></p>
                $save_strategie = $oneStrategie->ref_echantillon;
            }
            echo "</select>";
            echo "<button style=\"margin-left: 5px;\" class=\"ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow\" onClick=\"AfficheStrategie(this)\"><i class=\"fa fa-download\"></i></button>";
            echo "</td></tr>";*/
            ?>
        </tbody>
    </table>
</div>


<script language="javascript" type="text/javascript">
    var debutUrl = "<?php echo Gbmnetfront::GetUrlBack(); ?>/index.php?option=<?= $GLOBALS["CBV"] ?>";

    function AfficheStrategie(idEchantillon, typeStrategie) {
        let idStrategie = jQuery('#sl_' + idEchantillon).val();
        var page = debutUrl + "&task=AfficheStrategie&format=raw&type_strategie=" + typeStrategie + "&id_strategie=" + idStrategie + "&id_client=<?php echo $id_client; ?>&type_client=<?php echo $type_client; ?>&tokenclient=<?php echo $token_client; ?>";
        window.open(page, '_blank');
    }

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
            jQuery(this).html('<input type="text" placeholder="' + title + '" linkcolumn=' + e + ' style="width: 80%;max-width: 80%;margin:5px;"/>');
        });

        // DataTable
        var table = jQuery('#table_strategie').DataTable({
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

        // Active le tri sur la première ligne du thead uniquement
        var headerRow = jQuery('#table_strategie thead tr:eq(0) th');
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
        jQuery('#table_strategie thead tr:eq(1) th').removeClass('sorting sorting_asc sorting_desc').off('click');

        // Nettoie ces classes si DataTables les remet après un draw
        table.on('draw.dt', function() {
            jQuery('#table_strategie thead tr:eq(1) th').removeClass('sorting sorting_asc sorting_desc');
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