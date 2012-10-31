<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_User_agent extends CI_User_agent {


	// Tablet device RegEx's
	protected $_tablet_devices = array(
		'BlackBerryTablet'  => 'PlayBook|RIM Tablet',
		'iPad'              => 'iPad|iPad.*Mobile',
		'NexusTablet'       => '^.*Android.*Nexus(?:(?!Mobile).)*$',
		// @reference: http://www.labnol.org/software/kindle-user-agent-string/20378/
		'Kindle'            => 'Kindle|Silk.*Accelerated',
		'SamsungTablet'     => 'SAMSUNG.*Tablet|Galaxy.*Tab|GT-P1000|GT-P1010|GT-P6210|GT-P6800|GT-P6810|GT-P7100|GT-P7300|GT-P7310|GT-P7500|GT-P7510|SCH-I800|SCH-I815|SCH-I905|SGH-I957|SGH-I987|SGH-T849|SGH-T859|SGH-T869|SPH-P100|GT-P1000|GT-P3100|GT-P3110|GT-P5100|GT-P5110|GT-P5113|GT-P6200|GT-P7300|GT-P7320|GT-P7500|GT-P7510|GT-P7511',
		'HTCtablet'         => 'HTC Flyer|HTC Jetstream|HTC-P715a|HTC EVO View 4G|PG41200',
		'MotorolaTablet'    => 'xoom|sholest|MZ615|MZ605|MZ505|MZ601|MZ602|MZ603|MZ604|MZ606|MZ607|MZ608|MZ609|MZ615|MZ616|MZ617',
		'AsusTablet'        => 'Transformer|TF101',
		'NookTablet'        => 'Android.*Nook|NookColor|nook browser|BNTV250A|LogicPD Zoom2',
		'AcerTablet'        => 'Android.*\b(A100|A101|A200|A500|A501|A510|W500|W500P|W501|W501P)\b',
		'YarvikTablet'      => 'Android.*(TAB210|TAB211|TAB224|TAB250|TAB260|TAB264|TAB310|TAB360|TAB364|TAB410|TAB411|TAB420|TAB424|TAB450|TAB460|TAB461|TAB464|TAB465|TAB467|TAB468)',
		'MedionTablet'      => 'Android.*\bOYO\b|LIFE.*(P9212|P9514|P9516|S9512)|LIFETAB',
		'ArnovaTablet'      => 'AN10G2|AN7bG3|AN7fG3|AN8G3|AN8cG3|AN7G3|AN9G3|AN7dG3|AN7dG3ST|AN7dG3ChildPad|AN10bG3|AN10bG3DT',
		// @reference: http://wiki.archosfans.com/index.php?title=Main_Page
		'ArchosTablet'      => 'Android.*ARCHOS|101G9|80G9',
		// @reference: http://en.wikipedia.org/wiki/NOVO7
		'AinolTablet'       => 'NOVO7|Novo7Aurora|Novo7Basic|NOVO7PALADIN',
		// @todo: inspect http://esupport.sony.com/US/p/select-system.pl?DIRECTOR=DRIVER
		'SonyTablet'        => 'Sony Tablet|Sony Tablet S',
		'GenericTablet'     => 'Tablet(?!.*PC)|ViewPad7|LG-V909|MID7015|BNTV250A|LogicPD Zoom2|\bA7EB\b|CatNova8|A1_07|CT704|CT1002|\bM721\b|hp-tablet',
		'Toshiba'           => 'AT100',
		'Windows_rt'        => 'MSIE 10.0; Windows NT 6.2; ARM;',
		// @ref: db + http://www.cube-tablet.com/buy-products.html
		'CubeTablet'        => 'Android.*(K8GT|U9GT|U10GT|U16GT|U17GT|U18GT|U19GT|U20GT|U23GT|U30GT)',
		// @ref: http://www.cobyusa.com/?p=pcat&pcat_id=3001
		'CobyTablet'        => 'MID1042|MID1045|MID1125|MID1126|MID7012|MID7014|MID7034|MID7035|MID7036|MID7042|MID7048|MID7127|MID8042|MID8048|MID8127|MID9042|MID9740|MID9742|MID7022|MID7010',
		'GenericTablet'     => 'Android.*\b97D\b|Tablet(?!.*PC)|ViewPad7|LG-V909|MID7015|BNTV250A|LogicPD Zoom2|\bA7EB\b|CatNova8|A1_07|CT704|CT1002|\bM721\b|hp-tablet',
	);

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Is Tablet
	 * Check if the Useragent is a tablet
	 *
	 * @access	public
	 * @param	string	$ua	Useragent string
	 * @return	bool
	 */
	public function is_tablet($ua = null) {

		if (empty($ua)) $ua = $this->agent_string();

		foreach($this->_tablet_devices as $regex)
		{
	        if (preg_match('/'.$regex.'/is', $ua))
			{
					return true;
			}
		}
		return false;
	}

}

/* End of file MY_User_agent.php */
/* Location: ./system/cms/libraries/MY_User_agent.php */
