<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Modules
 * @category 	Sitemap
 */
class Module_Sitemap extends Module {

	public $version = '1.2';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Sitemap',
				'el' => 'Χάρτης Ιστότοπου',
				'de' => 'Sitemap',
				'nl' => 'Sitemap',
				'fr' => 'Plan du site',
				'zh' => '網站地圖',
				'it' => 'Mappa del sito',
				'ru' => 'Карта сайта',
				'ar' => 'خريطة الموقع',
				'br' => 'Mapa do Site',
				'es' => 'Mapa del Sitio',
				'fi' => 'Sivukartta',
				'lt' => 'Svetainės medis'
			),
			'description' => array(
				'en' => 'The sitemap module creates an index of all pages and an XML sitemap for search engines.',
				'el' => 'Δημιουργεί έναν κατάλογο όλων των σελίδων και έναν χάρτη σελίδων σε μορφή XML για τις μηχανές αναζήτησης.',
				'de' => 'Die Sitemap Modul erstellt einen Index aller Seiten und eine XML-Sitemap für Suchmaschinen.',
				'nl' => 'De sitemap module maakt een index van alle pagina\'s en een XML sitemap voor zoekmachines.',
				'fr' => 'Le module sitemap crée un index de toutes les pages et un plan de site XML pour les moteurs de recherche.',
				'zh' => '站點地圖模塊創建一個索引的所有網頁和XML網站地圖搜索引擎。',
				'it' => 'Il modulo mappa del sito crea un indice di tutte le pagine e una sitemap in XML per i motori di ricerca.',
				'ru' => 'Карта модуль создает индекс всех страниц и карта сайта XML для поисковых систем.',
				'ar' => 'وحدة خريطة الموقع تنشئ فهرساً لجميع الصفحات وملف XML لمحركات البحث.',
				'br' => 'O módulo de mapa do site cria um índice de todas as páginas e um sitemap XML para motores de busca.',
				'es' => 'El módulo de mapa crea un índice de todas las páginas y un mapa del sitio XML para los motores de búsqueda.',
				'fi' => 'sivukartta moduuli luo hakemisto kaikista sivuista ja XML sivukartta hakukoneille.',
				'lt' => 'struktūra modulis sukuria visų puslapių ir XML Sitemap paieškos sistemų indeksas.',
				'da' => 'Sitemapmodulet opretter et indeks over alle sider og et XML sitemap til søgemaskiner.'
			),
			'frontend' => TRUE,
			'backend' => FALSE,
			'menu' => 'content'
		);
	}

	public function install()
	{
		return TRUE;
	}

	public function uninstall()
	{
		return TRUE;
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		return <<<EOF
		
		<h4>Overview</h4>
		<p>The sitemap module automatically generates an index page and an XML file suitable for search crawlers.
		See <a href="http://sitemaps.org">sitemaps.org</a> for more information.
		</p>
		
EOF;
	}
}
/* End of file details.php */
