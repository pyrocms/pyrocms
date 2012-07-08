<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Install model
*
* @author PyroCMS Dev Team
* @package PyroCMS\Installer\Models
*
*/
class Install_m extends CI_Model
{
	public function set_default_structure(PDO $db, $input)
	{
		// User settings
		$salt = substr(md5(uniqid(rand(), true)), 0, 5);
		$input['password'] = sha1($input['password'].$salt);

		// Include migration config to know which migration to start from
		require '../system/cms/config/migration.php';

		// Get the SQL for the default data and parse it

		// Do we want to create the database using the installer ?
		if ( ! empty($input['create_db']) and $input['engine'] == 'mysql')
		{
			$stmt = $db->prepare('CREATE DATABASE IF NOT EXISTS :database');
			$stmt->bindValue('database', $input['database']);
			$stmt->execute();
			unset($stmt);
		}

		$sql = file_get_contents('./sql/default.'.$input['engine'].'.sql');
		$sql = str_replace('{site_ref}', $input['site_ref'], $sql);

		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':email',        $input['email']);
		$stmt->bindValue(':username',     $input['username']);
		$stmt->bindValue(':displayname',  $input['firstname'].' '.$input['lastname']);
		$stmt->bindValue(':password',     $input['password']);
		$stmt->bindValue(':firstname',    $input['firstname']);
		$stmt->bindValue(':lastname',     $input['lastname']);
		$stmt->bindValue(':salt',         $salt);
		$stmt->bindValue(':now',          time(), PDO::PARAM_INT);
		$stmt->bindValue(':migration',    $config['migration_version'], PDO::PARAM_INT);

		$stmt->execute();

		var_dump($stmt);
	}

}