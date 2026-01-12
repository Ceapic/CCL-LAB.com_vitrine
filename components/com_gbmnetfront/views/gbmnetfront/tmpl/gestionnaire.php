<?php
defined('_JEXEC') or die('Restricted access');

// $model = $this->getModel('gbmnetworldFront'); // nom model

// echo URL_MODELE."gbmnetworldFront.php";

require_once(URL_MODELE . "gbmnetFrontModel.php");
$model = new gbmnetFrontModel;
// var_dump($model);
// die();

$user = JFactory::getUser();
$id_user = $user->id;
// echo $id_user;
// die();
$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
// echo $token;
// 2147483647
$url = $model->GetRemoteToken() . "&task=ListeClient&token=" . $token . "&format=raw";

// echo $url;
$Clients = json_decode(file_get_contents($url));
// var_dump($Clients);
// echo $Clients;
// die();
if (isset($_POST['validation_client_user'])) {
    $model->ChangeClientUser($id_user, $_POST['type_client'], $_POST['id_client']);
    echo "<div class=\"alert-success\"> Modifications enregistrés</div>";
    header("Refresh:0");
}

$user = $model->AfficheUser($id_user);
// var_dump($user);
$id_client = $user[0]->client;
$type_client = $user[0]->type_client;

// echo $id_client;
// echo $type_client;
// die();
?>
<div class="panel panel-primary">
    <!-- <div class="panel-heading">
		<h3 class="panel-title">Gestionnaire</h3>
	</div> -->
    <form action="#" method="post">
        Type client :
        <select id="type_client" name="type_client" onchange="ChangeTypeClient(this);">
            <!-- <option value="0" disabled selected></option> -->
            <?php $opt = " ";
            if ($type_client == 1) $opt = "selected"; ?>
            <option value="1" <?php echo $opt; ?>>Interne</option>
            <?php $opt = "";
            if ($type_client == 2) $opt = "selected"; ?>
            <option value="2" <?php echo $opt; ?>>Externe</option>
        </select>

        Client :
        <select id="id_client" name="id_client">
            <option value="0"></option>
            <?php
            $disable = "";
            $save_type_client = $Clients[0]->type_client;

            foreach ($Clients as $oneClient) {
                $ref_client = $oneClient->ref_client;
                // $nbr = strlen($ref_client);
                $ref_client = "C".str_pad($ref_client, 3,"0",STR_PAD_LEFT);

                // $opt = "";
                // if (($oneClient->id_client == $id_client) && ($oneClient->type_client == $type_client)) $opt = "selected";
                $opt = (($oneClient->id_client == $id_client) && ($oneClient->type_client == $type_client))? "selected" : "";
                // $disable = "";
                // if ($type_client <> $oneClient->type_client) $disable = 'disabled="disabled"';
                $disable = ($type_client <> $oneClient->type_client)? 'disabled="disabled"' : "";
                $hide = ($type_client <> $oneClient->type_client)? 'hide' : "";
                echo "<option value=\"{$oneClient->id_client}\" class=\"type_client_{$oneClient->type_client} $hide\" {$opt} {$disable}>
                    {$ref_client} {$oneClient->nom_client}
                </option>";

                $save_type_client = $oneClient->type_client;
            }
            ?>
        </select>
        <button name="validation_client_user" style="margin-left: 5px; margin-bottom:9px;" class="ceapicworld_button_radius ceapicworld_button_blue ceapicworld_button_shadow">Valider</button>
    </form>
</div>
<div class="s2-event-log">
    <ul class="js-event-log"></ul>
</div>

<script language="javascript" type="text/javascript">
    // jQuery('#id_client').select2();
    

    function ChangeTypeClient(object) {
        // jQuery('#id_client').val('0').trigger('change');
        jQuery('#id_client').val('0').select();
        jQuery(".type_client_1").removeAttr('disabled').removeClass('hide');
        jQuery(".type_client_2").removeAttr('disabled').removeClass('hide');
        if (jQuery(object).val() == 1) jQuery(".type_client_2").attr('disabled', 'disabled').addClass('hide');
        if (jQuery(object).val() == 2) jQuery(".type_client_1").attr('disabled', 'disabled').addClass('hide');
        // jQuery('#id_client').select2();

        console.log("true");
    }
</script>

<!-- 
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    axios.post(<?php $url ?>)
        .then(response => {
            console.log('Response from API:', response.data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
</script> -->