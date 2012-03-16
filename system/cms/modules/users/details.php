<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Users Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Users
 */
class Module_Users extends Module {

	public $version = '0.8';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Users',
				'ar' => 'المستخدمون',
				'br' => 'Usuários',
				'cs' => 'Uživatelé',
				'da' => 'Brugere',
				'de' => 'Benutzer',
				'el' => 'Χρήστες',
				'es' => 'Usuarios',
				'fi' => 'Käyttäjät',
				'fr' => 'Utilisateurs',
				'he' => 'משתמשים',
				'id' => 'Pengguna',
				'it' => 'Utenti',
				'lt' => 'Vartotojai',
				'nl' => 'Gebruikers',
				'pl' => 'Użytkownicy',
				'ru' => 'Пользователи',
				'sl' => 'Uporabniki',
				'zh' => '用戶',
				'hu' => 'Felhasználók'
			),
			'description' => array(
				'en' => 'Let users register and log in to the site, and manage them via the control panel.',
				'ar' => 'تمكين المستخدمين من التسجيل والدخول إلى الموقع، وإدارتهم من لوحة التحكم.',
				'br' => 'Permite com que usuários se registrem e entrem no site e também que eles sejam gerenciáveis apartir do painel de controle.',
				'cs' => 'Umožňuje uživatelům se registrovat a přihlašovat a zároveň jejich správu v Kontrolním panelu.',
				'da' => 'Lader brugere registrere sig og logge ind på sitet, og håndtér dem via kontrolpanelet.',
				'de' => 'Erlaube Benutzern das Registrieren und Einloggen auf der Seite und verwalte sie über die Admin-Oberfläche.',
				'el' => 'Παρέχει λειτουργίες εγγραφής και σύνδεσης στους επισκέπτες. Επίσης από εδώ γίνεται η διαχείριση των λογαριασμών.',
				'es' => 'Permite el registro de nuevos usuarios quienes podrán loguearse en el sitio. Estos podrán controlarse desde el panel de administración.',
				'fi' => 'Antaa käyttäjien rekisteröityä ja kirjautua sisään sivustolle sekä mahdollistaa niiden muokkaamisen hallintapaneelista.',
				'fr' => 'Permet aux utilisateurs de s\'enregistrer et de se connecter au site et de les gérer via le panneau de contrôle',
				'he' => 'ניהול משתמשים: רישום, הפעלה ומחיקה',
				'id' => 'Memungkinkan pengguna untuk mendaftar dan masuk ke dalam situs, dan mengaturnya melalui control panel.',
				'it' => 'Fai iscrivere de entrare nel sito gli utenti, e gestiscili attraverso il pannello di controllo.',
				'lt' => 'Leidžia vartotojams registruotis ir prisijungti prie puslapio, ir valdyti juos per administravimo panele.',
				'nl' => 'Laat gebruikers registreren en inloggen op de site, en beheer ze via het controlepaneel.',
				'pl' => 'Pozwól użytkownikom na logowanie się na stronie i zarządzaj nimi za pomocą panelu.',
				'ru' => 'Управление зарегистрированными пользователями, активирование новых пользователей.',
				'sl' => 'Dovoli uporabnikom za registracijo in prijavo na strani, urejanje le teh preko nadzorne plošče',
				'zh' => '讓用戶可以註冊並登入網站，並且管理者可在控制台內進行管理。',
                                'hu' => 'Hogy a felhasználók tudjanak az oldalra regisztrálni és belépni, valamint lehessen őket kezelni a vezérlőpulton.'
			),
			'frontend' => false,
			'backend'  => true,
			'menu'	  => false,
			'shortcuts' => array(
				array(
				    'name' => 'user_add_title',
				    'uri' => 'admin/users/create',
				    'class' => 'add'
				),
		    ),
		);
	}

	/**
	 * Installation logic
	 *
	 * This is handled by the installer only so that a default user can be created.
	 *
	 * @return boolean
	 */
	public function install()
	{
		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{
		return true;
	}

}