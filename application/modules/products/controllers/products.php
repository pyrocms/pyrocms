<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();
		$this->load->model('products_m');
		$this->lang->load('products');
	}
	
	function index()
	{
		$products = array();
		if($this->data->products = $this->products_m->getProducts())
		{
			foreach ($this->data->products as $product)
			{
				$query = $this->db->getwhere('products_images', array('product_id'=>$product->id, 'for_display'=>'1'));
				if ($query->num_rows() == 0)
				{
					$query = $this->db->getwhere('products_images', array('product_id'=>$product->id));
				}
				$this->data->images[$product->id] = $query->row();
			}
		}		
		$this->layout->create('index', $this->data);
	}
	
	function category($category = '')
	{
		if (empty($category)) redirect('products/index');		
		$this->data->products = $this->products_m->getProducts($category);
		
		foreach ($this->data->products as $product)
		{
			$query = $this->db->getwhere('products_images', array('product_id'=>$product->id, 'for_display'=>'1'));
			if ($query->num_rows() == 0)
			{
				$query = $this->db->getwhere('products_images', array('product_id'=>$product->id));
			}
			$this->data->images[$product->id] = $query->row();
		}		
		$this->layout->create('index', $this->data);
	}
		
	function view($id = '')
	{
		if (empty($id)) redirect('products/index');
		
		$this->data->product = $this->products_m->getProduct($id);
		$this->data->images = FALSE;
		$query = $this->db->getwhere('products_images', array('product_id'=>$id));
		
		if ($query->num_rows() > 0)
		{
			$this->data->images = $query->result();
		}
		
		$this->layout->title( $this->data->product->title, lang('products_title'));
		$this->layout->add_breadcrumb(lang('products_title'), 'products');
		$this->layout->add_breadcrumb($this->data->product->title, 'products/'.$this->data->product->id);
		$this->layout->create('view', $this->data);
	}
}
?>