<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('products_m');
		$this->load->module_model('categories', 'categories_m');
		$this->lang->load('products');
	}
	
	// Admin: List all of the Products
	function index()
	{	
		// Create pagination links
		$total_rows = $this->products_m->countProducts();
		$this->data->pagination = create_pagination('admin/products/index', $total_rows);
		
		// Using this data, get the relevant results
		$this->data->products = $this->products_m->getProducts(array('limit' => $this->data->pagination['limit']));		
		$this->layout->create('admin/index', $this->data);
	}
	
	// Admin: Create a new Product
	function create()
	{
		$this->load->library('validation');
		$rules['title'] = 'trim|required|max_length[40]';
		$rules['price'] = 'trim|is_numeric';
		$rules['description'] = 'trim|required';
		$rules['category_slug'] = 'required';
		$rules['supplier_slug'] ='required';
		$this->validation->set_rules($rules);
		$fields['category_slug'] = 'Category';
		$fields['supplier_slug'] = 'Supplier';
		$fields['userfile'] = 'Item Photo';
		$this->validation->set_fields($fields);
		
		if ($this->validation->run())
		{
			$upload_cfg['upload_path'] = APPPATH.'assets/img/products';
			$upload_cfg['encrypt_name'] = TRUE;
			$upload_cfg['allowed_types'] = 'gif|jpg|png';
			$this->load->library('upload', $upload_cfg);
			
			if ($this->upload->do_upload())
			{
				$image = $this->upload->data();
				$this->_create_resize($image['file_name'], $this->config->item('product_width'), $this->config->item('product_height'));				
				$product_id = $this->products_m->newProduct($_POST, $image);
				
				$this->session->set_flashdata('success', $this->lang->line('products_add_success'));
				$this->_create_thumbnail($image['file_name']);
								
				redirect('admin/products/crop/' . $product_id);
			}
			show_error($this->upload->display_errors());
		}
		
		foreach(array_keys($rules) as $field)
		{
			$this->data->product->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
		}
		
		$this->load->module_model('suppliers', 'suppliers_m');
		$this->data->categories = $this->categories_m->getCategories();
		$this->data->suppliers = $this->suppliers_m->getSuppliers();
		
		// Load WYSIWYG editor
		$this->layout->extra_head( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->layout->create('admin/form', $this->data);
	}
	
	// Admin: Upload and add new photos to database
	function addphoto()
	{
		$upload_cfg['upload_path'] = APPPATH.'assets/img/products';
		$upload_cfg['allowed_types'] = 'gif|jpg|png';
		$upload_cfg['encrypt_name'] = TRUE;
		$this->load->library('upload', $upload_cfg);
		
		if (($this->input->post('btnSave')) && ($this->upload->do_upload()))
		{
			$product_id = $this->uri->segment(4);
			$image = $this->upload->data();
			$this->_create_resize($image['file_name'], $this->config->item('product_width'), $this->config->item('product_height'));
			$product_img_id = $this->products_m->newPhoto($_POST, $image, $product_id);
			$this->session->set_flashdata('success', $this->lang->line('products_add_photo_success'));
			$this->_create_thumbnail($image['file_name']);
			redirect('admin/products/crop/' . $product_img_id);
			return;
		}
		else
		{
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('admin/products/index');
		}
	}
	
	// Admin: Edit a Product
	function edit($id = 0)
	{	
		if (empty($id)) redirect('admin/products/index');
		
		$this->data->product = $this->products_m->getProduct($id);
		if (!$this->data->product) redirect('admin/products/create');
		
		$this->load->library('validation');
		$rules['price'] = 'trim|is_numeric|required';
		$rules['description'] = 'trim|required';
		$rules['category_slug'] = 'required';
		$rules['supplier_slug'] = 'required';
		
		$this->validation->set_rules($rules);
		$fields['category_slug'] = 'Category';
		$fields['supplier_slug'] = 'Supplier';
		
		$this->validation->set_fields($fields);
		
		foreach(array_keys($rules) as $field)
		{
			if(isset($_POST[$field])) $this->data->product->$field = $this->validation->$field;
		}
			
		if ($this->validation->run())
		{
			$this->products_m->updateProduct($id, $_POST);
			$this->session->set_flashdata('success', sprintf($this->lang->line('products_edit_success'), $this->input->post('title')));			
			redirect('admin/products/index');
		}
		
		$this->load->module_model('suppliers', 'suppliers_m');
		$this->data->categories = $this->categories_m->getCategories();
		$this->data->suppliers = $this->suppliers_m->getSuppliers();
		
		// Load WYSIWYG editor
		$this->layout->extra_head( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->layout->create('admin/form', $this->data);
	}
	
	// Admin: Make Product Photo its default Photo to display.
	function makedefault()
	{
		$this->products_m->makedefault($this->uri->segment(4));
		redirect('admin/products/index');
	}
	
	// Admin: Delete Product Photos
	function deletephoto()
	{
		if (!$this->input->post('btnDelete')) redirect('admin/products/index');
		
		foreach ($this->input->post('delete') as $photos => $value)
		{
			$this->products_m->deleteProductPhoto($photos);
		}		
		redirect('admin/products/index');
	}
	
	// Admin: Delete a Product
	function delete($id = 0)
	{
		$img_folder = APPPATH.'assets/img/products/';
		$img_prefixes = array('_home', '_thumb');		
		$this->load->library('image_lib');
		
		// An ID was passed in the URL, lets delete that
		$id_array = ($id > 0) ? array($id) : $this->input->post('action_to');
		
		if(empty($id_array))
		{
			$this->session->set_flashdata('error', $this->lang->line('products_delete_error'));
			redirect('admin/products/index');
		}
		
		$deleted = 0;
		foreach ($id_array as $product)
		{
			if($product_photos = $this->products_m->getAllImages( $product ))
			{
				// We need to delete the image + _home + _thumb images
				foreach($product_photos AS $image_data)
				{
					$img_info = $this->image_lib->explode_name( $image_data->filename );
					// Delete original img first
					
					$this->_delete_file( $img_folder , $img_info['name'].$img_info['ext'] );
					/*if( !$this->_delete_file( $img_folder , $img_info['name'].$img_info['ext'] ) )
					{
					// end the delete process, cant delete normally.
					redirect('admin/products/index');
					}*/
					
					// Now delete images whit prefixes
					foreach($img_prefixes as $prefix) 
					{
						$this->_delete_file( $img_folder , $img_info['name'].$prefix.$img_info['ext'] );
						/*						if( !$this->_delete_file( $img_folder , $img_info['name'].$prefix.$img_info['ext'] ) )
						{
						// end the delete process, cant delete normally.
						redirect('admin/products/index');
						}
						*/
					}
					// Images deleted, delete record from db
					$this->products_m->deleteProductPhoto( $image_data->image_id );
				}
			}
			
			// Now delete the products 
			$this->products_m->deleteProduct($product);
			$deleted++;
		}		
		
		if( $deleted > 0 )
		{
			$this->session->set_flashdata('success', sprintf($this->lang->line('products_delete_success'), $deleted, count($id_array)));
		}		
		redirect('admin/products/index');
	}
	
	function _delete_file($folder = FALSE, $file = FALSE)
	{
		if(!$folder || !$file) 
		{
			$this->session->set_flashdata('error', $this->lang->line('products_folder_file_error'));
		}
		else
		{
			if(@file_exists($folder.$file))
			{
				// Try and delete the file. If we cant remove it, meh, keep the file
				@unlink($folder.$file);
			}
		}
	}
	
	// Admin: Crop for Home Page
	function crop($id = 0)
	{	
		if (empty($id)) redirect('admin/products/index');
		
		$this->load->library('validation');
		$rules['x1'] = 'trim|required|numeric';
		$rules['y1'] = 'trim|required|numeric';
		$rules['x2'] = 'trim|required|numeric';
		$rules['y2'] = 'trim|required|numeric';
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		$this->data->image = $this->products_m->getImage($id);
		if (!$this->data->image) redirect('admin/products/index');
		
		$this->load->library('image_lib');
		$this->load->config('image_settings');
		$this->data->image_data = $this->image_lib->get_image_properties(APPPATH.'assets/img/products/'.$this->data->image, TRUE);
		
		if ($this->validation->run())
		{
			// 1. Crope the image
			$home_img = $this->_create_crop($this->data->image, $this->input->post('x1'), $this->input->post('y1'), $this->input->post('x2'), $this->input->post('y2'));
			// 2. Resize the image
			$this->_create_resize($home_img, $this->settings->item('product_width'), $this->settings->item('product_height') );
			redirect('admin/products/index');
			return;
		}
		else
		{
			$this->layout->create('admin/crop', $this->data);
			return;
		}
	}
	
	// Admin: Add new photos for products
	function photo($id = 0)
	{
		if (empty($id)) redirect('admin/products/index');
		$this->data->photos = $this->products_m->getAllImages($id);
		$this->data->product = $this->products_m->getProduct($id);
		$this->layout->create('admin/photo', $this->data);
	}
	
	// Admin: Toggle Frontpage Setting
	function frontpage($id = 0)
	{
		if (empty($id)) redirect('admin/products/index');
		
		$this->db->select('frontpage');
		$query = $this->db->getwhere('products', array('id'=>$id));
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			if ($row->frontpage == 'Y')
			{
				$new_setting = 'N';
			}
			else
			{ 
				$new_setting = 'Y';
			}
			$this->db->update('products', array('frontpage'=>$new_setting), array('id'=>$id));
		}
		redirect('admin/products/index');
		return;
	}
	
	// Private: Create the Crop for Home Page
	function _create_crop($image = '', $x = '', $y = '', $x2 = '', $y2 = '')
	{
		$new_img = substr($image, 0, -4) . '_home' . substr($image, -4);
		unset($img_cfg);
		$img_cfg['source_image'] = APPPATH.'assets/img/products/' . $image;
		$img_cfg['new_image'] = APPPATH.'assets/img/products/' . $new_img;
		$img_cfg['maintain_ratio'] = FALSE;
		$img_cfg['x_axis'] = $x;
		$img_cfg['y_axis'] = $y;
		$img_cfg['width'] = $x2 - $x;
		$img_cfg['height'] = $y2 - $y;
		$this->load->library('image_lib');
		$this->image_lib->initialize($img_cfg);
		$this->image_lib->crop();
		// return name of the croped image
		return $new_img;
	}
	
	// Private: Create resize of Cropped Image to ensure it's a certain size
	function _create_resize($homeimg = '', $x, $y)
	{
		unset($img_cfg);
		$img_cfg['source_image'] = APPPATH.'assets/img/products/' . $homeimg;
		$img_cfg['new_image'] = APPPATH.'assets/img/products/' . $homeimg;
		$img_cfg['maintain_ratio'] = true;
		$img_cfg['width'] = $x;
		$img_cfg['height'] = $y;
		$this->load->library('image_lib');
		$this->image_lib->initialize($img_cfg);
		$this->image_lib->resize();
	}
	
	// Private: Create a Thumbnail of Uploaded Image
	function _create_thumbnail($thumbimage = '',$width=350, $height=275)
	{
		unset($img_cfg_thumb);
		$img_cfg_thumb['source_image'] = APPPATH.'assets/img/products/' . $thumbimage;
		$img_cfg_thumb['create_thumb'] = TRUE;
		$img_cfg_thumb['thumb_marker'] = '_thumb'; 
		$img_cfg_thumb['maintain_ratio'] = TRUE;
		$img_cfg_thumb['width'] = $width;
		$img_cfg_thumb['height'] = $height;
		$this->load->library('image_lib');
		$this->image_lib->initialize($img_cfg_thumb); 
		$this->image_lib->resize();
	}
}
?>