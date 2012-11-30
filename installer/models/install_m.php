<?php 

use Illuminate\Database\Connection;

/**
* Install model
*
* @author PyroCMS Dev Team
* @package PyroCMS\Installer\Models
*
*/
class Install_m extends CI_Model
{
	public function set_default_structure(Connection $db, $input)
	{
		// @TODO Upgrade sha1 to password_hash()
		$salt = substr(md5(uniqid(rand(), true)), 0, 5);
		$input['password'] = sha1($input['password'].$salt);

		// Include migration config to know which migration to start from
		require PYROPATH.'config/migration.php';

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

		$pdo = $db->getPdo();

		$sql = file_get_contents('./sql/default.'.$input['driver'].'.sql');

		$replace = array(
			'{site_ref}' 	=> $input['site_ref'],
			'{session_table}' => config_item('sess_table_name'),

			':email'        => $pdo->quote($input['email']),
			':username'     => $pdo->quote($input['username']),
			':displayname'  => $pdo->quote($input['firstname'].' '.$input['lastname']),
			':password'     => $pdo->quote($input['password']),
			':firstname'    => $pdo->quote($input['firstname']),
			':lastname'     => $pdo->quote($input['lastname']),
			':salt'         => $pdo->quote($salt),
			':unix_now'     => time(),
			':migration'    => $config['migration_version'],
		);

		$sql = str_replace(array_keys($replace), array_values($replace), $sql);

		$pdo->exec($sql);
	}

}