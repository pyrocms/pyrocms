<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Users extends Module {

	public $version = '0.8';
	
	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Uporabniki',
				'en' => 'Users',
				'nl' => 'Gebruikers',
				'pl' => 'Użytkownicy',
				'es' => 'Usuarios',
				'fr' => 'Utilisateurs',
				'de' => 'Benutzer',
				'pt' => 'Usuários',
				'zh' => '用戶',
				'it' => 'Utenti',
				'ru' => 'Пользователи',
				'ar' => 'المستخدمون',
				'cs' => 'Uživatelé',
				'fi' => 'Käyttäjät',
				'el' => 'Χρήστες',
				'he' => 'משתמשים',
				'lt' => 'Vartotojai'
			),
			'description' => array(
				'sl' => 'Dovoli uporabnikom za registracijo in prijavo na strani, urejanje le teh preko nadzorne plošče',
				'en' => 'Let users register and log in to the site, and manage them via the control panel.',
				'nl' => 'Laat gebruikers registreren en inloggen op de site, en beheer ze via het controlepaneel.',
				'pl' => 'Pozwól użytkownikom na logowanie się na stronie i zarządzaj nimi za pomocą panelu.',
				'es' => 'Permite el registro de nuevos usuarios quienes podrán loguearse en el sitio. Estos podrán controlarse desde el panel de administración.',
				'fr' => 'Permet aux utilisateurs de s\'enregistrer et de se connecter au site et de les gérer via le panneau de contrôle',
				'de' => 'Erlaube Benutzern das Registrieren und Einloggen auf der Seite und verwalte sie über die Admin-Oberfläche.',
				'pt' => 'Permite com que usuários se registrem e entrem no site e também que eles sejam gerenciáveis apartir do painel de controle.',
				'zh' => '讓用戶可以註冊並登入網站，並且管理者可在控制台內進行管理。',
				'it' => 'Fai iscrivere de entrare nel sito gli utenti, e gestiscili attraverso il pannello di controllo.',
				'ru' => 'Управление зарегистрированными пользователями, активирование новых пользователей.',
				'ar' => 'تمكين المستخدمين من التسجيل والدخول إلى الموقع، وإدارتهم من لوحة التحكم.',
				'cs' => 'Umožňuje uživatelům se registrovat a přihlašovat a zároveň jejich správu v Kontrolním panelu.',
				'fi' => 'Antaa käyttäjien rekisteröityä ja kirjautua sisään sivustolle sekä mahdollistaa niiden muokkaamisen hallintapaneelista.',
				'el' => 'Παρέχει την δυνατότητα εγγραφής λογαριασμών χρηστών και σύνδεσης τους στους επισκέπτες του ιστοτόπου. Με αυτό το πρόσθετο μπορείτε επίσης να τους διαχειριστείτε.',
				'he' => 'ניהול משתמשים: רישום, הפעלה ומחיקה',
				'lt' => 'Leidžia vartotojams registruotis ir prisijungti prie puslapio, ir valdyti juos per administravimo panele.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'	  => FALSE
		);
	}
	
	public function install()
	{
		//This is handled by the installer only so that a default user can be created.
		return FALSE;
	}

	public function uninstall()
	{
		//it's a core module, lets keep it around
		return FALSE;
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}
	
	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "<h4>Overview</h4>
		<p>The Users module works together with Groups and Permissions to give PyroCMS access control.</p>
		<h4>Add a User</h4><hr>
		<p>Fill out the user's details (including a password) and save. If you have activation emails enabled in Settings
		an email will be sent to the new user with an activation link.</p>
		<h4>Activating New Users</h4><hr>
		<p>If activation emails are disabled in Settings users that register on the website front-end will appear under the Inactive Users
		menu item until you either approve or delete their account. If activation emails are enabled users may register silently, without an admin's help.</p>";
	}
}
/* End of file details.php */
