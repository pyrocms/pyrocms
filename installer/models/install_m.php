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
		
		if ($input['engine'] === 'mysql')
		{
			// Do we want to create the database using the installer?
			empty($input['create_db']) or $db->exec("CREATE DATABASE IF NOT EXISTS {$input['database']}");

			$db->exec("USE {$input['database']}");
		}

		if ($input['engine'] === 'pgsql')
		{
			// Do we want to create the database using the installer?
			empty($input['create_db']) or $db->exec("CREATE DATABASE IF NOT EXISTS {$input['database']}");

			$db->exec("USE {$input['database']}");
		}

		$sql = file_get_contents('./sql/default.'.$input['engine'].'.sql');

		/* 
		TODO Binding parameters via the usual method produces the ever-so-helpful error:
			 Uncaught exception 'PDOException' with message 'SQLSTATE[HY000]: General error: 25 bind or 
			 column index out of range'
	
		$sql = $db->prepare($sql);
		
		$stmt->bindValue(':email',        $input['email']);
		$stmt->bindValue(':username',     $input['username']);
		$stmt->bindValue(':displayname',  $input['firstname'].' '.$input['lastname']);
		$stmt->bindValue(':password',     $input['password']);
		$stmt->bindValue(':firstname',    $input['firstname']);
		$stmt->bindValue(':lastname',     $input['lastname']);
		$stmt->bindValue(':salt',         $salt);
		$stmt->bindValue(':unix_now',     time(), PDO::PARAM_INT);
		$stmt->bindValue(':migration',    $config['migration_version'], PDO::PARAM_INT);

		$sql = $db->prepare($sql);
		*/

		$replace = array(
			'{site_ref}' => $input['site_ref'],
			'{session_table}' => config_item('sess_table_name'),

			':email'        => $db->quote($input['email']),
			':username'     => $db->quote($input['username']),
			':displayname'  => $db->quote($input['firstname'].' '.$input['lastname']),
			':password'     => $db->quote($input['password']),
			':firstname'    => $db->quote($input['firstname']),
			':lastname'     => $db->quote($input['lastname']),
			':salt'         => $db->quote($salt),
			':unix_now'     => time(),
			':migration'    => $config['migration_version'],
		);


		$sql = str_replace(array_keys($replace), array_values($replace), $sql);

		$db->exec($sql);
	}

}