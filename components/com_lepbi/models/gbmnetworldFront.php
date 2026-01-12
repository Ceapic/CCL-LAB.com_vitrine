<?php
defined('_JEXEC') or die;

// jimport('joomla.application.component.modelitem');
// ModelgbmnetworldFront 
// extends JModelItem
class gbmnetworldFront
{
	function GetSharingKey(){
		$config = JFactory::getConfig();
		return $config->get('sharingkey');
	}

	function CheckRemoteToken($token) {
		$config = JFactory::getConfig();
		$remotetoken = $config->get('remotetoken');
		return file_get_contents($remotetoken . "/index.php?option=com_lepbi&task=CheckTokenCEAPIC&token=" . $token . "&format=raw");
	}

	function GetRemoteToken(){
		$config = JFactory::getConfig();
		return $config->get('remotetoken');
	}

    
	function CreateToken($key_token){
		$config = JFactory::getConfig();
		$dbprefix = $config->get('dbprefix');
		
		$data =new stdClass();
		$data->id_token = null;
		$data->date_token = date("Y-m-d H:i:s");
		$data->key_token = $key_token;
		$db = JFactory::getDbo();
		
		$db->insertObject($dbprefix.'token', $data, 'id_token');
		$id_token = $db->insertid();
		
		$query = "Select *
				from ".$dbprefix."token
				where id_token = ".$id_token;
		$db->setQuery($query);
		$token = $db->loadObjectList();
		
		return $token[0]->key_token;
	}
	



	function CheckLocalToken($key_token){
		// echo "salut etape local token";
		// die();
		$config = JFactory::getConfig();
		$dbprefix = $config->get('dbprefix');
		
		$query = "Select *
				from ".$dbprefix."token
				where key_token = '".$key_token."'";
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$token = $db->loadObjectList();
		// var_dump($token);
		// echo $token;
		// die();
		if(count($token) <> 0){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$conditions = array(
				$db->quoteName('id_token') . ' = ' . $db->quote($token[0]->id_token)
			);
			// $query->delete($db->quoteName('#__token'));
			// $query->where($conditions);
			// $db->setQuery($query);
			// $result = $db->execute();
			// echo "yes";
			return "true";
		}else{
			// echo "no";
			return "false";
		}
	}





















	function AfficheUser($id_user){
		$config = JFactory::getConfig();
		$dbprefix = $config->get('dbprefix');
		
		$query = "Select *
				from ".$dbprefix."users
				where id = '".$id_user."'";
		$db = JFactory::getDbo();
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	function ChangeClientUser($id_user, $type_client, $id_client){

		$config = JFactory::getConfig();
		$dbprefix = $config->get('dbprefix');
		
		$data =new stdClass();
		$data->id = $id_user;
		$data->type_client = $type_client;
		$data->client = $id_client;

		$db = JFactory::getDbo();
		$db->UpdateObject( '#__users', $data, 'id' );

		// echo "changeclient user";
		// var_dump($data);
		// die();
		$query = "Delete From #__user_usergroup_map
				where (user_id = '".$id_user."' and group_id = '11')
				OR (user_id = '".$id_user."' and group_id = '12')";
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$db->execute();
		
		if ($type_client == 1) $type_client = '11';
		if ($type_client == 2) $type_client = '12';
		
		$data =new stdClass();
		$data->user_id = $id_user;
		$data->group_id = $type_client;		
		$db = JFactory::getDbo();
		$db->insertObject('#__user_usergroup_map', $data);
		return $db->insertid();
		
	}


	////////////////////////////////////////////////////// mes-processus ////////////////////////////////////////////////////////
	
}





?>
