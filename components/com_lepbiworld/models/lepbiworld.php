<?php
// no direct access
defined('_JEXEC') or die('Acces interdit');

jimport('joomla.application.component.model');

class LepbiworldModelLepbiworld extends JModelItem {

	function GetSharingKey() {
		$config = JFactory::getConfig();
		return $config->get('sharingkey');
	}

	function GetRemoteToken() {
		$config = JFactory::getConfig();
		return $config->get('remoteToken');
	}

	function CreateToken($key_token) {
		$config = JFactory::getConfig();
		$dbprefix = $config->get('dbprefix');

		$data = new stdClass();
		$data->id_token = null;
		$data->date_token = date("Y-m-d H:i:s");
		$data->key_token = $key_token;

		$db = $this->getDbo();
		$db->insertObject($dbprefix . 'token', $data, 'id_token');
		$id_token = $db->insertid();

		$query = "Select *
				from " . $dbprefix . "token
				where id_token = " . $id_token;
		$db->setQuery($query);
		$token = $db->loadObjectList();

		return $token[0]->key_token;
	}

	function CheckLocalToken($key_token) {
		$config = JFactory::getConfig();
		$dbprefix = $config->get('dbprefix');

		$query = "Select *
				from " . $dbprefix . "token
				where key_token = '" . $key_token . "'";
    
		$db = $this->getDbo();
		$db->setQuery($query);
		$token = $db->loadObjectList();

		//var_dump($token);
		if (count($token) != 0) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$conditions = array(
				$db->quoteName('id_token') . ' = ' . $db->quote($token[0]->id_token)
			);
			$query->delete($db->quoteName('#__token'));
			$query->where($conditions);
			$db->setQuery($query);
			$result = $db->execute();
			return "true";
		} else {
			return "false";
		}
	}

	function CheckRemoteToken($token) {
		$config = JFactory::getConfig();
		$remotetoken = $config->get('remoteToken');

		return file_get_contents($remotetoken . "/index.php?option=com_lepbiworld&task=CheckTokenLEPBI&token=" . $token . "&format=raw");
	}

	function LogHistory($user_loghistory, $client_loghistory, $type_client_loghistory, $type_loghistory, $log_loghistory) {
		// id_loghistory`, `user_loghistory`, `client_loghistory`, `type_loghistory`, `date_loghistory`, `log_loghistory`
		$data = new stdClass();
		$data->id_loghistory = null;
		$data->user_loghistory = $user_loghistory;
		$data->client_loghistory = $client_loghistory;
		$data->type_client_loghistory = $type_client_loghistory;
		$data->type_loghistory = $type_loghistory;
		$data->date_loghistory = date('Y-m-d H:i:s');
		$data->log_loghistory = $log_loghistory;

		$db = $this->getDbo();
		$db->insertObject('#__loghistory', $data, 'id_loghistory');
		$db->insertid();
	}

	function NouveauUtilisateur($login, $pwd, $client, $type_client) {
		$data = new stdClass();
		$data->id = null;
		$data->name = $login;
		$data->username = $login;
		$data->email = $login . "@lepbi.fr";
		$data->password = md5($pwd);
		$data->client = $client;
		$data->id_client = $client;
		$data->type_client = $type_client;
		$data->block = 0;
		$data->sendEmail = 0;
		$data->registerDate = date("Y-m-d H:i:s");
		$data->activation = 0;
		$data->params = '{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}';
		$data->otpKey = "";
		$data->otep = "";
		$data->requireReset = 1;

		$db = $this->getDbo();
		$db->insertObject('#__users', $data, 'id');
		$user_id =  $db->insertid();

		$data = new stdClass();
		$data->user_id = $user_id;
		$data->group_id = 2;

		$db = $this->getDbo();
		$db->insertObject('#__user_usergroup_map', $data);
		$db->insertid();

		if ($type_client == 1) {
			$data = new stdClass();
			$data->user_id = $user_id;
			$data->group_id = 11;

			$db = $this->getDbo();
			$db->insertObject('#__user_usergroup_map', $data);
			$db->insertid();
		}

		if ($type_client == 2) {
			$data = new stdClass();
			$data->user_id = $user_id;
			$data->group_id = 10;

			$db = $this->getDbo();
			$db->insertObject('#__user_usergroup_map', $data);
			$db->insertid();
		}

		return $user_id;
	}

	function ListeUtilisateurClient($client, $type_client) {
		$query = "Select *
				from #__users
				where id_client = '" . $client . "'
				and type_client = '" . $type_client . "'";
		$db = $this->getDbo();
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function ModifierLoginUtilisateur($id, $login) {
		$data = new stdClass();
		$data->id = $id;
		$data->name = $login;
		$data->username = $login;

		$db = $this->getDbo();
		$db->updateObject('#__users', $data, 'id');
	}

	function ModifierPWDUtilisateur($id, $pwd) {
		$data = new stdClass();
		$data->id = $id;
		$data->password = md5($pwd);
		$data->requireReset = 1;

		$db = $this->getDbo();
		$db->updateObject('#__users', $data, 'id');
	}

	function NouveauClient($ref_client, $nom_client, $siret_client, $telephone_client, $adresse_client, $ville_client, $cp_client, $adresse_facturation_client, $ville_facturation_client, $cp_facturation_client, $mail_client, $fax_client, $disable_client) {
		$data = new stdClass();
		$data->id_client = null;
		$data->ref_client = $ref_client;
		$data->nom_client = $nom_client;
		$data->siret_client = $siret_client;
		$data->telephone_client = $telephone_client;
		$data->adresse_client = $adresse_client;
		$data->ville_client = $ville_client;
		$data->cp_client = $cp_client;
		$data->adresse_facturation_client = $adresse_facturation_client;
		$data->ville_facturation_client = $ville_facturation_client;
		$data->cp_facturation_client = $cp_facturation_client;
		$data->mail_client = $mail_client;
		$data->fax_client = $fax_client;
		$data->disable_client = $disable_client;


		$db = $this->getDbo();
		$db->insertObject('#__client', $data, 'id_client');
		return $db->insertid();
	}

	function GetClientID($id_user) {
		$config = JFactory::getConfig();
		$dbprefix = $config->get('dbprefix');

		$query = "Select *
				from " . $dbprefix . "users
				where id = '" . $id_user . "'";
		$db = $this->getDbo();
		$db->setQuery($query);
		$users = $db->loadObjectList();
		if (count($users) != 0) {
			return $users[0]->client;
		} else {
			return 0;
		}
	}

	function AfficheUser($id_user) {
		$config = JFactory::getConfig();
		$dbprefix = $config->get('dbprefix');

		$query = "Select *
				from " . $dbprefix . "users
				where id = '" . $id_user . "'";
		$db = $this->getDbo();
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function ChangeClientUser($id_user, $type_client, $id_client) {
		$config = JFactory::getConfig();
		$dbprefix = $config->get('dbprefix');

		$data = new stdClass();
		$data->id = $id_user;
		$data->type_client = $type_client;
		$data->client = $id_client;

		$db = $this->getDbo();
		$db->UpdateObject('#__users', $data, 'id');


		$query = "Delete From #__user_usergroup_map
				where (user_id = '" . $id_user . "' and group_id = '10')
				OR (user_id = '" . $id_user . "' and group_id = '11')";
		$db = $this->getDbo();
		$db->setQuery($query);
		$db->execute();

		if ($type_client == 1) $type_client = '11';
		if ($type_client == 2) $type_client = '10';

		$data = new stdClass();
		$data->user_id = $id_user;
		$data->group_id = $type_client;
		$db = $this->getDbo();
		$db->insertObject('#__user_usergroup_map', $data);
		return $db->insertid();
	}
}
