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

JHtml::script("components/com_ceapicworld/js/select2/select2.full.min.js");
JHtml::stylesheet('components/com_ceapicworld/js/select2/select2.css');


JHtml::script("components/com_ceapicworld/js/GBMNET-select/GBMNET-select.js");
JHtml::stylesheet('components/com_ceapicworld/js/GBMNET-select/GBMNET-select.css');



$model = $this->getModel('ceapicworld'); // nom model

$user = JFactory::getUser();
$id_user = $user->id;

$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));

$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=ListeClient&token=" . $token . "&format=raw";
// echo $url;
$Clients = json_decode(file_get_contents($url));

if (isset($_POST['validation_client_user'])) {
    $model->ChangeClientUser($id_user, $_POST['type_client'], $_POST['id_client']);
    echo "<div class=\"alert-success\"> Modifications enregistrés</div>";
    header("Refresh:0");
}

$user = $model->AfficheUser($id_user);

$id_client = $user[0]->client;
$type_client = $user[0]->type_client;
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

    #table_strategie .colonne1 {
        width: 10%;
    }

    #table_strategie .colonne2 {
        width: 51%;
    }

    #table_strategie .colonne3 {
        width: 15%;
    }

    #table_strategie .colonne4 {
        width: 5%;
    }

    #table_strategie .colonne5 {
        width: 19%;
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

    .select2-container--default .select2-results__option[aria-disabled=true] {
        display: none;
    }
</STYLE>

<div class="panel panel-primary">
    <div class="panel-heading">
    </div>
    <form action="#" method="post">
        <div style="display: flex;align-items: baseline;gap: 15px;">
            Type client :
            <select id="type_client" name="type_client" class="GBMNET_select" onChange="ChangeTypeClient(this);">
                <?php $opt = "";
                if ($type_client == 1) $opt = "selected"; ?>
                <option value="1" <?php echo $opt; ?>>Interne</option>
                <?php $opt = "";
                if ($type_client == 2) $opt = "selected"; ?>
                <option value="2" <?php echo $opt; ?>>Externe</option>
            </select>

            Client :
            <select id="id_client" name="id_client" class="GBMNET_select">
                <option value="0"></option>
                <?php
                $disable = "";
                $save_type_client = $Clients[0]->type_client;

                foreach ($Clients as $oneClient) {
                    $ref_client = $oneClient->ref_client;
                    $nbr = strlen($ref_client);
                    if ($nbr == 1) {
                        $ref_client = "00" . $ref_client;
                    }
                    if ($nbr == 2) {
                        $ref_client = "0" . $ref_client;
                    }

                    $opt = "";
                    if (($oneClient->id_client == $id_client) && ($oneClient->type_client == $type_client)) $opt = "selected";
                    $disable = "";
                    if ($type_client != $oneClient->type_client) {
                        $disable = 'disabled="disabled"';
                    }
                    echo "<option value=\"" . $oneClient->id_client . "\" class=\"type_client_" . $oneClient->type_client . "\" " . $opt . " " . $disable . ">C" . $ref_client . " " . $oneClient->nom_client . "</option>";

                    $save_type_client = $oneClient->type_client;
                }
                ?>
            </select>
            <button name="validation_client_user" style="margin-left: 5px;" class="ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow">Valider</button>

        </div>
    </form>
</div>
<div class="s2-event-log">
    <ul class="js-event-log"></ul>
</div>

<script language="javascript" type="text/javascript">
    //jQuery('#id_client').select2();

    jQuery(document).ready(function() {
        setTimeout(function() {
            //jQuery('#type_client').GBMNET_SELECT();
            //jQuery('#id_client').GBMNET_SELECT();
        }, 100);
    });

    function ChangeTypeClient(object) {
        jQuery('#id_client').val('0');

        // Appeler refresh si le plugin est disponible
        if (jQuery('#id_client')[0].GBMNET_SELECT) {
            //jQuery('#id_client').GBMNET_SELECT('refresh');
        }

        jQuery(".type_client_1").show();
        jQuery(".type_client_2").show();

        if (jQuery(object).val() == 1) {
            jQuery(".type_client_2").hide();
        }

        if (jQuery(object).val() == 2) {
            jQuery(".type_client_1").hide();
        }

        /*jQuery(".type_client_1").attr('disabled', '').removeAttr('disabled');
        jQuery(".type_client_2").attr('disabled', '').removeAttr('disabled');
        if (jQuery(object).val() == 1) jQuery(".type_client_2").attr('disabled', 'disabled');
        if (jQuery(object).val() == 2) jQuery(".type_client_1").attr('disabled', 'disabled');*/
        //jQuery('#id_client').select2();
    }
</script>