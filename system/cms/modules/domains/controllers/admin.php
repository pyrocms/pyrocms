<?php 

use Pyro\Module\Domains\Model\Domain;

/**
 * PyroCMS domain Admin Controller
 *
 * Provides an admin for the domain module.
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Domains\Controllers
 */
class Admin extends Admin_Controller
{
	/**
	 * Array containing the validation rules.
	 *
	 * @var array
	 */
	protected $validation_rules = array(
		'domain' => array(
			'field' => 'domain',
			'label' => 'lang:domains:domain',
			'rules' => 'trim|required|max_length[250]|callback__check_unique'
		),
		array(
			'field' => 'type',
			'label' => 'lang:domains:type',
			'rules' => 'trim|required'
		)
	);

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->load->helper('domains');
		$this->lang->load('domains');

		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
	 * List all domains
	 */
	public function index()
	{
		ci()->pdb->getQueryGrammar()->setTablePrefix('core_');
        // Create pagination links
		$domains = Domain::all();
		ci()->pdb->getQueryGrammar()->setTablePrefix(SITE_REF.'_');

		$this->template
					->set('domains',$domains)
					->build('admin/index');
	}

	/**
	 * Create a new domain
	 */
	public function add()
	{
		$domain = new Domain();

		// Got validation?
		if ($this->form_validation->run()) {

			ci()->pdb->getQueryGrammar()->setTablePrefix('core_');
			$result = Redirect::create(array(
                'domain' => $this->input->post('domain'),
                'site_id' => site_id(),
                'type' => $this->input->post('type')
            ));
            ci()->pdb->getQueryGrammar()->setTablePrefix(SITE_REF.'_');

			if ($result) {
				$this->session->set_flashdata('success', lang('domains:add_success'));
			} else {
				$this->session->set_flashdata('error', lang('domains:add_error'));
			}

			redirect('admin/domains');
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule) {
			$domain->$rule['field'] = set_value($rule['field']);
		}

		$this->template
			->set('domain', $domain)
			->build('admin/form');
	}

	/**
	 * Edit an existing domain
	 *
	 * @param int $id The ID of the domain
	 *
	 * @return void
	 */
	public function edit($id = 0)
	{
		// Got ID?
		$id or redirect('admin/domains');

		ci()->pdb->getQueryGrammar()->setTablePrefix('core_');
		// Get the domain
		if ( ! $domain = Domain::find($id)) {
			redirec('admin/domains');
		}

		$this->form_validation->set_rules(array_merge($this->validation_rules, array(
            'domain' => array(
				'field' => 'domain',
				'label' => 'lang:domains:domain',
				'rules' => 'trim|required|max_length[250]|callback__check_unique['.$id.']'
			)
        )));
		
		if ($this->form_validation->run()) {
			$domain->domain = $this->input->post('domain');
            $domain->site_id = site_id();
            $domain->type = $this->input->post('type');

			if ($domain->save()) {
				$this->session->set_flashdata('success', $this->lang->line('domains:edit_success'));
			} else {
				$this->session->set_flashdata('error', $this->lang->line('domains:edit_error'));
			}
			
			redirect('admin/domains');
		}

		ci()->pdb->getQueryGrammar()->setTablePrefix(SITE_REF.'_');

		$this->template
			->set('domain', $domain)
			->build('admin/form');
	}

	/**
	 * Delete an existing domain
	 *
	 * @param int $id The ID of the domain
	 *
	 * @return void
	 */
	public function delete($id = 0)
	{
		$id_array = ( ! empty($id)) ? array($id) : $this->input->post('action_to');

		ci()->pdb->getQueryGrammar()->setTablePrefix('core_');
		// Delete multiple
		if( ! empty($id_array)) {
			$deleted = 0;
			$to_delete = 0;
			foreach ($id_array as $id) {
				if (Domain::find($id)->delete()) {
					$deleted++;
				} else {
					$this->session->set_flashdata('error', sprintf($this->lang->line('domains:mass_delete_error'), $id));
				}
				$to_delete++;
			}

			if ($deleted > 0) {
				$this->session->set_flashdata('success', sprintf($this->lang->line('domains:mass_delete_success'), $deleted, $to_delete));
			}

		} else {
			$this->session->set_flashdata('error', $this->lang->line('domains:no_select_error'));
		}

		ci()->pdb->getQueryGrammar()->setTablePrefix(SITE_REF.'_');
		
		redirect('admin/domains');
	}

	/**
	 * Callback method for validating the domain's name
	 *
	 * @param string $domain
	 * @return bool
	 */
	public function _check_unique($domain, $id = null)
	{
		ci()->pdb->getQueryGrammar()->setTablePrefix('core_');
		$domain = Domain::findByDomainAndId($domain, $id);
		ci()->pdb->getQueryGrammar()->setTablePrefix('default_');
		if ($domain->isEmpty()) {
			return true;
		} else {
			$this->form_validation->set_message('_check_unique', sprintf(lang('domains:request_conflict_error'), $domain));
			return false;
		}
	}
}