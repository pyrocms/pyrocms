<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Sitemap Module
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Sitemap
 */
class Module_Sitemap extends Module {

	public $version = '1.3.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Sitemap',
				'ar' => 'خريطة الموقع',
				'br' => 'Mapa do Site',
				'pt' => 'Mapa do Site',
				'de' => 'Sitemap',
				'el' => 'Χάρτης Ιστότοπου',
				'es' => 'Mapa del Sitio',
                            'fa' => 'نقشه سایت',
				'fi' => 'Sivukartta',
				'fr' => 'Plan du site',
				'id' => 'Peta Situs',
				'it' => 'Mappa del sito',
				'lt' => 'Svetainės medis',
				'nl' => 'Sitemap',
				'ru' => 'Карта сайта',
				'tw' => '網站地圖',
				'cn' => '网站地图',
				'th' => 'ไซต์แมพ',
				'hu' => 'Oldaltérkép',
				'se' => 'Sajtkarta',
			),
			'description' => array(
				'en' => 'The sitemap module creates an index of all pages and an XML sitemap for search engines.',
				'ar' => 'وحدة خريطة الموقع تنشئ فهرساً لجميع الصفحات وملف XML لمحركات البحث.',
				'br' => 'O módulo de mapa do site cria um índice de todas as páginas e um sitemap XML para motores de busca.',
				'pt' => 'O módulo do mapa do site cria um índice de todas as páginas e um sitemap XML para motores de busca.',
				'da' => 'Sitemapmodulet opretter et indeks over alle sider og et XML sitemap til søgemaskiner.',
				'de' => 'Die Sitemap Modul erstellt einen Index aller Seiten und eine XML-Sitemap für Suchmaschinen.',
				'el' => 'Δημιουργεί έναν κατάλογο όλων των σελίδων και έναν χάρτη σελίδων σε μορφή XML για τις μηχανές αναζήτησης.',
				'es' => 'El módulo de mapa crea un índice de todas las páginas y un mapa del sitio XML para los motores de búsqueda.',
                            'fa' => 'ماژول نقشه سایت یک لیست از همه ی صفحه ها به فرمت فایل XML برای موتور های جستجو می سازد',
				'fi' => 'sivukartta moduuli luo hakemisto kaikista sivuista ja XML sivukartta hakukoneille.',
				'fr' => 'Le module sitemap crée un index de toutes les pages et un plan de site XML pour les moteurs de recherche.',
				'id' => 'Modul peta situs ini membuat indeks dari setiap halaman dan sebuah format XML untuk mempermudah mesin pencari.',
				'it' => 'Il modulo mappa del sito crea un indice di tutte le pagine e una sitemap in XML per i motori di ricerca.',
				'lt' => 'struktūra modulis sukuria visų puslapių ir XML Sitemap paieškos sistemų indeksas.',
				'nl' => 'De sitemap module maakt een index van alle pagina\'s en een XML sitemap voor zoekmachines.',
				'ru' => 'Карта модуль создает индекс всех страниц и карта сайта XML для поисковых систем.',
				'tw' => '站點地圖模塊創建一個索引的所有網頁和XML網站地圖搜索引擎。',
				'cn' => '站点地图模块创建一个索引的所有网页和XML网站地图搜索引擎。',
				'th' => 'โมดูลไซต์แมพสามารถสร้างดัชนีของหน้าเว็บทั้งหมดสำหรับเครื่องมือค้นหา.',
				'hu' => 'Ez a modul indexeli az összes oldalt és egy XML oldaltéképet generál a keresőmotoroknak.',
				'se' => 'Sajtkarta, modulen skapar ett index av alla sidor och en XML-sitemap för sökmotorer.'
			),
			'frontend' => true,
			'backend' => false,
			'menu' => 'content'
		);
	}

	public function install()
	{
		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}