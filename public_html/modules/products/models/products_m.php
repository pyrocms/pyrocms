<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products_m extends Model {

    function __construct() {
        parent::Model();
    }

    function newProduct($input = array(), $image = array()) {
        $this->load->helper('date');
        
        $title = $input['title'];
        $description = $input['description'];
        $price = $input['price'];
        $category_slug = $input['category_slug'];
        $supplier_slug = $input['supplier_slug'];
        
        $this->db->insert('products', array('title'=>$title,
                                            'description'=>$description,
                                            'price'=>$price,
                                            'category_slug'=>$category_slug,
                                            'supplier_slug'=>$supplier_slug,
                                            'updated_on'=>now()));
                                            
		$product_id = $this->db->insert_id();                                            
        $this->db->insert('products_images', array('filename'=>$image['file_name'], 'product_id'=>$product_id, 'for_display' => 1));
        $product_img_id = $this->db->insert_id();
        return $product_img_id;
    }
    
    function newPhoto($input = array(), $image = array(), $product_id) {
        $this->db->insert('products_images', array('filename'=>$image['file_name'], 'product_id'=>$product_id));
        $product_img_id = $this->db->insert_id();
        return $product_img_id;
    }

    function getProducts($params = array()) {
        $this->db->select('products.id, products.title, products.price, products.description, products.supplier_slug, products.updated_on, products.frontpage, suppliers.title AS supplier_title');
        $this->db->join('suppliers', 'products.supplier_slug = suppliers.slug', 'left');
        
       	// Limit the results based on 1 number or 2 (2nd is offset)
       	if(isset($params['limit']) && is_int($params['limit'])) $this->db->limit($params['limit']);
    	elseif(isset($params['limit']) && is_array($params['limit'])) $this->db->limit($params['limit'][0], $params['limit'][1]);
        
    	if(!empty($params['category'])) $this->db->where('products.category_slug', $params['category']);
    	
        $query = $this->db->get('products');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    
    function getProduct($id) {
        $this->db->select('products.*, products_images.filename AS image, suppliers.title AS supplier_title, categories.title AS category_title');
        $this->db->join('products_images', 'products.id = products_images.product_id', 'left');
        $this->db->join('suppliers', 'products.supplier_slug = suppliers.slug', 'left');
        $this->db->join('categories', 'products.category_slug = categories.slug', 'left');
        $query = $this->db->getwhere('products', array('products.id'=>$id));
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }
  
    function countProducts($params = array())
    {
		if(!empty($category)) $this->db->where('category_slug', $category);
    	
		return $this->db->count_all_results('products');
    }
    
    function updateProduct($id = '', $input = array()) {
        $this->load->helper('date');
        
        $title = $input['title'];
        $price = $input['price'];
        $category_slug = $input['category_slug'];
        $supplier_slug = $input['supplier_slug'];
        $description = $input['description'];
        
        $this->db->update('products', array('title'=>$title, 
        									'price'=>$price, 
                                            'category_slug'=>$category_slug, 
                                            'supplier_slug'=>$supplier_slug,
                                            'description'=>$description,
                                            'updated_on'=>now()), array('id'=>$id));

    }
    
    function makedefault($id){
    	$this->db->select('product_id');
    	$query = $this->db->getwhere('products_images', array('image_id'=>$id));
     	$product_id = $query->row();
     	$this->db->update('products_images', array('for_display'=>'0'), array('product_id'=>$product_id->product_id));
    	$this->db->update('products_images', array('for_display'=>'1'), array('image_id'=>$id));
    }
    
    function deleteProduct($id) {
        $this->db->delete('products', array('id'=>$id));
    }
    
    function deleteProductPhoto($id) {
        $this->db->delete('products_images', array('image_id'=>$id));
    }
    
    function getImage($id) {
        $this->db->select('filename');
        $query = $this->db->getwhere('products_images', array('image_id'=>$id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->filename;
        } else {
            return FALSE;
        }
    }
    
    function getAllImages($id) {
        $this->db->select('filename,image_id,product_id,for_display');
        $query = $this->db->getwhere('products_images', array('product_id'=>$id));
        if ($query->num_rows() > 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
    }

}

?>